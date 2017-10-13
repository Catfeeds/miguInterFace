    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl . "/css/wx/index.css"?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl . "/css/wx/public.css"?>"/>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/jquery.js"?>"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/myString.js"?>"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/function.js"?>"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/PublicUser.js"?>"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/KeywordReply_AddText.js"?>"></script>



<style type="text/css">

    .ErrorRed{ color:#e74649; /* padding-left: 2%; */ font-size: 14px; display: inline-block;}
</style>

<div class="menus_r">
    <div class="div_height_15"></div>
    <!--column end-->

    <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onSubmit="javascript:return funsubmit_update();" autocomplete="off">
        <input type="hidden" name="msgtype" id="msgtype" value="<?php echo $MsgType;?>" />

        <div class="clas_box" id="div_replay_news" style="margin-top:0px; padding-top:22px; padding-bottom:0px; ">
            <div class="class_con">
                <label for="">消息类型</label>
                <input type="text"
               value ="<?php if($MsgType =='news'){echo "图文消息";}
                              elseif($MsgType =='music'){echo "音乐消息";}
                              elseif($MsgType =='video'){echo "视频消息";}
                              elseif($MsgType =='voice'){echo "语音消息";}
                              elseif($MsgType =='image'){echo "图片消息";}
                              elseif($MsgType =='text'){echo "文本消息";}?>
                " disabled="disabled" />
            </div>
            <div class="class_con">
                <label for="">关键字</label>
                <input type="text" name="key_word" id="key_word" value="<?php echo !empty($automaticreply->key_word)?$automaticreply->key_word:''?>" maxlength="40" onKeyPress="return noStrs(event);" onblur="onblur_key_word()" />
                <span style="color:#F00;" id="span_key_word"></span>
            </div>
            <div class="class_con">
                <label for="">文本</label>
                <textarea name="text_description" id="text_description" maxlength="150" style="width:528px; height:100px;" onKeyPress="return noStrs(event);" onblur="onblur_text_description()"><?php echo !empty($automaticreply->description)?$automaticreply->description:''?></textarea>
                <span>最多支持150字</span>
                <span style="color:#F00;" id="span_text_description"></span>
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
