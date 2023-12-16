<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FixedAsset extends Model
{
	use SoftDeletes;
    public function category()
    {
        return $this->belongsTo(FixedAssetsCategory::class, 'category_id', 'id');
    }
}
