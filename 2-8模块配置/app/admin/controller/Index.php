<?php
namespace app\admin\controller;

use app\common\controller\Index as commonIndex;

class Index
{
    public function index()
    {
    	dump(config());
    }
}
