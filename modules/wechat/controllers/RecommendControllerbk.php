<?php

class RecommendController extends WController{

    public function actionDefault(){
        $this->render('default');
    }

    public function actionIndex(){
        $this->render('index');
    }

    public function actionLunbo(){
        $gid= $_REQUEST['mid'];
        $type='1';
        $tmp = WxMov::model()->findAll("gid='$gid' and type='$type'");
        $lunbo=array();
        if(!empty($tmp)){
            foreach($tmp as $key=>$val){
                $lunbo[]= $val->attributes;
            }
        }
        $this->render('lunbo',array('lunbo'=>$lunbo));
    }

    public function actionUpload(){
        //var_dump($_REQUEST);die;
        $classify = '5';
        if(!empty($_REQUEST['id'])){
            $id= $_REQUEST['id'];
            $tmp = WxMov::model()->find("id='$id'");
            if(!empty($tmp)){
                $tmp = $tmp->attributes;
            }
            //var_dump($tmp);
        }else{
            $wxmov = new WxMov();
            $tmp='';
            $tmp['id']='';
            $tmp['tType']='';
            $tmp['cp']='';
        }

        //var_dump($tmp);die;
        $n=$this->renderPartial('upload',array('tmp'=>$tmp),true);
        die(json_encode(array('code'=>200,'msg'=>$n)));
    }

    public function actionAdds(){
        //var_dump($_REQUEST);die;
        if(!empty($_REQUEST['id'])){
            $id= $_REQUEST['id'];
            $wxmov = WxMov::model()->find("id='$id'");
        }else{
            $wxmov = new WxMov();
        }
        $type='1';
        $gid=$_REQUEST['mid'];
        $gid=$_REQUEST['mid'];
        $wxmov->title=$_REQUEST['title'];
        $wxmov->pic='http://' . $_SERVER['HTTP_HOST'] .'/file/'.$_REQUEST['key'];
        $wxmov->type=$type;
        $wxmov->tType=$_REQUEST['tType'];
        $wxmov->param=$_REQUEST['param'];
        $wxmov->action=$_REQUEST['action'];
        $wxmov->cp=$_REQUEST['cp'];
        $wxmov->gid=$gid;
        //var_dump($wxmov);
        if(!$wxmov->save()){
            var_dump($wxmov->getErrors());
        }
        $this->die_json(array('code'=>200));
    }



    public function actionMovie(){
        $gid=$_REQUEST['mid'];
        $res=array();
        $list=WxMov::model()->findAll("type='2' and gid='$gid' and delFlag='0' order by `order` desc");
        foreach($list as $k=>$v){
            $res[]=$v->attributes;
        }
        //var_dump($res);die;
        $this->render('movie',array('list'=>$res));
    }

    public function actionAdd(){
        $nid=$_REQUEST['nid'];
        $word=!empty($_REQUEST['word'])?$_REQUEST['word']:'';
        $cp=!empty($_REQUEST['cp'])?$_REQUEST['cp']:'';
        //$classify = $_REQUEST['classify'];
        $page = 20;
        $data = $this->getPageInfo($page);
        //$list = WxMovManager::getList($data,$classify,$cp,$word);
        $list = WxMovManager::getList($data,$cp,$word);
        //var_dump($list);die;
        $url = $this->createUrl($this->action->id);
        $pagination = $this->renderPagination($url,$list['count'],$page,$data['currentPage']);
        //var_dump($list);die;
        $this->render('add',array('nid'=>$nid,'page'=>$pagination,'total'=>$list['count'],'list'=>$list['list']));
    }

    public function actionAddlist(){
        $nid=$_REQUEST['nid'];
        $word=!empty($_REQUEST['word'])?$_REQUEST['word']:'';
        $cp=!empty($_REQUEST['cp'])?$_REQUEST['cp']:'';
        //$classify = $_REQUEST['classify'];
        $page = 20;
        $data = $this->getPageInfo($page);
        //$list = WxMovManager::getList($data,$classify,$cp,$word);
        $list = WxMovManager::getList($data,$cp,$word);
        //var_dump($list);die;
        $url = $this->createUrl($this->action->id);
        $pagination = $this->renderPagination($url,$list['count'],$page,$data['currentPage']);
        //var_dump($list);die;
        $this->render('addlist',array('nid'=>$nid,'page'=>$pagination,'total'=>$list['count'],'list'=>$list['list']));
    }

    public function actionVideo(){
        $gid= $_REQUEST['nid'];
        $classify = $_REQUEST['classify'];
        //$tmp = WxSelect::model()->findAll("gid='$gid' and classify='$classify' order by orders asc");
        $tmp = WxSelect::model()->findAll("gid='$gid' order by orders asc");
        $video=array();
        if(!empty($tmp)){
            foreach($tmp as $key=>$val){
                $video[]= $val->attributes;
            }
        }
        //var_dump($video);die;
        $this->render('video',array('video'=>$video));
    }
    
