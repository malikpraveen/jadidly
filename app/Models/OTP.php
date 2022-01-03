<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use OwenIt\Auditing\Contracts\Auditable;



class OTP extends Model /*implements Auditable*/
{
    // use \OwenIt\Auditing\Auditable;
     protected $table = 'otp';
   protected $fillable = ['id','otp','user_id'];
}
