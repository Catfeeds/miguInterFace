<?php
class ReportController extends WController{
    public function actionDefault(){
        $this->render("default");
    }

    public function actionindex(){
        $total = Wxbox::model()->count();
        $page = 10;
        $data = $this->getPageInfo($page);
        $list = ReportManager::getUserList($data);
        $url = $this->createUrl($this->action->id);
        $pagination = $this->renderPagination($url,$list['count'],$page,$data['currentPage']);
        $this->render('index',array('province'=>$list['list'],'page'=>$pagination,'total'=>$total));
    }
    public function actionReport(){
        $page = 10;
        $data = $this->getPageInfo($page);
        //$total = WxUservisonManager::getTotal();
        $tmp = WxUserversionManager::getProvince($data);
        $province = ProvinceManager::getList();
        $num=$tmp['total'];
        //var_dump($num);die;
        foreach($tmp['list'] as $key=>$val){
            foreach($province as $k=>$v){
                if($val['province']==$v['provinceCode']){
                    $val['pro']=$v['provinceName'];
                }
                $list[$key]=$val;
}
        }

        $url = $this->createUrl($this->action->id);
        $pagination = $this->renderPagination($url,$tmp['count'],$page,$data['currentPage']);
        $this->render('report',array('list'=>$list,'num'=>$num,'page'=>$pagination));
    }


    public function actionReports(){
        $page = 10;
        $pro=$_REQUEST['pro'];
        $data = $this->getPageInfo($page);
        $total = WxUserversionManager::getPro($pro);
        $tmp = WxUserversionManager::getVname($data,$pro);
        $list = $tmp['list'];
        $num=$tmp['total'];
        $url = $this->createUrl($this->action->id);
        $pagination = $this->renderPagination($url,$tmp['count'],$page,$data['currentPage']);
        $this->render('reports',array('total'=>$total,'list'=>$list,'num'=>$num,'page'=>$pagination));
    }

    public function actionVideoreport(){
        $province = Province::model()->findAll("1=1 order by id asc");
        $p = isset($p) ? $p : '';
        $this->render('videoreport',array('province'=>$province,'provinceCode'=>$p));
    }
public function actionAppreport(){
        $province = Province::model()->findAll("1=1 order by id asc");
        $p = isset($p) ? $p : '';
        $this->render('appreport',array('province'=>$province,'provinceCode'=>$p));
    }

    public function actionUserlist(){
        $first = strtotime($_REQUEST['first']);
        $end = strtotime($_REQUEST['end']);
        if(empty($first) && empty($end)){
            $last = date("Ymd",strtotime("-1 day"));
            $first= strtotime($last);
            $now = date("Ymd",strtotime("0 day"));
            $end = strtotime($now)-1;
        }
        $type = $_REQUEST['type'];
        $p = $_REQUEST['page'];
        $province=$_REQUEST['province'];
        //$city=$_REQUEST['city'];
        $data = WxDpuserManager::getList($first,$end,$p,$province,$type);
        echo json_encode($data);
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
    $type = $_REQUEST['type'];
    //$p = $_REQUEST['page'];
    $province=$_REQUEST['province'];
    //$city=$_REQUEST['city'];
    $arr = WxDpuserManager::getAll($first,$end,$province,$type);
    //var_dump($arr);die;
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
        $letter = array('A','B','C','D');
        //表头数组
        $tableheader = array('影片名称','分类','投屏次数','日期');
        //填充表头信息
        for($i = 0;$i < count($tableheader);$i++) {
            $excel->getActiveSheet()->setCellValue("$letter[$i]1","$tableheader[$i]");
        }

        //var_dump($arr);die;
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
public function actionOuts(){
        $first = strtotime($_REQUEST['first']);
        $end = strtotime($_REQUEST['end']);
        if(empty($first) && empty($end)){
            $last = date("Ymd",strtotime("-1 day"));
            $first= strtotime($last);
            $now = date("Ymd",strtotime("0 day"));
            $end = strtotime($now)-1;
        }
        $type = $_REQUEST['type'];
        //$p = $_REQUEST['page'];
        $province=$_REQUEST['province'];
        //$city=$_REQUEST['city'];
        $arr = WxDpuserManager::getAll($first,$end,$province,$type);
        //var_dump($arr);die;
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
        $letter = array('A','B','C','D');
        //表头数组
        $tableheader = array('应用名称','分类','投屏次数','日期');
        //填充表头信息
        for($i = 0;$i < count($tableheader);$i++) {
            $excel->getActiveSheet()->setCellValue("$letter[$i]1","$tableheader[$i]");
        }

        //var_dump($arr);die;
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
}
?>

