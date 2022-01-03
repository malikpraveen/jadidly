<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\User;
use App\Models\OTP;
use App\Models\ContactUs;
use App\Models\CarDocument;
use App\Models\ContactUsImage;
use App\Models\ContactUsSubject;
use App\Models\CancelReason;
use App\Models\Categories;
use App\Models\Content;
use App\Models\Service;
use App\Models\Brand;
use App\Models\Branch;
use App\Models\Offer;
use App\Models\Booking;
use App\Models\BookingService;
use App\Models\BrandCar;
use App\Models\ModelName;
use App\Models\UserCart;
use App\Models\UserCar;
use App\Models\AdditionalCharge;
use App\Models\CancellationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {

    public function __construct() {
        DB::enableQueryLog();
    }

    public function register(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'name' => 'required',
                    // 'email'         =>  'required|email',
                    'email' => 'email',
                    'country_code' => 'required',
                    'password' => 'required|min:6',
                    'mobile_number' => 'required|numeric',
                        ], [
                    'name.required' => trans('messages.F001'),
                    // 'email.required'        =>  trans('messages.F002'),
                    'email.email' => trans('messages.F003'),
                    'country_code.required' => trans('messages.F027'),
                    'password.required' => trans('messages.F005'),
                    'password.min' => trans('validation.min', ['attribute' => 'password']),
                    'mobile_number.required' => trans('messages.F026'),
                    'mobile_number.numeric' => trans('messages.F028'),
        ]);

        $validator->after(function ($validator) use ($request) {
            if ($request['email']) {
                $email = User::where('email', $request['email'])->whereNotIn('status', ['inactive', 'trashed'])->first();
                if ($email) {
                    $validator->errors()->add('email', trans('messages.F006'));
                }
            }
            if ($request['country_code'] && $request['mobile_number']) {
                $mobile = User::where(['country_code' => $request['country_code'], 'mobile_number' => $request['mobile_number']])->whereNotIn('status', ['inactive', 'trashed'])/* ->where('is_completed','yes') */->first();
                if ($mobile) {
                    $validator->errors()->add('mobile_number', trans('messages.F029'));
                }
            }
        });

        if ($validator->fails()) {
            // dd($validator->errors());
            $this->status_code = 201;
            $this->message = $validator->errors();
        } else {
            User::where(['country_code' => $request['country_code'], 'mobile_number' => $request['mobile_number'], 'status' => 'inactive'])->orWhere(['email' => $request['email'], 'status' => 'inactive'])->delete();
            $addUser['password'] = bcrypt($request->password);
            $addUser['name'] = ucwords($request['name']);
            $addUser['email'] = $request['email'];
            $addUser['country_code'] = $request['country_code'];
            $addUser['mobile_number'] = $request['mobile_number'];
            $addUser['is_otp_verified'] = 'no';
            $addUser['status'] = 'inactive';
            $otpUser['otp'] = '111111';
            $otpUser['type'] = 'user';

            $data = User::create($addUser);
            $otpUser['user_id'] = $data['id'];
            $otp = OTP::create($otpUser);

            $response = new \Lib\PopulateResponse($data);

            $this->data = $response->apiResponse();
            $this->status = true;
            $this->message = trans('messages.F007');
        }
        return $this->populateResponse();
    }

    public function otp(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'otp' => 'required',
                        ], [
                    'otp.required' => trans('messages.F008'),
        ]);

        $validator->after(function ($validator) use ($request) {
            $checkOTP = OTP::where([
                        'user_id' => $request['user_id'],
                        'otp' => $request['otp'],
                    ])->latest()->first();
            // dd($checkOTP);
            if (empty($checkOTP)) {
                $validator->errors()->add('error', trans('messages.F009'));
            }
        });

        if ($validator->fails()) {
            $this->status_code = 201;
            $this->message = $validator->errors();
        } else {
            $user = User::where('id', $request['user_id'])->get()->first();
            if ($user && $user->status == 'inactive') {
                $update['status'] = 'active';
            }
            if ($request->type !== 'forgotPassword') {
                if ($request->type == 'registration') {
                    $update['is_otp_verified'] = 'yes';
                    User::where('id', $request['user_id'])->update($update);
                    $user = User::where('id', $request['user_id'])->get()->first();
                } else if ($request->type == 'email') {
                    $update['is_email_verified'] = 'yes';
                    User::where('id', $request['user_id'])->update($update);
                    $user = User::where('id', $request['user_id'])->get()->first();
                } else {
                    // forgotPassword
                }
                $updateArr = array();
                // $updateArr['timezone'] = $request->timezone;
                if ($request->device_token != "" && $request->device_type != "") {
                    $updateArr['device_token'] = $request->device_token;
                    $updateArr['device_type'] = $request->device_type == 'iphone' ? 'ios' : 'android';
                }
                if ($updateArr) {
                    User::where('id', $user->id)->update($updateArr);
                }
                $userTokens = $user->tokens;
                foreach ($userTokens as $utoken) {
                    $utoken->revoke();
                }

                $tokenResult = $user->createToken('MyApp');
                $token = $tokenResult->token;
                $token->save();
                $user['token'] = $tokenResult->accessToken;
                $data = $user;
            } else {
                $data = [];
            }

            $response = new \Lib\PopulateResponse($data);
            $this->data = $response->apiResponse();
            $this->status = true;
            $this->message = trans('messages.F010');
        }
        return $this->populateResponse();
    }

    public function login(Request $request) {

        if ($request->type == 2) {
            $validator = \Validator::make($request->all(), [
                        'type' => ['required'],
                        'country_code' => ['required'],
                        'mobile_number' => ['required'],
                        'password' => ['required'],
                            ], [
                        'type.required' => 'type is required field',
                        'country_code' => trans('messages.F027'),
                        'mobile_number' => trans('messages.F011'),
                        'password.required' => trans('messages.F005'),
            ]);
            $validator->after(function ($validator) use (&$user, $request) {
                $credentials = request(['country_code', 'mobile_number', 'password']);

                if (!Auth::attempt($credentials))
                    $validator->errors()->add('mobile_number', trans('messages.F011'));
            });
        } else {
            $validator = \Validator::make($request->all(), [
                        'type' => ['required'],
                        'email' => ['required'],
                        'password' => ['required'],
                            ], [
                        'type.required' => 'type is required field',
                        'email.required' => trans('messages.F002'),
                        'password.required' => trans('messages.F005'),
            ]);
            $validator->after(function ($validator) use (&$user, $request) {
                $credentials = request(['email', 'password']);

                if (!Auth::attempt($credentials))
                    $validator->errors()->add('email', trans('messages.F011'));
            });
        }

        // dd('d');
        if ($validator->fails()) {
            $this->status_code = 201;
            $this->message = $validator->errors();
        } else {
            if ($request->type == 2) {
                $user = User::where(['country_code' => $request->country_code, 'mobile_number' => $request->mobile_number])->first();
            } else {
                $user = User::where(['email' => $request->email])->first();
            }
            if ($user->status == 'active') {
                if (($request->type == 1 && $user->is_email_verified == 'yes') || ($request->type == 2 && $user->is_otp_verified == 'yes')) {
                    $updateArr = array();
                    // $updateArr['timezone'] = $request->timezone;
                    if ($request->device_token != "" && $request->device_type != "") {
                        $updateArr['device_token'] = $request->device_token;
                        $updateArr['device_type'] = $request->device_type == 'iphone' ? 'ios' : 'android';
                    }
                    if ($updateArr) {
                        User::where('id', $user->id)->update($updateArr);
                    }

                    $userTokens = $user->tokens;

                    foreach ($userTokens as $utoken) {
                        $utoken->revoke();
                    }

                    $tokenResult = $user->createToken('MyApp');
                    $token = $tokenResult->token;
                    $token->save();
                    $user['token'] = $tokenResult->accessToken;
                    $data = $user;
                    $this->message = trans('messages.F012');
                } else {
                    $otpUser['otp'] = '111111';
                    $otpUser['type'] = 'user';
                    $otpUser['user_id'] = $user->id;
                    $otp = OTP::create($otpUser);
                    $data['user_id'] = $otpUser['user_id'];
                    $data['otp'] = $otpUser['otp'];
                    if ($request->type == 2) {
                        $this->message = trans('messages.F041');
                    } else {
                        $this->message = trans('messages.F040');
                    }
                    $this->status_code = 201;
                }
            } else if ($user->status == 'inactive') {
                $otpUser['otp'] = '111111';
                $otpUser['type'] = 'user';
                $otpUser['user_id'] = $user->id;
                $otp = OTP::create($otpUser);
                $data['user_id'] = $otpUser['user_id'];
                $data['otp'] = $otpUser['otp'];
                $this->message = trans('messages.F037');
                $this->status_code = 201;
            } else if ($user->status == 'blocked') {
                $data = [];
                $this->message = trans('messages.F039');
                $this->status_code = 202;
            } else {
                $data = [];
                $this->message = trans('messages.F038');
                $this->status_code = 203;
            }
            $this->status = true;
            $response = new \Lib\PopulateResponse($data);
            $this->data = $response->apiResponse();
        }
        return $this->populateResponse();
    }

    public function logout(Request $request) {
        Auth::guard('api')->user()->token()->revoke();
        $user = [];
        $response = new \Lib\PopulateResponse($user);

        $this->data = $response->apiResponse();
        $this->status = true;
        $this->message = 'Logged out successfully.';

        return $this->populateResponse();
    }

    public function forgotPassword(Request $request) {
        if ($request->type == 2) {
            $validator = \Validator::make($request->all(), [
                        'type' => 'required',
                        'country_code' => 'required',
                        'mobile_number' => 'required'
                            ], [
                        'type' => 'Type is reuired field',
                        'country_code' => trans('messages.F027'),
                        'mobile_number' => trans('messages.F011')
            ]);
            $validator->after(function ($validator) use ($request) {

                $user = User::where(['country_code' => $request->country_code, 'mobile_number' => $request->mobile_number])->first();

                if (empty($user)) {
                    $validator->errors()->add('mobile_number', trans('messages.F013'));
                } else {
                    if ($user->status == 'blocked') {
                        $validator->errors()->add('mobile_number', trans('messages.F039'));
                    }
                    if ($user->status == 'trashed') {
                        $validator->errors()->add('mobile_number', trans('messages.F015'));
                    }
                }
            });
        } else {
            $validator = \Validator::make($request->all(), [
                        'type' => 'required',
                        'email' => 'required'
                            ], [
                        'type' => 'Type is reuired field',
                        'email.required' => trans('messages.F002')
            ]);
            $validator->after(function ($validator) use ($request) {

                $user = User::where('email', $request->email)->first();

                if (empty($user)) {
                    $validator->errors()->add('email', trans('messages.F013'));
                } else {
                    if ($user->status == 'blocked') {
                        $validator->errors()->add('email', trans('messages.F039'));
                    }
                    if ($user->status == 'trashed') {
                        $validator->errors()->add('email', trans('messages.F015'));
                    }
                }
            });
        }



        if ($validator->fails()) {
            $this->status_code = 201;
            $this->message = $validator->errors();
        } else {
            if ($request->type == 2) {
                $user = User::where(['country_code' => $request->country_code, 'mobile_number' => $request->mobile_number])->where('status', 'active')->orWhere('status', 'inactive')->first();
            } else {
                $user = User::where('email', $request->email)->where('status', 'active')->orWhere('status', 'inactive')->first();
            }

            $otpUser['user_id'] = $user['id'];
            $otpUser['otp'] = '111111';

            $otp = OTP::create($otpUser);

            $response = new \Lib\PopulateResponse($otp);
            $this->data = $response->apiResponse();
            $this->status = true;
            $this->message = 'OTP sent successfully.';
        }

        return $this->populateResponse();
    }

    public function updatePassword(Request $request) {
        // dd($request->all());
        $validator = \Validator::make($request->all(), [
                    'new_password' => 'required|min:6|max:15',
                    'confirm_password' => 'required|same:new_password',
                        ], [
                    'new_password.required' => trans('messages.F016'),
                    'new_password.min' => trans('messages.F017'),
                    'new_password.max' => trans('messages.F017'),
                    'confirm_password.required' => trans('messages.F018'),
                    'confirm_password.same' => trans('messages.F019'),
        ]);

        $validator->after(function ($validator) use ($request) {
            
        });

        if ($validator->fails()) {
            $this->status_code = 201;
            $this->message = $validator->errors();
        } else {
            $input['password'] = bcrypt($request->new_password);
            // dd($request->user_id);
            User::where('id', '=', $request->user_id)->update($input);
            $data = [];
            $response = new \Lib\PopulateResponse($data);
            $this->data = $response->apiResponse();
            $this->status = true;
            $this->message = trans('messages.F020');
        }
        // dd("ccc");

        return $this->populateResponse();
    }

    public function changePassword(Request $request) {
        $validatedData = Validator::make($request->all(), [
                    'current_password' => 'required',
                    'new_password' => 'required|min:6',
                    'confirm_password' => 'required|same:new_password'
                        ], [
                    'current_password.required' => trans('validation.required', ['attribute' => 'current password']),
                    'new_password.required' => trans('validation.required', ['attribute' => 'new password']),
//                    'new_password.alpha_dash' => trans('validation.alpha_dash', ['attribute' => 'new password']),
                    'new_password.min' => trans('validation.min', ['attribute' => 'new password']),
                    'confirm_password.required' => trans('validation.required', ['attribute' => 'confirm password']),
                    'confirm_password.same' => trans('validation.same', ['attribute' => 'confirm password'])
        ]);
        $validatedData->after(function ($validatedData) use ($request) {
            if ($request->current_password) {
                $user = User::where(['id' => Auth::guard('api')->id()])->first();
                if (!Hash::check($request->current_password, $user->password)) {
                    $validatedData->errors()->add('current_password', 'incorrect current password');
                }
            }
        });
        if ($validatedData->fails()) {
            $this->status_code = 201;
            $this->message = $validatedData->errors();
        } else {
            $this->status = true;
//            $user = User::where(['id' => Auth::guard('api')->id()])->first();
            $updateUser = [
                'password' => Hash::make($request->new_password)
            ];
            $data = User::where('id', Auth::guard('api')->id())->update($updateUser);
            if ($data) {
                $this->message = 'Password changed successully';
            } else {
                $this->message = 'Some error occured';
                $this->status_code = 201;
            }
        }
        return $this->populateResponse();
    }

    public function profileDetail(Request $request) {
        $user = User::where('id', Auth::guard('api')->id())->first();

        $data = $user;
        $response = new \Lib\PopulateResponse($data);
        $this->data = $response->apiResponse();
        $this->status = true;
        $this->message = trans('messages.F030');

        return $this->populateResponse();
    }

    public function dashboard() {
        $user = User::where('id', Auth::guard('api')->id())->first();

        $data = $user;

        $category_list = $this->getCategoryList(['category_id' => 0]);
        $data['category_list'] = $category_list;
        $data['offers'] = Offer::select('offers.*', 'categories.name as category_name')->where('offers.status', 'active')
                        ->join('categories', 'offers.category_id', '=', 'categories.id')
                        ->limit(5)->offset(0)
                        ->orderBy('offers.id', 'DESC')->get();
        $response = new \Lib\PopulateResponse($data);
        $this->data = $response->apiResponse();
        $this->status = true;
        $this->message = trans('messages.F030');

        return $this->populateResponse();
    }

    public function updateProfile(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'name' => 'required',
                    // 'email'         =>  'email',
                    'country_code' => 'required',
                    // 'password'      =>  'required',
                    'mobile_number' => 'required|numeric',
                        ], [
                    'name.required' => trans('messages.F001'),
                    // 'email.required'        =>  trans('messages.F002'),
                    // 'email.email'           =>  trans('messages.F003'),
                    'country_code.required' => trans('messages.F027'),
                    // 'password.required'     =>  trans('messages.F005'),
                    'mobile_number.required' => trans('messages.F026'),
                    'mobile_number.numeric' => trans('messages.F028'),
        ]);

        $validator->after(function ($validator) use ($request) {
            // $email = User::where('email',$request['email'])->whereNotIn('status',['inactive','trashed'])->where('id','<>',Auth::guard('api')->id())->first();
            // if ($email) {
            //     $validator->errors()->add('email', trans('messages.F006'));
            // }
            // $user_name = User::where(['country_code'=>$request['country_code'],'mobile_number'=>$request['mobile_number']])->whereNotIn('status',['inactive','trashed'])->where('id','<>',Auth::guard('api')->id())/*->where('is_completed','yes')*/->first();
            // if ($user_name) {
            //     $validator->errors()->add('mobile_number', trans('messages.F029'));
            // }
        });

        if ($validator->fails()) {
            // dd($validator->errors());
            $this->status_code = 201;
            $this->message = $validator->errors();
        } else {

            // $addUser['password']        =   bcrypt($request->password);
            $addUser['name'] = $request['name'];
            // $addUser['email']           =   $request['email'];
            $addUser['country_code'] = $request['country_code'];
            $addUser['mobile_number'] = $request['mobile_number'];
//            print_r($request->image);die;
            if ($request->file('image')) {
                $image = $request->file('image');
                $filename = $image->getClientOriginalName();
                $filename = str_replace(" ", "", $filename);
                $imageName = time() . '.' . $filename;
                $return = $image->move(
                        base_path() . '/public/uploads/user/', $imageName);
                $url = url('/uploads/user/');
                $addUser['image'] = $url . '/' . $imageName;
            }


            $data = User::where('id', Auth::guard('api')->id())->update($addUser);
            $data = User::find(Auth::guard('api')->id());
            // $otpUser['user_id']         =   $data['id'];
            // $otp                        =   OTP::create($otpUser);

            $response = new \Lib\PopulateResponse($data);

            $this->data = $response->apiResponse();
            $this->status = true;
            $this->message = trans('messages.F031');
        }
        return $this->populateResponse();
    }

    public function contactUs(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'email' => 'required|email',
                    'subject' => 'required',
                    'details' => 'required',
                    'images.*' => 'nullable|mimes:jpg,jpeg,png',
                        ], [
                    'email.required' => trans('validation.required', ['attribute' => 'email']),
                    'email.email' => trans('validation.email', ['attribute' => 'email']),
                    'subject.required' => trans('messages.F032'),
                    'details.required' => trans('messages.F033'),
                    'images.*.mimes' => trans('messages.F035'),
        ]);

        if ($validator->fails()) {
            $this->status_code = 201;
            $this->message = $validator->errors();
        } else {
            $data['email'] = $request->email;
            $data['subject'] = $request->subject;
            $data['details'] = $request->details;
            $data['user_id'] = (Auth::guard('api')->id() ? Auth::guard('api')->id() : 1);

            $userData = ContactUs::create($data);
            if ($request->images) {
                foreach ($request->images as $file) {
                    $filename = $file->getClientOriginalName();
                    $imageName = time() . '.' . $filename;
                    $return = $file->move(
                            base_path() . '/public/uploads/contact/', $imageName);
                    $url = url('/uploads/contact/');
                    $addCar['image'] = $url . '/' . $imageName;
                    $addCar['contact_us_id'] = $userData['id'];

                    ContactUsImage::create($addCar);
                }
            }

            $response = new \Lib\PopulateResponse($userData);

            $this->data = $response->apiResponse();
            $this->status = true;
            $this->message = trans('messages.F034');
        }

        // dd("ccc");

        return $this->populateResponse();
    }

    public function subjectList() {
        $subjectList = ContactUsSubject::select('id', 'subject_en as subject')->where('status', '1')->get();
        $response = new \Lib\PopulateResponse($subjectList);
        $this->data = $response->apiResponse();
        $this->status = true;
        $this->message = trans('messages.F036');
        return $this->populateResponse();
    }

    public function aboutUs() {
        $content = Content::select('id', 'text_en as text')->where('type', 'about_us')->get()->first();
        $data['content'] = $content;
        return view('content_view')->with($data);
    }

    public function privacyPolicy() {
        $content = Content::select('id', 'text_en as text')->where('type', 'privacy_policy')->get()->first();
        $data['content'] = $content;
        return view('content_view')->with($data);
    }

    public function termsConditons() {
        $content = Content::select('id', 'text_en as text')->where('type', 'terms_conditions')->get()->first();
        $data['content'] = $content;
        return view('content_view')->with($data);
    }

    public function ourServices(Request $request) {
        $data['category'] = "";
        if (isset($request->category_id) && $request->category_id) {
            $category = Categories::select('id as category_id', 'name', 'image', 'multiple_select')->where('id', $request->category_id)->first();
            if ($category) {
                $data['category'] = $category;
            }
        }
        $service_list = $this->getCategoryList($request);
        $data['category_list'] = $service_list;
        $this->status = true;
        $response = new \Lib\PopulateResponse($data);
        $this->data = $response->apiResponse();
        $this->message = trans('messages.F042');
        return $this->populateResponse();
    }

    public function serviceList(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'category_id' => 'required'
                        ], [
                    'category_id.required' => trans('validation.required', ['attribute' => 'category_id']),
        ]);

        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $all_services = [];
            $catgory = Categories::select('id as category_id', 'name', 'image', 'multiple_select')->find($request->category_id);
            if ($catgory) {
                $service_list = Service::where('category_id', $request->category_id)->get();
                if ($service_list) {
                    foreach ($service_list as $service) {
                        $getservice = Service::with(['service_category:id,name', 'service_subcategory:id,name', 'service_images:id,service_id,image'])->where('id', $service->id)->get(['id', 'main_category', 'category_id', 'name', 'description', 'price', 'is_pickup'])->first();
//                        print_r($getservice);die;
                        $getservice->is_cart = 0;
                        $cartCheck = UserCart::where(['user_id' => Auth::guard('api')->id(), 'service_id' => $service->id])->first();
                        if ($cartCheck) {
                            $getservice->is_cart = 1;
                        }
                        array_push($all_services, $getservice);
                    }
                }

                $catgory['service_list'] = $all_services;
            }
            $this->status = true;
            $response = new \Lib\PopulateResponse($catgory);
            $this->data = $response->apiResponse();
            $this->message = trans('messages.F042');
        }
        return $this->populateResponse();
    }

    public function getCategoryList($request) {
        if (isset($request->category_id) && $request->category_id) {
            $categories = Categories::select('id', 'id as category_id', 'name', 'name as value', 'image')->selectRaw("(SELECT COUNT(*) FROM categories WHERE parent_id=category_id AND status='active') as has_subcategory")->where(['parent_id' => $request->category_id, 'status' => 'active'])->get();
        } else {
            $categories = Categories::select('id', 'id as category_id', 'name', 'name as value', 'image')->selectRaw("(SELECT COUNT(*) FROM categories WHERE parent_id=category_id AND status='active') as has_subcategory")->where(['parent_id' => '0', 'status' => 'active'])->get();
        }
        $category_list = [];
        if ($categories) {
            foreach ($categories as $category) {
                if ($category['has_subcategory']) {
                    $category['has_subcategory'] = 1;
                } else {
//                    if (isset($request->category_id) && $request->category_id) {
                    $ifServies = Service::where(['category_id' => $category['category_id'], 'status' => '1'])->get()->toArray();
//                    } else {
//                        $ifServies = Service::where(['category_id' => $category['category_id'], 'subcategory_id' => 0, 'status' => '1'])->get();
//                    }
                    if ($ifServies) {
                        $category['has_subcategory'] = 2;
                    }
                }
                if ($category['has_subcategory']) {
                    if ($category['has_subcategory'] == 2) {
//                        $category['has_subcategory'] = 0;
                    }
                    array_push($category_list, $category);
                }
            }
        }
        return $category_list;
    }

    public function adminSettings() {
        $brand_list = [];
        $brands = Brand::where(['status' => 'active'])->get(['id', 'brand_name', 'image']);
        if ($brands) {
            foreach ($brands as $brand) {
                $brand['cars'] = BrandCar::with('car_models:id,brand_id,car_id,model_name')->where(['brand_id' => $brand->id])->where('status', 'active')->get(['id', 'brand_id', 'car_name']);
//               print_r($brand['brand_cars']);
                array_push($brand_list, $brand);
            }
        }
        $data['brand_list'] = $brand_list;
        $data['cancel_reasons'] = CancelReason::select('id as reason_id', 'reason')->where(['type' => 'user', 'status' => 'active'])->get();
        $this->status = true;
        $response = new \Lib\PopulateResponse($data);
        $this->data = $response->apiResponse();
        $this->message = trans('messages.F044');
        return $this->populateResponse();
    }

    public function addToCart(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'service_id' => 'required'
                        ], [
                    'service_id.required' => trans('validation.required', ['attribute' => 'service_id']),
        ]);
        $validator->after(function ($validator) use ($request) {
            if ($request->service_id) {
                $service = Service::where(['id' => $request->service_id, 'status' => '1'])->first();
                if (!$service) {
                    $this->error_code = "201";
                    $validator->errors()->add('service_id', trans('messages.F043'));
                }
            }
        });

        if ($validator->fails()) {
            $this->status_code = 201;
            $this->message = $validator->errors();
        } else {
            $this->message = "Service added to cart";
            $cartProducts = UserCart::where(['user_id' => Auth::guard('api')->id()])->get()->toArray();
            if (UserCart::where(['user_id' => Auth::guard('api')->id(), 'service_id' => $request->service_id])->first()) {
                $create = true;
            } else {
                $service = Service::where('id', $request->service_id)->first();
                if ($cartProducts) {
                    if (UserCart::where(['user_id' => Auth::guard('api')->id(), 'category_id' => $service->main_category])->get()->toArray()) {
                        $create = UserCart::create([
                                    'user_id' => Auth::guard('api')->id(),
                                    'category_id' => $service->main_category,
                                    'service_id' => $request->service_id,
                        ]);
                    } else {
                        $create = false;
                        $this->status_code = 201;
                        $this->message = "Cannot add multiple category services at same time.";
                    }
                } else {
                    $create = UserCart::create([
                                'user_id' => Auth::guard('api')->id(),
                                'category_id' => $service->main_category,
                                'service_id' => $request->service_id,
                    ]);
                }
            }

            if (!$create && $this->status_code != 201) {
                $this->status_code = 202;
                $this->message = "Some error occured. Try again later.";
            }
            $this->status = true;
        }
        return $this->populateResponse();
    }

    public function removeFromCart(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'service_id' => 'required'
                        ], [
                    'service_id.required' => trans('validation.required', ['attribute' => 'service_id']),
        ]);
        $validator->after(function ($validator) use ($request) {
            if ($request->service_id) {
                $service = Service::where(['id' => $request->service_id, 'status' => '1'])->first();
                if (!$service) {
                    $this->error_code = "201";
                    $validator->errors()->add('service_id', trans('messages.F043'));
                }
            }
        });

        if ($validator->fails()) {
            $this->status_code = 201;
            $this->message = $validator->errors();
        } else {
            $create = UserCart::where(['user_id' => Auth::guard('api')->id(), 'service_id' => $request->service_id])->delete();
            if (!$create) {
                $this->status_code = 202;
                $this->message = "Some error occured. Try again later.";
            } else {
//                $cartProducts = $this->cartProducts();
//                if ($cartProducts) {
//                    $response = new \Lib\PopulateResponse($cartProducts);
//                    $this->data = $response->apiResponse();
//                }
                $this->message = "Service removed from cart.";
            }
            $this->status = true;
        }
        return $this->populateResponse();
    }

    public function myCart() {
        $all_services = [];
        $total_cost = 0;
        $category_id = 0;
        $total_discount = 0;
        $total_paybale_amount = 0;
        $cartProducts = UserCart::where(['user_id' => Auth::guard('api')->id()])->get();
        if ($cartProducts) {
            foreach ($cartProducts as $service) {
                $category_id = $service->category_id;
                $getservice = Service::with(['service_category:id,name', 'service_subcategory:id,name', 'service_images:id,service_id,image'])->where('id', $service->service_id)->get(['id', 'main_category', 'category_id', 'name', 'description', 'price', 'is_pickup'])->first()->toArray();
                $total_cost = $total_cost + $getservice['price'];
                array_push($all_services, $getservice);
            }
        }
        $data['offer_id'] = "0";
        $getOffer = Offer::where('category_id', $category_id)->where('status', 'active')->first();
        if ($getOffer) {
            $total_discount = $getOffer->percentage;
            $data['offer_id'] = $getOffer->id;
        }
        $data['services'] = $all_services;
        $data['service_count'] = count($all_services);
        $data['total_cost'] = round($total_cost, 2);
        $data['total_discount'] = $total_discount;
        if ($total_discount) {
            $data['total_discount'] = round(($total_cost / 100) * $total_discount, 2);
            $total_paybale_amount = $total_cost - ($total_cost / 100) * $total_discount;
        } else {
            $total_paybale_amount = $total_cost;
        }
        $data['pickup_charges'] = 0;
        if ($all_services) {
            $charges = AdditionalCharge::where('type', 'pickup_charges')->first();
            if ($charges) {
                $data['pickup_charges'] = $charges->charges;
                $total_paybale_amount = $total_paybale_amount + $charges->charges;
            }
        }
        $data['tax'] = 0;
        $data['total_paybale_amount'] = round($total_paybale_amount, 2);
        $response = new \Lib\PopulateResponse($data);
        $this->data = $response->apiResponse();
        $this->message = "My Cart";
        $this->status = true;
        return $this->populateResponse();
    }

    public function cartProducts() {
        $all_services = [];
        $cartProducts = UserCart::where(['user_id' => Auth::guard('api')->id()])->get();
        if ($cartProducts) {
            foreach ($cartProducts as $service) {
                $getservice = Service::with(['service_category:id,name', 'service_subcategory:id,name', 'service_images:id,service_id,image'])->where('id', $service->service_id)->get(['id', 'main_category', 'category_id', 'name', 'description', 'price', 'is_pickup'])->toArray();
                array_push($all_services, $getservice);
            }
        }

        return $all_services;
    }

    public function addCar(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'brand_id' => 'required',
                    'car_id' => 'required',
//                    'model_id' => 'required',
                    'model_year' => 'required'
                        ], [
                    'brand_id.required' => trans('validation.required', ['attribute' => 'brand_id']),
                    'car_id.required' => trans('validation.required', ['attribute' => 'car_id']),
//                    'model_id.required' => trans('validation.required', ['attribute' => 'model_id']),
                    'model_year.required' => trans('validation.required', ['attribute' => 'model_year'])
        ]);
        if ($validator->fails()) {
            $this->status_code = 201;
            $this->message = $validator->errors();
        } else {
            $create = UserCar::create([
                        'user_id' => Auth::guard('api')->id(),
                        'brand_id' => $request->brand_id,
                        'car_id' => $request->car_id,
                        'model_id' => $request->model_id,
                        'model_year' => $request->model_year
            ]);

            $this->status = true;
            if ($create) {
                if ($request->file('files')) {
                    $files = $request->file('files');
                    foreach ($files as $file) {
                        $filename = $file->getClientOriginalName();
                        $filename = str_replace(" ", "", $filename);
                        $stringName = $this->my_random_string(explode('.', $filename)[0]);
                        $imageName = $stringName . time() . '.' . (($file->getClientOriginalExtension() == 'jpg' || $file->getClientOriginalExtension() == 'jpeg') ? 'png' : $file->getClientOriginalExtension());
                        $return = $file->move(
                                base_path() . '/public/uploads/user_cars/', $imageName);
                        $url = url('/uploads/user_cars/');
                        $path = $url . '/' . $imageName;
                        CarDocument::create([
                            'user_car_id' => $create->id,
                            'file_path' => $path,
                            'file_type' => $file->getClientOriginalExtension()
                        ]);
                    }
                }
                $this->message = "Car added successfully.";
            } else {
                $this->status_code = 202;
                $this->message = "Some error occured. Try again later.";
            }
        }
        return $this->populateResponse();
    }

    public function myCars() {
        $myCars = UserCar::with('images')
                ->where(['user_id' => Auth::guard('api')->id(), 'user_cars.status' => 'active'])
                ->select('user_cars.*', 'brands.brand_name', 'brands.image as brand_image', 'brand_cars.car_name', 'model_names.model_name')
                ->join('brands', 'brand_id', '=', 'brands.id')
                ->join('brand_cars', 'car_id', '=', 'brand_cars.id')
                ->join('model_names', 'model_id', '=', 'model_names.id')
                ->get();
        $this->message = "My Cars";
        $response = new \Lib\PopulateResponse($myCars);
        $this->data = $response->apiResponse();
        $this->status = true;
        return $this->populateResponse();
    }

    public function deleteCar(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'user_car_id' => 'required'
                        ], [
                    'user_car_id.required' => trans('validation.required', ['attribute' => 'user_car_id'])
        ]);
        if ($validator->fails()) {
            $this->status_code = 201;
            $this->message = $validator->errors();
        } else {
            $delete = UserCar::where(['user_id' => Auth::guard('api')->id(), 'id' => $request->user_car_id])->update(['status' => 'inactive']);
            if ($delete) {
                $this->message = "Car deleted successfully.";
            } else {
                $this->status_code = 202;
                $this->message = "Some error occured. Try again later.";
            }
            $this->status = true;
        }
        return $this->populateResponse();
    }

    public function editCar(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'user_car_id' => 'required',
                    'brand_id' => 'required',
                    'car_id' => 'required',
//                    'model_id' => 'required',
                    'model_year' => 'required'
                        ], [
                    'user_car_id.required' => trans('validation.required', ['attribute' => 'user_car_id']),
                    'brand_id.required' => trans('validation.required', ['attribute' => 'brand_id']),
                    'car_id.required' => trans('validation.required', ['attribute' => 'car_id']),
//                    'model_id.required' => trans('validation.required', ['attribute' => 'model_id']),
                    'model_year.required' => trans('validation.required', ['attribute' => 'model_year'])
        ]);

        $validator->after(function ($validator) use ($request) {
            if ($request->user_car_id) {
                $getCar = UserCar::where(['id' => $request->user_car_id, 'user_id' => Auth::guard('api')->id(), 'status' => 'active'])->first();
                if (!$getCar) {
                    $this->error_code = "201";
                    $validator->errors()->add('user_car_id', "This car is not found.");
                }
            }
        });

        if ($validator->fails()) {
            $this->status_code = 201;
            $this->message = $validator->errors();
        } else {
            $update = UserCar::where(['user_id' => Auth::guard('api')->id(), 'id' => $request->user_car_id])->update(
                    [
                        'brand_id' => $request->brand_id,
                        'car_id' => $request->car_id,
                        'model_id' => $request->model_id,
                        'model_year' => $request->model_year
                    ]
            );
            if ($update) {
                if ($request->remove_image) {
                    $removableimages = explode(',', $request->remove_image);
                    if ($removableimages) {
                        foreach ($removableimages as $image) {
                            CarDocument::where(['user_car_id' => $request->user_car_id, 'id' => $image])->delete();
                        }
                    }
                }
                if ($request->file('files')) {
                    $files = $request->file('files');
                    foreach ($files as $file) {
                        $filename = $file->getClientOriginalName();
                        $filename = str_replace(" ", "", $filename);
                        $stringName = $this->my_random_string(explode('.', $filename)[0]);
                        $imageName = $stringName . time() . '.' . (($file->getClientOriginalExtension() == 'jpg' || $file->getClientOriginalExtension() == 'jpeg') ? 'png' : $file->getClientOriginalExtension());
                        $return = $file->move(
                                base_path() . '/public/uploads/user_cars/', $imageName);
                        $url = url('/uploads/user_cars/');
                        $path = $url . '/' . $imageName;
                        CarDocument::create([
                            'user_car_id' => $request->user_car_id,
                            'file_path' => $path,
                            'file_type' => $file->getClientOriginalExtension()
                        ]);
                    }
                }
                $this->message = "Car details updated successfully.";
            } else {
                $this->status_code = 202;
                $this->message = "Some error occured. Try again later.";
            }
            $this->status = true;
        }
        return $this->populateResponse();
    }

    public function branchList(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'booking_date' => 'required'
                        ], [
                    'booking_date.required' => trans('validation.required', ['attribute' => 'booking date']),
        ]);

        if ($validator->fails()) {
            $this->status_code = 201;
            $this->message = $validator->errors();
        } else {
            $branchList = [];
            $day = date('l', strtotime($request->booking_date));
            $getBranch = Branch::select('id', 'branch_name', 'location', 'latitude', 'longitude', 'working_days', 'working_day_time')->whereRaw("FIND_IN_SET('$day',working_days)")->orderBy('branch_name', 'ASC')->get();
            if ($getBranch) {
                foreach ($getBranch as $branch) {
                    $timings = json_decode($branch->working_day_time);
                    $timing_slots = [];
                    if ($timings) {
                        foreach ($timings as $days => $timing) {
                            if ($day == $days) {
                                $open_time = date('d-m-Y h:i A', strtotime($request->booking_date . ' ' . $timing->open_time));
                                $close_time = date('d-m-Y h:i A', strtotime($request->booking_date . ' ' . $timing->close_time));
                                for ($i = strtotime($open_time); $i < strtotime($close_time); $i = $i + 1800) {
                                    array_push($timing_slots, date('h:i A', $i));
                                }
                            }
                        }
                    }
                    $branch->working_day_time = $timing_slots;
                    array_push($branchList, $branch);
                }
            }
            $this->message = "Branch List";
            $response = new \Lib\PopulateResponse($branchList);
            $this->data = $response->apiResponse();
            $this->status = true;
        }
        return $this->populateResponse();
    }

    public function bookService(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'user_car_id' => 'required',
                    'booking_date' => 'required',
                    'booking_time' => 'required',
                    'payment_mode' => 'required',
                    'price' => 'required',
                    'discount' => 'required',
                    'offer_id' => 'required_if:discount,>,0',
                    'pick_drop_charge' => 'required',
                    'tax' => 'required',
                    'total_amount' => 'required',
                    'is_pickup' => 'required',
                    'pickup_location' => 'required_if:is_pickup,==,1',
                    // 'pickup_lat'=>'required_if|is_pickup,==,1',
                    // 'pickup_lng'=>'required_if|is_pickup,==,1',
                    'dropoff_location' => 'required_if:is_pickup,==,1',
                    // 'dropoff_lat'=>'required_if|is_pickup,==,1',
                    // 'dropoff_lng'=>'required_if|is_pickup,==,1',
                    'branch_id' => 'required',
                        ], [
                    'user_car_id.required' => trans('validation.required', ['attribute' => 'user_car_id']),
                    'booking_date.required' => trans('validation.required', ['attribute' => 'booking_date']),
                    'booking_time.required' => trans('validation.required', ['attribute' => 'booking_time']),
                    'payment_mode.required' => trans('validation.required', ['attribute' => 'payment_mode']),
                    'price.required' => trans('validation.required', ['attribute' => 'price']),
                    'discount.required' => trans('validation.required', ['attribute' => 'discount']),
                    'offer_id.required_if' => trans('validation.required', ['attribute' => 'offer_id']),
                    'pick_drop_charge.required' => trans('validation.required', ['attribute' => 'pick_drop_charge']),
                    'tax.required' => trans('validation.required', ['attribute' => 'tax']),
                    'total_amount.required' => trans('validation.required', ['attribute' => 'total_amount']),
                    'is_pickup.required' => trans('validation.required', ['attribute' => 'is_pickup']),
                    'pickup_location.required_if' => trans('validation.required', ['attribute' => 'pickup_location']),
                    // 'pickup_lat.required_if' => trans('validation.required', ['attribute' => 'pickup_lat']),
                    // 'pickup_lng.required_if' => trans('validation.required', ['attribute' => 'pickup_lng']),
                    'dropoff_location.required_if' => trans('validation.required', ['attribute' => 'dropoff_location']),
                    // 'dropoff_lat.required_if'=>trans('validation.required', ['attribute' => 'dropoff_lat']),
                    // 'dropoff_lng.required_if'=>trans('validation.required', ['attribute' => 'dropoff_lng']),
                    'branch_id.required' => trans('validation.required', ['attribute' => 'branch_id']),
        ]);

        if ($validator->fails()) {
            $this->error_code = 201;
            $this->message = $validator->errors();
        } else {
            $insertArr = [
                'user_id' => Auth::guard('api')->id(),
                'user_car_id' => $request->user_car_id,
                'booking_datetime' => strtotime($request->booking_date . ' ' . $request->booking_time),
                'branch_id' => $request->branch_id,
                // 'booking_time' => $request->booking_time,
                'price' => $request->price,
                'discount' => $request->discount,
                'is_pickup' => $request->is_pickup,
                'pick_drop_charge' => $request->pick_drop_charge,
                'tax' => $request->tax,
                'amount' => $request->total_amount,
                'offer_id' => $request->offer_id,
                'payment_mode' => $request->payment_mode,
            ];

            if ($request->is_pickup == 1) {
                $insertArr['pickup_location'] = $request->pickup_location;
                $insertArr['dropoff_location'] = $request->dropoff_location;
                $insertArr['pickup_lat'] = $request->pickup_lat;
                $insertArr['dropoff_lat'] = $request->dropoff_lat;
                $insertArr['pickup_lng'] = $request->pickup_lng;
                $insertArr['dropoff_lng'] = $request->dropoff_lng;
            }


            $book = Booking::create($insertArr);
            if ($book) {
                $cartProducts = UserCart::where(['user_id' => Auth::guard('api')->id()])->get();
                if ($cartProducts) {
                    foreach ($cartProducts as $service) {
                        $serviceDetail = Service::where('id', $service->service_id)->where('status', '1')->first();
                        if ($serviceDetail) {
                            $insertService = [
                                'booking_id' => $book->id,
                                'service_id' => $service->service_id,
                                'price' => $serviceDetail->price,
                                'discount' => 0,
                                'amount' => $serviceDetail->price
                            ];
                            BookingService::create($insertService);
                        }
                    }
                }

                $this->message = "Service Booked successfully";
                $response = new \Lib\PopulateResponse(['booking_id' => $book->id]);
                $clearUserCart = UserCart::where(['user_id' => Auth::guard('api')->id()])->delete();
                $this->data = $response->apiResponse();
                $this->status = true;
            } else {
                $this->message = "Service booking cannot be completed please try again later";
                $this->status = true;
                $this->status_code = 201;
            }
        }
        return $this->populateResponse();
    }

    public function myBookings() {
        $bookingList = [];
        $bookings = Booking::where('user_id', Auth::guard('api')->id())->orderBy('id', 'DESC')->get();
        if ($bookings) {
            foreach ($bookings as $booking) {
                $getService = BookingService::where('booking_id', $booking->id)->first();
                if ($getService) {
                    $serviceDetails = Service::with(['service_images:id,service_id,image'])->where('id', $getService->service_id)->get(['id', 'main_category', 'category_id', 'name', 'description', 'price', 'is_pickup'])->first();
                    if ($serviceDetails) {
                        $booking->service_name = $serviceDetails->name;
                        if ($serviceDetails->service_images) {
                            $booking->service_image = $serviceDetails->service_images[0]['image'];
                        } else {
                            $booking->service_image = "";
                        }
                    }
                } else {
                    $booking->service_name = "";
                    $booking->service_image = "";
                }
                $booking->booking_datetime = date('d-m-Y h:i A', $booking->booking_datetime);
                array_push($bookingList, $booking);
            }
        }
        $this->message = "My Bookings";
        $this->status = true;
        $response = new \Lib\PopulateResponse($bookingList);
        $this->data = $response->apiResponse();
        return $this->populateResponse();
    }

    public function bookingDetails(Request $request) {

        $validator = \Validator::make($request->all(), [
                    'booking_id' => 'required'
                        ], [
                    'booking_id.required' => trans('validation.required', ['attribute' => 'booking_id'])
        ]);

        if ($validator->fails()) {
            $this->error_code = 201;
            $this->message = $validator->errors();
        } else {
            $booking = Booking::where('id', $request->booking_id)->where('user_id', Auth::guard('api')->id())->first();
            if ($booking) {
                $servicesList = [];
                $services = BookingService::where(['booking_id' => $request->booking_id])->get();
                if ($services) {
                    foreach ($services as $service) {
                        $service->name = "";
                        $service->image = "";
                        $service->description = "";
                        $service->main_category = "";
                        $serviceDetail = Service::with('service_category', 'service_images')->where('id', $service->service_id)->first();
                        if ($serviceDetail) {
                            $service->name = $serviceDetail->name;
                            if (isset($serviceDetail->service_images[0])) {
                                $service->image = $serviceDetail->service_images[0]['image'];
                            }
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
                        $booking->branch = $branch->branch_name . ' (' . $branch->location . ')';
                        $booking->branch_number = $branch->contact_number;
                    } else {
                        $booking->branch = "N/A";
                        $booking->branch_number = "N/A";
                    }
                } else {
                    $booking->branch = "N/A";
                    $booking->branch_number = "N/A";
                }
                $booking->cancellation_request_id = "0";
                $booking->cancellation_request_status = "";
                $is_cancellation_request = CancellationRequest::where('booking_id', $request->booking_id)->orderBy('id','DESC')->first();
                if ($is_cancellation_request && ($is_cancellation_request->status=='0' || $is_cancellation_request->status == '2')) {
                    $booking->cancellation_request_id = $is_cancellation_request->id;
                    $booking->cancellation_request_status = $is_cancellation_request->status;
                }
                $this->message = "Booking Details";
                $this->status = true;
                $response = new \Lib\PopulateResponse($booking);
                $this->data = $response->apiResponse();
            } else {
                $this->message = "Booking not found";
                $this->error_code = 201;
            }
        }
        return $this->populateResponse();
    }

    public function cancelBooking(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'booking_id' => 'required',
                    'reason_id' => 'required'
                        ], [
                    'booking_id.required' => trans('validation.required', ['attribute' => 'booking_id']),
                    'reason_id.required' => trans('validation.required', ['attribute' => 'reason_id'])
        ]);

        $validator->after(function ($validator) use ($request) {
            if ($request->booking_id) {
                $getBooking = Booking::where('id', $request->booking_id)->where('user_id', Auth::guard('api')->id())->first();
                if (!$getBooking) {
                    $this->error_code = 201;
                    $validator->errors()->add('booking_id', "This booking is not found.");
                }
            }
        });

        if ($validator->fails()) {
            $this->error_code = 201;
            $this->message = $validator->errors();
        } else {
//            $updateBooking = [
//                'cancel_reason' => $request->reason_id,
//                'status' => '4'
//            ];
//            $update = Booking::where('id', $request->booking_id)->where('user_id', Auth::guard('api')->id())->where('status', '0')->update($updateBooking);
//            if ($update) {
//                $this->message = "Booking cancelled successfully";
//                $this->status = true;
//            } else {
//                $this->message = "Booking can not be cancelled";
//                $this->error_code = 201;
//            }

            $insert = CancellationRequest::create(['booking_id' => $request->booking_id, 'reason_id' => $request->reason_id]);
            if ($insert) {
                $this->message = "Booking cancellation request sent to admin";
                $this->status = true;
            } else {
                $this->message = "Booking can not be cancelled at this moment. Please contact admin or try again later.";
                $this->error_code = 202;
            }
        }
        return $this->populateResponse();
    }

    public function cancelCancellationRequest(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'booking_id' => 'required',
                    'request_id' => 'required',
                        ], [
                    'booking_id.required' => trans('validation.required', ['attribute' => 'booking_id']),
                    'request_id.required' => trans('validation.required', ['attribute' => 'request_id'])
        ]);

        $validator->after(function ($validator) use ($request) {
            if ($request->request_id) {
                $getRequest = CancellationRequest::where('id', $request->request_id)->first();
                if (!$getRequest) {
                    $this->error_code = 201;
                    $validator->errors()->add('request_id', "This request is not found.");
                }else{
                    if($getRequest->status == '1'){
                        $this->error_code = 202;
                        $validator->errors()->add('request_id', "Your cancellation request has been accepted by admin.");
                    }
                }
            }
        });

        if ($validator->fails()) {
            $this->error_code = 201;
            $this->message = $validator->errors();
        } else {
            $cancel = CancellationRequest::where('id', $request->request_id)->update(['status' => '3']);
            if ($cancel) {
                $this->message = "Booking cancellation request cancelled";
                $this->status = true;
            } else {
                $this->message = "Request can not be cancelled at this moment.Please contact admin or try again later.";
                $this->error_code = 202;
            }
        }
        return $this->populateResponse();
    }

    public function offerList() {
        $offers = Offer::select('offers.*', 'categories.name as category_name')->where('offers.status', 'active')
                        ->join('categories', 'offers.category_id', '=', 'categories.id')
                        ->orderBy('offers.id', 'DESC')->get();
        $this->message = "Offer List";
        $this->status = true;
        $response = new \Lib\PopulateResponse($offers);
        $this->data = $response->apiResponse();
        return $this->populateResponse();
    }

    public function updatePaymentStatus(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'booking_id' => 'required'
                        ], [
                    'booking_id.required' => trans('validation.required', ['attribute' => 'booking_id'])
        ]);
        $validator->after(function ($validator) use ($request) {
            if ($request->booking_id) {
                $getBooking = Booking::where('id', $request->booking_id)->where('user_id', Auth::guard('api')->id())->first();
                if (!$getBooking) {
                    $this->error_code = 201;
                    $validator->errors()->add('booking_id', "This booking is not found. Transaction terminated");
                }
            }
        });

        if ($validator->fails()) {
            $this->error_code = 201;
            $this->message = $validator->errors();
        } else {
            $updateBooking = [
                'payment_status' => $request->payment_status
            ];
            $update = Booking::where('id', $request->booking_id)->where('user_id', Auth::guard('api')->id())->update($updateBooking);
            if ($update) {
                $this->message = "Booking payment completed successfully";
                $this->status = true;
            } else {
                $this->message = "Payment status cannot be updated, some error occured.";
                $this->error_code = 201;
            }
        }
        return $this->populateResponse();
    }

}
