<?php
namespace app\index\controller;
use think\Config;
class Index
{

    public function index()
    {
    	// $res = \think\Config::get();
    	// $res = Config::get();
    	// $res = config();

    	// 获取配置
    	// $res = Config::get('app_namespace');
    	// $res = config('app_namespace');

    	// 设置配置
    	// Config::set('username','alone');
    	// config('usernames','alone');
		// dump(Config::get('usernames'));

    	// 设置配置于某个作用域下
    	// Config::set('username','alone','index');
    	// dump(Config::get('username','index'));

    	// config('username','alone','index');
    	// dump(config('username','index'));  //null
    	// dump(Config::get('username','index'));//alone

    	// 检测配置中是否还有某个配置
    	Config::set('username','qwe');
    	// $res = Config::has('username'); //username 不存在或者为null 结果都返回false

    	$res = config('?username');

    	dump($res);
    	
    }

}
