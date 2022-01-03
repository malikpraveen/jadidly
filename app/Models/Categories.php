<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Categories extends Model {

    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $fillable = [
        'parent_id',
        'name',
        'name_ar',
        'image',
        'status',
        'created_at',
    ];

    public function services() {
        return $this->belongsToMany(Service::class);
    }


}
