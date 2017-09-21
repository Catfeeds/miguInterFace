<?php

/**
 * Created by PhpStorm.
 * User: xzm
 * Date: 2015/10/28
 * Time: 13:45
 */
class GansuController extends AController{

    public function actionDefault(){
         $idd = $_GET['mid'];
$quanxian = Yii::app()->session['group'];
$arr = explode(',',$quanxian);
$url = array_map(create_function('$record','return $record->attributes;'),Guide::model()->findAll(array(
'select' => array('id'),
'order'  => 'id asc',
'condition' => 'pid='.$idd,
)));
$gansu = $this->array_column($url,'id');
$you = array();
for($i=0;$i<count($gansu);$i++){
if(in_array($gansu[$i],$arr)){
$you[]=$gansu[$i];
}
}
$nid = $you[0];
$aa = array_map(create_function('$record','return $record->attributes;'),Guide::model()->findAll("id = '$nid' "));
$this->redirect($this->createUrl($aa[0]['url'],array('mid'=>$idd,'nid'=>$nid))); 


   }


    public function actionIndex(){
        $cp = 2;
        $id=$_GET['nid'];
        $type = isset($_GET['type']) ? $_GET['type'] : '';

        //用数据库
        if(!empty($id) && empty($type)){
            if($id==82){
                $type='yingyong';
            }
            if($id==79){
                $type='yinshi';
            }
            if($id==80){
                $type='shaoer';
            }
            if($id==81){
                $type='jishi';
            }
            if($id==78){
                $type='tuijian';
            }


            $gansu = UiGansuManager::getAll($cp,$type);

            $display = UiType::model()->findAll();
            $html = '';
            if(!empty($type)){
                $html = $this->getHtml($gansu,trim($type));
            }

            $this->render('index',array('ui'=>$gansu,'type'=>$gansu,'html'=>$html,'ids'=>$type));
        }
    }


    private function getHtml($gansu,$type){
        switch($type){
            case 'tuijian':
                $html = HTMLS::tuijian($gansu);
                break;
            case 'yinshi':
                $html = HTMLS::yingshi($gansu);
                break;
            case 'shaoer':
                $html = HTMLS::shaoer($gansu);
                break;
            case 'jishi':
                $html = HTMLS::jishi($gansu);
                break;
            case 'yingyong':
                $html = HTMLS::yingyong($gansu);
                break;
            default:
                $html = '';
                break;
        }
        return $html;
    }



    public function actionUpload(){
        $cp =2;
        if(empty($_GET['val']) || empty($_GET['type'])){
            $this->die_json(array('code'=>404,'msg'=>'请选择要设置的位置'));
        }

        $gansu = UiGansuManager::getAll($cp,$_GET['type']);

        $html = $this->getHtml($gansu,$_GET['type']);


        $t = trim($_GET['val']);
        $type = isset($_GET['type']) ? $_GET['type'] : '';
        if(empty($gansu[$t])){
            $tType = 1;
            $pos = $t;
            $id = '';
        }else{
            $tType = $gansu[$t][0]['tType'];
            $pos = $gansu[$t][0]['pos'];
            $id = $gansu[$t][0]['id'];
        }

        $size = array_map(create_function('$record','return $record->attributes;'),Imgsize::model()->findAll("type = '$type' AND position = '$pos'"));

        $w = $size[0]['width'];
        $h = $size[0]['height'];
        $fid = isset($_GET['fid'])?$_GET['fid']:'';
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
                'ui'=>$gansu,
                'html'=>$html,
                'id' =>$id,
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
        if(empty($_POST['pos'])) $this->die_json(array('code'=>404,'msg'=>'系统错误'));
        //echo $_POST['key'];
        $ui = UiGansu::model()->findByAttributes(array('pos'=>$_POST['pos'],'type'=>$_POST['type'],'id'=>$_POST['id']));
        //print_r($ui['id']);
        if(!$ui){
            $ui = new UiGansu();
            $ui->cTime = time();
        }else{
            $ui->upTime = time();
        }

        $img = substr($_POST['key'],-36);
        Common::synchroPic($img);
        $ui -> title  = trim($_POST['title']);
        $ui -> url    = trim($_POST['url']);
        //$ui -> bigImg    = 'http://'.$_SERVER['HTTP_HOST'].'/file/'.trim($img);
        //$ui -> bigImg    = 'http://192.168.1.111/file/'.trim($img);
        $ui->bigImg   = 'http://portalpic.itv.cmvideo.cn:8088/file/'.trim($img);
        $ui -> pos    = trim($_POST['pos']);
        $ui -> type   = trim($_POST['type']);
        $ui -> tType   = trim($_POST['tType']);
        $ui -> cp  = 2;

        $aa=getimagesize(Yii::app()->basePath.'/../file/'.trim($img));
        $width=$aa[0];
        $height=$aa[1];

        $ty = trim($_POST['type']);
        $pos = trim($_POST['pos']);

        $size = array_map(create_function('$record','return $record->attributes;'),Imgsize::model()->findAll("type = '$ty' AND position = '$pos'"));

        $w = $size[0]['width'];
        $wid = substr($w,0,strlen($w)-2);

        $h = $size[0]['height'];
        $hei = substr($h,0,strlen($h)-2);
        if($wid == $width && $hei == $height){
            if(!$ui->save()){
                var_dump($ui->getErrors());
                LogWriter::logModelSaveError($ui,__METHOD__,$ui->attributes);
                $this->die_json(array('code'=>404,'msg'=>'信息保存失败'));
            }
        }else{
            $this->die_json(array('code'=>404,'msg'=>"请上传宽度为'$w',高度为'$h'的图片！"));
        }

        $this->die_json(array('code'=>200));
    }




