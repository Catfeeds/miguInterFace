<?php

/**
 * Created by PhpStorm.
 * User: xiangl
 * Date: 2015/8/19 0019
 * Time: 11:48
 */
class ReportController extends MController{
    public function actionDefault(){
        $this->render('default');
    }



    public function actionContentNum()
    {
        $province = Province::model()->findAll("1=1 order by id desc");
        $p = isset($p) ? $p : '';
        $cityCode = isset($cityCode) ? $cityCode : '';
        $c = isset($c) ? $c : '';
        $this->render('contentnum',array('province'=>$province,'provinceCode'=>$p,'city'=>$cityCode,'cityCode'=>$c));
    }

    public function actionContentData()
    {
        $first = strtotime($_REQUEST['first']);
        $end = strtotime($_REQUEST['end']);
        if(empty($first) && empty($end)){
            $last = date("Ymd",strtotime("-1 day"));
            $first= strtotime($last);
            $now = date("Ymd",strtotime("0 day"));
            $end = strtotime($now)-1;
        }
        $keyword = $_REQUEST['keyword'];
        $p = $_REQUEST['page'];
        $province=$_REQUEST['province'];
        $city=$_REQUEST['city'];
        $usergroup = $_REQUEST['usergroup'];
        $epgcode = $_REQUEST['epgcode'];
        if(empty($usergroup)){
            $usergroup = 0;
        }
        if(empty($epgcode)){
            $epgcode = 0;
        }
        $data = ActiveOnepicManager::getClick($keyword,$first,$end,$p,$province,$city,$usergroup,$epgcode);
        $provincelist = ActiveOnepicManager::getProvinces();
        $citylist = ActiveOnepicManager::getCitys();
        foreach($data['res'] as $k=>$v){
            foreach($provincelist as $key=>$val){
                if($val['provinceCode']==$v['province']){
                    $res['res'][$k]=$v;
                    $res['res'][$k]['province']=$val['provinceName'];
                }
            }
        }
        foreach($res['res'] as $k=>$v){
            $cdata['res'][$k]=$v;
            $cdata['res'][$k]['city']='';
            foreach($citylist as $key=>$val){
                if($val['cityCode']==$v['city']){
                    $cdata['res'][$k]=$v;
                    $cdata['res'][$k]['city']=$val['cityName'];
                }
            }
        }
        $list['list'] = [];
        foreach ($cdata['res'] as $key => $v) {

            if($v['epg'] == '1'){
                $v['epg'] = '首页';
            }else if($v['epg'] == '2'){
                $v['epg'] = '影视';
            }else if($v['epg'] == '3'){
                $v['epg'] = '教育';
            }else if($v['epg'] == '4'){
                $v['epg'] = '游戏';
            }else if($v['epg'] == '5'){
                $v['epg'] = '应用';
            }else if($v['epg'] == '6'){
                $v['epg'] = '咪咕专区';
            }else if($v['epg'] == '7'){
                $v['epg'] = '综艺专区';
            }else if($v['epg'] == '8'){
                $v['epg'] = '华数专区';
            }else if($v['epg'] == '9'){
                $v['epg'] = '咪咕极光';
            }else if($v['epg'] == '10'){
                $v['epg'] = '咪咕现场秀';
            }else if($v['epg'] == '11'){
                $v['epg'] = '咪咕精彩';
            }else if($v['epg'] == '12'){
                $v['epg'] = '甘肃专区';
            }else if($v['epg'] == '13'){
                $v['epg'] = '音乐';
            }else if($v['epg'] == '14'){
                $v['epg'] = '体育';
            }else if($v['epg'] == '15'){
                $v['epg'] = '南传专区';
            }else if($v['epg']=='16'){
                $v['epg']='购物';
            }else if($v['epg']== '17'){
                $v['epg'] = '推荐';
            }else if($v['epg'] == '18'){
                $v['epg'] = '电视剧集';
            }else if($v['epg'] == '19'){
                $v['epg'] ='电影';
            }else if($v['epg'] == '20'){
                $v['epg'] = '少儿';
            } else if($v['epg'] == '21'){
                $v['epg'] = '综艺';
            } else if($v['epg'] == '22'){
                $v['epg'] = '田园阳光';
            }else if($v['epg'] == '23'){
		$v['epg'] = '百视通区';
            }else if($v['epg']=='24'){
                $v['epg']='华推';
            }else if($v['epg']=='25'){
                $v['epg']='华电视剧';
            }else if($v['epg']=='26'){
                $v['epg']='华影';
            }else if($v['epg']=='27'){
                $v['epg']='华少';
            }else if($v['epg']=='28'){
                $v['epg']='华综';
            }else if($v['epg']=='29'){
                $v['epg']='百推';
            }else if($v['epg']=='30'){
                $v['epg']='百电视剧';
            }else if($v['epg']=='31'){
                $v['epg']='百影';
            }else if($v['epg']=='32'){
                $v['epg']='百少';
            }else if($v['epg']=='33'){
                $v['epg']='百综';
            }else if($v['epg']=='34'){
                $v['epg']='未推';
            }else if($v['epg']=='35'){
                $v['epg']='未电视剧';
            }else if($v['epg']=='36'){
                $v['epg']='未影';
            }else if($v['epg']=='37'){
                $v['epg']='未少';
            }else if($v['epg']=='38'){
                $v['epg']='未综';
            }else if($v['epg']=='39'){
                $v['epg']='南推';
            }else if($v['epg']=='40'){
                $v['epg']='南电视剧';
            }else if($v['epg']=='41'){
                $v['epg']='南影';
            }else if($v['epg']=='42'){
                $v['epg']='南少';
            }else if($v['epg']=='43'){
                $v['epg']='南综';
            }else if($v['epg']=='44'){
                $v['epg']='未来专区';
            }else if($v['epg']=='45'){
                $v['epg']='美丽乡村';
            }else if($v['epg']=='46'){
                $v['epg']='百直';
            }else if($v['epg']=='47'){
                $v['epg']='芒推';
            }else if($v['epg']=='48'){
                $v['epg']='国推';
            }else if($v['epg']=='49'){
		$v['epg']='华看电视';	
	    }else if($v['epg']=='50'){
                $v['epg']='芒果专区';
            }else if($v['epg']=='51'){
                $v['epg']='国广专区';
            }else if($v['epg']=='52'){
		$v['epg']='芒少';
	    }else if($v['epg']=='53'){
                $v['epg']='芒电视剧';
            }else if($v['epg']=='54'){
                $v['epg']='芒影';
            }else if($v['epg']=='55'){
                $v['epg']='芒综';
            }else if($v['epg']=='56'){
		$v['epg']='咪咕游戏';
	    }







            
            if($v['cp'] == 1){
                $v['cp'] =  '华数';
            }else if($v['cp'] == 2){
                $v['cp'] = '百视通';
            }else if($v['cp'] == 3){
                $v['cp'] = '未来电视';
            }else if($v['cp']== 4){
                $v['cp']='南传';
            }else if($v['cp']== 5){
                $v['cp']='芒果';
            }else if($v['cp']== 6){
                $v['cp']='国广';
            }else if($v['cp']== 7){
                $v['cp']='银河';
            }

            $list['list'][] = $v;
        }
        $list['count'] = $data['count'];
        // var_dump($list);die;
        echo json_encode($list);

    }

