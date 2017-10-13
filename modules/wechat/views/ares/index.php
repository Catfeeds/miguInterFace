<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl . "/css/wx/index.css"?>"/>
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl . "/css/wx/public.css"?>"/>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . "/js/wx/jquery.js"?>"></script>
<div class="menus_r">
    <div class="div_height_15"></div>
    <!-- add end -->
    <ul class="tab_menu">
        <li><?php if($SearchMsgType=='video'){echo "<a class='selected'>视频回复</a>";}else{echo "<a href='/wechat/ares/index.html?mid=7&SearchMsgType=video&nid=11'>视频回复</a>";} ?></li>
        <!--        <li>--><?php //if($SearchMsgType=='video'){echo "<a class='selected'>视频回复</a>";}else{echo $this->get_url('response','index',array('msgtype'=>'video','nid'=>$_GET['nid'],'mid'=>$_GET['mid']));} ?><!--</li>-->
        <li><?php if($SearchMsgType=='voice'){echo "<a class='selected'>语音回复</a>";}else{echo "<a href='/wechat/ares/index.html?mid=7&SearchMsgType=voice&nid=11'>语音回复</a>";} ?></li>
        <li><?php if($SearchMsgType=='image'){echo "<a class='selected'>图片回复</a>";}else{echo "<a href='/wechat/ares/index.html?mid=7&SearchMsgType=image&nid=11'>图片回复</a>";} ?></li>
        <li><?php if($SearchMsgType=='text'){echo "<a class='selected'>文本回复</a>";}else{echo "<a href='/wechat/ares/index.html?mid=7&SearchMsgType=text&nid=11'>文本回复</a>";} ?></li>
        <li><?php if($SearchMsgType=='attention'){echo "<a class='selected'>关注回复</a>";}else{echo "<a href='/wechat/ares/index.html?mid=7&SearchMsgType=attention&nid=11'>关注回复</a>";} ?></li>
        <li><?php if($SearchMsgType=='auto'){echo "<a class='selected'>自动回复</a>";}else{echo "<a href='/wechat/ares/index.html?mid=7&SearchMsgType=auto&nid=11'>自动回复</a>";} ?></li>

    </ul>
    <div class="Member">
        <div class="member_l" style="width:700px;">
            <!--            <a class="selecs select_f" style="width:100px;" href="--><?php //echo $this->get_url('response','add',array('msgtype'=>'news','nid'=>$_GET['nid']));?><!--">添加图文回复</a>-->
            <!--            <a class="selecs select_f" style="width:100px;" href="__URL__/add/MsgType/music">添加音乐回复</a>-->
            <a class="selecs select_f" style="width:100px;" href="<?php echo $this->get_url('ares','add',array('msgtype'=>'video','nid'=>$_GET['nid']));?>">添加视频回复</a>
            <a class="selecs select_f" style="width:100px;" href="<?php echo $this->get_url('ares','add',array('msgtype'=>'voice','nid'=>$_GET['nid']));?>">添加语音回复</a>
            <a class="selecs select_f" style="width:100px;" href="<?php echo $this->get_url('ares','add',array('msgtype'=>'image','nid'=>$_GET['nid']));?>">添加图片回复</a>
            <a class="selecs select_f" style="width:100px;" href="<?php echo $this->get_url('ares','add',array('msgtype'=>'text','nid'=>$_GET['nid']));?>">添加文本回复</a>

            <a class="selecs select_f" style="width:100px;" href="<?php echo $this->get_url('ares','add',array('msgtype'=>'attention','nid'=>$_GET['nid']));?>">添加关注回复</a>
            <a class="selecs select_f" style="width:100px;" href="<?php echo $this->get_url('ares','add',array('msgtype'=>'auto','nid'=>$_GET['nid']));?>">添加自动回复</a>
        </div>
    </div>
    <div class="mid">
        <table class="mid_con"  style="border-collapse:collapse;">
            <?php if($SearchMsgType=='video'){   ?><!--视频消息-->
                <tr class="mid_01" style="border-left:3px solid #e4e3e3">
                    <td class="mid_th">关键词</td>
                    <!--<td class="mid_th">media_id</td>-->
                    <td class="mid_th">标题</td>
                    <td class="mid_th">描述</td>
                    <td class="mid_th">消息类型</td>
                    <td class="mid_s">操作</td>
                </tr>
            <?php }elseif($SearchMsgType=='voice'){   ?><!--语音消息-->
                <tr class="mid_01" style="border-left:3px solid #e4e3e3">
                    <td class="mid_th">关键词</td>
                    <!--<td class="mid_th">media_id</td>-->
                    <td class="mid_th">消息类型</td>
                    <td class="mid_s">操作</td>
                </tr>
            <?php }elseif($SearchMsgType=='image'){   ?><!--图片消息-->
                <tr class="mid_01" style="border-left:3px solid #e4e3e3">
                    <td class="mid_th">关键词</td>
                    <!--<td class="mid_th">media_id</td>-->
                    <td class="mid_th">图片</td>
                    <td class="mid_th">消息类型</td>
                    <td class="mid_s">操作</td>
                </tr>
            <?php }elseif($SearchMsgType=='text'){   ?><!--文本消息-->
                <tr class="mid_01" style="border-left:3px solid #e4e3e3">
                    <td class="mid_th">关键词</td>
                    <td class="mid_th">文本</td>
                    <td class="mid_th">消息类型</td>
                    <td class="mid_s">操作</td>
                </tr>
            <?php }elseif($SearchMsgType=='attention'){   ?><!--关注回复-->
                <tr class="mid_01" style="border-left:3px solid #e4e3e3">
                    <td class="mid_th">关键词</td>
                    <!--<td class="mid_th">media_id</td>-->
                    <td class="mid_th">描述</td>
                    <td class="mid_th">消息类型</td>
                    <td class="mid_s">操作</td>
                </tr>
            <?php }elseif($SearchMsgType=='auto'){   ?><!--自动回复-->
                <tr class="mid_01" style="border-left:3px solid #e4e3e3">
                    <td class="mid_th">关键词</td>
                    <!--<td class="mid_th">media_id</td>-->
                    <td class="mid_th">描述</td>
                    <td class="mid_th">消息类型</td>
                    <td class="mid_s">操作</td>
                </tr>
            <?php } ?>
            <?php if($SearchMsgType=='video'){   ?><!--视频消息-->
                <?php foreach($arr as $key=>$value){ ?>
                    <tr class="mid_02" style="border-left:3px solid #f5da8c;">
                        <td><?php echo $value['key_word']; ?></td>

                        <td><?php echo $value['title']; ?></td>
                        <td><?php echo $value['description']; ?></td>
                        <td>视频消息</td>
                        <td>
                            <a href="<?php echo $this->get_url('ares','add',array('msgtype'=>'video','nid'=>$_GET['nid'],'id'=>$value['id']));?>">编辑</a>　
                            <a href="javascript:void(0)" bid="<?php echo $value['id']?>" class="del" onClick="javascript:return confirm('确定要删除吗？');">删除</a>　
                        </td>
                    </tr>
                <?php } ?>
                <?php if(!count($arr)){ ?>
                    <tr class="mid_02" style="border-left:3px solid #f5da8c;">
                        <td colspan="4">暂无相关数据！</td>
                    </tr>
                <?php } ?>
            <?php }elseif($SearchMsgType=='voice'){   ?><!--语音消息-->
                <?php foreach($arr as $key=>$value){ ?>
                    <tr class="mid_02" style="border-left:3px solid #f5da8c;">
                        <td><?php echo $value['key_word']; ?></td>
                        <!--<td>{$value['media_id']}</td>-->
                        <td>语音消息</td>
                        <td>
                            <a href="<?php echo $this->get_url('ares','add',array('msgtype'=>'voice','nid'=>$_GET['nid'],'id'=>$value['id']));?>">编辑</a>　
                            <a href="javascript:void(0)" bid="<?php echo $value['id']?>" class="del" onClick="javascript:return confirm('确定要删除吗？');">删除</a>　
                        </td>
                    </tr>
                <?php } ?>
                <?php if(!count($arr)){ ?>
                    <tr class="mid_02" style="border-left:3px solid #f5da8c;">
                        <td colspan="4">暂无相关数据！</td>
                    </tr>
                <?php } ?>
            <?php }elseif($SearchMsgType=='image'){   ?><!--图片消息-->
                <?php foreach($arr as $key=>$value){ ?>
                    <tr class="mid_02" style="border-left:3px solid #f5da8c;">
                        <td><?php echo $value['key_word']; ?></td>
                        <!--<td>{$value['media_id']}</td>-->
                        <td>
                            <?php if($value['link_url']==''){ echo '暂无图片';}else{
                                echo "<img src=\"{$value['link_url']}\" alt=\"\" width=\"140\" height=\"100\" />";
                            } ?>
                        </td>
                        <td>图片消息</td>
                        <td>
                            <a href="<?php echo $this->get_url('ares','add',array('msgtype'=>'image','nid'=>$_GET['nid'],'id'=>$value['id']));?>">编辑</a>　
                            <a href="javascript:void(0)" bid="<?php echo $value['id']?>" class="del" onClick="javascript:return confirm('确定要删除吗？');">删除</a>　
                        </td>
                    </tr>
                <?php } ?>
                <?php if(!count($arr)){ ?>
                    <tr class="mid_02" style="border-left:3px solid #f5da8c;">
                        <td colspan="4">暂无相关数据！</td>
                    </tr>
                <?php } ?>
                <!--文本消息-->
            <?php }elseif($SearchMsgType=='text'){   ?>
                <?php foreach($arr as $key=>$value){ ?>
                    <tr class="mid_02" style="border-left:3px solid #f5da8c;">
                        <td><?php echo $value['key_word']; ?></td>
                        <td><?php echo $value['description']; ?></td>
                        <td>文本消息</td>
                        <td>
                            <a href="<?php echo $this->get_url('ares','add',array('msgtype'=>'text','nid'=>$_GET['nid'],'id'=>$value['id']));?>">编辑</a>
                            <a href="javascript:void(0)" bid="<?php echo $value['id']?>" class="del" onClick="javascript:return confirm('确定要删除吗？');">删除</a>　
                        </td>
                    </tr>
                <?php } ?>

                <?php if(!count($arr)){ ?>
                    <tr class="mid_02" style="border-left:3px solid #f5da8c;">
                        <td colspan="4">暂无相关数据！</td>
                    </tr>
                <?php } ?>
            <?php }elseif($SearchMsgType=='voice'){   ?>
                <!-- <elseif condition="$SearchMsgType eq 'voice'"/><!--语音消息-->
                <?php foreach($arr as $key=>$value){ ?>
                    <tr class="mid_02" style="border-left:3px solid #f5da8c;">
                        <td><?php echo $value['key_word']; ?></td>
                        <!--<td>{$value['media_id']}</td>-->
                        <td>语音消息</td>
                        <td>
                            <a href="<?php echo $this->get_url('ares','add',array('msgtype'=>'voice','nid'=>$_GET['nid'],'id'=>$value['id']));?>">编辑</a>　
                            <a href="javascript:void(0)" bid="<?php echo $value['id']?>" class="del" onClick="javascript:return confirm('确定要删除吗？');">删除</a>　
                        </td>
                    </tr>
                <?php } ?>
                <?php if(!count($arr)){ ?>
                    <tr class="mid_02" style="border-left:3px solid #f5da8c;">
                        <td colspan="4">暂无相关数据！</td>
                    </tr>
                <?php } ?>
            <?php }elseif($SearchMsgType=='attention'){   ?>
                <!-- <elseif condition="$SearchMsgType eq 'voice'"/><!--语音消息-->
                <?php foreach($arr as $key=>$value){ ?>
                    <tr class="mid_02" style="border-left:3px solid #f5da8c;">
                        <td><?php echo $value['key_word']; ?></td>
                        <!--<td>{$value['media_id']}</td>-->
                        <td><?php echo $value['description']; ?></td>
                        <td>关注回复</td>
                        <td>
                            <a href="<?php echo $this->get_url('ares','add',array('msgtype'=>'attention','nid'=>$_GET['nid'],'id'=>$value['id']));?>">编辑</a>　
                            <!--                            <a href="javascript:void(0)" bid="--><?php //echo $value['id']?><!--" class="del" onClick="javascript:return confirm('确定要删除吗？');">删除</a>　-->
                        </td>
                    </tr>
                <?php } ?>
                <?php if(!count($arr)){ ?>
                    <tr class="mid_02" style="border-left:3px solid #f5da8c;">
                        <td colspan="4">暂无相关数据！</td>
                    </tr>
                <?php } ?>
            <?php }elseif($SearchMsgType=='auto'){   ?>
                <!-- <elseif condition="$SearchMsgType eq 'voice'"/><!--语音消息-->
                <?php foreach($arr as $key=>$value){ ?>
                    <tr class="mid_02" style="border-left:3px solid #f5da8c;">
                        <td><?php echo $value['key_word']; ?></td>
                        <!--<td>{$value['media_id']}</td>-->
                        <td><?php echo $value['description']; ?></td>
                        <td>自动回复</td>
                        <td>
                            <a href="<?php echo $this->get_url('ares','add',array('msgtype'=>'auto','nid'=>$_GET['nid'],'id'=>$value['id']));?>">编辑</a>　
                            <a href="javascript:void(0)" bid="<?php echo $value['id']?>" class="del" onClick="javascript:return confirm('确定要删除吗？');">删除</a>　
                        </td>
                    </tr>
                <?php } ?>
                <?php if(!count($arr)){ ?>
                    <tr class="mid_02" style="border-left:3px solid #f5da8c;">
                        <td colspan="4">暂无相关数据！</td>
                    </tr>
                <?php } ?>
            <?php }  ?>
        </table>
        <div class="interpret">
            <div class="page"><?php echo $page;?></div>
        </div>
        <br /><br />
        <div class="Member" style="height:200px;">
            <div style="width:100%;" class="member_l">
                <label>备注：</label>
                            <span>1、关注回复和自动回复有且只能有一条。<br />
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
        $.post('/wechat/ares/del?mid=<?php echo $this->mid?>',{id:v},function(d){
            if(d.code == 200){
                $(k).parent().parent().remove();
                layer.alert(d.msg,{icon:1});
            }else{
                layer.alert(d.msg,{icon:0});
            }
        },'json')
    });
</script>