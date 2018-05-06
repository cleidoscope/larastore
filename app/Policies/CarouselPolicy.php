<?php

namespace App\Policies;

use App\User;
use App\Carousel;
use Illuminate\Auth\Access\HandlesAuthorization;

class CarouselPolicy
{
    use HandlesAuthorization;


    public function manageCarousel(User $user, Carousel $carousel)
    {
        return $user->id === $carousel->store->user->id;
    }
    
}
