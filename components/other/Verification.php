<?php

class Verification{
    public $width = 120;
    public $height = 34;
    public $size = 21;
    public $num = 6;
    public $type = 1;
    private $str = '0123456789abcdefghijkmnpqrstuvwxyABCDEFGHJKLMNPQRSTUVWXY';

    public function __construct($width,$height,$size){
        if(!empty($width))  $this->width = $width;
        if(!empty($height)) $this->height= $height;
        if(!empty($size)) $this->size= $size;
    }

    public static function getNew($width=120,$height=34,$size=21){
        static $val = null;
        if($val == null) $val = new Verification($width,$height,$size);
        return $val;
    }
    /**
     *	验证码函数
     *	@param int $width 验证码宽度
     *	@param int $height 验证码高度
     *	@param int $size  验证码文字大小
     *	@param int $num 字符串长度
     *	@param int $type 字符串类型 1.数字+大小写 2.数字 3.大写字母 4.大小写字母
     *	@return string $str 验证码生成的字符串
     *	@author SunKai 2014/03/10 sunkai@lampbrother.net
     */

    public function get_code($key='code'){

        //1.创建画布
        $im =imageCreateTrueColor($this->width,$this->height);

        $white = imageColorAllocate($im,255,255,255);
        $block = imageColorAllocate($im,000,000,000);
        $red   = imageColorAllocate($im,rand(000,255),rand(000,255),rand(000,255));
        imagecolorallocate($im,100,105,111);
        //imageantialias($im,true);
		//2.开始绘画

        imageFill($im,0,0,$white);
        //获取随机字符串
        $str = Verification::get_string($this->type,$this->num);
        //绘制字符串
        $ttf = dirname(__FILE__) . '/ttf/shadow.otf';
        $width = imagettfbbox($this->size,0,$ttf,$str);

        $w = ($this->width - 1 - ($width[0] + $width[2]))/2;
        $h = ($this->height - ($width[3] + $width[5]))/2;
        imagettftext($im,$this->size,0,intval($w),intval($h),$red,$ttf,$str);
        ob_clean();

        //3.输出图像
        Yii::app()->user->setState($key,md5(strtolower($str)));
        header('Content-type:image/jpeg');
        imageJpeg($im);
        //4.销毁资源
        imageDestroy($im);
    }

    private function get_string($type,$num){

        //判断字符串类型
        $start = 0;
        $end = 0;
        switch($type){
            case 1:
                $start = 0;
                $end = 55;
                break;
            case 2:
                $start = 0;
                $end = 9;
                break;
            case 3:
                $start = 10;
                $end = 32;
                break;
            case 4:
                $start = 10;
                $end = 55;
                break;
			case 5:
				$start = 0;
				$end = 32;
				break;
            case 6:
                $start = 33;
                $end = 55;
        }
        //字符串保存变量
        $temp = '';
        for($i=0;$i<rand($num-2,$num);$i++){
            $rand = rand($start,$end);
            //指定编码集截取字符串
            $temp .= mb_substr($this->str,$rand,1,'utf-8');
        }
        return $temp;
    }

    /**
     * 验证码匹配
     */
    public static function check($c,$key='code'){
        if(empty($c)) return false;
        $session = Yii::app()->user->getState($key);
        if(strcasecmp(md5(strtolower($c)),$session) != 0){
            return false;
        }
		return true;
    }
}
