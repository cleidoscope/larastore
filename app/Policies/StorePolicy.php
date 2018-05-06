<?php
namespace App\Policies;

use App\User;
use App\Store;
use Illuminate\Auth\Access\HandlesAuthorization;

class StorePolicy
{
    use HandlesAuthorization;


    public function manageStore(User $user, Store $store)
    {
        return $user->id === $store->user->id;
    }
}
