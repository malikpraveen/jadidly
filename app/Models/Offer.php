<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable=['category_id','name','name_ar','description','description_ar','percentage','image','status'];
}
