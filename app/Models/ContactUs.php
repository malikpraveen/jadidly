<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use OwenIt\Auditing\Contracts\Auditable;



class ContactUs extends Model /*implements Auditable*/
{
    // use \OwenIt\Auditing\Auditable;
    protected $table = 'contact_us';
    protected $fillable = ['id','user_id','email','subject','details'];

   	// public function getNameAttribute($value)
    // {
    //     if(\Session::get('locale') == 'ar') {
    //         // dd('dd');
    //         return $this->name_ar;
    //     }
    //     return $value;
    // }
        
    
//    public function subject(){
//        return $this->hasOne(ContactUsSubject::class, 'subject', 'id');
//    }
    
        public function images(){
        return $this->hasMany(ContactUsImage::class, 'contact_us_id', 'id');
    }
}
