<?php

namespace App\Policies;

use App\Models\Settlement;
use App\Models\User;

class SettlementPolicy
{
    public function view(User $user, Settlement $settlement): bool
    {
        return $user->id === $settlement->instructor_id || $user->isAdmin();
    }

    public function approve(User $user, Settlement $settlement): bool
    {
        return $user->isAdmin();
    }

    public function reject(User $user, Settlement $settlement): bool
    {
        return $user->isAdmin();
    }

    public function pay(User $user, Settlement $settlement): bool
    {
        return $user->isAdmin() && $settlement->isApproved();
    }
}
