<?php


class MvSeuiManager extends MvSeui
{
    /**
     * @return array
     * 获取布局数据
     */
    public static function getAll($cid){
        $res = array();
        $criteria = new CDbCriteria();

        if(!empty($cid)){
            $criteria->addCondition('cid=:cid');
            $criteria->params[':cid'] = $cid;
        }
        $criteria->order="pos asc";
        $mvui = self::model()->findAll($criteria);

        if(!empty($mvui)){
            foreach ($mvui as $v) {
                $res[$v['pos']][] = $v->getAttributes();
            }
        }

        return $res;
    }


    public static function getKey($key,$arr){
        if(array_key_exists($key,$arr)){
            return $arr[$key];
        }
        return '';
    }

    public static function getList($cid){
        $res = array();
        $sql_select = 'select *';
        $sql_from = ' from yd_mv_seui';
        $sql_where = " where cid='$cid'";
        $sql_order = ' order by pos asc';
        $list = $sql_select . $sql_from . $sql_where .$sql_order  ;
        $res = SQLManager::queryAll($list);
        return $res;
    }


}