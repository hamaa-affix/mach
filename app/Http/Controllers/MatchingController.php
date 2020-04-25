<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Reaction;
use App\User;
use Auth;

use App\Constants\Status;

class MatchingController extends Controller
{
    public static function index(){

        $got_reaction_ids = Reaction::where([
            //リレーションされた、userid と to_userid、sutatus = Likeが一致したものを取得
            ['to_user_id', Auth::id()], 
            ['status', Status::LIKE]
            //上記の条件が一致したfrom_user_idを取得しする（いいね）
            ])->pluck('from_user_id');

        //いいねをしてきた人を探しつつ
        $matching_ids = Reaction::whereIn('to_user_id', $got_reaction_ids)
        //whereでさらに条件を絞りつつ
        ->where('status', Status::LIKE)
        ->where('from_user_id', Auth::id())
        //上記の条件にあったto_user_idを取得する。
        ->pluck('to_user_id');

        //userのidと先ほど定義した中間テーブルでマッチングしているUser::id を取得。
        $matching_users = User::whereIn('id', $matching_ids)->get();
        
        //マッチングしている人のカウント
        $match_users_count = count($matching_users);
        //マッチングしているuser、カウント数を引き渡す。
        return view('users.index', compact('matching_users', 'match_users_count'));
    }
}
