<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\User;

class SocialController extends Controller
{
    public function redirectToProvider($provider) {
        if(!session()->has('url.intended')) {
            session()->put('url.intended',url()->previous()); //to return him back
        }
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider) {
        $getInfo = Socialite::driver($provider)->user();
        abort_if($getInfo->email != 'omartahersaad@protonmail.com',401); //Only Omar Taher (for now)
        $user = $this->createUser($getInfo,$provider);
        auth()->login($user);
        if(session()->has('url.intended')) {
            return redirect()->to(session()->get('url.intended'));
        }
        return redirect()->route('tas.home');
    }

    function createUser($getInfo, $provider)
    {
        $user = User::where('provider_id', $getInfo->id)->first();
        if (!$user) {
            $user = User::create([
                'name' => $getInfo->name,
                'email' => $getInfo->email,
                'provider' => $provider,
                'provider_id' => $getInfo->id,
            ]);
        }
        return $user;
    }
}
