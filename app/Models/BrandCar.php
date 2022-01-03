<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandCar extends Model {

    protected $fillable=['brand_id','car_name','car_name_ar'];
    public function brand() {
        return $this->belongsTo(Brand::class);
    }
    
    public function car_models(){
        return $this->hasMany(ModelName::class,'car_id','id');
    }

}
