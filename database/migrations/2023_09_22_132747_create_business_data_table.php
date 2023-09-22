<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_data', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unique();
            $table->string("businessName");
            $table->string("cacRegNumber");
            $table->string("businessAddress");
            $table->string("businessPhone");
            $table->string("businessCategory");
            $table->date("businessRegistrationDate");
            $table->string("businessDescription");
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
        Schema::dropIfExists('business_data');
    }
};
