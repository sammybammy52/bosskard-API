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
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('business_id')->nullable();
            $table->string('type')->nullable();
            $table->string('navName')->nullable();
            $table->string('heroText')->nullable();
            $table->string('heroSubText')->nullable();
            $table->string('heroBanner')->nullable();
            $table->json('services')->nullable();
            $table->json('blogs')->nullable();
            $table->json('testimonials')->nullable();
            $table->string('theme')->default('light');
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
        Schema::dropIfExists('websites');
    }
};
