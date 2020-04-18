<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
     //プロフィールの詳細画面
    public function show($id)
    {
        //findorFailでidに紐ずくカラムを取得、なければ例外処理を行う。
        $user = User::findorFail($id);
        return view('users.show', compact('user'));
    }
}