    public function actionPhoto(){
        $cp =2;
        if(empty($_GET['val']) || empty($_GET['type'])){
            $this->die_json(array('code'=>404,'msg'=>'请选择要设置的位置'));
        }


        $gansu = UiGansuManager::getAll($cp,$_GET['type']);
        $html = $this->getHtml($gansu,$_GET['type']);

        $t = trim($_GET['val']);
        $tType = $gansu[$t][0]['tType'];
        $pos = $gansu[$t][0]['pos'];
        $gansu = $gansu["$t"];
        $type = $_GET['type'];
        $size = array_map(create_function('$record','return $record->attributes;'),Imgsize::model()->findAll("type = '$type' AND position = '$pos'"));
        $w = $size[0]['width'];
        $h = $size[0]['height'];

        $n = $this->renderPartial(
            'photo',
            array(
                'w'=>$w,
                'h'=>$h,
                'tType'=>$tType,
                'address'=>trim($_GET['val']),
                'type'=>$_GET['type'],
                'ui'=>$gansu,
                'html'=>$html,
            ),
            true
        );
        die(json_encode(array('code'=>200,'msg'=>$n)));
    }

    public function actionGetcity(){
        $id=$_GET['id'];
        $city = array_map(create_function('$record','return $record->attributes;'),City::model()->findAll("provinceId = $id order by cityCode asc"));
        echo json_encode($city);
    }

    public function actionGonggao(){
        $page = 20;
        $pro = 28;
        $data = $this->getPageInfo($page);
        //var_dump($data);die;
        $gansu = GansuManager::getGansuList($data,$pro);
        $url = $this->createUrl($this->action->id);
        $pagination = $this->renderPagination($url,$gansu['count'],$page,$data['currentPage']);
        $this->render('gonggao',array('list'=>$gansu['list'],'page'=>$pagination));
    }

    public function actionAdds(){

        try{
            if(!empty($_GET['bid']) && is_numeric($_GET['bid'])){
                $notice = Notice::model()->findByPk($_GET['bid']);

                $id = isset($_GET['bid']) ? $_GET['bid'] : '';
                $provinceCode = array_map(create_function('$record','return $record->attributes;'),Notice::model()->findAll("id = $id"));

                $p = $provinceCode[0]['province'];//查询出来的省份编码
                $c = $provinceCode[0]['city'];//查询出来的城市编码

                $cityCode = array_map(create_function('$record','return $record->attributes;'),City::model()->findAll("provinceId = 28"));


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

                $notice -> province = '28';


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

                $this->redirect($this->get_url('gansu','gonggao'));
            }
        }catch (ExceptionEx $ex){
            $this->PopMsg($ex->getMessage());
        }catch (Exception $e){
            $this->log($e->getMessage());
        }


        $p = isset($p) ? $p : '';
        $cityCode = isset($cityCode) ? $cityCode : '';
        $c = isset($c) ? $c : '';

        $this->render('adds',array('notice'=>$notice,'city'=>$cityCode,'cityCode'=>$c));
    }
}
