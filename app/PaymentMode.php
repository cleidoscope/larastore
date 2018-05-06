<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMode extends Model
{

    protected $table = 'payment_modes';
    protected $fillable = ['store_id', 'title', 'description'];



    public function store()
    {
        return $this->belongsTo('App\Store');
    }
}
