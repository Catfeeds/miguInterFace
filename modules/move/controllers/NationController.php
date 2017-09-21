<?php
class NationController extends MController{

    public function actionDefault(){
        $this->render("default");
    }

    public function actionGongju(){
        $nid=$_GET['nid'];
        $gid=$nid;
        $epg=0;

        $this->render("gongju",array('gid'=>$gid,'epg'=>$epg));
    }

    public function actionEdit(){
        $pos = $_REQUEST['pos'];
        $epg = $_REQUEST['epg'];
        $gid = $_REQUEST['gid'];
        $result = MvUiManager::getTool($gid,$epg,$pos);
        $tType=!empty($result['tType'])?$result['tType']:'';
        $cp = !empty($result['cp'])?$result['cp']:'';
        $id = !empty($result['id'])?$result['id']:'';
        $this->render('edit',array('pos'=>$pos,'epg'=>$epg,'gid'=>$gid,'tool'=>$result,'tType'=>$tType,'cp'=>$cp,'id'=>$id));
    }

    public function actionEdits(){
        if(!Yii::app()->request->isAjaxRequest){
            $this->redirect($this->getPreUrl());
        }
        if(empty($_POST['tType'])) $this->die_json(array('code'=>404,'msg'=>'上传类型不能为空'));
        if(empty($_POST['title'])) $this->die_json(array('code'=>404,'msg'=>'标题不能为空'));

        if(empty($_POST['position'])) $this->die_json(array('code'=>404,'msg'=>'系统错误'));
        //if(empty($_POST['cp'])) $this->die_json(array('code'=>404,'msg'=>'牌照方不能为空'));
        //echo $_POST['key'];
        $mvui = MvUi::model()->findByAttributes(array('position'=>$_POST['position'],'id'=>$_POST['id']));
        //print_r($ui['id']);
        if(!$mvui){
            $mvui = new MvUi();
            $mvui->addTime = time();
        }else{
            $mvui->upTime = time();
        }

        $mvui->title    = trim($_POST['title']);
        $mvui->position = trim($_POST['position']);
        $mvui->tType    = trim($_POST['tType']);
        $mvui->cp       = trim($_POST['cp']);
        $mvui->gid      = trim($_POST['gid']);
        $mvui->epg      = trim($_POST['epg']);
        $mvui->action   = trim($_POST['action']);
        $mvui->param    = trim($_POST['param']);
        //$mvui->pic      = 'http://' . $_SERVER['HTTP_HOST'] . '/file/' . trim(substr($_POST['key'],-36));
        if(!$mvui->save()){
            LogWriter::logModelSaveError($mvui,__METHOD__,$mvui->attributes);
            $this->die_json(array('code'=>404,'msg'=>'信息保存失败'));
        }
	 //$mvui->pic      = 'http://' . $_SERVER['HTTP_HOST'] . '/file/' . trim(substr($_POST['key'],-36));
        /*if(!empty($_REQUEST['flag'])){
             $this->RecordAdd($_POST,$mvui->pic,$flag=1);
        }else{
             $this->RecordAdd($_POST,$mvui->pic,$flag=0);
        }*/

        $this->die_json(array('code'=>200));
    }


