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

    #down{ height: 120px; float: left;}
    #down img{width:134px; height:100px; margin-top: -8px;}
    #images3,#images5{margin-left: -30px;}
    #images4{margin-left: -29px;}
    #images2,#images6,#images7,#images8{margin-left: -28px;}

</style>
<div class="modules">

</div>
<?php
if(!empty($html)){
    echo $html;
}
?>
<div style="clear: both; margin: 0 auto; width: 908px;">
<div id="down">
    <img src="../../file/images01.png" id="images1">
    <img src="../../file/images02.png" id="images2">
    <img src="../../file/images03.png" id="images3">
    <img src="../../file/images04.png" id="images4">
    <img src="../../file/images05.png" id="images5">
    <img src="../../file/images06.png" id="images6">
    <img src="../../file/images07.png" id="images7">
    <img src="../../file/images08.png" id="images8">
</div>
</div>
<div style="text-align: center;margin-top:130px;font-size:20px;font-family: 'microsoft yahei';">位置已固定，无法修改</div>

<script>
    var timmer3;             
    var current3 = 0;        

    var count3 = '<?php echo empty($nanchuan['h-3'])?1:count($nanchuan['h-3']);?>';
    if(count3 !=1){
        var arr3 = new Array();
        arr3[0] = "<?php echo empty($nanchuan['h-3'][0]['pic'])?'':$nanchuan['h-3'][0]['pic'] ?>";
        arr3[1] = "<?php echo empty($nanchuan['h-3'][1]['pic'])?'':$nanchuan['h-3'][1]['pic'] ?>";
        arr3[2] = "<?php echo empty($nanchuan['h-3'][2]['pic'])?'':$nanchuan['h-3'][2]['pic'] ?>";


        function go(){

            var current3Image = arr3[current3];
            $('.modules #h-3 img').attr("src",current3Image);
            current3++;
            //alert
            if(current3 >= count3) current3=0;
        }
        function start(){
            timmer3 = setInterval(go,2000);
        }

        function stop(){
            clearInterval(timmer3);
        }
        start();
    }

</script>



<script type="text/javascript" charset="utf-8">
    $('.modules a').click(function(){

        var img =$(this).parent('li');
        if(img.length !=0 ){
            var k = $(this);
            var v = $(k).attr('pos');
            //alert(v);
            if(empty(v)) return false;
            var my = layer.msg('加载中', {icon: 16,shade:0.3});
            $.getJSON('<?php echo $this->get_url('nanchuan','photo')?>',{val:v},function(d){
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
            var k = $(this);
            var v = $(k).attr('pos');
            var fid = 0;
            if(empty(v)) return false;
            var my = layer.msg('加载中', {icon: 16,shade:0.3});
            $.getJSON('<?php echo $this->get_url('nanchuan','upload')?>',{val:v,fid:fid},function(d){
                if(d.code == 200){
                    //layer.alert(d.msg);
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
            })
        }

    });
    $('body').on('click','.gray',function(){
        layer.closeAll();
    });
</script>