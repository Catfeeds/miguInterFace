<style type="text/css">
    .up-main li{
        float: left;
        margin-right: 10px;
    }
    .up-h-1,.up-h-2,.up-h-8,.up-h-9{background-color:#fff;width:75px;height:150px;}
    .up-h-8,.up-h-9{width:150px;}
    .up-h-2{margin-top:10px;}
    .mt5{margin-top:10px;}
    .mr5{margin-right:5px;}
    .up-h-3,.up-h-7{width:150px;height:310px;background-color:#fff;}
    .up-h-4{width:310px;height:150px;background-color:#fff;}
    .up-h-5,.up-h-6{width:150px;background-color:#fff;height:150px;}
    <?php echo '#'.$address?>{position: relative;}
    #upload_file{background-color:#000;cursor:pointer;position: absolute;top:0;left:0;}
    #upload_file object{left:0;top:0;}
    .myt{text-align:center;position:relative;
        border: 1px solid #787878;}
    .myt1{text-align:center;position:relative;border: 1px solid #787878;}
    .myt1 span{display: inline-block;width:70px;height:25px;position: absolute;top:0;left:0;}
    .myt span{display: inline-block;width:70px;height:25px;position: absolute;top:0;left:0;}
    #page span {margin: 5px;}
    .charging{display: none;}
    <?php
         if($ui[$address][0]['tType']== 1 || $ui[$address][0]['tType']==3){
          echo '#title{width:800px;};
             #ybutton{display:block;}
          ';
          }else{
          echo '#title{width:100%;};
             #ybutton{display:none;}
          ';
         }
       ?>
</style>
<script type="text/javascript" src="/js/uploadify/jquery.uploadify.min.js"></script>
<table class="mtable" width="100%" cellspacing="0" cellpadding="10">
    <tr>
        <td width="100" align="right">上传类型：</td>
        <td>
            <select name="tType" class="form-input w300" id="tType" onchange="aa()">
                <option value="0">请选择</option>
                <option <?php if($tType==1){echo "selected=selected"; } ?> value="1" >图片</option>
                <option <?php if($tType==2){echo "selected=selected"; } ?> value="2">视频</option>
                <option <?php if($tType==3){echo "selected=selected"; } ?> value="3">应用</option>
                <option <?php if($tType==4){echo "selected=selected"; } ?> value="4">自有节目</option>
                <option <?php if($tType==5){echo "selected=selected"; } ?> value="5">付费</option>
            </select>
            <p style="margin-top: -10px;">&nbsp;</p>
            <span id="show">
                <input type="radio" name="tong" onclick="dianbo()" id="dian">点播
                <input type="radio" name="tong" onclick="huibo()" id="hui">回播
            </span>
        </td>
    </tr>
    <tr>
        <td width="100" align="right">标题：</td>
        <td><input type="text" name="title" id="title" value="<?php echo !empty($ui[$address][$fid]['title'])?$ui[$address][$fid]['title']:''?>" class="form-input"><input type="submit" name="button" id="ybutton" class="seo-gray" value="搜索" style="float:right;"></td>
    </tr>
    <tr class="fenlei" style="display:none">
        <td width="100"></td>
        <td id="fenlei" align="center"></td>
    </tr>
    <tr class="page" style="display:none">
        <td colspan="2" align="center"><div id="page"></div></td>
    </tr>
    <tr>
        <td align="right" id="aaa">URL：</td>
        <td><input type="text" name="url" id="url" value="<?php echo !empty($ui[$address][$fid]['url'])?$ui[$address][$fid]['url']:''?>" class="form-input">
            <input type="text" readonly class="form-input" id="yingyong" style="display: none" value="例如：?viewType=2&appId=201405151707249">
            <input type="text" readonly class="form-input" id="dianbo" style="display: none" value="例如：?viewType=1&foldId=384&contentId=3001234826">
            <input type="text" readonly class="form-input" id="huibo" style="display: none" value="例如：http://wasuott.itv.cmvideo.bcn/a?f=29820&recidentifying=bbqne1507">
        </td>
    </tr>
    <tr class="charging">
        <td align="right">时长：</td>
        <td><input type="text" name="duration" id="duration" value="<?php echo !empty($pay[0]['duration'])?$pay[0]['duration']:''?>" class="form-input w300" width="100px"> 分钟</td>
    </tr>
    <tr class="charging">
        <td align="right">年份：</td>
        <td><input type="text" name="year" id="year" value="<?php echo !empty($pay[0]['year'])?$pay[0]['year']:''?>" class="form-input w300"> 年</td>
    </tr>
    <tr class="charging">
        <td align="right">国家：</td>
        <td><input type="text" name="country" id="country" value="<?php echo !empty($pay[0]['country'])?$pay[0]['country']:''?>" class="form-input w300"></td>
    </tr>
    <tr class="charging">
        <td align="right">类型：</td>
        <td><input type="text" name="form" id="form" value="<?php echo !empty($pay[0]['form'])?$pay[0]['form']:''?>" class="form-input w300"></td>
    </tr>
    <tr class="charging">
        <td align="right">热门指数：</td>
        <td><input type="text" name="hot" id="hot" value="<?php echo !empty($pay[0]['hot'])?$pay[0]['hot']:''?>" class="form-input w300"> 请输入1~100的数字</td>
    </tr>
    <tr class="charging">
        <td align="right">导演：</td>
        <td><input type="text" name="director" id="director" value="<?php echo !empty($pay[0]['director'])?$pay[0]['director']:''?>" class="form-input w300"></td>
    </tr>
    <tr class="charging">
        <td align="right">主演：</td>
        <td><input type="text" name="actor" id="actor" value="<?php echo !empty($pay[0]['actor'])?$pay[0]['actor']:''?>" class="form-input"></td>
    </tr>
    <tr class="charging">
        <td align="right">播放连接：</td>
        <td><input type="text" name="link" id="link" value="<?php echo !empty($pay[0]['link'])?$pay[0]['link']:''?>" class="form-input">
            <textarea class="form-input" style="width: 700px;height:35px">例如：http://gslbserv.itv.cmvideo.cn:80/123.m3u8?channel-id=wasusyt&Contentid=8835439207829435185&stbId={XXXX}&usergroup={XXXX}&livemode=1&authCode={XXXX}</textarea>
        </td>
    </tr>
    <tr class="charging">
        <td align="right">剧情介绍：</td>
        <td><textarea name="epitasis" class="form-input" style="width: 300px;height: 100px" id="epitasis"><?php echo !empty($pay[0]['epitasis'])?$pay[0]['epitasis']:''?></textarea> 请输入不多于100个字！</td>
    </tr>
    <tr>
        <td align="right" valign="top">图片上传：</td>
        <td>
            <div class="up-main" id="main">
                <span>请上传宽为<?php echo $w;?>，高为<?php echo $h;?>的图片！</span>
                <?php echo $html;?>

            </div>
        </td>
    </tr>
    <tr>
        <td align="center" colspan="2">
            <input type="button" value="保存信息" class="btn save">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" value="取消" class="gray">
        </td>
    </tr>
</table>
<input type="hidden" name="provinceCode"  value="<?php echo !empty($provinceCode) ? $provinceCode :'0'?>" />
<input type="hidden" name="cityCode"  value="<?php echo !empty($cityCode) ? $cityCode :'0'?>" />
<input type="hidden" name="key" id="tupian" value="<?php echo !empty($ui[$address][$fid]['bigImg'])?$ui[$address][$fid]['bigImg']:''?>">
<input type="hidden" name="id" value="<?php echo !empty($ui[$address][$fid]['id'])?$ui[$address][$fid]['id']:''?>">
<input type="hidden" name="position" value="<?php echo $address;?>">
<input type="hidden" name="type" value="<?php echo $type;?>">

<script type="text/javascript">

    var z = $("#tType").val();
    if(z == 1){
        $("#show").show();
    }
    if(z == 3){
        $("#show").hide();
        $("#yingyong").show();
    }
    if(z == 2){
        $("#show").hide();
    }
    if(z == 4){
        $("#show").hide();
    }
    if(z == 5){
        $("#show").hide();
        $(".charging").show();
        $('#ybutton').css('display','none');
    }
    function aa(){
        var zhi = $("#tType").val();
        if(zhi == 0){
            $('#title').css('width','100%');
            $('#ybutton').css('display','none');
            $('#fenlei').empty();
            $('#page').empty();
            $('.fenlei').css('display','none');
            $('.page').css('display','none');
            $(".charging").hide();
            $("#aaa").text("URL：");
        }
        if(zhi==1){
            $("#show").show();
            $("#yingyong").hide();
            //$("#dianbo").show();
            $("#dian").removeAttr("checked");
            $("#hui").removeAttr("checked");
            $('#title').css('width','800px');
            $('#ybutton').css('display','block');
            $('#fenlei').empty();
            $('#page').empty();
            $('.fenlei').css('display','none');
            $('.page').css('display','none');
            $(".charging").hide();
            $("#aaa").text("URL：");
        }
        if(zhi==3){
            $("#yingyong").show();
            $("#huibo").hide();
            $("#dianbo").hide();
            $("#show").hide();
            $('#title').css('width','800px');
            $('#ybutton').css('display','block');
            $('#fenlei').empty();
            $('#page').empty();
            $('.fenlei').css('display','none');
            $('.page').css('display','none');
            $(".charging").hide();
            $("#aaa").text("URL：");
        }
        if(zhi==2){
            $("#show").hide();
            $("#yingyong").hide();
            $("#dianbo").hide();
            $("#huibo").hide();
            $('#title').css('width','100%');
            $('#ybutton').css('display','none');
            $('#fenlei').empty();
            $('#page').empty();
            $('.fenlei').css('display','none');
            $('.page').css('display','none');
            $(".charging").hide();
            $("#aaa").text("URL：");
        }
        if(zhi==4){
            $("#show").hide();
            $("#yingyong").hide();
            $("#dianbo").hide();
            $("#huibo").hide();
            $('#title').css('width','100%');
            $('#ybutton').css('display','none');
            $('#fenlei').empty();
            $('#page').empty();
            $('.fenlei').css('display','none');
            $('.page').css('display','none');
            $(".charging").hide();
            $("#aaa").text("URL：");
        }
        if(zhi == 5){
            $("#show").hide();
            $("#yingyong").hide();
            $(".charging").show();
            $("#aaa").text("资产ID：");
            $('#ybutton').css('display','none');
            $("#links").show();
        }
    }
    function dianbo(){
        $("#dianbo").show();
        $("#huibo").hide();
    }
    function huibo(){
        $("#huibo").show();
        $("#dianbo").hide();
    }
    $('.up-main li:last-child').css('margin-right','0');
    $(function(){
        $('.up-main').find('#<?php echo $address?>').find('a').replaceWith('<input type="file" id="upload_file">');
    });
    var start;
    $('#upload_file').uploadify({
        'auto': true,//关闭自动上传
        'buttonImage': '/images/up1.png',
        'width': 70,
        'height': 26,
        'swf': '/js/uploadify/uploadify.swf',
        'uploader': '/upload/img',
        'method': 'post',//方法，服务端可以用$_POST数组获取数据
        'buttonText': '选择图片',//设置按钮文本
        'queueID' : 'queueid',
        'multi': false,//允许同时上传多张图片
        'uploadLimit': 10,//一次最多只允许上传10张图片
        'fileTypeExts': '*',//限制允许上传的图片后缀
        'sizeLimit': 10240000000,//限制上传的图片不得超过200KB
        'onSelect'      : function(file){

            var type = file.type;
            var img = ['.jpg','.jpeg','.png','.gif'];
            var myself = this;
            //layer.alert(file.size);


            if(!in_array(type,img)){
                myself.cancelUpload();
                layer.alert("这不是图片");
                return false;
            }
        },
        'onUploadStart' :function(file){
            start = layer.load(0, {icon: 16,shade: [0.3,'#000']});
        },
        'onUploadSuccess' : function(file, data, response) {//每次成功上传后执行的回调函数，从服务端返回数据到前端
            layer.close(start);
            var value = eval('('+data+')');
            if(value.code == 200){
                $('input[name=key]').val(value.key);
                var l = $('#main').find('#<?php echo $address?>').find('img');
                if(l.length < 1){
                    $('#main').find('#<?php echo $address?>').append('<img src="'+value.url+'" width="100%" height="100%">');
                }else{
                    $(l).attr('src',value.url);
                }
            }else{
                layer.alert(value.msg,{icon:0});
            }
        },
        'onError':function(err){
            layer.alert(err);
        }
    });

    $('.save').click(function(){
        var k = $(this);
        var G = {};
        G.title = $('#title').val();
        G.url = $('#url').val();
        G.position = $('input[name=position]').val();
        //G.key = $('input[name=key]').val();
        G.key = $('#tupian').val();
        G.type = $('input[name=type]').val();
        G.tType = $('select[name=tType]').val();
        G.id = $('input[name=id]').val();
        G.duration = $("#duration").val();
        G.year     = $("#year").val();
        G.country  = $("#country").val();
        G.form     = $("#form").val();
        G.hot      = $("#hot").val();
        G.director = $("#director").val();
        G.actor    = $("#actor").val();
        G.epitasis = $("#epitasis").val();
        G.link     = $("#link").val();
        if(empty(G.tType)){
            layer.alert('上传类型不能为空',{icon:0});
            return false;
        }
        if(empty(G.title)){
            layer.alert('标题不鞥为空',{icon:0});
            return false;
        }
        if(empty(G.url)){
            layer.alert('链接不鞥为空',{icon:0});
            return false;
        }

        if(empty(G.position)){
            layer.alert('系统错误',{icon:0});
            return false;
        }

        if(empty(G.key)){
            layer.alert('系统错误',{icon:0});
            return false;
        }
        if(empty(G.type)){
            layer.alert('系统错误',{icon:0});
            return false;
        }
        G.provinceCode = $('input[name=provinceCode]').val();
        G.cityCode = $('input[name=cityCode]').val();
        //alert(G.provinceCode);
        //alert(G.cityCode);

        var load = layer.load(0, {icon: 16,shade: [0.3,'#000']});
        $.post('/admin/test/add?mid=<?php echo $this->mid?>',G,function(d){
            if(d.code == 200){
                location.reload();
            }else{
                layer.close(load);
                layer.alert(d.msg);
            }
        },'json')
    });
    function validate_edit_logo() {
        debugger;
        var file = "file:///"+ $('#File1').val();
        if (!/.(gif|jpg|jpeg|png|gif|jpg|png)$/.test(file)) {
            alert("图片类型必须是.gif,jpeg,jpg,png中的一种")
            if (a == 1) {
                return false;
            }
        } else {
            var image = new Image();
            image.src = file;
            var height = image.height;//得到高
            var width = image.width;//得到宽
            var filesize = image.fileSize;//图片大小

            if (width > 80 && height > 80 && filesize > 102400) {
                alert('请上传80*80像素 或者大小小于100k的图片');
                if (a == 1) {
                    return false;
                }
            }
            if (a == 1) {
                $("#img1").attr("src", file);
                return true;

            }
        }
    }
    $('body').on('click','.gray',function(){
        layer.closeAll();
    });

    var page_cur = 1; //当前页
    var total_num, page_size, page_total_num;//总记录数,每页条数,总页数

    function getData(page) { //获取当前页数据
        var tType = $('#tType').val();
        var val = $('#title').val();
        if(val =='') return false;
        //alert(tType);
        if(tType ==1){
            $.ajax({
                type: 'GET',
                url: '/admin/test/sousuo?mid='+"<?php echo $_GET['mid'];?>"+'&val='+val+'&type='+tType,
                data: {'page': page - 1},
                dataType: 'json',
                success: function(json) {
                    $("#fenlei").empty();
                    total_num = json.total_num;//总记录数
                    page_size = json.page_size;//每页数量
                    page_cur = page;//当前页
                    page_total_num = json.page_total_num;//总页数
                    var li = '<table width="700px" border="1"><tr><th>vid</th><th>title</th><th>type</th><th>cate</th></tr>';
                    var list = json.list;
                    $.each(list, function(index, array) { //遍历返回json
                        li += "<tr><td>"+array['vid']+"</td><td>"+array['title']+"</td><td>"+array['type']+"</td><td>"+array['cate']+"</td></tr>";
                    });
                    if(list == '') li +='<tr><td  colspan="4" align="center">暂无数据</td></tr>';
                    li += '</table>'
                    $("#fenlei").append(li);
                },
                complete: function() {
                    getPageBar();//js生成分页，可用程序代替
                },
                error: function() {
                    alert("数据异常,请检查是否json格式");
                }
            });
        }else{
            $.ajax({
                type: 'GET',
                url: '/admin/test/sousuo?mid='+"<?php echo $_GET['mid']?>"+'&val='+val+'&type='+tType,
                data: {'page': page - 1},
                dataType: 'json',
                success: function(json) {
                    $("#fenlei").empty();
                    total_num = json.total_num;//总记录数
                    page_size = json.page_size;//每页数量
                    page_cur = page;//当前页
                    page_total_num = json.page_total_num;//总页数
                    var li = '<table width="700px" border="1"><tr><th>appId</th><th>name</th><th>typeId</th><th>typeName</th></tr>';
                    var list = json.list;
                    $.each(list, function(index, array) { //遍历返回json
                        li += "<tr><td>"+array['appId']+"</td><td>"+array['name']+"</td><td>"+array['typeId']+"</td><td>"+array['typeName']+"</td></tr>";
                    });
                    if(list == '') li +='<tr><td  colspan="4" align="center">暂无数据</td></tr>';
                    li += '</table>';
                    $("#fenlei").append(li);
                },
                complete: function() {
                    getPageBar();//js生成分页，可用程序代替
                },
                error: function() {
                    alert("数据异常,请检查是否json格式");
                }
            });
        }
    }

    function getPageBar() { //js生成分页
        if (page_cur > page_total_num)
            page_cur = page_total_num;//当前页大于最大页数
        if (page_cur < 1)
            page_cur = 1;//当前页小于1
        page_str = "<span>共" + total_num + "条</span><span>" + page_cur + "/" + page_total_num + "</span>";
        if (page_cur == 1) {//若是第一页
            page_str += "<span>首页</span><span>上一页</span>";
        } else {
            page_str += "<span><a href='javascript:void(0)' data-page='1' onclick=getData(1)>首页</a></span><span><a href='javascript:void(0)' data-page='" + (page_cur - 1) + "' onclick=getData("+ (parseInt(page_cur) - 1) +")>上一页</a></span>";
        }
        if (page_cur >= page_total_num) {//若是最后页
            page_str += "<span>下一页</span><span>尾页</span>";
        } else {
            page_str += "<span><a href='javascript:void(0)' data-page='" + (parseInt(page_cur) + 1) + "' onclick=getData("+ (parseInt(page_cur) + 1) +") >下一页</a></span><span><a href='javascript:void(0)' data-page='" + page_total_num + "'  onclick=getData("+ (page_total_num) +")>尾页</a></span>";
        }
        $("#page").html(page_str);
    }

    $('#ybutton').click(function(){
        $('.fenlei').css('display','');
        $('.page').css('display','');
        $('#fenlei').empty();
        $('#page').empty();
        getData(1);
        return false;
    });
</script>