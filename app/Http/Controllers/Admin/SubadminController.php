<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Permission;
use App\Models\Priviledge;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubadminController extends Controller {

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
            if(!in_array(7,$details)){
                return redirect('admin/unauthenticated');
            }
            return $next($request);
        });
    }

    public function index(Request $request) {
        $data['admins'] = User::where('id', '<>', 1)->where('type', 'admin')->orderBy('id', 'DESC')->get();
        return view('admin.subadmin_list')->with($data);
    }

    public function add(Request $request) {
        $data['privilegde'] = Priviledge::where('status', 'active')->get();
        $validator = \Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'required|email',
                    'password' => 'required|min:8'
                        ], [
                    'name.required' => trans('validation.required', ['attribute' => 'Name']),
                    'email.required' => trans('validation.required', ['attribute' => 'Email']),
                    'email.email' => trans('validation.email', ['attribute' => 'Email']),
                    'password.required' => trans('validation.required', ['attribute' => 'Password']),
                    'password.min' => trans('validation.min', ['attribute' => 'Password'])
        ]);

        $validator->after(function ($validator) use (&$user, $request) {
            $user = User::where('email', $request->email)->where('type', 'admin')->first();
            if ($user) {
                $validator->errors()->add('email', 'This email is already registered.');
            }
        });

        if ($validator->fails()) {
            if (isset($request['submit'])) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->input());
            } else {
                return view('admin.add_subadmin')->with($data);
            }
        } else {
            $insert = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'type' => 'admin'
            ];
//            print_r($_POST);die;
            $create = User::create($insert);
            if ($create) {
                Permission::create([
                    'admin_id' => $create->id,
                    'pass_key' => $request->password,
                    'allowed_permission' => implode(',', $request->permission),
                    'status' => 'active'
                ]);
                return redirect('admin/subadmin-list')->with('success', 'Subadmin added successfully');
            } else {
                return redirect()->back()->withInput($request->input())->with('error', 'Some error occured while adding Subadmin.');
            }
        }
    }

    public function show($id = null) {
        $id = base64_decode($id);
        $admin = User::where('id', $id)->where('type', 'admin')->first();
        if ($admin) {
            $all_permission = [];
            $getPermissions = Permission::where('admin_id', $id)->first();
            if ($getPermissions) {
                $admin['pass_key'] = $getPermissions->pass_key;
                if ($getPermissions->allowed_permission) {
                    $permissions = explode(',', $getPermissions->allowed_permission);
                    foreach ($permissions as $permission) {
                        $getName = Priviledge::where('id', $permission)->first();
                        if ($getName) {
                            array_push($all_permission, $getName);
                        }
                    }
                }
            } else {
                $admin['pass_key'] = "";
            }
            $admin['permissions'] = $all_permission;
            $data['admin'] = $admin;
            return view('admin.subadmin_detail')->with($data);
        } else {
            return redirect()->back()->with('error', 'Sub admin not found.');
        }
    }

    public function edit_subadmin(Request $request, $id = null) {
        $id = base64_decode($id);
        $admin = User::where('id', $id)->where('type', 'admin')->first();
        if ($admin) {

            $getPermissions = Permission::where('admin_id', $id)->first();
            if ($getPermissions) {
                if ($getPermissions->allowed_permission) {
                    $permissions = explode(',', $getPermissions->allowed_permission);
                } else {
                    $permissions = [];
                }
            } else {
                $permissions = [];
            }
            $admin['permissions'] = $permissions;
            $data['admin'] = $admin;
            $data['privilegde'] = Priviledge::where('status', 'active')->get();
            $validator = \Validator::make($request->all(), [
                        'name' => 'required',
//                        'email' => 'required|email',
                        'password' => 'nullable|min:8'
                            ], [
                        'name.required' => trans('validation.required', ['attribute' => 'Name']),
//                        'email.required' => trans('validation.required', ['attribute' => 'Email']),
//                        'email.email' => trans('validation.email', ['attribute' => 'Email']),
//                        'password.required' => trans('validation.required', ['attribute' => 'Password']),
                        'password.min' => trans('validation.min', ['attribute' => 'Password'])
            ]);

//            $validator->after(function ($validator) use (&$user, $request) {
//                $user = User::where('email', $request->email)->where('type', 'admin')->first();
//                if ($user) {
//                    $validator->errors()->add('email', 'This email is already registered.');
//                }
//            });

            if ($validator->fails()) {
                if (isset($request['submit'])) {
                    return redirect()->back()->withErrors($validator->errors())->withInput($request->input());
                } else {
                    return view('admin.edit_subadmin')->with($data);
                }
            } else {
                $update = [
                    'name' => $request->name,
//                    'email' => $request->email,
//                    'password' => Hash::make($request->password),
//                    'type' => 'admin'
                ];
                if ($request->password) {
                    $update['password'] = Hash::make($request->password);
                }
//            print_r($_POST);die;
                $create = User::where('id', $id)->update($update);
                if ($create) {
                    $updateArr = [
//                        'admin_id' => $create->id,
//                        'pass_key' => ($request->password ? $request->password : ''),
                        'allowed_permission' => implode(',', $request->permission),
//                        'status' => 'active'
                    ];
                    if($request->password){
                        $updateArr['pass_key']=$request->password;
                    }
                    Permission::where('admin_id', $id)->update($updateArr);
                    return redirect('admin/subadmin-list')->with('success', 'Subadmin updated successfully');
                } else {
                    return redirect()->back()->withInput($request->input())->with('error', 'Some error occured while updating Subadmin.');
                }
            }
        } else {
            return redirect()->back()->with('error', 'Sub admin not found.');
        }
    }

}
