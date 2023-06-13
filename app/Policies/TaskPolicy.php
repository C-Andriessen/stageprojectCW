<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
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
    public function show(User $auth_user, Task $task)
    {
        return ($auth_user->role->id == Role::ADMIN) || ($auth_user->is($task->user));
    }

    public function approve(User $auth_user, Task $task)
    {
        return ($auth_user->role->id == Role::ADMIN) || ($auth_user->is($task->user));
    }
}
