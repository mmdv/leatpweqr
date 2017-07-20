<?php
/**
 * Created by PhpStorm.
 * Date: 2017-07-20
 * Time: 9:21
 */
//    namespace app\index\controller;
//
//    class Index
//    {
//        public function index()
//        {
//            return "this is index index index";
//        }
//
//        public  function  common()
//        {
//            return "common";
//        }
//
//    }

namespace app\index\controller;
use app\common\controller\Index as commonIndex;

class Index
{
    public function index()
    {
        return "this is index index index";
    }

    public  function  common()
    {
        echo "admin comomn ";
        $common = new commonIndex();
        return $common->index();
//        return "common";
    }

}