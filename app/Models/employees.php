<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class employees extends Model
{
    protected $table="employees";
    protected $fillable=["branch_id","employee_name","country_code","mobile_number","email","local_address","nationality","age","gender","image","id_image_front","id_image_back","status"];
}
