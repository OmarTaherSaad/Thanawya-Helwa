<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Team/member entry: visit /admin in the browser (not linked from the public navbar).
 */
class AdminEntryController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->user()) {
            return redirect('/home');
        }

        return redirect()->guest(route('login'));
    }
}
