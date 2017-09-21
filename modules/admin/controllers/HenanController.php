<?php

/**
 * Created by PhpStorm.
 * User: xzm
 * Date: 2015/10/28
 * Time: 13:45
 */
class HenanController extends AController{

    public function actionDefault(){
        $idd = $_GET['mid'];
        $quanxian = Yii::app()->session['group'];
        $arr = explode(',',$quanxian);
        $url = array_map(create_function('$record','return $record->attributes;'),Guide::model()->findAll(array(
            'select' => array('id'),
            'order'  => 'id asc',
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

    public function actionIndex(){

        $id=$_GET['nid'];
        $cp = 7;
        $henan = UiHenanManager::getAll($cp);

        $html = $this->getHtmls($henan);
        $this->render('index',array('henan'=>$henan,'html'=>$html));
    }

    private function getHtmls($henan){

        $html = HTML::henan($henan);

        return $html;
    }



    public function actionUpload(){
        if(empty($_GET['val'])){
            $this->die_json(array('code'=>404,'msg'=>'请选择要设置的位置'));
        }
        $cp = 7;
        $henan = UiHenanManager::getAll($cp);
        $html = $this->getHtmls($henan);
        //print_r($henan);
        $type = $henan[trim($_GET['val'])][0]['type'];

        $t = trim($_GET['val']);
        $ty = "henan";
        $pos = $henan[$t][0]['pos'];
        
        $size = array_map(create_function('$record','return $record->attributes;'),Imgsize::model()->findAll("type = '$ty' AND position = '$pos'"));
        $w = $size[0]['width'];
        $h = $size[0]['height'];
        
        $fid = isset($_GET['fid']) ? $_GET['fid'] : '';

        $n = $this->renderPartial(
            'upload',
            array(
                'w'=>$w,
                'h'=>$h,
                'fid'=>$fid,
                'address'=>trim($_GET['val']),
                'type'=>$type,
                'henan'=>$henan,
                'html'=>$html
            ),
            true
        );

        die(json_encode(array('code'=>200,'msg'=>$n)));
    }



    public function actionAdd(){
        if(!Yii::app()->request->isAjaxRequest){
            $this->redirect($this->getPreUrl());
        }
        if(empty($_POST['type']))   $this->die_json(array('code'=>404,'msg'=>'上传类型不能为空!'));
        if(empty($_POST['title']))  $this->die_json(array('code'=>404,'msg'=>'标题不能为空'));
        if(empty($_POST['url']))    $this->die_json(array('code'=>404,'msg'=>'链接地址不能为空'));
        if(empty($_POST['key']))    $this->die_json(array('code'=>404,'msg'=>'图片地址不能为空'));
        if(empty($_POST['pos']))    $this->die_json(array('code'=>404,'msg'=>'系统错误'));

        $henan = UiHenan::model()->findByAttributes(array('pos'=>$_POST['pos'],'id'=>$_POST['id']));
        
        if(!$henan){
            $henan = new UiHenan();
            $henan->cTime = time();
        }else{
            $henan->upTime = time();
        }
        $img = substr($_POST['key'],-36);
        Common::synchroPic($img);
        $henan -> title  = trim($_POST['title']);
        $henan -> url    = trim($_POST['url']);
        //$henan -> pic    = 'http://'.$_SERVER['HTTP_HOST'].'/file/'.trim($img);
        $henan -> pic    = 'http://portalpic.itv.cmvideo.cn:8088/file/'.trim($img);
        $henan -> pos    = trim($_POST['pos']);
        $henan -> type   = trim($_POST['type']);

        $aa=getimagesize(Yii::app()->basePath.'/../file/'.trim($img));
        $width=$aa[0];  
        $height=$aa[1]; 

        $ty = "henan";
        $pos = trim($_POST['pos']);

        $size = array_map(create_function('$record','return $record->attributes;'),Imgsize::model()->findAll("type = '$ty' AND position = '$pos'"));

        $w = $size[0]['width'];
        $wid = substr($w,0,strlen($w)-2);
        
        $h = $size[0]['height'];
        $hei = substr($h,0,strlen($h)-2);
        if($wid == $width && $hei == $height) {
            if (!$henan->save()) {
                var_dump($henan->getErrors);
                LogWriter::logModelSaveError($henan, __METHOD__, $henan->attributes);
                $this->die_json(array('code' => 404, 'msg' => '信息保存失败'));
            }
        }else{
            $this->die_json(array('code'=>404,'msg'=>"请上传宽度为'$w',高度为'$h'的图片！"));
        }

        //日志记录

        //牌照方
        $sp             = '699217';

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

        //栏目id
        $folderid   = '17217';
        $foldername = '河南银河门户';

        //上级栏目id
        $parentfolderid = '';

        //内容在栏目中的排列序号
        $sequence       = $size[0]['sequence'];

        $position   = '1';
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
        
        if(empty($_GET['val'])){
            $this->die_json(array('code'=>404,'msg'=>'请选择要设置的位置'));
        }
        $cp = 7;
        $henan = UiHenanManager::getAll($cp);
        $html = $this->getHtmls($henan);
        
        $type = $henan[trim($_GET['val'])][0]['type'];

        $t = trim($_GET['val']);
        $ty = "henan";
        $pos = $henan[$t][0]['pos'];
        
        $size = array_map(create_function('$record','return $record->attributes;'),Imgsize::model()->findAll("type = '$ty' AND position = '$pos'"));
        $w = $size[0]['width'];
        $h = $size[0]['height'];
        $henan = $henan["$t"];

        $n = $this->renderPartial(
            'photo',
            array(
                'w'=>$w,
                'h'=>$h,                
                'address'=>trim($_GET['val']),
                'type'=>$type,
                'henan'=>$henan,
                'html'=>$html
            ),
            true
        );
        die(json_encode(array('code'=>200,'msg'=>$n)));
    }
}
