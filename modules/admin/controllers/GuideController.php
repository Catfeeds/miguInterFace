<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/19 0019
 * Time: 11:48
 */
class GuideController extends AController{
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
		$parent = 0;
		if(!empty($_GET['id'])) $parent = intval($_GET['id']);
		$p = Guide::model()->findByPk($parent);
		$list = GuideManager::getforparent($parent);
		$this->render('index',array('guide'=>$list,'p'=>$p));
	}

	public function actionAdd(){
		try{
			if(!empty($_GET['id'])){
				$guide = Guide::model()->findByPk($_GET['id']);
			}else{
				$guide = new Guide();
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
				$sql = 'select `order` from yd_guide order by `order` desc limit 1';
				$return = Yii::app()->db->createCommand($sql)->queryRow();

				$guide->pid = intval($post['pid']);
				$guide->name = trim($post['name']);
				$guide->uType = intval($post['uType']);
				$guide->url = trim($post['url']);
				$guide->module = $this->module->id;
				if($guide->isNewRecord){
					$guide->order = $return['order'];
				}

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
		$parent = Guide::model()->findAllByAttributes(array('pid'=>0));
		$this->render('add',array('guide'=>$guide,'parent'=>$parent));
	}

	public function actionDel(){
		try{
			if(empty($_GET['id'])) throw new ExceptionEx('参数错误');
			$id = intval($_GET['id']);
			$ex = Guide::model()->exists('pid=:id',array(':id'=>$id));
			if($ex){
				throw new ExceptionEx('该分类下含有子类,请先处理子类');
			}

			$del = Guide::model()->deleteByPk($id);
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

    public function actionUp(){
        if(empty($_POST['nid'])) die(json_encode(array('code'=>404)));
        if(empty($_POST['prev'])) die(json_encode(array('code'=>404)));

        $new = Guide::model()->findByPk($_POST['nid']);
        $new->display -= 1;
        $new->save();

        $prev = Guide::model()->findByPk($_POST['prev']);
        $prev->display += 1;
        $prev->save();

        die(json_encode(array('code'=>200)));
    }

    public function actionDown(){
        if(empty($_POST['nid'])) die(json_encode(array('code'=>404)));
        if(empty($_POST['next'])) die(json_encode(array('code'=>404)));

        $new = Guide::model()->findByPk($_POST['nid']);
        $new->display += 1;
        $new->save();

        $prev = Guide::model()->findByPk($_POST['next']);
        $prev->display -= 1;
        $prev->save();

        die(json_encode(array('code'=>200)));
    }

}
