<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelName extends Model
{
    protected $fillable=['brand_id','car_id','model_name','model_name_ar'];
    public function car() {
        return $this->belongsTo(BrandCar::class);
    }
}
