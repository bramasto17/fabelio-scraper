<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductGalleries extends Model
{
    protected $table   = 'product_galleries';
    protected $guarded = array('id');

    public function priceHistory()
    {
        return $this->hasMany('\App\Models\PriceHistories', 'product_id', 'id');
    }
}
