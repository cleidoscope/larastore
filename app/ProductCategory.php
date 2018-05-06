<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'product_categories';
    protected $fillable = ['category', 'slug', 'store_id'];



    public function store()
    {
        return $this->belongsTo('App\Store', 'store_id');
    }



    public function products()
    {
        return $this->hasMany('App\Product', 'product_category_id');
    }


    
    public function getCreatedAtAttribute($value)
    {
        return date_format(date_create($value), 'M d, Y h:i a');
    }

}
