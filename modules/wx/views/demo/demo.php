<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title><?php $this->pageTitle= '遥控器'?></title>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.9.1.min.js"></script>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/music.css">
    <script type="text/javascript" charset="utf-8" src="<?php echo Yii::app()->request->baseUrl; ?>/js/strophe.min.js"></script>
    <style>
        @media screen and (max-width:320px) {
            #hidden{display:none;background-color:black;height:100%;width:100%;text-align:center;z-index:55;position:absolute;opacity: 0.8;}
            .center{color:white;margin-left:10%;text-align: left;font-size:1.3em}
            .stbid{display:inline-block;width: 83%;height:60px;line-height:40px;outline:0;font-size: 1.3em;padding: 0; margin-left: 4%;border: 0;background-color:white;border-radius:10px;margin-top:50px;color:#39393E;margin-top:5%}
            .false{background:url("<?php echo Yii::app()->request->baseUrl; ?>/images/quxiao.png") repeat-x  center;height:50px;border-radius:10px;background-size: 112% 125%;border:none;width:40.7%;margin-top:5%;}
            .submit{background:url("<?php echo Yii::app()->request->baseUrl; ?>/images/qd1.png") repeat-x  center;height:50px;border-radius:10px;background-size: 112% 125%;border:none;width:40.7%;margin-top:5%;}
            .bottom1{color:white;font-size:0.8em;text-align: left;margin-left:9%}
        }
        @media screen and (min-width:321px) and (max-width:414px){
            #hidden{display:none;background-color:black;height:100%;width:100%;text-align:center;z-index:55;position:absolute;opacity: 0.8;}
            .center{color:white;margin-left:10%;text-align: left;font-size:1.5em}
            .stbid{display:inline-block;width: 83%;height:60px;line-height:40px;outline:0;font-size: 1.5em;padding: 0; margin-left: 4%;border: 0;background-color:white;border-radius:10px;margin-top:50px;color:#39393E;margin-top:5%}
            .false{background:url("<?php echo Yii::app()->request->baseUrl; ?>/images/quxiao.png") repeat-x  center;height:50px;border-radius:10px;background-size: 112% 125%;border:none;width:40.7%;margin-top:5%;}
            .submit{background:url("<?php echo Yii::app()->request->baseUrl; ?>/images/qd1.png") repeat-x  center;height:50px;border-radius:10px;background-size: 112% 125%;border:none;width:40.7%;margin-top:5%;}
            .bottom1{color:white;font-size:1em;text-align: left;margin-left:9%}
        }
        @media screen and (min-width:415px){
            #hidden{display:none;background-color:black;height:100%;width:100%;text-align:center;z-index:55;position:absolute;opacity: 0.8;}
            .center{color:white;margin-left:10%;text-align: left;font-size:1.8em}
            .stbid{display:inline-block;width: 83%;height:60px;line-height:40px;outline:0;font-size: 1.8em;padding: 0; margin-left: 4%;border: 0;background-color:white;border-radius:10px;margin-top:50px;color:#39393E;margin-top:5%}
            .false{background:url("<?php echo Yii::app()->request->baseUrl; ?>/images/quxiao.png") repeat-x  center;height:50px;border-radius:10px;background-size: 112% 125%;border:none;width:40.7%;margin-top:5%;}
            .submit{background:url("<?php echo Yii::app()->request->baseUrl; ?>/images/qd1.png") repeat-x  center;height:50px;border-radius:10px;background-size: 112% 125%;border:none;width:40.7%;margin-top:5%;}
            .bottom1{color:white;font-size:1.2em;text-align: left;margin-left:9%}
        }
    </style>
</head>
<body>
<div id="hidden" >
    <form action="" method="post" style="margin-top:22%">
        <input type="hidden" name="id" value="<?php echo !empty($list[0]['id'])?$list[0]['id']:'' ?>">
        <div class="center" >请输入魔百和盒子的序列号：</div>
        <input type="text" placeholder="请输入设备号：" class="stbid" name="stbid" ><br/>
        <input type="button" class="false" value="">
        <input type="submit"  class="submit" value=""><br>
        <div class="bottom1">魔百和盒子的序列号位置:设置>系统设置>关于</div><br/>
        <div class="bottom1" >要自动找到您的设备：</div>
        <div class="bottom1">●盒子和手机在同一个无限网络里</div>
    </form>
</div>
<header>
    <div class="header">
        <a ontouchstart="voic('3')"  ontouchend="unvoic('3')"><img id="sh" src="<?php echo Yii::app()->request->baseUrl; ?>/html/01.png" alt=""><img id="sh1" style="display:none" src="<?php echo Yii::app()->request->baseUrl; ?>/html/01-1.png" alt=""></a>
        <a ontouchstart="voic('4')"  ontouchend="unvoic('4')"><img id="f" src="<?php echo Yii::app()->request->baseUrl; ?>/html/09.png" alt=""><img id="f1" style="display:none" src="<?php echo Yii::app()->request->baseUrl; ?>/html/09-1.png" alt=""></a>
        <a ontouchstart="voic('82')"  ontouchend="unvoic('82')"><img id="c" src="<?php echo Yii::app()->request->baseUrl; ?>/html/02.png" alt=""><img id="c1" style="display:none" src="<?php echo Yii::app()->request->baseUrl; ?>/html/02-1.png" alt=""></a>
    </div>
</header>
<section>
    <div class="controller">
        <div class="top"><a ontouchstart="voic('19')"  ontouchend="unvoic('19')"><img id="s" src="<?php echo Yii::app()->request->baseUrl; ?>/html/s.png" alt=""><img id="s1" style="display:none" src="<?php echo Yii::app()->request->baseUrl; ?>/html/04.png" alt=""></a> </div>
        <div class="main">
            <a ontouchstart="voic('21')"  ontouchend="unvoic('21')"><img id="z" src="<?php echo Yii::app()->request->baseUrl; ?>/html/z.png" alt=""><img id="z1" style="display:none" src="<?php echo Yii::app()->request->baseUrl; ?>/html/05.png" alt=""></a>
            <a ontouchstart="voic('23')"  ontouchend="unvoic('23')"><img id="zh" src="<?php echo Yii::app()->request->baseUrl; ?>/html/03.png" alt=""><img id="zh1" style="display:none" src="<?php echo Yii::app()->request->baseUrl; ?>/html/03-1.png" alt=""></a>
            <a ontouchstart="voic('22')"  ontouchend="unvoic('22')"><img id="y" src="<?php echo Yii::app()->request->baseUrl; ?>/html/y.png" alt=""><img id="y1" style="display:none" src="<?php echo Yii::app()->request->baseUrl; ?>/html/20151109--11.png" alt=""></a>
            <div class="clear"></div>
        </div>
        <div class="bottom">
            <a ontouchstart="voic('20')"  ontouchend="unvoic('20')"><img id="x" src="<?php echo Yii::app()->request->baseUrl; ?>/html/x.png" alt=""><img id="x1" style="display:none" src="<?php echo Yii::app()->request->baseUrl; ?>/html/20151109--12.png" alt=""></a>
        </div>
    </div>
</section>
<footer>
    <div style="margin:8% 0;padding:0; width:100%;height:1px;background-color:#434343;"></div>
    <div>
        <a ontouchstart="voic('25')"  ontouchend="unvoic('25')"><img id="jian" src="<?php echo Yii::app()->request->baseUrl; ?>/html/10.png" alt=""><img id="jian1" style="display:none" src="<?php echo Yii::app()->request->baseUrl; ?>/html/07.png" alt=""></a>
        <a ontouchstart="voic('24')"  ontouchend="unvoic('24')"><img id="jia" src="<?php echo Yii::app()->request->baseUrl; ?>/html/11.png" alt=""><img id="jia1" style="display:none" src="<?php echo Yii::app()->request->baseUrl; ?>/html/08.png" alt=""></a>
    </div>
</footer>
<input type="hidden" name="tbid" value="<?php echo !empty($list[0]['stbid'])?$list[0]['stbid']:''; ?>">
</body>
<script type="text/javascript">
    window.onload = function() {
        stbid =$('input[name=tbid]').val();
        if(stbid == ''){
            $('#hidden').css('display','block');
            return false;
        }
    }
    function voic(id) {
        stbid = $('input[name=tbid]').val();
        if (id == 3) {
            $("#sh").css('display', 'none');
            $("#sh1").css('display', 'block');
        }
        if (id == 4) {
            $("#f").css('display', 'none');
            $("#f1").css('display', 'block');
        }
        if (id == 19) {
            $("#s").css('display', 'none');
            $("#s1").css('display', 'block');
        }
        if (id == 20) {
            $("#x").css('display', 'none');
            $("#x1").css('display', 'block');
        }
        if (id == 21) {
            $("#z").css('display', 'none');
            $("#z1").css('display', 'block');
        }
        if (id == 22) {
            $("#y").css('display', 'none');
            $("#y1").css('display', 'block');
        }
        if (id == 23) {
            $("#zh").css('display', 'none');
            $("#zh1").css('display', 'block');
        }
        if (id == 24) {
            $("#jia").css('display', 'none');
            $("#jia1").css('display', 'block');
        }
        if (id == 25) {
            $("#jian").css('display', 'none');
            $("#jian1").css('display', 'block');
        }
        if (id == 82) {
            $("#c").css('display', 'none');
            $("#c1").css('display', 'block');
        }
        $.getJSON("/wx/demo/demos", {ope: id, stbid: stbid}, function (data) {

        })
    }

        function unvoic(id){
            if(id == 3){
                $("#sh").css('display','block');
                $("#sh1").css('display','none');
            }
            if(id == 4){
                $("#f").css('display','block');
                $("#f1").css('display','none');
            }
            if(id == 19){
                $("#s").css('display','block');
                $("#s1").css('display','none');
            }
            if(id == 20){
                $("#x").css('display','block');
                $("#x1").css('display','none');
            }
            if(id == 21){
                $("#z").css('display','block');
                $("#z1").css('display','none');
            }
            if(id == 22){
                $("#y").css('display','block');
                $("#y1").css('display','none');
            }
            if(id == 23){
                $("#zh").css('display','block');
                $("#zh1").css('display','none');
            }
            if(id == 24){
                $("#jia").css('display','block');
                $("#jia1").css('display','none');
            }
            if(id == 25){
                $("#jian").css('display','block');
                $("#jian1").css('display','none');
            }
            if(id == 82){
                $("#c").css('display','block');
                $("#c1").css('display','none');
            }
        }
        $('.false').click(function(){
            $('#hidden').css('display','none');
        })
        $('.submit').click(function(){
            var k = $(this);
            var G = {};
            var stbid =$('input[name=stbid]').val();
            var id = $('input[name=id]').val();
            if(G.stbid==''){
                alert('序列号不能为空');
                return false;
            }
            var isStbid = /^[a-zA-Z0-9]{32,32}$/;
            if(!isStbid.test($('.stbid').val())){
                alert('请输入正确的32位序列号');
                return false;
            }
            $.post("/wx/demo/bd",{id:id,stbid:stbid},function(data){

            })
            alert('绑定成功');
        })
        document.ontouchmove = function(e){ e.preventDefault(); }
</script>
</html>
