<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductGalleries extends Model
{
    use SoftDeletes;
    
    protected $table   = 'product_galleries';
    protected $guarded = array('id');

    public function priceHistory()
    {
        return $this->hasMany('\App\Models\PriceHistories', 'product_id', 'id');
    }
}
