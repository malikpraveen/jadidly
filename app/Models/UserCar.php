<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCar extends Model
{
    protected $fillable=['user_id','brand_id','car_id','model_id','model_year'];
    
    public function images(){
        return $this->hasMany(CarDocument::class,'user_car_id','id');
    }
}
