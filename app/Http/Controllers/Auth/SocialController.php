<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Socialite;
use App\Models\SocialProvider;

class SocialController extends Controller
{
    public function redirectToProvider()
    {
        $provider = request()->provider;
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback()
    {
        $provider = request()->provider;
        try
        {
            $socialUser = Socialite::driver($provider)->user();
        }
        catch (\Exception $e)
        {
            return redirect('/');
        }

        //check if we have logged provider
        $socialProvider = SocialProvider::where('provider_id', $socialUser->getId())->first();
        if (!$socialProvider)
        {
            //create a new user and provider
            $user = User::firstOrCreate(
                [
                    'email' => $socialUser->getEmail(),
                    'name' => $socialUser->getName(),
                    'role_id' => Role::USER,
                ]
            );
            $user->socialProviders()->create(
                ['provider_id' => $socialUser->getId(), 'provider' => $provider]
            );
        }
        else
        {
            $user = $socialProvider->user;
        }

        auth()->login($user);
        return redirect('/');
    }
}
