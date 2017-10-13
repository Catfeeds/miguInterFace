<?php
class NationController extends MController{

    public function actionDefault(){
        $this->render("default");
    }




    public function actionIndex(){

        $nid=$_GET['nid'];
        if($nid==7){
            $gid = 7;
            $epg = 1;
        }
        if($nid==8){
            $gid = 8;
            $epg = 2;
        }
        if($nid==9){
            $gid = 9;
            $epg = 3;
        }
        if($nid==10){
            $gid = 10;
            $epg = 4;
        }
        if($nid==11){
            $gid = 11;
            $epg = 5;
        }
        if($nid==12){
            $gid = 12;
            $epg = 6;
        }
        if($nid==13){
            $gid = 13;
            $epg = 7;
        }
        if($nid==17){
            $gid = 17;
            $epg = 1;
        }

        $mvui = MvUiManager::getAll($gid,$epg,99);
        $xiaotu = MvUiManager::getAll($gid,$epg,1);
        //print_r($xiaotu);die();
        $html = HTML::move($mvui,$xiaotu);

        $this->render("index",array('html'=>$html,'mvui'=>$mvui,'xiaotu'=>$xiaotu,'gid'=>$gid,'epg'=>$epg));//,'epg'=>$epg
    }


    public function actionUpload(){
        if(empty($_GET['val']) || empty($_GET['gid']) || empty($_GET['epg'])){
            $this->die_json(array('code'=>404,'msg'=>'请选择要设置的位置'));
        }
        $mvui = MvUiManager::getAll($_GET['gid'],$_GET['epg'],99);
        $xiaotu = MvUiManager::getAll($_GET['gid'],$_GET['epg'],1);
        $html = HTML::move($mvui,$xiaotu);

        //$tType = $setting[$t][0]['tType'];
        $fid = isset($_GET['fid'])?$_GET['fid']:'';


     //   $t = trim($_GET['val']);


       // print_r($mvui[$t]);die();
        $t = isset($_GET['val'])?trim($_GET['val']):'';
        $substr = substr($t,0,1);
        if($substr=='b'){
            $type = '99';
        }elseif($substr=='s'){
            $type = '1';
        }




      //  $t = isset($_GET['val'])?trim($_GET['val']):'';

        if($type==99){
            //大图
            if(empty($mvui[$t][$fid])){
                $cp = '';
                $id = '';
                $tType = '';

            }else{
                $tType = $mvui[$t][$fid]['tType'];
                $cp = $mvui[$t][$fid]['cp'];
                $id = $mvui[$t][$fid]['id'];
            }
//            $h = "650px";
//            $w = "350px";
        }elseif($type==1){
            //小图
            if(empty($xiaotu[$t][$fid])){
                $cp = '';
                $id = '';
                $tType = '';

            }else{
                $tType = $xiaotu[$t][$fid]['tType'];
                $cp = $xiaotu[$t][$fid]['cp'];
                $id = $xiaotu[$t][$fid]['id'];
            }
//            $h = "200px";
//            $w = "350px";
        }
        //大图
        /*if(empty($mvui[$t][$fid])){
            $cp = '';
            $id = '';
            $tType = '';

        }else{
            if($type==99){
                $tType = $mvui[$t][$fid]['tType'];
                $cp = $mvui[$t][$fid]['cp'];
                $id = $mvui[$t][$fid]['id'];
            }elseif($type==1){
                $tType = $xiaotu[$t][$fid]['tType'];
                $cp = $xiaotu[$t][$fid]['cp'];
                $id = $xiaotu[$t][$fid]['id'];
            }
            //$type = $mvui[$t][0]['type'];
            // $epg = $mvui[$t][0]['epg'];

        }*/
        $n = $this->renderPartial(
            'upload',
            array(
                'address'=>trim($_GET['val']),
                'fid'=>$fid,
                'ui'=>$mvui,
                'xiaotu'=>$xiaotu,
                'html'=>$html,
                'id' =>$id,
                'gid'=>$_GET['gid'],
                'tType'=>$tType,
                'cp' =>$cp,
                'type'=>$type,
                'epg'=>$_GET['epg'],
//                'h'=>$h,
//                'w'=>$w
                //'position'=>$position
            ),
            true
        );
        die(json_encode(array('code'=>200,'msg'=>$n)));
    }



    public function actionPhoto(){
        if(empty($_GET['val']) || empty($_GET['gid']) || empty($_GET['epg'])){
            $this->die_json(array('code'=>404,'msg'=>'请选择要设置的位置'));
        }
       // print_r($_GET['epg']);die();

        $mvui = MvUiManager::getAll($_GET['gid'],$_GET['epg'],99);
        $xiaotu = MvUiManager::getAll($_GET['gid'],$_GET['epg'],1);
       // print_r($mvui);die();
        $html = HTML::move($mvui,$xiaotu);

        $t = isset($_GET['val']) ? trim($_GET['val']) : '';

        $mvui = $mvui["$t"];
       // print_r($mvui);die();
        $n = $this->renderPartial(
            'photo',
            array(
                'address'=>trim($_GET['val']),
                'ui'=>$mvui,
                'xiaotu'=>$xiaotu,
                'html'=>$html,
                'gid' =>$_GET['gid'],
                'epg' =>$_GET['epg']
            ),
            true
        );
        die(json_encode(array('code'=>200,'msg'=>$n)));
    }


