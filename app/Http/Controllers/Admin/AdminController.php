<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\OTP;
use App\Models\ContactUs;
use App\Models\Content;
use App\Models\Offer;
use App\Models\Branch;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Permission;
use App\Models\BookingService;
use App\Models\CancelReason;
use App\Models\ContactUsImage;
use App\Models\ContactUsSubject;
use App\Models\AdditionalCharge;

use Auth;
use DB;
use Mail;
use Response;
use Session;
use Validator;
use App\Http\Requests\UsersRequest as StoreRequest;
use App\Http\Requests\UsersRequest as UpdateRequest;
use App\Http\Controllers\CrudOverrideController;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\employees;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class AdminController extends Controller {

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
            if (isset(session()->get('admin_logged_in')['id'])) {
                $details = $this->admin_priviledge(session()->get('admin_logged_in')['id']);
                session()->put('admin_logged_in.permissions', $details);
            }
            return $next($request);
        });
    }

    public function login(Request $request) {
        Auth::guard('admin')->check();
        if (\Auth::guard('admin')->check()) {
            return redirect()->intended('admin/home');
        }

        $data['title'] = 'Admin Login';
        return view('admin.login')->with($data);
    }
    

    public function getLogout() {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }

    public function error() {
        return view('error.error');
    }

    public function forgotPassword() {
        return view('admin.forgot');
    }

    public function forget(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'email' => 'required|email',
                        ], [
                    'email.required' => 'Please enter email address.',
                    'email.email' => 'Please enter valid email address.',
        ]);

        $validator->after(function ($validator) use (&$user, $request) {
            $user = User::where('email', $request->email)->where('type', 'admin')->first();

            if (empty($user)) {
                $validator->errors()->add('email', 'Your Account does not exist');
            } else {
                if ($user->status == 'inactive') {
                    $validator->errors()->add('email', 'Your Account is not active');
                }
                if ($user->status == 'trashed') {
                    $validator->errors()->add('email', 'Your Account is rejected by admin');
                }
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $user = User::where('email', $request->email)->where('type', 'admin')->where('status', 'active')->first();
            $otpUser['user_id'] = $user['id'];
            $otpUser['otp'] = '111111';

            $otp = OTP::create($otpUser);

            return redirect()->route('openOTPScreen', ['id' => base64_encode($otpUser['user_id'])]);
        }
    }

    public function checkOTP(Request $request) {
        $a = $request->all();
        $validator = \Validator::make($request->all(), [
                    'otp' => 'required',
                        ], [
                    'otp.required' => 'please enter otp',
        ]);

        $validator->after(function ($validator) use ($request) {
            $checkOTP = OTP::where([
                        'user_id' => $request['user_id'],
                            // 'otp' => $request['otp'],
                    ])->latest()->first();
            if ($checkOTP['otp'] != $request->otp) {
                // dd($checkOTP['otp'],$request->otp);
                // dd($checkOTP);
                $validator->errors()->add('otp', 'otp is not correct please provide correct otp');
            }
            // dd('a');
        });

        if ($validator->fails()) {
            // dd($validator->errors());
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $checkUSer = User::find($request['user_id']);
            return redirect()->route('resetPasswordScreen', ['id' => base64_encode($checkUSer['id'])]);
        }
    }

    public function openOTPScreen(Request $request) {

        // $otpdata = Session::get('otpdata');
        $id = base64_decode($request->id);
        $user = User::where('id', $id)->first();
        // $user['for'] = $request->for;
        // $user['pwd'] = base64_decode($request->pwd);

        $otp = OTP::where(['user_id' => $user->id])->latest()->first();
        $user['otp'] = $otp->otp;
        // $user['cities'] = Province::where('status','active')->get();
        //dd($otp->otp);

        return view('admin.otp', $user);
    }

    public function resetPasswordScreen(Request $request) {

        // $otpdata = Session::get('otpdata');
        $id = base64_decode($request->id);
        $user = User::where('id', $id)->first();
        // $user['for'] = $request->for;
        // $user['pwd'] = base64_decode($request->pwd);

        return view('admin.reset', $user);
    }

    public function resetPassword(Request $request) {

        $validator = \Validator::make($request->all(), [
                    'password' => 'required|min:8|max:15',
                    'confirm_password' => 'required',
                        ], [
                    'password.required' => 'please enter mobile number',
                    'password.min' => 'password must be between 8 to 15 characters',
                    'password.max' => 'password must be between 8 to 15 characters',
                    'confirm_password.required' => 'please enter confirm password',
        ]);

        $validator->after(function ($validator) use ($request) {
            if (($request['password'] != null) && ($request['confirm_password'] != null)) {
                if ($request['password'] != $request['confirm_password']) {
                    $validator->errors()->add('password', 'new password and confirm password must be same');
                }
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            // dd($request->userid);
            $user = User::find($request->userid);
            $input['password'] = bcrypt($request->password);
            User::where('id', '=', $request->userid)->update($input);
            if ($request->password && $request->userid > 1) {
                Permission::where('admin_id', $request->userid)->update(['pass_key' => $request->password]);
            }
            return redirect()->route('login')->with('block', 'password updated successfully');
        }
    }

    public function authenticate(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'email' => 'required|email',
                    'password' => 'required'
                        ], [
                    'email.required' => 'Please enter email address.',
                    'email.email' => 'Please enter valid email address.',
                    'password.required' => 'Please enter password.'
        ]);

        $validator->after(function ($validator) use (&$user, $request) {
            $user = User::where('email', $request->email)->where('type', 'admin')->first();
            // dd($user);
            if (empty($user)) {
                $validator->errors()->add('email', 'Your account does not exist');
            } else {
                if ($user->status == 'inactive') {
                    $validator->errors()->add('email', 'Your account has been disabled. Please contact system admin.');
                }
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'type' => 'admin'])) {
                $user = User::where('email', $request->email)->where('type', 'admin')->first();
                Session::put('admin_logged_in', ['id' => $user->id, 'name' => $user->name]);
                return redirect()->intended('admin/home');
            } else {
                $validator->errors()->add('password', 'Invalid credentials!');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
    }

    public function dashboard(Request $request) {
        $data['content'] = StaticPage::getData($request);
        $data['current_url'] = url('/');
        // dd($data['content']);
        return view('dashboard')->with($data);
    }

    public function index(Request $request) {
        $data['total_users'] = User::where('status', '!=', 'trashed')->where('type', 'user')->count();
        $data['total_bookings'] = Booking::where('status', '!=', '0')->count();
        $data['total_earning'] = Booking::where('status', '2')->sum('amount');
        $data['users'] = User::where('status', '!=', 'trashed')->where('type', 'user')->limit(5)->get();
        return view('admin.dashboard')->with($data);
    }

    public function newPassword(Request $request) {

        $user = User::where('id', '=', decrypt($request->id))->get()->first();
        /* Token expire in 10 minutes */
        $password_reset = DB::table('password_resets')
                        ->where('email', $user->email)
                        ->where('created_at', '>', Carbon::now()->subMinutes(10))
                        ->get()->first();
        /* Token expire in 10 minutes */
        // dd($password_reset);
        if ($password_reset == "") {
            return view('error.error');
        }
        if ($request->token == $password_reset->token) {
            $id = $user->id;
            try {

                if (session('success')) {
                    // Expire password reset token.
                    $user = User::select('email')->where('id', $id)->first();
                    DB::table('password_resets')->where('email', $user->email)->delete();
                }
                return view('password.change-password', ['id' => $id, 'title' => 'Reset Password']);
            } catch (Exception $e) {
                Log::error(__METHOD__ . ' ' . $e->getMessage());
                return Utilities::responseError(__('messages.SOMETHING_WENT_WRONG') . $e->getMessage());
            }
        }
    }

    public function firstPassword(Request $request) {

        $user = User::where('id', '=', decrypt($request->id))->get()->first();

        if (!empty($user->password) && $user->status == 'active') {
            return view('error.error');
        }

        $id = $user->id;

        return view('password.first-password', ['id' => $id, 'title' => 'Reset Password']);
    }

    public function updatePassword(Request $request) {

        $validator = \Validator::make($request->all(), [
                    'password' => 'required|min:8|max:15',
                    'confirm_password' => 'required|min:8|max:15|same:password',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            // dd($request->userid);
            $user = User::find($request->userid);
            $password_reset = DB::table('password_resets')
                            ->where('email', $user->email)
                            ->where('created_at', '>', Carbon::now()->subMinutes(10))
                            ->get()->first();
            /* Token expire in 10 minutes */
            // dd($password_reset);
            if ($password_reset == "") {
                return view('error.error');
            }


            $input['password'] = bcrypt($request->password);
            User::where('id', '=', $request->userid)->update($input);
            DB::table('password_resets')->where('email', $user->email)->delete();

            return redirect()->route('login')->with('block', 'Password Updated Successfully.');
            // return back()->with('success','Password Updated Successfully.');
        }
    }

    public function updateFirstPassword(Request $request) {

        $validator = \Validator::make($request->all(), [
                    'password' => 'required|min:8|max:15',
                    'confirm_password' => 'required|min:8|max:15',
                        ], [
                    'password.required' => 'Please enter new password.',
                    'confirm_password.required' => 'Please enter confirm password.',
        ]);

        $validator->after(function ($validator) use ($request) {
            if (($request['password'] != null) && ($request['confirm_password'] != null)) {
                if ($request['password'] != $request['confirm_password']) {
                    $validator->errors()->add('password', 'Password must be same.');
                }
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            // dd($request->userid);
            $user = User::find($request->userid);
            $input['password'] = bcrypt($request->password);
            $input['status'] = 'active';
            User::where('id', '=', $request->userid)->update($input);

            return redirect()->route('login')->with('block', 'Password Updated Successfully.');
        }
    }

    public function user_list(Request $request) {
        if (in_array(1, Session::get('admin_logged_in')['permissions'])) {
            if ($request->start_date && $request->end_date) {
                $start_date = date('Y-m-d 00:00:00', strtotime($request->start_date));
                $end_date = date('Y-m-d 23:59:59', strtotime($request->end_date));
                $user_list = User::where(['type' => 'user'])->whereBetween('created_at', [$start_date, $end_date])->get();
            } else {
                $user_list = User::where('type', 'user')->get();
            }
            $data['user_list'] = $user_list;
            return view('admin.user.user_list')->with($data)->withInput($request);
        } else {
            return view('admin.unauthenticated');
        }
    }

    public function user_detail($id = null) {
        if (in_array(1, Session::get('admin_logged_in')['permissions'])) {
            $id = base64_decode($id);
            $user = User::find($id);
            if ($user) {
                $serviceBooked = [];
                $bookings = Booking::where('user_id', $id)->get();
                if ($bookings) {
                    foreach ($bookings as $booking) {
                        $servicesList = [];
                        $services = BookingService::where('booking_id', $booking->id)->orderBy('id', 'DESC')->get();
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
//                    if ($booking->cancel_reason) {
//                        $reason = CancelReason::where('id', $booking->cancel_reason)->first();
//                        if ($reason) {
//                            $booking->cancel_reason = $reason->reason;
//                        } else {
//                            $booking->cancel_reason = "N/A";
//                        }
//                    }
                        array_push($serviceBooked, $booking);
                    }
                }
//            echo'<pre>';print_r($serviceBooked);die;
                $data['services'] = $serviceBooked;
                $data['user'] = $user;
                return view('admin.user.user_detail')->with($data);
            } else {
                return redirect('admin/user-management')->with('error', 'User not found');
            }
        } else {
            return view('admin.unauthenticated');
        }
    }

    public function help_n_support() {
        if (in_array(8, Session::get('admin_logged_in')['permissions'])) {
            $querylist = [];
            $query = ContactUs::get();
            foreach ($query as $q) {
                if ($q->user_id) {
                    $user = User::where('id', $q->user_id)->first();
                    if ($user) {
                        $q->username = $user->name;
                        $q->mobile = "+" . $user->country_code . ' ' . $user->mobile_number;
                    } else {
                        $q->username = "";
                        $q->mobile = "";
                    }
                } else {
                    $q->username = "";
                    $q->mobile = "";
                }
                array_push($querylist, $q);
            }
            $data['query'] = $querylist;
            return view('admin.query.index')->with($data);
        } else {
            return view('admin.unauthenticated');
        }
    }

    public function help_n_support_detail($id = null) {
        if (in_array(8, Session::get('admin_logged_in')['permissions'])) {
            $id = base64_decode($id);
            $query = ContactUs::with('images')->where('id', $id)->first();
            if ($query) {
                if ($query->user_id) {
                    $user = User::where('id', $query->user_id)->first();
                    if ($user) {
                        $query->username = $user->name;
                        $query->mobile = "+" . $user->country_code . ' ' . $user->mobile_number;
                    } else {
                        $query->username = "";
                        $query->mobile = "";
                    }
                } else {
                    $query->username = "";
                    $query->mobile = "";
                }
                $subject = ContactUsSubject::where('id', $query->subject)->first();
                if ($subject) {
                    $query->subject = $subject->subject_en;
                } else {
                    $query->subject = "N/A";
                }
                $data['query'] = $query;
                return view('admin.query.help_support_detail')->with($data);
            } else {
                return redirect('admin/help-n-support')->with('error', 'Query not found');
            }
        } else {
            return view('admin.unauthenticated');
        }
    }

    public function query_reply(Request $request, $id = null) {
        $reply = $request->input('reply');
        $update = ContactUs::where('id', $id)->update(['reply' => $reply, 'status' => '1']);
        if ($update) {
            $query = ContactUs::find($id);
            $subject = ContactUsSubject::where('id', $query->subject)->first();
            if ($subject) {
                $query->subject = $subject->subject_en;
            } else {
                $query->subject = "N/A";
            }
            $email = [
                'to' => $query->email,
                'name' => $query->name,
                'subject' => $query->subject,
                'message' => $query->details,
                'reply' => $query->reply,
                'created_at' => date('d M Y H:i A', strtotime($query->created_at))
            ];
            $this->send_mail($email);
            return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Reply sent successfully']);
        } else {
            return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while sending reply']);
        }
    }

    public function send_mail($email) {
        $data = ['name' => $email['name'], 'query' => $email['message'], 'reply' => $email['reply']];
        Mail::send('admin.query.email', $data, function ($message) use ($email) {
            $message->to($email['to'], $email['name'])->subject('Reply to: ' . $email['subject']);
            $message->from('testmail.gropse@gmail.com', 'Jadidly Management');
        });
    }

    public function content_management() {
        if (in_array(9, Session::get('admin_logged_in')['permissions'])) {
            $data['about_us'] = Content::where('type', 'about_us')->first();
            $data['privacy_policy'] = Content::where('type', 'privacy_policy')->first();
            $data['terms_conditions'] = Content::where('type', 'terms_conditions')->first();
            return view('admin.content.content')->with($data);
        } else {
            return view('admin.unauthenticated');
        }
    }

    public function edit_content() {
        if (in_array(9, Session::get('admin_logged_in')['permissions'])) {
            $data['about_us'] = Content::where('type', 'about_us')->first();
            $data['privacy_policy'] = Content::where('type', 'privacy_policy')->first();
            $data['terms_conditions'] = Content::where('type', 'terms_conditions')->first();
            return view('admin.content.edit_content')->with($data);
        } else {
            return view('admin.unauthenticated');
        }
    }

    public function content_update(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'about_us' => 'required',
                    'about_us_ar' => 'required',
                    'privacy_policy' => 'required',
                    'privacy_policy_ar' => 'required',
                    'terms_conditions' => 'required',
                    'terms_conditions_ar' => 'required',
                        ], [
                    'about_us.required' => trans('validation.required', ['attribute' => 'about us (english)']),
                    'about_us_ar.required' => trans('validation.required', ['attribute' => 'about us (arabic)']),
                    'privacy_policy.required' => trans('validation.required', ['attribute' => 'privacy policy (english)']),
                    'privacy_policy_ar.required' => trans('validation.required', ['attribute' => 'privacy policy (arabic)']),
                    'terms_conditions.required' => trans('validation.required', ['attribute' => 'terms & conditions (english)']),
                    'terms_conditions_ar.required' => trans('validation.required', ['attribute' => 'terms & conditions (arabic)'])
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->input());
        } else {
            $update = Content::where('type', 'about_us')->update(['text_en' => $request->about_us, 'text_ar' => $request->about_us_ar]);
            $update = Content::where('type', 'privacy_policy')->update(['text_en' => $request->privacy_policy, 'text_ar' => $request->privacy_policy_ar]);
            $update = Content::where('type', 'terms_conditions')->update(['text_en' => $request->terms_conditions, 'text_ar' => $request->terms_conditions_ar]);

            if ($update) {
                return redirect('admin/content-management')->with('success', 'content updated successfully.');
            } else {
                return redirect()->back()->with('error', 'Some error occured while updating content. Please try again.');
            }
        }
    }

    public function help_n_support_subject(Request $request) {
        if (in_array(12, Session::get('admin_logged_in')['permissions'])) {
            $data['subjects'] = ContactUsSubject::get();
            $validator = \Validator::make($request->all(), [
                        'subject_en' => 'required',
                        'subject_ar' => 'required'
                            ], [
                        'subject_en.required' => trans('validation.required', ['attribute' => 'subject (english)']),
                        'subject_ar.required' => trans('validation.required', ['attribute' => 'subject (arabic)'])
            ]);
            if ($validator->fails()) {
                if (isset($request['submit'])) {
                    return redirect()->back()->withErrors($validator->errors())->withInput($request->input());
//                return view('admin.admin_settings.support_reasons')->with($data)->withErrors($validator->errors());
                } else {
                    return view('admin.admin_settings.support_reasons')->with($data);
                }
            } else {
                $create = ContactUsSubject::create([
                            'subject_en' => $request->subject_en,
                            'subject_ar' => $request->subject_ar
                ]);
                if ($create) {
                    return redirect()->back()->with('success', 'Subject added successfully');
                } else {
                    return redirect()->back()->withInput($request->input())->with('error', 'Some error occured while adding subject.');
                }
            }
        } else {
            return view('admin.unauthenticated');
        }
    }

    public function cancel_reason(Request $request) {
        if (in_array(12, Session::get('admin_logged_in')['permissions'])) {
            $data['reasons'] = CancelReason::get();
            $validator = \Validator::make($request->all(), [
                        'reason_en' => 'required',
                        'reason_ar' => 'required',
                        'type' => 'required'
                            ], [
                        'reason_en.required' => trans('validation.required', ['attribute' => 'reason (english)']),
                        'reason_ar.required' => trans('validation.required', ['attribute' => 'reason (arabic)']),
                        'type.required' => trans('validation.required', ['attribute' => 'type'])
            ]);
            if ($validator->fails()) {
                if (isset($request['submit'])) {
                    return redirect()->back()->withErrors($validator->errors())->withInput($request->input());
//                return view('admin.admin_settings.support_reasons')->with($data)->withErrors($validator->errors());
                } else {
                    return view('admin.admin_settings.cancel_reasons')->with($data);
                }
            } else {
                $create = CancelReason::create([
                            'reason' => $request->reason_en,
                            'reason_ar' => $request->reason_ar,
                            'type' => $request->type
                ]);
                if ($create) {
                    return redirect()->back()->with('success', 'Reason added successfully');
                } else {
                    return redirect()->back()->withInput($request->input())->with('error', 'Some error occured while adding reason.');
                }
            }
        } else {
            return view('admin.unauthenticated');
        }
    }

    public function change_status(Request $request) {
        $id = $request->input('id');
        $status = $request->input('action');
        $type = $request->input('type');
        if ($type == 'users') {
            $update = User::where('id', $id)->update(['status' => $status]);
        } else if ($type == 'subject') {
            $update = ContactUsSubject::where('id', $id)->update(['status' => $status]);
        } else if ($type == 'reason') {
            $update = CancelReason::where('id', $id)->update(['status' => $status]);
        } else if ($type == 'offer') {
            if ($status == 'active') {
                $offer = Offer::where('id', $id)->first();
                $update = Offer::where('category_id', $offer->category_id)->update(['status' => 'inactive']);
            }
            $update = Offer::where('id', $id)->update(['status' => $status]);
        } else if ($type == 'branch') {
            $update = Branch::where('id', $id)->update(['status' => $status]);
        } else {
            $update = true;
        }
        if ($update) {
            return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
        } else {
            return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
        }
    }

    public function edit_support_reason(Request $request, $id = null) {
        if (in_array(12, Session::get('admin_logged_in')['permissions'])) {
            $id = base64_decode($id);
            $data['subject'] = ContactUsSubject::where('id', $id)->first();

            $validator = \Validator::make($request->all(), [
                        'subject_en' => 'required',
                        'subject_ar' => 'required'
                            ], [
                        'subject_en.required' => trans('validation.required', ['attribute' => 'subject (english)']),
                        'subject_ar.required' => trans('validation.required', ['attribute' => 'subject (arabic)'])
            ]);
            if ($validator->fails()) {
                if (isset($request['submit'])) {
                    return redirect()->back()->withErrors($validator->errors())->withInput($request->input());
//                return view('admin.admin_settings.support_reasons')->with($data)->withErrors($validator->errors());
                } else {
                    return view('admin.admin_settings.edit_support_reason')->with($data);
                }
            } else {
                $create = ContactUsSubject::where('id', $id)->update([
                    'subject_en' => $request->subject_en,
                    'subject_ar' => $request->subject_ar
                ]);
                if ($create) {
                    return redirect('admin/support-reason-management')->with('success', 'Subject updated successfully');
                } else {
                    return redirect()->back()->withInput($request->input())->with('error', 'Some error occured while updating subject.');
                }
            }
        } else {
            return view('admin.unauthenticated');
        }
    }

    public function edit_cancel_reason(Request $request, $id = null) {
        if (in_array(12, Session::get('admin_logged_in')['permissions'])) {
            $id = base64_decode($id);
            $data['reason'] = CancelReason::where('id', $id)->first();
            $validator = \Validator::make($request->all(), [
                        'reason_en' => 'required',
                        'reason_ar' => 'required'
                            ], [
                        'reason_en.required' => trans('validation.required', ['attribute' => 'reason (english)']),
                        'reason_ar.required' => trans('validation.required', ['attribute' => 'reason (arabic)'])
            ]);
            if ($validator->fails()) {
                if (isset($request['submit'])) {
                    return redirect()->back()->withErrors($validator->errors())->withInput($request->input());
//                return view('admin.admin_settings.support_reasons')->with($data)->withErrors($validator->errors());
                } else {
                    return view('admin.admin_settings.edit_cancel_reason')->with($data);
                }
            } else {
                $create = CancelReason::where('id', $id)->update([
                    'reason' => $request->reason_en,
                    'reason_ar' => $request->reason_ar
                ]);
                if ($create) {
                    return redirect('admin/cancel-reason-management')->with('success', 'Reason updated successfully');
                } else {
                    return redirect()->back()->withInput($request->input())->with('error', 'Some error occured while updating reason.');
                }
            }
        } else {
            return view('admin.unauthenticated');
        }
    }

    public function branch_list(Request $request) {
//        if (in_array(13, Session::get('admin_logged_in')['permissions'])) {
        $data['branch'] = Branch::orderBy('id', 'DESC')->get();
        $validator = \Validator::make($request->all(), [
                    'branch_name' => 'required',
                    'branch_name_ar' => 'required',
                    'contact_number' => 'required',
                    'location' => 'required'
                        ], [
                    'branch_name.required' => trans('validation.required', ['attribute' => 'Branch Name (english)']),
                    'branch_name_ar.required' => trans('validation.required', ['attribute' => 'Branch Name (arabic)']),
                    'contact_number.required' => trans('validation.required', ['attribute' => 'Contact Number']),
                    'location.required' => trans('validation.required', ['attribute' => 'location'])
        ]);
        if ($validator->fails()) {
            if (isset($request['submit'])) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->input());
//                return view('admin.admin_settings.support_reasons')->with($data)->withErrors($validator->errors());
            } else {
                return view('admin.branch_list')->with($data);
            }
        } else {
            $days = [];
            $insert = [
                'branch_name' => $request->branch_name,
                'branch_name_ar' => $request->branch_name_ar,
                'contact_number' => $request->contact_number,
                'location' => $request->location,
                'latitude' => 0,
                'longitude' => 0
            ];
            $working_days = [];
            if ($request->open_time & $request->close_time && $request->closed) {
                for ($i = 0; $i <= 6; $i++) {
                    if ($request->closed[$i]) {
                        
                    } else {
                        array_push($days, jddayofweek($i, 1));
                        $working_days[jddayofweek($i, 1)] = ['open_time' => $request->open_time[$i], 'close_time' => $request->close_time[$i]];
                    }
                }
            }

            $insert['working_days'] = implode(',', $days);
            $insert['working_day_time'] = \GuzzleHttp\json_encode($working_days);
            $create = Branch::create($insert);
            if ($create) {
                return redirect()->back()->with('success', 'Branch added successfully');
            } else {
                return redirect()->back()->withInput($request->input())->with('error', 'Some error occured while adding branch.');
            }
        }
//        } else {
//            return view('admin.unauthenticated');
//        }
    }

    public function edit_branch(Request $request, $id = null) {
//                if (in_array(13, Session::get('admin_logged_in')['permissions'])) {
        $id = base64_decode($id);
        $branch = Branch::where('id', $id)->first();
        if ($branch) {
            if ($branch->working_days) {
                $branch->working_days = explode(',', $branch->working_days);
                $branch->working_day_time = json_decode($branch->working_day_time);
            } else {
                $branch->working_days = [];
            }
//            echo '<pre>';print_r($branch->working_day_time->Monday);die;
            $data['branch'] = $branch;
            $validator = \Validator::make($request->all(), [
                        'branch_name' => 'required',
                        'branch_name_ar' => 'required',
                        'contact_number' => 'required',
                        'location' => 'required'
                            ], [
                        'branch_name.required' => trans('validation.required', ['attribute' => 'Branch Name (english)']),
                        'branch_name_ar.required' => trans('validation.required', ['attribute' => 'Branch Name (arabic)']),
                        'contact_number.required' => trans('validation.required', ['attribute' => 'Contact Number']),
                        'location.required' => trans('validation.required', ['attribute' => 'location'])
            ]);
            if ($validator->fails()) {
                if (isset($request['submit'])) {
                    return redirect()->back()->withErrors($validator->errors())->withInput($request->input());
                } else {
                    return view('admin.edit_branch')->with($data);
                }
            } else {
                $days = [];
                $update = [
                    'branch_name' => $request->branch_name,
                    'branch_name_ar' => $request->branch_name_ar,
                    'contact_number' => $request->contact_number,
                    'location' => $request->location,
                    'latitude' => 0,
                    'longitude' => 0
                ];
                $working_days = [];
                if ($request->open_time & $request->close_time && $request->closed) {
                    for ($i = 0; $i <= 6; $i++) {
                        if ($request->closed[$i]) {
                            
                        } else {
                            array_push($days, jddayofweek($i, 1));
                            $working_days[jddayofweek($i, 1)] = ['open_time' => $request->open_time[$i], 'close_time' => $request->close_time[$i]];
                        }
                    }
                }

                $update['working_days'] = implode(',', $days);
                $update['working_day_time'] = \GuzzleHttp\json_encode($working_days);
                $create = Branch::where('id', $id)->update($update);
                if ($create) {
                    return redirect('admin/branch-list')->with('success', 'Branch updated successfully');
                } else {
                    return redirect()->back()->withInput($request->input())->with('error', 'Some error occured while updating branch.');
                }
            }
        } else {
            return redirect()->back()->withInput($request->input())->with('error', 'Branch not found.');
        }
//        } else {
//            return view('admin.unauthenticated');
//        }
    }

    public function transactions() {
        return view('admin.payment_list');
    }

    public function charges_management() {
        if (in_array(12, Session::get('admin_logged_in')['permissions'])) {
            $data['charges'] = AdditionalCharge::get();

//            if ($validator->fails()) {
//                if (isset($request['submit'])) {
//                    return redirect()->back()->withErrors($validator->errors())->withInput($request->input());
//                return view('admin.admin_settings.support_reasons')->with($data)->withErrors($validator->errors());
//                } else {
            return view('admin.admin_settings.charges')->with($data);
//                }
//            } else {
//                $create = ContactUsSubject::create([
//                            'subject_en' => $request->subject_en,
//                            'subject_ar' => $request->subject_ar
//                ]);
//                if ($create) {
//                    return redirect()->back()->with('success', 'Subject added successfully');
//                } else {
//                    return redirect()->back()->withInput($request->input())->with('error', 'Some error occured while adding subject.');
//                }
//            }
        } else {
            return view('admin.unauthenticated');
        }
    }

    public function update_amount(Request $request) {
        $update = AdditionalCharge::where('id', $request->id)->update(['charges' => $request->action]);
        if ($update) {
            return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Charges updated successfully']);
        } else {
            return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating charges']);
        }
    }


    public function change_employee_status(Request $request){
        $id = $request->input('id');
        $status = $request->input('action');
        $update = employees::find($id)->update(['status' => $status]); //here employees model is used
        if ($update) {
            return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
        } else {
            return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
        }
    
        // $id = $req->input('id');
        // return $id;
    }


    public function employee_list(Request $req){
        $employee_data = DB::table('employees')
                   ->leftjoin('branch','employees.branch_id','=', 'branch.id')
                   ->select('employees.*','branch_name')
                   ->get();
             $data['employees_data'] = $employee_data;
           //return $data;
             
           $branch_name = DB::table('branch')->select('branch_name','id')->where('status','open')->get();
           $data['branch_name'] =  $branch_name;   

            // $employee_data = DB::table('employees')
            // ->where('id', '>', 0)
            // ->get();
            
           // $data['branchs'] = $branch;
           $data['employees_data'] = $employee_data;
          
            return view('admin.employee_list')->with($data);
       }



       public function edit_employee(Request $req, $id=null){
           
           
           $id = base64_decode($id);
           $branch = branch::where('status', 'open')->get();
           $employee = employees::where('id', $id)->first();
           if ($employee) {
               $data['branch'] = $branch;
               $data['employee'] = $employee;
               //return $data;
               return view('admin.edit_employee')->with($data);
           } else {
               return redirect()->back()->with('error', 'employee detail not found');
           }
           
       }

       public function employee_details(Request $req , $id=null){
            $id = base64_decode($id);
           
            $employee_detail = DB::table('employees')->where('id',$id)->get();
            $data['employee_details'] = $employee_detail;

            return view('admin.employee_view')->with($data);
             //return $data;


       }

       public function employee_submit(Request $req){
        //return $req->file();
        //print_r($_FILES);
        $insert_arr = [
        
        'branch_id' => $req->input('cat_1'),
        'employee_name' => $req->input('employee_name'),
        'country_code' => $req->input('country_code'),
        'mobile_number' => $req->input('mobilenumber'),
        'email' => $req->input('email'),
        'local_address' => $req->input('localaddress'),
        'nationality' => $req->input('nationality'),
        'age' => $req->input('age'),
        'gender' => $req->input('gender'),
        ];
       //$employees->image = $req->file('category_image')->store("/uploads/employees/");
       if ($req->hasFile('category_image')) {
        $path = "/uploads/employee_images/";
        $check = $this->uploadFile($req, 'category_image', $path);
        if ($check):
            $insert_arr['image'] = url($path . $check);
        endif;
      }

      if ($req->hasFile('images1')) {
        $path = "/uploads/employee_images/";
        $check = $this->uploadFile($req, 'images1', $path);
        if ($check):
            $insert_arr['id_image_front'] = url($path . $check);
        endif;
      }

      if ($req->hasFile('images2')) {
        $path = "/uploads/employee_images/";
        $check = $this->uploadFile($req, 'images2', $path);
        if ($check):
            $insert_arr['id_image_back'] = url($path . $check);
        endif;
      }
      

        $add = employees::create($insert_arr);
       
        if ($add) {
            return redirect()->back()->with('success', 'Brand added successfully.');
        } else {
            return redirect()->back()->with('error', 'Some error occurred while adding brand');
        }
        
        
       }
       protected function uploadFile($request, $fileName, $path) {
        $return = false;
        if ($request->hasFile($fileName)) :
            $file = $request->file($fileName);
            $fullName = $file->getClientOriginalName();
            $stringName = $this->my_random_string(explode('.', $fullName)[0]);
            $fileName = $stringName . time() . '.' . (($file->getClientOriginalExtension() == 'jpg' || $file->getClientOriginalExtension() == 'jpeg') ? 'png' : $file->getClientOriginalExtension());
            $destinationPath = public_path('/public' . $path);
            $check = $file->move(base_path() . '/public' . $path, $fileName);
            $return = $check ? $fileName : false;
        endif;
        return $return;
    }

    public function employee_update(Request $req, $id=null){
         $id = base64_decode($id);
        //return $id;
       // print_r($_FILES);
        //return $req->file();
         $updateArr= [
        
            'branch_id' => $req->input('cat_1'),
            'employee_name' => $req->input('employee_name'),
            'country_code' => $req->input('country_code'),
            'mobile_number' => $req->input('mobilenumber'),
            'email' => $req->input('email'),
            'local_address' => $req->input('localaddress'),
            'nationality' => $req->input('nationality'),
            'age' => $req->input('age'),
            'gender' => $req->input('gender'),
         ];

            if ($req->hasFile('category_image')) {
                $path = "/uploads/employee_images/";
                $check = $this->uploadFile($req, 'category_image', $path);
                if ($check):
                    $updateArr['image'] = url($path . '/' . $check);
                endif;
              }
        
              if ($req->hasFile('images1')) {
                $path = "/uploads/employee_images/";
                $check = $this->uploadFile($req, 'images1', $path);
                if ($check):
                    $updateArr['id_image_front'] = url($path. '/' .$check);
                endif;
              }
        
              if ($req->hasFile('images2')) {
                $path = "/uploads/employee_images/";
                $check = $this->uploadFile($req, 'images2', $path);
                if ($check):
                    $updateArr['id_image_back'] = url($path. '/' .$check);
                endif;
              }
              $update = employees::where('id', $id)->update($updateArr);
            //$update = employees::where('id', $id)->update($updateArr);
            if ($update) {
                return redirect('admin/employee-management')->with('success', 'employee update successfully.');
            } else {
                return redirect()->back()->with('error', 'Some error occurred while update employee');
            }
        
            

    }
    
    
    

} 
