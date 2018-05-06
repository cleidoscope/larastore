<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'orders';
    protected $fillable = ['email', 'store_id', 'shipping_address', 'shipping_method', 'payment_mode', 'voucher', 'notes', 'status'];


    public function user()
    {
        return $this->belongsTo('App\User');
    }



    public function store()
    {
        return $this->belongsTo('App\Store');
    }



    public function voucher()
    {
        return $this->belongsTo('App\Store');
    }



    public function order_items()
    {
        return $this->hasMany('App\OrderItem')->orderBy('created_at', 'desc');
    }




    public function getTotalAttribute()
    {
        $total = $weight = 0;
        foreach( $this->order_items as $order_item ) :
            $total += ($order_item->price * $order_item->quantity);
        endforeach;
        $weight += $this->order_items->sum('weight');
        $rates = $this->getShippingMethodAttribute($this->attributes['shipping_method'])->rates;
        foreach( $rates as $rate ) :
            if( $weight >= $rate->min && $weight <= $rate->max ) :
                $total += $rate->rate;
                break;
            endif;
        endforeach;

        $voucher = $this->getVoucherAttribute($this->attributes['voucher']);
        if( $voucher ) $total -= $voucher->discount;

        return $total;
    }




    public function getShippingAddressAttribute($value)
    {
        return json_decode($value);
    }



    public function getShippingMethodAttribute($value)
    {
        return json_decode($value);
    }



    public function getShippingFeeAttribute($value)
    {
        $fee = 0;
        $weight = $this->order_items->sum('weight');
        $rates = $this->getShippingMethodAttribute($this->attributes['shipping_method'])->rates;
        foreach( $rates as $rate ) :
            if( $weight >= $rate->min && $weight <= $rate->max ) :
                $fee = $rate->rate;
                break;
            endif;
        endforeach;

        return $fee;
    }


    public function getPaymentModeAttribute($value)
    {
        return json_decode($value);
    }



    public function getVoucherAttribute($value)
    {
        return json_decode($value);
    }


    
    public function getCreatedAtAttribute($value)
    {
        return date_format(date_create($value), 'M d, Y');
    }


}
