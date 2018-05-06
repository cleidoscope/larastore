<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $table = 'product_reviews';
    protected $fillable = ['product_id', 'user_id', 'rating', 'comment', 'is_approved'];



    public function product()
    {
        return $this->belongsTo('App\Product');
    }


    public function user()
    {
        return $this->belongsTo('App\User');
    }


    
    public function getCreatedAtAttribute($value)
    {
        return date_format(date_create($value), 'M d, Y h:i a');
    }
}
