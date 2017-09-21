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
                <a class="selecs" style="width:100px;" href="<?php echo $this->get_url('menus','add',array('nid'=>$_GET['nid']));?>">添加菜单</a>
                <a class="selecs" style="width:100px;" href="<?php echo $this->get_url('Common','CreateWechatMenu',array('nid'=>$_GET['nid']));?>">生成微信菜单</a>
                <div class="careful"></div>
            </div>

        </div>
        <div class="mid" id="div_wechat_list">
            <table class="mid_con" id="tab" style="border-collapse:collapse;">
                <tr class="mid_01" style="border-left:3px solid #e4e3e3">
                    <td class="mid_one">ID</td>
                    <td class="mid_th">一级菜单</td>
                    <td class="mid_th">二级菜单</td>
                    <td class="mid_th">描述</td>
                    <td class="mid_th">类型</td>
                    <td class="mid_th">跳转的url</td>
                    <!--<td class="mid_th">按钮的key</td>-->
                    <td class="mid_th">素材</td>
                    <td class="mid_s">操作</td>
                </tr>

                    <?php foreach($arr as $key=>$value){ ?>
                    <tr class="mid_02" style="border-left:3px solid #f5da8c;">
<!--                        <td>--><?php //echo $value['id']; ?><!--</td>-->
                        <td></td>
                        <td><?php echo  $value['title']; ?></td>
                        <td>&nbsp;</td>
                        <td><?php echo $value['description']; ?></td>
                        <td>
                            <?php if($value['data_type']=='click'){ echo "文本消息";} ?>
                            <?php if($value['data_type']=='view'){ echo "跳转URL";} ?>
                            <?php if($value['data_type']=='scancode_push'){ echo "扫码推事件";} ?>
                            <?php if($value['data_type']=='scancode_waitmsg'){ echo "扫码推事件且弹出“消息接收中”提示框";} ?>
                            <?php if($value['data_type']=='pic_sysphoto'){ echo "弹出系统拍照发图";} ?>
                            <?php if($value['data_type']=='pic_photo_or_album'){ echo "弹出拍照或者相册发图";} ?>
                            <?php if($value['data_type']=='pic_weixin'){ echo "弹出微信相册发图器";} ?>
                            <?php if($value['data_type']=='location_select'){ echo "弹出地理位置选择器";} ?>
                            <?php if($value['data_type']=='media_id'){ echo "下发消息（除文本消息）";} ?>
                            <?php if($value['data_type']=='view_limited'){ echo "跳转图文消息URL";} ?>
                        </td>
                        <td><?php $lenth = strlen($value['url']);if($lenth>=20) echo substr($value['url'],0,20).'...';?></td>
                        <!--<td>{$value['btn_key']}</td>-->
                        <td><?php echo $value['MaterialTitle']; ?></td>
                        <td>
                            <a href="<?php echo $this->get_url('menus','add',array('nid'=>$_GET['nid'],'id'=>$value['id']));?>">编辑</a>　
                                <?php  if(count($value['ChildrenList'])==0){ ?>
                                <a href="javascript:void(0)" bid="<?php echo $value['id']?>" class="del">删除</a>　
                               <?php }else{ ?>
                                <font color="#bbbbbb">删除</font>　
                           <?php }?>
                        </td>
                    </tr>
                        <?php foreach($value['ChildrenList'] as $k=>$val){ ?>
                        <tr class="mid_02" style="border-left:3px solid #f5da8c;">
<!--                            <td>--><?php //echo $val['id'];  ?><!--</td>-->
                            <td></td>
                            <td>|--</td>
                            <td><?php echo $val['title'];  ?>&nbsp;</td>
                            <td><?php echo $val['description'];  ?></td>
                            <td>
                                <?php if($val['data_type']=='click'){ echo "文本消息";} ?>
                                <?php if($val['data_type']=='view'){ echo "跳转URL";} ?>
                                <?php if($val['data_type']=='scancode_push'){ echo "扫码推事件";} ?>
                                <?php if($val['data_type']=='scancode_waitmsg'){ echo "扫码推事件且弹出“消息接收中”提示框";} ?>
                                <?php if($val['data_type']=='pic_sysphoto'){ echo "弹出系统拍照发图";} ?>
                                <?php if($val['data_type']=='pic_photo_or_album'){ echo "弹出拍照或者相册发图";} ?>
                                <?php if($val['data_type']=='pic_weixin'){ echo "弹出微信相册发图器";} ?>
                                <?php if($val['data_type']=='location_select'){ echo "弹出地理位置选择器";} ?>
                                <?php if($val['data_type']=='media_id'){ echo "下发消息（除文本消息）";} ?>
                                <?php if($val['data_type']=='view_limited'){ echo "跳转图文消息URL";} ?>
                            </td>
                            <td><?php $lenth = strlen($val['url']);if($lenth>=20) echo substr($val['url'],0,20).'...'; ?></td>
                            <!--<td>{$val['btn_key']}</td>-->
                            <td><?php echo $val['MaterialTitle'];  ?></td>
                            <td>
                                <a href="<?php echo $this->get_url('menus','add',array('nid'=>$_GET['nid'],'id'=>$val['id']));?>">编辑</a>　
                                <a href="javascript:void(0)" bid="<?php echo $val['id']?>" class="del" >删除</a>　
                            </td>
                        </tr>
                    <?php } ?>
                 <?php } ?>

                   <?php if(!count($arr)){ ?>
                            <tr class="mid_02" style="border-left:3px solid #f5da8c;">
                                <td colspan="8">暂无相关数据！</td>
                            </tr>
                    <?php    } ?>

            </table>

            <div class="interpret"> <!--分页--></div>
            <div class="Member" style="height:200px;">
                <div style="width:100%;" class="member_l">
                    <label>备注：</label>
                            <span>1、自定义菜单最多包括3个一级菜单，每个一级菜单最多包含5个二级菜单。<br />
                            2、一级菜单最多4个汉字，二级菜单最多7个汉字，多出来的部分将会以“...”代替。<br />
                            3、创建自定义菜单后，由于微信客户端缓存，需要24小时微信客户端才会展现出来。测试时可以尝试取消关注公众账号后再次关注，则可以看到创建后的效果。<br />
                            4、当按钮的类型为“下发消息（除文本消息）media_id”和“跳转图文消息URL(view_limited)”类型时起作用。<br />
                            5、当按钮的类型为“点击推事件(click)”等点击类型时起作用，菜单KEY值，用于消息接口推送，不超过128字节。<br />
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
            $.post('/wechat/menus/del?mid=<?php echo $this->mid?>',{id:v},function(d){
                if(d.code == 200){
                    $(k).parent().parent().remove();
                    layer.alert(d.msg,{icon:1});
                }else{
                    layer.alert(d.msg,{icon:0});
                }
            },'json')
        });
    </script>
    <script>
        i=0;
        $("#tab tr").each(function(){
            if (i > 0) {
                $(this).find("td:first").html(i);
            }
            i++;
        })
    </script>