    public function actionOut(){
        $first = strtotime($_REQUEST['first']);
        $end = strtotime($_REQUEST['end']);
        if(empty($first) && empty($end)){
            $last = date("Ymd",strtotime("-1 day"));
            $first= strtotime($last);
            $now = date("Ymd",strtotime("0 day"));
            $end = strtotime($now)-1;
        }
        $keyword = $_REQUEST['keyword'];
        $province=$_REQUEST['province'];
        $city=$_REQUEST['city'];
        $usergroup = $_REQUEST['usergroup'];
        $epgcode = $_REQUEST['epgcode'];
        if(empty($usergroup)){
            $usergroup = 0;
        }
        if(empty($epgcode)){
            $epgcode = 0;
        }
        $data = ActiveOnepicManager::getClicks($keyword,$first,$end,$province,$city,$usergroup,$epgcode);
        $provincelist = ActiveOnepicManager::getProvinces();
        $citylist = ActiveOnepicManager::getCitys();
        foreach($data['res'] as $k=>$v){
            foreach($provincelist as $key=>$val){
                if($val['provinceCode']==$v['province']){
                    $res['res'][$k]=$v;
                    $res['res'][$k]['province']=$val['provinceName'];
                }
            }
        }
        foreach($res['res'] as $k=>$v){
            $cdata['res'][$k]=$v;
            $cdata['res'][$k]['city']='';
            foreach($citylist as $key=>$val){
                if($val['cityCode']==$v['city']){
                    $cdata['res'][$k]=$v;
                    $cdata['res'][$k]['city']=$val['cityName'];
                }
            }
        }
        $arr = [];
        foreach ($cdata['res'] as $key => $v) {

            if($v['epg'] == '1'){
                $v['epg'] = '首页';
            }else if($v['epg'] == '2'){
                $v['epg'] = '影视';
            }else if($v['epg'] == '3'){
                $v['epg'] = '教育';
            }else if($v['epg'] == '4'){
                $v['epg'] = '游戏';
            }else if($v['epg'] == '5'){
                $v['epg'] = '应用';
            }else if($v['epg'] == '6'){
                $v['epg'] = '咪咕专区';
            }else if($v['epg'] == '7'){
                $v['epg'] = '综艺专区';
            }else if($v['epg'] == '8'){
                $v['epg'] = '华数专区';
            }else if($v['epg'] == '9'){
                $v['epg'] = '咪咕极光';
            }else if($v['epg'] == '10'){
                $v['epg'] = '咪咕现场秀';
            }else if($v['epg'] == '11'){
                $v['epg'] = '咪咕精彩';
            }else if($v['epg'] == '12'){
                $v['epg'] = '甘肃专区';
            }else if($v['epg'] == '13'){
                $v['epg'] = '音乐';
            }else if($v['epg'] == '14'){
                $v['epg'] = '体育';
            }else if($v['epg'] == '15'){
                $v['epg'] = '南传专区';
            }else if($v['epg']=='16'){
                $v['epg']='购物';
            }else if($v['epg']== '17'){
                $v['epg'] = '推荐';
            }else if($v['epg'] == '18'){
                $v['epg'] = '电视剧集';
            }else if($v['epg'] == '19'){
                $v['epg'] ='电影';
            }else if($v['epg'] == '20'){
                $v['epg'] = '少儿';
            } else if($v['epg'] == '21'){
                $v['epg'] = '综艺';
            } else if($v['epg'] == '22'){
                $v['epg'] = '田园阳光';
            }else if($v['epg'] == '23'){
		$v['epg'] = '百视通区';
            }else if($v['epg']=='24'){
                $v['epg']='华推';
            }else if($v['epg']=='25'){
                $v['epg']='华电视剧';
            }else if($v['epg']=='26'){
                $v['epg']='华影';
            }else if($v['epg']=='27'){
                $v['epg']='华少';
            }else if($v['epg']=='28'){
                $v['epg']='华综';
            }else if($v['epg']=='29'){
                $v['epg']='百推';
            }else if($v['epg']=='30'){
                $v['epg']='百电视剧';
            }else if($v['epg']=='31'){
                $v['epg']='百影';
            }else if($v['epg']=='32'){
                $v['epg']='百少';
            }else if($v['epg']=='33'){
                $v['epg']='百综';
            }else if($v['epg']=='34'){
                $v['epg']='未推';
            }else if($v['epg']=='35'){
                $v['epg']='未电视剧';
            }else if($v['epg']=='36'){
                $v['epg']='未影';
            }else if($v['epg']=='37'){
                $v['epg']='未少';
            }else if($v['epg']=='38'){
                $v['epg']='未综';
            }else if($v['epg']=='39'){
                $v['epg']='南推';
            }else if($v['epg']=='40'){
                $v['epg']='南电视剧';
            }else if($v['epg']=='41'){
                $v['epg']='南影';
            }else if($v['epg']=='42'){
                $v['epg']='南少';
            }else if($v['epg']=='43'){
                $v['epg']='南综';
            }else if($v['epg']=='44'){
                $v['epg']='未来专区';
            }else if($v['epg']=='45'){
                $v['epg']='美丽乡村';
           }else if($v['epg']=='46'){
                $v['epg']='百直';
            }else if($v['epg']=='47'){
                $v['epg']='芒推';
            }else if($v['epg']=='48'){
                $v['epg']='国推';
            }else if($v['epg']=='49'){
		$v['epg']='华看电视';
	    }else if($v['epg']=='50'){
                $v['epg']='芒果专区';
            }else if($v['epg']=='51'){
                $v['epg']='国广专区';
            }else if($v['epg']=='52'){
                $v['epg']='芒少';
            }else if($v['epg']=='53'){
                $v['epg']='芒电视剧';
            }else if($v['epg']=='54'){
                $v['epg']='芒影';
            }else if($v['epg']=='55'){
                $v['epg']='芒综';
            }else if($v['epg']=='56'){
                $v['epg']='咪咕游戏';
            }





            if($v['cp'] == 1){
                $v['cp'] =  '华数';
            }else if($v['cp'] == 2){
                $v['cp'] = '百视通';
            }else if($v['cp'] == 3){
                $v['cp'] = '未来电视';
            }else if($v['cp']== 4){
                $v['cp']='南传';
            }else if($v['cp']== 5){
                $v['cp']='芒果';
            }else if($v['cp']== 6){
                $v['cp']='国广';
            }else if($v['cp']== 7){
                $v['cp']='银河';
            }


            $arr[] = $v;
        }
        //var_dump($list);die;
        $result = $this->Excel($arr);
    }

