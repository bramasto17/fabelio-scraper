<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use SoftDeletes;
    
    protected $table   = 'products';
    protected $guarded = array('id');
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];

    public function priceHistory()
    {
        return $this->hasMany('\App\Models\PriceHistories', 'product_id', 'id');
    }

    public function gallery()
    {
        return $this->hasMany('\App\Models\ProductGalleries', 'product_id', 'id')->take(4);
    }

    public function getCreatedAtAttribute($value){
        return \Carbon\Carbon::parse($value)->setTimezone('Asia/Jakarta')->formatLocalized('%d %B %Y %H:%I:%S');
    }

    public function getUpdatedAtAttribute($value){
        return \Carbon\Carbon::parse($value)->setTimezone('Asia/Jakarta')->formatLocalized('%d %B %Y %H:%I:%S');
    }
}
