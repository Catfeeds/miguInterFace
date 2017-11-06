
<?php

class DefaultController extends MController
{
	public function actionIndex(){
            $this->render('index');
	}
        public function actionWebbench2(){
		$sql = "SELECT * from test.yd_active where cTime = '1454436927'";
		$res = SQLManager::queryAll($sql);
		echo json_encode($res);
	}

	
        public function actionRegist(){
            $err = 0;
            $uid = 0;
            if(empty($_REQUEST['name']) || empty($_REQUEST['stbid']) || empty($_REQUEST['type']) || empty($_REQUEST['pro']) ||  empty($_REQUEST['cp']) ||  empty($_REQUEST['pay'])) $err = 1;
            if($err == 0){
                $name = $_REQUEST['name'];
                $stbid = $_REQUEST['stbid'];
                $type = $_REQUEST['type'];
                $province = $_REQUEST['pro'];
                $city = $_REQUEST['city'];
                //$cp = $_REQUEST['cp'];
                $cp = substr($_REQUEST['cp'],-1);
                $group = !empty($_REQUEST['group'])?$_REQUEST['group']:'0';
                $pay = $_REQUEST['pay'];
                $muser = $_REQUEST['muser'];
                $mdevice = $_REQUEST['mdevice'];
                $epgcode = !empty($_REQUEST['epgcode'])?$_REQUEST['epgcode']:'0';
                $criteria = new CDbCriteria();  
                $criteria->select = 'id';
                $criteria->condition = 'name=:name and stbid=:stbid and delFlag=0';
                $criteria->params = array(':name'=>$name,':stbid'=>$stbid);
                $tmp = User::model()->findAll($criteria);
                if(empty($tmp)){
                    $user = new User();
                    $user->name = $name;
                    $user->stbid = $stbid;
                    $user->type = $type;
                    $user->province = $province;
                    $user->city = $city;
                    $user->cp = $cp;
                    $user->group = $group;
                    $user->pay = $pay;
                    $user->mobileUser = $muser;
                    $user->mobileDevice = $mdevice;
                    $user->cTime = time();
                    $user->epgcode=$epgcode;
                    if($user->save()){
                        $tmp = User::model()->findAll($criteria);
                        $uid = $tmp[0]['id'];
                    }else{
                        $err = 1;
                    }
                }else{
                    $uid = $tmp[0]['id'];
                }
            }
            $res['err'] = $err;
            $res['uid'] = $uid;
            echo json_encode($res);
        }
        
        public function actionLogin(){
            $err = 0;
            if(empty($_REQUEST['uid']) || empty($_REQUEST['type']) || empty($_REQUEST['pro']) || empty($_REQUEST['city']) || 
                    empty($_REQUEST['cp']) || empty($_REQUEST['flag'])) $err = 1;
            
            if($err == 0){
                $active = new Active();
                $active->uid = $_REQUEST['uid'];
                $active->type = $_REQUEST['type'];
                $active->province = $_REQUEST['pro'];
                $active->city = $_REQUEST['city'];
                $active->cp = $_REQUEST['cp'];
                $active->flag = $_REQUEST['flag'];
                $active->cTime = time();
                $active->save();
            }
        }
        
        public function actionEpgActive(){
            $err = 0;
            if(empty($_REQUEST['uid']) || empty($_REQUEST['type']) || empty($_REQUEST['pro']) || empty($_REQUEST['city']) || 
                    empty($_REQUEST['cp']) || !isset($_REQUEST['epg1']) || empty($_REQUEST['epg2'])) $err = 1;
            
            if($err == 0){
                $active = new ActiveEpg();
                $active->uid = $_REQUEST['uid'];
                $active->type = $_REQUEST['type'];
                $active->province = $_REQUEST['pro'];
                $active->city = $_REQUEST['city'];
                $active->cp = $_REQUEST['cp'];
                $active->epg1 = $_REQUEST['epg1'];
                $active->epg2 = $_REQUEST['epg2'];
                $active->cTime = time();
                $active->save();
            }
        }
        
        public function actionPicActive(){
            $err = 0;
            if(empty($_REQUEST['uid']) || empty($_REQUEST['type']) || empty($_REQUEST['pro']) || empty($_REQUEST['city']) || 
                    empty($_REQUEST['cp']) || empty($_REQUEST['epg']) || empty($_REQUEST['pos'])) $err = 1;
            
            if($err == 0){
                $active = new ActivePic();
                $active->uid = $_REQUEST['uid'];
                $active->type = $_REQUEST['type'];
                $active->province = $_REQUEST['pro'];
                $active->city = $_REQUEST['city'];
                $active->cp = $_REQUEST['cp'];
                $active->epg = $_REQUEST['epg'];
                $active->pos = $_REQUEST['pos'];
                $active->cTime = time();
                $active->save();
            }
        }

	public function actionGetEpg(){
            $err = 0;
            $list = array();
            $map1 = array('1'=>'tuijian','2'=>'dianshi','3'=>'yinshi','4'=>'shaoer','5'=>'yingyong','6'=>'jishi');
            $map2 = array(
                'tuijian' => array('h-2','h-4','h-5','h-6','h-8','h-3','h-7'),
                'dianshi' => array('h-2','h-4','h-5','h-8','h-3','h-6','h-7'),
                'yinshi' => array('h-3','h-4','h-7','h-8','h-5','h-6','h-9'),
                'shaoer' => array('h-2','h-4','h-5','h-8','h-3','h-6','h-7','h-9'),
                'yingyong' => array('h-6','h-7','h-8','h-9','h-10','h-11','h-12','h-13','h-14'),
                'jishi' => array('h-2','h-4','h-5','h-8','h-3','h-6','h-7'),
            );
            if(empty($_REQUEST['epg']) || empty($_REQUEST['cp']) || !isset($_REQUEST['pro']) || !isset($_REQUEST['city'])) $err = 1;
            
            if($err==0){
                $epg = trim($_REQUEST['epg']);
                $cp = trim($_REQUEST['cp']);
                $pro = trim($_REQUEST['pro']);
                $city = trim($_REQUEST['city']);
            
                $type = $map1[$epg];
                $criteria = new CDbCriteria();          
                $criteria->select = 'position,title,bigImg,url,tType';
                $criteria->condition = 'type=:type and cp=:cp and provinceCode=:province and cityCode=:city and delFlag=0';
                $criteria->params = array(':type'=>$type,':cp'=>$cp,':province'=>$pro,':city'=>$city);
                $criteria->order = 'position asc,addTime desc';
                $tmp = Ui::model()->findAll($criteria);
                if(empty($tmp)){
                    $criteria->condition = 'type=:type and cp=:cp and provinceCode=:province and cityCode=0 and delFlag=0';
                    $criteria->params = array(':type'=>$type,':cp'=>$cp,':province'=>$pro);
                    $tmp = Ui::model()->findAll($criteria);
                    if(empty($tmp)){
                        $criteria->condition = 'type=:type and cp=:cp and provinceCode=0 and cityCode=0 and delFlag=0';
                        $criteria->params = array(':type'=>$type,':cp'=>$cp);
                        $tmp = Ui::model()->findAll($criteria);
                    }
                }
                if(!empty($tmp)){
                    $tmp_tmp = array();
                    foreach ($tmp as $tt){
                        $pos = $tt['position'];
                        $tmp2 = array();
                        if(empty($tmp_tmp[$pos])){
                            $tmp2[] = array('title'=>$tt['title'],'pic'=>$tt['bigImg'],'url'=>$tt['url'],'tType'=>$tt['tType']);
                            $tmp_tmp[$pos] = array('type'=>$tt['tType'],'info'=>$tmp2);
                        }else{
                            $tmp2 = $tmp_tmp[$pos]['info'];
                            $tmp2[] = array('title'=>$tt['title'],'pic'=>$tt['bigImg'],'url'=>$tt['url'],'tType'=>$tt['tType']);
                            $tmp_tmp[$pos]['info'] = $tmp2;
                        }
                    }
                    $int = 0;
                    foreach ($map2[$type] as $ttt){
                        $int++;
                        $list[$int] = $tmp_tmp[$ttt];
                    }
                }else{
                    $err = 1;
                }
            } 
            $res['err'] = $err;
            $res['list'] = $list;
            echo json_encode($res);
	}
        
        public function actionGetNotice(){
            $err = 0;
            if(empty($_REQUEST['cp']) || !isset($_REQUEST['pro']) || !isset($_REQUEST['city'])) $err = 1;
            
            if($err==0){
                $cp = $_REQUEST['cp'];
                $pro = $_REQUEST['pro'];
                $city = $_REQUEST['city'];
                $time = time();
                

                $criteria->select = 'notice';
                $criteria->condition = 'cp=:cp and province=:province and city=:city and sTime<=:time and eTime>=:time and delFlag=0';
                $criteria->params = array(':cp'=>$cp,':province'=>$pro,':city'=>$city,':time'=>$time);
                $tmp = Notice::model()->find($criteria);
                if(empty($tmp)){
                    $criteria->condition = 'cp=:cp and province=:province and city=0 and sTime<=:time and eTime>=:time and delFlag=0';
                    $criteria->params = array(':cp'=>$cp,':province'=>$pro,':time'=>$time);
                    $tmp = Notice::model()->find($criteria);
                    if(empty($tmp)){
                        $criteria->condition = 'cp=:cp and province=0 and city=0 and sTime<=:time and eTime>=:time and delFlag=0';
                        $criteria->params = array(':cp'=>$cp,':time'=>$time);
                        $tmp = Notice::model()->find($criteria);
                    }
                }
            }
            if(empty($tmp)){
                $res['err'] = 0;
                $res['notice'] = '';
            }else{
                $res['err'] = 1;
                $res['notice'] = $tmp['notice'];
            }
            echo json_encode($res);
        }
        
	public function actionError(){
            $this->ReturnDate(MSG::ERROR,MSG::ERROR_INFO);
	}
        
        public function actionGetEpgHenan(){
            $err = 0;
            $list = array();
            $map = array('h-1','h-3','h-6','h-2','h-4','h-5','h-7');
            if(empty($_REQUEST['cp']) || !isset($_REQUEST['pro']) || !isset($_REQUEST['city'])) $err = 1;
            
            if($err==0){
                $cp = trim($_REQUEST['cp']);
                $pro = trim($_REQUEST['pro']);
                $city = trim($_REQUEST['city']);
            
                $criteria = new CDbCriteria();          
                $criteria->select = 'pos,title,pic,url,type';
                $criteria->condition = 'cp=:cp';
                $criteria->params = array(':cp'=>$cp);
                $criteria->order = 'pos asc,upTime desc';
                $tmp = UiHenan::model()->findAll($criteria);
                if(!empty($tmp)){
                    $tmp_tmp = array();
                    foreach ($tmp as $tt){
                        $pos = $tt['pos'];
                        $tmp2 = array();
                        if(empty($tmp_tmp[$pos])){
                            $tmp2[] = array('title'=>$tt['title'],'pic'=>$tt['pic'],'url'=>$tt['url']);
                            $tmp_tmp[$pos] = array('type'=>$tt['type'],'info'=>$tmp2);
                        }else{
                            $tmp2 = $tmp_tmp[$pos]['info'];
                            $tmp2[] = array('title'=>$tt['title'],'pic'=>$tt['pic'],'url'=>$tt['url']);
                            $tmp_tmp[$pos]['info'] = $tmp2;
                        }
                    }
                    $int = 0;
                    foreach ($map as $ttt){
                        $int++;
                        $list[$int] = $tmp_tmp[$ttt];
                    }
                }else{
                    $err = 1;
                }
            } 
            $res['err'] = $err;
            $res['list'] = $list;
            echo json_encode($res);
	}

       
       public function actionGetBackimgs(){
            $page = empty($_REQUEST['pg'])?1:$_REQUEST['pg'];
            $start = ($page-1)*6;
            
            try{
                $sql = 'select title,pic from yd_background order by id asc LIMIT '.$start.',6';
                $res['list'] = SQLManager::queryAll($sql);
                
                $sql = 'select count(id) as cnt from yd_background';
                $cnt = SQLManager::queryRow($sql);
                $res['total'] = ceil($cnt['cnt']/6);
                
                echo json_encode($res);
            } catch (Exception $ex) {
                var_dump($ex);die;
            }
        }


