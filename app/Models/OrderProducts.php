<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProducts extends Model
{
    protected $table = 'order_products';

    public function product()
    {
        return $this->belongsTo('App\Product','product_id','id');
    }
}
