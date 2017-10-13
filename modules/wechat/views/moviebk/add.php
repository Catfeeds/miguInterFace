<form action="" method="post" enctype="multipart/form-data">
    <table class="mtable" cellpadding="10" cellspacing="0" width="100%">
        <tr>
            <input type="hidden" name="gid" value="<?php echo $_REQUEST['mid']?>">
            <td align="right">上传类型：</td>
            <td><select name="type" id="type" class="form-input w200">
                    <option value="0">--请选择--</option>
                    <option <?php echo !empty($movie->type) && $movie->type ==1?'selected="selected"':''?> value="1">跳转牌照方客户端</option>
                    <option <?php echo !empty($movie->type) && $movie->type ==3?'selected="selected"':''?> value="3">应用商城</option>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right">牌照方：</td>
            <td>
                <select name="cp" id="cp" class="form-input w200">
                    <option value="0">--请选择--</option>
                    <option <?php echo !empty($movie->cp) && $movie->cp ==1?'selected="selected"':''?> value="1">华数客户端</option>
                    <option <?php echo !empty($movie->cp) && $movie->cp ==2?'selected="selected"':''?> value="2">百视通客户端</option>
                    <option <?php echo !empty($movie->cp) && $movie->cp ==3?'selected="selected"':''?> value="3">未来电视</option>
                    <option <?php echo !empty($movie->cp) && $movie->cp ==4?'selected="selected"':''?> value="4">南传</option>
                    <option <?php echo !empty($movie->cp) && $movie->cp ==7?'selected="selected"':''?> value="7">银河</option>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right">片名：</td>
            <td><input type="text" name="title" id="title" class="form-input w400" value="<?php echo !empty($movie->title)?$movie->title:''?>"></td>
        </tr>
        <tr>
            <td align="right">分类：</td>
            <td>
                <select name="classify" id="classify" class="form-input w200" onchange="aa()">
                    <option value="0">--请选择--</option>
                    <option <?php echo !empty($movie->classify) && $movie->classify =="电影"?'selected="selected"':''?> value="电影">电影</option>
                    <option <?php echo !empty($movie->classify) && $movie->classify =="电视"?'selected="selected"':''?> value="电视">电视</option>
                    <option <?php echo !empty($movie->classify) && $movie->classify =="综艺"?'selected="selected"':''?> value="综艺">综艺</option>
                    <option <?php echo !empty($movie->classify) && $movie->classify =="少儿"?'selected="selected"':''?> value="少儿">少儿</option>
                </select>
            </td>
        </tr>
        <tr style="display:none" class="show adds">
                <td align="right">剧集数量：</td>
                <td><input type="text" name="num" class="num form-input w400" value="<?php if(count($episode)==1){
                        echo '1';
                     }else{
                        echo count($episode);
                    }?>"></td>
            </tr>
        <?php if(count($episode)>1){foreach($episode as $k=>$v){?>
        <tr style="display:none" class="show addr">
            <td align="right">选集名称:</td>
            <td><input type="text" name="mname[]" class="mname[] form-input w400" value="<?php echo !empty($v->mname)?$v->mname:''?>"></td>
        </tr>
        <tr style="display:none" class="show addrs">
            <td align="right">选集url:</td>
            <td><input type="text" name="url[]" class="url[] form-input w400" value="<?php echo !empty($v->url)?$v->url:''?>"></td>
        </tr>
        <?php }}else{?>
            <tr style="display:none" class="show addr">
                <td align="right">选集名称:</td>
                <td><input type="text" name="mname[]" class="mname[] form-input w400" value="<?php echo !empty($episode->mname)?$episode->mname:''?>"></td>
            </tr>
            <tr style="display:none" class="show addrs">
                <td align="right">选集url:</td>
                <td><input type="text" name="url[]" class="url[] form-input w400" value="<?php echo !empty($episode->url)?$episode->url:''?>"></td>
            </tr>
        <?php }?>
        <tr>
            <td align="right">action：</td>
            <td><input type="text" name="action" id="action" value="<?php echo !empty($movie->action)?$movie->action:''?>" class="form-input w400"></td>
        </tr>
        <tr>
            <td align="right">param：</td>
            <td><input type="text" name="param" id="param" value="<?php echo !empty($movie->param)?$movie->param:''?>" class="form-input w400"></td>
        </tr>
        <tr>
            <td align="right">导演：</td>
            <td><input type="text" name="director" id="director" class="form-input w400" value="<?php echo !empty($movie->director)?$movie->director:''?>"></td>
        </tr>
        <tr>
            <td align="right">演员：</td>
            <td><input type="text" name="actor" id="actor" class="form-input w400" value="<?php echo !empty($movie->actor)?$movie->actor:''?>"></td>
        </tr>
        <tr>
            <td align="right">简介：</td>
            <td>
                <textarea cols="55" name="info" style="border: 1px solid #ccc;border-radius: 3px;height: 100px;box-shadow: 1px 1px 8px #dddddd inset;"><?php echo !empty($movie->info)?$movie->info:''?></textarea>
            </td>
        </tr>
        <tr>
            <td align="right">图片：</td>
            <td>
                <input id="imgs" name="imgs" type="file" value="" class="form-input w400" /><br />
                <input name="imgss" type="text" class="form-input w400" value="<?php echo !empty($movie->img)?$movie->img:''?>">
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
                <input type="submit" value="添加/保存" class="btn">
                <input type="button" value="返回列表" class="gray" onclick="window.location.href='<?php echo $this->get_url('movie','index',array('nid'=>$_GET['nid']));?>'">
            </td>
        </tr>
    </table>
</form>
<script>
    function aa(){
        var classify = $('#classify').val();
        if(classify=='电视' || classify=='综艺'){
            $('.show').show();
        }
    }

    $(function(){
        var classify = $('#classify').val();
        if(classify=='电视' || classify=='综艺'){
            $('.show').show();
        }
    })

    $('.num').blur(function(){
        var num = $('.num').val();
        $('.addr').remove();
        $('.addrs').remove();
        for(var i=0;i<num;i++){
            $('.adds').after("<tr class='show addr'><td align='right'>选集名称:</td><td><input type='text' name='mname[]' class='mname form-input w400' value=''></td></tr><tr class='show addrs'><td align='right'>选集url:</td><td><input type='text' class='url form-input w400' name='url[]' value=''></td></tr>")
        }
    })
</script>
