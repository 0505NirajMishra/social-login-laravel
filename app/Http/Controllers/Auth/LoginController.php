<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        // New code
        // youtube login :- https://www.youtube.com/watch?v=j-lVevL_72E

        try {

            $googleUser = Socialite::driver('google')->user();
            $user = User::where('google_id', $googleUser->getId())->first();

            if(!$user){
                 $new_user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make('12345678')
                 ]);
                 Auth::login($new_user);
                 return redirect('/');
            }
            else
            {
                 Auth::login($user);
                 return redirect('/');
            }

        } catch (\Exception $e) {
            Log::error("Exception during Google login: " . $e->getMessage());
            return redirect('/')->with('error', 'Google login failed');
        }

    }

}
