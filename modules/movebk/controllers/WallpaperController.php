<?php

/**
 * Created by PhpStorm.
 * User:
 * Date: 2016/05/13
 * Time: 11:48
 */
class WallpaperController extends MController{

    public function actionIndex(){
        $id=$_GET['nid'];
        $type = isset($_GET['type']) ? $_GET['type'] : '';
        if(!empty($id) && empty($type)){

            $province = Province::model()->findAll("1=1 order by id desc");

            $provinceCode = isset($provinceCode) ? $provinceCode : '';
            $city = isset($city) ? $city : '';
            $cityCode = isset($cityCode) ? $cityCode : '';

        $page = 20;
        $data = $this->getPageInfo($page);
        $criteria = new CDbCriteria();
        $criteria->select = '*';
        $count = MvWallpaper::model()->count($criteria);
        $criteria->offset = $data['start'];
        $criteria->limit = $data['limit'];
        $criteria->order = 'addTime desc';
        $list = MvWallpaper::model()->findAll($criteria);
        $url = $this->createUrl($this->action->id);
        $pagination = $this->renderPagination($url,$count,$page,$data['currentPage']);
        $this->render('index',array('list'=>$list,'page'=>$pagination,'province'=>$province,'provinceCode'=>$provinceCode,'city'=>$city,'cityCode'=>$cityCode));
        }else{
            $provinceCode = isset($_GET['provinceCode']) ? $_GET['provinceCode'] : '0';
            $cityCode = isset($_GET['cityCode']) ? $_GET['cityCode'] : '0';

            $province = Province::model()->findAll("1=1 order by id desc");
            $city = isset($city) ? $city : '';

            $page = 20;
            $data = $this->getPageInfo($page);
            $criteria = new CDbCriteria();
            $criteria->select = '*';
            $count = MvWallpaper::model()->count($criteria);

            $criteria->addCondition("province=".$provinceCode);
            $criteria->addCondition("city=".$cityCode);
            $criteria->order = 'addTime desc';
            $list = MvWallpaper::model()->findAll($criteria);
            $url = $this->createUrl($this->action->id);
            $pagination = $this->renderPagination($url,$count,$page,$data['currentPage']);
           // print_r($list);

            $this->render('index',array('list'=>$list,'page'=>$pagination,'province'=>$province,'provinceCode'=>$provinceCode,'city'=>$city,'cityCode'=>$cityCode));
        }


    }

    public function actionAdd(){
        try{
            if(!empty($_GET['id'])){
                $paper = MvWallpaper::model()->findByPk($_GET['id']);

                $id = $_GET['id'];
                $provinceCode = array_map(create_function('$record','return $record->attributes;'),MvWallpaper::model()->findAll("id = $id"));
                //   print_r($provinceCode);die();
                if(!empty($provinceCode)){
                    $p = $provinceCode[0]['province'];//查询出来的省份编码
                    $c = $provinceCode[0]['city'];//查询出来的城市编码

                    $cityCode = array_map(create_function('$record','return $record->attributes;'),City::model()->findAll("provinceId = $p"));
                }

            }else{
                $paper = new MvWallpaper();
                $paper->addTime = time();
            }

            if(!empty($_POST)){

                $sheng = explode('_',$_POST['province']);
                $paper -> province = trim($sheng[0]);
                $shi = explode('_',$_POST['city']);
                $paper -> city     = trim($shi[0]);
                $paper ->title = $_POST['title'];


                if(!empty($_FILES['pic']['tmp_name'])){
                    $filename = 'pic';
                    $path = $this->up($filename);
                    Common::synchroPic($path);
                    //$paper ->pic    = 'http://' . $_SERVER['HTTP_HOST'] . '/file/' . $path;
                    //$paper ->pic    = 'http://192.168.1.109/file/' . $path;
                    $paper->pic = 'http://portalpic.itv.cmvideo.cn:8083/file/'.$path;
                }
                if(!$paper->save()){
                    LogWriter::logModelSaveError($paper,__METHOD__,$paper->attributes);
                    throw new ExceptionEx('信息保存失败');
                }

                $this->PopMsg('保存成功');
                $this->redirect($this->get_url('wallpaper','index'));
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

        $this->render('add',array('wallpaper'=>$paper,'province'=>$province,'provinceCode'=>$p,'city'=>$cityCode,'cityCode'=>$c));
    }


    public function actionDel(){
        if(empty($_POST['id'])) $this->die_json(array('code'=>404,'msg'=>'参数不能为空'));
        $del = MvWallpaper::model()->deleteByPk($_POST['id']);
        if(!$del){
            $this->die_json(array('code'=>404,'msg'=>'删除失败'));
        }
      //  $title = count($del) > 1 ? '' : $del[0]['name'];
        //$this->RecordOperatingLog(MSG::MYSQL_EDIT_DEL,$del,'权限组',$title);
        $this->die_json(array('code'=>404,'msg'=>'删除成功'));
    }

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
