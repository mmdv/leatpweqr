<?php
namespace app\index\controller;

use app\common\controller\Index as commonIndex;

class Index
{
    public function index()
    {
    	dump(config());
    }
}
