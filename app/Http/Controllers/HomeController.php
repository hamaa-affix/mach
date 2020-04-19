<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::all(); 
        //前ユーザー数を取得
        $userCount = $users->count(); 
        //現在ログインしているユーザーを取得
        $from_user_id = Auth::id(); 

        return view('home', compact('users', 'userCount', 'from_user_id')); 
    }
}
