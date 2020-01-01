<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookedItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booked_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('room_id');
            $table->integer('adult')->default(1);
            $table->integer('children')->default(0);
            $table->integer('quantity')->default(1);
            $table->date('check_in_time');
            $table->date('check_out_time');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('booking_id');
            $table->timestamps();

            $table->foreign('room_id')->references('id')->on('rooms');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('booking_id')->references('id')->on('bookings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booked_items', function (Blueprint $table) {
           $table->dropForeign('booked_items_booking_id_foreign');
        });
        Schema::dropIfExists('cart_items');
    }
}
