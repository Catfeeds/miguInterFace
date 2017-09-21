<?php

/**
 * Created by PhpStorm.
 * User:
 * Date:
 * Time:
 */
class TestController extends WController
{
    public function actionIndex(){
        //$this->render('index');
        echo "<script>window.location.href='/wechat/response/index.html?mid=1&nid=2'</script>";
    }
}
?>