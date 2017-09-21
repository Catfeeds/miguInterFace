<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/10 0010
 * Time: 14:54
 */
class SQLManager{
	public static function queryScalar($sql){
		return Yii::app()->db->createCommand($sql)->queryScalar();
	}


	public static function queryAll($sql,$cache=false,$key=null,$time=1800){
//		if($cache == true){
//			if(empty($key)) throw new Exception('系统错误,请调试');
//			$info = Cache::get($key);
//			if(!$info){
//				$info = Yii::app()->db->createCommand($sql)->queryAll();
//				Cache::setCache($key,$info,$time);
//			}
//			return $info;
//		}
		return Yii::app()->db->createCommand($sql)->queryAll();
	}

	public static function queryRow($sql){
		return Yii::app()->db->createCommand($sql)->queryRow();
	}

	public static function execute($sql){
		return Yii::app()->db->createCommand($sql)->execute();
	}
}