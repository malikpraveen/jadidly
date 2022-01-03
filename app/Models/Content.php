<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use OwenIt\Auditing\Contracts\Auditable;



class Content extends Model 
{
    protected $table = 'contents';
   	protected $fillable = ['id','type','text_en','text_ar'];
}