    public function Excel($arr){
        Yii::$enableIncludePath = false;
        Yii::import('application.extensions.PHPExcel.PHPExcel', 1);
        $fileName=date("Ymdhis", time());
        //引入PHPExcel库文件（路径根据自己情况）
        //include 'PHPExcel.php';
        //创建对象
        $excel = new PHPExcel();

        //Excel表格式,这里简略写了8列
        $letter = array('A','B','C','D','E','F','G','H');
        //表头数组
        $tableheader = array('省','市','牌照方','导航名称','海报标题','第一次点击时间','统计时间','点击量');
        //填充表头信息
        for($i = 0;$i < count($tableheader);$i++) {
            $excel->getActiveSheet()->setCellValue("$letter[$i]1","$tableheader[$i]");
        }

        // var_dump($arr);die;
        //填充表格信息
        for ($i = 2;$i <= count($arr) + 1;$i++) {
            $j = 0;
            foreach ($arr[$i - 2] as $key=>$value) {
                $excel->getActiveSheet()->setCellValue("$letter[$j]$i","$value");
                $j++;
            }
        }
        //创建Excel输入对象
        ob_end_clean();
        $write = new PHPExcel_Writer_Excel5($excel);
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:charset/UTF-8");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header('Content-Disposition:attachment;filename="'.$fileName.'.xls"');
        header("Content-Transfer-Encoding:binary");
        $write->save('php://output');
    }