    public function actionSearchContent(){
        if(empty($_REQUEST['kw'])) throw new ExceptionEx('关键字不能为空');

        $title = $_REQUEST['kw'];
        $page  = 20;
        $data = $this->getPageInfo($page);
        $data['title'] = $title;
        $list = VideoManager::getList($data);
        foreach($list['list'] as $key => $val){
            $vid = $val['vid'];
            $cp  = $val['cp'];
            $list['list'][$key]['pics'] = SQLManager::queryAll("select title,size,url from yd_video_pic where vid = '$vid' and cp = '$cp'");
            $list['list'][$key]['videos'] = SQLManager::queryAll("select title,size,url from yd_video_list where vid = '$vid' and cp = '$cp'");
        }
        $res['list'] = $list['list'];
        $res['total'] = ceil($list['count'] / $page);
        echo json_encode($res);
    }
    public function actionGetEpgGansu()
    {
        $err = 0;
        $list = array();
        $map1 = array('1' => 'tuijian', '2' => 'dianshi', '3' => 'yinshi', '4' => 'shaoer', '5' => 'yingyong', '6' => 'jishi');
        $map2 = array(
            'tuijian' => array('h-2', 'h-4', 'h-5', 'h-6', 'h-8', 'h-3', 'h-7'),
            'dianshi' => array('h-2', 'h-4', 'h-5', 'h-8', 'h-3', 'h-6', 'h-7'),
            'yinshi' => array('h-3', 'h-4', 'h-7', 'h-8', 'h-5', 'h-6', 'h-9'),
            'shaoer' => array('h-2', 'h-4', 'h-5', 'h-8', 'h-3', 'h-6', 'h-7', 'h-9'),
            'yingyong' => array('h-6', 'h-7', 'h-8', 'h-9', 'h-10', 'h-11', 'h-12', 'h-13', 'h-14'),
            'jishi' => array('h-2', 'h-4', 'h-5', 'h-8', 'h-3', 'h-6', 'h-7'),
        );
        if (empty($_REQUEST['epg']) || empty($_REQUEST['cp']) || !isset($_REQUEST['pro']) || !isset($_REQUEST['city'])) $err = 1;

        if ($err == 0) {
            $epg = trim($_REQUEST['epg']);
            $cp = trim($_REQUEST['cp']);
            $pro = trim($_REQUEST['pro']);
            $city = trim($_REQUEST['city']);
            $type = $map1[$epg];

            $criteria = new CDbCriteria();
            $criteria->select = 'pos,title,bigImg,url,tType';
            $criteria->condition = 'type=:type and cp=:cp and delFlag=0';
            $criteria->params = array(':type' => $type, ':cp' => $cp);
            $criteria->order = 'pos asc,cTime desc';
            $tmp = UiGansu::model()->findAll($criteria);
            if (empty($tmp)) {
                $criteria->condition = 'type=:type and cp=:cp and delFlag=0';
                $criteria->params = array(':type' => $type, ':cp' => $cp);
                $tmp = UiGansu::model()->findAll($criteria);
                if (empty($tmp)) {
                    $criteria->condition = 'type=:type and cp=:cp and delFlag=0';
                    $criteria->params = array(':type' => $type, ':cp' => $cp);
                    $tmp = UiGansu::model()->findAll($criteria);
                }
            }

            if (!empty($tmp)) {
                $tmp_tmp = array();
                foreach ($tmp as $tt) {
                    $pos = $tt['pos'];
                    $tmp2 = array();
                    if (empty($tmp_tmp[$pos])) {
                        $tmp2[] = array('title' => $tt['title'], 'pic' => $tt['bigImg'], 'url' => $tt['url'], 'tType' => $tt['tType']);
                        $tmp_tmp[$pos] = array('type' => $tt['tType'], 'info' => $tmp2);
                    } else {
                        $tmp2 = $tmp_tmp[$pos]['info'];
                        $tmp2[] = array('title' => $tt['title'], 'pic' => $tt['bigImg'], 'url' => $tt['url'], 'tType' => $tt['tType']);
                        $tmp_tmp[$pos]['info'] = $tmp2;
                    }
                }
                /*var_dump($map2[$type]);
                echo '<pre>';
                print_r($tmp_tmp);
                echo '</pre>';die;*/
                $int = 0;
                foreach ($map2[$type] as $ttt) {
                    $int++;
                    $list[$int] = $tmp_tmp[$ttt];
                }
            } else {
                $err = 1;
            }
        }
        $res['err'] = $err;
        $res['list'] = $list;
        echo json_encode($res);
    }
    public function actionGetWalls(){
        $err = 0;
        $list = array();
        if (!isset($_REQUEST['pro']) || !isset($_REQUEST['city'])) $err = 1;
        if($err == 0){
            $pro = $_REQUEST['pro'];
            $city = $_REQUEST['city'];
            $tmp = MvWallManager::getlists($pro,$city);
            if(!empty($tmp)){
                foreach($tmp as $val){
                    $list[] = $val;
                }
            }else{
                $err = 1;
            }
        }

        $res['err'] = $err;
        $res['list'] = $list;
        echo json_encode($res);
    }

    /*public function actionGettabs()
    {
        $err = 0;
        $tabs = array();
        $map = array('1'=>'首页','2'=>'影视','3'=>'教育','4'=>'游戏','5'=>'应用','6'=>'咪咕专区','7'=>'综艺专区','8'=>'华数专区','9'=>'咪咕极光','10'=>'咪咕现场秀','11'=>'咪咕精彩','12'=>'甘肃专区','13'=>'音乐','14'=>'体育','15'=>'南传专区');
        if (!isset($_REQUEST['pro']) || !isset($_REQUEST['city'])) $err = 1;
        //var_dump($map);
        if ($err == 0) {
            $pro = $_REQUEST['pro'];
            $city = $_REQUEST['city'];
            $tmp = MvGuideManager::getTab($pro, $city);
            $gongju = MvUiManager::getNew('0', $pro, $city);
            $cp = MvNavManager::getList($pro,$city);
            //var_dump($tmp);die;
            if (!empty($tmp)) {
               foreach($cp as $k=>$v){
                    $cps[] = $v['cp'];
                }
               $tool=array();
               if($tmp[0]['title']=='工具栏'){
                    $tool['title']=$tmp[0]['title'];
                    if(!empty($gongju)){
                    //$tool['title']=$tmp[0]['title'];
                    foreach($gongju as $val){
                        $tool['content'][]=$val;
                    }
                    }
                    unset($tmp[0]);
                    $res['tool'] = $tool;
                }
                //var_dump($tmp);
                foreach ($tmp as $val) {
                    foreach($map as $key=>$v){
                        if($val['title']==$v){
                            //echo $key;
                            $val['epg']=$key;
                        }
                    }
                    $tabs[]=$val;
                }

            } else {
                $err = 1;
            }


        }
        $res['err'] = $err;
        $res['tabs'] = $tabs;
        $res['cp'] = $cps;
        echo json_encode($res);
    }*/
    public function actionGettabs()
    {
        $err = 0;
        $tabs = array();
        $map = array('1'=>'首页','2'=>'影视','3'=>'教育','4'=>'游戏','5'=>'应用','6'=>'咪咕专区','7'=>'综艺专区','8'=>'华数专区','9'=>'咪咕极光','10'=>'咪咕现场秀','11'=>'咪咕精彩','12'=>'甘肃专区','13'=>'音乐','14'=>'体育','15'=>'百推');
        //if (!isset($_REQUEST['pro']) || !isset($_REQUEST['city'])) $err = 1;
        if ($err == 0) {
            //$pro = $_REQUEST['pro'];
            //$city = $_REQUEST['city'];
            $tmp = MvGuideManager::getTabs();
            //var_dump($tmp);die;
            if (!empty($tmp)) {
                foreach ($tmp as $val) {
                    foreach($map as $key=>$v){
                        if($val['title']==$v){
                            $val['epg']=$key;
                        }
                    }
                    $tabs[]=$val;
                }

            } else {
                $err = 1;
            }


        }
        $res['err'] = $err;
        $res['tabs'] = $tabs;
        echo json_encode($res);
    }


    /*public function actionGetnewepg()
    {
        $err = 0;
        $list = array();
        if (empty($_REQUEST['epg']) || !isset($_REQUEST['pro']) || !isset($_REQUEST['city'])) $err = 1;
        //if(empty($_REQUEST['epg'])) $err=1;
        if ($err == 0) {
            $epg = $_REQUEST['epg'];
            $pro = $_REQUEST['pro'];
            $city = $_REQUEST['city'];
            $tmp = MvUiManager::getNew($epg, $pro, $city);
            if (!empty($tmp)) {
                $tmp_tmp = array();
                foreach ($tmp as $tt) {
                    $pos = $tt['position'];
                    $tmp2 = array();
                    if (empty($tmp_tmp[$pos])) {
                            $tmp2[] = array('title' => $tt['title'], 'pic' => $tt['pic'], 'action' => $tt['action'], 'tType' => $tt['tType'], 'cp' => $tt['cp'], 'param' => $tt['param'],'cid'=>$tt['id']);
                            $tmp_tmp[$pos] = array('type' => $tt['type'], 'info' => $tmp2);


                    } else {
                        $tmp2 = $tmp_tmp[$pos]['info'];
                        $tmp2[] = array('title' => $tt['title'], 'pic' => $tt['pic'], 'action' => $tt['action'], 'tType' => $tt['tType'], 'cp' => $tt['cp'], 'param' => $tt['param'],'cid'=>$tt['id']);
                        $tmp_tmp[$pos]['info'] = $tmp2;


                    }
                }
                foreach ($tmp_tmp as $v) {
                    $list[] = $v;
                }
            } else {
                $err = 1;
            }
        }
        $res['err'] = $err;
        $res['list'] = $list;
        echo json_encode($res);

    }*/

