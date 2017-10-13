<form action="" method="post">
    <table width="100%" cellspacing="0" cellpadding="10" class="mtable">
        <tr>
            <td colspan="2" align="left" valign="top">VIP用户数：394</td>
        </tr>
        <tr>
            <td colspan="2" align="left" valign="top">微信绑定用户数：<?php echo $cnt; ?></td>
        </tr>
        <tr>
            <td align="right" valign="top">消息内容：</td>
            <td><textarea name="content" id="content" class="form-input w400" style="height:200px;resize: none;"></textarea></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
                <input type="submit" value="发送消息" class="btn">
                <input type="button" value="返回" class="gray" onclick="history.go(-1)">
            </td>
        </tr>
    </table>
</form>
<input type="hidden" name="message" value="<?php echo empty($message)?'':$message ?>">
<script type="text/javascript">
window.onload = function() {
    message=$('input[name=message]').val();
    if(message != ''){
        alert('发送成功！');      
    }
}
</script>
