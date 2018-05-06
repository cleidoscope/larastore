<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table = 'stores';
    protected $fillable = ['user_id', 'name', 'tagline', 'subdomain', 'store_category_id', 'plan_id', 'store_logo', 'store_icon', 'theme_id', 'is_active', 'facebook', 'twitter', 'instagram', 'street', 'city', 'province', 'zip_code', 'phone', 'last_payment'];



    public function user()
    {
        return $this->belongsTo('App\User');
    }



    public function products()
    {
        return $this->hasMany('App\Product')->orderBy('created_at', 'desc');
    }



    public function carousels()
    {
        return $this->hasMany('App\Carousel')->orderBy('created_at', 'desc');
    }



    public function plan()
    {
        return $this->belongsTo('App\Plan');
    }



    public function store_category()
    {
        return $this->belongsTo('App\StoreCategory');
    }



    public function product_categories()
    {
        return $this->hasMany('App\ProductCategory')->orderBy('created_at', 'desc');
    }




    public function vouchers()
    {
        return $this->hasMany('App\Voucher')->orderBy('created_at', 'desc');
    }




    public function newsletters()
    {
        return $this->hasMany('App\Newsletter')->orderBy('created_at', 'desc');
    }




    public function store_subscribers()
    {
        return $this->hasMany('App\StoreSubscriber')->orderBy('created_at', 'desc');
    }



    public function shipping_methods()
    {
        return $this->hasMany('App\ShippingMethod')->orderBy('created_at', 'desc');
    }




    public function orders()
    {
        return $this->hasMany('App\Order')->orderBy('created_at', 'desc');
    }




    public function store_theme()
    {
        return $this->belongsTo('App\StoreTheme', 'theme_id')->orderBy('created_at', 'desc');
    }




    public function store_themes()
    {
        return $this->hasMany('App\StoreTheme')->orderBy('created_at', 'desc');
    }




    public function payment_modes()
    {
        return $this->hasMany('App\PaymentMode')->orderBy('created_at', 'desc');
    }




    public function getIsBasicAttribute()
    {
        return $this->attributes['plan_id'] == 1;
    }





    public function getIsPlusAttribute()
    {
        return $this->attributes['plan_id'] == 2;
    }





    public function getIsProAttribute()
    {
        return $this->attributes['plan_id'] == 3;
    }




    public function getCreatedAtAttribute($value)
    {
        return date_format(date_create($value), 'M d, Y');
    }






    public function getisActiveAttribute($value)
    {
        return $this->attributes['is_active'];
    }




    public function getUrlAttribute()
    {
        $subdomain = explode('.', $this->attributes['subdomain']);
        if( count($subdomain) > 1 ) :
            $url = 'http://' . $this->attributes['subdomain'];
        else :
            $url = 'http://' . $this->attributes['subdomain'] . '.cloudstore.ph';
        endif;
        
        return $url;
    }
}
