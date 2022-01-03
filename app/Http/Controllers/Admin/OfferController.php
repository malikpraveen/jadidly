<?php

namespace App\Http\Controllers\Admin;

use App\Models\Offer;
use App\Models\Categories;
use Session;
use App\Http\Requests\UsersRequest as StoreRequest;
use App\Http\Requests\UsersRequest as UpdateRequest;
use App\Http\Controllers\CrudOverrideController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class OfferController extends Controller {

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
            if(!in_array(11,$details)){
                return redirect('admin/unauthenticated');
            }
            return $next($request);
        });
    }

    public function index(Request $request) {
        $category_list = Categories::where('status', 'active')->where('parent_id', '0')->get();
        $offers = Offer::select('offers.*', 'categories.name as category_name')->where('offers.status', '<>', 'trashed')
                        ->join('categories', 'offers.category_id', '=', 'categories.id')
                        ->orderBy('offers.id', 'DESC')->get();

        $data['offers'] = $offers;
        $data['category_list'] = $category_list;
        $validator = \Validator::make($request->all(), [
                    'name' => 'required',
                    'name_ar' => 'required',
                    'category_id' => 'required',
                    'percentage' => 'required:min=1,max=100',
                    'description' => 'required',
                    'description_ar' => 'required',
                    'image' => 'required'
                        ], [
                    'name.required' => trans('validation.required', ['attribute' => 'Name']),
                    'name_ar.required' => trans('validation.required', ['attribute' => 'Name (Ar)']),
                    'category_id.required' => trans('validation.required', ['attribute' => 'Category']),
                    'percentage.required' => trans('validation.required', ['attribute' => 'Offer Discount']),
                    'percentage.min' => trans('validation.min', ['attribute' => 'Offer Discount']),
                    'percentage.max' => trans('validation.max', ['attribute' => 'Offer Discount']),
                    'description.required' => trans('validation.required', ['attribute' => 'Description']),
                    'description_ar.required' => trans('validation.required', ['attribute' => 'Description (Ar)']),
                    'image.required' => trans('validation.required', ['attribute' => 'Image'])
        ]);
        if ($validator->fails()) {
            if (isset($request['submit'])) {
                return redirect()->back()->withErrors($validator->errors())->withInput($request->input());
//                return view('admin.admin_settings.support_reasons')->with($data)->withErrors($validator->errors());
            } else {
                return view('admin.offers.offer_list')->with($data);
            }
        } else {
            $insert = [
                'name' => $request->name,
                'name_ar' => $request->name_ar,
                'category_id' => $request->category_id,
                'percentage' => $request->percentage,
                'description' => $request->description,
                'description_ar' => $request->description_ar,
            ];
            $image = $this->upload_image('offers', $request->image);
            if ($image) {
                $insert['image'] = $image;
            }
            $create = Offer::create($insert);
            if ($create) {
                Offer::where('category_id',$request->category_id)->where('id','<>',$create->id)->update(['status'=>'inactive']);
                return redirect('admin/offer-list')->with('success', 'Offer added successfully');
            } else {
                return redirect()->back()->withInput($request->input())->with('error', 'Some error occured while adding offer.');
            }
        }
    }

    public function edit(Request $request, $id = null) {
        $id = base64_decode($id);
        $getOffer = Offer::find($id);
        if ($getOffer) {
            $category_list = Categories::where('status', 'active')->where('parent_id', '0')->get();
            $data['offer']=$getOffer;
            $data['category_list'] = $category_list;
            $validator = \Validator::make($request->all(), [
                        'name' => 'required',
                        'name_ar' => 'required',
                        'category_id' => 'required',
                        'percentage' => 'required:min=1,max=100',
                        'description' => 'required',
                        'description_ar' => 'required'
                            ], [
                        'name.required' => trans('validation.required', ['attribute' => 'Name']),
                        'name_ar.required' => trans('validation.required', ['attribute' => 'Name (Ar)']),
                        'category_id.required' => trans('validation.required', ['attribute' => 'Category']),
                        'percentage.required' => trans('validation.required', ['attribute' => 'Offer Discount']),
                        'percentage.min' => trans('validation.min', ['attribute' => 'Offer Discount']),
                        'percentage.max' => trans('validation.max', ['attribute' => 'Offer Discount']),
                        'description.required' => trans('validation.required', ['attribute' => 'Description']),
                        'description_ar.required' => trans('validation.required', ['attribute' => 'Description (Ar)'])
            ]);
            if ($validator->fails()) {
                if (isset($request['submit'])) {
                    return redirect()->back()->withErrors($validator->errors())->withInput($request->input());
//                return view('admin.admin_settings.support_reasons')->with($data)->withErrors($validator->errors());
                } else {
                    return view('admin.offers.edit_offer')->with($data);
                }
            } else {
                $insert = [
                    'name' => $request->name,
                    'name_ar' => $request->name_ar,
                    'category_id' => $request->category_id,
                    'percentage' => $request->percentage,
                    'description' => $request->description,
                    'description_ar' => $request->description_ar,
                ];
                if ($request->image) {
                    $image = $this->upload_image('offers', $request->image);
                    if ($image) {
                        $insert['image'] = $image;
                    }
                }
                $update = Offer::where('id',$id)->update($insert);
                if ($update) {
                    return redirect('admin/offer-list')->with('success', 'Offer updated successfully');
                } else {
                    return redirect()->back()->withInput($request->input())->with('error', 'Some error occured while updating offer.');
                }
            }
        } else {
            return redirect()->back()->with('error', 'Offer not found');
        }
    }

}

?>