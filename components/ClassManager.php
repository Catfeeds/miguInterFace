<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/13 0013
 * Time: 13:20
 */
class ClassManager{
	/**
	 * @param $model
	 * @return array|bool
	 * @throws Exception
	 * 获取模块下的controller
	 */
	public static function getModelFile($model){
		if(empty($model)) return false;
		$path = Yii::getPathOfAlias('application.modules.'.$model.'.controllers');
		if(!@file_exists($path)){
			throw new Exception('模块【'.$model.'】不存在');
		}
		$file = self::getClassName($path);
		$res = array();
		if(!empty($file)){
			foreach($file as $v){
				$class = substr($v,0,mb_strlen($v) - 4);
				$res[$class] = self::getAction($class);
			}
		}
		return $res;
	}

	/**
	 * @param $class
	 * @return array
	 * 获取操作方法
	 */
	public static function getAction($class){
		$action = array();
		$a = ClassReflection::instance($class)->getController();
		if(!empty($a)){
			foreach($a as $n){
				if(substr($n,0,6) === 'action' && $n !== 'actions'){
					$action[] = $n;
				}
			}
		}
		return $action;
	}

	/**
	 * @param $class
	 * @return array
	 * 获取类名
	 */
	public static function getClassName($class){
		return self::getFile($class,'php',false);
	}

	/**
	 * @param $path
	 * @param $fileType
	 * @param bool|true $isType
	 * @return array
	 * 获取目录下的文件
	 */
	public static function getFile($path,$fileType,$isType=true){
		$name = array();
		if(is_dir($path)){
			$open = opendir($path);
			while(false !== ($file = readdir($open))){
				if($file == '.' || $file == '..') continue;
				if(strtolower(pathinfo($file,PATHINFO_EXTENSION)) === strtolower('php')){
					$dp = $path . DIRECTORY_SEPARATOR . $file;
					require_once $dp;
					$name[] = $isType?$dp:$file;
				}
			}
		}
		return $name;
	}

	public static function save($model,$auth=''){
		try{
			$controllers = self::getModelFile($model);
			if(!empty($controllers)){
				foreach($controllers as $key=>$con){
					$class = strtolower(mb_substr($key,0,strlen($key) - 10));
					foreach($con as $v){
						$action = strtolower(mb_substr($v,6));
						if(Auth::model()->exists('model=:model and class=:class and action=:action',
							array(':model'=>$model,':class'=>$class,':action'=>$action))){
							continue;
						};
						$auth = new Auth();
						$auth->title    = $model.'_'.$class.'_'.$action;
						$auth->model    = $model;
						$auth->class    = $class;
						$auth->action   = $action;
						$auth->addres   = '/'.$model.'/'.$class.'/'.$action;
						$auth->addTime  = time();
						if(!$auth->save()){
							LogWriter::logModelSaveError($auth,__METHOD__,$auth->attributes);
							throw new Exception('保存失败');
						}
					}
				}
			}
		}catch (Exception $e){
			Yii::app()->user->setFlash(rand(0,999999),array('title'=>'温馨提示','message'=>$e->getMessage(),'info'=>0));
		}
	}
}

/**
 * Class ClassReflection
 * 反射API  获取类中的操作方法
 */
class ClassReflection{
	private  $class;
	private  $reflector;

	public function __construct(&$class=''){
		if(!empty($class)){
			$this->class = $class;
			$this->reflector = new ReflectionClass($class);
		}else{
			throw new Exception('类名不能为空');
		}
	}

	public static function instance($class){
		return new self($class);
	}

	public function getController(){
		return get_class_methods($this->class);
	}
}