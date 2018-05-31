<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_informations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('fax_number')->nullable();
            $table->string('email')->nullable();
            $table->string('head_line')->nullable();
            $table->string('slogan')->nullable();
            $table->string('image_path')->nullable();
            $table->text('about_us_desc')->nullable();
            $table->text('vision_desc')->nullable();
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
        Schema::dropIfExists('system_informations');
    }
}
