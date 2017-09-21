<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/4 0004
 * Time: 22:03
 */
class MController extends Controller{

	public $layout = 'application.modules.mobile.views.layouts.main';
	public $user;
	private $key= 'zhongguoyidong';
	private $token;
	private $bulletin;

	public function beforeAction($action){
		if(parent::beforeAction($action)){
			$this->bulletin = empty($_REQUEST['bulletin']) ? '' : $_REQUEST['bulletin'];
		}
			return true;
	}

	public function ReturnDate($err,$status,$list=array()){
		if(is_numeric($status)) $status = 'success';
		die(json_encode(array('code'=>$err,'info'=>$status,'data'=>$list)));
	}

	public function token(){
		return md5(encrypt($this->bulletin,'D',$this->key));
	}

	public function check($token,$model){
		$user = Token::model()->findByAttributes(array('token'=>$token,'bulletin'=>encrypt($model,'E',$this->key)));
		if(empty($user)){
			$this->ReturnDate(MSG::ERROR,'token 无效');
		}

		if($user->end < time()){
			$user->token = $this->token();
			$user->end = time() + 24 * 3600;
			$user->update();
		}

		return $this->user = $user;
	}
}