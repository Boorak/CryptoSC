<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;

class RegisterConfirmationController extends Controller
{
    public function index()
    {

        $user = User::where('confirmation_token', \request('token'))->first();

        if (!$user) {
            return redirect(route('threads'))
                ->with('flash', 'Unknown token.');
        }

        $user->confirm();
        return redirect(route('threads'))
            ->with('flash', 'حساب کاربری شما با موفقیت فعال شد.');
    }
}
