<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('account_id')->nullable();
            $table->enum('type', ['Debit', 'Credit']);
            $table->string('sub_type')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->double('amount', 20, 2)->nullable();
            $table->string('reff_no')->nullable();
            $table->date('operation_date')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('account_transactions');
    }
}
