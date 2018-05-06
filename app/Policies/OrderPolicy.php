<?php

namespace App\Policies;

use App\User;
use App\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;


    public function manageOrder(User $user, Order $order)
    {
        return $user->id === $order->store->user->id;
    }
    
}
