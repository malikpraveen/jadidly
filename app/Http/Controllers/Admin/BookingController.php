<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Branch;
use App\Models\Booking;
use App\Models\BookingService;
use App\Models\Service;
use App\Models\Categories;
use App\Models\UserCar;
use App\Models\CancelReason;
use App\Models\CancellationRequest;
use Auth;
use DB;
use Mail;
use Response;
use Session;
use App\Http\Requests\UsersRequest as StoreRequest;
use App\Http\Requests\UsersRequest as UpdateRequest;
use App\Http\Controllers\CrudOverrideController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class BookingController extends Controller {

    private $URI_PLACEHOLDER;
    private $jsondata;
    private $redirect;
    protected $message;
    protected $status;
    private $prefix;

    public function __construct() {
        // dd('aaaa');
        $this->jsondata = [];
        $this->message = false;
        $this->redirect = false;
        $this->status = false;
        $this->prefix = \DB::getTablePrefix();
        $this->URI_PLACEHOLDER = \Config::get('constants.URI_PLACEHOLDER');
        $this->middleware(function ($request, $next) {
            $details = $this->admin_priviledge(session()->get('admin_logged_in')['id']);
            session()->put('admin_logged_in.permissions', $details);
            if (!in_array(5, $details)) {
                return redirect('admin/unauthenticated');
            }
            return $next($request);
        });
    }

    public function index() {
        $bookingList = [];
        $bookings = Booking::where('status', '<>', '0')->orderBy('id', 'DESC')->get();
        if ($bookings) {
            foreach ($bookings as $booking) {
                $booking->username = "";
                $booking->mobile = "";
                $booking->email = "";
                $userdetail = User::where('id', $booking->user_id)->first();
                if ($userdetail) {
                    $booking->username = $userdetail->name;
                    $booking->mobile = '+' . $userdetail->country_code . ' ' . $userdetail->mobile_number;
                    $booking->email = $userdetail->email;
                }
                array_push($bookingList, $booking);
            }
        }
        $data['bookings'] = $bookingList;
        return view('admin.bookings.booking_list')->with($data);
    }

    public function request_list() {
        $bookingList = [];
        $bookings = Booking::where('status', '0')->orderBy('id', 'DESC')->get();
        if ($bookings) {
            foreach ($bookings as $booking) {
                $booking->username = "";
                $booking->mobile = "";
                $booking->email = "";
                $userdetail = User::where('id', $booking->user_id)->first();
                if ($userdetail) {
                    $booking->username = $userdetail->name;
                    $booking->mobile = '+' . $userdetail->country_code . ' ' . $userdetail->mobile_number;
                    $booking->email = $userdetail->email;
                }
                array_push($bookingList, $booking);
            }
        }
        $data['bookings'] = $bookingList;
        return view('admin.bookings.booking_request_list')->with($data);
    }

    public function request_detail($id = null) {
        $id = base64_decode($id);
        $cancel_reason = CancelReason::where('status', 'active')->where('type', 'admin')->get();
//        echo '<pre>';print_r($cancel_reason);die;
        $data['cancel_reason'] = $cancel_reason;
        $booking = Booking::where('id', $id)->where('status', '0')->first();
        if ($booking) {
            $booking->username = "";
            $booking->mobile = "";
            $booking->email = "";
            $userdetail = User::where('id', $booking->user_id)->first();
            if ($userdetail) {
                $booking->username = $userdetail->name;
                $booking->mobile = '+' . $userdetail->country_code . ' ' . $userdetail->mobile_number;
                $booking->email = $userdetail->email;
            }
            $servicesList = [];
            $services = BookingService::where('booking_id', $id)->get();
            if ($services) {
                foreach ($services as $service) {
                    $service->name = "";
                    $service->image = "";
                    $service->description = "";
                    $service->main_category = "";
                    $serviceDetail = Service::with('service_category', 'service_images')->where('id', $service->service_id)->first();
                    if ($serviceDetail) {
                        $service->name = $serviceDetail->name;
                        $service->image = $serviceDetail->service_images[0]['image'];
                        $service->description = $serviceDetail->description;
                        $service->main_category = $serviceDetail->service_category->name;
                    }
                    array_push($servicesList, $service);
                }
            }
            $booking['services'] = $servicesList;
            $getCarDetail = UserCar::with('images')
                    ->where(['user_cars.id' => $booking->user_car_id])
                    ->select('user_cars.*', 'brands.brand_name', 'brands.image as brand_image', 'brand_cars.car_name', 'model_names.model_name')
                    ->join('brands', 'brand_id', '=', 'brands.id')
                    ->join('brand_cars', 'car_id', '=', 'brand_cars.id')
                    ->join('model_names', 'model_id', '=', 'model_names.id')
                    ->first();
            $booking['cardetails'] = $getCarDetail;
            if ($booking->branch_id) {
                $branch = Branch::where('id', $booking->branch_id)->first();
                if ($branch) {
                    $booking->branch = $branch->branch_name . ' (' . $branch->location . ')';
                } else {
                    $booking->branch = "N/A";
                }
            }
            $data['booking'] = $booking;
            return view('admin.bookings.booking_request_detail')->with($data);
        } else {
            return redirect()->back()->with('error', 'Booking Request not found');
        }
    }

    public function booking_action(Request $request) {
        $id = $request->input('id');
        $update['status'] = (string) $request->input('status');
        if ($request->input('reason')) {
            if (CancelReason::where('id', $request->input('reason'))->first()) {
                $update['cancel_reason'] = $request->input('reason');
            } else {
                $create = CancelReason::create([
                            'reason' => $request->input('reason'),
                            'reason_ar' => $request->input('reason'),
                            'type' => 'admin'
                ]);
                if ($create) {
                    $update['cancel_reason'] = $create->id;
                }
            }
        }
        $change_status = Booking::where('id', $id)->update($update);

        if ($change_status) {
            return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Booking Status updated successfully']);
        } else {
            return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
        }
    }

    public function booking_details($id = null) {
        $id = base64_decode($id);
        $booking = Booking::where('id', $id)->first();
        
        if ($booking) {
            $booking->username = "";
            $booking->mobile = "";
            $booking->email = "";
            $userdetail = User::where('id', $booking->user_id)->first();
           
            if ($userdetail) {
                $booking->username = $userdetail->name;
                $booking->mobile = '+' . $userdetail->country_code . ' ' . $userdetail->mobile_number;
                $booking->email = $userdetail->email;
            }
            $servicesList = [];
            $services = BookingService::where('booking_id', $id)->get();
            if ($services) {
                foreach ($services as $service) {
                    $service->name = "";
                    $service->image = "";
                    $service->description = "";
                    $service->main_category = "";
                    $serviceDetail = Service::with('service_category', 'service_images')->where('id', $service->service_id)->first();
                    if ($serviceDetail) {
                        $service->name = $serviceDetail->name;
                        $service->image = $serviceDetail->service_images[0]['image'];
                        $service->description = $serviceDetail->description;
                        $service->main_category = $serviceDetail->service_category->name;
                    }
                    array_push($servicesList, $service);
                }
            }
            $booking['services'] = $servicesList;
            $getCarDetail = UserCar::with('images')
                    ->where(['user_cars.id' => $booking->user_car_id])
                    ->select('user_cars.*', 'brands.brand_name', 'brands.image as brand_image', 'brand_cars.car_name', 'model_names.model_name')
                    ->join('brands', 'brand_id', '=', 'brands.id')
                    ->join('brand_cars', 'car_id', '=', 'brand_cars.id')
                    ->join('model_names', 'model_id', '=', 'model_names.id')
                    ->first();
            $booking['cardetails'] = $getCarDetail;
            if ($booking->cancel_reason) {
                $reason = CancelReason::where('id', $booking->cancel_reason)->first();
                if ($reason) {
                    $booking->cancel_reason = $reason->reason;
                } else {
                    $booking->cancel_reason = "N/A";
                }
            }
            if ($booking->branch_id) {
                $branch = Branch::where('id', $booking->branch_id)->first();
                if ($branch) {
                    $booking->branch = $branch->branch_name;
                } else {
                    $booking->branch = "N/A";
                }
            }
//             echo '<pre>';print_r($booking);die;
            $data['booking'] = $booking;
            return view('admin.bookings.booking_detail')->with($data);
        } else {
            return redirect()->back()->with('error', 'Booking not found');
        }
    }

    public function cancellation_request() {
        $bookingList = [];
        $bookings = CancellationRequest::orderBy('id', 'DESC')->get();
        if ($bookings) {
            foreach ($bookings as $c_request) {
                $booking = Booking::where('id', $c_request->booking_id)->first();
                $booking->id = $c_request->id;
                $booking->booking_id = $c_request->booking_id;
                $booking->username = "";
                $booking->mobile = "";
                $booking->email = "";
                $userdetail = User::where('id', $booking->user_id)->first();
                if ($userdetail) {
                    $booking->username = $userdetail->name;
                    $booking->mobile = '+' . $userdetail->country_code . ' ' . $userdetail->mobile_number;
                    $booking->email = $userdetail->email;
                }
                $reason = CancelReason::where('id', $c_request->reason_id)->first();
                if ($reason) {
                    $booking->reason = $reason->reason;
                } else {
                    $booking->reason = "-";
                }
                $booking->request_status = $c_request->status;
                array_push($bookingList, $booking);
            }
        }
//        echo '<pre>';print_r($bookingList);die;
        $data['bookings'] = $bookingList;
        return view('admin.bookings.cancel_request_list')->with($data);
    }

    public function request_action(Request $request) {
        $id = $request->input('id');
        $bookings = CancellationRequest::where('id', $id)->first();
        $update = CancellationRequest::where('id', $id)->update(['status' => $request->input('status')]);
        if ($request->input('status') == 1) {
            $updateArr['status'] = '4';
            $updateArr['cancel_reason'] = $bookings->reason_id;
            $change_status = Booking::where('id', $bookings->booking_id)->update($updateArr);
        }
        if ($update) {
            return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Cancellation Request Status updated successfully']);
        } else {
            return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
        }
    }

}

?>