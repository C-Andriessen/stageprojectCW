<?php

namespace App\Policies;

use App\Models\ProjectsUsers;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectsUsersPolicy
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
    public function show(User $auth_user, ProjectsUsers $projectUsers)
    {

        if ($auth_user->role->id == Role::ADMIN)
        {
            return true;
        }

        foreach ($projectUsers as $user)
        {
            if ($user->is($auth_user))
            {
                return true;
            }
        }
    }
}
