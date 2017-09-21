<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/21 0021
 * Time: 16:14
 */
class UiManager extends Ui
{
    /**
     * @return array
     * 获取布局数据
     */
    public static function getAll($cp = '',$type = '',$provinceCode = '0',$cityCode = '0'){
        $res = array();
        $criteria = new CDbCriteria();
        if(!empty($type)){
            $criteria->addCondition('type=:type');
            $criteria->params[':type'] = $type;
        }
        if(!empty($provinceCode)||$provinceCode==0){
            $criteria->addCondition('provinceCode=:provinceCode');
            $criteria->params[':provinceCode'] = $provinceCode;
        }
        if(!empty($cityCode)||$cityCode==0){
            $criteria->addCondition('cityCode=:cityCode');
            $criteria->params[':cityCode'] = $cityCode;
        }
        if(!empty($cp)){
            $criteria->addCondition('cp=:cp');
            $criteria->params[':cp'] = $cp;
        }
        $ui = self::model()->findAll($criteria);
        if(!empty($ui)){
            foreach ($ui as $v) {
                $res[$v['position']][] = $v->getAttributes();
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