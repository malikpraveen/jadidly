<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Service extends Model {

    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'category_id',
        'main_category',
        'name',
        'name_ar',
        'description',
        'description_ar',
        'price',
        'is_pickup',
        'status',
        'created_at',
    ];

    public function service_category() {
        return $this->hasOne(Categories::class,'id','main_category');
    }
    
    public function service_subcategory() {
        return $this->hasOne(Categories::class,'id','category_id');
    }

    public function getSubCategory() {
        return $this->belongsTo('App\Model\Categories', 'subcategory_id');
    }

    public function service_images() {
        return $this->hasMany(ServiceImage::class, 'service_id', 'id');
    }

}
