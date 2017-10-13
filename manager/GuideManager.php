<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/19 0019
 * Time: 12:50
 */
class GuideManager extends Guide{
	public static function getList(){
		$res = array();
		$all = Guide::model()->findAll();
//        var_dump($all);die();
		if(!empty($all)){
			foreach($all as $key=>$n){
				if($n->pid == 0){
					$tmp['id'] = $n->id;
					$tmp['name'] = $n->name;
					$res[$n->id] = $tmp;
				}elseif(array_key_exists($n->pid,$res)){//array_key_exists() 函数判断某个数组中是否存在指定的 key，如果该 key 存在，则返回 true，否则返回 false。
					$tm['id'] = $n->id;
					$tm['name'] = $n->name;
					$res[$n->pid]['node'][] = $tm;
				}
			}
		}

		return $res;
	}
	public static function lists(){
		$sql_select = 'select pid,name,module,url,status,id from yd_guide';
		return SQLManager::queryAll($sql_select);
	}

	public static function getforparent($id=0){
		$sql_select = 'select name,url,id,module,pid from yd_guide where pid='.intval($id).' order by `order` asc';
		return SQLManager::queryAll($sql_select);
	}
}
