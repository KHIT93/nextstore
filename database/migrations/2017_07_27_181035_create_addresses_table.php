<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('street1');
            $table->string('street2');
            $table->string('street3');
            $table->string('zipcode');
            $table->string('country');
            $table->string('phone');
            $table->string('mobile');
            $table->string('company');
            $table->string('tin');
            $table->boolean('billing');
            $table->boolean('shipping');
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
        Schema::dropIfExists('addresses');
    }
}
