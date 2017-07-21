<?php
namespace app\index\controller;

use think\Request;

class Index
{
    public function index(Request $request)
    {  
    	// $request = request();  
    	$request = Request::instance();
    	// 方式3:传参数 注入

    	dump($request);
        return "this is index index index";
    }
}
