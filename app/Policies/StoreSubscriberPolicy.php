<?php

namespace App\Policies;

use App\User;
use App\StoreSubscriber;
use Illuminate\Auth\Access\HandlesAuthorization;

class StoreSubscriberPolicy
{
    use HandlesAuthorization;


    public function manageStoreSubscriber(User $user, StoreSubscriber $storeSubscriber)
    {
        return $user->id === $storeSubscriber->store->user->id;
    }
    
}
