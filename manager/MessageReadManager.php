<?php

/**
 * Created by PhpStorm.
 * User: xzm
 * Date: 2015/12/04
 * Time: 14:32
 */
class MessageReadManager extends MessageRead{


    public static function getReadList($data){
        $res = array();
        $sql_count = 'select count(id)';
        $sql_select = 'select *';
        $sql_from = ' from yd_message';
        $sql_where = ' where stbid ='.$data['stbid'];
        $sql_order = ' order by time desc';
        $sql_limit = ' limit '.$data['start'].','.$data['limit'];

        $count = $sql_count . $sql_from . $sql_where;
        $res['count'] = Yii::app()->db->createCommand($count)->queryScalar();

        $list = $sql_select . $sql_from . $sql_where . $sql_order . $sql_limit;
        $res['list'] = SQLManager::queryAll($list);

        return $res;
    }
}