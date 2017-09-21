<form action="" method="post" enctype="multipart/form-data">
    <table class="mtable" width="50%" cellpadding="10" cellspacing="0">
        <tr>
            <td align="right">导航分级：</td>
            <td>
                <select name="pid" id="pid" class="form-input" onchange="aa()">
                    <option value="0">顶级导航</option>
                    <?php
                    if(!empty($parent)){
                        foreach($parent as $p){?>
                            <option value="<?php echo $p['id'] ?>" <?php echo !empty($guide->pid) && $guide->pid == $p['id']?'selected="selected"':''?>><?php echo $p['name']?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td width="200" align="right">导航名称：</td>
            <td><input type="text" name="name" id="name" class="form-input" value="<?php echo !empty($guide->name)?$guide->name:''?>"></td>
        </tr>
        <tr>
            <td align="right">需要跳转：</td>
            <td>
                <label for="out"><input type="radio" name="uType" id="out" value="1" <?php echo !empty($guide->uType) && $guide->uType == 1?'checked="checked"':''?>> 是</label>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <label for="in"><input type="radio" name="uType" id="in" value="2" <?php echo !empty($guide->uType) && $guide->uType == 2?'checked="checked"':''?>> 否</label>
            </td>
        </tr>
        <tr>
            <td align="right">链接：</td>
            <td><input type="text" name="url" id="url" class="form-input" value="<?php echo !empty($guide->url)?$guide->url:''?>"></td>
        </tr>
        <tr id="vip" style="display: none">
            <td align="right">vip：</td>
            <td>
                <label for="outs"><input type="radio" name="vip" id="outs" value="1" <?php echo !empty($guide->vip) && $guide->vip == 1?'checked="checked"':''?>> 是</label>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <label for="ins"><input type="radio" name="vip" id="ins" value="0" <?php echo !empty($guide->vip) && $guide->vip == 2?'checked="checked"':''?>> 否</label>
            </td>
        </tr>
        <tr id="sf">
            <td align="right">添加省份</td>
            <td>
               <span onclick="tianjia();">添加</span>
            </td>
        </tr>
        <span class="s">
	    <tr id="addr-1" style="display: none"></tr>
            <?php for($i=0;$i<$cou;$i++){  ?>
            <tr id="addr<?php echo $i;?>">
                <td width="100" align="right">地址:</td>
                <td>
                    <select name="province[]" onchange="getregin(this)" id="w<?php echo $i;?>" class="form-input" style="width: 140px">
                        <!--                    <option value="0">请选择省份</option>-->
                        <?php
                        if(!empty($province)){
                            foreach($province as $v){?>
                                <option <?php if($arr[$i]['province']==$v['provinceCode']){echo "selected=selected"; } ?> value ="<?php echo $v['provinceCode']?>_<?php echo $v['provinceName']?>"><?php echo $v['provinceName']?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                    <select name="city[]" id="c<?php echo $i;?>" class="form-input"  style="width: 140px">
                        <?php
                        if(!empty($cityarr)){
                            foreach($cityarr[$i] as $vv){?>
                                <option <?php if($arr[$i]['city']==$vv['cityCode']){echo "selected=selected"; } ?> value ="<?php echo $vv['cityCode']?>_<?php echo $vv['cityName']?>"><?php echo $vv['cityName']?></option>

                                <?php
                            }
                        }
                        ?>
                    </select><span onclick="shanchu(<?php echo $i;?>);">删除</span>
                </td>
            </tr>
            <?php  } ?>
        </span>
	<tr id="pzf">
            <td align="right">添加牌照方：</td>
            <td>
                <span onclick="add();">添加</span>
            </td>
        </tr>
        <tr id="cp-1" style="display: none"></tr>
        <?php for($i=0;$i<$cous;$i++){  ?>
        <tr id="cp<?php echo $i;?>">
            <td align="right">牌照方：</td>
            <td>
                <select name="cp[]" id="p<?php echo $i;?>" class="form-input" style="width: 140px">
                    <option value="0">--请选择牌照方--</option>
                    <option value="1" <?php if($ars[$i]['cp']==1){echo "selected=selected"; } ?>>华数</option>
                    <option value="2" <?php if($ars[$i]['cp']==2){echo "selected=selected"; } ?>>百视通</option>
                    <option value="3" <?php if($ars[$i]['cp']==3){echo "selected=selected"; } ?>>未来电视</option>
                    <option value="4" <?php if($ars[$i]['cp']==4){echo "selected=selected"; } ?>>南传</option>
                    <option value="5" <?php if($ars[$i]['cp']==5){echo "selected=selected"; } ?>>芒果</option>
                    <option value="6" <?php if($ars[$i]['cp']==6){echo "selected=selected"; } ?>>国广</option>
                    <option value="7" <?php if($ars[$i]['cp']==7){echo "selected=selected"; } ?>>银河</option>
                </select><span onclick="dell(<?php echo $i;?>);">删除</span>
            </td>
        </tr>
        <?php  } ?>
        <tr>
            <td width="200" align="right">usergroup：</td>
            <td><input type="text" name="usergroup" id="usergroup" class="form-input" value="<?php echo !empty($arrs[0]['usergroup'])?$arrs[0]['usergroup']:''?>"></td>
        </tr>
        <tr>
            <td width="200" align="right">epgcode：</td>
            <td><input type="text" name="epgcode" id="epgcode" class="form-input" value="<?php echo !empty($arres[0]['epgcode'])?$arres[0]['epgcode']:''?>"></td>
        </tr>
        <tr id="true" style="display: none">
            <td width="100" align="right">选中的图片：</td>
            <td>
                <input name="ico_true" type="file" class="form-input">
                <input name="ico_trues" type="text" class="form-input" value="<?php echo !empty($guide->ico_true)?$guide->ico_true:''?>">
            </td>
        </tr>
        <tr id="false" style="display: none">
            <td width="100" align="right">未选中的图片：</td>
            <td>
                <input id="ico_false" name="ico_false" type="file" value="">
                <input name="ico_falses" type="text" class="form-input" value="<?php echo !empty($guide->ico_false)?$guide->ico_false:''?>">
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
                <input type="submit" value="保存信息" class="btn">
                <input type="button" value="返回列表" class="gray" onclick="window.location.href='<?php echo $this->get_url('guide','index')?>'">
            </td>
        </tr>
    </table>
</form>
<script>
    function checks(obj){
        var num=$("#xuanze").val();
        $('.addr').remove();
        for (var i=1;i<num;i++){
            //这里可以用ajax获取省的数据 然后组装成 append里面的数据
            // $(".s").append("<select class='aa' name='province[]' style='width: 200px;height: 33px;'><option>省</option> </select>");
            //alert(i);
            $("#addr").after("<tr class='addr'><td width='100' align='right'>地址:</td><td><select onchange='getregin(this)' id=w"+i+" name='province[]' class='aa' style='width: 150px;height: 33px;'></select><select id=c"+i+" name='city[]' class='cc' style='width: 150px;height: 33px;'></select></td></tr>");
            //console.log("#w"+i);
            $.ajax({
                type: "POST",
                url: '/move/guide/getpro?mid=<?php echo $_GET['mid']?>',
                async : false,//是否为同步
                dataType: "json",
                success: function(data){
                    var weizhi=i;
                    //console.log("#w"+i);
                    $.each(data,function(i){
                        $("#w"+weizhi).append("<option value="+data[i]["provinceCode"]+'_'+data[i]['provinceName']+">"+data[i]["provinceName"]+"</option>");
                    });
                    $("#c"+weizhi).append('<option>请选择市</option>');
                }
            });
        }
    }
</script>
<script>
    //添加
    var shus=<?php echo $cous-1;?>;
    function add(){
        shus++;
        var wzss=shus-1;
        $("#cp"+wzss).after("<tr id='cp"+shus+"' class='cp'><td align='right'>牌照方：</td><td><select name='cp[]' id=p"+shus+" class='form-input' style='width: 140px'><option value='0'>--请选择牌照方--</option><option value='1'>华数</option><option value='2'>百视通</option><option value='3'>未来电视</option><option value='4'>南传</option><option value='5'>芒果</option><option value='6'>国广</option><option value='7'>银河</option></select><span onclick='dell("+shu+")';>删除</span></td></tr>");
        //console.log("#w"+i);
        wzss++;
        if(wzss>=7){
            alert("已经七个了");
            $("#cp"+wzss).remove();
            return false;
        }
    }
    //删除
    function dell(zz){
        $("#cp"+zz).remove();
    }
</script>

<script>
    //添加
    var shu=<?php echo $cou-1;?>;
    function tianjia(){
        shu++;
        var wzs=shu-1;
        $("#addr"+wzs).after("<tr id='addr"+shu+"' class='addr'><td width='100' align='right'>地址:</td><td><select onchange='getregin(this)' id=w"+shu+" name='province[]' class='aa' style='width: 140px;height: 33px;'></select><select id=c"+shu+" name='city[]' class='cc' style='width: 140px;height: 33px;'></select><span onclick='shanchu("+shu+")';>删除</span></td></tr>");
        //console.log("#w"+i);
        wzs++;
        if(wzs>=9){
            alert("已经九个了");
            $("#addr"+wzs).remove();
            return false;
        }
        $.ajax({
            type: "POST",
            url: '/move/guide/getpro?mid=<?php echo $_GET['mid']?>',
            async : false,//是否为同步
            dataType: "json",
            success: function(data){
                var weizhi=shu;
                //console.log("#w"+i);
                $.each(data,function(i){
                    $("#w"+weizhi).append("<option value="+data[i]["provinceCode"]+'_'+data[i]['provinceName']+">"+data[i]["provinceName"]+"</option>");
                });
                $("#c"+weizhi).append('<option>请选择市</option>');
            }
        });
    }
</script>
<script>
    //删除
    function shanchu(zz){
       $("#addr"+zz).remove();
    }
</script>


<script type="text/javascript">
    var dh = $("#pid").val();
    if(dh != 0 ){
        $("#vip").show();
        $("#false").show();
        $("#true").show();
    }else{
        $("#vip").hide();
        $("#false").hide();
        $("#true").hide();
    }

    function aa(){
        var pid =  $("#pid").val();
        if(pid != 0){
            $("#vip").show();
            $("#false").show();
            $("#true").show();
        }else{
            $("#vip").hide();
            $("#false").hide();
            $("#true").hide();
        }
    }
    function getregin(obj){
        var shengid=obj.value;
        var i = shengid.split('_');//分割
        var ns=obj.id;
        var wz=ns.charAt(ns.length - 1);
        var remo="c"+wz+' '+"option";

        $("#"+remo).remove();

        $.getJSON("/move/guide/getcity?mid=<?php echo $_GET['mid']?>",{id:i[0]},function(data){

            $.each(data,function(i){
                $("#c"+wz).append('<option value="'+data[i]['cityCode']+'_'+data[i]['cityName']+'">'+data[i]['cityName']+'</option>');
//                +'_'+data[i]['cityName']
            });
        });
    };



</script>
