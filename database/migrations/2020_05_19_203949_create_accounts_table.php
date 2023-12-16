<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('category')->nullable();
            $table->string('name')->nullable();
            $table->string('alias')->nullable();
            $table->string('display_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('salary')->nullable();
            $table->text('address')->nullable();
            $table->text('account_no')->nullable();
            $table->string('check_form')->nullable();
            $table->string('check_to')->nullable();
            $table->date('opening_date')->nullable();
            $table->string('status')->nullable();
            $table->timestamp('deleted_at')->nullable();

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
        Schema::dropIfExists('accounts');
    }
}
