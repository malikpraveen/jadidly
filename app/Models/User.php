<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable ;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable 
{
	    use HasApiTokens, Notifiable;


     /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

	protected $table = 'users';
	protected $primaryKey = 'id';
	protected $fillable	=	[
		'country_code',
		'mobile_number',
		'fb_id',
		'google_id',
		'twitter_id',
		'name',
		'email',
		'password',
		'device_token',
		'device_type',
		'remember_token',
		'is_otp_verified',
		'is_email_verified',
		'status',
		'type',
	];
	protected $hidden =[
		'password',
	];
	public $timestamps = true;


	
}
