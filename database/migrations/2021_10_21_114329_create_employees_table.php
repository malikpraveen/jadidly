<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('branch_id');
            $table->string('employee_name');
            $table->string('country_code');
            $table->string('mobile_number');
            $table->string('email');
            $table->string('local_address');
            $table->string('nationality');
            $table->integer('age');
            $table->string('gender');
            $table->text('image');
            $table->text('id_image_front');
            $table->text('id_image_back');
            $table->enum('status',['active','inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
