<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $fillable = ['invoice_id', 'amount', 'mode', 'mode_transaction'];
    

    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }


    public function getCreatedAtAttribute($value)
    {
        return date_format(date_create($value), 'M d, Y');
    }
}
