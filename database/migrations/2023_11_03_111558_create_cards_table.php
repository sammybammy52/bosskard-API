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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role');
            $table->string('phone_1');
            $table->string('phone_2')->nullable();
            $table->string('email');
            $table->string('website');
            $table->string('address');
            $table->string('company_name')->nullable();
            $table->string('logo');
            $table->string('color_1');
            $table->string('color_2');
            $table->integer('logoX');
            $table->integer('logoY');
            $table->integer('filler_id');
            $table->boolean('claimed')->default(0);
            $table->integer('business_id')->default(0);
            $table->integer('template');
            $table->boolean('isMyCard')->default(0);
            $table->boolean('flip')->default(0);
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
        Schema::dropIfExists('cards');
    }
};
