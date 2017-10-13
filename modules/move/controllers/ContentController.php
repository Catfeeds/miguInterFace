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

//        echo Yii::app()->session['username'];
//        echo "<hr />";
//        echo Yii::app()->session['password'];

        $idd = $_GET['mid'];
        //echo $idd;
        //查询出这个用户的session，

        $name = Yii::app()->session['username'];
        $pwd  = Yii::app()->session['password'];
        //通过session查询出这个用户的权限
        $auth = Admin::model()->find("username = '$name' and password = '$pwd'");
//        print_r($auth);
//        echo $auth['auth'];
//        echo "<hr />";
        $id = $auth['auth'];
        $group = Group::model()->find("id = '$id'");

       //print_r($group);
       // echo $group['auth'];//这个用户的权限
        $quanxian = $group['auth'];


        $arr = explode(',',$group['auth']);
       // print_r($arr);

        $url = array_map(create_function('$record','return $record->attributes;'),Guide::model()->findAll(array(
            'select' => array('id'),
            'order'  => 'id DESC',
            'condition' => 'pid='.$idd,
        )));//把对象转化为数组

        //print_r($url);
        $huashu = array_column($url,'id');
       // print_r($huashu);

        //通过查出来的这个用户的权限判断查询出来的这个顶级栏目下的子栏目哪些是有权限的

        $you = array();
        for($i=0;$i<count($huashu);$i++){
            if(in_array($huashu[$i],$arr)){
                $you[]=$huashu[$i];
            }
        }

       // print_r($you);die();
       // echo "<hr />";
        //这个就是有的权限的  这是字符串 查询 in 这个字符串就行了
        //echo implode(',',$you);
       // $nid = $you[0];
        $nid = !empty($you[0]) ? $you[0] : '0';
       // echo $nid;die();


        $aa = array_map(create_function('$record','return $record->attributes;'),Guide::model()->findAll("id = '$nid' "));
        //echo $aa[0]['url'];
        //print_r($aa);
       // die();
       $this->redirect($this->createUrl($aa[0]['url'],array('mid'=>$idd,'nid'=>$nid)));
        //$this->redirect($this->createUrl('/admin/default/index',array('mid'=>$idd,'nid'=>$id)));
	}
}