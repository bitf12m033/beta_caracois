<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product extends Model
{
	use SoftDeletes;
    protected $fillable = [
        'brand_name', 'product_name', 'category','receive_date','exp_date','orginal_price','sell_price','quantity','is_active','is_delete',
    ];

    /**

     * The attributes that should be mutated to dates.

     *

     * @var array

     */

    protected $dates = ['deleted_at'];
}
