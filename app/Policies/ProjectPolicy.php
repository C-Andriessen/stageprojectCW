<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\ProjectsUsers;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
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
    public function show(User $auth_user, Project $project)
    {

        if ($auth_user->role->id == Role::ADMIN)
        {
            return true;
        }


        foreach ($project->users as $user)
        {
            if ($user->is($auth_user))
            {
                return true;
            }
        }
    }
}
