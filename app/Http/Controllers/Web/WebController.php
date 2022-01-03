<?php

namespace App\Http\Controllers\Web;

use Auth;
use DB;
use Mail;
use Response;
use Session;
use GuzzleHttp\Client;
use App\Models\Content;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\CrudOverrideController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class WebController extends Controller {

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
//        $this->user_data=Session::get('login_info');
    }

    public function index() {
        $tokenRequest = Request::create(
                        '/api/dashboard',
                        'GET'
        );

        $response = Route::dispatch($tokenRequest)->getContent();
        $res = json_decode($response);
        if ($res->status_code == 200 && $res->status) {
            $data['homepage'] = $res->data;
        } else {
            $data['homepage'] = [];
        }

        return view('web.index')->with($data);
    }

    public function about_us() {
        $tokenRequest = Request::create(
                        '/api/dashboard',
                        'GET'
        );

        $response = Route::dispatch($tokenRequest)->getContent();
        $res = json_decode($response);
        if ($res->status_code == 200 && $res->status) {
            $data['homepage'] = $res->data;
        } else {
            $data['homepage'] = [];
        }
        $content = Content::select('id', 'text_en as text')->where('type', 'about_us')->get()->first();
        $data['content'] = $content;
        return view('web.about_us')->with($data);
    }

    public function privacy_policy() {
        $content = Content::select('id', 'text_en as text')->where('type', 'privacy_policy')->get()->first();
        $data['content'] = $content;
        return view('web.privacy_policy')->with($data);
    }

    public function terms_conditions() {
        $content = Content::select('id', 'text_en as text')->where('type', 'terms_conditions')->get()->first();
        $data['content'] = $content;
        return view('web.term_condition')->with($data);
    }

    public function login() {
        if (Session::get('login_info')) {
            return redirect('home');
        } else {
            return view('web.login');
        }
    }

    public function registration() {
        if (Session::get('login_info')) {
            return redirect('home');
        } else {
            return view('web.register');
        }
    }

    public function verification() {
        if (Session::get('login_info')) {
            return redirect('home');
        } else {
            return view('web.verification');
        }
    }

    public function forgot_password() {
        if (Session::get('login_info')) {
            return redirect('home');
        } else {
            return view('web.forgot_password');
        }
    }

    public function verify() {
        if (Session::get('login_info')) {
            return redirect('home');
        } else {
            return view('web.verify');
        }
    }

    public function reset_password() {
        if (Session::get('login_info')) {
            return redirect('home');
        } else {
            return view('web.reset_password');
        }
    }

    public function contact_us() {
        return view('web.contact');
    }

    public function offer_list() {
        $tokenRequest = Request::create(
                        '/api/offerList',
                        'GET'
        );

        $response = Route::dispatch($tokenRequest)->getContent();
        $res = json_decode($response);
        if ($res->status_code == 200 && $res->status) {
            $data['offers'] = $res->data;
        } else {
            $data['offers'] = [];
        }
        return view('web.offers')->with($data);
    }

    public function set_session_keys(Request $request) {
        $data = $_POST;
        Session::put('login_info', $data);
        echo json_encode(['status' => true, 'error_code' => 100, 'message' => 'Session set successfully.']);
    }

    public function unset_session_keys(Request $request) {
        Session::forget($request->key);
        echo json_encode(['status' => true, 'error_code' => 100, 'message' => 'Session set successfully.']);
    }

}

?>
