<?php
    class KefuController extends AController{

        public function actionDefault(){
            $this->render("default");
        }

        public function actionindex(){
            $this->render('index');
        }


        public function curlPost($url, $data = null)
        {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
            curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
            curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
            $output = curl_exec($curl);
            curl_close($curl); // 关闭CURL会话
            return $output;
        }


        public function actiontest1(){
            2017 == 客服1;
            2004 == 客服2;
            2010 == 客服5;
            2011 == 客服6;
            2014 == 客服4;
            2018 == 客服9;

        }


        public function actiontest(){
            $last = date("Ymd",strtotime("-1 day"));
            $last = strtotime($last);
            // $last.'<br>';
            $now = date("Ymd",strtotime("0 day"));
            $now = strtotime($now)-1;
            //echo $now;
            $appid = "wx3f9bb59f5ba78010";
            $appsecret = "5f17728db47200477af5b2d9943211b0";
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
            $output=file_get_contents($url);
            $jsoninfo = json_decode($output, true);

            $access_token = $jsoninfo["access_token"];
            $url ="https://api.weixin.qq.com/customservice/msgrecord/getrecord?access_token=$access_token";
            for($i=1;$i<100;$i++){
                $data = '{"endtime" : '.$now.',"pageindex" : '.$i.',"pagesize" : 50,"starttime" : '.$last.'}';
                $list = $this->curlPost($url,$data);
                $list = json_decode($list,true);
                if(empty($list['recordlist'])){
                    break;
                }
                $arr[] = $list;

            }
            /*echo '<pre>';
            print_r($arr);
            echo '</pre>';*/
            foreach($arr as $key=>$val){
                foreach($val['recordlist'] as $v){
                    /*$list[]=$v;*/
                    $history = new WxHistory();
                    $history->openid = $v['openid'];
                    $history->opercode = $v['opercode'];
                    $history->text = $v['text'];
                    $history->time = $v['time'];
                    $history->worker = $v['worker'];
                    if(!$history->save()){
                        var_dump($history->getErrors());
                        $this->die_json(array('code'=>404,'msg'=>'信息保存失败1'));
                    }
                }
            }
            //echo json_encode($arr);
        }

        public function actionHistory(){
            $worker = $_REQUEST['worker'];
            $first = $_REQUEST['first'];
            $first=strtotime($first);
            $end = $_REQUEST['end'];
            $end = strtotime($end)-1;
            $page = $_REQUEST['page'];
            $res = WxHistoryManager::getALL($worker,$first,$end,$page);
            /*echo '<pre>';
            print_r($res);
            echo '</pre>';*/
            if(!empty($res['list'])){
                echo json_encode($res);
            }else{
                echo json_encode(array('code'=>404,'msg'=>'未查询到数据','res'=>$res));
            }

        }

        public function actionOut(){
            $worker = $_REQUEST['worker'];
            $first = $_REQUEST['first'];
            $first=strtotime($first);
            $end = $_REQUEST['end'];
            $end = strtotime($end)-1;
            /*$worker = 'kf2017@MobileBox2015';
            $first=1462896000;
            $end = 1462982399;*/
            $data = WxHistoryManager::getExcel($worker,$first,$end);
            $result = $this->Excel($data);
        }


        public function Excel($data){
            Yii::$enableIncludePath = false;
            Yii::import('application.extensions.PHPExcel.PHPExcel', 1);
            $fileName=date("Ymdhis", time());
            //引入PHPExcel库文件（路径根据自己情况）
            //include 'PHPExcel.php';
            //创建对象
            $excel = new PHPExcel();

            //Excel表格式,这里简略写了8列
            $letter = array('A','B','C','D','E','F','F','G');
            //表头数组
            $tableheader = array('序号','用户','内容','时间','客服');
            //填充表头信息
            for($i = 0;$i < count($tableheader);$i++) {
                $excel->getActiveSheet()->setCellValue("$letter[$i]1","$tableheader[$i]");
            }

            //填充表格信息
            for ($i = 2;$i <= count($data) + 1;$i++) {
                $j = 0;
                foreach ($data[$i - 2] as $key=>$value) {
                $excel->getActiveSheet()->setCellValue("$letter[$j]$i","$value");
                $j++;
                }
            }
            //创建Excel输入对象
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

        public function actionTime(){
            $last = date("Ymd",strtotime("-1 day"));
            $last = strtotime($last);
            echo $last.'<br>';
            $now = date("Ymd",strtotime("0 day"));
            $now = strtotime($now)-1;
            echo $now;
        }



    }
?>