    public function actionVideolist(){
        $gid= $_REQUEST['nid'];
        $classify = $_REQUEST['classify'];
        //$tmp = WxSelect::model()->findAll("gid='$gid' and classify='$classify' order by orders asc");
        $tmp = WxSelect::model()->findAll("gid='$gid' order by orders asc");
        $video=array();
        if(!empty($tmp)){
            foreach($tmp as $key=>$val){
                $video[]= $val->attributes;
            }
        }
        //var_dump($video);die;
        $this->render('videolist',array('video'=>$video));
    }
 
    public function actionDoadd(){
        //var_dump($_REQUEST);die;
        $gid=$_REQUEST['nid'];
        $arr=explode(' ',$_REQUEST['ids']);
        $classify=$_REQUEST['classify'];
        foreach($arr as $k=>$v){
            if(!empty($v)){
                $wxmov = new WxSelect();
                $result = WxMovie::model()->find("id=$v");
                $sql = "select `orders` from yd_wx_select where classify='$classify' and gid=$gid order by `orders` desc limit 1";
                $return = Yii::app()->db->createCommand($sql)->queryRow();
                $wxmov->mid = $result->id;
                $wxmov->title = $result->title;
                $wxmov->img = $result->img;
                $wxmov->type = $result->type;
                $wxmov->action = $result->action;
                $wxmov->param = $result->param;
                $wxmov->cp = $result->cp;
                $wxmov->classify = $result->classify;
                $wxmov->gid = $gid;
                $wxmov->director = $result->director;
                $wxmov->actor = $result->actor;
                $wxmov->info = $result->info;
                $wxmov->addTime = time();
                if($return){
                    $wxmov->orders = $return['orders']+1;
                }else{
                    $wxmov->orders='1';
                }
                if(!$wxmov->save()){
                    var_dump($wxmov->getErrors());
                }
            }
        }
    }

    public function actionDel(){
        if(!empty($_REQUEST['id'])){
            $id=$_REQUEST['id'];
            $wxmov=WxSelect::model()->deleteByPk($id);
            if($wxmov){
                echo json_encode(array('code'=>200,'msg'=>'删除成功'));
            }else{
                echo json_encode(array('code'=>404,'msg'=>'删除失败'));
            }
        }

    }

    public function actionSearch(){
        //var_dump($_REQUEST);
        $page = 20;
        $cp = $_REQUEST['cp'];
        $word = $_REQUEST['word'];
        $p = $_REQUEST['p']*$page;
        $type=$_REQUEST['classify'];
        $tmp = WxMovManager::getAll($cp,$type,$word,$p);
        foreach($tmp as $key=>$val){
            switch($val['cp']) {
                case '1':
                    $val['cp'] = "华数";
                    break;
                case '2':
                    $val['cp'] = "百视通";
                    break;
                case '4':
                    $val['cp'] = "南传";
                    break;
                case '7':
                    $val['cp'] = "银河";
                    break;
                case '3':
                    $val['cp'] = "未来电视";
                    break;
                case '5':
                    $val['cp'] = "国广";
                    break;
                case '6':
                    $val['cp'] = "芒果";
                    break;

            }
            switch($val['type']) {
                case '2':
                    $val['type']='电影';
                    break;
            }
            $tmp[$key]=$val;
        }
        //var_dump($tmp);die;
        $p = intval($_REQUEST['p'], 10);
        if($tmp){
            echo json_encode(array('code'=>200,'list'=>$tmp,'p'=>$p));
        }else{
            echo json_encode(array('code'=>404,'list'=>$tmp,'p'=>$p));
        }

    }

    public function actionUpdate(){
        if(!empty($_REQUEST['id'])){
            $id = $_REQUEST['id'];
            $order=$_REQUEST['order'];
            $tmp=array_combine($id,$order);
            foreach($tmp as $key=>$val){
                $wxmov = WxSelect::model()->find("id='$key'");
                $wxmov->orders = $val;
                if(!$wxmov->save()){
                    var_dump($wxmov->getErrors());
                }
            }
        }
        echo json_encode(array('code'=>'200'));

    }

    public function up($filename){
        if (!empty($filename)) {
            if ($_FILES[$filename]["error"] > 0) {
                $this->error('上传文件错误! 错误代码:' . $_FILES[$filename]['error'], '', 3);
            }
            $dir = Yii::app()->basePath . '/../file/';
            //echo $dir;die();
            $name = date('YmdHis') . mt_rand(0000, 9999);
            //$expand_arr = explode('/',$_FILES['media']['type']);
            //$expand = '.'.$expand_arr[1];
            $expand = '.' . pathinfo($_FILES[$filename]['name'], PATHINFO_EXTENSION);
            if (is_uploaded_file($_FILES[$filename]["tmp_name"])) {
                if (move_uploaded_file($_FILES[$filename]["tmp_name"], $dir . $name . $expand)) {
                    $path = $name . $expand;
                    //$path = isset($name) ? $name . $expand : '';
                } else {
                    $this->error('上传服务器临时错误');
                }
            } else {
                $this->error('非法上传方法');
            }
        }
        return $path;
    }

    
}

