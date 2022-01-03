<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('user_car_id');
            $table->integer('branch_id')->default(0);
            $table->text('pickup_location')->nullable();
            $table->float('pickup_lat')->nullable();
            $table->float('pickup_lng')->nullable();
            $table->text('dropoff_location')->nullable();
            $table->float('dropoff_lat')->nullable();
            $table->float('dropoff_lng')->nullable();
            $table->bigInteger('booking_datetime');
            $table->float('price');
            $table->float('discount')->default(0);
            $table->enum('is_pickup',['0','1'])->default('0');
            $table->float('pick_drop_charge')->default(0);
            $table->float('tax')->default(0);
            $table->float('amount');
            $table->integer('offer_id')->default(0);
            $table->enum('payment_mode',['online','cash'])->default('cash');
            $table->enum('payment_status',['0','1','2','3'])->default('0')->comment("0=pending,1=in process,2=paid,3=failed");
            $table->integer('cancel_reason')->default('0');
            $table->enum('status',['0','1','2','3','4'])->default('0')->comment("0=new,1=pending,2=completed,3=rejected,4=cancelled");
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
        Schema::dropIfExists('bookings');
    }
}
