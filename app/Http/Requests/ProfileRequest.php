<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Auth;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //authorizaメソッドはユーザーがデータを更新する為の権限を持っているか確認するメソッド
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //ログイン済みユーザーのメールアドレスを取得する
        $myEmail = Auth::user()->email; 
        
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 
                        'string', 
                        'email', 
                        'max:255', 
                        Rule::unique('users', 'email')->whereNot('email', $myEmail)],
        ];
    }
}
