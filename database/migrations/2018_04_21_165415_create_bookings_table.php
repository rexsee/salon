<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->enum('status',['Pending','Confirmed','Postpone','Cancel'])->default('Pending');
            $table->string('name');
            $table->string('tel');
            $table->date('booking_date');
            $table->time('booking_time');
            $table->unsignedInteger('service_id')->index();
            $table->unsignedInteger('stylist_id')->index();
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
