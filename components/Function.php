<?php
/**
 * @return string
 * 分辨访问设备类型
 */

function getallheaderss()
{
	$header = null;
	foreach ($_SERVER as $name => $value)
	{
		if ('HTTP_' == substr($name, 0, 5)) {
			$header[str_replace('_', '-', substr($name, 5))] = $value;
		}
	}
	if (isset($_SERVER['PHP_AUTH_DIGEST'])) {
		$header['AUTHORIZATION'] = $_SERVER['PHP_AUTH_DIGEST'];
	} elseif (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
		$header['AUTHORIZATION'] = base64_encode($_SERVER['PHP_AUTH_USER'] . ':' . $_SERVER['PHP_AUTH_PW']);
	}
	if (isset($_SERVER['CONTENT_LENGTH'])) {
		$header['CONTENT-LENGTH'] = $_SERVER['CONTENT_LENGTH'];
	}
	if (isset($_SERVER['CONTENT_TYPE'])) {
		$header['CONTENT-TYPE'] = $_SERVER['CONTENT_TYPE'];
	}
	return $header;
}

function isModLe(){
	$useragent  = strtolower($_SERVER["HTTP_USER_AGENT"]);
	// iphone
	$is_iphone  = strripos($useragent,'iphone');
	if($is_iphone){
		return 'iphone';
	}
	// android
	$is_android    = strripos($useragent,'android');
	if($is_android){
		return 'android';
	}
	// 微信
	$is_weixin  = strripos($useragent,'micromessenger');
	if($is_weixin){
		return 'weixin';
	}
	// ipad
	$is_ipad    = strripos($useragent,'ipad');
	if($is_ipad){
		return 'ipad';
	}
	// ipod
	$is_ipod    = strripos($useragent,'ipod');
	if($is_ipod){
		return 'ipod';
	}
	// pc电脑
	$is_pc = strripos($useragent,'windows nt');
	if($is_pc){
		return 'pc';
	}
	return 'other';
}

/**
 * @param $string
 * @param $operation
 * @param string $key
 * @return mixed|string
 * 字符串加密
 *
 *  $str = 'abc';
 *	$key = 'www.helloweba.com';
 *	$token = encrypt($str, 'E', $key);
 *	echo '加密:'.encrypt($str, 'E', $key);
 *	echo '解密：'.encrypt($str, 'D', $key);
 */
function encrypt($string,$operation,$key=''){
	$key=md5($key);
	$key_length=strlen($key);
	$string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string;
	$string_length=strlen($string);
	$rndkey=$box=array();
	$result='';
	for($i=0;$i<=255;$i++){
		$rndkey[$i]=ord($key[$i%$key_length]);
		$box[$i]=$i;
	}
	for($j=$i=0;$i<256;$i++){
		$j=($j+$box[$i]+$rndkey[$i])%256;
		$tmp=$box[$i];
		$box[$i]=$box[$j];
		$box[$j]=$tmp;
	}
	for($a=$j=$i=0;$i<$string_length;$i++){
		$a=($a+1)%256;
		$j=($j+$box[$a])%256;
		$tmp=$box[$a];
		$box[$a]=$box[$j];
		$box[$j]=$tmp;
		$result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
	}
	if($operation=='D'){
		if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8)){
			return substr($result,8);
		}else{
			return'';
		}
	}else{
		return str_replace('=','',base64_encode($result));
	}
}

function curl_post($url,$data){
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}

function curl_get($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}