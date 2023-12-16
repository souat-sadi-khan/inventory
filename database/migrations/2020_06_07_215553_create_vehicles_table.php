<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('regi_no')->nullable();
            $table->string('chassis_no')->nullable();
            $table->string('model_no')->nullable();
            $table->string('engine_no')->nullable();
            $table->string('vehicle_type_id')->nullable();
            $table->string('road_permit')->nullable();
            $table->string('license_no')->nullable();
            $table->string('license_validity')->nullable();
            $table->string('investment')->nullable();
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
        Schema::dropIfExists('vehicles');
    }
}
