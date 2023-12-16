<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('ref_no')->nullable();
            $table->date('date')->nullable();
            $table->string('loan_from')->nullable();
            $table->string('title')->nullable();
            $table->double('amount', 2)->nullable();
            $table->string('interest')->nullable();
            $table->double('payable', 2)->nullable();
            $table->double('due', 2)->nullable();
            $table->longtext('details')->nullable();
            $table->string('attatchment')->nullable();
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('loans');
    }
}
