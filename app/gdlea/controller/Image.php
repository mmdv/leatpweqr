<?php

    namespace app\index\controller;

    class Index
    {
        public function index()
        {
            $myImage=ImageCreate(400,60); //参数为宽度和高度
//            $myImage=ImageCreateFromJpg("localhost/public/11.jpg");

            $white=ImageColorAllocate($myImage, 255, 255, 255);
            $black=ImageColorAllocate($myImage, 0, 0, 0);
            $red=ImageColorAllocate($myImage, 255, 0, 0);
            $green=ImageColorAllocate($myImage, 0, 255, 0);
            $blue=ImageColorAllocate($myImage, 0, 0, 255);


            ImageFilledRectangle($myImage, 50, 20, 200, 15, $blue);
            imagettftext($myImage, 12, 0, 5, 20, $black, "Fonts/Oblivious font.ttf",  "这是要显示的内容");
        }
    }