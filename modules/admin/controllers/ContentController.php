<?php

/**
 * Created by PhpStorm.
 * User: whwyy
 * Date: 2015/9/10 0010
 * Time: 10:58
 */
class ContentController extends AController
{
    public function actionIndex(){
        $idd = $_GET['mid'];
        $quanxian = Yii::app()->session['group'];
        $arr = explode(',',$quanxian);
        $url = array_map(create_function('$record','return $record->attributes;'),Guide::model()->findAll(array(
            'select' => array('id'),
            'order'  => 'id asc',
            'condition' => 'pid='.$idd,
        )));
        $huashu = $this->array_column($url,'id');
        $you = array();
        for($i=0;$i<count($huashu);$i++){
            if(in_array($huashu[$i],$arr)){
                $you[]=$huashu[$i];
            }
        }
        $nid = $you[0];
        $aa = array_map(create_function('$record','return $record->attributes;'),Guide::model()->findAll("id = '$nid' "));
        $this->redirect($this->createUrl($aa[0]['url'],array('mid'=>$idd,'nid'=>$nid)));
    }
}
