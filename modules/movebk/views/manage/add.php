<link rel="stylesheet" href="/js/jquery.datetimepicker.css">
<script type="text/javascript" charset="utf-8" src="/js/jquery.datetimepicker.js"></script>
<form action="" method="post">
    <table width="100%" cellspacing="0" cellpadding="10" class="mtable">
        <tr>
            <td align="right" style="width: 100px">牌照方：</td>
            <td><span><input type="text" name="cp" value="<?php echo !empty($manage->cp)?$manage->cp:''?>" class="form-input w200"></span></td>
        </tr>
        <tr>
            <td align="right">省：</td>
            <td><span><input type="text" name="province" value="<?php echo !empty($manage->province)?$manage->province:''?>" class="form-input w200"></span></td>
        </tr>
        <tr>
            <td align="right">市：</td>
            <td><span><input type="text" name="city" value="<?php echo !empty($manage->city)?$manage->city:''?>" class="form-input w200"></span></td>
        </tr>
        <tr>
            <td align="right">板块：</td>
            <td><span><input type="text" name="plate" value="<?php echo !empty($manage->plate)?$manage->plate:''?>" class="form-input w200"></span></td>
        </tr>
        <tr>
            <td align="right">位置：</td>
            <td><span><input type="text" name="position" value="<?php echo !empty($manage->position)?$manage->position:''?>" class="form-input w200"></span></td>
        </tr>
        <tr>
            <td align="right" valign="top">内容描述：</td>
            <td><textarea name="content" class="form-input w400" style="height:200px;resize: none;"><?php echo !empty($manage->content)?$manage->content:''?></textarea></td>
        </tr>
        <tr>
            <td align="right">有效期：</td>
            <td>
                <span><input type="text" name="time" value="<?php echo !empty($manage->time)?date('Y-m-d',$manage->time):''?>" id="time" class="form-input w200"></span>
            </td>
        </tr>
        <tr>
            <td align="right">编辑人：</td>
            <td><span><input type="text" name="editor" value="<?php echo !empty($manage->editor)?$manage->editor:''?>" class="form-input w200"></span></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
                <input type="submit" value="保存管理" class="btn">
                <input type="button" value="返回列表" class="gray" onclick="window.location.href='<?php echo Yii::app()->createUrl('/admin/manage/index',array('mid'=>$this->mid,'nid'=>$_GET['nid']))?>'">
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
    $(function(){
        $('#time').datetimepicker({
            validateOnBlur:false,
            format : 'Y-m-d',
            timepicker : false,
            minDate : '<?php echo date('Y-m-d')?>',
        })
    });
</script>