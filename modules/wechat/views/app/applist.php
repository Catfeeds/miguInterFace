<style type="text/css">
    table,tr,td{border:1px solid grey}
    .search{width:120px;border:1px solid #808080;line-height:35px;height: 40px;border-radius: 5px;font-size: 20px;}
    .search_btn{width: 40px;  height: 40px;  cursor: pointer; border-radius: 5px;position: relative;top:-2px}
    .fenlei ul li:nth-child(1){background-color: #0099CC;color:white;font-size: 25px;text-align: center;line-height:45px}
    .fenlei ul li{background-color: #A1A1A1;color:white;font-size: 20px;text-align: center;line-height:40px;border-radius: 5px;cursor: pointer}
    .fenlei ul .active{color:#000000;background-color: #D7D7D7}
    .load{text-align: center;width:900px;float:right;cursor: pointer}
    .btn,.gray{font-size: 20px;width:200px}
    .right{width:800px;float: right}
    table{float:left;margin-left: 10px;margin-top:10px}
    table tr td{text-align: center}
    button{width:160px;height:20px}
</style>
<body>
<div  class="content" style="height:550px;overflow: auto">
    <div style="float:left;width:190px">
        <div>
            <input type="text" class="search" placeholder="输入片名搜索" value="<?php echo !empty($_REQUEST['word'])?$_REQUEST['word']:''?>">
            <input type="submit" class="search_btn" value="搜索">
        </div>
        <button class="btnall">全选</button>
        <button class="btnno">全不选</button>
        <!--
        <div class="fenlei">
            <ul>
                <li>按分类</li>
                <li>全部</li>
                <li>影音</li>
                <li>工具</li>
                <li>游戏</li>
                <li>其他</li>
            </ul>
        </div>-->
    </div>
    <div class="right">
        <?php foreach($app as $k=>$v){?>
            <table style="width:340px;height:350px">
                <tr>
                    <td colspan="4">应用名称</td>
                    <td><?php echo $v['name']?></td>
                </tr>
                <tr>
                    <td colspan="3" rowspan="4"><img src="<?php echo $v['imageUrl']?>" width="100%"></td>
                    <td>大小：</td>
                    <td><?php echo $v['size']?></td>
                </tr>
                <tr>
                    <td>版本号：</td>
                    <td><?php echo $v['version']?></td>
                </tr>
                <tr>
                    <td>开发商：</td>
                    <td><?php echo $v['creatorName']?></td>
                </tr>
                <tr>
                    <td>分类：</td>
                    <td><?php echo $v['type']?></td>
                </tr>
                <tr>
                    <td>应用简介：</td>
                    <td colspan="4"><?php echo $v['description']?></td>
                </tr>
                <tr>
                    <td colspan="4">点击选择</td>
                    <td><input type="checkbox" class="checkbox" name="id" value="<?php echo $v['id']?>"></td>
                </tr>
            </table>
        <?php }?>
    </div>
</div>
<div style="background:#808080;text-align:center;line-height: 70px;width:920px;float:right">
    <input type="submit" value="确定" class="btn">
    <input type="button" value="取消" class="gray" onclick="window.location.href='<?php echo $this->get_url('app','indexlist')?>'">
</div>
</body>
<script>
    $('.btnall').click(function(){
        $(".right :checkbox").prop("checked", true);
    })
    $('.btnno').click(function(){
        $(".right :checkbox").prop("checked", false);
    })

    $('.btn').click(function(){

        var ids="";
        $("input[name='id']:checked").each(function() {

            ids += $(this).val()+' ';

        });
        if(ids==''){
            alert('请选择要添加的应用')
        }else{
            $.post('/wechat/app/appadd?mid=<?php echo $this->mid?>&nid=<?php echo $_REQUEST['nid']?>&classify=<?php echo $_REQUEST['classify']?>',{ids:ids},function(d){
                window.location.href="<?php echo Yii::app()->createUrl('/wechat/app/indexlist',array('mid'=>$this->mid,'nid'=>$_GET['nid'],'classify'=>$_REQUEST['classify']))?>";
            })
        }

    })
    $('.search_btn').click(function(){
        var word = $('.search').val();
        window.location.href="/wechat/app/applist?mid=<?php echo $_GET['mid']?>&nid=<?php echo $_GET['nid']?>&classify=<?php echo $_GET['classify']?>&word="+word
    })

</script>
