<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdditionalChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additional_charges', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->double('charges')->default(0);
            $table->timestamps();
        });
        
        DB::table('additional_charges')->insert([
            'type'=>'pickup_charges',
            'charges'=>0,
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
        Schema::dropIfExists('additional_charges');
    }
}
