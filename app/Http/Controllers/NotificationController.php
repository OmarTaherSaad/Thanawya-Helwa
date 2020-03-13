<?php

namespace App\Http\Controllers;

use App\Events\NewPostUnderReviewAdded;
use App\Notifications\NewPostAddedNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function notify()
    {
        $post = \App\Models\Team\Post::find(2);
        auth()->user()->notify(new NewPostAddedNotification($post));
        //dd($post);
        //NewPostUnderReviewAdded::dispatch($post);

    }

    public function view()
    {
        return view('welcome');
    }
}
