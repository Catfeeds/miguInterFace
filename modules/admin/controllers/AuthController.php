<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/12 0012
 * Time: 17:48
 */
class AuthController extends AController
{
	public function actionIndex(){
		$page = 20;
		$criteria = new CDbCriteria();
		$data = $this->getPageInfo($page);
		$criteria->select = 'id,title,model,class,action,addres';
		$count = Auth::model()->count($criteria);
		$criteria->offset = $data['start'];
		$criteria->limit = $data['limit'];
		$list = Auth::model()->findAll($criteria);
		$url = $this->createUrl($this->action->id);
		$pagination = $this->renderPagination($url,$count,$page,$data['currentPage']);
		$this->render('index',array('list'=>$list,'page'=>$pagination));
	}

	public function actionAdd(){
		try{
			if(!empty($_GET['id'])){
				$auth = Auth::model()->findByPk($_GET['id']);
			}else{
				$auth = new Auth();
			}
			if(!empty($_POST)){
				if(empty($_POST['title'])) throw new ExceptionEx('请输入权限名称');
				if(empty($_POST['model'])) throw new ExceptionEx('请输入模块名称');
				if(empty($_POST['class'])) throw new ExceptionEx('请输入类名称');
				if(empty($_POST['action']))throw new ExceptionEx('请输入操作方法名称');

				$auth->title = trim($_POST['title']);
				$auth->model = trim($_POST['model']);
				$auth->class = trim($_POST['class']);
				$auth->action= trim($_POST['action']);
				$auth->addres= '/'.trim($_POST['model']).'/'.trim($_POST['class']).'/'.trim($_POST['action']);
				if($auth->isNewRecord){
					$auth->addTime = time();
				}

				if(!$auth->save()){
					LogWriter::logModelSaveError($auth,__METHOD__,$auth->attributes);
					throw new ExceptionEx('保存失败');
				}

				if($auth->isNewRecord){
					$this->RecordOperatingLog(MSG::MYSQL_EDIT_ADD,$auth,'权限',$auth->title);
				}else{
					$this->RecordOperatingLog(MSG::MYSQL_EDIT_EDIT,$auth,'权限',$auth->title);
				}
				$this->redirect($this->get_url('auth','index'));
			}
		}catch (ExceptionEx $ex){
			$this->PopMsg($ex->getMessage());
		}catch (Exception $e){
			$this->log($e->getMessage());
		}
		$this->render('add',array('auth'=>$auth));
	}

	public function actionDel(){
		if(!empty($_GET['id']) && is_numeric($_GET['id'])){
			$del = Auth::model()->deleteByPk($_GET['id']);
			if(!$del){
				$this->PopMsg('删除失败');
			}else{
				$name = count($del) > 1?'':$del[0]['title'];
				$this->RecordOperatingLog(MSG::MYSQL_EDIT_DEL,$del,'权限',$name);
				$this->PopMsg('删除成功');
			}
		}
		$this->redirect($this->getPreUrl());
	}

	public function actionUpdate(){
		$model = $this->module->id;
		ClassManager::save('admin');
		$this->PopMsg('更新成功');
		$this->redirect($this->getPreUrl());
	}

	public function actionReset(){
		if(empty($_POST['name'])) $this->die_json(array('code'=>404,'msg'=>'权限名称不能为空'));
		if(empty($_POST['id'])) $this->die_json(array('code'=>404,'msg'=>'权限主键错误'));

		$auth = Auth::model()->findByPk($_POST['id']);
		$auth->title = trim($_POST['name']);
		if(!$auth->save()){
			LogWriter::logModelSaveError($auth,__METHOD__,$auth->attributes);
			$this->die_json(array('code'=>303,'msg'=>'修改失败,请稍后重试'));
		}
		$this->RecordOperatingLog(MSG::MYSQL_EDIT_EDIT,$auth,'权限名称',$auth->title);
		$this->die_json(array('code'=>200,'msg'=>'修改成功'));
	}
}