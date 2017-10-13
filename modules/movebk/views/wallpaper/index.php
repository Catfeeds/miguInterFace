<div class="" style="margin-left: 20px">

    <span style="width:100px;display: inline-block;">省市选择：</span>
	<span style="display:inline-block; width:475px;">
		<input type="hidden" name="" id="child" value="<?php //echo $ids; ?>" />
        <select name="province" id="province" onchange="getregin()" class="form-input w300">
            <?php
            if(!empty($province)){
                foreach($province as $v){?>
                    <option <?php if($provinceCode==$v['provinceCode']){echo "selected=selected"; } ?> value ="<?php echo $v['provinceCode']?>_<?php echo $v['provinceName']?>"><?php echo $v['provinceName']?></option>
                <?php
                }
            }
            ?>
        </select>
        <select name="city" id="city" class="form-input w300">
            <option value="0">请选择市</option>
            <?php
            if(!empty($city)){
                foreach($city as $vv){?>
                    <option <?php if($cityCode==$vv['cityCode']){echo "selected=selected"; } ?> value ="<?php echo $vv['cityCode']?>_<?php echo $vv['cityName']?>"><?php echo $vv['cityName']?></option>
                <?php
                }
            }
            ?>
        </select>
	</span>
    <span><input type="submit" name="button" id="button" class="seo-gray" value="搜索"></span>

    <a href="<?php echo $this->get_url('wallpaper', 'add',array('nid'=>$_GET['nid'])) ?>" class="btn" style="margin-left: 200px;">添加壁纸</a>
</div>
<div class="mt10">
    <table width="100%" cellspacing="0" cellpadding="10" class="mtable center">
        <tr>
            <th>编号</th>
            <th>标题</th>
            <th>壁纸</th>
            <th>操作</th>
        </tr>
        <?php
        if(!empty($list)){
            foreach($list as $l){?>
                <tr id="<?php echo $l->id;?>">
                    <td><?php echo $l->id?></td>
                    <td><?php echo $l->title?></td>
                    <td><img src="<?php echo $l->pic?>" width="300px" height="200px"></td>
                    <td>
                        <a href="<?php echo $this->get_url('wallpaper','add',array('id'=>$l->id,'nid'=>$_GET['nid']))?>">编辑</a>
                        <a href="javascript:void(0)" gid="<?php echo $l->id?>" class="del">删除</a>
                    </td>
                </tr>
            <?php
            }
        }else{?>
            <tr>
                <td colspan="4" align="center">暂无数据</td>
            </tr>
        <?php
        }
        ?>
    </table>
</div>
<div><?php echo $page;?></div>
<script type="text/javascript" charset="utf-8">
    $('.del').click(function(){
        var k = $(this);
        var v = $(k).attr('gid');
        if(empty(v)) return false;
        $.post('/move/wallpaper/del?mid=<?php echo $_GET['mid']?>',{id:v},function(d){
            if(d.code == 200){
                $(k).parent().parent().remove();

                layer.alert(d.msg,{icon:1});

            }else{
                layer.alert(d.msg,{icon:0});
            }
        },'json');
        $("#"+v).remove();

    });

    function getregin(){
        var shengid=$("#province").val();

        var i = shengid.split('_');//分割
        $("#city option").remove();

        $.getJSON("/move/wallpaper/getcity?mid=<?php echo $_GET['mid']?>",{id:i[0]},function(data){

            $.each(data,function(i){
                $("#city").append('<option value="'+data[i]['cityCode']+'_'+data[i]['cityName']+'">'+data[i]['cityName']+'</option>');
//                +'_'+data[i]['cityName']
            });
        });
    };

    $('#button').click(function(){
        var val = 'aa';
        var sheng = $("#province").val();
        var shengid = sheng.split('_');//分割

        var city = $("#city").val();
        var cityid = city.split('_');//分割
//    alert(sheng);
        if(empty(val)) return false;
        window.location.href = '/move/wallpaper/index.html?mid=<?php echo $this->mid?>&nid=<?php echo $_GET['nid']?>&type='+val+'&provinceCode='+shengid[0]+'&cityCode='+cityid[0];
    });
</script>
