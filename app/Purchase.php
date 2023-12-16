<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
     use SoftDeletes;
     protected $guarded = ['id'];

     public function product()
    {
        return $this->belongsTo('App\Models\Products\Product','product_id');
    }
}
