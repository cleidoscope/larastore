<?php

namespace App\Policies;

use App\User;
use App\ProductCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductCategoryPolicy
{
    use HandlesAuthorization;


    public function manageProductCategory(User $user, ProductCategory $productCategory)
    {
        return $user->id === $productCategory->store->user->id;
    }
    
}
