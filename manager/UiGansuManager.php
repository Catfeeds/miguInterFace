<?php
class UiGansuManager extends UiGansu{
    public static function getAll($cp = '',$type = ''){
        $res = array();
        $criteria = new CDbCriteria();
        if(!empty($type)){
            $criteria->addCondition('type=:type');
            $criteria->params[':type'] = $type;
        }

        if(!empty($cp)){
            $criteria->addCondition('cp=:cp');
            $criteria->params[':cp'] = $cp;
        }
        $ui = self::model()->findAll($criteria);
        if(!empty($ui)){
            foreach ($ui as $v) {
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
?>