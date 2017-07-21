<?php
namespace app\index\controller;

use app\common\controller\Index as commonIndex;

class Index
{
	public function __construct()
	{
		// 所有方法都获取配置
		config('before','beforeAction');
	}

    public function index()
    {
    	config('before0','before0000');
    	dump(config());
    }

    public function demo()
    {
    	dump(config());
    }
}
