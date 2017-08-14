<?php
//创建画布
    namespace app\gdlea\controller;

   class Verify
   {
       public function verify()
       {
           $width = 400;
           $height = 500;
           $image = imagecreatetruecolor($width,$height);
//    创建颜色
           $white = imagecolorallocate($image,255,255,255);
           imagefilledrectangle($image,0,0,$width,$height,$white);
//    创建画笔颜色
           $randColor = imagecolorallocate($image,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
//    开始绘制
           $size = mt_rand(20,28);
           $angle = mt_rand(-15,15);
           $x = 50;
           $y = 30;
           $fontFile = 'font/FZSTK.TTF';
           $text = mt_rand(1000,99999);
           imagettftext($image,$size,$angle,$x,$y,$randColor,$fontFile,$text);
//    告诉浏览器以图形显示
           header('content-type:image/png');
//    输出图像
           imagepng($image);
//    销毁图像
           imagedestroy($image);
       }
   }