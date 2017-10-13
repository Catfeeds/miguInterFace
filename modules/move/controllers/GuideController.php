<?php

/**
 * Created by PhpStorm.
 * User: 
 * Date: 2015/8/19 0019
 * Time: 11:48
 */
class GuideController extends MController{
	public function actionDefault(){
//        $idd = $_GET['mid'];
//        //echo $idd;
//        //查询出这个用户的session，
//
//        $name = Yii::app()->session['username'];
//        $pwd  = Yii::app()->session['password'];
//        //通过session查询出这个用户的权限
//        $auth = MvAdmin::model()->find("username = '$name' and password = '$pwd'");
//        $id = $auth['auth'];
//        $group = MvGroup::model()->find("id = '$id'");
//        // echo $group['auth'];//这个用户的权限
//        $quanxian = $group['auth'];
//
//
//        $arr = explode(',',$group['auth']);
//        $url = array_map(create_function('$record','return $record->attributes;'),MvGuide::model()->findAll(array(
//            'select' => array('id'),
//            'order'  => 'id DESC',
//            'condition' => 'pid='.$idd,
//        )));
//        $bb = array_column($url,'id');
//
//        //通过查出来的这个用户的权限判断查询出来的这个顶级栏目下的子栏目哪些是有权限的
//
//        $you = array();
//        for($i=0;$i<count($bb);$i++){
//            if(in_array($bb[$i],$arr)){
//                $you[]=$bb[$i];
//            }
//        }
//        $nid = $you[0];
//        $aa = array_map(create_function('$record','return $record->attributes;'),MvGuide::model()->findAll("id = '$nid' "));
//         echo $aa[0]['url'];
//
//        $this->redirect($this->createUrl($aa[0]['url'],array('mid'=>$idd,'nid'=>$nid)));
		$this->render('default');
	}

	public function actionIndex(){
		$parent = 0;
		if(!empty($_GET['id'])) $parent = intval($_GET['id']);
		$p = MvGuide::model()->findByPk($parent);
		$list = MvGuideManager::getforparent($parent);
		$this->render('index',array('guide'=>$list,'p'=>$p));
	}
       
        /*public function actionReport(){
        $page = 10;
        $data = $this->getPageInfo($page);
        $total = MvGuideManager::getTotal();
        $tmp = MvGuideManager::getVname($data);
        $num=$tmp['total'];
        $list = $tmp['list'];
        $url = $this->createUrl($this->action->id);
        $pagination = $this->renderPagination($url,$tmp['count'],$page,$data['currentPage']);
        $this->render('report',array('total'=>$total,'list'=>$list,'num'=>$num,'page'=>$pagination));
        }*/
        public function actionReport(){
        $page = 10;
        $data = $this->getPageInfo($page);
        $total = MvGuideManager::getTotal();
        //$tmp = MvGuideManager::getVname($data);
        //$tmp = MvGuideManager::getProvince($data);
        //var_dump($tmp);die;
        //$province = ProvinceManager::getList();
        //$num=$tmp['total'];
        //var_dump($list);die;
        if(empty($list)){
            $usergroup = MvGuideManager::Usergroup();
            $epgcode = MvGuideManager::Epgcode();
            $list = array_merge($usergroup,$epgcode);
        }
        //var_dump($list);

        //$url = $this->createUrl($this->action->id);
        //$pagination = $this->renderPagination($url,$tmp['count'],$page,$data['currentPage']);
        //$this->render('report',array('total'=>$total,'list'=>$list,'num'=>$num,'page'=>$pagination));
            $this->render('report',array('total'=>$total,'list'=>$list));
    }

    public function actionReports(){
        $page = 10;
        $pro=$_REQUEST['pro'];
        $data = $this->getPageInfo($page);

        //$total = MvGuideManager::getPro($pro);
        if(is_numeric($pro)){
            $total = MvGuideManager::getPro($pro);
            $tmp = MvGuideManager::getVname($data);
        }else{
            $total = MvGuideManager::getCun($pro);
            $tmp = MvGuideManager::getCuns($data,$pro);
        }
        //$tmp = MvGuideManager::getVname($data,$pro);
        $list = $tmp['list'];
        $num=$tmp['total'];
        $url = $this->createUrl($this->action->id);
        $pagination = $this->renderPagination($url,$tmp['count'],$page,$data['currentPage']);
        $this->render('reports',array('total'=>$total,'list'=>$list,'num'=>$num,'page'=>$pagination));
    }	
       
