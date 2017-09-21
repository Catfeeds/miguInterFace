<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/10 0010
 * Time: 13:37
 */
class Common
{
	public static function getStr($end=32){
		static $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ';
		$s = '';
		while(strlen($s) <= $end){
			$s .= mb_strcut($str,rand(1,strlen($str)),1,'utf-8');
		}
		return $s;
	}

	function encode($string = '', $skey = 'cxphp') {
		$strArr = str_split(base64_encode($string));
		$strCount = count($strArr);
		foreach (str_split($skey) as $key => $value)
			$key < $strCount && $strArr[$key].=$value;
		return str_replace(array('=', '+', '/'), array('O0O0O', 'o000o', 'oo00o'), join('', $strArr));
	}
	/**
	 * 简单对称加密算法之解密
	 * @param String $string 需要解密的字串
	 * @param String $skey 解密KEY
	 * @author Anyon Zou <zoujingli@qq.com>
	 * @date 2013-08-13 19:30
	 * @update 2014-10-10 10:10
	 * @return String
	 */
	function decode($string = '', $skey = 'cxphp') {
		$strArr = str_split(str_replace(array('O0O0O', 'o000o', 'oo00o'), array('=', '+', '/'), $string), 2);
		$strCount = count($strArr);
		foreach (str_split($skey) as $key => $value)
			$key <= $strCount && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
		return base64_decode(join('', $strArr));
	}

        /**
	 * 通过ftp方式实现图片同步
	 * @param String $img 需要同步的图片文件名
	 * @return null
	 */
        public static function synchroPic($img){
            $ftp_server = array('10.200.18.72','10.200.18.75');
            //$ftp_server = array('10.200.18.75');
            //$ftp_server = array('10.200.17.57','10.200.18.75');
            $ftp_user = 'miguftp';
            $ftp_passwd = 'miguftp2015';
            $img = trim($img);
            
            foreach($ftp_server as $ftp){
                $conn = ftp_connect($ftp);
                ftp_login($conn, $ftp_user, $ftp_passwd);
                ftp_put($conn, $img, Yii::app()->basePath.'/../file/'.$img, FTP_BINARY);
            }

//            @unlink(Yii::app()->basePath.'/../file/'.$img);
        }
        
        public static function fspost($img){
           $host = '10.200.18.76';
           $port = 8080;
           $errno = '';
    	   $errstr = '';
       	   $timeout = 30;
    	   $url = '/curl.php';
    	   $param = array(
              'img' => $img
           );

    	   $url = $url.'?'.http_build_query($param);
	   // create connect
    	   $fp = fsockopen($host, $port, $errno, $errstr, $timeout);
    	   if(!$fp){
        	return false;
           }

	   // send request
    	   $out = "GET ${url} HTTP/1.1\r\n";
    	   $out .= "Host: ${host}\r\n";
	   $out .= "Connection:close\r\n\r\n";
 	   fwrite($fp, $out);

 	   usleep(2000);

 	   fclose($fp);

	}       
        
}
