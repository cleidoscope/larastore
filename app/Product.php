<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
    protected $table = 'products';
    protected $fillable = ['title', 'description', 'price', 'old_price', 'weight', 'store_id', 'in_stock', 'is_featured', 'product_category_id', 'slug'];


    public function store()
    {
        return $this->belongsTo('App\Store');
    }



    public function product_category()
    {
        return $this->belongsTo('App\ProductCategory');
    }



    public function product_images()
    {
        return $this->hasMany('App\ProductImage')->orderBy('order', 'asc');
    }



    public function product_reviews()
    {
        return $this->hasMany('App\ProductReview')->orderBy('created_at', 'desc');
    }



    
    public function getCreatedAtAttribute($value)
    {
        return date_format(date_create($value), 'M d, Y h:i a');
    }


    public function getUrlAttribute()
    {
        $category = $this->product_category;
        if( $category ) :
            return '/' . $category->slug . '/' . $this->attributes['slug'];
        else :
            return '/product/' . $this->attributes['slug'];
        endif;
    }


}
