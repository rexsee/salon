<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('log_date');
            $table->string('services_id')->index();
            $table->string('services')->nullable();
            $table->text('products')->nullable();
            $table->text('remark')->nullable();
            $table->float('total')->default(0);
            $table->unsignedInteger('stylist_id')->index();
            $table->unsignedInteger('customer_id')->index();
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
        Schema::dropIfExists('customer_logs');
    }
}
