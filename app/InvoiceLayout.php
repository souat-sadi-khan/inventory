<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceLayout extends Model
{
    use SoftDeletes;
     protected $fillable = ['type','name','value'];
}
