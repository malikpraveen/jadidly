<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Session;
use App\Models\Permission;
class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    protected $status = false;
    protected $errors = [];
    protected $data = [];
    protected $error = '';
    protected $message = '';
    protected $status_code = 200;

    protected function populateResponse($used_validator = true) {
        if ($this->status == false) {
            if ($used_validator) {
                $this->error = $this->message->first();
                $this->errors = $this->message;
            } else {
                $this->error = $this->message;
            }
            $this->message = "";
        }

        return response()->json([
                    'status' => $this->status,
                    'status_code' => $this->status_code,
                    'data' => $this->data,
                    'error' => $this->error,
                    'errors' => $this->errors,
                    'message' => $this->message
        ]);
    }

    public function upload_image($path, $file) {
        $filename = $file->getClientOriginalName();
        $imageName = time() . '.' . $filename;
        $return = $file->move(
                base_path() . '/public/uploads/' . $path, $imageName);
        $url = url('/uploads/'.$path.'/'.$imageName);
        return $url;
    }

    public function my_random_string($char) {
        return uniqid('jadidly');
    }

    
    public function admin_priviledge($id=null){
        $details= Permission::where('admin_id',$id)->first();
        if($details && $details->allowed_permission){
            $permissions=explode(',',$details->allowed_permission);
        }else{
            $permissions=[];
        }
        return $permissions;
    }
    
    public function auth(){
        return view('admin.unauthenticated');
    }
}
