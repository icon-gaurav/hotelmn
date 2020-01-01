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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->string('gtw_txn_id')->nullable();
            $table->boolean('confirmed')->default(false);
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
//            $table->foreign('payment_id')->references('id')->on('payments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign('bookings_customer_id_foreign');
            $table->dropForeign('booked_items_booking_id_foreign');
        });
        Schema::dropIfExists('bookings');
    }
}
