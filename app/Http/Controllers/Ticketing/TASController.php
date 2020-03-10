<?php

namespace App\Http\Controllers\Ticketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class TASController extends Controller
{
    public function countdown() {
        return view('tas.countdown');
    }

    public function home() {
        if(Auth::check()) {
            return view('tas.home');
        } else {
            return $this->countdown();
        }
    }

    public function registerTicket()
    {
        return view('tas.register-ticket');
    }

    public function buyTicketOnline()
    {
        return view('tas.buy-online');
    }

    public function schedule()
    {
        return view('tas.schedule');
    }

    public function hermanTest() {
        return view('tas.herman');
    }
}
