<div class="searchBar-form" hieght="40px">
    <form action="" method="get">
        <div style="margin-bottom: 10px;float: right">
            <a href="<?php echo Yii::app()->createUrl('/wechat/movie/upload',array('mid'=>$this->mid,'nid'=>$_GET['nid']))?>" class="btn btn-padding30 btn-blue action_box">新增客户端</a>
        </div>
    </form>
</div>
<div style="clear: both"></div>
<div>
    <table cellspacing="0" cellpadding="10" width="100%" class="mtable table-td-center">
        <tr>
            <th>版本</th>
            <th>包名</th>
            <th>平台标识</th>
            <th>客户端大小</th>
            <th>版本代号</th>
            <th>操作</th>
        </tr>
        <?php if(!empty($list)) {
            foreach ($list as $k => $v) {
                ?>
                <tr>
                    <td><?php echo $v->version ?></td>
                    <td><?php echo $v->pname ?></td>
                    <td><?php echo $v->app ?></td>
                    <td><?php echo round(($v->size) / 1024000) ?>M</td>
                    <td><?php echo $v->verStr ?></td>
                    <td><a href="<?php echo Yii::app()->createUrl('/wechat/movie/see',array('mid'=>$this->mid,'nid'=>$_GET['nid'],'id'=>$v->id))?>">查看</a><a class="delApp" appId="<?php echo $v->id?>">删除</a></td>
                </tr>
            <?php }
        }?>

    </table>
</div>
<script type="text/javascript">
    $('.delApp').click(function(){
        var id = $(this).attr('appId');
        var cf = confirm('您确定要删除吗？');
        if(cf){
            $.post('/wechat/movie/delApp?mid=<?php echo $_GET["mid"]?>&nid=<?php echo $_GET["nid"]?>',{id:id}, function (a) {
                if(a.code == 2){
                    alert(a.msg);
                    window.location.reload();
                }else{
                    alert(a.msg);
                }
            },'json');
        }
    })
</script>
