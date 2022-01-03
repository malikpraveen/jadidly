<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('branch', function (Blueprint $table) {
            $table->id();
            $table->string('branch_name');
            $table->string('branch_name_ar');
            $table->string('contact_number');
            $table->text('location');
            $table->double('latitude');
            $table->double('longitude');
            $table->text('working_days');
            $table->text('working_day_time');
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('branch');
    }

}
