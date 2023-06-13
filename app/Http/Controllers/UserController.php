<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('isAdmin', User::class);
        $users = User::where('role_id', '!=', Role::ADMIN)->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function adminEdit(User $user)
    {
        $this->authorize('isAdmin', User::class);
        return view('admin.users.edit', compact('user'));
    }

    public function adminUpdate(UpdateUserRequest $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();
        return redirect(route('admin.users.index'))->with('status', __('Profiel bijgewerkt'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();
        return redirect(route('user.profile.index'))->with('status', __('Profiel bijgewerkt'));
    }

    public function profile()
    {

        return view('user.profile.index');
    }

    public function edit(User $user)
    {
        $this->authorize('editUpdate', User::class);

        $google2fa_url = '';
        if ($user->passwordSecurity()->exists())
        {
            $google2fa = app('pragmarx.google2fa');
            $google2fa_url = $google2fa->getQRCodeInline(
                config('app.name'),
                $user->email,
                $user->passwordSecurity->google2fa_secret
            );
        }
        $data = array(
            'user' => $user,
            'google2fa_url' => $google2fa_url
        );

        return view('user.profile.edit', compact('user', 'data'));
    }

    public function delete(User $user)
    {
        $this->authorize('isAdmin', User::class);

        foreach ($user->created_articles as $article)
        {
            if ($article->image)
            {
                unlink(public_path('/images/' . $article->image));
            }
        }
        $user->delete();
        return redirect(route('admin.users.index'))->with('status', __('Gebruiker "' . $user->name . '" is verwijderd'));
    }
}
