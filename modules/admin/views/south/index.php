<style>

    a{font-size: 12px;font-family: "microsoft yahei";font-weight: bold;color:#fff;}
    .ui-a{position: relative;}
    .ui-b{position: relative;}
    .ui-a a{position: absolute;top:0;left:0;background-color:#898989;padding:5px 10px;}
    .mt6{margin-top:10px;}
    .ui-b a{position: absolute;top:0;left:0;background-color:#898989;padding:5px 10px;}
    .mt6{margin-top:10px; float:left;}
    .mt7{margin-top:10px; float:left;}
    .cc{margin-left: 10px;}

</style>
<!--<form action="" method="post">-->
<div class="modules">
    <span style="width:100px;display: inline-block;">省市选择：</span>
	<span style="display:inline-block; width:675px;">
		<input type="hidden" name="" id="child" value="<?php echo $ids; ?>" />
        <select name="province" id="province" onchange="getregin()" class="form-input w300">
            <option value="0">请选择省份</option>
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
            <!--显示所有的市-->
        </select>
	</span>
    <span><input type="submit" name="button" id="button" class="seo-gray" value="搜索"></span>


</div>
<!--</form>-->
<?php
if(!empty($html)){
    echo $html;
}
?>
<div style="text-align: center;margin-top:40px;font-size:20px;font-family: 'microsoft yahei';">位置已固定，无法修改</div>
<script>
    var timmer4;             //定时器
    var current4 = 0;        //当前位置


    var count4 = '<?php echo empty($ui['h-4'])?1:count($ui['h-4']);?>';
    if(count4 !=1){
        var arr4 = new Array();
        arr4[0] = "<?php echo empty($ui['h-4'][0]['bigImg'])?'':$ui['h-4'][0]['bigImg'] ?>";
        arr4[1] = "<?php echo empty($ui['h-4'][1]['bigImg'])?'':$ui['h-4'][1]['bigImg'] ?>";
        arr4[2] = "<?php echo empty($ui['h-4'][2]['bigImg'])?'':$ui['h-4'][2]['bigImg'] ?>";



        function go(){

            var current4Image = arr4[current4];
            //alert(current4Image);
            $('.modules #h-4 img').attr("src",current4Image);
            current4++;
            //alert
            if(current4 >= count4) current4=0;
        }
        function start(){
            timmer4 = setInterval(go,2000);
        }

        function stop(){
            clearInterval(timmer4);
        }
        start();
    }

</script>
<script>
    var timmer8;             //定时器
    var current8 = 0;        //当前位置


    var count8 = '<?php echo empty($ui['h-8'])?1:count($ui['h-8']);?>';
    if(count8 !=1){
        var arr8 = new Array();
        arr8[0] = "<?php echo empty($ui['h-8'][0]['bigImg'])?'':$ui['h-8'][0]['bigImg'] ?>";
        arr8[1] = "<?php echo empty($ui['h-8'][1]['bigImg'])?'':$ui['h-8'][1]['bigImg'] ?>";
        arr8[2] = "<?php echo empty($ui['h-8'][2]['bigImg'])?'':$ui['h-8'][2]['bigImg'] ?>";



        function go(){

            var current8Image = arr8[current8];
            //alert(current4Image);
            $('.modules #h-8 img').attr("src",current8Image);
            current8++;
            //alert
            if(current8 >= count8) current8=0;
        }
        function start(){
            timmer8 = setInterval(go,2000);
        }

        function stop(){
            clearInterval(timmer8);
        }
        start();
    }

</script>
<script>
    var timmer5;             //定时器
    var current5 = 0;        //当前位置

    var count5 = '<?php echo empty($ui['h-5'])?1:count($ui['h-5']);?>';
    if(count5 !=1){
        var arr5 = new Array();
        arr5[0] = "<?php echo empty($ui['h-5'][0]['bigImg'])?'':$ui['h-5'][0]['bigImg'] ?>";
        arr5[1] = "<?php echo empty($ui['h-5'][1]['bigImg'])?'':$ui['h-5'][1]['bigImg'] ?>";
        arr5[2] = "<?php echo empty($ui['h-5'][2]['bigImg'])?'':$ui['h-5'][2]['bigImg'] ?>";


        function go(){

            var current5Image = arr5[current5];
            $('.modules #h-5 img').attr("src",current5Image);
            current5++;
            //alert
            if(current5 >= count5) current5=0;
        }
        function start(){
            timmer5 = setInterval(go,2000);
        }

        function stop(){
            clearInterval(timmer5);
        }
        start();
    }

</script>
<script>
    var timmer7;             //定时器
    var current7 = 0;        //当前位置

    var count7 = '<?php echo empty($ui['h-7'])?1:count($ui['h-7']);?>';
    if(count7 !=1){
        var arr7 = new Array();
        arr7[0] = "<?php echo empty($ui['h-7'][0]['bigImg'])?'':$ui['h-7'][0]['bigImg'] ?>";
        arr7[1] = "<?php echo empty($ui['h-7'][1]['bigImg'])?'':$ui['h-7'][1]['bigImg'] ?>";
        arr7[2] = "<?php echo empty($ui['h-7'][2]['bigImg'])?'':$ui['h-7'][2]['bigImg'] ?>";


        function go(){

            var current7Image = arr7[current7];
            $('.modules #h-7 img').attr("src",current7Image);
            current7++;
            //alert
            if(current7 >= count7) current7=0;
        }
        function start(){
            timmer7 = setInterval(go,2000);
        }

        function stop(){
            clearInterval(timmer7);
        }
        start();
    }

</script>
<script type="text/javascript" charset="utf-8">
    $('#button').click(function(){
        var val = $("#child").val();
        var sheng = $("#province").val();
        var shengid = sheng.split('_');//分割

        var city = $("#city").val();
        var cityid = city.split('_');//分割
//    alert(sheng);
        if(empty(val)) return false;
        window.location.href = '/admin/south/index.html?mid=<?php echo $this->mid?>&nid=<?php echo $_GET['nid']?>&type='+val+'&provinceCode='+shengid[0]+'&cityCode='+cityid[0];
    });


    $('.modules a').click(function(){
        var img = $(this).parent('li');
        //alert(img.length);
        if(img.length !== 0){

            var pcode = '<?php echo !empty($provinceCode) ? $provinceCode :'0'?>';
            //alert(pcode);
            var ccode = '<?php echo !empty($cityCode) ? $cityCode :'0'?>';
            //alert(ccode);
            var k = $(this);
            var v = $(k).attr('pos');
            //alert(v);
            var type = '<?php echo !empty($ids) ? $ids :''?>';
            if(empty(v)) return false;
            var my = layer.msg('加载中', {icon: 16,shade:0.3});
            $.getJSON('<?php echo $this->get_url('south','photo')?>',{val:v,type:type,provinceCode:pcode,cityCode:ccode},function(d){
                if(d.code == 200){
                    layer.close(my);
                    layer.open({
                        type: 1,
                        skin: 'layui-layer-rim', //加上边框
                        area: ['1030px', '506'], //宽高
                        content: d.msg
                    })
                }else{
                    layer.alert(d.msg,{icon:0});
                }
            });
            $('body').on('click','.gray',function(){
                layer.closeAll();
            })
        }else{
            //alert(2);
            var pcode = '<?php echo !empty($provinceCode) ? $provinceCode :'0'?>';
            //alert(pcode);
            var ccode = '<?php echo !empty($cityCode) ? $cityCode :'0'?>';

            var k = $(this);
            var v = $(k).attr('pos');
            var type = '<?php echo !empty($ids) ? $ids :''?>';
            fid=0;
            if(empty(v)) return false;
            var my = layer.msg('加载中', {icon: 16,shade:0.3});
            $.getJSON('<?php echo $this->get_url('south','upload')?>',{val:v,type:type,fid:fid,provinceCode:pcode,cityCode:ccode},function(d){
                if(d.code == 200){
                    layer.close(my);
                    layer.open({
                        type: 1,
                        skin: 'layui-layer-rim', //加上边框
                        area: ['1030px', '650px'], //宽高
                        content: d.msg
                    })
                }else{
                    layer.alert(d.msg,{icon:0});
                }
            })
        }
    });
    function getregin(){
        var shengid=$("#province").val();

        var i = shengid.split('_');//分割
        $("#city option").remove();

        $.getJSON("/admin/south/getcity?mid=<?php echo $_GET['mid']?>",{id:i[0]},function(data){

            $.each(data,function(i){
                $("#city").append('<option value="'+data[i]['cityCode']+'_'+data[i]['cityName']+'">'+data[i]['cityName']+'</option>');
            });
        });
    }
</script>