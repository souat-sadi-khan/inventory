<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('sup_name')->nullable();
            $table->string('code_name')->nullable();
            $table->string('sup_mobile')->nullable();
            $table->string('sup_email')->nullable();
            $table->string('gtin')->nullable();
            $table->string('sup_address')->nullable();
            $table->string('sup_city')->nullable();
            $table->string('sup_state')->nullable();
            $table->string('sup_country')->nullable();
            $table->longtext('sup_details')->nullable();
            $table->boolean('status')->nullable();
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
        Schema::dropIfExists('suppliers');
    }
}