    public function actionNums(){
        $province = Province::model()->findAll("1=1 order by id desc");
        $p = isset($p) ? $p : '';
        $cityCode = isset($cityCode) ? $cityCode : '';
        $c = isset($c) ? $c : '';
        $this->render('nums',array('province'=>$province,'provinceCode'=>$p,'city'=>$cityCode,'cityCode'=>$c));
    }

    public function actionContentDatas()
    {
        $first = strtotime($_REQUEST['first']);
        $end = strtotime($_REQUEST['end']);
        if(empty($first) && empty($end)){
            $last = date("Ymd",strtotime("-1 day"));
            $first= strtotime($last);
            $now = date("Ymd",strtotime("0 day"));
            $end = strtotime($now)-1;
        }
        $keyword = $_REQUEST['keyword'];
        $p = $_REQUEST['page'];
        $province=$_REQUEST['province'];
        $city=$_REQUEST['city'];
        $usergroup = $_REQUEST['usergroup'];
        $epgcode = $_REQUEST['epgcode'];
        if(empty($usergroup)){
            $usergroup = 0;
        }
        if(empty($epgcode)){
            $epgcode = 0;
        }
        $data = ActiveTwopicManager::getClick($keyword,$first,$end,$p,$province,$city,$usergroup,$epgcode);
        //var_dump($data);die;
        $provincelist = ActiveTwopicManager::getProvinces();
        $citylist = ActiveTwopicManager::getCitys();
        foreach($data['res'] as $k=>$v){
            foreach($provincelist as $key=>$val){
                if($val['provinceCode']==$v['province']){
                    $res['res'][$k]=$v;
                    $res['res'][$k]['province']=$val['provinceName'];
                }
            }
        }
        foreach($res['res'] as $k=>$v){
            $cdata['res'][$k]=$v;
            $cdata['res'][$k]['city']='';
            foreach($citylist as $key=>$val){
                if($val['cityCode']==$v['city']){
                    $cdata['res'][$k]=$v;
                    $cdata['res'][$k]['city']=$val['cityName'];
                }
            }
        }
        $list['list'] = [];
        foreach ($cdata['res'] as $key => $v) {

            if($v['epg'] == '1'){
                $v['epg'] = '首页';
            }else if($v['epg'] == '2'){
                $v['epg'] = '影视';
            }else if($v['epg'] == '3'){
                $v['epg'] = '教育';
            }else if($v['epg'] == '4'){
                $v['epg'] = '游戏';
            }else if($v['epg'] == '5'){
                $v['epg'] = '应用';
            }else if($v['epg'] == '6'){
                $v['epg'] = '咪咕专区';
            }else if($v['epg'] == '7'){
                $v['epg'] = '综艺专区';
            }else if($v['epg'] == '8'){
                $v['epg'] = '华数专区';
            }else if($v['epg'] == '9'){
                $v['epg'] = '咪咕极光';
            }else if($v['epg'] == '10'){
                $v['epg'] = '咪咕现场秀';
            }else if($v['epg'] == '11'){
                $v['epg'] = '咪咕精彩';
            }else if($v['epg'] == '12'){
                $v['epg'] = '甘肃专区';
            }else if($v['epg'] == '13'){
                $v['epg'] = '音乐';
            }else if($v['epg'] == '14'){
                $v['epg'] = '体育';
            }else if($v['epg'] == '15'){
                $v['epg'] = '南传专区';
            }else if($v['epg'] == '16'){
                $v['epg'] = '少儿';
            }else if($v['epg']== '17'){
                $v['epg'] = '推荐';
            }else if($v['epg'] == '18'){
                $v['epg'] = '电视剧集';
            }else if($v['epg'] == '19'){
                $v['epg'] ='电影';
            }else if($v['epg'] == '20'){
                $v['epg'] = '少儿';
            } else if($v['epg'] == '21'){
                $v['epg'] = '综艺';
            } else if($v['epg'] == '22'){
                $v['epg'] = '田园阳光';
            }else if($v['epg'] == '23'){
                $v['epg'] = '百视通区';
            }else if($v['epg']=='24'){
                $v['epg']='华推';
            }else if($v['epg']=='25'){
                $v['epg']='华电视剧';
            }else if($v['epg']=='26'){
                $v['epg']='华影';
            }else if($v['epg']=='27'){
                $v['epg']='华少';
            }else if($v['epg']=='28'){
                $v['epg']='华综';
            }else if($v['epg']=='29'){
                $v['epg']='百推';
            }else if($v['epg']=='30'){
                $v['epg']='百电视剧';
            }else if($v['epg']=='31'){
                $v['epg']='百影';
            }else if($v['epg']=='32'){
                $v['epg']='百少';
            }else if($v['epg']=='33'){
                $v['epg']='百综';
            }else if($v['epg']=='34'){
                $v['epg']='未推';
            }else if($v['epg']=='35'){
                $v['epg']='未电视剧';
            }else if($v['epg']=='36'){
                $v['epg']='未影';
            }else if($v['epg']=='37'){
                $v['epg']='未少';
            }else if($v['epg']=='38'){
                $v['epg']='未综';
            }else if($v['epg']=='39'){
                $v['epg']='南推';
            }else if($v['epg']=='40'){
                $v['epg']='南电视剧';
            }else if($v['epg']=='41'){
                $v['epg']='南影';
            }else if($v['epg']=='42'){
                $v['epg']='南少';
            }else if($v['epg']=='43'){
                $v['epg']='南综';
            }else if($v['epg']=='44'){
                $v['epg']='未来专区';
            }else if($v['epg']=='45'){
                $v['epg']='美丽乡村';
           }else if($v['epg']=='46'){
                $v['epg']='百直';
            }else if($v['epg']=='47'){
                $v['epg']='芒推';
            }else if($v['epg']=='48'){
                $v['epg']='国推';
            }else if($v['epg']=='49'){
		$v['epg']='华看电视';
	    }else if($v['epg']=='50'){
                $v['epg']='芒果专区';
            }else if($v['epg']=='51'){
                $v['epg']='国广专区';
            }else if($v['epg']=='52'){
                $v['epg']='芒少';
            }else if($v['epg']=='53'){
                $v['epg']='芒电视剧';
            }else if($v['epg']=='54'){
                $v['epg']='芒影';
            }else if($v['epg']=='55'){
                $v['epg']='芒综';
            }else if($v['epg']=='56'){
                $v['epg']='咪咕游戏';
            }






            if($v['cp'] == 1){
                $v['cp'] =  '华数';
            }else if($v['cp'] == 2){
                $v['cp'] = '百视通';
            }else if($v['cp'] == 3){
                $v['cp'] = '未来电视';
            }else if($v['cp']== 4){
                $v['cp']='南传';
            }else if($v['cp']== 5){
                $v['cp']='芒果';
            }else if($v['cp']== 6){
                $v['cp']='国广';
            }else if($v['cp']== 7){
                $v['cp']='银河';
            }


            $list['list'][] = $v;
        }
        $list['count'] = $data['count'];
        // var_dump($list);die;
        echo json_encode($list);

    }

