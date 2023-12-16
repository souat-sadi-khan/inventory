<?php

namespace App\Models\Products;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    // Relation with Supplier
    public function supplier() {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function unit() {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

     public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function purchase() {
        return $this->hasMany('App\Purchase');
    }

    public function sale_line() {
        return $this->hasMany('App\TransactionSellLine');
    }
}
