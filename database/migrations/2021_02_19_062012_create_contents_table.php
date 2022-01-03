<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->text('text_en')->nullable();
            $table->text('text_ar')->nullable();
            $table->timestamps();
        });

        DB::table('contents')->insert([
            [
                'type' => 'about_us',
                'text_en' => '',
                'text_ar' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ], ['type' => 'privacy_policy',
                'text_en' => '',
                'text_ar' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ], [
                'type' => 'terms_conditions',
                'text_en' => '',
                'text_ar' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('contents');
    }

}
