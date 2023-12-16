<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionPayment extends Model
{
     use SoftDeletes;
     protected $guarded = ['id'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

     public function customer()
    {
        return $this->belongsTo('App\Models\Customer','customer_id','id');
    }

      public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier', 'supplier_id', 'id');
    }

    public function account()
    {
        return $this->belongsTo('App\Models\Admin\Account','account_id','id');
    }

    
}
