<script type="text/javascript" src="/js/uploadify/jquery.uploadify.min.js"></script>
<table class="mtable" width="100%" cellspacing="0" cellpadding="10">
    <tr>
        <td width="100" align="right">上传类型：</td>
        <td>
            <select name="tType" class="form-input w300" id="tType" onchange="aa()">
                <option value="0">请选择</option>
                <option <?php if($tType==1){echo "selected=selected"; } ?> value="1" >跳转牌照方客户端</option>
            </select>
        </td>
    </tr>
    <tr id="show" style="display:none">
        <td width="100" align="right">牌照方：</td>
        <td>
            <select name="cp" class="form-input w300" id="cp">
                <option value="0">请选择</option>
                <option <?php if($cp==1){echo "selected=selected"; } ?> value="1">华数客户端</option>
                <option <?php if($cp==2){echo "selected=selected"; } ?> value="2">百视通客户端</option>
                <option <?php if($cp==3){echo "selected=selected"; } ?> value="3">未来电视</option>
                <option <?php if($cp==4){echo "selected=selected"; } ?> value="4">南传</option>
                <option <?php if($cp==5){echo "selected=selected"; } ?> value="5">芒果</option>
                <option <?php if($cp==6){echo "selected=selected"; } ?> value="6">国广</option>
                <option <?php if($cp==7){echo "selected=selected"; } ?> value="7">银河</option>
            </select>
        </td>
    </tr>
    <tr>
        <td width="100" align="right">标题：</td>
        <td><input type="text" name="title" id="title" value="<?php echo !empty($tool['title'])?$tool['title']:''; ?>" class="form-input">
        </td>
    </tr>

    <tr>
        <td width="100" align="right">action：</td>
        <td><input type="text" name="action" id="action" value="<?php echo !empty($tool['action'])?$tool['action']:''; ?>" class="form-input"></td>
    </tr>
    <tr>
        <td width="100" align="right">param：</td>
        <td><input type="text" name="param" id="param" value="<?php echo !empty($tool['param'])?$tool['param']:''; ?>" class="form-input"><input type="submit" name="button" id="pbutton" class="seo-gray" value="搜索" style="float:left;margin-left:650px;margin-top:-35px;display:none"></td>
    </tr>
    <tr>
        <td align="center" colspan="2">
            <input type="button" value="保存信息" class="btn save">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" value="取消" class="gray" onClick="javascript :history.back(-1);">
        </td>
    </tr>
</table>
<input type="hidden" name="id" value="<?php echo $id;?>">
<input type="hidden" name="position" id="position" value="<?php echo $pos;?>">
<input type="hidden" name="epg" id="epg" value="<?php echo $epg;?>">
<input type="hidden" name="gid" id="gid" value="<?php echo $gid;?>">
<script>
$(function(){
    if($('#tType').val()==1){
        $('#show').show();
    }
})
    function aa(){
        var zhi = $("#tType").val();
        if(zhi == 0){
            $(".charging").hide();
            $("#aaa").text("URL：");
        }
        if(zhi==1){
            $("#show").show();
            $("#yingyong").hide();
            $("#dian").removeAttr("checked");
            $("#hui").removeAttr("checked");
            $(".charging").hide();
            $("#aaa").text("URL：");
            $('#param').css('width','100%');
            $('#pbutton').css('display','none');
        }
        if(zhi==3){
            $("#yingyong").show();
            $("#huibo").hide();
            $("#dianbo").hide();
            $("#show").hide();
            $(".charging").hide();
            $("#aaa").text("URL：");
            $('#param').css('width','100%');
            $('#pbutton').css('display','none');
        }
        if(zhi==2){
            $("#show").hide();
            $("#yingyong").hide();
            $("#dianbo").hide();
            $("#huibo").hide();
            $(".charging").hide();
            $("#aaa").text("URL：");
            $('#param').css('width','100%');
            $('#pbutton').css('display','none');
        }
        if(zhi==4){
            $("#show").hide();
            $("#yingyong").hide();
            $("#dianbo").hide();
            $("#huibo").hide();
            $(".charging").hide();
            $("#aaa").text("URL：");
            $('#param').css('width','100%');
            $('#pbutton').css('display','none');
        }
        if(zhi == 5){
            $("#show").hide();
            $("#yingyong").hide();
            $(".charging").show();
            $("#aaa").text("资产ID：");
            $('#param').css('width','100%');
            $('#pbutton').css('display','none');
        }
        if(zhi == 6){
            $("#show").hide();
            $('#param').css('width','600px');
            $('#pbutton').css('display','block');
        }
    }

    $('.save').click(function(){
        var k = $(this);
        var G = {};
        G.position = $('input[name=position]').val();
        G.id = $('input[name=id]').val();
        G.type  = $('#type').val();

        G.tType  = $('#tType').val();
        G.title  = $('#title').val();
        G.action = $('#action').val();
        G.param  = $('#param').val();
        G.cp     = $('#cp').val();
        G.gid    = $('#gid').val();
        G.epg    = $('#epg').val();
        if(empty(G.tType)){
            layer.alert('上传类型不能为空',{icon:0});
            return false;
        }
        if(empty(G.title)) {
            layer.alert('标题不鞥为空', {icon: 0});
            return false;
        }

        if(empty(G.position)){
            layer.alert('系统错误',{icon:0});
            return false;
        }
        $.post('/move/nation/edits?mid=<?php echo $this->mid?>',G,function(d){
            if(d.code == 200){
                window.location.href = '/move/nation/default.html?mid=<?php echo $this->mid?>&nid=<?php echo $_GET['gid']?>';
            }else{
                layer.alert(d.msg);
            }
        },'json')
    });
    /*$('.gray').click(function(){

    })*/
</script>

