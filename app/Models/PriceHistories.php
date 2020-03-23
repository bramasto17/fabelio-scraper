<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PriceHistories extends Model
{
    use SoftDeletes;
    
    protected $table   = 'product_price_histories';
    protected $guarded = array('id');

    public function priceHistory()
    {
        return $this->belongsTo('\App\Models\PriceHistories', 'product_id', 'id');
    }

    public function getCreatedAtAttribute($value){
        return \Carbon\Carbon::parse($value)->setTimezone('Asia/Jakarta')->formatLocalized('%d %B %Y %H:%I:%S');
    }

    public function getUpdatedAtAttribute($value){
        return \Carbon\Carbon::parse($value)->setTimezone('Asia/Jakarta')->formatLocalized('%d %B %Y %H:%I:%S');
    }
}
