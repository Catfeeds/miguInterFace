<form downloadUrl="" method="post" enctype="multipart/form-data">
    <table class="mtable" cellpadding="10" cellspacing="0" width="100%">
        <tr>
            <td align="right">片名：</td>
            <td><input type="text" name="name" id="name" class="form-input w400" value="<?php echo !empty($app->name)?$app->name:''?>"></td>
        </tr>
        <tr>
            <td align="right">appid：</td>
            <td><input type="text" name="appid" id="appid" class="form-input w400" value="<?php echo !empty($app->appid)?$app->appid:''?>"></td>
        </tr>
        <tr>
            <td align="right">分类：</td>
            <td>
                <select name="type" id="type" class="form-input w200">
                    <option value="0">--请选择--</option>
                    <option <?php echo !empty($app->type) && $app->type =="影音"?'selected="selected"':''?> value="影音">影音</option>
                    <option <?php echo !empty($app->type) && $app->type =="工具"?'selected="selected"':''?> value="工具">工具</option>
                    <option <?php echo !empty($app->type) && $app->type =="游戏"?'selected="selected"':''?> value="游戏">游戏</option>
                    <option <?php echo !empty($app->type) && $app->type =="其他"?'selected="selected"':''?> value="其他">其他</option>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right">action：</td>
            <td><input type="text" name="action" id="action" value="<?php echo !empty($app->action)?$app->action:''?>" class="form-input w400"></td>
        </tr>
        <tr>
            <td align="right">param：</td>
            <td><input type="text" name="param" id="param" value="<?php echo !empty($app->param)?$app->param:''?>" class="form-input w400"></td>
        </tr>
        <tr>
            <td align="right">下载地址：</td>
            <td><input type="text" name="downloadUrl" id="downloadUrl" value="<?php echo !empty($app->downloadUrl)?$app->downloadUrl:''?>" class="form-input w400"></td>
        </tr>
        <tr>
            <td align="right">包名 ：</td>
            <td><input type="text" name="packageName" id="packageName" value="<?php echo !empty($app->packageName)?$app->packageName:''?>" class="form-input w400"></td>
        </tr>
        <tr>
            <td align="right">作者：</td>
            <td><input type="text" name="creatorName" id="creatorName" class="form-input w400" value="<?php echo !empty($app->creatorName)?$app->creatorName:''?>"></td>
        </tr>
        <tr>
            <td align="right">应用大小：</td>
            <td><input type="text" name="size" id="size" class="form-input w400" value="<?php echo !empty($app->size)?$app->size:''?>"></td>
        </tr>
        <tr>
            <td align="right">版本号：</td>
            <td><input type="text" name="version" id="version" class="form-input w400" value="<?php echo !empty($app->version)?$app->version:''?>"></td>
        </tr>
        <tr>
            <td align="right">简介：</td>
            <td>
                <textarea cols="55" name="description" style="border: 1px solid #ccc;border-radius: 3px;height: 100px;box-shadow: 1px 1px 8px #dddddd inset;"><?php echo !empty($app->description)?$app->description:''?></textarea>
            </td>
        </tr>
        <tr>
            <td align="right">图片：</td>
            <td>
                <input id="imgs" name="imgs" type="file" value="" class="form-input w400" /><br />
                <input name="imgss" type="text" class="form-input w400" value="<?php echo !empty($app->imageUrl)?$app->imageUrl:''?>">
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
                <input type="submit" value="添加/保存" class="btn">
                <input type="button" value="返回列表" class="gray" onclick="window.location.href='<?php echo $this->get_url('app','detail',array('nid'=>$_GET['nid']));?>'">
            </td>
        </tr>
    </table>
</form>
<script>
    $('#appid').blur(function(){
        var appid = $('#appid').val();
        $.getJSON('http://appcenter.itv.cmvideo.cn:17080/portal-ott/ott/system/detail.jsp?appId='+appid+'&areaId=02',function(d){
            console.log(d);
        })
    })
</script>
