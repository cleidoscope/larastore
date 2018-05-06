<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    protected $table = 'carousels';
    protected $fillable = ['store_id', 'url', 'image'];


    public function store()
    {
        return $this->belongsTo('App\Store');
    }

}
