<?php

/**
 * Created by PhpStorm.
 * User: xzm
 * Date: 2015/10/28
 * Time: 16:52
 */
class UiHenanManager extends UiHenan
{
    /**
     * @return array
     * 获取布局数据
     */
    public static function getAll($cp){
        $res = array();
        $criteria = new CDbCriteria();
        $criteria -> addCondition('cp = :cp');
        $criteria -> params[':cp'] = $cp;
        $henan = self::model()->findAll($criteria);
        if(!empty($henan)){
            foreach ($henan as $v) {
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
}