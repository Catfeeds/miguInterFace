    <meta charset="UTF-8">

    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl . "/css/wx/index.css"?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl . "/css/wx/public.css"?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl . "/css/wx/lightbox.css"?>"/>
    <link rel="stylesheet" href="http://vjs.zencdn.net/c/video-js.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl . "/css/wx/remodal.css"?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl . "/css/wx/remodal-default-theme.css"?>"/>
    <style>
        .bor_cen tr td {
            color:#333;
        }
        .clip,.clip a{
            text-align:center;
            width:200px;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
        }
        .remodal{
            padding:0;
        }

    </style>

<div class="menus_r">
    <div id="con_two_1" style="display: block;">
        <!--column end-->
        <div class="form_con">
            <div class="form_xuan">
<!--                <a href="javascript:void(0)" class="form_qx form_true selectall">全选</a>-->
<!--                <a href="javascript:void(0)" class="form_qx from_false unselected">反选</a>-->
<!--                <a href="javascript:void(0)" class="form_qx from_q select_f">取消</a>-->
<!--                <a href="javascript:void(0)" class="sc from_de">删除</a>-->
<!--                <a href="{:U('Material/addMedia')}" class="tjwzhang add_article">添加素材</a>-->
                <a href="<?php echo $this->get_url('Common','SyncAllList',array('nid'=>$_GET['nid']));?>" class="a5">同步素材</a>
            </div>
            <table class="bor_cen"  style="border-collapse:collapse;">
                <thead>
                <tr class="mid_01" style="border-left:3px solid #e4e3e3">
<!--                    <td class="mid_one" style="border-right:1px solid #e4e3e3"></td>-->
                    <td class="mid_t">标题</td>
                    <td class="mid_one">类型</td>
                    <td class="mid_f">图文ID</td>
                    <td class="mid_one">同步</td>
                    <td class="mid_f">创建时间：</td>
                    <td class="mid_s">操作</td>
                </tr>
                </thead>
                <tbody>
                <?php foreach($arr as $key=>$value){?>
                    <tr  class="mid_02" style="border-left:3px solid #cfbba9" data-id="<?php echo $value['media_id'];?>">
<!--                        <td class="mid_one" style="border-right:1px solid #e4e3e3"><input type="checkbox" /></td>-->
                        <td class="mid_t">
                            <div class="clip">
                                <?php

                                           if($value['data_type'] == "image"){
                                               echo "<a href=".$value['url']." data-lightbox=\"roadtrip\">".$value['title']."</a>";
                                           }elseif($value['data_type'] == "video"){
                                               echo "<div class=\"remodal-bg\">
                                        <div id=\"qunit\"></div>
                                        <a href=\"#\" id=\"video-title\" data-remodal-target=\"modal\" data-url=".$value['local_path'].">".$value['title']."</a>
                                               </div>";
                                           }elseif($value['data_type'] == "voice"){
                                               echo "<div class=\"remodal-bg\">
                                        <div id=\"voice-qunit\"></div>
                                        <a href=\"#\" id=\"voice-title\" data-remodal-target=\"voice-modal\" data-url=".$value['local_path'].">".$value['title']."</a>
                                               </div>";
                                           }else{
                                               echo $value['title'];
                                           }
                                    ?>


                            </div>
                        </td>
                        <td class="mid_one" style="text-align:center"><?php echo $value['data_type'];?></td>
                        <td class="mid_f"><?php echo $value['atricles_id'];?></td>
                        <td class="mid_one">
                            <?php
                              if($value['data_status']==1){
                                  echo "同步";
                              }else{
                                  echo "未同步";
                              }
                            ?>
                        </td>
                        <td class="mid_f" style="text-align:center"><?php echo date('Y-m-d H:i:s',$value['create_time']);?></td>
                        <td class="mid_s" style="text-align:center">
                            <a href="javascript:void(0);" data-id="<?php echo $value['media_id'];?>" class="del">删除</a>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
            <div class="interpret">
                <div class="page"><?php echo $page;?></div>
            </div>
        </div>
        <!-- form_con end -->
    </div>
</div>
<div class="remodal" data-remodal-id="modal" style="width:340px;height:164px;">
    <video id="example_video_1" class="video-js vjs-default-skin" controls preload="none" width="340" height="164" data-setup="{}">
        <source src="Public/Uploads/Multimedia/201508121401518467.mp4" type='video/mp4' />
    </video>
</div>
<div class="remodal" data-remodal-id="voice-modal" style="width:300px;height:30px;">
    <audio id="voice_player" controls="controls" height="100" width="100">
        <source  type="audio/mp3" />
        <embed height="100" width="100" />
    </audio>
</div>
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.js"></script>
<script src="http://vjs.zencdn.net/c/video.js"></script>

    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/lightbox.min.js"?>"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/remodal.js"?>"></script>
<script>
    $(function(){
        //删除
//        $(".del").on('click',function(){
//            var mediaId = $(this).data('id');
//            //console.log("{:U(Material/delMedia)}/media_id/"+mediaId);
//            if(confirm("您是否确认删除<"+mediaId+">?")){
//                location.href = "{:U('Material/delMedia')}/media_id/"+mediaId;
//            }
//        });

        //预览图片插件设置
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true
        });

        //全选
        var attrIn = $(".mid_02 input[type='checkbox']");
        $(".selectall").click(function(){
            attrIn.prop("checked",true)
        });

        //反选
        $(".unselected").click(function () {
            $("input[type='checkbox']").each(function () {
                $(this).prop("checked", !$(this).prop("checked"));
            });
        });
        //取消
        $(".select_f").click(function(){
            $("input[type='checkbox']").each(function(){
                $(this).prop("checked",false)
            });
        });
        //删除
//        $('.from_de').click(function () {
//            if(confirm("您是否确认删除选中的素材?")) {
//                $("input:checked").each(function () {
//                    var myself = $(this).parents('tr');
//                    var id = myself.data('id');
//                    $.post('/wechat/material/dels?mid=<?php //echo $this->mid?>//', {media_id: id}, function (d) {
//                        //console.log(data);
//                        if(d.code == 200){
//                            var k = $('.del');
//                            $(k).parent().parent().remove();
//                            layer.alert(d.msg,{icon:1});
//                        }else{
//                            layer.alert(d.msg,{icon:0});
//                        }
//                    },'json');
//                });
//            }
//        });
        //加载视屏URL
        $("#video-title").on('click',function(){
            var url = $(this).data('url');
            $("#example_video_1_html5_api").attr('src',url);
        });
        $("#voice-title").on('click',function(){
            var url = $(this).data('url');
            $("#voice_player").attr('src',url);
            //$("#voice_player embed").attr('src',url);
        });
    })
</script>

    <script type="text/javascript">
        $('.del').click(function(){
            var k = $(this);
            var v = $(k).attr('data-id');
            if(empty(v)) return false;
            $.post('/wechat/material/del?mid=<?php echo $this->mid?>',{id:v},function(d){
                if(d.code == 200){
                    $(k).parent().parent().remove();
                    layer.alert(d.msg,{icon:1});
                }else{
                    layer.alert(d.msg,{icon:0});
                }
            },'json')
        });
    </script>