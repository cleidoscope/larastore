<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{

    protected $table = 'vouchers';
    protected $fillable = ['code', 'discount', 'store_id', 'valid_until'];



    public function store()
    {
        return $this->belongsTo('App\Store');
    }




    public function getCreatedAtAttribute($value)
    {
        return date_format(date_create($value), 'M d, Y h:i a');
    }




    public function getValidUntilAttribute($value)
    {
        return date_format(date_create($value), 'M d, Y');
    }

}