        public function actionStbid(){
            $province = $_REQUEST['province'];
            $version = $_REQUEST['version'];
            $page = 10;
            $data = $this->getPageInfo($page);
            if(is_numeric($province)){
                $stbid = MvGuideManager::getStbid($data,$province,$version);
            }else{
                $stbid = MvGuideManager::getCunstbid($data,$province,$version);
            }

            //$stbid = MvGuideManager::getStbid($data,$province,$version);
            $url = $this->createUrl($this->action->id);
            $pagination = $this->renderPagination($url,$stbid['count'],$page,$data['currentPage']);
            $this->render('stbid',array('stbid'=>$stbid['list'],'page'=>$pagination));
        }
	public function actionAdd(){
        try{
                $guide = new MvGuide();
                $guide->addTime = time();

            if(!empty($_POST)){
                $post = $_POST;
                if(empty($post['name'])) throw new ExceptionEx('请输入导航名称');
                if(empty($post['uType']))throw new ExceptionEx('请选择链接类型');
                if(empty($post['url'])) throw new ExceptionEx('请输入链接');
                if(!empty($_GET['id']) && $_GET['id'] == $post['pid']){
                    throw new ExceptionEx('自己不能作为自己的父类');
                }

                $sql = 'select `order` from yd_mv_guide order by `order` desc limit 1';
                $return = Yii::app()->db->createCommand($sql)->queryRow();

                $vip = isset($post['vip'])? $post['vip']:'0';
                $guide -> vip = $vip;


                $guide->pid = intval($post['pid']);
                $guide->name = trim($post['name']);
                $guide->uType = intval($post['uType']);
                $guide->url = trim($post['url']);
                $guide->module = $this->module->id;

               if(!empty($_FILES['ico_true']['tmp_name'])){
                    $filename = 'ico_true';
                    $path = $this->up($filename);
                    //Common::synchroPic($path);
                    //Common::fspost($path);
                    $guide->ico_true = 'http://portalpic.itv.cmvideo.cn:8088/file/'.$path;
                }

                if(!empty($_FILES['ico_false']['tmp_name'])){
                    $filenames = 'ico_false';
                    $path = $this->up($filenames);
                    //Common::synchroPic($path);
                    //Common::fspost($path);
                    $guide->ico_false = 'http://portalpic.itv.cmvideo.cn:8088/file/'.$path;
                }

                if($guide->isNewRecord){
                    if($_REQUEST['name']=='工具栏'){
                        $guide->order='0';
                    }else{
                        $guide->order = $return['order']+1;
                    }
                }
                if(!$guide->save()){
                    LogWriter::logModelSaveError($guide,__METHOD__,$guide->attributes);
                    throw new ExceptionEx('信息保存失败');
                }
                //添加到yd_mv_nav
                if(!empty($_POST['province']) && empty($_GET['id'])){
                    $gid = $guide->attributes['id'];
                    $count = count($_POST['province']);
                    // print_r($count);die();


                    $sheng=$_POST['province'];
                    $shi=$_POST['city'];

              /*      for($i=0;$i<count($sheng);$i++){
                        $nav = new MvNav();
                        $nav -> gid = $gid;
                        $se=explode('_',$sheng[$i]);
                        $nav -> province = $se[0];

                        $s=explode('_',$shi[$i]);
                        $nav -> city = $s[0];
                        $nav -> save();
                        if(!$nav->save()){
                            LogWriter::logModelSaveError($nav,__METHOD__,$nav->attributes);
                            throw new ExceptionEx('信息保存失败s');
                        }
                    }*/
		    $cp = $_POST['cp'];
                    for($i=0;$i<count($sheng);$i++){
                        for($c=0;$c<count($cp);$c++){
                            $nav = new MvNav();
                            $nav -> gid = $gid;
                            $se=explode('_',$sheng[$i]);
                            $nav -> province = $se[0];

                            $s=explode('_',$shi[$i]);
                            $nav -> city = $s[0];
                            $nav -> cp =$cp[$c];
                            $nav ->usergroup = $_REQUEST['usergroup'];
                            $nav ->epgcode = $_REQUEST['epgcode'];
                                //echo $cp[$c];
                            $nav -> save();
                            if(!$nav->save()){
                                LogWriter::logModelSaveError($nav,__METHOD__,$nav->attributes);
                                throw new ExceptionEx('信息保存失败s');
                            }
                        }
//                        die();
                    }
                }
                //判断是不是左侧的导航
                $diqus=array(
                    '1'=>'首页',
                    '2'=>'影视',
                    '3'=>'教育',
                    '4'=>'游戏',
                    '5'=>'应用',
                    '6'=>'咪咕专区',
                    '7'=>'综艺专区',
                    '8'=>'华数专区',
                    '9'=>'咪咕极光',
                    '10'=>'咪咕现场秀',
                    '11'=>'咪咕精彩',
                    '12'=>'甘肃专区',
                    '13'=>'音乐',
                    '14'=>'体育',
                    '15'=>'南传专区',
                    '16'=>'购物',
		    '17'=>'推荐',
		    '18'=>'电视剧集',
		    '19'=>'电影',
		    '20'=>'少儿',
		    '21'=>'综艺',
                    '22'=>'田园阳光',
		    '23'=>'百视通区',
                    '24'=>'华推',
                    '25'=>'华电视剧',
                    '26'=>'华影',
                    '27'=>'华少',
                    '28'=>'华综',
                    '29'=>'百推',
                    '30'=>'百电视剧',
                    '31'=>'百影',
                    '32'=>'百少',
                    '33'=>'百综',
                    '34'=>'未推',
                    '35'=>'未电视剧',
                    '36'=>'未影',
                    '37'=>'未少',
                    '38'=>'未综',
                    '39'=>'南推',
                    '40'=>'南电视剧',
                    '41'=>'南影',
                    '42'=>'南少',
                    '43'=>'南综',
                    '44'=>'未来专区',
                    '45'=>'美丽乡村',
                    '46'=>'百直',
                    '47'=>'芒推',
                    '48'=>'国推',
		    '49'=>'华看电视',
		    '50'=>'芒果专区',
		    '51'=>'国广专区',
		    '52'=>'芒少',
		    '53'=>'芒电视剧',
		    '54'=>'芒影',
		    '55'=>'芒综',
		    '56'=>'咪咕游戏'  						    		
                );
                /*$ziname=$post['name'];
                if(in_array("$ziname", $diqus)){
                    $key = array_search("$ziname", $diqus);
                    $auth = MvGuide::model()->find("name = '全国'");
                    $id=$auth->id;
                    $ss = MvGuide::model()->find("pid = '$id' and name='$ziname'");
                    $sname=$ss->name;
                    $sid=$ss->id;
                    $epgid = array_search("$sname", $diqus);
                    $shujuall = array_map(create_function('$record','return $record->attributes;'),MvUi::model()->findAll("gid = '$sid' and epg='$epgid'"));

                    foreach($shujuall as $k=>$v){
                        $ui = new MvUi();
                        $ui->title    = $v['title'];
                        $ui->type = $v['type'];
                        $ui->tType      = $v['tType'];
                        $ui->param   = $v['param'];
                        $ui->action     = $v['action'];
                        $ui->pic  = $v['pic'];
                        $ui->cp = $v['cp'];
                        $ui->epg = $epgid;
                        $ui->addTime  = $v['addTime'];
                        $ui->upTime      = $v['upTime'];
                        $ui->position    = $v['position'];
                        $ui->gid       = $gid;
                        $ui->save();
                    }
                }*/
                $this->PopMsg('保存成功');
                $this->redirect($this->get_url('guide','index'));
            }
        }catch (ExceptionEx $ex){
            $this->PopMsg($ex->getMessage());
        }catch (Exception $e){
            $this->log($e->getMessage());
        }

        $province = Province::model()->findAll("1=1 order by id desc");

        $p = isset($p) ? $p : '';
        $cityCode = isset($cityCode) ? $cityCode : '';
        $c = isset($c) ? $c : '';


        $parent = MvGuide::model()->findAllByAttributes(array('pid'=>0));

        $this->render('add',array('guide'=>$guide,'parent'=>$parent,'province'=>$province,'provinceCode'=>$p,'city'=>$cityCode,'cityCode'=>$c));
    }
    //修改
    public function actionUpdate(){
        try{
            if(!empty($_GET['id'])){
                $guide = MvGuide::model()->findByPk($_GET['id']);

                $id = $_GET['id'];
                $arr = array_map(create_function('$record','return $record->attributes;'),MvNav::model()->findAll("gid = $id group by `province`"));
                $cou = count($arr);
		$ars = array_map(create_function('$record','return $record->attributes;'),MvNav::model()->findAll("gid = $id group by `cp`"));
                $cous = count($ars);
                $arrs = array_map(create_function('$record','return $record->attributes;'),MvNav::model()->findAll("gid = $id group by `usergroup`"));
                $arres = array_map(create_function('$record','return $record->attributes;'),MvNav::model()->findAll("gid = $id group by `epgcode`"));
                $cityar=$arr;
                foreach($cityar as $key=>$val){
                   $cityarr[]= array_map(create_function('$record','return $record->attributes;'),City::model()->findAll("provinceId = $val[province]"));
                }
                $cityarr = isset($cityarr) ? $cityarr : '';
            }
            if(!empty($_POST)){
                $post = $_POST;
                if(empty($post['name'])) throw new ExceptionEx('请输入导航名称');
                if(empty($post['uType']))throw new ExceptionEx('请选择链接类型');
                if(empty($post['url'])) throw new ExceptionEx('请输入链接');
                if(!empty($_GET['id']) && $_GET['id'] == $post['pid']){
                    throw new ExceptionEx('自己不能作为自己的父类');
                }
                $sql = 'select `order` from yd_mv_guide order by `order` desc limit 1';
                $return = Yii::app()->db->createCommand($sql)->queryRow();

                $vip = isset($post['vip'])? $post['vip']:'0';
                $guide -> vip = $vip;


                $guide->pid = intval($post['pid']);
                $guide->name = trim($post['name']);
                $guide->uType = intval($post['uType']);
                $guide->url = trim($post['url']);
                $guide->module = $this->module->id;

                if(!empty($_FILES['ico_true']['tmp_name'])){
                    $filename = 'ico_true';
                    $path = $this->up($filename);
                    //Common::synchroPic($path);
                    //Common::fspost($path);
                    $guide->ico_true = 'http://portalpic.itv.cmvideo.cn:8088/file/'.$path;
                }

                if(!empty($_FILES['ico_false']['tmp_name'])){
                    $filenames = 'ico_false';
                    $path = $this->up($filenames);
                    //Common::synchroPic($path);
                    //Common::fspost($path);
                    $guide->ico_false = 'http://portalpic.itv.cmvideo.cn:8088/file/'.$path;
                }

                if($guide->isNewRecord){
                    $guide->order = $return['order']+1;
                }
                if(!$guide->save()){
                    LogWriter::logModelSaveError($guide,__METHOD__,$guide->attributes);
                    throw new ExceptionEx('信息保存失败');
                }
                //添加到yd_mv_nav
                //先删除
                $gid=$_GET['id'];
                $sql = "DELETE from yd_mv_nav where gid=$gid";
                $rows=Yii::app()->db->createCommand($sql)->query();
                //MvNav::model()->deleteAll("gid in($gid)");

                if(!empty($_POST['province'])){

                    $count = count($_POST['province']);
                    // print_r($count);die();

                    $sheng=$_POST['province'];
                    $shi=$_POST['city'];

                  /*  for($i=0;$i<count($sheng);$i++){
                        $nav = new MvNav();
                        $nav -> gid = $gid;
                        $se=explode('_',$sheng[$i]);
                        $nav -> province = $se[0];

                        $s=explode('_',$shi[$i]);
                        $nav -> city = $s[0];
                        $nav -> save();
                        if(!$nav->save()){
                            LogWriter::logModelSaveError($nav,__METHOD__,$nav->attributes);
                            throw new ExceptionEx('信息保存失败s');
                        }
                    }*/
		            $cp = $_POST['cp'];
                    for($i=0;$i<count($sheng);$i++){
                        for($c=0;$c<count($cp);$c++){
                            $nav = new MvNav();
                            $nav -> gid = $gid;
                            $se=explode('_',$sheng[$i]);
                            $nav -> province = $se[0];

                            $s=explode('_',$shi[$i]);
                            $nav -> city = $s[0];
                            $nav -> cp =$cp[$c];
                            $nav ->usergroup = $_REQUEST['usergroup'];
                            $nav ->epgcode = $_REQUEST['epgcode'];
                            //echo $cp[$c];
                            $nav -> save();
                            if(!$nav->save()){
                                LogWriter::logModelSaveError($nav,__METHOD__,$nav->attributes);
                                throw new ExceptionEx('信息保存失败s');
                            }
                        }
                    }
                }
		else{
                    $cp = $_POST['cp'];
                    for($c=0;$c<count($cp);$c++){
                        $nav = new MvNav();
                        $nav -> gid = $gid;
                        $nav -> province = 0;
                        $nav -> city = 0;
                        $nav -> cp =$cp[$c];
                        $nav ->usergroup = $_REQUEST['usergroup'];
                            $nav ->epgcode = $_REQUEST['epgcode'];
                        //echo $cp[$c];
                        $nav -> save();
                        if(!$nav->save()){
                            LogWriter::logModelSaveError($nav,__METHOD__,$nav->attributes);
                            throw new ExceptionEx('信息保存失败ss');
                        }
                    }
                }

                $this->PopMsg('保存成功');
                $this->redirect($this->get_url('guide','index'));
            }
        }catch (ExceptionEx $ex){
            $this->PopMsg($ex->getMessage());
        }catch (Exception $e){
            $this->log($e->getMessage());
        }

        $province = Province::model()->findAll("1=1 order by id desc");

        $p = isset($p) ? $p : '';
        $cityCode = isset($cityCode) ? $cityCode : '';
        $c = isset($c) ? $c : '';


        $parent = MvGuide::model()->findAllByAttributes(array('pid'=>0));

        $this->render('update',array('guide'=>$guide,'parent'=>$parent,'province'=>$province,'provinceCode'=>$p,'city'=>$cityCode,'cityCode'=>$c,'cou'=>$cou,'arr'=>$arr,'cityarr'=>$cityarr,'cous'=>$cous,'ars'=>$ars,'arrs'=>$arrs,'arres'=>$arres));
    }


