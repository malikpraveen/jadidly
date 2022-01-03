<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUsSubject extends Model {

    protected $table = 'contact_us_subjects';
    protected $fillable = ['id', 'subject_en', 'subject_ar', 'status'];

//    public function query() {
//        return $this->belongsToMany(ContactUs::class);
//    }

}
