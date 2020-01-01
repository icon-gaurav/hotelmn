<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('short_bio');
            $table->integer('total_count')->default(0);
            $table->integer('booked_count')->default(0);
            $table->double('price_per_night')->default(0.0);
            $table->string('cur')->default('USD');
            $table->double('discount')->default(0);
            $table->double('area')->default(0);
            $table->integer('adult_guest_limit')->default(1);
            $table->integer('children_guest_limit')->default(1);
            $table->longText('facilities')->nullable();
            $table->boolean('wifi')->default(false);
            $table->text('special')->nullable();
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
        Schema::dropIfExists('rooms');
    }
}
