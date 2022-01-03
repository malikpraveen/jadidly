<?php

namespace App\Http\Controllers\Admin;

use Auth;
use DB;
use Response;
use Session;
use App\Http\Requests\UsersRequest as StoreRequest;
use App\Http\Requests\UsersRequest as UpdateRequest;
use App\Http\Controllers\CrudOverrideController;
use Illuminate\Http\Request;
use App\Models\Categories;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class CategoryController extends Controller {

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
    }

    public function index(Request $request) {
        if (in_array(2, Session::get('admin_logged_in')['permissions'])) {
            $category = DB::table('categories')
                    ->where('parent_id', 0)
                    ->get();
            $data['categories'] = $category;
            return view('admin.category.category_list')->with($data);
        } else {
            return view('admin.unauthenticated');
        }
    }

    public function subcategory_management(Request $request) {
        if (in_array(3, Session::get('admin_logged_in')['permissions'])) {
            $category = DB::table('categories')
                    ->where('parent_id', 0)
                    ->get();
            $data['categories'] = $category;
            $subcategory = DB::table('categories')
                    ->where('parent_id', '>', 0)
                    ->get();
            $data['categories'] = $category;
            if ($subcategory) {
                foreach ($subcategory as $subcat) {
                    $category_name = DB::table('categories')->where('id', $subcat->parent_id)->get()->first();
                    if ($category_name) {
                        $subcat->category_name = $category_name->name;
                    } else {
                        $subcat->category_name = "N/A";
                    }
                }
            }
            $data['subcategories'] = $subcategory;
            return view('admin.category.subcategory_list')->with($data);
        } else {
            return view('admin.unauthenticated');
        }
    }

    public function store(Request $request) {
        $insert_arr = [
            'name' => ucwords($request->input('category_name_en')),
            'name_ar' => $request->input('category_name_ar'),
            'parent_id' => $request->input('parent_id')
        ];

        if ($request->input('cat_3')) {
            $insert_arr['parent_id'] = $request->input('cat_3');
        } else if ($request->input('cat_2')) {
            $insert_arr['parent_id'] = $request->input('cat_2');
        } else {
            $insert_arr['parent_id'] = $request->input('parent_id');
        }
        $insert_arr['multiple_select'] = $request->input('multiselect');
        if ($request->hasFile('category_image')) {
            $path = "/uploads/category_images/";
            $check = $this->uploadFile($request, 'category_image', $path);
            if ($check):
                $insert_arr['image'] = url($path . $check);
            endif;
        }
        $add = Categories::create($insert_arr);
        if ($add) {
            if ($request->input('parent_id') == 0) {
                return redirect('admin/category-management')->with('success', 'Category added succesfully');
            } else {
                return redirect('admin/subcategory-management')->with('success', 'Subcategory added succesfully');
            }
        } else {
            
        }
        return back()->withInput()->with('error', 'Error while adding category');
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

//    protected function my_random_string($char) {
//        return uniqid('jadidly');
//    }

    public function change_category_status(Request $request) {
        $id = $request->input('id');
        $status = $request->input('action');
        $update = Categories::find($id)->update(['status' => $status]);
        if ($update) {
            return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully']);
        } else {
            return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status']);
        }
    }

    public function getSubcategory(Request $request) {
        $id = $request->input('id');
        $subcategories = DB::table('categories')->where('parent_id', $id)->where('status', 'active')->get();
        if ($subcategories) {
            return response()->json(['status' => true, 'error_code' => 200, 'message' => 'Status updated successfully', 'data' => $subcategories]);
        } else {
            return response()->json(['status' => false, 'error_code' => 201, 'message' => 'Error while updating status', 'data' => []]);
        }
    }

    public function edit(Request $request, $id = null) {
        if (in_array(2, Session::get('admin_logged_in')['permissions'])) {
            $id = base64_decode($id);
            $category = Categories::find($id);
            if ($category) {
                $data['category'] = $category;
                return view('admin.category.edit_category')->with($data);
            } else {
                return redirect('admin/category-management')->with('error', 'Category not found');
            }
        } else {
            return view('admin.unauthenticated');
        }
    }

    public function edit_subcategory(Request $request, $id = null) {
        if (in_array(3, Session::get('admin_logged_in')['permissions'])) {
            $id = base64_decode($id);
            $data['first_level_cat'] = [];
            $data['second_level_cat'] = [];
            $data['third_level_cat'] = [];
            $data['second_parent_id'] = "";
            $data['third_parent_id'] = "";
            $data['second_parent_name'] = "";
            $data['third_parent_name'] = "";
            $data['parent_name'] = "";
            $subcategory = Categories::find($id);
            if ($subcategory) {
                if ($subcategory->parent_id) {
                    $parent = Categories::find($subcategory->parent_id);
                    $data['parent_name'] = $parent->name;
                    $get_parent_siblings = Categories::where('parent_id', $parent->parent_id)->get();
                    $data['first_level_cat'] = $get_parent_siblings;
                    if ($parent->parent_id) {
                        $mid_level = Categories::find($parent->parent_id);
                        $get_mid_parent_siblings = Categories::where('parent_id', $mid_level->parent_id)->get();
                        $data['second_level_cat'] = $get_mid_parent_siblings;
                        $data['second_parent_id'] = $parent->parent_id;
                        $data['second_parent_name'] = $mid_level->name;
                        if ($mid_level->parent_id) {
                            $upper_level = Categories::find($mid_level->parent_id);
                            $upper_level_parent = Categories::where('parent_id', $upper_level->parent_id)->get();
                            $data['third_level_cat'] = $upper_level_parent;
                            $data['third_parent_id'] = $mid_level->parent_id;
                            $data['third_parent_name'] = $upper_level->name;
                        }
                    }
                }
                $data['category'] = $subcategory;
//
//            echo '<pre>';
//            print_r($data);
//            die;
                return view('admin.category.edit_subcategory')->with($data);
            } else {
                return redirect('admin/subcategory-management')->with('error', 'Subcategory not found');
            }
        } else {
            return view('admin.unauthenticated');
        }
    }

    public function update(Request $request, $id = null) {
        $id = base64_decode($id);
        $insert_arr = [
            'name' => ucwords($request->input('category_name_en')),
            'name_ar' => $request->input('category_name_ar'),
            'parent_id' => $request->input('parent_id')
        ];

        if ($request->input('cat_3')) {
            $insert_arr['parent_id'] = $request->input('cat_3');
        } else if ($request->input('cat_2')) {
            $insert_arr['parent_id'] = $request->input('cat_2');
        } else {
            $insert_arr['parent_id'] = $request->input('parent_id');
        }

        if ($request->hasFile('category_image')) {
            $path = "/uploads/category_images/";
            $check = $this->uploadFile($request, 'category_image', $path);
            if ($check):
                $insert_arr['image'] = url($path) . '/' . $check;
            endif;
        }
        $update = Categories::where('id', $id)->update($insert_arr);
        if ($update) {
            if ($insert_arr['parent_id'] == 0) {
                return redirect('admin/category-management')->with('success', 'Category Updated Succesfully');
            } else {
                return redirect('admin/subcategory-management')->with('success', 'Subcategory Updated Succesfully');
            }
        }
        return back()->withInput()->with('error', 'Error while updating Category');
    }

}
