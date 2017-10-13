<?php

class DefaultController extends WController{

    public function actionIndex(){
        $this->render('index');
        //$this->redirect($this->createUrl('/admin/guide/index'));
    }

    public function actionLogin(){
        try{
            if(Yii::app()->user->getState('admin')){
               // echo Yii::app()->user->getState('wxadmin');die();
                $this->redirect($this->createUrl('/wechat/default/index'));
            }
            // print_r(Yii::app()->user->getState());

            $model = new WxAdminForm();

            //print_r($model);die();
            //print_r($model);

            if(isset($_POST['WxAdminForm']))
            {
                //print_r($_POST['WxAdminForm']);die();
                $model->attributes=$_POST['WxAdminForm'];
                //print_r($model);die();
               //  print_r($model['attributes']);die();
                // print_r($_POST['WxAdminForm']);die();
//                echo "<hr/>";
              //  print_r($_SESSION);die();
               // print_r($model->validate());
                //                echo "<hr/>";
//                print_r($model->login());
//                die();
                if($model->validate() && $model->login()){////$model->validate() &&

                   // $this->RecordOperatingLog(MSG::OP_LOG_LOGIN,$this->getAdmin());
                    //$this->redirect($this->createUrl('/admin/guide/index',array('mid'=>9,'nid'=>10,'id'=>0,'pid'=>0)));
                    //$this->redirect($this->createUrl('/admin/admin/index',array('mid'=>9,'nid'=>22,'id'=>0,'pid'=>0)));
                   // print_r($model);die();

                    // $group = Group::model()->findAll();
                    // print_r($model);
                    // echo "<br />";
                    //print_r($model);
                    $name = $model['username'];

                   // echo "<br />";
                   // echo $name;die();
                    $pwd = md5($model['password']);
                    // echo "<br />";
                    //print_r($model);die();
                    Yii::app()->session['username']=$name;
                    Yii::app()->session['password']=$pwd;
                    // echo Yii::app()->session['var'];

                    $auth = WxAdmin::model()->find("username = '$name' and password = '$pwd'");

                    // print_r($auth);die();
                    //echo $auth['auth'];
                    $id = $auth['auth'];
                    $group = WxGroup::model()->find("id = '$id'");
                    //echo $group['auth'];
                    $arr = explode(',',$group['auth']);
                    //print_r($arr);
                    //echo $arr[0];

                    $url = WxGuide::model()->find("id = '$arr[0]'");
                    // print_r($url);
                    // echo $url['url'];
                    // die();
                    $aa = $url['url'];
                    //echo $aa;die();
                    $ids = $url['id'];
                    //echo $ids;die();
                    $this->redirect($this->createUrl($aa,array('mid'=>$ids,'nid'=>0,'id'=>0,'pid'=>0)));
                    //$this->redirect("/wechat/test/index");
                    //echo "<script>window.location.href='http://phpweb100.com/wechat/test/index'</script>";
                    //$this->redirect($this->createUrl('/wechat/test/index',array('mid'=>$ids,'nid'=>0,'id'=>0,'pid'=>0)));
                   // $this->redirect(array('/wechat/test/index',array('mid'=>$ids,'nid'=>0,'id'=>0,'pid'=>0)));
//                    $this->redirect($this->createUrl('/admin/guide/default',array('mid'=>9,'nid'=>0,'id'=>0,'pid'=>0)));
                }
                throw new ExceptionEx('登陆失败');
                //$this->redirect("/wechat/test/index");
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
        $this->RecordOperatingLog(MSG::OP_LOG_LOGOUT,$this->getWxAdmin());
        Yii::app()->user->logout();
        $this->redirect($this->createUrl('/wechat/default/login'));
    }
}
