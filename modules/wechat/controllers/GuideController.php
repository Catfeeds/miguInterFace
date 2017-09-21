<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/19 0019
 * Time: 11:48
 */
class GuideController extends WController{
	public function actionDefault(){
//        $idd = $_GET['mid'];
//        //echo $idd;
//        //查询出这个用户的session，
//
//        $name = Yii::app()->session['username'];
//        $pwd  = Yii::app()->session['password'];
//        //通过session查询出这个用户的权限
//        $auth = Admin::model()->find("username = '$name' and password = '$pwd'");
//        $id = $auth['auth'];
//        $group = Group::model()->find("id = '$id'");
//        // echo $group['auth'];//这个用户的权限
//        $quanxian = $group['auth'];
//
//
//        $arr = explode(',',$group['auth']);
//        $url = array_map(create_function('$record','return $record->attributes;'),Guide::model()->findAll(array(
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
//        $aa = array_map(create_function('$record','return $record->attributes;'),Guide::model()->findAll("id = '$nid' "));
//        // echo $aa[0]['url'];
//
//        $this->redirect($this->createUrl($aa[0]['url'],array('mid'=>$idd,'nid'=>$nid)));
		$this->render('default');
	}

	public function actionIndex(){
		$parent = 0;
        //var_dump($_GET['id']);
		if(!empty($_GET['id'])) $parent = intval($_GET['id']);
		$p = WxGuide::model()->findByPk($parent);
        //($p);
		$list = WxGuideManager::getforparent($parent);
        //var_dump($list);
		$this->render('index',array('guide'=>$list,'p'=>$p));
	}

	public function actionAdd(){
		try{
			if(!empty($_GET['id'])){
				$guide = WxGuide::model()->findByPk($_GET['id']);
			}else{
				$guide = new WxGuide();
				$guide->addTime = time();
			}


			if(!empty($_POST)){
				//var_dump($_REQUEST);die;
				$post = $_POST;
				if(empty($post['name'])) throw new ExceptionEx('请输入导航名称');
				if(empty($post['uType']))throw new ExceptionEx('请选择链接类型');
				if(empty($post['url'])) throw new ExceptionEx('请输入链接');
				if(!empty($_GET['id']) && $_GET['id'] == $post['pid']){
					throw new ExceptionEx('自己不能作为自己的父类');
				}
				$sql = 'select `order` from yd_wx_guide order by `order` desc limit 1';
				$return = Yii::app()->db->createCommand($sql)->queryRow();

				$guide->pid = intval($post['pid']);
				$guide->name = trim($post['name']);
				$guide->uType = intval($post['uType']);
				$guide->url = trim($post['url']);
				$province = $post['province'];
				$se=explode('_',$province[0]);
				$guide->province = $se[0];
				$city = $post['city'];
				$s=explode('_',$city[0]);
				$guide -> city = $s[0];
				$guide->module = $this->module->id;
				if($guide->isNewRecord){
					$guide->order = $return['order'];
				}
				//var_dump($guide);die;

				if(!$guide->save()){
					LogWriter::logModelSaveError($guide,__METHOD__,$guide->attributes);
					throw new ExceptionEx('信息保存失败');
				}

				if(empty($_GET['id'])){
					$this->RecordOperatingLog(MSG::MYSQL_EDIT_ADD,$guide,'导航',$guide->name);
				}else{
					$this->RecordOperatingLog(MSG::MYSQL_EDIT_EDIT,$guide,'导航',$guide->name);
				}
				$this->PopMsg('保存成功');
				$this->redirect($this->get_url('guide','index'));
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
		$pid = !empty($_REQUEST['pid'])?$_REQUEST['pid']:'0';
		$parent = WxGuide::model()->findAllByAttributes(array('pid'=>$pid));
        //var_dump($parent);
		$this->render('add',array('guide'=>$guide,'parent'=>$parent,'province'=>$province,'provinceCode'=>$p,'city'=>$cityCode,'cityCode'=>$c));
	}

	public function actionDel(){
		try{
			if(empty($_GET['id'])) throw new ExceptionEx('参数错误');
			$id = intval($_GET['id']);
			$ex = WxGuide::model()->exists('pid=:id',array(':id'=>$id));
			if($ex){
				throw new ExceptionEx('该分类下含有子类,请先处理子类');
			}

			$del = WxGuide::model()->deleteByPk($id);
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
		$pro = array_map(create_function('$record','return $record->attributes;'),Province::model()->findAll("1=1 order by id asc"));
//print_r($pro);
		echo json_encode($pro);
	}

}
