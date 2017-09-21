<?php
    class BaishiController extends AController{
        public function actionDefault(){
            $idd = $_GET['mid'];
            $name = Yii::app()->session['username'];
            $pwd  = Yii::app()->session['password'];
            $auth = Admin::model()->find("username = '$name' and password = '$pwd'");
            $id = $auth['auth'];
            $group = Group::model()->find("id = '$id'");
            $quanxian = $group['auth'];
            $arr = explode(',',$group['auth']);
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
           // print_r($you);die();
            $nid = $you[0];
            //$nid = 49;
            $aa = array_map(create_function('$record','return $record->attributes;'),Guide::model()->findAll("id = '$nid' "));
            $this->redirect($this->createUrl($aa[0]['url'],array('mid'=>$idd,'nid'=>$nid)));
            //$this->render('default');
        }


    public function actionIndex(){
        $id=$_GET['nid'];
        $cp = 2;
        $type = isset($_GET['type']) ? $_GET['type'] : '';
        if(!empty($id) && empty($type)){
            if($id==478){
                $type='tuijian';
            }
            if($id==479){
                $type='jishi';
            }
            if($id==480){
                $type='yinshi';
            }
            if($id==481){
                $type='shaoer';
            }
            if($id==482){
                $type='yingyong';
            }
            $provinceCode = isset($_GET['provinceCode']) ? $_GET['provinceCode'] : '0';
            $cityCode = isset($_GET['cityCode']) ? $_GET['cityCode'] : '0';
            $setting = UiBaishiManager::getInfo($type,$cp,$provinceCode,$cityCode);
            $display = UiType::model()->findAll();
            $html = '';
            if(!empty($type)){
                $html = $this->getHtml($setting,trim($type));
            }
            $province = Province::model()->findAll("1=1 order by id asc");
            $this->render('index',array('ui'=>$setting,'type'=>$display,'html'=>$html,'province'=>$province,'ids'=>$type,'provinceCode'=>$provinceCode,'cityCode'=>$cityCode));
        }else{
            $cp = 2;
            $type = isset($_GET['type']) ? $_GET['type'] : '';
            $provinceCode = isset($_GET['provinceCode']) ? $_GET['provinceCode'] :'0';
            $cityCode = isset($_GET['cityCode']) ? $_GET['cityCode'] : '0';
            $setting = UiBaishiManager::getInfo($type,$cp,$provinceCode,$cityCode);
            if(empty($setting)){
                //查询省的 如果省的为空 就查询默认的
                $setting = UiBaishiManager::getInfo($type,$cp,$provinceCode);
		if(empty($setting)){
                    $setting = UiBaishiManager::getInfo($type,$cp);
                    header("Content-type:text/html;charset=utf-8");
                    foreach($setting as $key=>$val){
                        if(count($val)>1){
                            foreach($val as $k=>$v){
                                //var_dump($v);
                                if($v['provinceCode'] == 0 && $v['cityCode'] ==0){
                                    $ui = new Ui();
                                    $ui->title    = $v['title'];
                                    $ui->position = $v['position'];
                                    $ui->url      = $v['url'];
                                    $ui->bigImg   = $v['bigImg'];
                                    $ui->type     = $v['type'];
                                    $ui->addTime  = time();
                                    $ui->provinceCode = $provinceCode;
                                    $ui->cityCode = $cityCode;
                                    $ui->delFlag  = $v['delFlag'];
                                    $ui->epg      = $v['epg'];
                                    $ui->tType    = $v['tType'];
                                    $ui->cp       = $v['cp'];
                                    $ui->save();
                                }elseif($v['provinceCode'] == $provinceCode && $v['cityCode'] == 0){
                                    //var_dump($v);die;
                                    $ui = new Ui();
                                    $ui->title    = $v['title'];
                                    $ui->position = $v['position'];
                                    $ui->url      = $v['url'];
                                    $ui->bigImg   = $v['bigImg'];
                                    $ui->type     = $v['type'];
                                    $ui->addTime  = time();
                                    $ui->provinceCode = $provinceCode;
                                    $ui->cityCode = $cityCode;
                                    $ui->delFlag  = $v['delFlag'];
                                    $ui->epg      = $v['epg'];
                                    $ui->tType    = $v['tType'];
                                    $ui->cp       = $v['cp'];
                                    $ui->save();  
                                }  
                            }
                        }else{
                            $ui = new Ui();
                            $ui->title    = $val[0]['title'];
                            $ui->position = $val[0]['position'];
                            $ui->url      = $val[0]['url'];
                            $ui->bigImg   = $val[0]['bigImg'];
                            $ui->type     = $val[0]['type'];
                            $ui->addTime  = time();
                            $ui->provinceCode = $provinceCode;
                            $ui->cityCode = $cityCode;
                            $ui->delFlag  = $val[0]['delFlag'];
                            $ui->epg      = $val[0]['epg'];
                            $ui->tType    = $val[0]['tType'];
                            $ui->cp       = $val[0]['cp'];
                            $ui->save();
                        }
                    }
		}else{
                    $setting = UiBaishiManager::getInfo($type,$cp);
                    foreach ($setting as $key => $val) {
                        //var_dump($val);die;
                        foreach ($val as $v) {
                            if($v['provinceCode'] == 0){
                                $ui = new Ui();
                                $ui->title    = $v['title'];
                                $ui->position = $v['position'];
                                $ui->url      = $v['url'];
                                $ui->bigImg   = $v['bigImg'];
                                $ui->type     = $v['type'];
                                $ui->addTime  = time();
                                $ui->provinceCode = $provinceCode;
                                $ui->cityCode = $cityCode;
                                $ui->delFlag  = $v['delFlag'];
                                $ui->epg      = $v['epg'];
                                $ui->tType    = $v['tType'];
                                $ui->cp       = $v['cp'];
                                $ui->save();
                            }
                        }
                    }
                }
            }
            //$display = UiType::model()->findAll("provinceCode = '$provinceCode' and cityCode = '$cityCode'");
            //$display = Ui::model()->findAll("provinceCode = '$provinceCode' and cityCode = '$cityCode'");
            $display = UiType::model()->findAll();
            $html = '';
            if(!empty($type)){
		$html = $this->getHtml($setting,trim($type));
            }
            if(!empty($provinceCode)){
		//就去查询市 把所有的市显示出来
                $city = City::model()->findAll("provinceId = '$provinceCode'");
            }
            $province = Province::model()->findAll("1=1 order by id asc");
            $citys = isset($city) ? $city : '';
                //print_r($citys);
            $this->render('index',array('ui'=>$setting,'type'=>$display,'html'=>$html,'province'=>$province,'ids'=>$type,'provinceCode'=>$provinceCode,'cityCode'=>$cityCode,'city'=>$citys));
        }
    }
    
    public function actionUpload(){
        $cp = 2;
	if(empty($_GET['val']) || empty($_GET['type'])){
            $this->die_json(array('code'=>404,'msg'=>'请选择要设置的位置'));
	}
	$provinceCode = !empty($_GET['provinceCode']) ? $_GET['provinceCode'] :0;
		
        $cityCode = !empty($_GET['cityCode']) ? $_GET['cityCode'] :0;

	$setting = UiBaishiManager::getInfo($_GET['type'],$cp,$provinceCode,$cityCode);
        //var_dump($setting);die;
	$html = $this->getHtml($setting,$_GET['type']);	
        $t = trim($_GET['val']);
        
        $type = $_GET['type'];//这是获取的类型
        if(empty($setting[$t])){
        	$tType = 1;
        	$position = $t;
        	$id = '';
        }else{
        	$tType = $setting[$t][0]['tType'];
            $position = $setting[$t][0]['position'];//这是获取的位置
            $id = $setting[$t][0]['id'];
        }
        
        $size = array_map(create_function('$record','return $record->attributes;'),Imgsize::model()->findAll("type = '$type' AND position = '$position'"));

        $w = $size[0]['width'];
        $h = $size[0]['height'];
        $fid = isset($_GET['fid'])?$_GET['fid']:'';
        //echo $fid;die;
	$n = $this->renderPartial(
            'upload',
            array(
		        'cp'=>$cp,
                'w'=>$w,
                'h'=>$h,
                'tType'=>$tType,
		        'address'=>trim($_GET['val']),
                'fid'=>$fid,
		        'type'=>$_GET['type'],
		        'ui'=>$setting,
		        'html'=>$html,
                'id' =>$id,
		        'provinceCode'=>$provinceCode,
		        'cityCode'=>$cityCode
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
	if(empty($_POST['url'])) $this->die_json(array('code'=>404,'msg'=>'链接地址不能为空'));
	if(empty($_POST['key'])) $this->die_json(array('code'=>404,'msg'=>'图片地址不能为空'));
	if(empty($_POST['position'])) $this->die_json(array('code'=>404,'msg'=>'系统错误'));
	$ui = Ui::model()->findByAttributes(array('position'=>$_POST['position'],'type'=>$_POST['type'],'id'=>$_POST['id']));
	if(!$ui){
            $ui = new Ui();
            $ui->addTime = time();
	}else{
            $ui->upTime = time();
	}
        $img = substr($_POST['key'],-36);
        //Common::synchroPic($img);
        //echo 'http://'.$_SERVER['HTTP_HOST'].'/file/'.trim($img);die;\
        //var_dump($_POST['cp']);die;
        $ui->cp = trim($_POST['cp']);
	$ui->provinceCode= trim($_POST['provinceCode']);
	$ui->cityCode=	 trim($_POST['cityCode']);
	$ui->title    = trim($_POST['title']);
	$ui->url      = trim($_POST['url']);
        $ui->bigImg   = 'http://' . $_SERVER['HTTP_HOST'] . '/file/' . trim(substr($_POST['key'],-36));
        $ui->position = trim($_POST['position']);
	$ui->type     = trim($_POST['type']);
        $ui->tType    = trim($_POST['tType']);
        $ty = trim($_POST['type']);
        $po = trim($_POST['position']);
        $epg=array_map(create_function('$record','return $record->attributes;'),UiType::model()->findAll("altem = '$ty' "));
        $ui->epg      = $epg[0]['id'];

        $aa=getimagesize(Yii::app()->basePath.'/../file/'.trim($img));
        $width=$aa[0];////获取图片的宽
        $height=$aa[1];///获取图片的高
        $size = array_map(create_function('$record','return $record->attributes;'),Imgsize::model()->findAll("type = '$ty' AND position = '$po'"));
        $w = $size[0]['width'];
        $wid = substr($w,0,strlen($w)-2);
        $h = $size[0]['height'];
        $hei = substr($h,0,strlen($h)-2);
        if($wid == $width && $hei == $height){
            if(!$ui->save()){
                LogWriter::logModelSaveError($ui,__METHOD__,$ui->attributes);
                $this->die_json(array('code'=>404,'msg'=>'信息保存失败'));
            }
        }else{
            $this->die_json(array('code'=>404,'msg'=>"请上传宽度为'$w',高度为'$h'的图片！"));
        }

        //日志记录

        //牌照方
        $sp             = '699212';

        //内容id
        $c  =trim($_POST['url']);
        $a  =explode('contentId=',$c);
        if(!empty($a[1])){
            $contentid  = $a[1];
        }else{
            $contentid  = '';
        }

        //标题
        $contentname    = trim($_POST['title']);

        //栏目id(省编码+211【211为华数】)
        if(trim($_POST['provinceCode'])==0){
            $folderid   = '00212';
        }else{
            $folderid   = trim($_POST['provinceCode']).'212';
        }

        //栏目名称(省名称+门户)
        if(!empty($_POST['provinceCode'])){
            $fold = Province::model()->findByPk(trim($_POST['provinceCode']));
            $pname = $fold['provinceName'];

            $p =preg_replace('/(省|市|自治区)/','',$pname);
            //判断$pname中是否有省、市、自治区
//            if(strstr($pname,'省')){
//                $p = mb_substr($pname,0,-1,'utf-8');
//                $foldername     =$p.'门户';
//            }elseif(strstr($pname,'市')){
//                $p = mb_substr($pname,0,-1,'utf-8');
//                $foldername     =$p.'门户';
//            }elseif(strstr($pname,'自治区')){
//                $p = mb_substr($pname,0,-3,'utf-8');
//                $foldername     =$p.'门户';
//            }else{
//                $foldername = '';
//            }
            $foldername     =$p.'百视通门户';
        }else{
            $foldername = '全国百视通门户';
        }

        //上级栏目id
        $parentfolderid = '';

        //内容在栏目中的排列序号
        $sequence       = $size[0]['sequence'];

        //内容在栏目中的位置(1 ：推荐2：电视3：影视4：教育5：应用)
        if($size[0]['type'] == 'yinshi'){
            $position   = '3';
        }elseif($size[0]['type'] == 'jishi'){
            $position   = '6';
        }elseif($size[0]['type'] == 'tuijian'){
            $position   = '1';
        }elseif($size[0]['type'] == 'shaoer'){
            $position   = '4';
        }elseif($size[0]['type'] == 'yingyong'){
            $position   = '5';
        }

        $str = $sp.'|'.$contentid.'|'.$contentname.'|'.$folderid.'|'.$foldername.'|'.$parentfolderid.'|'.$sequence.'|'.$position;

        //echo $str;

        $fileName=date("Ymd", time()); //文件名字
        //$fileName='./data/sp/'.$fileName.'_OTT-21104.txt';
        $fileName=Yii::app()->basePath.'/../data/sp/i_'.$fileName.'_OTT-21104.txt';

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

        $this->die_json(array('code'=>200));
    }


        private function getHtml($setting,$type){
		switch($type){
			case 'yinshi':
				$html = HTMLS::yingshi($setting);
				break;
			case 'jishi':
				$html = HTMLS::jishi($setting);
				break;
			case 'tuijian':
				$html = HTMLS::tuijian($setting);
				break;
			case 'shaoer':
				$html = HTMLS::shaoer($setting);
				break;
            case 'yingyong':
                $html = HTMLS::yingyong($setting);
                break;
			default:
				$html = '';
				break;
		}
		return $html;
	}

    public function actionPhoto(){
        if(empty($_GET['val']) || empty($_GET['type'])){
            $this->die_json(array('code'=>404,'msg'=>'请选择要设置的位置'));
        }
        $cp = 2;

        $provinceCode = !empty($_GET['provinceCode']) ? $_GET['provinceCode'] :0;
        $cityCode = !empty($_GET['cityCode']) ? $_GET['cityCode'] :0;
        $setting = UiBaishiManager::getInfo($_GET['type'],$cp,$provinceCode,$cityCode);
        //echo $provinceCode;
        //var_dump($setting);die;
        $t = trim($_GET['val']);
        $setting = $setting[$t];

        foreach($setting as $val){
            if($val['provinceCode'] == $provinceCode){
                $ui[] = $val;
            }   
        }

        $tType = $ui[0]['tType'];
        $type = $_GET['type'];//这是获取的类型
        $position = $ui[0]['position'];//这是获取的位置
        $size = array_map(create_function('$record','return $record->attributes;'),Imgsize::model()->findAll("type = '$type' AND position = '$position'"));

        $w = $size[0]['width'];
        $h = $size[0]['height'];
        //$ui = $ui["$t"];

        $n = $this->renderPartial(
            'photo',
            array(
            	'cp'=>$cp,
                'w'=>$w,
                'h'=>$h,
                'tType'=>$tType,
                'address'=>trim($_GET['val']),
                'type'=>$_GET['type'],
                'ui'=>$ui,
		'provinceCode'=>$provinceCode,
		'cityCode'=>$cityCode
            ),
            true
        );
        die(json_encode(array('code'=>200,'msg'=>$n)));
    }

	     //读取出符合条件的所有的市
        public function actionGetcity(){
            $id=$_GET['id'];
            $city = array_map(create_function('$record','return $record->attributes;'),City::model()->findAll("provinceId = $id order by cityCode asc"));
            echo json_encode($city);
        }
        
        
        public function actionGonggao(){
            $page = 20;
            $data = $this->getPageInfo($page);
            //var_dump($data);die;
            $baishi = BaishiManager::getBaishiList($data);
            $url = $this->createUrl($this->action->id);
            $pagination = $this->renderPagination($url,$baishi['count'],$page,$data['currentPage']);
            $this->render('gonggao',array('list'=>$baishi['list'],'page'=>$pagination));
        }


        public function actionAdds(){
            
        try{
            if(!empty($_GET['bid']) && is_numeric($_GET['bid'])){
                $notice = Notice::model()->findByPk($_GET['bid']);

                $id = isset($_GET['bid']) ? $_GET['bid'] : '';
                $provinceCode = array_map(create_function('$record','return $record->attributes;'),Notice::model()->findAll("id = $id"));

                $p = $provinceCode[0]['province'];//查询出来的省份编码
                $c = $provinceCode[0]['city'];//查询出来的城市编码

                $cityCode = array_map(create_function('$record','return $record->attributes;'),City::model()->findAll("provinceId = $p"));


            }else{
                $notice = new Notice();
            }
            if(!empty($_POST)){
                //var_dump($_POST);die;
                if(empty($_POST['notice']))  throw new ExceptionEx('公告内容不能为空！');
                //if(empty($_POST['province'])) throw new ExceptionEx('请选择省份！');
                if(empty($_POST['sTime'])) throw new ExceptionEx('请选择开始时间');
                if(empty($_POST['eTime'])) throw new ExceptionEx('请选择结束时间');
                if(strtotime($_POST['sTime']) > strtotime($_POST['eTime'])){
                    throw new ExceptionEx('结束时间必须大于、等于开始时间!');
                }

                $notice -> notice   = trim($_POST['notice']);
                
                if(empty($_POST['province'])){
                    $notice -> province = '0';
                }else{
                    $sheng = explode('_',$_POST['province']);
                    $notice -> province = trim($sheng[0]);
                }

                if(empty($_POST['city'])){
                    $notice -> city = '0';
                }else{
                    $shi = explode('_',$_POST['city']);
                    $notice -> city     = trim($shi[0]);
                }

                $notice -> sTime    = strtotime($_POST['sTime']);
                $notice -> eTime    = strtotime($_POST['eTime']);
                $notice -> cp = '2';
                $notice -> delFlag = '0';
                $notice -> cTime    = time();


                if(!$notice->save()){
                    LogWriter::logModelSaveError($notice,__METHOD__,$notice->attributes);
                    throw new ExceptionEx('保存失败!');
                }
                if(!empty($_GET['id'])){
                    $this->RecordOperatingLog(MSG::MYSQL_EDIT_EDIT,$notice,'公告',$notice->notice);
                }else{
                    $this->RecordOperatingLog(MSG::MYSQL_EDIT_ADD,$notice,'公告',$notice->notice);
                }

                $this->redirect($this->get_url('baishi','gonggao'));
            }
        }catch (ExceptionEx $ex){
            $this->PopMsg($ex->getMessage());
        }catch (Exception $e){
            $this->log($e->getMessage());
        }
        $province = Province::model()->findAll("1=1 order by id asc");

        $p = isset($p) ? $p : '';
        $cityCode = isset($cityCode) ? $cityCode : '';
        $c = isset($c) ? $c : '';
        
        $this->render('adds',array('notice'=>$notice,'province'=>$province,'provinceCode'=>$p,'city'=>$cityCode,'cityCode'=>$c));
        }
        public function actionDel(){
        if(empty($_POST['id']) || !is_numeric($_POST['id'])){
            $this->die_json(array('code'=>404,'msg'=>'参数不能为空'));
        }
        $notice = Notice::model()->deleteByPk($_POST['id']);
        if(!$notice){
            $this->die_json(array('code'=>404,'msg'=>'删除失败'));
        }
        $this->RecordOperatingLog(MSG::MYSQL_EDIT_DEL,$notice,'公告',count($notice) > 1?'':$notice[0]['notice']);
        $this->die_json(array('code'=>200,'msg'=>'删除成功'));
    }

    }
?>