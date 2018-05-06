<?php

namespace App\Policies;

use App\User;
use App\ShippingRate;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShippingRatePolicy
{
    use HandlesAuthorization;


    public function manageShippingRate(User $user, ShippingRate $shippingRate)
    {
        return $user->id === $shippingRate->shipping_method->store->user->id;
    }
    
}
