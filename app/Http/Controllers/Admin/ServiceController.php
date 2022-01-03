<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\OTP;
use Auth;
use DB;
use Response;
use Session;
use App\Http\Requests\UsersRequest as StoreRequest;
use App\Http\Requests\UsersRequest as UpdateRequest;
use App\Http\Controllers\CrudOverrideController;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Categories;
use App\Models\ServiceImage;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class ServiceController extends Controller {

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
            if (!in_array(4, $details)) {
                return redirect('admin/unauthenticated');
            }
            return $next($request);
        });
    }

    public function index(Request $request) {
        $servicesList = [];
        $services = Service::select(['id', 'category_id', 'main_category', 'name', 'description', 'price', 'is_pickup', 'status'])->get();
//        if($services){
//            foreach($services as $service){
//                $serviced=Service::with('service_category')->where('category_id',$service->main_category)->first();
////                echo '<pre>';print_r($serviced);
//                array_push($servicesList,$serviced);
//            }
//        }
        $data['services'] = $services;
//        echo '<pre>';print_r($services);exit;
        return view('admin.service.service_list')->with($data);
    }

    public function add(Request $request) {
        $category = DB::table('categories')
                ->where('parent_id', 0)
                ->get();
        $data['categories'] = $category;
        $subcategory = DB::table('categories')
                ->where('parent_id', '>', 0)
                ->get();

        $data['categories'] = $category;
        $data['subcategories'] = $subcategory;
        return view('admin.service.add_service')->with($data);
    }

    public function show(Request $request, $id = null) {
        $id = base64_decode($id);
        $service = Service::find($id);
        if ($service) {
            $category = Categories::find($service->category_id);
            if ($category) {
                $service->category_name = $category->name;
                if ($category->parent_id) {
                    $parent_1 = Categories::find($category->parent_id);
                    $service->category_name = $parent_1->name . '>>' . $service->category_name;
                    if ($parent_1->parent_id) {
                        $parent_2 = Categories::find($parent_1->parent_id);
                        $service->category_name = $parent_2->name . '>>' . $service->category_name;
                        if ($parent_2->parent_id) {
                            $parent_3 = Categories::find($parent_2->parent_id);
                            $service->category_name = $parent_3->name . '>>' . $service->category_name;
                        }
                    }
                }
            } else {
                $service->category_name = 'N/A';
            }
            $subcategory = Categories::find($service->subcategory_id);
            if ($subcategory) {
                $service->subcategory_name = $subcategory->name;
            } else {
                $service->subcategory_name = 'N/A';
            }

            $service['images'] = ServiceImage::where('service_id', $id)->get();
//            $service['category_name'] = !empty($service->getServiceCategory) ? $service->getServiceCategory->name : 'N/A';      
            $data['service'] = $service;
            return view('admin.service.service_detail')->with($data);
        } else {
            return redirect('admin/service-management')->with('error', 'Service not found');
        }
    }

    public function store(Request $request) {

        $insert_arr = [
            'name' => ucwords($request->input('service_name_en')),
            'name_ar' => $request->input('service_name_ar'),
            'description' => ucwords($request->input('description')),
            'description_ar' => ucwords($request->input('description_ar')),
            'is_pickup' => ($request->input('is_pickup') ? $request->input('is_pickup') : "0"),
            'price' => $request->input('price'),
            'status' => '1'
        ];

        if ($request->input('cat_4')) {
            $insert_arr['category_id'] = $request->input('cat_4');
        } else if ($request->input('cat_3')) {
            $insert_arr['category_id'] = $request->input('cat_3');
        } else if ($request->input('cat_2')) {
            $insert_arr['category_id'] = $request->input('cat_2');
        } else {
            $insert_arr['category_id'] = $request->input('cat_1');
        }
        $insert_arr['main_category'] = $request->input('cat_1');
//        echo '<pre>';
//        print_r($_POST);
//        echo '<pre>';
//        print_r($insert_arr);
//        die;
        $add = Service::create($insert_arr);
        if ($add) {
            $serviceImage['service_id'] = $add->id;
            if ($request->images) {
                foreach ($request->images as $file) {
                    $filename = $file->getClientOriginalName();
                    $imageName = time() . '.' . $filename;
                    $return = $file->move(
                            base_path() . '/public/uploads/services/', $imageName);
                    $url = url('/uploads/services/');
                    $serviceImage['image'] = $url . '/' . $imageName;

                    ServiceImage::create($serviceImage);
                }
            }
            return redirect('admin/service-management')->with('success', 'Service added succesfully');
        }
        return back()->withInput()->with('error', 'Error while adding Service');
    }

    public function edit(Request $request, $id = null) {
        $id = base64_decode($id);
        $service = Service::find($id);
        if ($service) {
//            $data['second_parent_id'] = "";
//            $data['third_parent_id'] = "";
            $category = Categories::where('parent_id', 0)->get();
            $data['categories'] = $category;
//            $data['level'] = 1;
//            if ($service->category_id != $service->main_category) {
//                $sub_category = Categories::where('parent_id', $service->main_category)->get()->toArray();
//                $arr = [];
//                if ($sub_category) {
//                    $data['level'] = 2;
//
//                    foreach ($sub_category as $sub) {
//                        $sub_category = Categories::where('parent_id', $sub['id'])->get()->toArray();
//                        if ($service->category_id == $sub['id']) {
//                            $sub['selected'] = 1;
//                            $data['level'] = 3;
//                            $data['second_parent_id'] = $sub['id'];
//                        } else {
//                            $sub['selected'] = 0;
//                        }
//                        $array = [];
//                        if ($sub_category) {
//
//                            foreach ($sub_category as $s_cat) {
//                                if ($service->category_id == $s_cat['id']) {
//                                    $s_cat['selected'] = 1;
//                                    $data['level'] = 4;
////                                    $data['third_parent_id'] = $s_cat['id'];
//                                    $data['second_parent_id'] = $sub['id'];
//                                } else {
//                                    $s_cat['selected'] = 0;
//                                }
//                                $sub_cat = Categories::where('parent_id', $s_cat['id'])->get()->toArray();
//                                $s_array = [];
//                                if ($sub_cat) {
//
//                                    foreach ($sub_cat as $s) {
//                                        if ($service->category_id == $s['id']) {
//                                            $s['selected'] = 1;
//                                            $data['third_parent_id'] = $s_cat['id'];
//                                            $data['second_parent_id'] = $sub['id'];
//                                        } else {
//                                            $s['selected'] = 0;
//                                        }
//                                        array_push($s_array, $s);
//                                    }
//                                    $s_cat['sub_category'] = $s_array;
//                                }
//                            }
//                            array_push($array, $s_cat);
//                        }
//                        $sub['sub_category'] = $array;
//                        array_push($arr, $sub);
//                    }
//                }
//                $subcategory = $arr;
//            } else {
//                $subcategory = [];
//            }
            $category_level = [];
            
            for ($i = $service->category_id, $j = 1; $i > 0, $j <= 4; $j++) {
                $data['levels'] = $j;
                $category = Categories::where('id', $i)->get()->first();
                if ($category) {
                    if ($j == 1) {
                        $category['siblings'] = Categories::where('parent_id', $category->parent_id)->get();
                    } else {
                        $category['siblings'] = [];
                    }
                    array_push($category_level, $category);
                    $i = $category->parent_id;
                }
            }
            $data['levels']=count($category_level);
            $data['category_level']= array_reverse($category_level);
//            echo '<pre>';
//            print_r($data);
//            die;
            $data['categories'] = $category;
//            $data['subcategories'] = $subcategory;
            $service['images'] = ServiceImage::where('service_id', $id)->get();
            $data['service'] = $service;

            return view('admin.service.edit_service')->with($data);
        } else {
            return redirect('admin/service-management')->with('error', 'Service not found');
        }
    }

    public function update(Request $request, $id = null) {
        $id = base64_decode($id);
        $service_images = ServiceImage::where('service_id', $id)->get();
        $insert_arr = [
            'name' => ucwords($request->input('service_name_en')),
            'name_ar' => $request->input('service_name_ar'),
//            'category_id' => $request->input('category_id'),
//            'main_category' => $request->input('cat_1'),
            'description' => ucwords($request->input('description')),
            'description_ar' => ucwords($request->input('description_ar')),
            'is_pickup' => ($request->input('is_pickup') ? $request->input('is_pickup') : "0"),
            'price' => $request->input('price')
        ];
        if ($request->input('cat_4')) {
            $insert_arr['category_id'] = $request->input('cat_4');
        } else if ($request->input('cat_3')) {
            $insert_arr['category_id'] = $request->input('cat_3');
        } else if ($request->input('cat_2')) {
            $insert_arr['category_id'] = $request->input('cat_2');
        } else {
            $insert_arr['category_id'] = $request->input('cat_1');
            $insert_arr['main_category'] = $request->input('cat_1');
        }

        $serviceImage['service_id'] = $id;
        if ($request->images) {
            foreach ($request->images as $k => $file) {
                $filename = $file->getClientOriginalName();
                $imageName = time() . '.' . $filename;
                $return = $file->move(
                        base_path() . '/public/uploads/services/', $imageName);
                $url = url('/uploads/services/');
                if ($service_images && isset($service_images[$k])) {
                    ServiceImage::where(['id' => $service_images[$k]['id']])->update(['image' => $url . '/' . $imageName]);
                } else {
                    $serviceImage['image'] = $url . '/' . $imageName;
                    ServiceImage::create($serviceImage);
                }
            }
        }

        $update = Service::where('id', $id)->update($insert_arr);
        if ($update) {
            return redirect("admin/service-detail/" . base64_encode($id))->with('success', 'Service updated succesfully');
        }
        return back()->withInput()->with('error', 'Error while updating Service');
    }

    public function change_service_status(Request $request) {
        $id = $request->input('id');
        $status = $request->input('action');
        $update = Service::find($id)->update(['status' => $status]);
        if ($update) {
            return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
        } else {
            return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
        }
    }

    protected function uploadFile($request, $fileName, $path) {
        $return = false;
        if ($request->hasFile($fileName)) :
            $file = $request->file($fileName);
            $fullName = $file->getClientOriginalName();
            $stringName = $this->my_random_string(explode('.', $fullName)[0]);
            $fileName = $stringName . time() . '.' . (($file->getClientOriginalExtension() == 'jpg' || $file->getClientOriginalExtension() == 'jpeg') ? 'png' : $file->getClientOriginalExtension());
            $destinationPath = public_path($path);
            $check = $file->move($destinationPath, $fileName);
            $return = $check ? $fileName : false;
        endif;
        return $return;
    }

}
