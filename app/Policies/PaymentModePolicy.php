<?php

namespace App\Policies;

use App\User;
use App\PaymentMode;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentModePolicy
{
    use HandlesAuthorization;


    public function managePaymentMode(User $user, PaymentMode $paymentMode)
    {
        return $user->id === $paymentMode->store->user->id;
    }
    
}
