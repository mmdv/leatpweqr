<?php

    namespace app\index\controller;

    class Test
    {
        public function test()
        {
            $data = json_encode([1,2,3,4]);
            var_dump(json_encode($data));
            echo '<a href="javascript:;">跳转</a>';
        /*    $formStr = '<form method="post" action="http://localhost/index.php/test/test/test" target="_blandk">';
                $formStr.='<input type="hidden" value="'.$data.'" name="content">';
                $formStr.='<input type="submit" value="制作二维码">';
            $formStr.='</form>'*/;

//            echo $formStr;
        }

        public function say()
        {
            echo "helloWorld";
        }
    }