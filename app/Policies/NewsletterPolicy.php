<?php

namespace App\Policies;

use App\User;
use App\Newsletter;
use Illuminate\Auth\Access\HandlesAuthorization;

class NewsletterPolicy
{
    use HandlesAuthorization;


    public function manageNewsletter(User $user, Newsletter $newsletter)
    {
        return $user->id === $newsletter->store->user->id;
    }
    
}
