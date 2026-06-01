<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'product_id',
        'start_date',
        'end_date',
        'days',
        'quantity',
        'note',
        'price_per_day',
        'total_price',
        'shipping_cost',
        'service_fee',
        'shipping_method',
        'customer_name',
        'customer_phone',
        'customer_address',
        'snap_token',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}