<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable=['brand_name','brand_name_ar','image'];
    public function brand_cars(){
        return $this->hasMany(BrandCar::class,'brand_id','id');
    }
}
