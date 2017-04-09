<?php
class Image
{
    //加水印方法
    /**
     * @param $dst
     * @param $water
     * dst 要加水印的图片的路径
     * water 水印图片的路径
     * positon 水印图片的位置，采用九宫格的方式，9表示右下角，1表示左上角
     */
    public static function water($dst,$water,$position=9)
    {
        //获取要加水印的图片的信息
        $dst_info = getimagesize($dst);//图像相关信息的一个数组
        echo "<pre>";
        print_r($dst_info);
        echo "</pre>";
        die;
        /**
         * Array
        (
        [0] => 500 宽度
        [1] => 600 高度
        [2] => 2 图像的类型：1 = GIF，2 = JPG，3 = PNG，4 = SWF，5 = PSD，6 = BMP。。。
        [3] => width="500" height="600" 文本字符串，内容为"height="yyy" width="xxx""，可直接用于 IMG 标记
        [bits] => 8 每种颜色的位数
        [channels] => 3 对于 RGB 图像其值为 3，对于 CMYK 图像其值为 4
        [mime] => image/jpeg 符合该图像的 MIME 类型。此信息可以用来在 HTTP Content-type 头信息中发送正确的信息
        )
         */
        //要加水印的图片，可能是jpg图片，也可能是gif图片，也可能是png图片
        //打开图片
        //$dst_img = imagecreatefromjpeg();
        //根据mime动态的打开一个图像
        $dstCreateFun = str_replace('/','createfrom',$dst_info['mime']);//形成了一个动态的函数
        $dst_im = $dstCreateFun($dst);

        //用同样的方法获取水印图片的信息，以及打开水印的图片
        $water_info = getimagesize($water);
        $waterCreateFun = str_replace('/','createfrom',$water_info['mime']);
        $water_im = $waterCreateFun($water);

        //动态配置水印图片的位置
        switch($position){
            case 1;//左上角
                $x = 0;
                $y = 0;
            case 2;//左中部
                $x = ($dst_info[0] - $water_info[0]) / 2;
                $y = 0;
            case 3;//右上角
                $x = $dst_info[0] - $water_info[0];
                $y = 0;
            case 4;//左中部
                $x = 0;
                $y = ($dst_info[1] - $water_info[1]) / 2;
            case 5;//正中部
                $x = ($dst_info[0] - $water_info[0]) / 2;
                $y = ($dst_info[1] - $water_info[1]) / 2;
            case 6;//右中部
                $x = $dst_info[0] - $water_info[0];
                $y = ($dst_info[1] - $water_info[1]) / 2;
            case 7;//左下角
                $x = 0;
                $y = $dst_info[1] - $water_info[1];
            case 8;//中下部
                $x = ($dst_info[0] - $water_info[0]) / 2;
                $y = $dst_info[1] - $water_info[1];
            case 9;//右下角
                $x = $dst_info[0] - $water_info[0];
                $y = $dst_info[1] - $water_info[1];
        }

        //加水印，使用函数：水印图片png--imagecopy(),水印图片jpg/jif--imagecopymerge()
        if($water_info[2] == 3)
        {
            //水印图片是png
            imagecopy($dst_im,$water_im,$x,$y,0,0,$water_info[0],$water_info[1]);
        }else
        {
            imagecopymerge($dst_im,$water_im,$x,$y,0,0,$water_info[0],$water_info[1],80);
        }

        //保存加好水印的图片dst
        //创建一个保存图片的动态函数
        $saveFun = str_replace('/','',$dst_info['mime']);
        //$saveFun($dst_im,'12.jpg');
        $saveFun($dst_im,$dst);//将原图覆盖

        //销毁图像资源
        imagedestroy($dst_im);
        imagedestroy($water_im);


    }
        //缩略图
        //函数中，src和dst的含义：把src图片（要缩略的图片）拷贝到dst图片(小图)上
        /**
         * 要进行缩略的图片src 缩略后的图片dst
         * width 缩略后的宽度
         * height 缩略后的高度
         * is_dengbi 是否是等比缩放，true表示是等比例缩放，false表示不是等比例缩放，默认为true
         * 等比例缩放时以缩放大的比例为准
         *
         */
        public static function thumb($src,$width,$height,$is_dengbi = true )
        {
            //获取图像的信息
            $src_info = getimagesize($src);
            echo "<pre>";
            print_r($src_info);
            //创建一个打开图像的函数
            $srcCreateFun = str_replace('/','createfrom',$src_info['mime']);
            //打开要缩略的图片
            $src_im = $srcCreateFun($src);

            //计算真实的宽、高，实现等比缩放
            $w = $width;//真实的宽度
            $h = $height;//真实的高度
            if($is_dengbi)
            {
                /*$src_info[0];//原始的宽度
                $src_info[1];//原始的高度
                $width;      //用户传递的宽度
                $height;     //用户传递的高度*/

                if($src_info[0] / $width >= $src_info[1] / $height)
                {
                    //以新的宽度为标准
                    $w = $width;
                    $h = ($src_info[1]*$width) / $src_info[0];
                }else
                {
                    //以新的高度为标准
                    $h = $height;
                    $w = ($src_info[0]*$height) / $src_info[1];
                }
            }


            //创建一个小图
            $dst_im = imagecreatetruecolor($w,$h);
            //拷贝(缩略处理)
            imagecopyresampled($dst_im,$src_im,0,0,$w,$h,$width,$height,$src_info[0],$src_info[1]);
            //保存缩略后的图片
            //创建保存缩略后图片的动态函数
            $dstSaveFun = str_replace('/','',$src_info['mime']);
            //$dstSaveFun($dst_im,'13.jpg');
            //覆盖原图
            $dstSaveFun($dst_im,$dst_im);

            //销毁图像资源
            imagedestroy($dst_im);
            imagedestroy($src_im);
        }


}
//Image::water('1.jpg','water.jpg');
//根据原图的宽度和高度，进行等比例缩放
Image::thumb('2.jpg',480,320);