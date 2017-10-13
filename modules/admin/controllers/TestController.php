<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/20 0020
 * Time: 15:49
 */
class TestController extends AController
{

    public function actionDefault(){
        $idd = $_GET['mid'];
        $quanxian = Yii::app()->session['group'];
        $arr = explode(',',$quanxian);
        $url = array_map(create_function('$record','return $record->attributes;'),Guide::model()->findAll(array(
            'select' => array('id'),
            'order'  => 'id asc',
            'condition' => 'pid='.$idd,
        )));
        $nanchuan = $this->array_column($url,'id');
        $you = array();
        for($i=0;$i<count($nanchuan);$i++){
            if(in_array($nanchuan[$i],$arr)){
                $you[]=$nanchuan[$i];
            }
        }
        $nid = $you[0];
        $aa = array_map(create_function('$record','return $record->attributes;'),Guide::model()->findAll("id = '$nid' "));
        $this->redirect($this->createUrl($aa[0]['url'],array('mid'=>$idd,'nid'=>$nid)));
    }


    public function actionIndex(){
        $id=$_GET['nid'];
        $type = isset($_GET['type']) ? $_GET['type'] : '';
        $cp = 99;
        //用数据库
        if(!empty($id) && empty($type)){
            if($id==72){
                $type='shaoer';
            }
            if($id==73){
                $type='yingyong';
            }
            if($id==70){
                $type='dianshi';
            }
            if($id==69){
                $type='tuijian';
            }
            if($id==71){
                $type='yinshi';
            }
            $provinceCode = isset($_GET['provinceCode']) ? $_GET['provinceCode'] : '0';
            $cityCode = isset($_GET['cityCode']) ? $_GET['cityCode'] : '0';

            $setting = UiManager::getAll($cp,$type,$provinceCode,$cityCode);
            $display = UiType::model()->findAll();
            $html = '';
            if(!empty($type)){
                $html = $this->getHtml($setting,trim($type));
            }
            $province = Province::model()->findAll();

            $this->render('index',array('ui'=>$setting,'type'=>$display,'html'=>$html,'province'=>$province,'ids'=>$type,'provinceCode'=>$provinceCode,'cityCode'=>$cityCode));
        }else{
            $type = isset($_GET['type']) ? $_GET['type'] : '';
            $provinceCode = isset($_GET['provinceCode']) ? $_GET['provinceCode'] : '0';
            $cityCode = isset($_GET['cityCode']) ? $_GET['cityCode'] : '0';
            $setting = UiManager::getAll($cp,$type,$provinceCode,$cityCode);
            if(empty($setting)){
                $setting = UiManager::getAll($cp,$type,$provinceCode);
                if(empty($setting)){
                    $setting = UiManager::getAll($cp,$type);
                }
                header("Content-type:text/html;charset=utf-8");
                foreach($setting as $key=>$val){
                    if(count($val)>1){
                        foreach($val as $k=>$v){
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

                            $id = $ui->attributes['id'];
	                        $arr = array_map(create_function('$record', 'return $record->attributes;'), UiPay::model()->findAll("u_id=" . $id));
	                        if (!empty($arr)) {
	                            $pay = new UiPay();
	                            $pay->duration = $arr[0]['duration'];
	                            $pay->year = $arr[0]['year'];
	                            $pay->country = $arr[0]['country'];
	                            $pay->form = $arr[0]['form'];
	                            $pay->hot = $arr[0]['hot'];
	                            $pay->director = $arr[0]['director'];
	                            $pay->actor = $arr[0]['actor'];
	                            $pay->link = $arr[0]['link'];
	                            $pay->epitasis = $arr[0]['epitasis'];
	                            $pay->u_id = $id;
	                            $pay->save();
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

                       	$id = $ui->attributes['id'];
	                    $arr = array_map(create_function('$record', 'return $record->attributes;'), UiPay::model()->findAll("u_id=" . $id));
	                    if (!empty($arr)) {
	                        $pay = new UiPay();
	                        $pay->duration = $arr[0]['duration'];
	                        $pay->year = $arr[0]['year'];
	                        $pay->country = $arr[0]['country'];
	                        $pay->form = $arr[0]['form'];
	                        $pay->hot = $arr[0]['hot'];
	                        $pay->director = $arr[0]['director'];
	                        $pay->actor = $arr[0]['actor'];
	                        $pay->link = $arr[0]['link'];
	                        $pay->epitasis = $arr[0]['epitasis'];
	                        $pay->u_id = $id;
	                        $pay->save();
	                   }
                    }
                }
            }
            $display = UiType::model()->findAll();
            $html = '';
            if(!empty($type)){
                $html = $this->getHtml($setting,trim($type));
            }
            if(!empty($provinceCode)){
                $city = City::model()->findAll("provinceId = '$provinceCode'");
            }
            $province = Province::model()->findAll();
            $citys = isset($city) ? $city : '';

            $this->render('index',array('ui'=>$setting,'type'=>$display,'html'=>$html,'province'=>$province,'ids'=>$type,'provinceCode'=>$provinceCode,'cityCode'=>$cityCode,'city'=>$citys));

        }
    }


    public function actionUpload(){
        $cp =99;
        if(empty($_GET['val']) || empty($_GET['type'])){
            $this->die_json(array('code'=>404,'msg'=>'请选择要设置的位置'));
        }
        $provinceCode = !empty($_GET['provinceCode']) ? $_GET['provinceCode'] :'0';
        $cityCode = !empty($_GET['cityCode']) ? $_GET['cityCode'] :'0';

        $nanchuan = UiManager::getAll($cp,$_GET['type'],$provinceCode,$cityCode);
        $html = $this->getHtml($nanchuan,$_GET['type']);
        //print_r($nanchuan);

        $t = trim($_GET['val']);
        $type = isset($_GET['type']) ? $_GET['type'] : '';
        $fid = isset($_GET['fid'])?$_GET['fid']:'';
        if(empty($nanchuan[$t])){
            $tType = 1;
            $position = $t;
            $id = '';
            $pay = '';
        }else{
            $tType = $nanchuan[$t][0]['tType'];
            $position = $nanchuan[$t][0]['position'];
            $id = $nanchuan[$t][0]['id'];
            $pay = array_map(create_function('$record','return $record->attributes;'),UiPay::model()->findAll("u_id =".$nanchuan[$t][$fid]['id']));

        }

        $size = array_map(create_function('$record','return $record->attributes;'),Imgsize::model()->findAll("type = '$type' AND position = '$position'"));

        $w = $size[0]['width'];
        $h = $size[0]['height'];


        $n = $this->renderPartial(
            'upload',
            array(
                'w'=>$w,
                'h'=>$h,
                'tType'=>$tType,
                'address'=>trim($_GET['val']),
                'fid'=>$fid,
                'type'=>$_GET['type'],
                'ui'=>$nanchuan,
                'html'=>$html,
                'id' =>$id,
                'provinceCode'=>$provinceCode,
                'cityCode'=>$cityCode,
                'pay'=>$pay,
            ),
            true
        );
        die(json_encode(array('code'=>200,'msg'=>$n)));
    }

    private function getHtml($setting,$type){
        switch($type){
            case 'yinshi':
                $html = HTML::yingshi($setting);
                break;
            case 'dianshi':
                $html = HTML::dianshi($setting);
                break;
            case 'tuijian':
                $html = HTML::tuijian($setting);
                break;
            case 'shaoer':
                $html = HTML::shaoer($setting);
                break;
            case 'yingyong':
                $html = HTML::yingyong($setting);
                break;
            default:
                $html = '';
                break;
        }
        return $html;
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

        $ui->provinceCode= trim($_POST['provinceCode']);
        $ui->cityCode =	 trim($_POST['cityCode']);
        $ui->title    = trim($_POST['title']);
        $ui->url      = trim($_POST['url']);
        $ui->position = trim($_POST['position']);
        $ui->type     = trim($_POST['type']);
        $ui->tType    = trim($_POST['tType']);
        $ui->cp       = 99;

        $ty = trim($_POST['type']);
        //echo $ty;

        $po = trim($_POST['position']);
        //echo $po;

        $epg=array_map(create_function('$record','return $record->attributes;'),UiType::model()->findAll("altem = '$ty' "));
        $ui->epg      = $epg[0]['id'];

        $img = substr($_POST['key'],-36);
        Common::synchroPic($img);
        //$ui->bigImg = 'http://' . $_SERVER['HTTP_HOST'] . 'file/' . trim(substr($_POST['key'],-36));
        $ui->bigImg = 'http://portalpic.itv.cmvideo.cn:8088/file/' . trim(substr($_POST['key'],-36));
        $aa=getimagesize(Yii::app()->basePath.'/../file/'.trim($img));
        $width=$aa[0];////获取图片的宽
        $height=$aa[1];///获取图片的高
        $size = array_map(create_function('$record','return $record->attributes;'),Imgsize::model()->findAll("type = '$ty' AND position = '$po'"));
        // print_r($size);
        $w = $size[0]['width'];
        $wid = substr($w,0,strlen($w)-2);
        //echo $wid;
        $h = $size[0]['height'];
        $hei = substr($h,0,strlen($h)-2);


        //echo $wid.'\n'.$hei;
        if($wid == $width && $hei == $height){
            if(!$ui->save()){
                LogWriter::logModelSaveError($ui,__METHOD__,$ui->attributes);
                $this->die_json(array('code'=>404,'msg'=>'信息保存失败'));
            }
        }else{
            $this->die_json(array('code'=>404,'msg'=>"请上传宽度为'$w',高度为'$h'的图片！"));
        }
        $id =$ui->attributes['id'];
        //echo $aaaa=$ui->save();die();

        $pay = UiPay::model()->find('u_id=:u_id',array(':u_id'=>$_POST['id']));
        if(!$pay){
            $pay = new UiPay();
            $pay->u_id     = $id;
        }else{
            $pay->u_id     = trim($_POST['id']);
        }
        $pay->duration = trim($_POST['duration']);
        $pay->year     = trim($_POST['year']);
        $pay->country  = trim($_POST['country']);
        $pay->form     = trim($_POST['form']);
        $pay->hot      = trim($_POST['hot']);
        $pay->director = trim($_POST['director']);
        $pay->actor    = trim($_POST['actor']);
        $pay->link     = trim($_POST['link']);
        $pay->epitasis = trim($_POST['epitasis']);

        if(!$pay->save()){
            LogWriter::logModelSaveError($pay,__METHOD__,$pay->attributes);
            $this->die_json(array('code'=>404,'msg'=>'信息保存失败1'));
        }



        $this->die_json(array('code'=>200));
    }

    public function actionPhoto(){
        //echo $_GET['val'];
        $cp = 99;
        if(empty($_GET['val']) || empty($_GET['type'])){
            $this->die_json(array('code'=>404,'msg'=>'请选择要设置的位置'));
        }

        $provinceCode = !empty($_GET['provinceCode']) ? $_GET['provinceCode'] :"0";
        $cityCode = !empty($_GET['cityCode']) ? $_GET['cityCode'] :"0";
        $setting = UiManager::getAll($cp,$_GET['type'],$provinceCode,$cityCode);
        //print_r($setting);
        //$setting = UiManager::getAll($_GET['type']);
        $html = $this->getHtml($setting,$_GET['type']);

        $t = trim($_GET['val']);
        //$setting = $setting["$t"];
        $tType = $setting[$t][0]['tType'];

        $type = $_GET['type'];//这是获取的类型
        $position = $setting[$t][0]['position'];//这是获取的位置
        $size = array_map(create_function('$record','return $record->attributes;'),Imgsize::model()->findAll("type = '$type' AND position = '$position'"));

        $w = $size[0]['width'];
        //echo $w;
        $h = $size[0]['height'];
        $setting = $setting["$t"];
        //print_r($setting);
        $n = $this->renderPartial(
            'photo',
            array(
                'w'=>$w,
                'h'=>$h,
                'tType'=>$tType,
                'address'=>trim($_GET['val']),
                'type'=>$_GET['type'],
                'ui'=>$setting,
                'html'=>$html,
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
        $city = array_map(create_function('$record','return $record->attributes;'),City::model()->findAll("provinceId = $id order by id desc"));
        echo json_encode($city);
    }



    public function actionSousuo(){
        $type = $_GET['type'];
        if($type==1){
            $value = $_GET['val'];
            $page = intval($_GET['page']); //当前页

            $sql = "select count(*) as total from yd_video where title like '%{$value}%'"; //总记录数
            $total_num = Yii::app()->db->createCommand($sql)->queryAll()[0]['total'];
            $page_size = 5; //每页数量
            $page_total = ceil($total_num / $page_size); //总页数
            $page_start = $page * $page_size;
            $arr = array(
                "total_num" => $total_num,
                "page_size" => $page_size,
                "page_total_num" => $page_total,
            );

            $sql = "select vid,title,type,cate from yd_video where title like '%{$value}%' limit {$page_start},{$page_size}";
            $arr['list'] =Yii::app()->db->createCommand($sql)->queryAll();
            //var_dump($arr['list']);
            echo json_encode($arr);
        }else{
            $value = $_GET['val'];
            $page = intval($_GET['page']); //当前页

            $sql = "select count(*) as total from yd_apps where name like '%{$value}%'"; //总记录数
            $total_num = Yii::app()->db->createCommand($sql)->queryAll()[0]['total'];
            $page_size = 5; //每页数量
            $page_total = ceil($total_num / $page_size); //总页数
            $page_start = $page * $page_size;
            $arr = array(
                "total_num" => $total_num,
                "page_size" => $page_size,
                "page_total_num" => $page_total,
            );

            $sql = "select appId,name,typeId,typeName from yd_apps where name like '%{$value}%' limit {$page_start},{$page_size}";
            $arr['list'] =Yii::app()->db->createCommand($sql)->queryAll();
            //var_dump($arr['list']);
            echo json_encode($arr);
        }
    }
}
