<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'item_id',
        'quantity',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function getDaysAttribute(): int
    {
        if (!$this->start_date || !$this->end_date) return 1;
        return max(1, $this->start_date->diffInDays($this->end_date));
    }

    public function getSubtotalAttribute(): int
    {
        if (!$this->item) return 0;
        return $this->item->price_per_day * $this->days * $this->quantity;
    }
}
