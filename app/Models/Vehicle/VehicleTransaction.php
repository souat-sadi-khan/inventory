<?php

namespace App\Models\Vehicle;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleTransaction extends Model
{
	 use SoftDeletes;
    public function truck()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }
}
