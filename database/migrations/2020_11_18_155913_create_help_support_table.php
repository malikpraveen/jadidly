<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHelpSupportTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('contact_us', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->text('email');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('subject');
            $table->string('details');
            $table->text('reply')->nullable();
            $table->enum('status', ['0', '1'])->default('1')->comment("0=unseen,1=seen");
            $table->timestamps();
        });

        Schema::create('contact_us_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contact_us_id')->unsigned();
            $table->foreign('contact_us_id')->references('id')->on('contact_us')->onDelete('cascade');
            $table->string('image');
            $table->timestamps();
        });

        Schema::create('contact_us_subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject_en');
            $table->string('subject_ar');
            $table->enum('status', ['0', '1'])->default('1')->comment("0=inactive,1=active");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('contact_us_images');
        Schema::dropIfExists('contact_us');
        Schema::dropIfExists('contact_us_subjects');
    }

}
