<?php

namespace App\Policies;

use App\Models\Address;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AddressPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Address $address)
    {
        if ($user->id != $address->user_id) {
            return false;
        } else {
            return true;
        }
    }

    public function delete(User $user, Address $address)
    {
        if ($user->id != $address->user_id) {
            return false;
        } else {
            return true;
        }
    }
}
