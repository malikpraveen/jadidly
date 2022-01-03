<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable=['user_id','user_car_id','branch_id','booking_datetime','payment_mode','price','discount','pick_drop_charge','tax','amount','offer_id','is_pickup','pickup_location','pickup_lat','pickup_lng','dropoff_location','dropoff_lat','dropoff_lng'];
}
