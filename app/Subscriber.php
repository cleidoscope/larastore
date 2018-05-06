<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $table = 'subscribers';
    protected $fillable = ['full_name', 'email', 'is_subscribed'];
}
