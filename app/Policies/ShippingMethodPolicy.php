<?php

namespace App\Policies;

use App\User;
use App\ShippingMethod;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShippingMethodPolicy
{
    use HandlesAuthorization;


    public function manageShippingMethod(User $user, ShippingMethod $shippingMethod)
    {
        return $user->id === $shippingMethod->store->user->id;
    }
    
}
