<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('name_ar');
            $table->enum('status',['active','inactive']);
            $table->timestamps();

        });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('fb_id')->nullable();
            $table->string('google_id')->nullable();
            $table->string('twitter_id')->nullable();
            $table->string('email')->nullable();
            $table->string('country_code')->nullable();
            $table->string('mobile_number')->nullable();
            $table->text('image')->nullable();
            $table->string('password');
            $table->string('device_token',1000)->nullable();
            $table->enum('device_type', ['android', 'ios','web']);
            $table->rememberToken();
            $table->enum('is_otp_verified',['yes','no'])->default('no');
            $table->enum('is_email_verified',['yes','no'])->default('no');
            $table->enum('type',['admin','user'])->default('user');
            $table->enum('status',['active','inactive','blocked','trashed'])->default('inactive');
            $table->timestamps();

        });

        Schema::create('otp', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('otp');
            $table->timestamps();

        });
        
        
        DB::table('users')->insert([
            'name'=>'Super Admin',
            'email'=>'admin@jadidly.com',
            'password'=>Hash::make('admin'),
            'device_type'=>'web',
            'type'=>'admin',
            'status'=>'active',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('otp');
        Schema::dropIfExists('users');
        Schema::dropIfExists('countries');
    }
}
