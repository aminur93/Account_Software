<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_incomes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('booking_no');
            $table->string('sellerId');
            $table->string('branchId');
            $table->string('companyId');
            $table->string('categoryId');
            $table->string('subcategoryId');
            $table->string('square_fit');
            $table->string('total');
            $table->string('parcentage');
            $table->string('seller_income');
            $table->string('type');
            $table->string('payment_method');
            $table->date('date');
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
        Schema::dropIfExists('sales_incomes');
    }
}
