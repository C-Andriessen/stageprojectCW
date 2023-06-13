<?php

namespace App\Http\Controllers;

use App\Models\PasswordSecurity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordSecurityController extends Controller
{

    public function generateSecret()
    {
        $user = request()->user();
        request()->session()->flash('2fa', true);
        // Initialise the 2FA class
        $google2fa = app('pragmarx.google2fa');

        // Add the secret key to the registration data
        PasswordSecurity::create([
            'user_id' => $user->id,
            'google2fa_enable' => 0,
            'google2fa_secret' => $google2fa->generateSecretKey(),
        ]);

        return redirect()
            ->route('user.profile.edit', compact('user'))
            ->with('success', "Geheime code is aangemaakt, activeer je account door de code in te voeren");
    }

    public function enable(Request $request)
    {
        $user = $request->user();
        $request->session()->flash('2fa', true);
        $google2fa = app('pragmarx.google2fa');
        $secret = $request->input('verify-code');
        $valid = $google2fa->verifyKey($user->passwordSecurity->google2fa_secret, $secret);
        if ($valid)
        {
            $user->passwordSecurity->google2fa_enable = 1;
            $user->passwordSecurity->save();
            return redirect()->route('user.profile.edit', compact('user'))->with('success', "2FA is geactiveerd");
        }
        else
        {
            return redirect()->route('user.profile.edit', compact('user'))->with('error', "De code klopt niet, probeer het opnieuw");
        }
    }

    public function disable(Request $request)
    {
        $request->session()->flash('2fa', true);
        if (count($request->user()->socialProviders) == 0)
        {
            if (!(Hash::check($request->get('current-password'), $request->user()->password)))
            {
                // The passwords matches
                return redirect()->back()->with("error", "Je wachtwoord komt niet overeen met die van je account");
            }
            $validatedData = $request->validate([
                'current-password' => 'required',
            ]);
        }

        $user = $request->user();
        $user->passwordSecurity->google2fa_enable = 0;
        $user->passwordSecurity->save();
        return redirect()->route('user.profile.edit', compact('user'))->with('success', "2FA is nu uitgeschakeld");
    }
}
