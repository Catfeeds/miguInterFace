<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl . "/css/wx/index.css"?>"/>
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl . "/css/wx/public.css"?>"/>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/jquery.js"?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/myString.js"?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/function.js"?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/PublicUser.js"?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/WechatWatchGroups_Index.js"?>"></script>

<div class="menus_r">
    <div class="div_height_15"></div>
    <!-- add end -->
    <div class="Member">
        <div class="member_l">
            <a class="selecs" style="width:100px;" href="<?php echo $this->get_url('defaulturl','add',array('nid'=>$_GET['nid']));?>">添加菜单</a>
            <div class="careful"></div>
        </div>

    </div>
    <div class="mid" id="div_wechat_list">
        <table class="mid_con" id="tab" style="border-collapse:collapse;">
            <tr class="mid_01" style="border-left:3px solid #e4e3e3">
                <td class="mid_one">ID</td>
                <td class="mid_th">菜单名称</td>
<!--                <td class="mid_th">牌照方</td>-->
                <td class="mid_th">URL</td>
                <td class="mid_s">操作</td>
            </tr>

            <?php foreach($arr as $key=>$value){ ?>
                <tr class="mid_02" style="border-left:3px solid #f5da8c;">
                    <td><?php echo  $value['id']; ?></td>
                    <td><?php echo  $value['menu']; ?></td>
<!--                    <td>--><?php //echo  $value['cp']; ?><!--</td>-->
                    <td><?php echo  $value['url'];  ?></td>
                    <td>
                        <a href="<?php echo $this->get_url('defaulturl','add',array('nid'=>$_GET['nid'],'id'=>$value['id']));?>">编辑</a>　

                            <a href="javascript:void(0)" bid="<?php echo $value['id']?>" class="del">删除</a>　
                    </td>
                </tr>
            <?php } ?>

            <?php if(!count($arr)){ ?>
                <tr class="mid_02" style="border-left:3px solid #f5da8c;">
                    <td colspan="8">暂无相关数据！</td>
                </tr>
            <?php    } ?>

        </table>

        <div class="interpret"><div class="page"><?php echo $page;?></div> <!--分页--></div>
        <br /><br />
        <div class="Member" style="height:200px;">
            <div style="width:100%;" class="member_l">
                <label>备注：</label>
                            <span>1、每个菜单的URL有且只能有一条。<br />
                            </span>
            </div>
        </div>
        <br /><br />
    </div>
    <!-- mid end -->

</div>
<script type="text/javascript">
    $('.del').click(function(){
        var k = $(this);
        var v = $(k).attr('bid');
        if(empty(v)) return false;
        $.post('/wechat/defaulturl/del?mid=<?php echo $this->mid?>',{id:v},function(d){
            if(d.code == 200){
                $(k).parent().parent().remove();
                layer.alert(d.msg,{icon:1});
            }else{
                layer.alert(d.msg,{icon:0});
            }
        },'json')
    });
</script>