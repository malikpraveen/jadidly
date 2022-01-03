<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarDocument extends Model
{
    protected $fillable=['user_car_id','file_path','file_type'];
    public function car() {
        return $this->belongsTo(UserCar::class);
    }
}
