<html>
<title>内容录入</title>
<style>
    *{margin: 0;padding: 0;}
    table{border-collapse:collapse; font-size: 14px; margin-top: 0.5rem;}
    table img{ height: 100%;width: 100%}
    tr{border:#CCCCCC 1px solid}
    td{border:#CCCCCC 1px solid}
    .center{width: 70px;text-align: right; height: 50px}
    .edit{background-color: #868686;text-align: center;color: #FFFFFF}
    .edit a{background-color: #868686;text-align: center;color: #FFFFFF;border:#868686 1px solid;text-decoration:none;}
    .bttn button{
        background-color: #A1A1A1;
        padding: 8px 20px;
        display: inline-block;
        border-radius: 4px;
        border: 1px solid #A1A1A1;
        color: #fff;
        font-family: "宋体";
        font-size: 18px;
        /*background-image: -moz-linear-gradient(top, #A1A1A1,#A1A1A1);*/
        /*background-image: -webkit-gradient(linear,left top,left bottom, color-stop(0, #A1A1A1), color-stop(1, #A1A1A1));*/
        cursor: pointer;/*设定鼠标的形状为一只伸出食指的手*/
        width: 11rem;
    }
</style>
<script>
    function ch(i){
        $(".bty").css({'background-color':'','color':'','font-weight':''});
        $(".bttn"+i).css({'background-color':'#D7D7D7','color':'#000000','font-weight':'900'});
//        $.post('/wechat/movie/indexs?mid=<?php //echo $_GET['mid']?>//&nid=<?php //echo $_GET['nid']?>//',{cp:i},function(d){
//        },'json');
        window.location.href = "/wechat/movie/index.html?mid=<?php echo $this->mid?>&nid=<?php echo $_GET['nid']?>&cp="+i;
    }
    function search(){
        var title = $("#search").val();
        window.location.href = "/wechat/movie/index.html?mid=<?php echo $this->mid?>&nid=<?php echo $_GET['nid']?>&title="+title;
    }
</script>
<body>
<div style="width: 200px;overflow: hidden;float: left;clear: both">
    <div>
        <input type="text" name="select" id="search" class="form-input w100" value="输入片名搜索" onFocus="if(value==defaultValue){value='';this.style.color='#000'}" onBlur="if(!value){value=defaultValue;this.style.color='#999'}" style="color:#999999">
        <button class="btn" onclick="search()">搜索</button>
    </div>
    <div class="bttn" style="margin-top: 10px">
        <button class="bttn1 bty" onclick="ch(1)">华数</button><br />
        <button class="bttn2 bty" onclick="ch(2)">百视通</button><br />
        <button class="bttn3 bty" onclick="ch(3)">未来电视</button><br />
        <button class="bttn4 bty" onclick="ch(4)">南传</button><br />
        <button class="bttn5 bty" onclick="ch(5)">国广</button><br />
        <button class="bttn6 bty" onclick="ch(6)">芒果</button><br />
        <button class="bttn7 bty" onclick="ch(7)">银河</button><br />
        <button class="bttn8 bty" onclick="ch(8)">其他</button><br />
    </div>
</div>
<div style="margin-left: 200px;">
    <div style="text-align: right;margin-bottom: 1rem;">
        <a href="<?php echo $this->get_url('movie','add')?>" class="btn">添加内容</a>
    </div>
    <div>
        <?php
        if(!empty($list)){
        foreach($list as $l){?>
        <table id="<?php echo $l->id;?>">
            <tr>
                <td rowspan="6" width="200px" height="300px"><img src="<?php echo $l->img;?>"></td>
            </tr>
            <tr style="background-color: #AEAEAE; color: #FFFFFF">
                <td class="center">片名：</td>
                <td colspan="5" width="1000px"><?php echo $l->title;?></td>
            </tr>
            <tr>
                <td class="center">导演：</td>
                <td colspan="5"><?php echo $l->director;?></td>
            </tr>
            <tr>
                <td class="center">演员：</td>
                <td colspan="5"><?php echo $l->actor;?></td>
            </tr>
            <tr>
                <td style="height: 120px;text-align: right;">简介：</td>
                <td colspan="5"><?php echo $l->info;?></td>
            </tr>
            <tr>
                <td class="center">牌照方：</td>
                <td>
                    <?php if($l->cp==1){echo "华数";}elseif($l->cp==2){echo "百视通";}elseif($l->cp==3){echo "未来电视";}elseif($l->cp==4){echo "南传";}elseif($l->cp==5){echo "芒果";}elseif($l->cp==6){echo "国广";}elseif($l->cp==7){echo "银河";}
                    ?>
                </td>
                <td class="center">分类：</td>
                <td>
                    <?php
                       echo $l->classify;
                    ?>
                </td>
                <td class="edit"><a href="<?php echo $this->get_url('movie','add',array('id'=>$l->id,'nid'=>$_GET['nid']))?>">点击修改</a></td>
                <td class="edit"><a href="javascript:void(0)" gid="<?php echo $l->id?>" class="del">删除</a></td>
            </tr>
        </table>
        <?php
        }
        }
        ?>
        <div><?php echo $page;?></div>
    </div>
</div>
</body>

<script type="text/javascript" charset="utf-8">
    $('.del').click(function(){
        var k = $(this);
        var v = $(k).attr('gid');
        if(empty(v)) return false;
        $.post('/wechat/movie/del?mid=<?php echo $_GET['mid']?>',{id:v},function(d){
            if(d.code == 200){
                $(k).parent().parent().remove();

                layer.alert(d.msg,{icon:1});

            }else{
                layer.alert(d.msg,{icon:0});
            }
        },'json');
        $("#"+v).remove();
    })
</script>
</html>


