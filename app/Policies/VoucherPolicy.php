<?php

namespace App\Policies;

use App\User;
use App\Voucher;
use Illuminate\Auth\Access\HandlesAuthorization;

class VoucherPolicy
{
    use HandlesAuthorization;


    public function manageVoucher(User $user, Voucher $voucher)
    {
        return $user->id === $voucher->store->user->id;
    }
    
}
