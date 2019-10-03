<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerCommisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_commisions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('booking_no');
            $table->string('customer_id');
            $table->string('branchId');
            $table->string('categoryId');
            $table->string('subcategoryId');
            $table->string('square_fit');
            $table->string('company');
            $table->string('parcentage');
            $table->string('installment');
            $table->string('grand_total');
            $table->string('type');
            $table->date('date');
            $table->string('account');
            $table->string('payment_method');
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
        Schema::dropIfExists('customer_commisions');
    }
}
