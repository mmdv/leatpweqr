<?php
namespace app\index\controller;

use app\common\controller\Index as commonIndex;

class Index
{
    public function index()
    {  
        return "this is index index index";
    }

    public function common()
	{
		$common = new commonIndex();
		return $common->index();
	}
}
