<link rel="stylesheet" type="text/css" href="/js/uploadify/uploadify.css">
<script type="text/javascript" src="/js/uploadify/jquery.uploadify.min.js"></script>
<div>
    <div id="admin_border">
        <form name="myForm" action="" method="post" enctype="multipart/form-data">
            <table width="100%" cellpadding="10" cellspacing="0">
                <tr>
                    <td width="100" align="right">上传地址：</td>
                    <td>
                        <div style="width:300px;float:left;"><input type="text" name="path" id="audio" readonly class="form-input w300" style="border:1px solid"/></div>
                        <div style="float:left;margin-right:10px;"><input id="file_upload1" name="file_upload" type="file" multiple="true"></div>
                        <div style="clear: both;"></div>
                        <script>
                            var i = 0;//初始化数组下标
                            $(function () {
                                $('#file_upload1').uploadify({
                                    'auto': true,//关闭自动上传
                                    'buttonImage': '/images/02.png',
                                    'width': 98,
                                    'height': 36,
                                    'swf': '/js/uploadify/uploadify.swf',
                                    'uploader': '/wechat/movie/appadd?mid=<?php echo $_GET['mid']?>',
                                    'method': 'post',//方法，服务端可以用$_POST数组获取数据
                                    'buttonText': '选择图片',//设置按钮文本
                                    'multi': false,//允许同时上传多张图片
                                    'uploadLimit': 10,//一次最多只允许上传10张图片
                                    'fileTypeExts': '*',//限制允许上传的图片后缀
                                    'sizeLimit': 10240000000,//限制上传的图片不得超过200KB
                                    //   'onSelect':onSelect,
                                    'onUploadSuccess': function (file, data, response) {//每次成功上传后执行的回调函数，从服务端返回数据到前端
                                        //图片预览
                                        var value = eval('('+data+')');
                                        if(value.code == 200){
                                            $('#verStr').val(value.bate);
                                            $('#pname').val(value.apk);
                                            $('#version').val(value.codes);
                                            $('#audio').val(value.url);
                                            $('.is_hide').show();
                                        }else{
                                            alert(value.msg);
                                        }
                                    },

                                    'onSelect': function(data) {
                                        var result1 = data.size;
                                        if (result1) {
                                            $('#size').val(result1);
                                        }

                                    },

                                    'onQueueComplete': function (queueData) {//上传队列全部完成后执行的回调函数
                                        // if(img_id_upload.length>0)
                                        // alert('成功上传的文件有：'+encodeURIComponent(img_id_upload));
                                    }

                                });
                            });
                            //

                        </script>
                    </td>
                </tr>
                <tr class="is_hide" style="display:none;">
                    <td width="100" align="right">版本：</td>
                    <td>
                        <div style="width:300px;">
                            <input type="text" name="version" id="version" class="form-input w400" readonly="readonly"/>
                        </div>
                    </td>
                </tr>
                <tr class="is_hide" style="display:none;">
                    <td width="100" align="right">包名：</td>
                    <td>
                        <div style="width:300px;">
                            <input type="text" name="pname" id="pname" class="form-input w400" readonly="readonly"/>
                        </div>
                    </td>
                </tr>
                <tr class="is_hide" style="display:none;">
                    <td width="100" align="right">版本代号：</td>
                    <td>
                        <div style="width:300px;">
                            <input type="text" name="verStr" id="verStr" class="form-input w400" readonly="readonly"/>
                        </div>
                    </td>
                </tr>
                <tr class="is_hide" style="display:none;">
                    <td width="164" align="right">客户端大小：</td>
                    <td>
                        <div class="tame not_img" style="width:300px;">
                            <input type="text" name="size" id="size" readonly class="form-input w400"/>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right">平台标识：</td>
                    <td>
                        <div style="width:400px;">
                            <input type="radio" name="app" value="1" id="1"><label for="1">安卓</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="100" align="right">新特性：</td>
                    <td>
                        <div style="width:600px;">
                            <textarea id="per" class="form-input w400" rows="4"   name="per" style="width:300px;height:200px;border:1px solid"></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>
                        <input type="submit" class="btn btn-blue btn-padding20 mr20" name="" id="submit" value="添加内容"/>
                        <input type="button" class="btn btn-blue btn-padding20 contentSave" onclick="history.go(-1)" value="返回"/>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<script type="text/javascript">
    $('#submit').click(function(){
        var version = $('#version').val();
        var pname = $('#pname').val();
        var verStr = $('#verStr').val();
        var per = $('#per').val();

        if(empty(version)){
            alert('版本号不能为空');
            return false;
        }
        if(empty(pname)){
            alert('包名不能为空');
            return false;
        }
        if(empty(verStr)){
            alert('版本代号不能为空');
            return false;
        }
        if(empty(per)){
            alert('新特性不能为空');
            return false;
        }
    })
</script>

