<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/18 0018
 * Time: 16:03
 */
class GroupManager extends Group{
	public static function getGroup($cache=false,$key='group'){
		$sql = 'select id,name from yd_group';
		return SQLManager::queryAll($sql);
	}

	public static function getName($str){

	}
}