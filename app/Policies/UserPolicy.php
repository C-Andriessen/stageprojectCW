<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
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

    public function editUpdate(User $auth_user)
    {
        return ($auth_user->role->id == Role::ADMIN) || $auth_user->is(Auth::user());
    }

    public function isAdmin(User $auth_user)
    {
        return $auth_user->role->id == Role::ADMIN;
    }
}
