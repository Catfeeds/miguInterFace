<?php

class DefaultController extends AController{

	public function actionIndex(){
		$this->render('index');
        //$this->redirect($this->createUrl('/admin/guide/index'));
	}

	public function actionLogin(){
		try{
			if(Yii::app()->user->getState('admin')){
				$this->redirect($this->createUrl('/admin/default/index'));
			}
                        Yii::app()->session['var']='value';
			$model = new AdminForm();
			if(isset($_POST['AdminForm']))
			{
				$model->attributes=$_POST['AdminForm'];
				if($model->validate() && $model->login()){
                                //if($model->login()){
					$this->RecordOperatingLog(MSG::OP_LOG_LOGIN,$this->getAdmin());
                    $auth = Yii::app()->user->getState('admin');
                    $id = $auth['auth'];
                    $group = Group::model()->find("id = '$id'");
                    Yii::app()->session['group']=$group['auth'];
                    $arr = explode(',',$group['auth']);

                    $url = Guide::model()->find("id = '$arr[0]'");                    
                    $aa = $url['url'];
                    $ids = $url['id'];
                    $this->redirect($this->createUrl($aa,array('mid'=>$ids,'nid'=>0,'id'=>0,'pid'=>0)));
				}
				throw new ExceptionEx('登陆失败');
			}
		}catch (ExceptionEx $ex){
			$this->PopMsg($ex->getMessage());
		}catch (Exception $e){
			$this->log($e->getMessage());
		}
		$this->renderPartial('login',array('model'=>$model));
	}

	public function actionCode(){
		Verification::getNew()->get_code();
	}


	public function actionLogout(){
		$this->RecordOperatingLog(MSG::OP_LOG_LOGOUT,$this->getAdmin());
		Yii::app()->user->logout();
		$this->redirect($this->createUrl('/admin/default/login'));
	}
}
