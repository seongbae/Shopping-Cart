<?php

namespace App\Modules\Cart\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	public $timestamps = false;
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'price',
    ];

    public function getImageAttribute()
    {
        if ($this->photo_url != null)
            return $this->photo_url;
        else 
            return '/img/product-placeholder.png';
    }
}
