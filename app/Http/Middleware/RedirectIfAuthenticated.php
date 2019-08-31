<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        if (\auth()->check() && ($request->user()->confirmed == false)) {
            return redirect('/threads')->with('flash', 'حساب کاربری شما فعال نیست! لطفا ایمیل خودتان را چک کنید.');
        }

        return $next($request);
    }
}
