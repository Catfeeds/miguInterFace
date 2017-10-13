<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/10 0010
 * Time: 13:18
 */
class NoticeController extends AController{
    public function actionIndex(){
        $page = 20;
        $data = $this->getPageInfo($page);
        $notice = NoticeManager::getNoticeList($data);
        $url = $this->createUrl($this->action->id);
        $pagination = $this->renderPagination($url,$notice['count'],$page,$data['currentPage']);
        $this->render('index',array('list'=>$notice['list'],'page'=>$pagination));
    }

    public function actionAdd(){
        try{
            if(!empty($_GET['bid']) && is_numeric($_GET['bid'])){
                $notice = Notice::model()->findByPk($_GET['bid']);

                $id = isset($_GET['bid']) ? $_GET['bid'] : '';
                $provinceCode = array_map(create_function('$record','return $record->attributes;'),Notice::model()->findAll("id = $id"));

                $p = $provinceCode[0]['province'];//查询出来的省份编码
                $c = $provinceCode[0]['city'];//查询出来的城市编码

                $cityCode = array_map(create_function('$record','return $record->attributes;'),City::model()->findAll("provinceId = $p"));


            }else{
                $notice = new Notice();
            }
            if(!empty($_POST)){
                if(empty($_POST['notice']))  throw new ExceptionEx('公告内容不能为空！');
                //if(empty($_POST['province'])) throw new ExceptionEx('请选择省份！');
                if(empty($_POST['sTime'])) throw new ExceptionEx('请选择开始时间');
                if(empty($_POST['eTime'])) throw new ExceptionEx('请选择结束时间');
                if(strtotime($_POST['sTime']) > strtotime($_POST['eTime'])){
                    throw new ExceptionEx('结束时间必须大于、等于开始时间!');
                }

                $notice -> notice   = trim($_POST['notice']);
                
                if(empty($_POST['province'])){
                    $notice -> province = '0';
                }else{
                    $sheng = explode('_',$_POST['province']);
                    $notice -> province = trim($sheng[0]);
                }

                if(empty($_POST['city'])){
                    $notice -> city = '0';
                }else{
                    $shi = explode('_',$_POST['city']);
                    $notice -> city     = trim($shi[0]);
                }

                $notice -> sTime    = strtotime($_POST['sTime']);
                $notice -> eTime    = strtotime($_POST['eTime']);
                $notice -> cp = '1';
                $notice -> delFlag = '0';
                $notice -> cTime    = time();


                if(!$notice->save()){
                    LogWriter::logModelSaveError($notice,__METHOD__,$notice->attributes);
                    throw new ExceptionEx('保存失败!');
                }
                if(!empty($_GET['id'])){
                    $this->RecordOperatingLog(MSG::MYSQL_EDIT_EDIT,$notice,'公告',$notice->notice);
                }else{
                    $this->RecordOperatingLog(MSG::MYSQL_EDIT_ADD,$notice,'公告',$notice->notice);
                }

                $this->redirect($this->get_url('notice','index'));
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

        $this->render('add',array('notice'=>$notice,'province'=>$province,'provinceCode'=>$p,'city'=>$cityCode,'cityCode'=>$c));
    }

    public function actionDel(){
        if(empty($_POST['id']) || !is_numeric($_POST['id'])){
            $this->die_json(array('code'=>404,'msg'=>'参数不能为空'));
        }
        $notice = Notice::model()->deleteByPk($_POST['id']);
        if(!$notice){
            $this->die_json(array('code'=>404,'msg'=>'删除失败'));
        }
        $this->RecordOperatingLog(MSG::MYSQL_EDIT_DEL,$notice,'公告',count($notice) > 1?'':$notice[0]['notice']);
        $this->die_json(array('code'=>200,'msg'=>'删除成功'));
    }

    //读取出符合条件的所有的市
    public function actionGetcity(){
        $id=$_GET['id'];
        $city = array_map(create_function('$record','return $record->attributes;'),City::model()->findAll("provinceId = '$id' order by id desc"));

        echo json_encode($city);
    }
}