<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/10 0010
 * Time: 14:49
 */
class BulletinManager extends Bulletin{
	public static function getBullList($data){
		$res = array();
		$sql_count = 'select count(id)';
		$sql_select = 'select id,title,url,status,addTime';
		$sql_from = ' from yd_bulletin';
		$sql_where = ' where id <> 0';
		$sql_order = ' order by addTime desc';
		$sql_limit = ' limit '.$data['start'].','.$data['limit'];

		$count = $sql_count . $sql_from . $sql_where;
		$res['count'] = Yii::app()->db->createCommand($count)->queryScalar();

		$list = $sql_select . $sql_from . $sql_where . $sql_order . $sql_limit;
		$res['list'] = SQLManager::queryAll($list);
		return $res;
	}
}