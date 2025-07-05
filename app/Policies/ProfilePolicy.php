<?php

namespace App\Policies;

use App\Models\Profile;
use App\Models\User;

class ProfilePolicy
{
    public function update(User $user, Profile $profile)
    {
        return $user->id === $profile->user_id;
    }
}
