<?php

namespace app\index\controller;
use app\index\model\User;

class Index
{
    public function index()
    {
        $res = User::get(2);
        echo $res->sex;
        var_dump($res->toArray());
        var_dump($res->getData());//获取原始数据
    }
}