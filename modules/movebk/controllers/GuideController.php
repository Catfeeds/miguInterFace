<?php

/**
 * Created by PhpStorm.
 * User: xiangl
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

	public function actionAdd(){
		try{
			if(!empty($_GET['id'])){
				$guide = MvGuide::model()->findByPk($_GET['id']);

                $id = $_GET['id'];
                $provinceCode = array_map(create_function('$record','return $record->attributes;'),MvGuide::model()->findAll("id = $id"));
         //   print_r($provinceCode);die();
                if(!empty($provinceCode)){
                    $p = $provinceCode[0]['province'];//查询出来的省份编码
                    $c = $provinceCode[0]['city'];//查询出来的城市编码

                    $cityCode = array_map(create_function('$record','return $record->attributes;'),City::model()->findAll("provinceId = $p"));
                }

			}else{
				$guide = new MvGuide();
				$guide->addTime = time();
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

                $sheng = explode('_',$_POST['province']);
                $guide -> province = trim($sheng[0]);
                $shi = explode('_',$_POST['city']);
                $guide -> city     = trim($shi[0]);
                $guide -> vip = $post['vip'];


				$guide->pid = intval($post['pid']);
				$guide->name = trim($post['name']);
				$guide->uType = intval($post['uType']);
				$guide->url = trim($post['url']);
				$guide->module = $this->module->id;

                if(!empty($_FILES['ico_true']['tmp_name'])){
                    $filename = 'ico_true';
                    $path = $this->up($filename);
                    //var_dump($path);die;
                    Common::synchroPic($path);
                    //$guide ->ico_true    = 'http://' . $_SERVER['HTTP_HOST'] . '/file/' . $path;
                    //$guide ->ico_true    = 'http://192.168.1.107/file/' . $path;
                    $guide->ico_true = 'http://portalpic.itv.cmvideo.cn:8083/file/'.$path;
                }

                if(!empty($_FILES['ico_false']['tmp_name'])){
                    $filenames = 'ico_false';
                    $path = $this->up($filenames);
                    Common::synchroPic($path);
                    //$guide ->ico_false   = 'http://' . $_SERVER['HTTP_HOST'] . '/file/' . $path;
                    //$guide ->ico_false   = 'http://192.168.1.107/file/' . $path;
                    $guide->ico_false = 'http://portalpic.itv.cmvideo.cn:8083/file/'.$path;
                }
				if($guide->isNewRecord){
					$guide->order = $return['order'];
				}
				if(!$guide->save()){
					LogWriter::logModelSaveError($guide,__METHOD__,$guide->attributes);
					throw new ExceptionEx('信息保存失败');
				}

//				if(empty($_GET['id'])){
//					$this->RecordOperatingLog(MSG::MYSQL_EDIT_ADD,$guide,'导航',$guide->name);
//				}else{
//					$this->RecordOperatingLog(MSG::MYSQL_EDIT_EDIT,$guide,'导航',$guide->name);
//				}
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

	public function actionDel(){
		try{
			if(empty($_GET['id'])) throw new ExceptionEx('参数错误');
			$id = intval($_GET['id']);
			$ex = MvGuide::model()->exists('pid=:id',array(':id'=>$id));
			if($ex){
				throw new ExceptionEx('该分类下含有子类,请先处理子类');
			}

			$del = MvGuide::model()->deleteByPk($id);
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
