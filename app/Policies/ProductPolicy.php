<?php

namespace App\Policies;

use App\User;
use App\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;


    public function manageProduct(User $user, Product $product)
    {
        return $user->id === $product->store->user->id;
    }
    
}