    public function actionIndex(){

	$nid=$_GET['nid'];
        $gid=$nid;
        $epg=$_GET['epg'];
        if($epg=='首页'){
            $epg=1;
        }
        if($epg=='影视'){
            $epg=2;
        }
        if($epg=='教育'){
            $epg=3;
        }
        if($epg=='游戏'){
            $epg=4;
        }
        if($epg=='应用'){
            $epg=5;
        }
        if($epg=='咪咕专区'){
            $epg=6;
        }
        if($epg=='综艺专区'){
            $epg=7;
        }
        if($epg=='华数专区'){
            $epg=8;
        }
        if($epg=='咪咕极光'){
            $epg=9;
        }
        if($epg=='咪咕现场秀'){
            $epg=10;
        }
        if($epg=='咪咕精彩'){
            $epg=11;
        }
        if($epg=='甘肃专区'){
            $epg=12;
        }
        if($epg=='音乐'){
            $epg=13;
        }
        if($epg=='体育'){
            $epg=14;
        }
        if($epg=='南传专区'){
           $epg=15;
       }
        if($epg=='购物'){
           $epg=16;
        }
	if($epg == '推荐'){
           $epg = 17;		
	}
	if($epg == '电视剧集'){
	   $epg = 18;	
	}
	if($epg == '电影'){
	   $epg = 19;
	}
	if($epg == '少儿'){
	   $epg = 20;
	}
	if($epg == '综艺'){
	   $epg = 21;		
	}
        if($epg=='田园阳光'){
           $epg=22;
        }
	if($epg=='百视通区'){
	   $epg=23;
	}
        if($epg=='华推'){
            $epg=24;
        }
        if($epg=='华电视剧'){
            $epg=25;
        }
        if($epg=='华影'){
            $epg=26;
        }
        if($epg=='华少'){
            $epg=27;
        }
        if($epg=='华综'){
            $epg=28;
        }
        if($epg=='百推'){
            $epg=29;
        }
        if($epg=='百电视剧'){
            $epg=30;
        }
        if($epg=='百影'){
            $epg=31;
        }
        if($epg=='百少'){
            $epg=32;
        }
        if($epg=='百综'){
            $epg=33;
        }
        if($epg=='未推'){
            $epg=34;
        }
        if($epg=='未电视剧'){
            $epg=35;
        }
        if($epg=='未影'){
            $epg=36;
        }
        if($epg=='未少'){
            $epg=37;
        }
        if($epg=='未综'){
            $epg=38;
        }
        if($epg=='南推'){
            $epg=39;
        }
        if($epg=='南电视剧'){
            $epg=40;
        }
        if($epg=='南影'){
            $epg=41;
        }
        if($epg=='南少'){
            $epg=42;
        }
        if($epg=='南综'){
            $epg=43;
        }
        if($epg=='未来专区'){
           $epg=44;
        }
        if($epg=='美丽乡村'){
           $epg=45;
        }
        if($epg=='百直'){
           $epg=46;
        }
        if($epg=='芒推'){
           $epg=47;
        }	
        if($epg=='国推'){
           $epg=48;
        }
	if($epg=='华看电视'){
	   $epg=49;    	
	}
	if($epg=='芒果专区'){
           $epg=50;
        }
	if($epg=='国广专区'){
           $epg=51;
        }
	if($epg=='芒少'){
	   $epg=52;	
	}
	 if($epg=='芒电视剧'){
           $epg=53;
        }
	 if($epg=='芒影'){
           $epg=54;
        }
	 if($epg=='芒综'){
           $epg=55;
        }
	if($epg=='咪咕游戏'){
	   $epg=56; 
	}



        $mvui = MvUiManager::getAll($gid,$epg,99);
        $xiaotu = MvUiManager::getAll($gid,$epg,1);
        //print_r($xiaotu);die();
        $html = HTML::move($mvui,$xiaotu);

        $this->render("index",array('html'=>$html,'mvui'=>$mvui,'xiaotu'=>$xiaotu,'gid'=>$gid,'epg'=>$epg));
    }


