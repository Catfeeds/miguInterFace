    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl . "/css/wx/index.css"?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl . "/css/wx/public.css"?>"/>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/jquery.js"?>"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/myString.js"?>"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/function.js"?>"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/PublicUser.js"?>"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/KeywordReply_AddImage.js"?>"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/PublicMaterialAjax.js"?>"></script>
<style type="text/css">

    .ErrorRed{ color:#e74649; /* padding-left: 2%; */ font-size: 14px; display: inline-block;}
    .form-control {
        cursor: not-allowed;
        background-color: #eeeeee;
    }
    .uploadify {
        position: relative;
        margin-bottom: 1em;
    }
    .uploadify-queue {
        margin-bottom: 1em;
    }
</style>
<script type="text/javascript">
    var w,h;
    function getSrceenWH(){
        w = $(window).width();
        h = $(window).height();
        $('#dialogBg').width(w).height(h);
    }
    window.onresize = function(){
        getSrceenWH();
    }

    $(window).resize();


</script>
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
                <label for="">图片</label>

                <!--<input type="file" name="image_link_url"  onblur="onblur_image_link_url()" /><!--id="image_link_url"-->
                <!--<input type="hidden" name="image_link_urls" value="<?php echo !empty($automaticreply->link_url)?$automaticreply->link_url:''?>">-->
                <input type="hidden" name="image_media_id" id="image_media_id" value="<?php echo !empty($automaticreply->media_id)?$automaticreply->media_id:''?>"   />
                <input type="text" name="image_link_url" id="image_link_url" value="<?php echo !empty($automaticreply->link_url)?$automaticreply->link_url:''?>"  onblur="onblur_image_link_url()" />
                <span>图片支持JPG、PNG、GIF格式！</span>
                <a href="javascript:Oclick_ShowBox('image');" class="class_con_alink_01">点击这里“从素材库选择”</a>　
                <span style="color:#F00;" id="span_image_link_url"></span>
            </div>

            <div class="class_con" style="display:none;">
                <label for="">&nbsp;</label>
                <input type="file" name="image_images"  id="image_images" class="class_con_inputfile"  style="width:150px;" />　

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


    <div id="dialogBg" style="display:none;">
    <div id="dialog">

        <input type="hidden" name="InputMaterialUrl" id="InputMaterialUrl" value="<?php echo $this->get_url('material','AjaxMaterial');?>" autocomplete="off" />
        <input type="hidden" name="InputMaterialMusicUrl" id="InputMaterialMusicUrl" value="<?php echo $this->get_url('material','AjaxMaterialMusic');?>" autocomplete="off" />

        <div class="menus_r_openwindow" id="div_material_image" style="display:none;  overflow-x: hidden; ">
            <input type="hidden" name="PageMaterial_image" id="PageMaterial_image" value="1" autocomplete="off" />
            <div class="maps" style="margin-top: 0px; margin-left:0px;">
                <a href="javascript:Oclick_claseDialogBtn();" style="float:right;">X关闭　</a>
            </div>
            <div class="mid" style="margin-left:0px; margin-top:0px;">
                <table id="Table_image"  style="border-collapse:collapse;margin-left:0px;" class="mid_con">
                    <tbody id="TableTbody_image">
                    <tr style="border-left:3px solid #e4e3e3" class="mid_01">
                        <td class="mid_thr">文件</td>
                        <td class="mid_thr">时间</td>
                        <td class="mid_thr">选择</td>
                    </tr>

                    </tbody>
                </table>
                <div class="interpret" style="margin-left:0px; text-align:center;" id="link_image" onclick="AjaxMaterialSearchInfo('image')">点击加载更多...</div>
                <script type="text/javascript">AjaxMaterialSearchInfo('image');</script>
            </div>
        </div>

    </div>
    </div>