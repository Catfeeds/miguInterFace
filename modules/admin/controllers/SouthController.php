<?php

/**
 * Created by PhpStorm.
 * User: xzm
 * Date: 2015/12/30
 * Time: 11:12
 */
class SouthController extends AController{
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
        $cp = 4;
        $id=$_GET['nid'];
        $type = isset($_GET['type']) ? $_GET['type'] : '';

        //用数据库
        if(!empty($id) && empty($type)){
            if($id==56){
                $type='shaoer';
            }
            if($id==57){
                $type='yingyong';
            }
            if($id==54){
                $type='dianshi';
            }
            if($id==53){
                $type='tuijian';
            }
            if($id==55){
                $type='yinshi';
            }
            $provinceCode = isset($_GET['provinceCode']) ? $_GET['provinceCode'] : '0';
            $cityCode = isset($_GET['cityCode']) ? $_GET['cityCode'] : '0';

            $nanchuan = UiManager::getAll($cp,$type,$provinceCode,$cityCode);
            $display = UiType::model()->findAll();
            $html = '';
            if(!empty($type)){
                $html = $this->getHtml($nanchuan,trim($type));
            }
            $province = Province::model()->findAll();

            $this->render('index',array('ui'=>$nanchuan,'type'=>$display,'html'=>$html,'province'=>$province,'ids'=>$type,'provinceCode'=>$provinceCode,'cityCode'=>$cityCode));
        }else{
            $cp =4;
            $type = isset($_GET['type']) ? $_GET['type'] : '';
            $provinceCode = isset($_GET['provinceCode']) ? $_GET['provinceCode'] : '0';
            $cityCode = isset($_GET['cityCode']) ? $_GET['cityCode'] : '0';
            $nanchuan = UiManager::getAll($cp,$type,$provinceCode,$cityCode);
            if(empty($nanchuan)){
                $nanchuan = UiManager::getAll($cp,$type,$provinceCode);
                if(empty($nanchuan)){
                    $nanchuan = UiManager::getAll($cp,$type);
                }
                header("Content-type:text/html;charset=utf-8");
                foreach($nanchuan as $key=>$val){
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
            }
            $display = UiType::model()->findAll();
            $html = '';
            if(!empty($type)){
                $html = $this->getHtml($nanchuan,trim($type));
            }
            if(!empty($provinceCode)){
                $city = City::model()->findAll("provinceId = '$provinceCode'");
            }
            $province = Province::model()->findAll();
            $citys = isset($city) ? $city : '';

            $this->render('index',array('ui'=>$nanchuan,'type'=>$display,'html'=>$html,'province'=>$province,'ids'=>$type,'provinceCode'=>$provinceCode,'cityCode'=>$cityCode,'city'=>$citys));

        }
    }


