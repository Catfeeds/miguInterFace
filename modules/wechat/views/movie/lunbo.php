<style type="text/css">
    .ui-a{background-color:#898989;height:320px;text-align: center;width:175px;}
    #b-2{background-color:#898989;height:320px;text-align: center;width:175px;}
    #h-8,#h-9,#h-10{height:100px;background-color:#898989;text-align: center;width: 175px;}
    #h-9,#h-10{margin-top:10px;}

    .ui-s:nth-child(3n){margin-bottom: 0px;}
    .ui-s{text-align: center; width:175px; background-color: #898989;height:100px; margin-bottom: 10px;}
    .ui-s .add{position: absolute;top:0;left:0;background-color:#898989;padding:5px 10px;}
    .ui-s .add img{position: absolute;top:0;left:0;background-color:#898989;}
    .ui-s{position: relative;}
    .lunbo ul li {width:500px}
    .lunbo ul li img{width:100%}
    .lunbo ul li .turn {color: #686868;display: block;font-size: 16px;font-weight: normal;top:42px;left:0;position: relative;text-overflow: ellipsis;white-space: nowrap; background-color: grey;width:80px;color: #ffffff;text-align: center}
    .lunbo ul li .del {color: #686868;display: block;font-size: 16px;font-weight: normal;top:21px;left:420px;position: relative;text-overflow: ellipsis;white-space: nowrap; background-color: grey;width:80px;color: #ffffff;text-align: center}
</style>
<body>
<div class="modules" id="dddd" style="margin-top:20px;overflow-x: scroll;width: 100%"><div id="cccc" style="height:500px;">
<div id="aaaa">
<div  height="320px" style="float:left;">
<div   class="ui-s" style="">
<img src=""  alt=""  width="175px" height="100px">
<?php if(count($lunbo)>2){ ?>
    <div class="add"><img src="../../file/3.png" ></div>
<?php }else{?>
    <div class="add add1"><a href="<?php echo $this->get_url('movie','lunboadd')?>"><img src="../../file/3.png"></a></div>
<?php }?>
</div>
</div>
<div style="clear:both"></div>
<div class="lunbo">
    <ul>
        <?php if(!empty($lunbo)) {
            foreach ($lunbo as $key => $value) {
                ?>
                <li>
                    <a class="turn" href="<?php echo $this->get_url('movie','lunboadd',array('id'=>$value['id'],'nid'=>$_GET['nid']))?>">点击修改</a>
                    <a class="del">删除</a>
                    <input type="hidden" name="id" value="<?php echo $value['id']?>">
                    <img src="<?php echo $value['img']?>" width="500px">
                </li>
            <?php
            }
        }
        ?>
    </ul>
</div>
</div></div>
</body>
<script>
    $('.del').click(function(){
        var id = $(this).next().val();
        $.post('/wechat/movie/lunbodel?mid=<?php echo $_GET['mid']?>',{id:id},function(d){
            if(d.code == 200){
                layer.alert(d.msg,{icon:1});
                window.location.reload();
            }else{
                layer.alert(d.msg,{icon:0});
            }
        },'json')
    })
</script>

