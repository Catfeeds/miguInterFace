<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/2/28
 * Time: 17:11
 */
class MaterialController extends WController{


    public function actionDefault(){
        $this->render("default");
    }

        public function actionIndex(){

            //分页
            $page = 10;
            $data = $this->getPageInfo($page);
            $criteria = new CDbCriteria();
            $criteria->select = '*';
//            $criteria->addCondition("msgtype = '$SearchMsgType'");
            $count = WxMaterial::model()->count($criteria);
            $criteria->offset = $data['start'];
            $criteria->limit = $data['limit'];
            $criteria->order = "create_time desc";
            $url = $this->createUrl($this->action->id);
            $arr = WxMaterial::model()->findAll($criteria);
            $pagination = $this->renderPagination($url,$count,$page,$data['currentPage']);

            $this->render('index',array('arr'=>$arr,'page'=>$pagination));
        }

        public function actionDel(){
            if(empty($_POST['id'])){
                $this->die_json(array('code'=>404,'msg'=>'参数不能为空'));
            }
            $material = WxMaterial::model()->deleteByPk($_POST['id']);
            if(!$material){
                $this->die_json(array('code'=>404,'msg'=>'删除失败'));
            }
            $this->die_json(array('code'=>200,'msg'=>'删除成功'));
        }

    public function actionDels(){
        $media_id = $_POST['media_id'];
        $material = WxMaterial::model()->deleteByPk($media_id);
        if(!$material){
            $this->die_json(array('code'=>404,'msg'=>'删除失败'));
        }
        $this->die_json(array('code'=>200,'msg'=>'删除成功'));
    }

    //ajax返回除了音乐以为的素材
    public function actionAjaxMaterial(){
        $ListArray=array("count"=>0,
            "page"=>0,
            "last_page"=>0,
            "total_page"=>0,
            "list"=>array(),
        );

        $page = isset($_POST["page"]) ? intval(trim($_POST["page"])) : intval($_GET["page"]);
        $MsgType = isset($_POST['MsgType']) ? $_POST['MsgType'] : $_GET['MsgType'] ;
        $MsgType=htmlspecialchars(trim($MsgType));
        if(empty($MsgType)){ $MsgType="news";  }

        if($MsgType=="news"){
            $_where=" AND (data_type='$MsgType' OR data_type='atricles')";
        }else{
            $_where=" AND data_type='$MsgType'";
        }
        //$ModelWechatMaterial=M('WechatMaterial');
        //$count=$ModelWechatMaterial->where("1 $_where ")->count();
        $connection = Yii::app()->db;
        $sql = "select count(*) FROM yd_wx_material where 1 $_where";
        $command = $connection->createCommand($sql);
        $count = $command->queryColumn();
        $count=$count[0];

        $page = $page ? $page : 1 ;//当前页
        $display_num=10;
        $total_page=ceil($count/$display_num);//总页数
        $page=$page>$total_page ? $total_page : $page;
        $numpage=($page-1)*$display_num;
        $last_page=$page+1;//下一页
        $last_page=$last_page>$total_page ? $total_page : $last_page;

        //$List=$ModelWechatMaterial->where("1 $_where ")
          //  ->order("create_time DESC")
         //   ->limit("$numpage,$display_num")->select();
        //wirtefile($ModelWechatMaterial->getLastSql());
        $connection = Yii::app()->db;
        $sql = "select * FROM yd_wx_material where 1 $_where order by create_time desc limit $numpage,$display_num";
        $command = $connection->createCommand($sql);
        $List = $command->queryAll();
        $_list=array();
        foreach($List as $key=>$value){
            $_arr=array();
            $_arr["MediaId"]=$value["media_id"];
            $_arr["Title"]=$value["title"];
            $_arr["Url"]=$value["url"];
            $_arr["Description"]=$value["introduction"];
            $_arr["Type"]=$value["data_type"];
            $_arr["Time"]=date("Y-m-d",$value["create_time"]);
            $_list[]=$_arr;
        }

        $ListArray["count"]=$count;
        $ListArray["page"]=$page;
        $ListArray["last_page"]=$last_page;
        $ListArray["total_page"]=$total_page;
        $ListArray["list"]=$_list;

        echo json_encode($ListArray);
        exit;
    }
    /**
     * @描述：ajax查询音乐素材
     */
    public function actionAjaxMaterialMusic(){
        $ListArray=array("count"=>0,
            "page"=>0,
            "last_page"=>0,
            "total_page"=>0,
            "list"=>array(),
        );

        $page = isset($_POST["page"]) ? intval(trim($_POST["page"])) : intval($_GET["page"]);
        $MsgType = isset($_POST['MsgType']) ? $_POST['MsgType'] : $_GET['MsgType'] ;
        $MsgType=htmlspecialchars(trim($MsgType));
        if(empty($MsgType)){ $MsgType="music";  }

        $_where=" AND data_type='$MsgType'";
        $ModelWechatMaterialMusic=M('WechatMaterialMusic');
        $count=$ModelWechatMaterialMusic->where("1 $_where ")->count();

        $page = $page ? $page : 1 ;//当前页
        $display_num=10;
        $total_page=ceil($count/$display_num);//总页数
        $page=$page>$total_page ? $total_page : $page;
        $numpage=($page-1)*$display_num;
        $last_page=$page+1;//下一页
        $last_page=$last_page>$total_page ? $total_page : $last_page;

        $List=$ModelWechatMaterialMusic->where("1 $_where ")
            ->order("id DESC")
            ->limit("$numpage,$display_num")->select();

        $_list=array();
        foreach($List as $key=>$value){
            $_arr=array();
            $_arr["Title"]=$value["title"];
            $_arr["Description"]=$value["introduction"];
            $_arr["Url"]=$value["url"];
            $_arr["HdUrl"]=$value["hd_url"];
            $_arr["ThumbUrl"]=$value["thumb_url"];
            $_arr["ThumbMediaId"]=$value["thumb_media_id"];
            $_arr["Type"]=$value["data_type"];
            $_arr["Time"]=date("Y-m-d",$value["create_time"]);
            $_list[]=$_arr;
        }

        $ListArray["count"]=$count;
        $ListArray["page"]=$page;
        $ListArray["last_page"]=$last_page;
        $ListArray["total_page"]=$total_page;
        $ListArray["list"]=$_list;

        echo json_encode($ListArray);
        exit;
    }






}