    public function actionUpload(){
        if(empty($_GET['val']) || empty($_GET['gid']) || empty($_GET['epg'])){
            $this->die_json(array('code'=>404,'msg'=>'请选择要设置的位置'));
        }
        $mvui = MvUiManager::getAll($_GET['gid'],$_GET['epg'],99);
        $xiaotu = MvUiManager::getAll($_GET['gid'],$_GET['epg'],1);
        $html = HTML::moves($mvui,$xiaotu);

        
        $fid = isset($_GET['fid'])?$_GET['fid']:'';
        $t = isset($_GET['val'])?trim($_GET['val']):'';
        $substr = substr($t,0,1);
        if($substr=='b'){
            $type = '99';
        }elseif($substr=='s'){
            $type = '1';
        }
        if($type==99){
            //大图
           // print_r($mvui[$t][$fid]);
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
       $gid = $_GET['gid'];
        $ars = array_map(create_function('$record','return $record->attributes;'),MvNav::model()->findAll("gid = $gid group by `cp`"));
        //print_r($ars);
        foreach($ars as $key=>$val){
            $cpnew[]=$val['cp'];
        }
        $cpnew = isset($cpnew)?$cpnew:'';
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
		'cpnew'=>$cpnew,
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
        $img = substr($_POST['key'],-36);
        //Common::synchroPic($img);
        $mvui->title    = trim($_POST['title']);
        $mvui->position = trim($_POST['position']);
        $mvui->type     = trim($_POST['type']);
        $mvui->tType    = trim($_POST['tType']);
        $mvui->cp       = trim($_POST['cp']);
        $mvui->gid      = trim($_POST['gid']);
        $mvui->epg      = trim($_POST['epg']);
        $mvui->action   = trim($_POST['action']);
        $mvui->param    = trim($_POST['param']);
        $mvui->pic      = 'http://' . $_SERVER['HTTP_HOST'] . '/file/' . trim(substr($_POST['key'],-36));
        //$mvui->pic      = 'http://192.168.1.107/file/' . trim(substr($_POST['key'],-36));
        //$mvui->pic   = 'http://portalpic.itv.cmvideo.cn:8088/file/'.trim($img);
        if(!$mvui->save()){
            LogWriter::logModelSaveError($mvui,__METHOD__,$mvui->attributes);
            $this->die_json(array('code'=>404,'msg'=>'信息保存失败'));
        }

	/*if(!empty($_REQUEST['flag'])){
             $this->RecordAdd($_POST,$mvui->pic,$flag=1);
        }else{
             $this->RecordAdd($_POST,$mvui->pic,$flag=0);
        }*/

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
        $html = HTML::selvs($mvui);
        /*echo '<pre>';
        print_r($html);
        echo '</pre>';die;*/
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
        $img = substr($_POST['key'],-36);
        Common::synchroPic($img);

        $mvui->cid = trim($_POST['cid']);
        $mvui->title    = trim($_POST['title']);
        $mvui->type     = trim($_POST['type']);
        $mvui->tType    = trim($_POST['tType']);
        $mvui->cp       = trim($_POST['cp']);
        $mvui->pos      = trim($_POST['position']);
        $mvui->action   = trim($_POST['action']);
        $mvui->param    = trim($_POST['param']);
        //$mvui->pic      = 'http://' . $_SERVER['HTTP_HOST'] . '/file/' . trim(substr($_POST['key'],-36));
        //$mvui->pic      = 'http://192.168.1.107/file/' . trim(substr($_POST['key'],-36));
        $mvui->pic   = 'http://portalpic.itv.cmvideo.cn:8088/file/'.trim($img);
        if(!$mvui->save()){
            LogWriter::logModelSaveError($mvui,__METHOD__,$mvui->attributes);
            $this->die_json(array('code'=>404,'msg'=>'信息保存失败'));
        }
	if(!empty($_REQUEST['flag'])){
             $this->RecordAdd($_POST,$mvui->pic,$flag=1);
        }else{
             $this->RecordAdd($_POST,$mvui->pic,$flag=0);
        }
        $this->die_json(array('code'=>200));

    }

    public function actionDel(){
        if(empty($_REQUEST['id'])) $this->die_json(array('code'=>404,'msg'=>'参数不能为空'));
        $id = $_REQUEST['id'];
        Yii::app()->db->createCommand()->delete('{{mv_seui}}', "cid=$id");
        $del = MvUi::model()->deleteByPk($_REQUEST['id']);
        if(!$del){
            $this->die_json(array('code'=>404,'msg'=>'删除失败'));
        }
         $gid = !empty($_GET['gid'])?$_GET['gid']:'';
        $epg = !empty($_GET['epg'])?$_GET['epg']:'';
        $pos = !empty($_GET['pos'])?$_GET['pos']:'';
        $this->Recorddel($epg,$gid,$pos=0);
	$this->die_json(array('code'=>200,'msg'=>'删除成功'));
    }

    public function actionDels(){
        $id = $_REQUEST['id'];
        Yii::app()->db->createCommand()->delete('{{mv_seui}}', "cid=$id");
        //$dels = MvSeui::model()->deleteAll($criteria);

        $mvui = MvUiManager::getAll($_GET['gid'],$_GET['epg'],99);
        $fid = isset($_GET['fid'])?$_GET['fid']:'';
        $t = isset($_GET['val'])?trim($_GET['val']):'';
       // print_r($mvui[$t][$fid]['id']);
        $id=$mvui[$t][$fid]['id'];

        $del = MvUi::model()->deleteByPk($id);

        if(!$del){
            $this->die_json(array('code'=>404,'msg'=>'删除失败'));
        }
	$gid = $_GET['gid'];
        $epg = $_GET['epg'];
        $this->Recorddel($epg,$gid,$pos=0);
        $this->die_json(array('code'=>200,'msg'=>'删除成功'));
    }

    public function actionSedel(){
        if(empty($_REQUEST['id'])) $this->die_json(array('code'=>404,'msg'=>'参数不能为空'));
        $del = MvSeui::model()->deleteByPk($_REQUEST['id']);
        if(!$del){
            $this->die_json(array('code'=>404,'msg'=>'删除失败'));
        }
	$seUiModel = new MvSeui();
        $id = $_REQUEST['id'];
        //var_dump($id);
        $res = $seUiModel->findBySql("select cid from yd_mv_seui where id=:id",array(':id'=>$id));
        $res6 = $seUiModel->findBySql("select pos from yd_mv_seui where id=:id",array(':id'=>$id));
        $uiModel = new MvUi();
        $res2 = $uiModel->findBySql("select gid from yd_mv_ui where id=:id",array(':id'=>$res['cid']));
        $guideModel = new MvGuide();
        $res3 =  $guideModel->findBySql("select id from yd_mv_guide where id=:id",array(':id'=>$res2['gid']));
        $res4 =  $guideModel->findBySql("select pid from yd_mv_guide where id=:id",array(':id'=>$res3['pid']));
        $res5 =  $guideModel->findBySql("select id from yd_mv_guide where id=:id",array(':id'=>$res4['pid']));
        /*echo '<pre>';
        var_dump($res);
        var_dump($res3);
        var_dump($res5);
        var_dump($res6);die;*/
        $gid = !empty($_res5['id'])?$_res5['id']:'';
        $epg = !empty($_res3['id'])?$_res3['id']:'';
        $pos = !empty($_res6['pos'])?$_res6['pos']:'';
        $this->Recorddel($epg,$gid,$pos=0);

        $this->die_json(array('code'=>200,'msg'=>'删除成功'));
    }

    public function actionTodel(){
        $id = $_REQUEST['id'];
        Yii::app()->db->createCommand()->delete('{{mv_seui}}', "cid=$id");
        $epg = $_REQUEST['epg'];
        $pos = $_REQUEST['pos'];
        $gid = $_REQUEST['gid'];
        $result=Yii::app()->db->createCommand()->delete('{{mv_ui}}', "gid='$gid' and epg='$epg' and position='$pos'");
        if(!$result){
            $this->die_json(array('code'=>404,'msg'=>'删除失败'));
        }
	$this->Recorddel($epg,$gid,$pos);
        $this->die_json(array('code'=>200,'msg'=>'删除成功'));
    }


    public function RecordAdd($data,$pic,$flag)
    {
       
        $record = new MvUserrecord();
        if(!empty($data['tType'])){
            switch($data['tType'])
            {   
                case 1: $tType='跳转牌照方客户端';break;
                case 3: $tType='应用商城';  break;
                case 4: $tType='自有节目';  break;
                case 1: $tType='全屏大图';  break;
                case 1: $tType='二级专题页';break;
                case 1: $tType='咪咕音乐';  break;
                case 1: $tType='咪咕视讯'; break;
                case 1: $tType='咪咕学堂'; break;
                case 1: $tType='糖果乐园'; break;
                case 1: $tType='咪咕爱唱'; break;
                case 1: $tType='和动漫';   break;
            }
        }else{
            $tType = '';
        }
        if(!empty($data['cp'])){
            switch($data['cp'])
            {
                case 1: $cp='华数';break;
                case 2: $cp='百视通';break;
                case 3: $cp='未来电视';break;
                case 4: $cp='南传';break;
                case 5: $cp='芒果';break;
                case 6: $cp='国广';break;
                case 7: $cp='银河';break;
            }
        }else{
            $cp='';
        }
        $title    = !empty($data['title'])?$data['title']:'';
        $action   = !empty($data['action'])?$data['action']:'';
        $param    = !empty($data['param'])?$data['param']:'';
        $gid      = !empty($data['gid'])?$data['gid']:'';
        $epg      = !empty($data['epg'])?$data['epg']:'';
        $mid      = !empty($_GET['mid'])?$_GET['mid']:'';
        $pic      = !empty($pic)?$pic:'';
        $position = !empty($data['position'])?$data['position']:'';
        $guideModle = new MvGuide();
        $res = $guideModle->findBySql("select name from yd_mv_guide where id=:id",array(':id'=>$mid));
        $epgName= $guideModle->findBySql("select name from yd_mv_guide where id=:id",array(":id"=>$gid));
        $username = $_SESSION['username']; 
        if($flag == 1){
            $recordType = '操作';
        }else if($flag == 0){
            $recordType = '操作';
        }       
        date_default_timezone_set('PRC');
        if(!empty($cp)){
            $content = '用户：'.$username.'在'.date('Y-m-d,h:i:s',time()).$res['name'].'->'.$epgName['name'].'位置为：'.$position.$recordType.',上传类型为：'.$tType.'牌照方为: '.$cp.',标题为：'.$title.',action为'.$action.',param 为'.$param.',图片地址为'.$pic;   
        }else{
            $content = '用户：'.$username.'在'.date('Y-m-d,h:i:s',time()).$res['name'].'->'.$epgName['name'].'位置为：'.$position.$recordType.',上传类型为：'.$tType.'标题为: '.$title.',action为'.$action.',param 为'.$param.',图片地址为'.$pic; 
        }
        // var_dump($content);die;
        $record->type = $recordType;
        $record->content = $content;
        $record->addTime = time();
        $record->adminId = 1;
        $record->recordType= $recordType;
        $record->userId = 1;
        $record->recordName = $recordType;
        if($record->save()){
            return true;
        }
        
    }

    public function Recorddel($epg,$gid,$pos)
    {
        $mid  = $_GET['mid'];   //guide表主键
        $uiId = $_GET['id'];    //ui表主键
        $guideModle = new MvGuide();
        $res = $guideModle->findBysql("select name from yd_mv_guide where id=:id",array(':id'=>$mid));
        $epgName= $guideModle->findBySql("select name from yd_mv_guide where id=:id",array(":id"=>$gid));
        $uiModel = new MvUi();
        $list = $uiModel->findBySql("select title,param,action from yd_mv_ui where id=:id",array(":id"=>$uiId));
        $record = new MvUserrecord();
        $username = $_SESSION['username'];
        $recordType = '删除';
        date_default_timezone_set('PRC');
        if($pos == '0'){
            $content = '用户：'.$username.'在'.date('Y-m-d,h:i:s',time()).$res['name'].'->'.$epgName['name'].$recordType.'标题为: '.$list['title'].',action为'.$list['action'].',param 为'.$list['param'].'的内容';
        }else{
            $content = '用户：'.$username.'在'.date('Y-m-d,h:i:s',time()).$res['name'].'->'.$epgName['name'].$recordType.$pos.'整体的内容';
        }
        
        $record->type = $recordType;
        $record->content = $content;
        $record->addTime = time();
        $record->adminId = 1;
        $record->recordType= $recordType;
        $record->userId = 1;
        $record->recordName = $recordType;
        if($record->save()){
            return true;
        }
    }	
}
