<style>
    .box5 {
        /*background: url("/Public/images/333.jpg") no-repeat scroll -2px -2px rgba(0, 0, 0, 0);*/
        display: inline-block;
        float: right;
        height: 30px;
        vertical-align: middle;
        width: 32px;
        z-index: 9999;
        margin-right: 9px;

    }

    .upload {
        /*   position: absolute;*/
        right: 4px;
        top: 0;
        z-index: 999;

    }

    .box12 {
        margin-left: 304px;
        margin-top: -57px;
    }

    .box13 {
        height: 212px;
        width: 921px;
    }

    .audioplayer {
        border-radius: 2px;
    }

    .audioplayer, .audioplayer-volume-adjust {
        background: linear-gradient(to bottom, #444, #222) repeat scroll 0 0 rgba(0, 0, 0, 0);
    }

    .audioplayer {
        box-shadow: 0 1px 0 rgba(255, 255, 255, 0.15) inset, 0 0 1.25em rgba(0, 0, 0, 0.5);
    }

    .audioplayer {
        background: none repeat scroll 0 0 #333;
        border: 1px solid #222;
        color: #fff;
        height: 2.5em;
        position: relative;
        text-shadow: 1px 1px 0 #000;
        z-index: 1;
        width: 335px;
    }

    .box14 {
        float: right;
        margin-right: -100px;
        margin-top: -35px;
        position: relative;
    }
</style>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/js/upload/uploadify.css">
<script src="__PUBLIC__/js/upload/jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="__PUBLIC__/css/jquery.datetimepicker.css"/>
<!-- 时间插件-->
<script src="__PUBLIC__/js/jquery.datetimepicker.js"></script>
<div>
    <div id="admin_border">
        <form name="myForm" action="" method="post"  enctype="multipart/form-data">
            <table width="100%" cellpadding="10" cellspacing="0">
                <tr>
                    <td width="100" align="right">标题：</td>
                    <td>
                        <div style="width:300px;">
                            <input type="text" name="title" id="title" class="form-control" value=""/></div>
                    </td>
                </tr>

                <tr>
                    <td width="100" align="right"></td>
                    <td>
                        <div class="upload10">
                            <div id="wrapper" style="width:300px;margin-top:-20px;">
                                <div class="audioplayer audioplayer-stopped not_img">
                                    <audio preload="auto" id="upload10" controls style="margin-left: 21px;margin-top:5px;">
                                        <source src=""/>
                                    </audio>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right">背景图：</td>
                    <td>
                        <div style="width:300px;margin-top:9px;">
                            <input type="text" readonly  class="form-control"/>
                            <!--<input class="btn btn-blue box12" type="button" value="选择图片" name="back">-->
                            <div style="float: right;margin-top: -35px;margin-right: -100px;">
                                <input id="file_upload" name="file_upload" type="file"  multiple="true">
                            </div>
                        </div>
                        <span style="float: right;margin-top:-28px;margin-right:303px;">只支持jpg、png格式且为1920*1080的尺寸</span>
                    </td>

                </tr>
                <tr class="repass">
                    <td width="100" align="right"></td>
                    <td>
                        <div class="box13">
                            <input type="hidden" name="imgKey" id="imgKey">
                            <div class="box1 box4">
                                <a class="upload">
                                    <a href="javascript:void(0)"><em class="box5"></em></a>
                                </a>
                                <img id="imgKey[]" height="157" width="265" src="">
                            </div>
                        </div>

                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <input type="submit" class="btn btn-blue btn-padding20 mr20" name="" id="submit"
                               value="添加内容"/>
                        <input type="button" class="btn btn-blue btn-padding20 contentSave"
                               onclick="history.go(-1)" value="返回"/>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>