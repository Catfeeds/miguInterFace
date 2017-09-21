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
<html>
<head></head>
<body>
<!--<div style="clear: both">
    <div style="width: 175px;height: 325px; border: solid 1px #ff0000; margin-top: 50px;margin-left: 50px;clear: both;overflow: hidden;;float: left">
        <img src="../../file/fdb5d67b3b94918621da02528a3e223f.png" width="175px" height="325px">
    </div>
    <div style="width: 175px;height: 325px; border: solid 1px #ff0000; margin-top: 50px;margin-left: 10px;float: left">
        <div style="width: 175px;height: 100px; border: solid 1px #ff0000;float: left">111</div>
        <div style="width: 175px;height: 100px; border: solid 1px #ff0000; margin-top:10px;float: left">111</div>
        <div style="width: 175px;height: 100px; border: solid 1px #ff0000; margin-top:10px;float: left">111</div>
    </div>

</div>-->

<?php
if(!empty($html)){
    echo $html;
}
?>
</body>
</html>
<script>
    <?php $i=1; ?>
    <?php foreach($mvui as $key=>$val){ ?>


    var timmer<?php echo $i; ?>;             //定时器
    var current<?php echo $i; ?> = 0;        //当前位置


    var count<?php echo $i; ?> = '<?php echo empty($mvui[$key])?1:count($mvui[$key]);?>';
    if(count<?php echo $i; ?> !=1){
        var arr<?php echo $i; ?> = new Array();
        arr<?php echo $i; ?>[0] = "<?php echo empty($mvui[$key][0]['pic'])?'':$mvui[$key][0]['pic'] ?>";
        arr<?php echo $i; ?>[1] = "<?php echo empty($mvui[$key][1]['pic'])?'':$mvui[$key][1]['pic'] ?>";
        arr<?php echo $i; ?>[2] = "<?php echo empty($mvui[$key][2]['pic'])?'':$mvui[$key][2]['pic'] ?>";


        function go(){

            var current<?php echo $i; ?>Image = arr<?php echo $i; ?>[current<?php echo $i; ?>];
            //alert(current4Image);
            $('.modules #<?php echo $key; ?> img').attr("src",current<?php echo $i; ?>Image);
            current<?php echo $i; ?>++;
            //alert
            if(current<?php echo $i; ?> >= count<?php echo $i; ?>) current<?php echo $i; ?>=0;
        }
        function start(){
            timmer<?php echo $i; ?> = setInterval(go,2000);
        }

        function stop(){
            clearInterval(timmer<?php echo $i; ?>);
        }
        start();
    }
    <?php $i++; ?>
    <?php } ?>
</script>

<script type="text/javascript" charset="utf-8">
    //	$('#child').change(function(){
    //		var val = $(this).val();
    //		if(empty(val)) return false;
    //		window.location.href = '/admin/setting/index.html?mid=<?php //echo $this->mid?>//&nid=<?php //echo $_GET['nid']?>//&type='+val;
    //	});
    $('#button').click(function(){
        var val = $("#child").val();
        var sheng = $("#province").val();
        var shengid = sheng.split('_');//分割

        var city = $("#city").val();
        var cityid = city.split('_');//分割
//    alert(sheng);
        if(empty(val)) return false;
        window.location.href = '/move/nation/index.html?mid=<?php echo $this->mid?>&nid=<?php echo $_GET['nid']?>&type='+val+'&provinceCode='+shengid[0]+'&cityCode='+cityid[0];
    });


    $('.modules a').click(function(){
        var img = $(this).parent('li');
        //alert(img.length);
        if(img.length !== 0){
            var k = $(this);
            var v = $(k).attr('pos');
            //alert(v);
           // var type = '<?php echo !empty($ids) ? $ids :''?>';
            var gid = '<?php echo !empty($gid) ? $gid :''?>';
            var epg = '<?php echo !empty($epg) ? $epg :''?>';
            if(empty(v)) return false;
            var my = layer.msg('加载中', {icon: 16,shade:0.3});
            $.getJSON('<?php echo $this->get_url('nation','photo')?>',{val:v,gid:gid,epg:epg},function(d){
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
            fid=0;
            var gid = '<?php echo !empty($gid) ? $gid :''?>';
            var epg = '<?php echo !empty($epg) ? $epg :''?>';
            if(empty(v)) return false;
            var my = layer.msg('加载中', {icon: 16,shade:0.3});
            $.getJSON('<?php echo $this->get_url('nation','upload')?>',{val:v,fid:fid,gid:gid,epg:epg},function(d){
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

        $.getJSON("/move/nation/getcity?mid=<?php echo $_GET['mid']?>",{id:i[0]},function(data){

            $.each(data,function(i){
                $("#city").append('<option value="'+data[i]['cityCode']+'_'+data[i]['cityName']+'">'+data[i]['cityName']+'</option>');
//                +'_'+data[i]['cityName']
            });
        });
    }
</script>

