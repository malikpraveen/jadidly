<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingService extends Model
{
    protected $fillable=['booking_id','service_id','price','discount','amount'];
}
