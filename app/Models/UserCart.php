<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCart extends Model
{
    protected $table="user_cart";
    protected $fillable=['user_id','category_id','service_id'];
}
