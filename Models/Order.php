<?php

namespace App\Modules\Cart\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Cart\Models\OrderItem;

class Order extends Model
{
	protected $appends = ['order_shipped','label_made'];

    public function getOrderShippedAttribute()
	{
		if ($this->shipped)
	   		return 'Yes';
	   	else 
	   		return 'No';
	}

	public function getLabelMadeAttribute()
	{
		if ($this->label_created)
	   		return 'Yes';
	   	else 
	   		return 'No';
	}

	public function getFreeAttribute()
	{
		if ($this->price == null || $this->price == 0)
			return true;
		else
			return false;
	}

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