    public function actionAdd(){
        if(!Yii::app()->request->isAjaxRequest){
            $this->redirect($this->getPreUrl());
        }
        if(empty($_POST['tType'])) $this->die_json(array('code'=>404,'msg'=>'上传类型不能为空'));
        if(empty($_POST['title'])) $this->die_json(array('code'=>404,'msg'=>'标题不能为空'));

        if(empty($_POST['key'])) $this->die_json(array('code'=>404,'msg'=>'图片地址不能为空'));
        if(empty($_POST['position'])) $this->die_json(array('code'=>404,'msg'=>'系统错误'));
        //if(empty($_POST['cp'])) $this->die_json(array('code'=>404,'msg'=>'牌照方不能为空'));
        //echo $_POST['key'];
        $mvui = MvUi::model()->findByAttributes(array('position'=>$_POST['position'],'type'=>$_POST['type'],'id'=>$_POST['id']));
        //print_r($ui['id']);
        if(!$mvui){
            $mvui = new MvUi();
            $mvui->addTime = time();
        }else{
            $mvui->upTime = time();
        }

        $mvui->title    = trim($_POST['title']);
        $mvui->position = trim($_POST['position']);
        $mvui->type     = trim($_POST['type']);
        $mvui->tType    = trim($_POST['tType']);
        $mvui->cp       = trim($_POST['cp']);
        $mvui->gid      = trim($_POST['gid']);
        $mvui->epg      = trim($_POST['epg']);
        $mvui->action   = trim($_POST['action']);
        $mvui->param    = trim($_POST['param']);
        //$mvui->pic      = 'http://' . $_SERVER['HTTP_HOST'] . '/file/' . trim(substr($_POST['key'],-36));
        $mvui->pic      = 'http://192.168.1.110/file/' . trim(substr($_POST['key'],-36));
        if(!$mvui->save()){
            LogWriter::logModelSaveError($mvui,__METHOD__,$mvui->attributes);
            $this->die_json(array('code'=>404,'msg'=>'信息保存失败'));
        }



        $this->die_json(array('code'=>200));
    }

    public function actionSelv(){
        $cid=$_REQUEST['cid'];
        $mvui = MvSeuiManager::getAll($cid);

        //print_r($mvui);die();
        $html = HTML::selv($mvui);

        $n = $this->renderPartial(
            'selv',
            array(
                'address'=>99,
                'ui'=>$mvui,
                'html'=>$html,
                'cid'=>$cid
            ),
            true
        );
        die(json_encode(array('code'=>200,'msg'=>$n)));
    }

    public function actionUploads(){
        $cid = $_REQUEST['cid'];
        $mvui = MvSeuiManager::getAll($cid);
        // print_r($mvui);die();
        $html = HTML::selv($mvui);
        $fid = isset($_GET['fid'])?$_GET['fid']:'';
        $t = isset($_GET['val'])?trim($_GET['val']):'';
        $type=99;
        if(empty($mvui[$t][$fid])){
            $cp = '';
            $id = '';
            $tType = '';

        }else{
            $tType = $mvui[$t][$fid]['tType'];
            $cp = $mvui[$t][$fid]['cp'];
            $id = $mvui[$t][$fid]['id'];
        }
        $n = $this->renderPartial(
            'uploads',
            array(
                'address'=>trim($_GET['val']),
                'fid'=>$fid,
                'ui'=>$mvui,
                'html'=>$html,
                'id' =>$id,
                'cid'=>$cid,
                'tType'=>$tType,
                'cp' =>$cp,
                'type'=>$type,
            ),
            true
        );
        die(json_encode(array('code'=>200,'msg'=>$n)));
    }

    public function actionAdds(){

        if(!Yii::app()->request->isAjaxRequest){
            $this->redirect($this->getPreUrl());
        }
        if(empty($_POST['tType'])) $this->die_json(array('code'=>404,'msg'=>'上传类型不能为空'));
        if(empty($_POST['title'])) $this->die_json(array('code'=>404,'msg'=>'标题不能为空'));

        if(empty($_POST['key'])) $this->die_json(array('code'=>404,'msg'=>'图片地址不能为空'));
        if(empty($_POST['position'])) $this->die_json(array('code'=>404,'msg'=>'系统错误'));
        //if(empty($_POST['cp'])) $this->die_json(array('code'=>404,'msg'=>'牌照方不能为空'));
        //echo $_POST['key'];
        $mvui = MvSeui::model()->findByAttributes(array('pos'=>$_POST['position'],'type'=>$_POST['type'],'id'=>$_POST['id']));

        //print_r($ui['id']);
        if(!$mvui){
            $mvui = new MvSeui();
            $mvui->addTime = time();
        }else{
            $mvui->upTime = time();
        }


        $mvui->cid = trim($_POST['cid']);
        $mvui->title    = trim($_POST['title']);
        $mvui->type     = trim($_POST['type']);
        $mvui->tType    = trim($_POST['tType']);
        $mvui->cp       = trim($_POST['cp']);
        $mvui->pos      = trim($_POST['position']);
        $mvui->action   = trim($_POST['action']);
        $mvui->param    = trim($_POST['param']);
        //$mvui->pic      = 'http://' . $_SERVER['HTTP_HOST'] . '/file/' . trim(substr($_POST['key'],-36));
        $mvui->pic      = 'http://192.168.1.110/file/' . trim(substr($_POST['key'],-36));
        if(!$mvui->save()){
            LogWriter::logModelSaveError($mvui,__METHOD__,$mvui->attributes);
            $this->die_json(array('code'=>404,'msg'=>'信息保存失败'));
        }



        $this->die_json(array('code'=>200));
    }
}