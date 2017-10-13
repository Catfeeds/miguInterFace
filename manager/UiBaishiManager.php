<?php 
    class UiBaishiManager extends Ui
{
    /**
     * @return array
     * 获取布局数据
     */
    public static function getInfo($type = '',$cp = '',$provinceCode = '',$cityCode = ''){
        $res = array();
		$criteria = new CDbCriteria();
		if(!empty($type)){
			$criteria->addCondition('type=:type');
			$criteria->params[':type'] = $type;
		}
        if(is_numeric($provinceCode) ){
            $criteria->addCondition('provinceCode=:provinceCode');
            $criteria->params[':provinceCode'] = $provinceCode;
        }

        if(is_numeric($cityCode) ){
            $criteria->addCondition('cityCode=:cityCode');
            $criteria->params[':cityCode'] = $cityCode;
        }
        if(!empty($cp)){
            $criteria->addCondition('cp=:cp');
            $criteria->params[':cp'] = $cp;
        }
		$ui = self::model()->findAll($criteria);
        //var_dump($ui);
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
?>