    public function actionOuts(){
        $first = strtotime($_REQUEST['first']);
        $end = strtotime($_REQUEST['end']);
        if(empty($first) && empty($end)){
            $last = date("Ymd",strtotime("-1 day"));
            $first= strtotime($last);
            $now = date("Ymd",strtotime("0 day"));
            $end = strtotime($now)-1;
        }
        $keyword = $_REQUEST['keyword'];
        $province=$_REQUEST['province'];
        $city=$_REQUEST['city'];
        $usergroup = $_REQUEST['usergroup'];
        $epgcode = $_REQUEST['epgcode'];
        if(empty($usergroup)){
            $usergroup = 0;
        }
        if(empty($epgcode)){
            $epgcode = 0;
        }
        $data = ActiveTwopicManager::getClicks($keyword,$first,$end,$province,$city,$usergroup,$epgcode);
        $provincelist = ActiveTwopicManager::getProvinces();
        $citylist = ActiveTwopicManager::getCitys();
        foreach($data['res'] as $k=>$v){
            foreach($provincelist as $key=>$val){
                if($val['provinceCode']==$v['province']){
                    $res['res'][$k]=$v;
                    $res['res'][$k]['province']=$val['provinceName'];
                }
            }
        }
        foreach($res['res'] as $k=>$v){
            $cdata['res'][$k]=$v;
            $cdata['res'][$k]['city']='';
            foreach($citylist as $key=>$val){
                if($val['cityCode']==$v['city']){
                    $cdata['res'][$k]=$v;
                    $cdata['res'][$k]['city']=$val['cityName'];
                }
            }
        }
        $arr = [];
        foreach ($cdata['res'] as $key => $v) {

            if($v['epg'] == '1'){
                $v['epg'] = '首页';
            }else if($v['epg'] == '2'){
                $v['epg'] = '影视';
            }else if($v['epg'] == '3'){
                $v['epg'] = '教育';
            }else if($v['epg'] == '4'){
                $v['epg'] = '游戏';
            }else if($v['epg'] == '5'){
                $v['epg'] = '应用';
            }else if($v['epg'] == '6'){
                $v['epg'] = '咪咕专区';
            }else if($v['epg'] == '7'){
                $v['epg'] = '综艺专区';
            }else if($v['epg'] == '8'){
                $v['epg'] = '华数专区';
            }else if($v['epg'] == '9'){
                $v['epg'] = '咪咕极光';
            }else if($v['epg'] == '10'){
                $v['epg'] = '咪咕现场秀';
            }else if($v['epg'] == '11'){
                $v['epg'] = '咪咕精彩';
            }else if($v['epg'] == '12'){
                $v['epg'] = '甘肃专区';
            }else if($v['epg'] == '13'){
                $v['epg'] = '音乐';
            }else if($v['epg'] == '14'){
                $v['epg'] = '体育';
            }else if($v['epg'] == '15'){
                $v['epg'] = '南传专区';
            }else if($v['epg'] == '16'){
                $v['epg'] = '少儿';
            }else if($v['epg']== '17'){
                $v['epg'] = '推荐';
            }else if($v['epg'] == '18'){
                $v['epg'] = '电视剧集';
            }else if($v['epg'] == '19'){
                $v['epg'] ='电影';
            }else if($v['epg'] == '20'){
                $v['epg'] = '少儿';
            } else if($v['epg'] == '21'){
                $v['epg'] = '综艺';
            } else if($v['epg'] == '22'){
                $v['epg'] = '田园阳光';
            }else if($v['epg'] == '23'){
                $v['epg'] = '百视通区';
            }else if($v['epg']=='24'){
                $v['epg']='华推';
            }else if($v['epg']=='25'){
                $v['epg']='华电视剧';
            }else if($v['epg']=='26'){
                $v['epg']='华影';
            }else if($v['epg']=='27'){
                $v['epg']='华少';
            }else if($v['epg']=='28'){
                $v['epg']='华综';
            }else if($v['epg']=='29'){
                $v['epg']='百推';
            }else if($v['epg']=='30'){
                $v['epg']='百电视剧';
            }else if($v['epg']=='31'){
                $v['epg']='百影';
            }else if($v['epg']=='32'){
                $v['epg']='百少';
            }else if($v['epg']=='33'){
                $v['epg']='百综';
            }else if($v['epg']=='34'){
                $v['epg']='未推';
            }else if($v['epg']=='35'){
                $v['epg']='未电视剧';
            }else if($v['epg']=='36'){
                $v['epg']='未影';
            }else if($v['epg']=='37'){
                $v['epg']='未少';
            }else if($v['epg']=='38'){
                $v['epg']='未综';
            }else if($v['epg']=='39'){
                $v['epg']='南推';
            }else if($v['epg']=='40'){
                $v['epg']='南电视剧';
            }else if($v['epg']=='41'){
                $v['epg']='南影';
            }else if($v['epg']=='42'){
                $v['epg']='南少';
            }else if($v['epg']=='43'){
                $v['epg']='南综';
            }else if($v['epg']=='44'){
                $v['epg']='未来专区';
            }else if($v['epg']=='45'){
                $v['epg']='美丽乡村';
            }else if($v['epg']=='46'){
                $v['epg']='百直';
            }else if($v['epg']=='47'){
                $v['epg']='芒推';
            }else if($v['epg']=='48'){
                $v['epg']='国推';
            }else if($v['epg']=='49'){
		$v['epg']='华看电视';	
	    }else if($v['epg']=='50'){
                $v['epg']='芒果专区';
            }else if($v['epg']=='51'){
                $v['epg']='国广专区';
            }else if($v['epg']=='52'){
                $v['epg']='芒少';
            }else if($v['epg']=='53'){
                $v['epg']='芒电视剧';
            }else if($v['epg']=='54'){
                $v['epg']='芒影';
            }else if($v['epg']=='55'){
                $v['epg']='芒综';
            }else if($v['epg']=='56'){
                $v['epg']='咪咕游戏';
            }





            if($v['cp'] == 1){
                $v['cp'] =  '华数';
            }else if($v['cp'] == 2){
                $v['cp'] = '百视通';
            }else if($v['cp'] == 3){
                $v['cp'] = '未来电视';
            }else if($v['cp']== 4){
                $v['cp']='南传';
            }else if($v['cp']== 5){
                $v['cp']='芒果';
            }else if($v['cp']== 6){
                $v['cp']='国广';
            }else if($v['cp']== 7){
                $v['cp']='银河';
            }


            $arr[] = $v;
        }
        //var_dump($list);die;
        $result = $this->Excels($arr);
    }