	public function actionDel(){
		try{
			if(empty($_GET['id'])) throw new ExceptionEx('参数错误');
			$id = intval($_GET['id']);
			$ex = MvGuide::model()->exists('pid=:id',array(':id'=>$id));
			if($ex){
				throw new ExceptionEx('该分类下含有子类,请先处理子类');
			}

			$del = MvGuide::model()->deleteByPk($id);
                        Yii::app()->db->createCommand()->delete('{{mv_nav}}', "gid=$id");
			if(!$del){
				throw new ExceptionEx('系统繁忙,删除失败');
			}

		}catch (ExceptionEx $ex){
			$this->PopMsg($ex->getMessage());
		}catch (Exception $e){
			$this->log($e->getMessage());
			$this->PopMsg('系统繁忙,请稍后再试');
		}
		$this->redirect($this->getPreUrl());
	}


    //读取出符合条件的所有的市
    public function actionGetcity(){
        $id=$_GET['id'];
        $city = array_map(create_function('$record','return $record->attributes;'),City::model()->findAll("provinceId = '$id' order by id desc"));

        echo json_encode($city);
    }
	public function actionGetpro(){
        $pro = array_map(create_function('$record','return $record->attributes;'),Province::model()->findAll("1=1 order by id desc"));
        echo json_encode($pro);
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
