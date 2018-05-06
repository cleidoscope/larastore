<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $table = 'newsletters';
    protected $fillable = ['store_id', 'subject', 'message'];




    public function store()
    {
        return $this->belongsTo('App\Store');
    }



    public function getCreatedAtAttribute($value)
    {
        return date_format(date_create($value), 'M d, Y h:i a');
    }
}
