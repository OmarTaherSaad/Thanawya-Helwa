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

        //Create Tickets

foreach(\App\Ticket::all() as $ticket) {
    $qr = Image::make(base_path('/public/storage/QRs/'.$ticket->id.'.png'))->resize(300,300);
    $image = Image::make(base_path('/public/storage/template2.jpg'))
    ->insert($qr,'bottom-left',275,45);
    $image->text($ticket->serial(),$image->width() - 90,365,function($font) {
    $font->file(base_path('/public/css/fonts/Tajawal-Regular.ttf'));
    $font->size(50);
    $font->angle(90);
    $font->valign('center');
    $font->align('center');
    })
    ->text($ticket->id,$image->width() - 71,$image->height() - 73,function($font) {
    $font->file(base_path('/public/css/fonts/Tajawal-Regular.ttf'));
    $font->size(35);
    $font->valign('center');
    $font->align('center');
    });
    $image->save('storage/ticket/' .$ticket->id.'.jpg');
}
dd('Done');

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
