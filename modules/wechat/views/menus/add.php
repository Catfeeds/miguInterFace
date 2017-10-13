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
                <label for="">父级菜单</label>　
                <select class="" name="father_id" id="father_id">
                    <option value="0">一级菜单</option>
                    <?php foreach($ListWxMenu as $key=>$value){?>
                         <option value="<?php echo $value['id'];?>" <?php if($wxmenu['father_id']==$value['id']) {?> selected= "selected" <?php }?>><?php echo $value['title']; ?></option>
                    <?php }?>
                </select>
            </div>
            <div class="class_con">
                <label for="">类型</label>　
                <select class="" name="data_type" id="data_type">
                    <option value="click" <?php if($wxmenu['data_type']=='click'){?> selected="selected" <?php }?>>文本消息</option><!--点击推事件-->
                    <option value="view" <?php if($wxmenu['data_type']=='view'){?> selected="selected" <?php }?>>跳转URL</option>
                    <option value="media_id" <?php if($wxmenu['data_type']=='media_id'){?> selected="selected" <?php }?>>下发消息（除文本消息）</option>
                    <!--<option value="view_limited">跳转图文消息URL</option>-->
                </select>
            </div>
            <div class="class_con">
                <label for="">名称<font color="#FF0000">*</font></label>
                <input type="text" name="title" id="title" value="<?php echo !empty($wxmenu->title)?$wxmenu->title:''?>" maxlength="8" onKeyPress="return noStrs(event);" onblur="onblur_title()" />
                <span style="color:#F00;" id="span_title"></span>
            </div>
            <div class="class_con">
                <label for="">跳转的URL</label>
                <input type="text" name="url" id="url" value="<?php echo !empty($wxmenu->url)?$wxmenu->url:''?>" maxlength="255"  onblur="onblur_url()" />
                <span>当类型为“跳转URL”时有效，并为必填项</span>
                <span style="color:#F00;" id="span_url"></span>
            </div>
            <div class="class_con">
                <label for="">按钮的KEY</label>
                <input type="text" name="btn_key" id="btn_key" value="<?php echo !empty($wxmenu->btn_key)?$wxmenu->btn_key:''?>" maxlength="64" onKeyPress="return noStrs(event);" onblur="onblur_btn_key()" />
                <span>当类型为“文本消息”时有效，并为必填项</span>
                <span style="color:#F00;" id="span_btn_key"></span>
            </div>
            <div class="class_con" >
                <label for="">素材的MediaId</label>
                <input type="text" name="media_id" id="media_id" value="<?php echo !empty($wxmenu->media_id)?$wxmenu->media_id:''?>" maxlength="64" onKeyPress="return noStrs(event);" onblur="onblur_media_id()" />
<!--                <span>当类型为“下发消息（除文本消息）”或“跳转图文消息URL”时有效，并为必填项</span>-->
                <a  onclick="Oclick_ShowBox('image')" id="alink_media_id"  class="class_con_alink_01">点击这里“从素材库选择”</a>　
                <span style="color:#F00;" id="span_media_id"></span>
            </div>
            <div class="class_con" style="display:none;">
                <label for="">&nbsp;</label>
                <span>当类型为“下发消息（除文本消息）”或“跳转图文消息URL”时有效，并为必填项</span>
            </div>
            <div class="class_con">
                <label for="">排序</label>
                <input type="text" name="data_sort" id="data_sort" value="<?php echo !empty($wxmenu->data_sort)?$wxmenu->data_sort:''?>" maxlength="10" onKeyPress="return noNumbers(event);"  />
                <span>如果不填写默认为0</span>
                <span style="color:#F00;" id="span_data_sort"></span>
            </div>
            <div class="class_con">
                <label for="">描述</label>
                <input type="text" name="description" id="description" value="<?php echo !empty($wxmenu->description)?$wxmenu->description:''?>" maxlength="10" onKeyPress="return noStrs(event);"  />
            </div>
        </div>

        <div class="clas_box" style=" margin-top:0px; padding-top:0px;">
            <div class="de_y">
                <button type="submit" class="de_y_l" style="background:#00b6ea">确定</button>
                <button type="button" class="de_y_r" style="background:#9b8975" onclick="history.go(-1);" >返回</button>
            </div>
        </div>
        <!-- classify end -->
    </form>

    <div class="clas_box" id="div_replay_news" style="margin-top:0px; padding-top:0px; padding-bottom:0px; ">
        <div class="class_con">
            <label for="">备注：</label>
                            <span>
                            1、自定义菜单最多包括3个一级菜单，每个一级菜单最多包含5个二级菜单。<br />
                            2、一级菜单最多4个汉字，二级菜单最多7个汉字，多出来的部分将会以“...”代替。<br />
                            3、创建自定义菜单后，由于微信客户端缓存，需要24小时微信客户端才会展现出来。测试时可以尝试取消关注公众账号后再次关注，则可以看到创建后的效果。<br />
                            4、当按钮的类型为“下发消息（除文本消息）media_id”和“跳转图文消息URL(view_limited)”类型时起作用。<br />
                            5、当按钮的类型为“点击推事件(click)”等点击类型时起作用，菜单KEY值，用于消息接口推送，不超过128字节。<br />
                            </span>
        </div>
    </div>
