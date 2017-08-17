<?php

namespace app\index\controller;
use app\index\model\User;

class Index
{
    public function index()
    {
//        $res = User::create([
//            'nickname' => 'goodwin',
//            'sex' => 1,
//            'num' => 10
//        ]);
        $userModel = User::get(16);
        $userModel->sex = 1;
        $res = $userModel->save();
        var_dump($res);
    }
}