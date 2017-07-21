<?php
namespace app\index\controller;
use think\Config;
use think\Env;
class Index
{
    public function index()
    {
        // dump($_ENV['email']);  //获取不到系统变量
        // $res = Env::get('email','def'); //无第一个参数则返回def
        // dump($res);

        // $res = Env::get('database_username');
        // $res = Env::get('database.username');  //使用.语法代码可读性更高
        // dump($res);

        // $res = Env::get('status','prod');
        dump(config());
    }

}