</div>




    <div id="dialogBg" style="display:none;">
        <div id="dialog">
            <input type="hidden" name="InputMaterialUrl" id="InputMaterialUrl" value="<?php echo $this->get_url('material','AjaxMaterial');?>" autocomplete="off" />
            <input type="hidden" name="InputMaterialMusicUrl" id="InputMaterialMusicUrl" value="<?php echo $this->get_url('material','AjaxMaterialMusic');?>" autocomplete="off" />

            <div class="menus_r" id="div_material_mpnews" style="display:block;">
                <input type="hidden" name="PageMaterial_news" id="PageMaterial_news" value="2" autocomplete="off" />
                <div class="maps" style="margin-left:0px; margin-top:0px;">
                    <a href="javascript:Oclick_claseDialogBtn();" style="float:right;">X关闭　</a>
                </div>
                <ul class="tab_menu" style="margin-left:0px;">
                    <li onclick="Oclick_ShowBox('image')">图片素材</li>
                    <li onclick="Oclick_ShowBox('video')">视频素材</li>
                    <li onclick="Oclick_ShowBox('voice')">音频素材</li>
                    <li onclick="Oclick_ShowBox('mpnews')" class="selected">图文素材</li>
                </ul>
                <div class="mid" style="margin-left:0px; margin-top:0px;">
                    <table id="Table_news" style="border-collapse:collapse;margin-left:0px;" class="mid_con">
                        <tbody id="TableTbody_news">
                        <tr style="border-left:3px solid #e4e3e3" class="mid_01">
                            <td class="mid_thr">标题</td>
                            <td class="mid_thr">选择</td>
                        </tr>
                            <?php foreach($ListWxMaterialArticles as $key=>$value){ ?>
                            <tr style="border-left:3px solid #cfbba9" class="mid_02">
                                <td><?php echo $value['title'];?></td>
                                <td><a href=javascript:GetWechatMaterial("<?php echo $value['media_id'];?>");>选中使用</a></td>
                            </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                    <?php if(count($ListWxMaterialArticles)<10){ ?>
                    <div class="interpret" style="margin-left:0px; text-align:center;" id="link_news" > 亲，没有更多了哈...</div>
                    <?php }else{ ?>
                    <div class="interpret" style="margin-left:0px; text-align:center;" id="link_news" onclick="AjaxMaterialSearchInfo('news')">点击加载更多...</div>
                    <?php } ?>
                </div>
            </div>



            <div class="menus_r" id="div_material_image" style="display:none;">
                <input type="hidden" name="PageMaterial_image" id="PageMaterial_image" value="1" autocomplete="off" />
                <div class="maps" style="margin-top: 0px; margin-left:0px;">
                    <a href="javascript:Oclick_claseDialogBtn();" style="float:right;">X关闭　</a>
                </div>
                <ul class="tab_menu" style="margin-left:0px;">
                    <li onclick="Oclick_ShowBox('image')" class="selected">图片素材</li>
                    <li onclick="Oclick_ShowBox('video')">视频素材</li>
                    <li onclick="Oclick_ShowBox('voice')">音频素材</li>
                    <li onclick="Oclick_ShowBox('mpnews')">图文素材</li>
                </ul>
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
            <div class="menus_r" id="div_material_video" style="display:none;">
                <input type="hidden" name="PageMaterial_video" id="PageMaterial_video" value="2" autocomplete="off" />
                <div class="maps" style="margin-top: 0px; margin-left:0px;">
                    <a href="javascript:Oclick_claseDialogBtn();" style="float:right;">X关闭　</a>
                </div>
                <ul class="tab_menu" style="margin-left:0px;">
                    <li onclick="Oclick_ShowBox('image')">图片素材</li>
                    <li onclick="Oclick_ShowBox('video')" class="selected">视频素材</li>
                    <li onclick="Oclick_ShowBox('voice')">音频素材</li>
                    <li onclick="Oclick_ShowBox('mpnews')">图文素材</li>
                </ul>
                <div class="mid" style="margin-left:0px; margin-top:0px;">
                    <table id="Table_video" style="border-collapse:collapse;margin-left:0px;" class="mid_con">
                        <tbody id="TableTbody_video">
                        <tr style="border-left:3px solid #e4e3e3" class="mid_01">
                            <td class="mid_thr">文件</td>
                            <td class="mid_thr">选择</td>
                        </tr>
                            <?php foreach($ListWxMaterialVideo as $key=>$value){  ?>
                            <tr style="border-left:3px solid #cfbba9" class="mid_02">
                                <td><?php echo $value['title'];  ?></td>
                                <td><a href=javascript:GetWechatMaterial("<?php echo $value['media_id'];?>")>选中使用</a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php if(count($ListWxMaterialVideo)<10){ ?>
                    <div class="interpret" style="margin-left:0px; text-align:center;" id="link_video" > 亲，没有更多了哈...</div>
                    <?php }else{ ?>
                    <div class="interpret" style="margin-left:0px; text-align:center;" id="link_video" onclick="AjaxMaterialSearchInfo('video')">点击加载更多...</div>
                    <?php } ?>
                </div>
            </div>
            <div class="menus_r" id="div_material_voice" style="display:none;">
                <input type="hidden" name="PageMaterial_voice" id="PageMaterial_voice" value="2" autocomplete="off" />
                <div class="maps" style="margin-top: 0px; margin-left:0px;">
                    <a href="javascript:Oclick_claseDialogBtn();" style="float:right;">X关闭　</a>
                </div>
                <ul class="tab_menu" style="margin-left:0px;">
                    <li onclick="Oclick_ShowBox('image')">图片素材</li>
                    <li onclick="Oclick_ShowBox('video')">视频素材</li>
                    <li onclick="Oclick_ShowBox('voice')" class="selected">音频素材</li>
                    <li onclick="Oclick_ShowBox('mpnews')">图文素材</li>
                </ul>
                <div class="mid" style="margin-left:0px; margin-top:0px;">
                    <table id="Table_voice" style="border-collapse:collapse;margin-left:0px;" class="mid_con">
                        <tbody id="TableTbody_voice">
                        <tr style="border-left:3px solid #e4e3e3" class="mid_01">
                            <td class="mid_thr">文件</td>
                            <td class="mid_thr">选择</td>
                        </tr>
                            <?php foreach($ListWxMaterialVoice as $key=>$value){ ?>
                            <tr style="border-left:3px solid #cfbba9" class="mid_02">
                                <td><?php echo $value['title']; ?></td>
                                <td><a href=javascript:GetWechatMaterial("<?php echo $value['media_id'];?>")>选中使用</a></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php if(count($ListWxMaterialVoice)<10){ ?>
                    <div class="interpret" style="margin-left:0px; text-align:center;" id="link_voice" > 亲，没有更多了哈...</div>
                  <?php }else{?>
                    <div class="interpret" style="margin-left:0px; text-align:center;" id="link_voice" onclick="AjaxMaterialSearchInfo('voice')">点击加载更多...</div>
                   <?php } ?>
                </div>
            </div>


        </div>
    </div>