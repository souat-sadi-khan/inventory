<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->string('sale_type')->nullable();
            $table->string('reference_no')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('date')->nullable();
            $table->string('type')->nullable();
            $table->string('transaction_type')->nullable();
            $table->double('sub_total',20,2)->nullable();
            $table->double('discount',10,2)->nullable();
            $table->string('discount_type')->nullable();
            $table->double('discount_amount',20,2)->nullable();
            $table->double('tax',20,2)->nullable();
            $table->double('shipping_charges',20,2)->nullable();
            $table->double('net_total',20,2)->nullable();
            $table->double('paid',20,2)->nullable();
            $table->double('due',20,2)->nullable();
            $table->string('status')->nullable();
            $table->string('payment_status')->nullable();
            $table->longText('stuff_note')->nullable();
            $table->longText('transaction_note')->nullable();
            $table->integer('return_parent_id')->nullable();
            $table->integer('return')->default(0);
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
