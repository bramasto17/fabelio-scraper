<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceHistories extends Model
{
    protected $table   = 'product_price_histories';
    protected $guarded = array('id');

    public function priceHistory()
    {
        return $this->belongsTo('\App\Models\PriceHistories', 'product_id', 'id');
    }
}
