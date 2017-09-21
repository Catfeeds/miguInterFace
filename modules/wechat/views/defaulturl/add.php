<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">


<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl . "/css/wx/index.css"?>"/>
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl . "/css/wx/public.css"?>"/>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/jquery.js"?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/myString.js"?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/function.js"?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/PublicUser.js"?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/WechatMenuAdd.js"?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/PublicMaterialPushAjax.js"?>"></script>

<style type="text/css">
    .ErrorRed{ color:#e74649; /* padding-left: 2%; */ font-size: 14px; display: inline-block;}
</style>


<div class="menus_r">
    <div class="div_height_15"></div>
    <!--column end-->

    <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onSubmit="javascript:return funsubmit_add();" autocomplete="off">

        <div class="clas_box" id="div_replay_news" style="margin-top:0px;  padding-bottom:0px; ">

            <div class="class_con">
                <label for="">菜单名称</label>　
                <select class="" name="menu" id="menu">
                    <?php foreach($menuname as $key=>$value){?>
                        <option value="<?php echo $value['title'];?>" <?php if($wxurl['menu']==$value['title']){?> selected="selected" <?php }?>><?php echo $value['title']; ?></option>
                    <?php }?>
                </select>
            </div>
        <!--    <div class="class_con">
                <label for="">牌照方</label>　
                <select class="" name="cp" id="cp">
                    <option value="0" <?php //if($wxurl['cp']=='0'){?> selected="selected" <?php //}?>>默认</option>
                    <option value="1" <?php //if($wxurl['cp']=='1'){?> selected="selected" <?php //}?>>华数</option>
                </select>
            </div>-->
            <div class="class_con">
                <label for="">URL</label>
<!--                <input type="text" name="url" id="url" value="--><?php //echo !empty($wxurl->url)?$wxurl->url:''?><!--" maxlength="255"  onblur="onblur_url()" />-->
                <input type="radio" value="1" name="upde" onclick="xianshi()" style="width: 20px;height: 15px" >URL
                <input type="radio" value="2" name="upde" onclick="hidd()" style="width: 20px;height: 15px" >上传文件
                <input style="display: none" type="text" name="url" id="url" value="<?php echo !empty($wxurl->url)?$wxurl->url:''?>" maxlength="255"  onblur="onblur_url()" />
                <input style="display: none" type="file" name="urls" id="urls" value="<?php echo !empty($wxurl->url)?$wxurl->url:''?>" maxlength="255"  onblur="onblur_url()" />
                <span style="color:#F00;" id="span_url"></span>
            </div>
            <script>
                // var val=$('input:radio[name="upde"]:checked').val();
                function xianshi(){
                    $("#url").show();
                    $("#urls").hide();
                }
                function hidd(){
                    $("#url").hide();
                    $("#urls").show();
                }
            </script>
        </div>

        <div class="clas_box" style=" margin-top:0px; padding-top:0px;">
            <div class="de_y">
                <button type="submit" class="de_y_l" style="background:#00b6ea">确定</button>
                <button type="button" class="de_y_r" style="background:#9b8975" onclick="history.go(-1);" >返回</button>
            </div>
        </div>
        <!-- classify end -->
    </form>
</div>