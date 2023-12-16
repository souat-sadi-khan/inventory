<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
	use SoftDeletes;
     protected $guarded = ['id'];
    function account()
    {
        return $this->hasMany(AccountTransaction::class);
    }
}
