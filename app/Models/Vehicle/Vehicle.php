<?php

namespace App\Models\Vehicle;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
	 use SoftDeletes;
    public function type() {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id', 'id');
    }


    function invest()
    {
        return $this->hasMany(VehicleTransaction::class);
    }

}
