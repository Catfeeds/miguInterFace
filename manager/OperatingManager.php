<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/18 0018
 * Time: 14:37
 */
class OperatingManager extends OperatingLog
{
	public static function getLogList($data){
		$res = array();
		$sql_count = 'select count(o.id)';
		$sql_select = 'select o.id,a.nickname,o.edit,o.link,o.oTime,g.name,o.content';
		$sql_from = ' from yd_operating_log as o inner join yd_admin as a on o.aid=a.id left join yd_group as g on a.auth=g.id';
		$sql_where = ' where o.id <> 0';
		$sql_order = ' order by o.oTime desc';
		$sql_limit = ' limit '.$data['start'].','.$data['limit'];

		if(!empty($data['nickname'])){
			$sql_where .= ' and a.nickname like \'%'.$data['nickname'].'%\'';
		}

		if(!empty($data['edit'])){
			$sql_where .= ' and o.edit=\''.$data['edit'].'\'';
		}

		if(!empty($data['link'])){
			$sql_where .= ' and o.content like \'%'.$data['link'].'%\'';
		}

		if(!empty($data['first']) && !empty($data['end'])){
			$sql_where .= ' and o.oTime BETWEEN '.$data['first'].' and '.$data['end'];
		}

		if(!empty($data['group'])){
			$sql_where .= ' and o.group='.$data['group'];
		}

		$count = $sql_count . $sql_from . $sql_where;
		$res['count'] = SQLManager::queryScalar($count);

		$list = $sql_select . $sql_from . $sql_where . $sql_order . $sql_limit;
		$res['list'] = SQLManager::queryAll($list);
		return $res;
	}

	public static function getDetail($id){
		$sql = 'select o.content,o.edit,o.oTime,g.name,a.nickname';
		$sql.= ' from yd_operating_log as o inner join yd_admin as a on o.aid=a.id inner join yd_group as g on o.group=g.id';
		$sql.= ' where o.id='.$id;
		return SQLManager::queryRow($sql);
	}
}