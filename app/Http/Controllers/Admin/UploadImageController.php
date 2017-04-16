<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Controller;

class UploadImageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    //
    public function upload(Request $request)
    {
        debugbar()->disable();
        //dd($request->file());
        //一般图片上传
        $file = $request->file('file');
        if ($file) {
            $name = date('YmdHis') . random_int(1000, 9999) . '.' . $file->getClientOriginalExtension();
            //dd($name);
            $new_file = $file->move('upload/image', $name);
            if ($new_file) {
                $message = ['error' => 0,'src'=>"/upload/image/$name"];
                return json_encode($message);
            }
        }

        //product模块用来填写描述的图片
        //成功：返回图片路径
        //失败：返回 'error|错误信息提示...' 格式的字符串
        $file = $request->file('description_image');
        if($file){
            $name = date('YmdHis') . random_int(1000, 9999) . '.' . $file->getClientOriginalExtension();

            $new_file = $file->move('upload/image', $name);
            if ($new_file) {
                $src = "/upload/image/$name";
                return $src;
            }
        }

        return $request->hasFile('description_image')? 'error|上传失败...':json_encode(['error' => 1]);
    }
}
