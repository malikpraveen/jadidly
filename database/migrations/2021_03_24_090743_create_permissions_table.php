<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_id');
            $table->text('pass_key')->nullable();
            $table->text('allowed_permission');
            $table->enum('status',['active','inactive'])->default('active');
            $table->timestamps();
        });
        
        DB::table('permissions')->insert([
            'admin_id'=>1,
            'allowed_permission'=>'1,2,3,4,5,6,7,8,9,10,11,12,13',
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
        Schema::dropIfExists('permissions');
    }
}
