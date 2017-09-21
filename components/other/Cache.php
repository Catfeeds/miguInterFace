<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/18 0018
 * Time: 15:55
 */
class Cache
{
	public static function setCache($key,$value,$time=3600){
		return Yii::app()->cache->set($key, $value, $time);
	}

	public static function get($key){
		return Yii::app()->cache->get($key);
	}

	public static function delete($key){
		return Yii::app()->cache->delete($key);
	}

	public static function flush(){
		return Yii::app()->cache->flush();
	}
}