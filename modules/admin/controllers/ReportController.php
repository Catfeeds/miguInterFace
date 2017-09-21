<?php


class ReportController extends AController{
    public function actionDefault(){
        $idd = $_GET['mid'];
        $quanxian = Yii::app()->session['group'];
        $arr = explode(',',$quanxian);
        $url = array_map(create_function('$record','return $record->attributes;'),Guide::model()->findAll(array(
            'select' => array('id'),
            'order'  => 'id DESC',
            'condition' => 'pid='.$idd,
        )));

        $bb = $this->array_column($url,'id');
        $you = array();
        for($i=0;$i<count($bb);$i++){
            if(in_array($bb[$i],$arr)){
                $you[]=$bb[$i];
            }
        }
        $nid = $you[0];
        $aa = array_map(create_function('$record','return $record->attributes;'),Guide::model()->findAll("id = '$nid' "));
        $this->redirect($this->createUrl($aa[0]['url'],array('mid'=>$idd,'nid'=>$nid)));
    }

    public function actionUser(){
        $total = User::model()->count("cp in (1,2,4,7) and province not in (28)");
        $huashu = User::model()->count("cp=1 and province not in (28)");
        $nanchuan = User::model()->count("cp=4 and province not in (28)");
        $yinhe = User::model()->count("cp=7 and province not in (28)");
        $baishi = User::model()->count("cp=2 and province not in (28)");
        $this->render('user',array('total'=>$total,'huashu'=>$huashu,'nanchuan'=>$nanchuan,'yinhe'=>$yinhe,'baishi'=>$baishi));
    }

    public function actionDetial(){
        $type = $_GET['type'];
        if($type=='华数'){
            $cp = 1;
        }elseif($type=='百视通'){
            $cp=2;
        }elseif($type=='银河'){
            $cp=7;
        }elseif($type=='南传'){
            $cp=4;
        }
        //$cp = $_GET['cp'];
        $page = 10;
        $data = $this->getPageInfo($page);
        $province = UserManager::getUserList($data,$cp);
        $url = $this->createUrl($this->action->id);
        $pagination = $this->renderPagination($url,$province['count'],$page,$data['currentPage']);
        $this->render('detial',array('province'=>$province['list'],'page'=>$pagination));
    }
    public function actionStbid(){
        ini_set("memory_limit","516M");
        $type = $_GET['type'];
        if($type=='华数'){
            $cp = 1;
        }elseif($type=='百视通'){
            $cp=2;
        }elseif($type=='银河'){
            $cp=7;
        }elseif($type=='南传'){
            $cp=4;
        }
        $province = $_REQUEST['province'];
        //$cp = $_GET['cp'];
        $page = 20;
        $data = $this->getPageInfo($page);
        $stbid = UserManager::getStbid($data,$province,$cp);
        $url = $this->createUrl($this->action->id);
        $pagination = $this->renderPagination($url,$stbid['count'],$page,$data['currentPage']);
        $this->render('stbid',array('stbid'=>$stbid['list'],'page'=>$pagination));
    }


}
