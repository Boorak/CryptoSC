<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $thread = Thread::orderBy('replies_count', 'desc')->first();
        $popularThreads = Thread::orderBy('replies_count', 'desc')->take(2)->get();
        return view('home', [
            'thread' => $thread,
            'popularThreads' => $popularThreads,
        ]);
    }
}
