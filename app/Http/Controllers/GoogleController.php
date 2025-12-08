<?php

namespace App\Http\Controllers;

use Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        // cari user berdasarkan email
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // jika belum ada → buat user baru
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => bcrypt(str()->random(16)), // random password
                'google_id' => $googleUser->getId(),
            ]);
        }

        // login ke laravel
        Auth::login($user);

        return redirect('/dashboard');
    }
}
