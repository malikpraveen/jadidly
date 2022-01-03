<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\BrandCar;
use App\Models\ModelName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
//use Symfony\Component\Console\Input\Input;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Carbon\Carbon;

class CarsController extends Controller {

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
            if(!in_array(6,$details)){
                return redirect('admin/unauthenticated');
            }
            return $next($request);
        });
        
    }

    public function brand_list() {
        $brands = Brand::get();
        $data['brands'] = $brands;
        return view('admin.car.brand_list')->with($data);
    }

    public function car_list() {
        $brands = Brand::where('status', 'active')->get();
        $brandcars = BrandCar::select('brand_cars.*', 'brands.brand_name')->join('brands', 'brand_id', '=', 'brands.id')->get();
        $data['cars'] = $brandcars;
        $data['brands'] = $brands;
        return view('admin.car.add_car_name')->with($data);
    }

    public function model_list() {
        $brands = Brand::with('brand_cars')->where(['brands.status' => 'active'])->get();
        $models = ModelName::select('model_names.*', 'brand_cars.car_name', 'brands.brand_name')->join('brand_cars', 'car_id', '=', 'brand_cars.id')->join('brands', 'model_names.brand_id', '=', 'brands.id')->get();
        $data['models'] = $models;
        $data['brands'] = $brands;
        return view('admin.car.model_list')->with($data);
    }

    public function change_status(Request $request) {
        $id = $request->input('id');
        $status = $request->input('action');
        $type = $request->input('type');
        if ($type == 'brands') {
            $update = Brand::where('id', $id)->update(['status' => $status]);
        } else if ($type == 'brand_cars') {
            $update = BrandCar::where('id', $id)->update(['status' => $status]);
        } else if ($type == 'model_names') {
            $update = ModelName::where('id', $id)->update(['status' => $status]);
        } else {
            $update = true;
        }
        if ($update) {
            return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
        } else {
            return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
        }
    }

    public function brand_store(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'brand_name' => 'required',
                    'brand_name_ar' => 'required',
                    'image' => 'required|dimensions:min_width=150,min_height=200,max_width=250,max_height=250',
                        ], [
                    'brand_name.required' => trans('validation.required', ['attribute' => 'Brand Name']),
                    'brand_name_ar.required' => trans('validation.required', ['attribute' => 'Brand Name (Ar)']),
                    'image.required' => trans('validation.required', ['attribute' => 'Brand Icon']),
                    'image.dimensions' => trans('validation.dimensions', ['attribute' => 'Brand Icon']),
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->input());
        } else {
            $image = "";
            if ($request->image) {
                $image = $this->upload_image('brands', $request->image);
            }
            $add = Brand::create([
                        'brand_name' => ucwords($request->input('brand_name')),
                        'brand_name_ar' => $request->input('brand_name_ar'),
                        'image' => $image
            ]);
            if ($add) {
                return redirect()->back()->with('success', 'Brand added successfully.');
            } else {
                return redirect()->back()->with('error', 'Some error occurred while adding brand');
            }
        }
    }

    public function car_store(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'brand_id' => 'required',
                    'car_name' => 'required',
                    'car_name_ar' => 'required'
                        ], [
                    'brand_id.required' => trans('validation.required', ['attribute' => 'Brand']),
                    'car_name.required' => trans('validation.required', ['attribute' => 'Car Name']),
                    'car_name_ar.required' => trans('validation.required', ['attribute' => 'Car Name Ar'])
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->input());
        } else {
            $add = BrandCar::create([
                        'brand_id' => $request->input('brand_id'),
                        'car_name' => ucwords($request->input('car_name')),
                        'car_name_ar' => $request->input('car_name_ar')
            ]);
            if ($add) {
                return redirect()->back()->with('success', 'Car added successfully.');
            } else {
                return redirect()->back()->with('error', 'Some error occurred while adding car');
            }
        }
    }

    public function model_store(Request $request) {
        $validator = \Validator::make($request->all(), [
                    'brand_id' => 'required',
                    'car_id' => 'required',
                    'model_name' => 'required',
                    'model_name_ar' => 'required'
                        ], [
                    'brand_id.required' => trans('validation.required', ['attribute' => 'Brand']),
                    'car_id.required' => trans('validation.required', ['attribute' => 'Car']),
                    'model_name.required' => trans('validation.required', ['attribute' => 'Model Name']),
                    'model_name_ar.required' => trans('validation.required', ['attribute' => 'Model Name Ar'])
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->input());
        } else {
            $add = ModelName::create([
                        'brand_id' => $request->input('brand_id'),
                        'car_id' => $request->input('car_id'),
                        'model_name' => ucwords($request->input('model_name')),
                        'model_name_ar' => $request->input('model_name_ar')
            ]);
            if ($add) {
                return redirect()->back()->with('success', 'Model added successfully.');
            } else {
                return redirect()->back()->with('error', 'Some error occurred while adding model');
            }
        }
    }

    public function edit_brand($id = null) {
        $id = base64_decode($id);
        $brand = Brand::where('id', $id)->first();
        if ($brand) {
            $data['brand'] = $brand;
            return view('admin.car.edit_brand')->with($data);
        } else {
            return redirect()->back()->with('error', 'Brand not found');
        }
    }

    public function edit_car($id = null) {
        $id = base64_decode($id);
        //return $id;
        $brands = Brand::where('status', 'active')->get();
        $car = BrandCar::where('id', $id)->first();
        if ($car) {
            $data['brands'] = $brands;
            $data['car'] = $car;
           // return $data;
            return view('admin.car.edit_car')->with($data);
        } else {
            return redirect()->back()->with('error', 'Brand Car not found');
        }
    }

    public function edit_model($id = null) {
        $id = base64_decode($id);
        $model = ModelName::where('id', $id)->first();
        if ($model) {
            $brands = Brand::with('brand_cars')->where(['brands.status' => 'active'])->get();
            $data['model'] = $model;
            $data['brands'] = $brands;
            return view('admin.car.edit_model')->with($data);
        } else {
            return redirect()->back()->with('error', 'Model not found');
        }
    }

    public function brand_update(Request $request, $id = null) {
        $id = base64_decode($id);
        $validator = \Validator::make($request->all(), [
                    'brand_name' => 'required',
                    'brand_name_ar' => 'required',
                    'image' => 'dimensions:min_width=150,min_height=200,max_width=250,max_height=250',
                        ], [
                    'brand_name.required' => trans('validation.required', ['attribute' => 'Brand Name']),
                    'brand_name_ar.required' => trans('validation.required', ['attribute' => 'Brand Name Ar']),
//                    'image.required' => trans('validation.required', ['attribute' => 'image']),
                    'image.dimensions' => trans('validation.dimensions', ['attribute' => 'Brand Icon']),
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->input());
        } else {
            $image = "";
            if ($request->image) {
                $image = $this->upload_image('brands', $request->image);
            }
            $updateArr = [
                'brand_name' => ucwords($request->input('brand_name')),
                'brand_name_ar' => $request->input('brand_name_ar')
            ];
            if ($image) {
                $updateArr['image'] = $image;
            }
            $update = Brand::where('id', $id)->update($updateArr);
            if ($update) {
                return redirect('admin/brand-management')->with('success', 'Brand updated successfully.');
            } else {
                return redirect()->back()->with('error', 'Some error occurred while updating brand');
            }
        }
    }

    public function car_update(Request $request, $id = null) {
        $id = base64_decode($id);
        $validator = \Validator::make($request->all(), [
                    'brand_id' => 'required',
                    'car_name' => 'required',
                    'car_name_ar' => 'required'
                        ], [
                    'brand_id.required' => trans('validation.required', ['attribute' => 'Brand']),
                    'car_name.required' => trans('validation.required', ['attribute' => 'Car Name']),
                    'car_name_ar.required' => trans('validation.required', ['attribute' => 'Car Name Ar'])
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->input());
        } else {
            $updateArr = [
                'brand_id' => $request->input('brand_id'),
                'car_name' => ucwords($request->input('car_name')),
                'car_name_ar' => $request->input('car_name_ar')
            ];
            $update = BrandCar::where('id', $id)->update($updateArr);
            if ($update) {
                return redirect('admin/car-management')->with('success', 'Car updated successfully.');
            } else {
                return redirect()->back()->with('error', 'Some error occurred while updating Car');
            }
        }
    }

    public function model_update(Request $request, $id = null) {
        $id = base64_decode($id);
        $validator = \Validator::make($request->all(), [
                    'brand_id' => 'required',
                    'car_id' => 'required',
                    'model_name' => 'required',
                    'model_name_ar' => 'required'
                        ], [
                    'brand_id.required' => trans('validation.required', ['attribute' => 'Brand']),
                    'car_id.required' => trans('validation.required', ['attribute' => 'Car']),
                    'model_name.required' => trans('validation.required', ['attribute' => 'Model Name']),
                    'model_name_ar.required' => trans('validation.required', ['attribute' => 'Model Name Ar'])
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->input());
        } else {
            $updateArr = [
                'brand_id' => $request->input('brand_id'),
                'car_id' => $request->input('car_id'),
                'model_name' => ucwords($request->input('model_name')),
                'model_name_ar' => $request->input('model_name_ar')
            ];
            $update = ModelName::where('id', $id)->update($updateArr);
            if ($update) {
                return redirect('admin/model-management')->with('success', 'Model updated successfully.');
            } else {
                return redirect()->back()->with('error', 'Some error occurred while updating model');
            }
        }
    }

}
