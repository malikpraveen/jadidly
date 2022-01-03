<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table="branch";
    protected $fillable=['branch_name','branch_name_ar','contact_number','location','latitude','longitude','working_days','working_day_time'];
}
