<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_people', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('seller_name');
            $table->string('phone');
            $table->string('email');
            $table->string('national_id')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('postal_code');
            $table->string('image')->default('default.png');
            $table->string('sales_parcentage');
            $table->string('country');
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
        Schema::dropIfExists('sales_people');
    }
}
