<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/20 0020
 * Time: 15:49
 */
class SettingController extends AController
{
    public function actionIndex(){
    $cp = 1;
	$id=$_GET['nid'];
        $type = isset($_GET['type']) ? $_GET['type'] : '';

	//用数据库
	if(!empty($id) && empty($type)){
            if($id==36){
                $type='shaoer';
            }
            if($id==37){
                $type='yingyong';
            }
            if($id==34){
                $type='dianshi';
            }
            if($id==35){
                $type='tuijian';
            }
            if($id==33){
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
            $province = Province::model()->findAll("1=1 order by id desc");
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
                }
            }
            $display = UiType::model()->findAll();
            $html = '';
            if(!empty($type)){
                $html = $this->getHtml($setting,trim($type));
            }
            if(!empty($provinceCode)){
                $city = City::model()->findAll("provinceId=".$provinceCode);
            }
            $province = Province::model()->findAll("1=1 order by id desc");
            $citys = isset($city) ? $city : '';
            $this->render('index',array('ui'=>$setting,'type'=>$display,'html'=>$html,'province'=>$province,'ids'=>$type,'provinceCode'=>$provinceCode,'cityCode'=>$cityCode,'city'=>$citys));
	}
    }


	public function actionUpload(){
        $cp =1;
		if(empty($_GET['val']) || empty($_GET['type'])){
			$this->die_json(array('code'=>404,'msg'=>'请选择要设置的位置'));
		}
		$provinceCode = !empty($_GET['provinceCode']) ? $_GET['provinceCode'] :'0';
        $cityCode = !empty($_GET['cityCode']) ? $_GET['cityCode'] :'0';

		$setting = UiManager::getAll($cp,$_GET['type'],$provinceCode,$cityCode);
		$html = $this->getHtml($setting,$_GET['type']);
		
		
        $t = trim($_GET['val']);
        $tType = $setting[$t][0]['tType'];

        $type = $_GET['type'];//这是获取的类型
        $position = $setting[$t][0]['position'];//这是获取的位置


        $size = array_map(create_function('$record','return $record->attributes;'),Imgsize::model()->findAll("type = '$type' AND position = '$position'"));

        $w = $size[0]['width'];
        $h = $size[0]['height'];
        $id = $setting[$t][0]['id'];
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
        $img = substr($_POST['key'],-36);
        Common::synchroPic($img);

	$ui->provinceCode= trim($_POST['provinceCode']);
	$ui->cityCode=	 trim($_POST['cityCode']);
	$ui->title    = trim($_POST['title']);
	$ui->url      = trim($_POST['url']);
        $ui->bigImg   = 'http://portalpic.itv.cmvideo.cn:8088/file/'.trim($img);
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
        $sp             = '699218';

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
            $folderid   = '00211';
        }else{
            $folderid   = trim($_POST['provinceCode']).'211';
        }

       
        if(!empty($_POST['provinceCode'])){
            $fold = Province::model()->findByPk(trim($_POST['provinceCode']));
            $pname = $fold['provinceName'];

            $p =preg_replace('/(省|市|自治区)/','',$pname);
            $foldername     =$p.'华数门户';
        }else{
            $foldername = '全国华数门户';
        }

        //上级栏目id
        $parentfolderid = '';

        //内容在栏目中的排列序号
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

        //echo $str;

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
        $cp =1;
        if(empty($_GET['val']) || empty($_GET['type'])){
            $this->die_json(array('code'=>404,'msg'=>'请选择要设置的位置'));
        }

        $provinceCode = !empty($_GET['provinceCode']) ? $_GET['provinceCode'] :"0";
        $cityCode = !empty($_GET['cityCode']) ? $_GET['cityCode'] :"0";
        $setting = UiManager::getAll($cp,$_GET['type'],$provinceCode,$cityCode);
        $html = $this->getHtml($setting,$_GET['type']);

        $t = trim($_GET['val']);
        $tType = $setting[$t][0]['tType'];

        $type = $_GET['type'];//这是获取的类型
        $position = $setting[$t][0]['position'];//这是获取的位置
        $size = array_map(create_function('$record','return $record->attributes;'),Imgsize::model()->findAll("type = '$type' AND position = '$position'"));

        $w = $size[0]['width'];
        $h = $size[0]['height'];
        $setting = $setting["$t"];
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
        $city = array_map(create_function('$record','return $record->attributes;'),City::model()->findAll("provinceId = $id order by cityCode asc"));
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
	
    //检查搜索的省份市下面有没有对应的数据
      public function actionCheckData()
      {
//            var_dump($_POST);
          $pro = trim($_GET['provinceCode']);
          $city = trim($_GET['cityCode']);
          $sql = "select count(*) from yd_ui WHERE `provinceCode`=$pro AND `cityCode`=$city";
          //echo $sql;
          $arr =Yii::app()->db->createCommand($sql)->queryAll();
          //var_dump($arr);
          $arr[0]['flag'] = $arr[0]['count(*)'];
          echo json_encode($arr,true);
      }

}
