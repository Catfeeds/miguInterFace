<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/10 0010
 * Time: 13:18
 */
class BulletinController extends AController{
	public function actionIndex(){
		$page = 20;
		$data = $this->getPageInfo($page);
		$bull = BulletinManager::getBullList($data);
		$url = $this->createUrl($this->action->id);
		$pagination = $this->renderPagination($url,$bull['count'],$page,$data['currentPage']);
		$this->render('index',array('list'=>$bull['list'],'page'=>$pagination));
	}

	public function actionAdd(){
		try{
			if(!empty($_GET['bid']) && is_numeric($_GET['bid'])){
				$bulletin = Bulletin::model()->findByPk($_GET['bid']);
			}else{
				$bulletin = new Bulletin();
			}
			if(!empty($_POST)){
				if(empty($_POST['title']))  throw new ExceptionEx('公告标题不能为空');
				if(empty($_POST['info']))   throw new ExceptionEx('公告内容不能为空');

				$bulletin->title    = trim($_POST['title']);
				$bulletin->info     = trim($_POST['info']);
				$bulletin->status   = 1;
				$bulletin->addTime  = time();

				if(!$bulletin->save()){
					LogWriter::logModelSaveError($bulletin,__METHOD__,$bulletin->attributes);
					throw new ExceptionEx('保存失败');
				}
				if(!empty($_GET['id'])){
					$this->RecordOperatingLog(MSG::MYSQL_EDIT_EDIT,$bulletin,'公告',$bulletin->title);
				}else{
					$this->RecordOperatingLog(MSG::MYSQL_EDIT_ADD,$bulletin,'公告',$bulletin->title);
				}
				$this->redirect($this->get_url('bulletin','index'));
			}
		}catch (ExceptionEx $ex){
			$this->PopMsg($ex->getMessage());
		}catch (Exception $e){
			$this->log($e->getMessage());
		}
		$this->render('add',array('bull'=>$bulletin));
	}

	public function actionDel(){
		if(empty($_POST['id']) || !is_numeric($_POST['id'])){
			$this->die_json(array('code'=>404,'msg'=>'参数不能为空'));
		}
		$bulletin = Bulletin::model()->deleteByPk($_POST['id']);
		if(!$bulletin){
			$this->die_json(array('code'=>404,'msg'=>'删除失败'));
		}
		$this->RecordOperatingLog(MSG::MYSQL_EDIT_DEL,$bulletin,'公告',count($bulletin) > 1?'':$bulletin[0]['title']);
		$this->die_json(array('code'=>200,'msg'=>'删除成功'));
	}
}