<?php

    namespace app\index\controller;
    use think\Config;
    use think\Request;

    class Index {
        public function  index(Request $request) {
            $res = [
              'code' => 200,
                'result'=> [
                    'list'=>[1,2,3,4,5,6]
                ]
            ];
//            return 123;   //默认输出类型为.html  在convention.php中配置
            Config::set('default_return_type','json'); //直接return $res为json格式  如果使用dump依然为.html格式
            return $res;
        }
    }