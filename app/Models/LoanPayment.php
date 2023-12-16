<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanPayment extends Model
{

    use SoftDeletes;

    protected $guarded = [];

    public function admin() {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    
}