    public function Excels($arr){
        Yii::$enableIncludePath = false;
        Yii::import('application.extensions.PHPExcel.PHPExcel', 1);
        $fileName=date("Ymdhis", time());
        //引入PHPExcel库文件（路径根据自己情况）
        //include 'PHPExcel.php';
        //创建对象
        $excel = new PHPExcel();

        //Excel表格式,这里简略写了8列
        $letter = array('A','B','C','D','E','F','G','H','I');
        //表头数组
        $tableheader = array('省','市','牌照方','导航编号','导航名称','海报标题','第一次点击时间','统计日期','点击量');
        //填充表头信息
        for($i = 0;$i < count($tableheader);$i++) {
            $excel->getActiveSheet()->setCellValue("$letter[$i]1","$tableheader[$i]");
        }

        // var_dump($arr);die;
        //填充表格信息
        for ($i = 2;$i <= count($arr) + 1;$i++) {
            $j = 0;
            foreach ($arr[$i - 2] as $key=>$value) {
                $excel->getActiveSheet()->setCellValue("$letter[$j]$i","$value");
                $j++;
            }
        }
        //创建Excel输入对象
        ob_end_clean();
        $write = new PHPExcel_Writer_Excel5($excel);
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:charset/UTF-8");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header('Content-Disposition:attachment;filename="'.$fileName.'.xls"');
        header("Content-Transfer-Encoding:binary");
        $write->save('php://output');
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
