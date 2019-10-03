<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('amount');
            $table->string('account');
            $table->string('branchId');
            $table->string('source');
            $table->text('description');
            $table->integer('categoryId');
            $table->integer('payment_method');
            $table->text('attachment')->nullable();
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
        Schema::dropIfExists('other');
    }
}