    public function actionUpload(){
        $cp =4;
        if(empty($_GET['val']) || empty($_GET['type'])){
            $this->die_json(array('code'=>404,'msg'=>'请选择要设置的位置'));
        }
        $provinceCode = !empty($_GET['provinceCode']) ? $_GET['provinceCode'] :'0';
        $cityCode = !empty($_GET['cityCode']) ? $_GET['cityCode'] :'0';

        $nanchuan = UiManager::getAll($cp,$_GET['type'],$provinceCode,$cityCode);
        $html = $this->getHtml($nanchuan,$_GET['type']);


        $t = trim($_GET['val']);
        $type = isset($_GET['type']) ? $_GET['type'] : '';
        if(empty($nanchuan[$t])){
            $tType = 1;
            $position = $t;
            $id = '';
        }else{
            $tType = $nanchuan[$t][0]['tType'];
            $position = $nanchuan[$t][0]['position'];
            $id = $nanchuan[$t][0]['id'];
        }

        $size = array_map(create_function('$record','return $record->attributes;'),Imgsize::model()->findAll("type = '$type' AND position = '$position'"));

        $w = $size[0]['width'];
        $h = $size[0]['height'];
        $fid = isset($_GET['fid'])?$_GET['fid']:'';
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
                'cityCode'=>$cityCode
            ),
            true
        );
        die(json_encode(array('code'=>200,'msg'=>$n)));
    }

    private function getHtml($nanchuan,$type){
        switch($type){
            case 'yinshi':
                $html = HTML::yingshi($nanchuan);
                break;
            case 'dianshi':
                $html = HTML::dianshi($nanchuan);
                break;
            case 'tuijian':
                $html = HTML::tuijian($nanchuan);
                break;
            case 'shaoer':
                $html = HTML::shaoer($nanchuan);
                break;
            case 'yingyong':
                $html = HTML::yingyong($nanchuan);
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
        $img = substr($_POST['key'],-36);
        Common::synchroPic($img);

        $ui->provinceCode= trim($_POST['provinceCode']);
        $ui->cityCode=	 trim($_POST['cityCode']);
        $ui->title    = trim($_POST['title']);
        $ui->url      = trim($_POST['url']);
        $ui->position = trim($_POST['position']);
        $ui->type     = trim($_POST['type']);
        $ui->tType    = trim($_POST['tType']);
        $ty = trim($_POST['type']);
        $po = trim($_POST['position']);

        $epg=array_map(create_function('$record','return $record->attributes;'),UiType::model()->findAll("altem = '$ty' "));
        $ui->epg      = $epg[0]['id'];
        $ui->bigImg = 'http://portalpic.itv.cmvideo.cn:8088/file/'.trim($img);
        $ui->cp = 4;

        $aa=getimagesize(Yii::app()->basePath.'/../file/'.trim($img));
        $width=$aa[0];
        $height=$aa[1];
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


        $sp             = '699218';
        $c  =trim($_POST['url']);
        $a  =explode('contentId=',$c);
        if(!empty($a[1])){
            $contentid  = $a[1];
        }else{
            $contentid  = '';
        }
        $contentname    = trim($_POST['title']);
        if(trim($_POST['provinceCode'])==0){
            $folderid   = '00214';
        }else{
            $folderid   = trim($_POST['provinceCode']).'214';
        }
        if(!empty($_POST['provinceCode'])){
            $fold = Province::model()->findByPk(trim($_POST['provinceCode']));
            $pname = $fold['provinceName'];

            $p =preg_replace('/(省|市|自治区)/','',$pname);

            $foldername     =$p.'南传门户';
        }else{
            $foldername = '全国南传门户';
        }
        $parentfolderid = '';
        $sequence       = $size[0]['sequence'];
        if($size[0]['type'] == 'yinshi'){
            $position   = '3';
        }elseif($size[0]['type'] == 'dianshi'){
            $position   = '2';
        }elseif($size[0]['type'] == 'tuijian'){
            $position   = '1';
        }elseif($size[0]['type'] == 'shaoer'){
            $position   = '4';
        }elseif($size[0]['type'] == 'yingyong'){
            $position   = '5';
        }
        $str = $sp.'|'.$contentid.'|'.$contentname.'|'.$folderid.'|'.$foldername.'|'.$parentfolderid.'|'.$sequence.'|'.$position;

        $fileName=date("Ymd", time());
        $fileName=Yii::app()->basePath.'/../data/i_'.$fileName.'_OTT-21104.txt';
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

    public function actionPhoto(){
        $cp =4;
        if(empty($_GET['val']) || empty($_GET['type'])){
            $this->die_json(array('code'=>404,'msg'=>'请选择要设置的位置'));
        }

        $provinceCode = !empty($_GET['provinceCode']) ? $_GET['provinceCode'] :"0";
        $cityCode = !empty($_GET['cityCode']) ? $_GET['cityCode'] :"0";
        $nanchuan = UiManager::getAll($cp,$_GET['type'],$provinceCode,$cityCode);
        $html = $this->getHtml($nanchuan,$_GET['type']);

        $t = trim($_GET['val']);
        $tType = $nanchuan[$t][0]['tType'];

        $type = $_GET['type'];
        $position = $nanchuan[$t][0]['position'];
        $size = array_map(create_function('$record','return $record->attributes;'),Imgsize::model()->findAll("type = '$type' AND position = '$position'"));

        $w = $size[0]['width'];
        $h = $size[0]['height'];
        $nanchuan = $nanchuan["$t"];
        $n = $this->renderPartial(
            'photo',
            array(
                'w'=>$w,
                'h'=>$h,
                'tType'=>$tType,
                'address'=>trim($_GET['val']),
                'type'=>$_GET['type'],
                'ui'=>$nanchuan,
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

    //南传下的公告列表
    public function actionNotice(){
        $cp = 4;
        $page = 20;
        $data = $this->getPageInfo($page);
        $notice = NoticeManager::getNoticeList($data,$cp);
        $url = $this->createUrl($this->action->id);
        $pagination = $this->renderPagination($url,$notice['count'],$page,$data['currentPage']);
        $this->render('notice',array('list'=>$notice['list'],'page'=>$pagination));
    }
    public function actionNadds(){
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
                if(empty($_POST['notice']))  throw new ExceptionEx('公告内容不能为空！');
                //if(empty($_POST['province'])) throw new ExceptionEx('请选择省份！');
                if(empty($_POST['sTime'])) throw new ExceptionEx('请选择开始时间');
                if(empty($_POST['eTime'])) throw new ExceptionEx('请选择结束时间');
                if(strtotime($_POST['sTime']) > strtotime($_POST['eTime'])){
                    throw new ExceptionEx('结束时间必须大于、等于开始时间!');
                }

                $notice -> notice   = trim($_POST['notice']);
                $notice -> cp       = '4';

                $sheng = explode('_',$_POST['province']);
                $notice -> province = trim($sheng[0]);

                $shi = explode('_',$_POST['city']);
                $notice -> city     = trim($shi[0]);

                $notice -> sTime    = strtotime($_POST['sTime']);
                $notice -> eTime    = strtotime($_POST['eTime']);
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

                $this->redirect($this->get_url('south','notice'));
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

        $this->render('nadds',array('notice'=>$notice,'province'=>$province,'provinceCode'=>$p,'city'=>$cityCode,'cityCode'=>$c));
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
