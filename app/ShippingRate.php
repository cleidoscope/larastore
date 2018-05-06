<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingRate extends Model
{

    protected $table = 'shipping_rates';
    protected $fillable = ['shipping_method_id', 'min', 'max', 'rate'];



    public function shipping_method()
    {
        return $this->belongsTo('App\ShippingMethod');
    }
}
