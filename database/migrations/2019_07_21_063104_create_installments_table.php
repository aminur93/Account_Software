<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('install_name');
            $table->date('install_date');
            $table->string('customerId');
            $table->string('sellerId');
            $table->string('bookingId');
            $table->string('branchId');
            $table->string('categoryId');
            $table->string('subcategoryId');
            $table->string('square_fit');
            $table->string('total');
            $table->integer('status')->default(1);
            $table->string('accountId');
            $table->string('payment');
            $table->string('payement_method_id');
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
        Schema::dropIfExists('installments');
    }
}