   public function actionGetnewepg()
    {
    //header('Content-type: text/json;');
        $err = 0;
        $list = array();
        if (empty($_REQUEST['epg'])) $err = 1;
        if ($err == 0) {
            $epg = $_REQUEST['epg'];
            $tmp = MvUiManager::getLists($epg);      
            if (!empty($tmp)) {
                $tmp_tmp = array();
                foreach ($tmp as $tt) {
                    $pos = $tt['position'];
                    switch($tt['tType']){
                        case '9':$tt['action']='com.gschinamobile.hestudy';break;
                        case '7':
                            $arr = explode('&',$tt['action']);
                            $tt['action']='tv.icntv.migu.video&'.$arr[1];
                            break;
                    }
                    $tmp2 = array();
                    if (empty($tmp_tmp[$pos])) {
                            $tmp2[] = array('title' =>$tt['title'], 'pic' => $tt['pic'], 'action' => $tt['action'], 'tType' => $tt['tType'], 'cp' => $tt['cp'], 'param' => $tt['param'],'cid'=>$tt['id']);
                            $tmp_tmp[$pos] = array('type' => $tt['type'], 'info' => $tmp2);
                    } else {
                        $tmp2 = $tmp_tmp[$pos]['info'];
                        $tmp2[] = array('title' => $tt['title'], 'pic' => $tt['pic'], 'action' => $tt['action'], 'tType' => $tt['tType'], 'cp' => $tt['cp'], 'param' => $tt['param'],'cid'=>$tt['id']);
                        $tmp_tmp[$pos]['info'] = $tmp2;
                    }
                }
                foreach ($tmp_tmp as $v) {
                    $list[] = $v;
                }
            } else {
                $err = 1;
            }
        }
        $res['err'] = $err;
        $res['list'] = $list;
        echo json_encode($res);
    }

    public function actionGetselv(){
        $err = 0;
        $list = array();
        if (empty($_REQUEST['cid']) ) $err = 1;
        if($err==0){
            $cid = $_REQUEST['cid'];
            $tmp = MvSeuiManager::getList($cid);
            if(empty($tmp)){
                $err =1;
            }
        }
        $res['err'] = $err;
        $res['list'] = $tmp;
        echo json_encode($res);
    }
    public function actionIsClean(){
        if (!isset($_REQUEST['pro']) || !isset($_REQUEST['city'])) $res['flag'] = 0;
        $res['flag']=0;
        echo json_encode($res);
    }
    
    public function actionOnePicActive(){
        $err = 0;
        if(empty($_REQUEST['uid']) || empty($_REQUEST['type']) || !isset($_REQUEST['pro']) || !isset($_REQUEST['city']) || empty($_REQUEST['cp']) || empty($_REQUEST['epg']) || empty($_REQUEST['cid']) || empty($_REQUEST['title']) || empty($_REQUEST['vname'])) $err = 1;

        if($err == 0){
            $active = new ActiveOnepic();
            $active->uid = $_REQUEST['uid'];
            $active->type = $_REQUEST['type'];
            $active->province = $_REQUEST['pro'];
            $active->city = $_REQUEST['city'];
            $active->cp = $_REQUEST['cp'];
            $active->epg = $_REQUEST['epg'];
            $active->cid = $_REQUEST['cid'];
            $active->title = $_REQUEST['title'];
            $active->vname = $_REQUEST['vname'];
            $active->cTime = time();
            $active->save();
        }
    }
    public function actionTwoPicActive(){
        $err = 0;
        if(empty($_REQUEST['uid']) || empty($_REQUEST['type']) || !isset($_REQUEST['pro']) || !isset($_REQUEST['city']) || empty($_REQUEST['cp']) || empty($_REQUEST['epg']) || empty($_REQUEST['cid']) || empty($_REQUEST['title']) || empty($_REQUEST['vname']) || empty($_REQUEST['pos'])) $err = 1;

        if($err == 0){
            $active = new ActiveTwopic();
            $active->uid = $_REQUEST['uid'];
            $active->type = $_REQUEST['type'];
            $active->province = $_REQUEST['pro'];
            $active->city = $_REQUEST['city'];
            $active->cp = $_REQUEST['cp'];
            $active->epg = $_REQUEST['epg'];
            $active->cid = $_REQUEST['cid'];
            $active->title = $_REQUEST['title'];
            $active->vname = $_REQUEST['vname'];
            $active->pos = $_REQUEST['pos'];
            $active->cTime = time();
            $active->save();
            var_dump($active->getErrors());
        }
    }
    public function actionUsernum(){
            $err = 0;
            if(empty($_REQUEST['uid']) || empty($_REQUEST['vname']) || empty($_REQUEST['pro']) ) $err = 1;

            if($err == 0){
                $uid = $_REQUEST['uid'];
                $vname = $_REQUEST['vname'];
                $pro = $_REQUEST['pro'];
                $usergroup = !empty($_REQUEST['group'])?$_REQUEST['group']:'0';
                $epgcode = !empty($_REQUEST['epgcode'])?$_REQUEST['epgcode']:'0';
                $user = MvUser::model()->findByAttributes(array('uid'=>$uid));
                if(empty($user)){
                    $user = new MvUser();
                    $user->cTime = time();
                }else{
                    $user->cTime = time();
                }
                $user->uid = $uid;
                $user->vname = $vname;
                //$user->province=$pro;
                $user->usergroup = $usergroup;
                $user->epgcode = $epgcode;    
                if(!$user->save()){
                    $err = 1;
                    var_dump($user->getErrors());
                }
            }
            $res['err'] = $err;
            echo json_encode($res);
    }
    public function actionGettabes()
    {
        $err = 0;
        $tabs = array();
        $map = array('1'=>'首页','2'=>'影视','3'=>'教育','4'=>'游戏','5'=>'应用','6'=>'咪咕专区','7'=>'综艺专区','8'=>'华数专区','9'=>'咪咕极光','10'=>'咪咕现场秀','11'=>'咪咕精彩','12'=>'甘肃专区','13'=>'音乐','14'=>'体育','15'=>'南传专区','16'=>'购物','17'=>'推荐','18'=>'电视剧集','19'=>'电影','20'=>'少儿','21'=>'综艺','22'=>'田园阳光','23'=>'百视通区','24'=>'华推','25'=>'华电视剧','26'=>'华影','27'=>'华少','28'=>'华综','29'=>'百推','30'=>'百电视剧','31'=>'百影','32'=>'百少','33'=>'百综','34'=>'未推','35'=>'未电视剧','36'=>'未影','37'=>'未少','38'=>'未综','39'=>'南推','40'=>'南电视剧','41'=>'南影','42'=>'南少','43'=>'南综','44'=>'未来专区','45'=>'美丽乡村','46'=>'百直','47'=>'芒推','48'=>'国推','49'=>'华看电视','50'=>'芒果专区','51'=>'国广专区','52'=>'芒少','53'=>'芒电视剧','54'=>'芒影','55'=>'芒综','56'=>'咪咕游戏');
        if (!isset($_REQUEST['pro']) || !isset($_REQUEST['city'])) $err = 1;
        if ($err == 0) {
            $pro = $_REQUEST['pro'];
            $city = $_REQUEST['city'];
            $cp = $_REQUEST['cp'];
            $tmp = MvGuideManager::getNew($pro, $city,$cp);
            $gongju = MvUiManager::getCP('0', $pro, $city,$cp);
            $cp = MvNavManager::getList($pro,$city);
            if (!empty($tmp)) {
                foreach($cp as $k=>$v){
                    $cps[] = $v['cp'];
                }
                $tool['title']=$tmp[0]['title'];
                foreach($gongju as $val){
                    $tool['content'][]=$val;
                }
                unset($tmp[0]);
                foreach ($tmp as $val) {
                    foreach($map as $key=>$v){
                        if($val['title']==$v){
                            $val['epg']=$key;
                        }
                    }
                    $tabs[]=$val;
                }
            } else {
                $err = 1;
            }


        }
        $res['err'] = $err;
        $res['tabs'] = $tabs;
        $res['tool'] = $tool;
        $res['cp'] = $cps;
        echo json_encode($res);
    }

    public function actionGetnew()
    {
        $err = 0;
        $list = array();
        if (empty($_REQUEST['epg']) || !isset($_REQUEST['pro']) || !isset($_REQUEST['city'])) $err = 1;
        //if(empty($_REQUEST['epg'])) $err=1;
        if ($err == 0) {
            $epg = $_REQUEST['epg'];
            $pro = $_REQUEST['pro'];
            $city = $_REQUEST['city'];
            $gid = $_REQUEST['gid'];
            $tmp = MvUiManager::getOldGid($epg, $pro, $city,$gid);
            if (!empty($tmp)) {
                $tmp_tmp = array();
                foreach ($tmp as $tt) {
                    $pos = $tt['position'];
                    $tmp2 = array();
                    if (empty($tmp_tmp[$pos])) {
                        $tmp2[] = array('title' => $tt['title'], 'pic' => $tt['pic'], 'action' => $tt['action'], 'tType' => $tt['tType'], 'cp' => $tt['cp'], 'param' => $tt['param'],'cid'=>$tt['id']);
                        $tmp_tmp[$pos] = array('type' => $tt['type'], 'info' => $tmp2);


                    } else {
                        $tmp2 = $tmp_tmp[$pos]['info'];
                        $tmp2[] = array('title' => $tt['title'], 'pic' => $tt['pic'], 'action' => $tt['action'], 'tType' => $tt['tType'], 'cp' => $tt['cp'], 'param' => $tt['param'],'cid'=>$tt['id']);
                        $tmp_tmp[$pos]['info'] = $tmp2;
                    }
                }
                foreach ($tmp_tmp as $v) {
                    $list[] = $v;
                }
            } else {
                $err = 1;
            }
        }
        $res['err'] = $err;
        $res['list'] = $list;
        echo json_encode($res);

    }
    public function actionTgly(){
        $str =array('flag'=>0);
        echo json_encode($str);
    }
    public function actionOnePicActives(){
        $err = 0;
        if(empty($_REQUEST['uid']) || empty($_REQUEST['type']) || !isset($_REQUEST['pro']) || !isset($_REQUEST['city'])  || empty($_REQUEST['epg']) || empty($_REQUEST['cid']) || empty($_REQUEST['title']) || empty($_REQUEST['vname'])) $err = 1;
        $usergroup = !empty($_REQUEST['usergroup'])?$_REQUEST['usergroup']:'0';
            $epgcode= !empty($_REQUEST['epgcode'])?$_REQUEST['epgcode']:'0';
        if($err == 0){
            $active = new ActiveOnepic();
            $active->uid = $_REQUEST['uid'];
            $active->type = $_REQUEST['type'];
            $active->province = $_REQUEST['pro'];
            $active->city = $_REQUEST['city'];
            $active->cp = $_REQUEST['cp'];
            $active->epg = $_REQUEST['epg'];
            $active->cid = $_REQUEST['cid'];
            $active->pos = $_REQUEST['pos'];
            $active->rand = $_REQUEST['rand'];
            $active->title = $_REQUEST['title'];
            $active->vname = $_REQUEST['vname'];
            $active->cTime = time();
            $active->usergroup = $usergroup;
            $active->epgcode = $epgcode;
            $active->save();
            var_dump($active->getErrors());
        }
    }

