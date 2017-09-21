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
        <tr>
            <td width="200" align="right">usergroup：</td>
            <td><input type="text" name="usergroup" id="usergroup" class="form-input" value=""></td>
        </tr>
        <tr>
            <td width="200" align="right">epgcode：</td>
            <td><input type="text" name="epgcode" id="epgcode" class="form-input" value=""></td>
        </tr>
        <tr id="sf">
            <td align="right">省份数</td>
            <td>
                <select name="xuanze" id="xuanze" onchange="checks()">
                    <option value="0">--请选择--</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                </select>
            </td>
        </tr>
        <span class="s">
            <tr id="addr">
                <td width="100" align="right">地址:</td>
                <td>
                    <select name="province[]" onchange="getregin(this)" id="w0" class="form-input" style="width: 140px">
                        <option value="28" selected>甘肃</option>
                        <option value="44" >group</option>
                    </select>
                    <select name="city[]" id="c0" class="form-input"  style="width: 140px">
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
                </td>
            </tr>
        </span>
	<tr>
            <td align="right">牌照方数：</td>
            <td>
                <select name="licences" id="licences" onchange="pai()">
                    <option value="0">--请选择--</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                </select>
            </td>
        </tr>
        <tr id="cp">
            <td align="right">牌照方：</td>
            <td>
                <select name="cp[]" id="p0" class="form-input" style="width: 140px">
                    <option value="0">--请选择牌照方--</option>
                    <option value="1">华数</option>
                    <option value="2">百视通</option>
                    <option value="3">未来电视</option>
                    <option value="4">南传</option>
                    <option value="5">芒果</option>
                    <option value="6">国广</option>
                    <option value="7">银河</option>
                </select>
            </td>
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
    function pai(){
        var nums = $("#licences").val();
        $('.cp').remove();
        for(var x=1;x<nums;x++){
            $("#cp").after("<tr class='cp'><td align='right'>牌照方：</td><td><select name='cp[]' id=p"+x+" class='form-input' style='width: 140px'><option value='0'>--请选择牌照方--</option><option value='1'>华数</option><option value='2'>百视通</option><option value='3'>未来电视</option><option value='4'>南传</option><option value='5'>芒果</option><option value='6'>国广</option><option value='7'>银河</option></select></td></tr>");
        }
    }
</script>
<script>
    function checks(obj){
        var num=$("#xuanze").val();
        $('.addr').remove();
        for (var i=1;i<num;i++){
            //这里可以用ajax获取省的数据 然后组装成 append里面的数据
            // $(".s").append("<select class='aa' name='province[]' style='width: 200px;height: 33px;'><option>省</option> </select>");
            //alert(i);
            $("#addr").after("<tr class='addr'><td width='100' align='right'>地址:</td><td><select onchange='getregin(this)' id=w"+i+" name='province[]' class='aa' style='width: 140px;height: 33px;'></select><select id=c"+i+" name='city[]' class='cc' style='width: 140px;height: 33px;'></select></td></tr>");
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
<script type="text/javascript">
    var dh = $("#pid").val();
    if(dh != 0 ){
        $("#addr").show();
        $("#vip").show();
        $("#false").show();
        $("#true").show();
        $('#sf').show();
        $('.addr').show();
    }else{
        $("#vip").hide();
        $("#false").hide();
        $("#true").hide();
        $("#addr").show();
        $('#sf').show();
        $('.addr').show();
    }

    function aa(){
        var pid =  $("#pid").val();
        if(pid != 0){
            $("#addr").show();
            $("#vip").show();
            $("#false").show();
            $("#true").show();
            $('#sf').show();
            $('.addr').show();
        }else{
            $("#vip").hide();
            $("#false").hide();
            $("#true").hide();
            $("#addr").show();
            $('#sf').show();
            $('.addr').show();
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
