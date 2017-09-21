<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/4 0004
 * Time: 20:24
 */
class AdminManager extends Admin{

	public static function getNickName($str){
		if(empty($str)) return '未知错误';
		if(is_numeric($str)){
			$admin = Admin::model()->findByPk($str);
		}else{
			$admin = self::getAdmin($str);
		}
		return is_object($admin)?$admin->nickname:$admin['nickname'];
	}

	public static function getAdmin($name){
//		$criteria = new CDbCriteria();
//		$criteria->addCondition('username=\''.$name.'\'','OR');
//		$criteria->addCondition('email=\''.$name.'\'','OR');
//		return Admin::model()->find($criteria);
            $sql = 'select * from yd_admin where username=\''.$name.'\' or email=\''.$name.'\'';
try{
  return SQLManager::queryRow($sql);
}catch (Exception $ex){
  var_dump($ex);die;
}
            //return SQLManager::queryRow($sql);
	}

	public static function getAdminList($data){
		$res = array();
		$sql_count = 'select count(a.id)';
		$sql_select = 'select a.id,a.nickname,a.username,a.email,g.name';
		$sql_from = ' from yd_admin as a inner join yd_group as g on g.id=a.auth';
		$sql_where = ' where a.id <> 0';
		$sql_order = ' order by a.addTime desc';
		$sql_limit = ' limit '.$data['start'].','.$data['limit'];

		if(!empty($data['nick'])){
			$sql_where .= ' and a.nickname like \'%'.$data['nick'].'%\'';
		}

		if(!empty($data['name'])){
			$sql_where .= ' and a.username like \'%'.$data['name'].'%\'';
		}

		if(!empty($data['email'])){
			$sql_where .= ' and a.email like \'%'.$data['email'].'%\'';
		}


		$count = $sql_count . $sql_from . $sql_where;
		$res['count'] = SQLManager::queryScalar($count);

		$list = $sql_select . $sql_from . $sql_where . $sql_order . $sql_limit;
		$res['list'] = SQLManager::queryAll($list);
		return $res;
	}
}
