<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreSubscriber extends Model
{
    protected $table = 'store_subscribers';
    protected $fillable = ['store_id', 'full_name', 'email', 'is_subscribed'];




    public function store()
    {
        return $this->belongsTo('App\Store');
    }



    public function getStatusAttribute()
    {
    	switch( $this->attributes['is_subscribed'] ) :
    	 	case true :
    	 		return "Active";
    	 		break;
    	 	case false :
    	 		return "Unsubscribed";
    	 		break;
    	endswitch;
    }

}
