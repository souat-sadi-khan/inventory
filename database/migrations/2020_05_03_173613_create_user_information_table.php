<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('gender')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('skype_link')->nullable();
            $table->string('website_link')->nullable();
            $table->string('present_address')->nullable();
            $table->string('present_additional_address')->nullable();
            $table->string('present_city')->nullable();
            $table->string('present_postcode')->nullable();
            $table->string('present_state')->nullable();
            $table->string('present_country')->nullable();
            $table->string('parmanent_address')->nullable();
            $table->string('parmanent_additional_address')->nullable();
            $table->string('parmanent_city')->nullable();
            $table->string('parmanent_postcode')->nullable();
            $table->string('parmanent_state')->nullable();
            $table->string('parmanent_country')->nullable();
            $table->string('education')->nullable();
            $table->string('designation')->nullable();
            $table->longText('notes')->nullable();
            $table->text('skill')->nullable();
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
        Schema::dropIfExists('user_information');
    }
}
