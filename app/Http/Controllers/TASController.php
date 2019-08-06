<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

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

    }
}