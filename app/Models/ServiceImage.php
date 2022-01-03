<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// use OwenIt\Auditing\Contracts\Auditable;



class ServiceImage extends Model /* implements Auditable */ {

    // use \OwenIt\Auditing\Auditable;
    protected $table = 'service_images';
    protected $fillable = ['id', 'service_id', 'image'];

    // public function getNameAttribute($value)
    // {
    //     if(\Session::get('locale') == 'ar') {
    //         // dd('dd');
    //         return $this->name_ar;
    //     }
    //     return $value;
    // }

    public function images() {
        return $this->belongsTo(Service::class);
    }

}
