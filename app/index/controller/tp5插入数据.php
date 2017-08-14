<?php

namespace app\index\controller;
use think\Controller;
use think\Db;

class Index extends Controller
{
    public function  index()
    {
        $db = Db::name('user');

        #insert   返回值是影响记录的行数(插入数)
        #insertGetId 返回插入数据的自增id
        #insertAll 返回插入数据成功的行数
//        $res = $db->insert([
//            'nickname' => 'hello',
//            'time' => time()
//        ]);

        #获取到自增id
            $res = $db->insertGetId([
            'nickname' => 'hello00',
            'time' => time()
        ]);

            $data = [];
            for($i=0;$i < 10;$i++){
                $data[] = [
                    'nickname' => "hello00{$i}",
                    'time' => time()
                ];
            }

//            tp插入全部数据
        $res = $db->insertAll($data);
//            var_dump($data);
        var_dump($res);
    }
}

