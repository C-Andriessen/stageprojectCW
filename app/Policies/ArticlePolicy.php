<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ArticlePolicy
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

    public function createStore(User $auth_user)
    {
        return $auth_user->role->id == Role::USER || $auth_user->role->id == Role::ADMIN;
    }
    public function editUpdate(User $auth_user, Article $article)
    {
        return $auth_user->role->id == Role::ADMIN || $auth_user->is($article->creating_user);
    }
    public function delete(User $auth_user, Article $article)
    {
        return $auth_user->role->id == Role::ADMIN || $auth_user->is($article->creating_user);
    }
}
