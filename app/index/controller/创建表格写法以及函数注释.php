<?php

    namespace app\index\controller;

    class Index
    {
        /**
         * 按照需求创建指定表格
         * 必选参数一定在可选参数之前,带默认值在后
         * @param string $rows
         * @param string $cols
         * @return string
         */
        public function index($rows='4',$cols='3',$content="hello",$bgcolor="red")//6
        {
            /**
             * 学习这个拼接表格的过程
             * 参数的例子
             * 返回一个3行2列的表格
             */

            /**
             * 创建3行两列的表格
             * @return string
             */
            $table = "<table border='1' cellpadding='0' cellspacing='0' width='80%' align='center' bgcolor=$bgcolor>"; //1
                for($i=1;$i<=$rows;$i++){//2
                    $table.="<tr>";//3
                        for($j=1;$j<=$cols;$j++){//4
                            $table.="<td>$content</td>";//5
                        }
                    $table.="<tr/>";//3
                }
            $table.="</table>";//1
            return $table;
        }
    }