<?php

/**
 * Created by PhpStorm.
 * User: whwyy
 * Date: 2015/9/1 0001
 * Time: 10:31
 */
class PController extends Controller
{
	public $token;
	public $client;
	public $client_id;
	public $referrer;
	public $layout = 'application.modules.api.views.layouts.main';
	public function beforeAction($action){
		if(parent::beforeAction($action)){
			$this->ip();
			return true;
		}
		$this->ReturnData(MSG::ERROR,MSG::ERROR_INFO);
		return true;
	}

	public function ReturnData($code,$info,$param = array()){
		die(json_encode(array('code'=>$code,'info'=>$info,'data'=>$param)));
	}

	public function ip(){
		$ip = $_SERVER['REMOTE_ADDR'];
//		if(!in_array($ip,MSG::$ip)){
//			$this->ReturnData(MSG::ERROR,'暂时不让你访问');
//		}
	}
}