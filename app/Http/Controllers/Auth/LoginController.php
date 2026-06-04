<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Support\PageSeo;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {
        if (is_numeric($request->get('email'))) {
            return ['mobile_number' => $request->get('email'), 'password' => $request->get('password')];
        }
        return ['email' => $request->get('email'), 'password' => $request->get('password')];
    }

    public function showLoginForm()
    {
        if(!session()->has('url.intended'))
        {
            session(['url.intended' => url()->previous()]);
        }
        PageSeo::applyNoindex(
            'تسجيل الدخول | ثانوية حلوة',
            'دخول أعضاء فريق ثانوية حلوة.',
            route('login')
        );

        return view('auth.login');
    }

     /**
     * Where to redirect users after login.
     *
     * @return string
     */
    protected function redirectTo()
    {
        if(session()->has('url.intended')) {
            return session('url.intended');
        } else {
            return '/home';
        }
    }
}
