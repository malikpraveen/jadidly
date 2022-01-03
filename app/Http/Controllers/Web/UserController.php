<?php

namespace App\Http\Controllers\Web;

use Auth;
use DB;
use Mail;
use Response;
use Session;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrudOverrideController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class UserController extends Controller {

    private $URI_PLACEHOLDER;
    private $jsondata;
    private $redirect;
    protected $message;
    protected $status;
    private $prefix;

//    private $user_data;

    public function __construct() {
        // dd('aaaa');
        $this->jsondata = [];
        $this->message = false;
        $this->redirect = false;
        $this->status = false;
        $this->prefix = \DB::getTablePrefix();
        $this->URI_PLACEHOLDER = \Config::get('constants.URI_PLACEHOLDER');
        $this->middleware(function ($request, $next) {
            $user_data = session()->get('login_info');
//           echo '<pre>';print_r($user_data);
            if (!$user_data) {
                Session::forget('login_info');
                \Redirect::to('login')->send();
            }
            return $next($request);
        });
    }

    public function index() {
        $user_data = Session::get('login_info');
        $data['user'] = $user_data;
        return view('web.user.my_account')->with($data);
    }

    public function edit_profile() {
        $user_data = Session::get('login_info');
//        print_r($user_data);die;
        $data['user'] = $user_data;
        return view('web.user.edit_profile')->with($data);
    }

    public function change_password() {
        $user_data = Session::get('login_info');
        $data['user'] = $user_data;
        return view('web.user.change_password')->with($data);
    }

    public function subcategory_list($id = null) {

        $data['category_list'] = [];
        $id = base64_decode($id);
        if ($id) {
            $data['category_id'] = $id;
        } else {
            $data['category_id'] = "";
        }
        return view('web.subcategory_list')->with($data);
    }

    public function service_list($id = null) {
         $id = base64_decode($id);
        if ($id) {
            $data['category_id'] = $id;
            $data['service_list'] = [];
            return view('web.service')->with($data);
        } else {
            $user_data = Session::get('login_info');
            $data['category_id'] = "";
            $data['category_list'] = [];
            return view('web.subcategory_list')->with($data);
        }
    }

    public function my_cart() {
//        dd('hi');
//        $request=[
//            'headers'=>['Authorization:Bearer '.Session::get('login_info')['token']],
//        ];
//        $request->header('Authorization', 'Bearer '.Session::get('login_info')['token']);
//        $tokenRequest = Request::create(
//                        url('/api/myCart'),
//                        'get', [
//                    'headers' => [
//                        'Authorization' => 'Bearer ' . Session::get('login_info')['token'],
//                        'Accept' => 'application/json',
//                    ],
//                        ]
//        );
//        try {
//            $client = new Client();
//            $request = $client->get('http://127.0.0.1:8000/api/myCart', [
//                'headers' => [
//                    'Authorization' => 'Bearer ' . Session::get('login_info')['token'],
//                    'Accept' => 'application/json',
//                ],
//            ]);
//            $response = $request->getBody();
//        } catch (Throwable $e) {
//            report($e);
//
//            return false;
//        }
//        $response = app()->handle($tokenRequest);
//        $res = $response->getData();
//        echo '<pre>';
//        print_r($response);
//        exit;
//        $response = Route::dispatch($tokenRequest)->getContent();
//        if ($res->status_code == 200 && $res->status) {
//            $data['my_cart'] = $res->data;
//        } else {
//            $data['my_cart'] = [];
//        }
        return view('web.user.cart');
    }

    public function checkout_order() {
        $user_data = Session::get('login_info');
        $data['user'] = $user_data;
        return view('web.user.checkout')->with($data);
    }

    public function my_cars() {
        $user_data = Session::get('login_info');
        $data['user'] = $user_data;
        return view('web.user.cars')->with($data);
    }

    public function add_car() {
        $user_data = Session::get('login_info');
        $data['user'] = $user_data;
        return view('web.user.add_new_car')->with($data);
    }

    public function my_bookings() {
        $user_data = Session::get('login_info');
        $data['user'] = $user_data;
        return view('web.user.my_booking')->with($data);
    }

    public function booking_detail(Request $request, $id = null) {
        $user_data = Session::get('login_info');
        $id = base64_decode($id);
        $post = ['booking_id' => $id];
        $request->headers->set('Authorization', 'Bearer ' . $user_data['token']);
        $request->request->add($post);
        $tokenRequest = Request::create(
                        '/api/bookingDetails',
                        'POST', $request->all()
        );
        $response = Route::dispatch($tokenRequest)->getContent();
        $res = json_decode($response);
        if ($res->status_code == 200 && $res->status == true) {
            $data['booking'] = $res->data;
            $data['user'] = $user_data;
            return view('web.user.booking_detail')->with($data);
        } else {
            $data['booking'] = "";
            return redirect()->back()->with('error', ($res->error ? $res->error : $res->message));
        }
    }

}

?>