    public function actionTwoPicActives(){
        $err = 0;
        if(empty($_REQUEST['uid']) || empty($_REQUEST['type']) || !isset($_REQUEST['pro']) || !isset($_REQUEST['city']) || empty($_REQUEST['cp']) || empty($_REQUEST['epg']) || empty($_REQUEST['cid']) || empty($_REQUEST['title']) || empty($_REQUEST['vname']) || empty($_REQUEST['pos'])) $err = 1;
        $usergroup = !empty($_REQUEST['usergroup'])?$_REQUEST['usergroup']:'0';
        $epgcode= !empty($_REQUEST['epgcode'])?$_REQUEST['epgcode']:'0';
        if($err == 0){
            $active = new ActiveTwopic();
            $active->uid = $_REQUEST['uid'];
            $active->type = $_REQUEST['type'];
            $active->province = $_REQUEST['pro'];
            $active->city = $_REQUEST['city'];
            $active->cp = $_REQUEST['cp'];
            $active->epg = $_REQUEST['epg'];
            $active->cid = $_REQUEST['cid'];
            $active->rand = $_REQUEST['rand'];
            $active->title = $_REQUEST['title'];
            $active->vname = $_REQUEST['vname'];
            $active->pos = $_REQUEST['pos'];
            $active->cTime = time();
            $active->usergroup = $usergroup;
            $active->epgcode = $epgcode;
            $active->save();
            var_dump($active->getErrors());
        }
    }
    public function actionDptab(){
        $err = 0;
        $list = array();
        if (!isset($_REQUEST['pro']) || !isset($_REQUEST['city']) || !isset($_REQUEST['type'])) $err = 1;
        if($err==0){
            $pro = $_REQUEST['pro'];
            $city = $_REQUEST['city'];
            $type = $_REQUEST['type'];
            $tmp = WxGuideManager::Dptab($pro,$city);
            if(!empty($tmp)){
                $pid = $tmp['id'];
                $list = WxGuideManager::getAll($pid,$type);
                $pids = $list['list']['id'];
                $data = WxGuideManager::getData($pids,$type);
            }else{
                $err=1;
            }
            $tmp['video_tab']=$data;
            $tmp['banner']=$list['banner'];
            $tmp['tabs']=$list['tab'];
            echo json_encode($tmp);
        }
    }

    public function actionDetail(){
        $err = 0;
        $list = array();
        if (!isset($_REQUEST['id']) ) $err = 1;
        if($err==0){
            $id = $_REQUEST['id'];
            $list=WxGuideManager::getDp($id);
            $res['tab']=$list;
        }
        echo json_encode($res);
    }

    public function actionDetaillist(){
        $err = 0;
        $list = array();
        if (!isset($_REQUEST['id']) ) $err = 1;
        if($err==0){
            $id = $_REQUEST['id'];
            $type=$_REQUEST['type'];
            $list=WxGuideManager::getDplist($id,$type);
            $res['list']=$list;
        }
        echo json_encode($res);
    }

    public function actionDetaillists(){
        $err = 0;
        $list = array();
        if (!isset($_REQUEST['id']) ) $err = 1;
        if($err==0){
            $id = $_REQUEST['id'];
            $type=$_REQUEST['type'];
            $p = $_REQUEST['p'];
            $list=WxGuideManager::getDplists($id,$type,$p);
            $res=$list;
        }
        echo json_encode($res);
    }

    public function actionDetailinfo(){
        $err = 0;
        $list = array();
        if (!isset($_REQUEST['id']) ) $err = 1;
        if($err==0){
            $id = $_REQUEST['id'];
            $type = $_REQUEST['type'];
            $list=WxGuideManager::getDpinfo($id,$type);
            $res=$list;
            /*if(empty($list['list'])){
                $res['flag']=0;
            }else{
                if($res['info']['classify']=='电视'){
                    $res['flag']=1;
                }else{
                    $res['flag']=2;
                }
            }*/
        }
        echo json_encode($res);
    }

    public function actionSearch(){
        $err = 0;
        if (!isset($_REQUEST['keyword']) ) $err = 1;
        if($err==0 && !empty($_REQUEST['keyword'])){
            $key = $_REQUEST['keyword'];
            $sql = "select * from yd_wx_movie where title like '%$key%' or director like '%$key%' or actor like '%$key%' or info like '%$key%'";
            $res['list'] = SQLManager::queryAll($sql);
        }else{
            $res['err']=1;
        }
        echo json_encode($res);

    }
    public function actionCheckVersion(){
        $app = intval($_REQUEST['app']);
        //echo $iapp;
        if ($app) {
            $result=WxVersion::model()->find("app='$app'");
            //var_dump($result);die;
            $res['info']=$result->attributes;
            echo json_encode($res);
        }else{
            $res['info'] = null;
            echo json_encode($res);
        }
    }
    public function actionDpuser(){
        $err = 0;
        if (!isset($_REQUEST['title']) && !isset($_REQUEST['pro']) && !isset($_REQUEST['stbid']) && !isset($_REQUEST['city']) && !isset($_REQUEST['cp']) && !isset($_REQUEST['id']) ) $err = 1;
        if($err==0){
            $dpuser = new WxDpuser();
            $dpuser->title = $_REQUEST['title'];
            $dpuser->province = $_REQUEST['pro'];
            $dpuser->city = $_REQUEST['city'];
            $dpuser->cp = $_REQUEST['cp'];
            $dpuser->cid = $_REQUEST['id'];
            $dpuser->type = $_REQUEST['type'];
            $dpuser->typeName = $_REQUEST['typeName'];
            $dpuser->stbid = $_REQUEST['stbid'];
            $dpuser->cTime = time();
            $dpuser->save();
            var_dump($dpuser->getErrors());
        }
    }

    public function actionUserversion(){
        $err = 0;
        if (!isset($_REQUEST['xmpp']) && !isset($_REQUEST['vname']) && !isset($_REQUEST['pro']) && !isset($_REQUEST['city']) && !isset($_REQUEST['stbid'])) $err = 1;
        if($err==0){
            $xmpp = $_REQUEST['xmpp'];
            $userversion = WxUserversion::model()->findByAttributes(array('xmpp' => $xmpp));
            if (empty($userversion)) {
                $userversion = new WxUserversion();
                $userversion->cTime = time();
            } else {
                $userversion->cTime = time();
            }
            $userversion->xmpp = $xmpp;
            $userversion->province = $_REQUEST['pro'];
            $userversion->city = $_REQUEST['city'];
            $userversion->vname = $_REQUEST['vname'];
            $userversion->stbid = $_REQUEST['stbid'];
            $userversion->cp = $_REQUEST['cp'];
            $userversion->flag = $_REQUEST['flag'];


            if (!$userversion->save()) {
                $err = 1;
                var_dump($userversion->getErrors());

            }
        }
    }

