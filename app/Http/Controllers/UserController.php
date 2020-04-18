<?php

namespace App\Http\Controllers;
use Intervention\Image\Facades\Image; 

use App\Services\CheckExtensionServices; 
use App\Services\FileUploadServices; 

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
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
    
    //編集画面の処理
    public function edit($id)
    {
        $user = User::findorFail($id);

        return view('users.edit', compact('user')); 
    }
    
    //データの更新処理
    public function update($id, ProfileRequest $request)
    {

        $user = User::findorFail($id);
        
        //画像ファイルがアップロードされているかどうか判定。
        if(!is_null($request['img_name'])){
            $imageFile = $request['img_name'];

            $list = FileUploadServices::fileUpload($imageFile);
            list($extension, $fileNameToStore, $fileData) = $list;
            
            $data_url = CheckExtensionServices::checkExtension($fileData, $extension);
            $image = Image::make($data_url);        
            $image->resize(400,400)->save(storage_path() . '/app/public/images/' . $fileNameToStore );

            $user->img_name = $fileNameToStore;
        }
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->sex = $request->sex;
        $user->self_introduction = $request->self_introduction;

        $user->save();

        return redirect('home'); 
    }
}
