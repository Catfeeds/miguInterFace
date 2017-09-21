<style>
    .mtable td{font-size: 20px}
    
</style>
<html>
<head></head>
<body>
<table class="mtable mt10" cellpadding="10" cellspacing="0" width="50%">
   <tr id="b-1">
       <td>搜索</td><td><input type="button" class="search btn" value="编辑"></td>
   </tr>
   <tr id="b-2">
       <td>历史</td><td><input type="button" class="search btn" value="编辑"></td>
   </tr> 
</table>
</body>
<script>
    $('.search').click(function(){
        var pos=$(this).parent().parent().attr('id');
        var epg='0';
        var gid='<?php echo $gid?>';
        window.location.href='/move/nation/edit.html?mid=<?php echo $this->mid?>&pos='+pos+'&epg='+epg+'&gid='+gid;
    })
</script>
</html>


