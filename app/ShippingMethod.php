<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{

    protected $table = 'shipping_methods';
    protected $fillable = ['store_id', 'title', 'description'];



    public function store()
    {
        return $this->belongsTo('App\Store');
    }


    public function rates()
    {
        return $this->hasMany('App\ShippingRate')->orderBy('min', 'asc');
    }
}
