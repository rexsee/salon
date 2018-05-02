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
            $table->enum('status',['Pending','Confirmed','Postpone','Cancel','Done'])->default('Pending');
            $table->string('name')->index();
            $table->string('tel')->index();
            $table->timestamp('booking_date')->index();
            $table->string('services')->index();
            $table->unsignedInteger('stylist_id')->index();
            $table->unsignedDecimal('hour_take');
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
