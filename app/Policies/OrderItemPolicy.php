<?php

namespace App\Policies;

use App\User;
use App\OrderItem;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderItemPolicy
{
    use HandlesAuthorization;


    public function manageOrderItem(User $user, OrderItem $orderItem)
    {
        return $user->id === $orderItem->order->store->user->id;
    }
    
}
