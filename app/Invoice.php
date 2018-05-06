<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Transaction;
use App\Http\Helpers;
use Carbon\Carbon;

class Invoice extends Model
{
    protected $table = 'invoices';
    protected $fillable = ['user_id', 'store_id', 'bill_to', 'pay_to', 'items', 'amount', 'due_at', 'notes'];



    public function user()
    {
        return $this->belongsTo('App\User');
    }



    public function store()
    {
        return $this->belongsTo('App\Store');
    }



    public function transactions()
    {
        return $this->hasMany('App\Transaction')->orderBy('created_at', 'desc');
    }




    public function getStatusAttribute()
    {
        $status = $this->getisPaidAttribute();
        switch( $status ) :
            case true :
                return 'Paid';
                break;
            case false :
                return 'Unpaid';
                break;
        endswitch;
    }




    public function getisPaidAttribute()
    {
        $transactions_sum = $this->transactions()->sum('amount');
        return $this->getAmountAttribute() -  $transactions_sum <= 0;
    }




    public function getAmountAttribute()
    {
        return $this->getItemsAttribute($this->attributes['items'])->plan->price;
    }




    public function getAmountDueAttribute()
    {
        $amount = $this->getAmountAttribute();
        $transactions = $this->transactions()->sum('amount');
        return $amount - $transactions;
    }



    
    public function getCreatedAtAttribute($value)
    {
        return date_format(date_create($value), 'M d, Y');
    }




    public function getDueAtAttribute($value)
    {
        $created_at = Carbon::parse($this->attributes['created_at']);
        return $created_at->addDays(14)->format('M d, Y');
    }



    public function getItemsAttribute($value)
    {
        return json_decode($value);
    }




    public function getBillToAttribute($value)
    {
        return json_decode($value);
    }
}
