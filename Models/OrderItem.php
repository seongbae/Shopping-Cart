<?php

namespace App\Modules\Cart\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Cart\Models\Product;

class OrderItem extends Model
{
	public $timestamps = false;
	
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