    public function actionVersion(){
        $tmp =WxVersion::model()->find(array('order'=>'version desc'));
        if(!empty($tmp)){
            $res['info']=$tmp->attributes;
            $res['flag']=1;
            echo json_encode($res);
        }else{
            $res['flag']=0;
            echo json_encode($res);
        }

    }
    public function actionTabes()
    {
        $err = 0;
        $tabs = array();
        $map = array('1'=>'首页','2'=>'影视','3'=>'教育','4'=>'游戏','5'=>'应用','6'=>'咪咕专区','7'=>'综艺专区','8'=>'华数专区','9'=>'咪咕极光','10'=>'咪咕现场秀','11'=>'咪咕精彩','12'=>'甘肃专区','13'=>'音乐','14'=>'体育','15'=>'南传专区
','16'=>'购物','17'=>'推荐','18'=>'电视剧集','19'=>'电影','20'=>'少儿','21'=>'综艺','22'=>'田园阳光','23'=>'百视通区','24'=>'华推','25'=>'华电视剧','26'=>'华影','27'=>'华少','28'=>'华综','29'=>'百推','30'=>'百电视剧','31'=>'百影','32'=>'百少','33'=>'百综','34'=>'未推','35'=>'未电视剧','36'=>'未影','37'=>'未少','38'=>'未综','39'=>'南推','40'=>'南电视剧','41'=>'南影','42'=>'南少','43'=>'南综','44'=>'未来专区','45'=>'美丽乡村','46'=>'百直','47'=>'芒推','48'=>'国推','49'=>'华看电视','50'=>'芒果专区','51'=>'国广专区','52'=>'芒少','53'=>'芒电视剧','54'=>'芒影','55'=>'芒综','56'=>'咪咕游戏');
        if (!isset($_REQUEST['pro']) || !isset($_REQUEST['city'])) $err = 1;
        if ($err == 0) {
            $pro = $_REQUEST['pro'];
            $city = $_REQUEST['city'];
            $cp = $_REQUEST['cp'];
            $usergroup = $_REQUEST['usergroup'];
            $epgcode = $_REQUEST['epgcode'];
            $tmp = MvGuideManager::getNews($pro, $city,$cp,$usergroup,$epgcode);
            $gongju = MvUiManager::getCP('0', $pro, $city,$cp,$usergroup,$epgcode);
            //var_dump($gongju);
            $cp = MvNavManager::getList($pro,$city,$usergroup,$epgcode);
            //var_dump($cp);die;
            if (!empty($tmp)) {
                foreach($cp as $k=>$v){
                    $cps[] = $v['cp'];
                }
                $tool=array();
                if($tmp[0]['title']=='工具栏'){
                $tool['title']=$tmp[0]['title'];
                foreach($gongju as $val){
                    $tool['content'][]=$val;
                }
                unset($tmp[0]);
                }
                foreach ($tmp as $val) {
                    foreach($map as $key=>$v){
                        if($val['title']==$v){
                            $val['epg']=$key;
                        }
                    }
                    $tabs[]=$val;
                }
            } else {
                $err = 1;
            }


        }
        $res['err'] = $err;
        $res['tabs'] = $tabs;
        $res['tool'] = $tool;
        $res['cp'] = $cps;
        echo json_encode($res);
    }
    public function actionEpgs()
    {
        $err = 0;
        $list = array();
        if (empty($_REQUEST['epg'])) $err = 1;
        if ($err == 0) {
            $epg = $_REQUEST['epg'];
            $gid = $_REQUEST['gid'];
            $tmp = MvUiManager::getGid($epg,$gid);
            if (!empty($tmp)) {
                $tmp_tmp = array();
                foreach ($tmp as $tt) {
                    $pos = $tt['position'];
                    $tmp2 = array();
                    if (empty($tmp_tmp[$pos])) {
                        $tmp2[] = array('title' =>$tt['title'], 'pic' => $tt['pic'], 'action' => $tt['action'], 'tType' => $tt['tType'], 'cp' => $tt['cp'], 'param' => $tt['param'],'cid'=>$tt['id']);
                        $tmp_tmp[$pos] = array('type' => $tt['type'], 'info' => $tmp2);
                    } else {
                        $tmp2 = $tmp_tmp[$pos]['info'];
                        $tmp2[] = array('title'=>$tt['title'], 'pic' => $tt['pic'], 'action' => $tt['action'], 'tType' => $tt['tType'], 'cp' => $tt['cp'], 'param' => $tt['param'],'cid'=>$tt['id']);
                        $tmp_tmp[$pos]['info']=$tmp2;
                    }
                }
                foreach ($tmp_tmp as $v) {
                    $list[] = $v;
                }
            } else {
                $err = 1;
            }
        }
        $res['err'] = $err;
        $res['list'] = $list;
        echo json_encode($res);
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////
    //3.0		 
    public function actionGetHomeTab()
    {
        $cacheId = 'GetHomeTab'.'?pro='.$_REQUEST['pro'].'&city='.$_REQUEST['city'].'&usergroup='.$_REQUEST['usergroup'].'&epgcode='.$_REQUEST['epgcode'].'&cp='.$_REQUEST['cp'];
        $value=Yii::app()->cache->get($cacheId);
        if($value===false) {
            $err = 0;
            if (!isset($_REQUEST['pro']) || !isset($_REQUEST['city']) || !isset($_REQUEST['usergroup']) || !isset($_REQUEST['epgcode'])) $err = 1;
            $res = array();
            if ($err == 0) {
                $pro = $_REQUEST['pro'];
                $city = $_REQUEST['city'];
                $usergroup = $_REQUEST['usergroup'];
                $epgcode = $_REQUEST['epgcode'];
                $cp = $_REQUEST['cp'];
                $tmp = VerGuideManager::getData($pro, $city, $cp, $usergroup, $epgcode);
                $res = $tmp;
            }
            $res['err'] = $err;
            $value = $res;
            Yii::app()->cache->set($cacheId, $value, CACHETIME);
            echo json_encode($value);
        }else{
            echo json_encode($value);
        }
    }

    public function actionGetDetail()
    {	
	$cacheId = 'GetDetail'.'?cid='.$_REQUEST['cid'].'&type='.$_REQUEST['type'];
        $value=Yii::app()->cache->get($cacheId);
        if($value===false) {
            // 因为在缓存中没找到 $value ，重新生成它 ，
            // 并将它存入缓存以备以后使用：
            // Yii::app()->cache->set($id,$value);
        $err = 0;
        if (empty($_REQUEST['cid']) || empty($_REQUEST['type']) || !isset($_REQUEST['pro']) || !isset($_REQUEST['city']) || !isset($_REQUEST['usergroup'])  || !isset($_REQUEST['epgcode'])) $err = 1;
        if($err==0){
            $vid = $_REQUEST['cid'];
            $type = $_REQUEST['type'];
            $pro = $_REQUEST['pro'];
            $city = $_REQUEST['city'];
            $cp = $_REQUEST['cp'];
            $usergroup = $_REQUEST['usergroup'];
            $epgcode = $_REQUEST['epgcode'];
            //$tmp = VerGuideManager::getStation($pro,$city,$cp,$usergroup,$epgcode);
            $tmp = VerGuideManager::getData($pro,$city,$cp,$usergroup,$epgcode);
	    $name_res = VerStation::model()->findByPk($tmp['station_id']);	
            //$list = VerGuideManager::getStationList($tmp['name']);
            $list = VerGuideManager::getStationList($name_res->attributes['name']);
            $tmp = VideoManager::getDetail($vid,$type,$list);
            $res['content']=$tmp;
        }
        $res['err']=$err;
	    $value = $res;
        Yii::app()->cache->set($cacheId, $value, CACHETIME);
              //echo '1';
              echo json_encode($res);
        }else{
            //echo '2';
            echo json_encode($value);
        }
	
    }

    public function actionSearchIndex()
    {
        $cacheId = 'SearchIndex'.'?pro='.$_REQUEST['pro'].'&city='.$_REQUEST['city'].'&usergroup='.$_REQUEST['usergroup'].'&epgcode='.$_REQUEST['epgcode'].'&cp='.$_REQUEST['cp'];
        $value=Yii::app()->cache->get($cacheId);
        if($value===false) {
            $pro = $_REQUEST['pro'];
            $city = $_REQUEST['city'];
            $usergroup = $_REQUEST['usergroup'];
            $epgcode = $_REQUEST['epgcode'];
            $cp = $_REQUEST['cp'];
            $tmp = VerGuideManager::getData($pro, $city, $cp, $usergroup, $epgcode);
	    $name_res = VerStation::model()->findByPk($tmp['station_id']);
            $list = VerSiteListManager::getStationList($name->attributes['name']);
            $res['list'] = VideoManager::getSomeContent($list);
            $row = 4;
            $res['movie'] = VideoManager::getMovie($list, $row);
            if (!empty($res['list']) && !empty($res['movie'])) {
                $err = 0;
                $res['err'] = $err;
            } else {
                $res['err'] = 1;
                $res['list'] = null;
                $res['movie'] = null;
            }
            $value = $res;
            Yii::app()->cache->set($cacheId, $value, CACHETIME);
            echo json_encode($value);
        }else{
            echo json_encode($value);
        }

    }

    public function actionHomeSearch()
    {
        $cacheId = 'HomeSearch'.'?pro='.$_REQUEST['pro'].'&city='.$_REQUEST['city'].'&usergroup='.$_REQUEST['usergroup'].'&epgcode='.$_REQUEST['epgcode'].'&cp='.$_REQUEST['cp'];
        $value=Yii::app()->cache->get($cacheId);
        if($value===false) {
            $pro = $_REQUEST['pro'];
            $city = $_REQUEST['city'];
            $usergroup = $_REQUEST['usergroup'];
            $cp = $_REQUEST['cp'];
            $epgcode = $_REQUEST['epgcode'];
            $row = 6;   //取多少条数据
            $tmp = VerGuideManager::getData($pro,$city,$cp,$usergroup,$epgcode);
	    $name_res = VerStation::model()->findByPk($tmp['station_id']);	
            $list = VerSiteListManager::getStationList($name_res->attributes['name']);
            $res['movie'] = VideoManager::getMovie($list,$row);
            if(!empty($res['movie'])){
                $res['err'] = 0;
            }else{
                $res['err'] = 1;
            }
            $value = $res;
            Yii::app()->cache->set($cacheId, $value, CACHETIME);
            echo json_encode($value);
        }else{
            echo json_encode($value);
        }
    }

    public function actionInitialsSearch()
    {
	    header("Content-type: text/html; charset=utf-8");
        $p = !empty($_REQUEST['p'])?$_REQUEST['p']:'1';
        $initial = !empty($_REQUEST['initials'])?$_REQUEST['initials']:'';
        $showType = !empty($_REQUEST['showType'])?$_REQUEST['showType']:'';
        $title = !empty($_REQUEST['title']) ? $_REQUEST['title'] : '';

        $cacheId = 'InitialsSearch'.'?pro='.$_REQUEST['pro'].'&city='.$_REQUEST['city'].'&usergroup='.$_REQUEST['usergroup'].'&epgcode='.$_REQUEST['epgcode'].'&cp='.$_REQUEST['cp'].'&initial='.$initial.'&showType='.$showType.'&title='.$title.'&p='.$p;
        $value=Yii::app()->cache->get($cacheId);

        if($value===false) {
            $pro = $_REQUEST['pro'];
            $city = $_REQUEST['city'];
            $usergroup = $_REQUEST['usergroup'];
            $cp = $_REQUEST['cp'];
            $epgcode = $_REQUEST['epgcode'];

            $tmp = VerGuideManager::getData($pro, $city, $cp, $usergroup, $epgcode);
	    $name_res = VerStation::model()->findByPk($tmp['station_id']);	
            $list = VerSiteListManager::getStationList($name_res->attributes['name']);

            if ($showType == '全部') {
                $showType = '';
            }
            $res = array();
            $res = VideoManager::initialSearch($initial, $showType, $title, $list, $p);
            $value = $res;
            Yii::app()->cache->set($cacheId, $value, CACHETIME);
            echo json_encode($value);
        }else{
            echo json_encode($value);
        }
   }

    public function actionTitleSearch()
    {
        $pro = $_REQUEST['pro'];
        $city = $_REQUEST['city'];
        $usergroup = $_REQUEST['usergroup'];
        $cp = $_REQUEST['cp'];
        $epgcode = $_REQUEST['epgcode'];
        $p = !empty($_REQUEST['p'])?$_REQUEST['p']:'1';
        $initial = !empty($_REQUEST['initials'])?$_REQUEST['initials']:'';
        $showType = !empty($_REQUEST['showType'])?$_REQUEST['showType']:'';

        $cacheId = 'TitleSearch'.'?pro='.$_REQUEST['pro'].'&city='.$_REQUEST['city'].'&usergroup='.$_REQUEST['usergroup'].'&epgcode='.$_REQUEST['epgcode'].'&cp='.$_REQUEST['cp'].'&initial='.$initial.'&showType='.$showType.'&p='.$p;
        $value=Yii::app()->cache->get($cacheId);
        if($value===false) {
            $tmp = VerGuideManager::getData($pro,$city,$cp,$usergroup,$epgcode);
	    $name_res = VerStation::model()->findByPk($tmp['station_id']);	
            $list = VerSiteListManager::getStationList($name_res->attributes['name']);

            if($showType == '全部' ){
                $showType = '';
            }
            $res = array();
            $res = VideoManager::titleSearch($initial,$showType,$list,$p);
            $value = $res;
            Yii::app()->cache->set($cacheId, $value, CACHETIME);
            echo json_encode($value);
        }else{
            echo json_encode($value);
        }
   }


 
    public function actionGetEpgContent()
    {
        $err = 0;
        if(!empty($_REQUEST['gid'])){
            $gid = $_REQUEST['gid'];
        }else{
            $err = '1';
            $list['err'] = $err;
            echo json_encode($list);
            return;
        }

        $cacheId = 'GetEpgContent'.'?gid='.$_REQUEST['gid'];

        $value=Yii::app()->cache->get($cacheId);
        if($value===false) {
	    $sql = "select upTime from yd_ver_screen_content where `screenGuideId`=$gid group by upTime order by upTime desc";
 	    $res = SQLManager::queryAll($sql);
	    $data=array();
            if(empty($res)){
                return null;
            }else{
                $data['updateTime']= $res[0]['upTime'];
            }
            //$res['updateTime'] = VerScreenContentManager::getEpgContentUpdateTime(8);
            $data['err'] = '0';
            //$data['list'] = VerScreenContentManager::getEpgContent($gid);
	    $info = array();
    $sql_select="select c.type,c.tType, g.gid,s.circular as is_circular ,c.id ,c.cp,c.cid,c.action,c.param,c.title as main_title,c.uType,c.width,c.height,c.x,c.y,c.pic,c.order,c.videoUrl from yd_ver_screen_content c ,yd_ver_screen_guide g,yd_ver_station s";
    $sql_where = " where `screenGuideId`=$gid and `delFlag`=0 and c.screenGuideid=g.id and g.gid=s.id order by `order`";
    $sql = $sql_select.$sql_where;
    $info = SQLManager::queryAll($sql);
    if(empty($info)){
        return null;
    }
    foreach ($info as $k => $v) {
        if($v['is_circular']=='2'){//无圆角
            $v['is_circular']=1;
        }else{
            $v['is_circular']=0;//圆角
        }
        $order = $v['order'];
        if (empty($arr[$order])) {
            $arr[$order]['banner'][] = $v;
        } else {
            $tmp = $arr[$order]['banner'];
            $tmp[] = $v;
            $arr[$order]['banner'] = $tmp;
        }
        if($v['cid'] == ' '){
            $v['cid'] = '0';
        }
    }
    foreach ($arr as $k=>$v){
        $newArr[] = $v;
    }
	$data['list']=$newArr;

            $value = $data;
            Yii::app()->cache->set($cacheId, $value, CACHETIME);
            echo json_encode($value);
        }else{
            echo json_encode($value);
        }
    }

    public function actionSpecial(){
        $err = 0;
        if (empty($_REQUEST['cid'])){
            $err = 1;
            $res['err']=$err;
            echo json_encode($res);
            return;
        }

        $cacheId = 'Special'.'?cid='.$_REQUEST['cid'];
        $value=Yii::app()->cache->get($cacheId);
        if($value===false) {
            $vid = $_REQUEST['cid'];
            $tmp= VerBkimg::model()->find("gid='$vid'");
            $res['wallpaper']=$tmp->attributes;
            $res['content'] = VerUiManager::getList($vid);
            $err = 0;
            $res['err']=$err;
            $value = $res;
            Yii::app()->cache->set($cacheId, $value, CACHETIME);
            echo json_encode($value);
        }else{
            echo json_encode($value);
        }

    }

    public function actionClassifyData(){
        $cacheId = 'ClassifyData'.'?cid='.$_REQUEST['cid'].'&p='.$_REQUEST['p'];
        $value=Yii::app()->cache->get($cacheId);
        if($value===false) {
            // 因为在缓存中没找到 $value ，重新生成它 ，
            // 并将它存入缓存以备以后使用：
            // Yii::app()->cache->set($id,$value);
        $err = 0;
        if (empty($_REQUEST['cid'] || empty($_REQUEST['p']))) $err = 1;
        if($err==0){
            $gid = $_REQUEST['cid'];
            $p = $_REQUEST['p'];
            $tmp = VerSiteListManager::getSiteList($gid,$p);
            $res = $tmp;
        }
        $res['err']=$err;
        //echo json_encode($res);
        $value = $res;
            Yii::app()->cache->set($cacheId, $value, 60);
            //echo '1';
            echo json_encode($res);
        }else{
            //echo '2';
            echo json_encode($value);
        }
    }


    public function actionClassify(){
        $err = 0;
        if (!isset($_REQUEST['cid'])){
            $err = 1;
            $res['err']=$err;
            echo json_encode($res);
            return;
        }
        $res=array();
        $cacheId = 'Classify'.'?cid='.$_REQUEST['cid'];
        $value=Yii::app()->cache->get($cacheId);
        if($value===false) {
            $cid= $_REQUEST['cid'];
            $tmp = VerGuideManager::getClassify($cid);
            $res=$tmp;
            $err = 0;
            $res['err']=$err;
            $value = $res;
            Yii::app()->cache->set($cacheId, $value, CACHETIME);
            echo json_encode($value);
        }else{
            echo json_encode($value);
        }

    }
    
    public function actionMsgContent(){
        $err = 0;
        if (!isset($_REQUEST['pro']) || !isset($_REQUEST['city']) || !isset($_REQUEST['usergroup']) || !isset($_REQUEST['epgcode'])){
            $err = 1;
            $res['err']=$err;
            echo json_encode($res);
            return;
        }
        $pro = $_REQUEST['pro'];
        $city = $_REQUEST['city'];
        $usergroup = $_REQUEST['usergroup'];
        $epgcode = $_REQUEST['epgcode'];
        $cp = !empty($_REQUEST['cp'])?$_REQUEST['cp']:'';
        $cacheId = 'MsgContent'.'?pro='.$_REQUEST['pro'].'&city='.$_REQUEST['city'].'&usergroup='.$_REQUEST['usergroup'].'&epgcode='.$_REQUEST['epgcode'].'&cp='.$cp;
        $value=Yii::app()->cache->get($cacheId);
        if($value===false) {
            $tmp = MessageManager::getMsgData($pro,$city,$usergroup,$epgcode,$cp);
	        if($tmp['uType']=='') $tmp['uType']=0;
            $res['content']=$tmp;
            $err = 0;
            $res['err']=$err;
            $value = $res;
            Yii::app()->cache->set($cacheId, $value, CACHETIME);
            echo json_encode($value);
        }else{
            echo json_encode($value);
        }
    }

    public function actionFilter(){
        $err = 0;
        if (empty($_REQUEST['cid'])){
            $err = 1;
            $res['err']=$err;
            echo json_encode($res);
            return;
        }

        $cacheId = 'Filter'.'?cid='.$_REQUEST['cid'];
        $value=Yii::app()->cache->get($cacheId);
        if($value===false) {
            $cid = $_REQUEST['cid'];
            $tmp = VerSiteListManager::getFilter($cid);
            $res['tab']=$tmp;
            $err = 0;
            $res['err']=$err;
            $value = $res;
            Yii::app()->cache->set($cacheId, $value, CACHETIME);
            echo json_encode($value);
        }else{
            echo json_encode($value);
        }

    }

    public function actionFiltData(){
        $err = 0;
        if (empty($_REQUEST['cid'])){
            $err = 1;
            $res['err']=$err;
            echo json_encode($res);
            return;
        }
        $cacheId = 'Filter'.'?cid='.$_REQUEST['cid'];
        $value=Yii::app()->cache->get($cacheId);
        if($value===false) {
            $cid = $_REQUEST['cid'];
            $country = $_REQUEST['country'];
            $year = $_REQUEST['year'];
            $p = $_REQUEST['p'];
            $tmp = VerSiteListManager::getFiltData($cid,$country,$year,$p);
            $res = $tmp;
            $err = 0;
            $res['err']=$err;
            $value = $res;
            Yii::app()->cache->set($cacheId, $value, CACHETIME);
            echo json_encode($value);
        }else{
            echo json_encode($value);
        }
    }
  
    public function actionGetNewWallPaper()
    {
        $err = 0;
        $list = array();
        if (!isset($_REQUEST['pro']) || !isset($_REQUEST['city'])){
            $err = 1;
            $res['err']=$err;
            echo json_encode($res);
            return;
        }

        $usergroup = isset($_REQUEST['usergroup'])?$_REQUEST['usergroup']:'';
        $epgcode = isset($_REQUEST['epgcode'])?$_REQUEST['epgcode']:'';
        $cp = !empty($_REQUEST['cp'])?$_REQUEST['cp']:'';
        $cacheId = 'GetNewWallPaper'.'?pro='.$_REQUEST['pro'].'&city='.$_REQUEST['city'].'&usergroup='.$usergroup.'&epgcode='.$epgcode.'&cp='.$cp;
        $value=Yii::app()->cache->get($cacheId);
        if($value===false) {
            $pro  = $_REQUEST['pro'];
            $city = $_REQUEST['city'];
            $tmp = VerWallManager::getData($pro,$city,$cp,$usergroup,$epgcode);
            if (!empty($tmp)) {
                foreach ($tmp as $val) {
                    $list[] = $val;
                }
            } else {
                $err = 1;
            }
            $res['err'] = $err;
            $res['walls'] = $list;
            $value = $res;
            Yii::app()->cache->set($cacheId, $value, CACHETIME);
            echo json_encode($value);
        }else{
            echo json_encode($value);
        }

    }

    public function actionGetTest(){
        $err = 0;
        if (empty($_REQUEST['cid']) || empty($_REQUEST['type'])) $err = 1;
        if($err==0){
            $vid = $_REQUEST['cid'];
            $type = $_REQUEST['type'];
            $tmp = VideoManager::getNewDetail($vid,$type);
            $res['content']=$tmp;
        }
        $res['err']=$err;
        echo json_encode($res);
    }

    public function actionGetSpecialContent()
    {
        $cacheId = 'GetSpecialContent'.'?gid='.$_REQUEST['gid'];
        $value=Yii::app()->cache->get($cacheId);
        if($value===false) {
            $gid = $_REQUEST['gid'];
            $bkimg = VerBkimg::model()->find("gid = $gid");
            if (empty($bkimg)) {
                $bkimg = new VerBkimg();
            } else {
                $type = $bkimg->attributes['type'];
            }
            if ($type == '3') {
                $sql = "select a.upTime,a.id,a.tType,a.vid,a.param,a.action,a.title,a.vid,a.pic,a.uType,a.scort,a.position,a.type,b.assetId,b.cp,b.url from yd_ver_ui as a left join yd_video_list as b on a.vid=b.vid where a.gid=$gid AND a.`delFlag`=0 and b.flag='1' order by `position` asc";
            } else {
                $sql = "select a.upTime,a.id,a.vid,a.param,a.action,a.title,a.vid,a.pic,a.uType,b.templateType as vuType,a.scort,a.cp,a.position,a.type,b.type as vType,a.tType from yd_ver_ui as a left join yd_video as b on a.vid=b.vid where a.gid=$gid AND a.`delFlag`=0   order by `position`,scort asc";
            }
            $tmp = SQLManager::queryAll($sql);
            $sql_bg = "select url from yd_ver_bkimg where delFlag=0 and gid=$gid";
            $bg = SQLManager::queryRow($sql_bg);
            if (!empty($bg)) {
                $res['bg'] = $bg['url'];
            } else {
                $res['bg'] = null;
            }
            if (!empty($tmp)) {
                $tmp_tmp = array();
                foreach ($tmp as $tt) {
                    if (is_null($tt['uType'])) {
                        switch ($tt['vType']) {
                            case '电影':
                                $tt['uType'] = 'A';
                                break;
                            case '电视剧':
                                $tt['uType'] = 'B';
                                break;
                            case '综艺':
                                $tt['uType'] = 'C';
                                break;
                            case '新闻':
                                $tt['uType'] = 'D';
                                break;
                            default:
                                $tt['uType'] = 'D';
                                break;
                        }
                    }
                    switch ($tt['uType']) {
                        case 'A':
                            $tt['uType'] = '7';
                            break;
                        case 'B':
                            $tt['uType'] = '8';
                            break;
                        case 'C':
                            $tt['uType'] = '10';
                            break;
                        case 'D':
                            $tt['uType'] = '9';
                            break;
                        default :
                            $tt['uType'] = $tt['uType'];
                            break;
                    }
                    $pos = $tt['position'];
                    $tmp2 = array();
                    if (empty($tmp_tmp[$pos])) {
                        if ($tt['position'] == 'appTop') {
                            $tt['position'] = '5';
                        }
                        if ($type == '3') {
                            $pa = "/<|\m3u8|ts/";
                            preg_match($pa, $tt['url'], $match);
                            $tmp2[] = array(
                                'title' => $tt['title'],
                                'pic' => $tt['pic'],
                                'action' => $tt['action'],
                                'uType' => $tt['uType'],
                                'cp' => $tt['cp'],
                                'param' => $tt['param'],
                                'vid' => $tt['vid'],
                                'position' => $tt['position'],
                                'assetId' => $tt['assetId'],
                                'tType' => $tt['tType'],
                                'upTime' => $tt['upTime'],
                                'id' => $tt['id'],
                                'url' => $match[0],
                            );
                        } else {
                            $tmp2[] = array(
                                'title' => $tt['title'],
                                'pic' => $tt['pic'],
                                'action' => $tt['action'],
                                'uType' => $tt['uType'],
                                'cp' => $tt['cp'],
                                'param' => $tt['param'],
                                'vid' => $tt['vid'],
                                'tType' => $tt['tType'],
                                'upTime' => $tt['upTime'],
                                'id' => $tt['id'],
                                'position' => $tt['position'],
                            );
                        }
                        $tmp_tmp[$pos] = array('info' => $tmp2);
                    } else {
                        if ($tt['position'] == 'appTop') {
                            $tt['position'] = '5';
                        }
                        $tmp2 = $tmp_tmp[$pos]['info'];
                        if ($type == '3') {
                            $pa = "/<|\m3u8|ts/";
                            preg_match($pa, $tt['url'], $match);
                            $tmp2[] = array(
                                'title' => $tt['title'],
                                'pic' => $tt['pic'],
                                'action' => $tt['action'],
                                'uType' => $tt['uType'],
                                'cp' => $tt['cp'],
                                'param' => $tt['param'],
                                'vid' => $tt['vid'],
                                'position' => $tt['position'],
                                'assetId' => $tt['assetId'],
                                'tType' => $tt['tType'],
                                'upTime' => $tt['upTime'],
                                'id' => $tt['id'],
                                'url' => $match[0],
                            );
                        } else {
                            $tmp2[] = array(
                                'title' => $tt['title'],
                                'pic' => $tt['pic'],
                                'action' => $tt['action'],
                                'uType' => $tt['uType'],
                                'cp' => $tt['cp'],
                                'param' => $tt['param'],
                                'vid' => $tt['vid'],
                                'tType' => $tt['tType'],
                                'upTime' => $tt['upTime'],
                                'id' => $tt['id'],
                                'position' => $tt['position'],
                            );
                        }
                        $tmp_tmp[$pos]['info'] = $tmp2;
                    }
                }
                foreach ($tmp_tmp as $v) {
                    $list[] = $v;
                }
                $err = 0;
                $res['err'] = $err;
                $res['list'] = $list;
            } else {
                $err = 1;
                $res['err'] = $err;
            }
            $value = $res;
            Yii::app()->cache->set($cacheId, $value, CACHETIME);
            echo json_encode($value);
        }else{
            echo json_encode($value);
        }


    }

   public function actionGetTextVersionContent()
   {
       $cacheId = 'GetTextVersionContent'.'?gid='.$_REQUEST['gid'];
       $value=Yii::app()->cache->get($cacheId);
       if($value===false) {
            $gid = $_REQUEST['gid'];
            $sql = "select a.tType,a.vid,a.param,a.action,a.title,a.vid,a.pic,a.uType,a.scort,a.position,a.type,b.assetId,b.cp,b.url from yd_ver_ui as a left join yd_video_list as b on a.vid=b.vid where a.gid=$gid AND a.`delFlag`=0 and b.flag='1' order by `position` asc";
            $tmp = SQLManager::queryAll($sql);
            $sql_bg = "select url from yd_ver_bkimg where delFlag=0 and gid=$gid";
            $bg =  SQLManager::queryRow($sql_bg);
            if(!empty($bg)){
                $res['bg'] = $bg['url'];
            }else{
                $res['bg'] = null;
            }
            if (!empty($tmp)) {
                $tmp_tmp = array();
                foreach ($tmp as $tt) {
                    if(is_null($tt['uType'])){
                        switch($tt['vType']){
                            case '电影':$tt['uType']='A';break;
                            case '电视剧':$tt['uType']='B';break;
                            case '综艺':$tt['uType']='C';break;
                            case '新闻':$tt['uType']='D';break;
                            default:$tt['uType']='D';break;
                        }
                    }
                    switch($tt['uType'])
                    {
                        case 'A':$tt['uType']='7';break;
                        case 'B':$tt['uType']='8';break;
                        case 'C':$tt['uType']='10';break;
                        case 'D':$tt['uType']='9';break;
                        default : $tt['uType']=$tt['uType'];break;
                    }
                    $pos = $tt['position'];
                    $tmp2 = array();
                    if (empty($tmp_tmp[$pos])) {
                        if($tt['position'] =='appTop'){
                            $tt['position'] = '5';
                        }

                        $pa = "/<|\m3u8|ts/";
                        preg_match($pa, $tt['url'], $match);
                        $tmp2[] = array(
                            'title'    => $tt['title'],
                            'pic'      => $tt['pic'],
                            'action'   => $tt['action'],
                            'uType'    => $tt['uType'],
                            'cp'       => $tt['cp'],
                            'param'    => $tt['param'],
                            'vid'      => $tt['vid'],
                            'position' => $tt['position'],
                            'assetId'  => $tt['assetId'],
                            'tType'    => $tt['tType'],
                            'url'      => $match[0],
                        );
                        $tmp_tmp[$pos] = array( 'info' => $tmp2);
                    } else {
                        if($tt['position'] =='appTop'){
                            $tt['position'] = '5';
                        }
                        $tmp2 = $tmp_tmp[$pos]['info'];
                            $pa = "/<|\m3u8|ts/";
                            preg_match($pa, $tt['url'], $match);
                            $tmp2[] = array(
                                'title'    => $tt['title'],
                                'pic'      => $tt['pic'],
                                'action'   => $tt['action'],
                                'uType'    => $tt['uType'],
                                'cp'       => $tt['cp'],
                                'param'    => $tt['param'],
                                'vid'      => $tt['vid'],
                                'position' => $tt['position'],
                                'assetId'  => $tt['assetId'],
                                'tType'    => $tt['tType'],
                                'url'      => $match[0],
                            );
                        $tmp_tmp[$pos]['info'] = $tmp2;
                    }
                }
                foreach ($tmp_tmp as $v) {
                    $list[] = $v;
                }
                $err = 0;
                $res['err'] =$err;
                $res['list'] = $list;
            } else {
                $err = 1;
                $res['err'] = $err;
            }
           $value = $res;
           Yii::app()->cache->set($cacheId, $value, CACHETIME);
           echo json_encode($value);
       }else{
           echo json_encode($value);
       }

    }

    
    public function actionClassifyDataTextVersion()
    {
        $cacheId = 'ClassifyData'.'?cid='.$_REQUEST['cid'];
        $value=Yii::app()->cache->get($cacheId);
        if($value===false) {
            // 因为在缓存中没找到 $value ，重新生成它 ，
            // 并将它存入缓存以备以后使用：
            // Yii::app()->cache->set($id,$value);
        $err = 0;
        if (empty($_REQUEST['cid'] )) $err = 1;
        if($err==0){
            $gid = $_REQUEST['cid'];
            $tmp = VerSiteListManager::getSiteListTextVersion($gid);
            $res = $tmp;
        }
        $res['err']=$err;
        //echo json_encode($res);
        $value = $res;
            Yii::app()->cache->set($cacheId, $value, 60);
            //echo '1';
            echo json_encode($res);
        }else{
            //echo '2';
            echo json_encode($value);
        }
    }

    public function actionStation(){
        $err = 0;
        if (!isset($_REQUEST['pro']) || !isset($_REQUEST['city']) || !isset($_REQUEST['usergroup']) ) $err = 1;
        if($err==0){
            $pro = $_REQUEST['pro'];
            $city = $_REQUEST['city'];
            $usergroup = $_REQUEST['usergroup'];
            $cp = $_REQUEST['cp'];
            $epgcode = $_REQUEST['epgcode'];
            $tmp = VerGuideManager::getStation($pro,$city,$cp,$usergroup,$epgcode);
            if(!empty($tmp)){
                if($tmp['mark']=='0'){
	            $list['flag']='0';
                }else{
                    $list['flag']='1';
                }
                $cptmp=trim($tmp['cp'],'/');
                switch($cptmp){
                       case '1':$list['cp'] = '699211';break;
                       case '2':$list['cp'] = '699212';break;
                       case '3':$list['cp'] = '699213';break;
                       case '4':$list['cp'] = '699214';break;
                       case '5':$list['cp'] = '699215';break;
                       case '6':$list['cp'] = '699216';break;
                       case '7':$list['cp'] = '699217';break;
                }

                $cps = array();
                $cps = explode('/',trim($tmp['cps'],'/'));
                foreach($cps as $k=>$v){
		            switch($v){
                       case '1':$newcp = '699211';break;
                       case '2':$newcp = '699212';break;
                       case '3':$newcp = '699213';break;
                       case '4':$newcp = '699214';break;
                       case '5':$newcp = '699215';break;
                       case '6':$newcp = '699216';break;
                       case '7':$newcp = '699217';break;
                    }
                    $cplist[]=$newcp;
                }
                $list['cps']=$cplist;
                $list['name']=$tmp['name'];
            }else{
                $err=1;
                $list = array();
            }
        }
        $res['err']=$err;
        $res['info']=$list;
        echo json_encode($res);
    }

   public function actionSearchFilter(){
	    $err=0;
        if(empty($_REQUEST['data'])){
            $err=1;
            $res['err']=$err;
            echo json_encode($res);
            return;
        }

        $data=$_REQUEST['data'];
        $json = json_decode($data,true);
        $pro = $json['pro'];
        $city = $json['city'];
        $usergroup = $json['usergroup'];
        $cp = $json['cp'];
        $epgcode = $json['epgcode'];
        $cacheId = 'SearchFilter'.'?pro='.$pro.'&city='.$city.'&usergroup='.$usergroup.'&epgcode='.$epgcode.'&cp='.$cp;
        $value=Yii::app()->cache->get($cacheId);
        if($value===false) {
           $name = VerGuideManager::getData($pro,$city,$cp,$usergroup,$epgcode);
           if(!empty($name)){
	       $name_res = VerStation::model()->findByPk($name['station_id']);
               $gid = VerGuideManager::getStationList($name_res->attributes['name']);
               $gidlist = VerGuideManager::String($gid);
               $vid = $json['vid'];
               $vid = implode(',',$vid);
               $sql = "select v.templateType,p.url,s.vid from yd_ver_site s inner join yd_video v on v.vid=s.vid inner join yd_video_pic p on s.vid=p.vid and p.type=1 where s.gid in ($gidlist) and s.vid in ($vid) group by s.vid";
               $tmp = SQLManager::queryAll($sql);
           }
           if(!empty($tmp)){
              $res['list']=$tmp;
           }else{
              $res['list']=array();
           }
           $value = $res;
           Yii::app()->cache->set($cacheId, $value, CACHETIME);
           echo json_encode($value);
        }else{
            echo json_encode($value);
        }

    }    

    public function actionLoginLog(){
        include('BILogConfig.php');
        $str = $_REQUEST['land'];
        //$fileName=date("Ymd", time()); //文件名字
        $time=date('YmdHi',time());
        $fileName = substr($time,0,-1);
        $fileName = $fileName.'0';
        $fileName=Yii::app()->basePath.'/../data/login/80000000-10002-'.SERVER_LOCAL.'-'.SERVER_ID.'-'.$fileName.'.dat';

        //判断文件是否存在 如果不存在就创建
        if(!file_exists($fileName)) {
            $file = fopen("$fileName",'a+');
            fwrite($file,"$str"."\r\n");
            fclose($file);
        }else{
            $file = fopen("$fileName",'a+');
            fwrite($file,"$str"."\r\n");
            fclose($file);
        }
    }

    public function actionBrowseLog(){
        include('BILogConfig.php');
        $str = $_REQUEST['land'];
        //$fileName=date("Ymd", time()); //文件名字
        $time=date('YmdHi',time());
        $fileName = substr($time,0,-1);
        $fileName = $fileName.'0';
        $fileName=Yii::app()->basePath.'/../data/browse/80000000-10001-'.SERVER_LOCAL.'-'.SERVER_ID.'-'.$fileName.'.dat';

        //判断文件是否存在 如果不存在就创建
        if(!file_exists($fileName)) {
            $file = fopen("$fileName",'a+');
            fwrite($file,"$str"."\r\n");
            fclose($file);
        }else{
            $file = fopen("$fileName",'a+');
            fwrite($file,"$str"."\r\n");
            fclose($file);
        }
    }

    public function actionGetIP()
   {
        $arr_ip_header = array(
            "HTTP_CDN_SRC_IP",
            "HTTP_PROXY_CLIENT_IP",
            "HTTP_WL_PROXY_CLIENT_IP",
            "HTTP_CLIENT_IP",
            "HTTP_X_FORWARDED_FOR",
            "REMOTE_ADDR",
        );

        $client_ip = "";
        foreach ($arr_ip_header as $key) {
            if (!empty($_SERVER[$key]) && strtolower($_SERVER[$key]) != "unknown") {
                $client_ip = $_SERVER[$key];
                break;
            }
        }
        if (false !== strpos($client_ip, ",")) {
            $client_ip = preg_replace("/,.*/", "", $client_ip);
        }
        echo $client_ip;
   }

    public function actionNewSpecial(){
        $err=0;
        if(empty($_REQUEST['cid'])){
            $err=1;
            $res['err']=$err;
            echo json_encode($res);
            return;
        }

        $cacheId = 'NewSpecial'.'?cid='.$_REQUEST['cid'];
        $value=Yii::app()->cache->get($cacheId);
        if($value===false) {
            $sid=$_REQUEST['cid'];
            $sql = "select * from yd_special_topic where sid=$sid order by `order` asc";
            $data = SQLManager::queryAll($sql);

            $bkimg = VerBkimg::model()->find("gid = $sid");
            $bgimg=$bkimg->url;
            foreach($data as $v){
                $info[]=array("id"=>$v['id'],"cid"=>$v['cid'],"is_circular"=>1,"action"=>$v['action'],"param"=>$v['param'],"main_title"=>$v['title'],"type"=>$v['type'],"tType"=>$v['tType'],"uType"=>$v['uType'],"width"=>$v['width'],"height"=>$v['height'],"x"=>$v['x'],"y"=>$v['y'],"pic"=>$v['picSrc'],"order"=>$v['order'],"videoUrl"=>$v['videoUrl'],"cp"=>0);
            }
            foreach ($info as $k => $v) {
                $order = $v['order'];
                $v['width']  = $v['width'];
                $v['height'] = $v['height'];
                $v['x'] = $v['x'];
                $v['y'] = $v['y'];
                if($v['width']<20){
                    $v['width'] = $v['width']*250;
                }
                if($v['height']<20){
                    $v['height'] = $v['height']*105;
                }
                if (empty($arr[$order])) {
                    $arr[$order]['banner'][] = $v;
                } else {
                    $tmp = $arr[$order]['banner'];
                    $tmp[] = $v;
                    $arr[$order]['banner'] = $tmp;
                }
                if($v['cid'] == ' '){
                    $v['cid'] = '0';
                }
            }
            foreach ($arr as $k=>$v){
                $newArr[] = $v;
            }
            $res['err'] = 0;
            $res['bgimg'] = $bgimg;
            $res['list'] = $newArr;
            $res['updateTime'] = 0;
            $value = $res;
            Yii::app()->cache->set($cacheId, $value, CACHETIME);
            echo json_encode($value);
        }else{
            echo json_encode($value);
        }

    }

    //强制壁纸
    public function actionGetForceWallPaper()
    {
        $err = 0;
        $list = array();
        if (!isset($_REQUEST['pro']) || !isset($_REQUEST['city'])){
            $err = 1;
            $res['err']=$err;
            echo json_encode($res);
            return;
        }

        $usergroup = isset($_REQUEST['usergroup'])?$_REQUEST['usergroup']:'';
        $epgcode = isset($_REQUEST['epgcode'])?$_REQUEST['epgcode']:'';
        $cp = !empty($_REQUEST['cp'])?$_REQUEST['cp']:'';
        $cacheId = 'GetForceWallPaper'.'?pro='.$_REQUEST['pro'].'&city='.$_REQUEST['city'].'&usergroup='.$usergroup.'&epgcode='.$epgcode.'&cp='.$cp;
        $value=Yii::app()->cache->get($cacheId);
        if($value===false) {
            $pro  = $_REQUEST['pro'];
            $city = $_REQUEST['city'];
            $tmp = VerWallManager::getForceData($pro,$city,$cp,$usergroup,$epgcode);
            //var_dump($tmp);die;
            $res['err'] = $err;
            if(!empty($tmp)){
		$res['status']=1;
		//$res['show']=0;
		for($m=0;$m<count($tmp);$m++){
			if($tmp[$m]['endTime']<strtotime(date("Ymd",time()))||$tmp[$m]['startTime']>(strtotime(date("Ymd",time()))+86399)){
			$res['show']=0;	
			}else{
			$res['show']=$tmp[$m]['id'];break;
			}
		}
                for($i=0;$i<count($tmp);$i++){
                    $res['wall'][$i]=array("id"=>$tmp[$i]['id'],"title"=>$tmp[$i]['title'],"pic"=>$tmp[$i]['pic'],"thum"=>$tmp[$i]['thum'],"expiry_time"=>$tmp[$i]['startTime']."/".$tmp[$i]['endTime'],"pic_update_time"=>$tmp[$i]['pic_time'],"updatetime"=>$tmp[$i]['addTime']);
                }
            }else{
                $res['status'] = 1;
		$list = VerGuideManager::getData($pro,$city,$cp,$usergroup,$epgcode);
		$sql="select * from yd_ver_wall where gid={$list['station_id']} and flag=6 and type=1 and province like '%$pro%' and city=0";
		$result=SQLManager::queryAll($sql);
		if(!empty($result)){
		for($j=0;$j<count($result);$j++){
			if($result[$j]['endTime']<strtotime(date("Ymd",time()))||$result[$j]['startTime']>(strtotime(date("Ymd",time()))+86399)){
				$res['show']=0;
			}else{
				$res['show']=$result[$j]['id'];break;
			}
		}
		for($k=0;$k<count($result);$k++){
                    $res['wall'][$k]=array("id"=>$result[$k]['id'],"title"=>$result[$k]['title'],"pic"=>$result[$k]['pic'],"thum"=>$result[$k]['thum'],"expiry_time"=>$result[$k]['startTime']."/".$result[$k]['endTime'],"pic_update_time"=>$result[$k]['pic_time'],"updatetime"=>$result[$k]['addTime']);
                }}else{
			$res['err']=0;
			$res['status']=0;
		}
            }

            $value = $res;
            Yii::app()->cache->set($cacheId, $value, CACHETIME);
            echo json_encode($value);
        }else{
            echo json_encode($value);
        }

    }

   public function actionGetNewEpgContent()
    {
        /*
         * apk定点是否需要偏移
         * */
        $x=110;
        $y=70;

        $err = 0;
        if(!empty($_REQUEST['gid'])){
            $gid = $_REQUEST['gid'];
        }else{
            $err = '1';
            $list['err'] = $err;
            echo json_encode($list);
            return;
        }

        $cacheId = 'GetNewEpgContent'.'?gid='.$_REQUEST['gid'];
        $value=Yii::app()->cache->get($cacheId);
        if($value===false) {
            $sql = "select upTime from yd_ver_screen_content where `screenGuideId`=$gid group by upTime order by upTime desc";
            $res = SQLManager::queryAll($sql);
            $data=array();
            if(empty($res)){
                return null;
            }else{
                $data['updateTime']= $res[0]['upTime'];
            }
            $data['err'] = '0';
            $info = array();
            $sql_select="select g.templateId,c.type,c.tType, g.gid,s.circular as is_circular,c.id ,c.cp,c.cid,c.action,c.param,c.title as main_title,c.uType,c.width,c.height,c.x,c.y,c.pic,c.order,c.videoUrl from yd_ver_screen_content c ,yd_ver_screen_guide g,yd_ver_station s";
            $sql_where = " where `screenGuideId`=$gid and `delFlag`=0 and c.screenGuideid=g.id and g.gid=s.id order by `order`";
            $sql = $sql_select.$sql_where;
            $info = SQLManager::queryAll($sql);
            if(empty($info)){
                return null;
            }
            foreach ($info as $k => $v) {
                if($v['templateId']<11){
		    if($v['width']>1){
                        $spacing = $v['width']-1;
                        $v['width'] = (250*$v['width'])+($spacing*20);
                    }else{
                        $v['width'] = 250*$v['width'];
                    }
                    if($v['height']>1){
                        $spacing_h = $v['height']-1;
                        $v['height'] = (105*$v['height'])+($spacing_h*20);
                    }else{
                        $v['height'] = 105*$v['height'];
                    }
                }
                if($v['templateId']<=11){
                    $v['x'] += $x;
                    $v['y'] += $y;
                }

                if ($v['is_circular'] == '2') {//无圆角
                    $v['is_circular'] = 1;
                } else {
                    $v['is_circular'] = 0;//圆角
                }
                $order = $v['order'];
                if (empty($arr[$order])) {
                    $arr[$order]['banner'][] = $v;
                } else {
                    $tmp = $arr[$order]['banner'];
                    $tmp[] = $v;
                    $arr[$order]['banner'] = $tmp;

                }
                if ($v['cid'] == ' ') {
                    $v['cid'] = '0';
                }
            }
            foreach ($arr as $k=>$v){
                $newArr[] = $v;
            }
            $data['list']=$newArr;

            $value = $data;
            Yii::app()->cache->set($cacheId, $value, CACHETIME);
            echo json_encode($value);
        }else{
            echo json_encode($value);
        }
    }

    public function actionGetAddress(){
        $err = 0;
        if (!isset($_REQUEST['pro']) || !isset($_REQUEST['city'])){
            $err = 1;
            $res['err']=$err;
            echo json_encode($res);
            return;
        }
        $usergroup = isset($_REQUEST['usergroup'])?$_REQUEST['usergroup']:'';
        $epgcode = isset($_REQUEST['epgcode'])?$_REQUEST['epgcode']:'';
        $cp = !empty($_REQUEST['cp'])?$_REQUEST['cp']:'';
        $cacheId = 'getaddress.html'.'?pro='.$_REQUEST['pro'].'&city='.$_REQUEST['city'].'&usergroup='.$usergroup.'&epgcode='.$epgcode.'&cp='.$cp;
        $value=Yii::app()->cache->get($cacheId);
        if($value===false) {
            $pro  = $_REQUEST['pro'];
            $city = $_REQUEST['city'];
	    $res['error']=$err;
            $list = VerGuideManager::getData($pro,$city,$cp,$usergroup,$epgcode);//获取站点信息
            if(!empty($list)){
                $gid=$list['station_id'];
            }else{
                $gid = 1;
            }
            $sql_select = "select * from yd_ver_address";
            $sql_where = " where stationId=$gid and province like '%$pro%' and city like '%$city%'";
            $sql = $sql_select . $sql_where;
            $tmp = SQLManager::queryRow($sql);
            if(!empty($tmp)){
                $res['web_ip']=$tmp['web_ip'];
                $res['img_ip']=$tmp['img_ip'];
            }else{
                $res['web_ip']=0;
                $res['img_ip']=0;
            }
            $value = $res;
            Yii::app()->cache->set($cacheId, $value, CACHETIME);
	    echo json_encode($value);
        }else{
            echo json_encode($value);
        }
    }

}

