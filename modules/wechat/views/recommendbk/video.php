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
    .content ul li{float:left;margin-left:5px;padding-bottom: 20px;height: 300px;}
    .content ul li .del {color: #686868;display: block;font-size: 16px;font-weight: normal;top:22px;left:90px;position: relative;text-overflow: ellipsis;white-space: nowrap; background-color: grey;width:50px;color: #ffffff;text-align: center}
    .content ul li strong {color: #686868;display: block;font-size: 16px;font-weight: normal;line-height: 175%;overflow: hidden;position: relative;text-overflow: ellipsis;white-space: nowrap;  }
    .content ul li strong .order{width:95px;margin-left:5px;font-size: 16px;border:1px solid #808080}
</style>
<body>
<div class="modules" id="dddd" style="margin-top:20px;overflow-x: scroll;width: 100%"><div id="cccc" style="height:500px;">
        <div id="aaaa">
            <div  height="320px" style="float:left;">
                <div   class="ui-s" style="">
                    <img src=""  alt=""  width="175px" height="100px">
                    <?php if(!empty($video)){
                            if(count($video)>5){ ?>
                            <div class="add"><img src="../../file/3.png" ></div>
                        <?php }else{?>
                            <div class="add add1"><a href="<?php echo Yii::app()->createUrl('/wechat/recommend/add',array('mid'=>$this->mid,'nid'=>$_GET['nid'],'classify'=>$_REQUEST['classify']))?>"><img src="../../file/3.png"></a></div>
                        <?php }
                    }else{?>
                        <div class="add add1"><a href="<?php echo Yii::app()->createUrl('/wechat/recommend/add',array('mid'=>$this->mid,'nid'=>$_GET['nid'],'classify'=>$_REQUEST['classify']))?>"><img src="../../file/3.png"></a></div>
                    <?php
                    } ?>
                </div>
            </div>
            <div style="clear:both"></div>
            <div style="width:470px;height:600px;overflow: auto" class="content">
                <ul>
                    <?php if(!empty($video)){
                    foreach($video as $key=>$value){?>
                        <li>
                            <div>
                                <a class="del">删除</a>
                                <input type="hidden" name="id" value="<?php echo $value['id']?>">
                                <img src="<?php echo $value['img']?>" alt="" width="140px"/>
                                <strong>权重:<input name="order" type="text" value="<?php echo $value['orders']?>" class="order"></strong>
                            </div>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <div style="width:470px;text-align: center;line-height: 50px;margin-top: 20px;">
                <input type="submit" value="保存修改" class="btn">
            </div>
            <?php }?>
        </div></div>
</body>
<script>
    $('.del').click(function(){
        var id = $(this).next().val();
        $.post('/wechat/recommend/del?mid=<?php echo $_GET['mid']?>',{id:id},function(d){
            if(d.code == 200){
                layer.alert(d.msg,{icon:1});
                window.location.reload();
            }else{
                layer.alert(d.msg,{icon:0});
            }
        },'json')
    })

    $('.btn').click(function(){
        var ids = {};
        var orders={};
        var els =document.getElementsByName("id");
        for (var i = 0, j = els.length; i < j; i++){
            ids[i]=els[i].value;
        }
        var order =document.getElementsByName("order");
        for (var i = 0, j = order.length; i < j; i++){
            orders[i]=order[i].value;
        }
        $.post('/wechat/recommend/update?mid=<?php echo $this->mid?>',{id:ids,order:orders},function(d){
            if(d.code==200){
                location.reload();
            }
        },'json')

    })
</script>

