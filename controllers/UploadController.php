<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/21 0021
 * Time: 13:22
 */
class UploadController extends Controller{
	public function actionImg(){
		$folder = Yii::app()->basePath . '/../file/';
		if(!is_dir($folder)){
			mkdir($folder);
		}
		$tmp = $_FILES['Filedata']['tmp_name'];

		$file = getimagesize($tmp);
		if(!$file){
			die(json_encode(array('code'=>101,'msg'=>'这不是一张图片')));
		}

		$yx = array('image/jpeg','image/jpg','image/png','image/gif');
		if(!in_array($file['mime'],$yx)){
			die(json_encode(array('code'=>202,'msg'=>'上传了不允许的文件')));
		}

		//image file reset name
		$wz = strrchr($_FILES['Filedata']['name'],'.');
		$new= md5(microtime().rand(000000,999999)).$wz;

		@move_uploaded_file($tmp,$folder.$new);
		if(!file_exists($folder.$new)){
			die(json_encode(array('code'=>404,'msg'=>'文件上传失败')));
		}
		die(json_encode(array(
			'code'=>200,
			'msg'=>'文件上传成功',
			'key'=>$new,
			'url'=>'http://'.$_SERVER['HTTP_HOST'].'/file/'.$new
		)));
	}
}
