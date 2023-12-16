<?php

namespace App;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
     use SoftDeletes;
     protected $guarded = ['id'];


    public function purchase()
    {
        return $this->hasMany(Purchase::class, 'transaction_id', 'id');
    }

    public function sell_lines()
    {
        return $this->hasMany(\App\TransactionSellLine::class);
    }

    public function payment()
    {
        return $this->hasMany(TransactionPayment::class, 'transaction_id', 'id');
    }

     public function customer()
    {
        return $this->belongsTo('App\Models\Customer','customer_id','id');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier', 'supplier_id', 'id');
    }

    public function return_parent()
    {
        return $this->hasOne(Transaction::class, 'return_parent_id');
    }
}
