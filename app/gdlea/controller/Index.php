<?php

namespace  app\gdlea\controller;

class Index
{
    public function index()
    {
        /*
         * 画布黑色
         * 字体太小
         * */
//            创建画布
        $image =    imagecreatetruecolor(500,500);
//            创建颜色
        $white = imagecolorallocate($image,255,255,255);
        $randColor = imagecolorallocate($image,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
//            绘制填充矩形
        imagefilledrectangle($image,0,0,500,500,$white);
//        echo "<img src='".DIRECTORY_SEPARATOR."images".DIRECTORY_SEPARATOR."11.jpg"."'>";

//            绘画
//            imagettftext();
//            windows->运行 ->fonts
        imagettftext($image,20,0,100,100,$randColor,'font/FZSTK.TTF','hello');
        imagettftext($image,30,40,200,200,$randColor,'font/FZSTK.TTF','world');
//            告诉浏览器以什么图片形式显示
        header ( "Content-type: image/png" );
//            输出图像
        imagepng($image);
        imagepng($image,'images/1.png');//保存文件
//            销毁资源
        imagedestroy($image);
    }

    public function demo() {
        header("Content-Type:image/jpg");
        $image=imagecreate(300,80);
        $bgcolor=imagecolorallocate($image,200,60,90);
        $write=imagecolorallocate($image,0,0,0);
        imagestring($image,5,80,30,"I Like PHP",$write);
        imagejpeg($image);
        imagedestroy($image);
    }
}