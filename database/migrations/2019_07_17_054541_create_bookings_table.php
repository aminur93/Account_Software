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
            $table->bigIncrements('id');
            $table->string('sellerId');
            $table->string('branchId');
            $table->string('categoryId');
            $table->string('customerid');
            $table->string('companyId');
            $table->string('subcategoryId');
            $table->string('booking_type');
            $table->string('booking_no');
            $table->string('sqfit');
            $table->string('price');
            $table->string('total_price');
            $table->date('booking_date');
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
