<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// use OwenIt\Auditing\Contracts\Auditable;



class ContactUsImage extends Model /* implements Auditable */ {

    // use \OwenIt\Auditing\Auditable;
    protected $table = 'contact_us_images';
    protected $fillable = ['id', 'contact_us_id', 'image'];

    // public function getNameAttribute($value)
    // {
    //     if(\Session::get('locale') == 'ar') {
    //         // dd('dd');
    //         return $this->name_ar;
    //     }
    //     return $value;
    // }

    public function contactus() {
        return $this->belongsTo(ContactUs::class);
    }

}
