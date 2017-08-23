<?php
namespace app\index\controller;
use think\Controller;
use think\View;

class Index extends Controller
{
    public function index()
    {
        $this->assign('key','value');
        $this->view->key2 = 'wordk';//继承controller,可以使用view类
        view::share('key3','value3');
        return $this->fetch('index',[  //如果存在__CSS__ 则改变配置的__CSS__值,可以在config下写
            'email'=>'121212'
        ],[
            'STATIC' =>"这个是static替换后内容"
        ]);
    }
}