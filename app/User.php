<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['first_name', 'last_name', 'email', 'password', 'role', 'registration_type', 'street', 'city', 'province', 'zip', 'phone', 'email_notifications', 'last_login'];
    protected $hidden = ['password', 'remember_token'];



    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }



    public function getInitialNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'][0].'.';
    }



    public function getIsAdminAttribute()
    {
        return $this->attributes['role'] == \Roles::Admin();
    }



    public function getIsManagerAttribute()
    {
        return $this->attributes['role'] == \Roles::Manager();
    }


    public function getEmailNotificationsAttribute($value)
    {
        if( $value ) :
            return json_decode($value);
        else :
            return [];
        endif;
    }




    public function getIsCustomerAttribute()
    {
        return $this->attributes['role'] == \Roles::Customer();
    }



    public function stores()
    {
        return $this->hasMany('App\Store')->orderBy('created_at', 'desc');
    }




    public function invoices()
    {
        return $this->hasMany('App\Invoice')->orderBy('created_at', 'desc');
    }

    

    public function orders()
    {
        return $this->hasMany('App\Order')->orderBy('created_at', 'desc');
    }



    public function product_reviews()
    {
        return $this->hasMany('App\ProductReview')->orderBy('created_at', 'desc');
    }



    public function activities()
    {
        return $this->hasMany('App\UserActivity')->orderBy('created_at', 'desc');
    }
}
