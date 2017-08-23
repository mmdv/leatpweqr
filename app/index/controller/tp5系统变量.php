<?php
namespace app\index\controller;
use think\Controller;
use think\View;

class Index extends Controller
{
    public function index()
    {
//        var_dump($_SERVER);
//        session('email','120000');
//        cookie('name','乌云龙');
        return $this->fetch();
    }
}