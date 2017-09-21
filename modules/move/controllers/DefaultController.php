<?php

class DefaultController extends MController{

	public function actionIndex(){
		$this->render('index');
        //$this->redirect($this->createUrl('/admin/guide/index'));
	}

	public function actionLogin(){
		try{
			if(Yii::app()->user->getState('admin')){
				$this->redirect($this->createUrl('/move/default/index'));
			}
           // print_r(Yii::app()->user->getState());

			$model = new MvAdminForm();
           // print_r($model);
			if(isset($_POST['MvAdminForm']))
			{
				$model->attributes=$_POST['MvAdminForm'];
//                print_r($_POST['AdminForm']);
//                echo "<hr/>";
//                print_r($_SESSION);die();
				if($model->validate() && $model->login()){//$model->validate() &&
					//$this->RecordOperatingLog(MSG::OP_LOG_LOGIN,$this->getAdmin());
					//$this->redirect($this->createUrl('/admin/guide/index',array('mid'=>9,'nid'=>10,'id'=>0,'pid'=>0)));
                    //$this->redirect($this->createUrl('/admin/admin/index',array('mid'=>9,'nid'=>22,'id'=>0,'pid'=>0)));
                    //print_r($model);

                   // $group = Group::model()->findAll();
                   // print_r($model);
                   // echo "<br />";
                    $name = $model['username'];
                    // echo "<br />";
//                    echo $name;
                    $pwd = $model['password'];
                   // echo "<br />";
                    //print_r($model);
                    Yii::app()->session['username']=$name;
                    Yii::app()->session['password']=$pwd;
                   // echo Yii::app()->session['var'];

                    $auth = MvAdmin::model()->find("username = '$name' and password = '$pwd'");

                   // print_r($auth);
                    //echo $auth['auth'];
                    $id = $auth['auth'];
                    $group = MvGroup::model()->find("id = '$id'");
                   // print_r($group);
                    //echo $group['auth'];
                    $arr = explode(',',$group['auth']);
                    //print_r($arr);
                    //echo $arr[0];

                    $url = MvGuide::model()->find("id = '$arr[0]'");
                   // print_r($url);
                   // echo $url['url'];
                   // die();
                    $aa = $url['url'];
                    $ids = $url['id'];
                    $this->redirect($this->createUrl($aa,array('mid'=>$ids,'nid'=>0,'id'=>0,'pid'=>0)));
//                    $this->redirect($this->createUrl('/admin/guide/default',array('mid'=>9,'nid'=>0,'id'=>0,'pid'=>0)));
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
	//	$this->RecordOperatingLog(MSG::OP_LOG_LOGOUT,$this->getAdmin());
		Yii::app()->user->logout();
		$this->redirect($this->createUrl('/move/default/login'));
	}
}
