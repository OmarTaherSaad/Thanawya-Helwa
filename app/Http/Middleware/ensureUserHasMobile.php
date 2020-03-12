<?php

namespace App\Http\Middleware;

use Closure;

class ensureUserHasMobile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!\Auth::check()) {
            return redirect()->route('login');
        }
        if (!is_numeric(\Auth::user()->mobile_number)) {
            session()->flash('warning', 'محتاجين تكون مسجل رقم الموبايل. لازم تكتب رقم الموبايل اللي استخدمته / هتستخدمه في الدفع.');
            return redirect()->route('users.edit',[
                'user' => \Auth::user()
            ]);
        }
        return $next($request);
    }
}
