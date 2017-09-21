<style type="text/css">
    .up-main li{
        float: left;
        margin-right: 10px;
    }
    .up-h-1,.up-h-2,.up-h-8,.up-h-9{background-color:#fff;width:75px;height:150px;}
    .up-h-8,.up-h-9{width:150px;}
    .up-h-2{margin-top:10px;}
    .mt5{margin-top:10px;}
    .mr5{margin-right:5px;}
    .up-h-3,.up-h-7{width:150px;height:310px;background-color:#fff;}
    .up-h-4{width:310px;height:150px;background-color:#fff;}
    .up-h-5,.up-h-6{width:150px;background-color:#fff;height:150px;}
    <?php echo '#'.$address?>{position: relative;}
    #upload_file{background-color:#000;cursor:pointer;position: absolute;top:0;left:0;}
    #upload_file object{left:0;top:0;}
    .myt{text-align:center;position:relative;
        border: 1px solid #787878;}
    .myt1{text-align:center;position:relative;border: 1px solid #787878;}
    .myt1 span{display: inline-block;width:70px;height:25px;position: absolute;top:0;left:0;}
    .myt span{display: inline-block;width:70px;height:25px;position: absolute;top:0;left:0;}
    <?php echo '#'.$address?> a{
                                  position: absolute;
                                  top: 0;
                                  left: 0;
                                  background-color: #898989;
                                  padding: 5px 10px;
                                  color:white
                              }
    #zuo{
        background-color: #898989;
    }
    #zuo a{
        position: absolute;
        top: 0;
        left: 300;
        background-color: #898989;
        padding: 5px 10px;
        color:white
    }
    #shang{
        background-color: #898989;
    }
    #shang a{
        position: absolute;
        top: 0;
        left: 300;
        background-color: #898989;
        padding: 5px 10px;
        color:white;
    }


</style>
<script type="text/javascript" src="/js/uploadify/jquery.uploadify.min.js"></script>
<table class="mtable" width="100%" cellspacing="0" cellpadding="10">
    <tr width="900px">
        <?php
        if(count($nanchuan) == 1){
            echo "<td fid='0' id=".$nanchuan[0]['pos']." width='250px'><img src=".$nanchuan[0]['pic']." width='80%'><a pos=".$nanchuan[0]['pos']." href=".'javascript:void(0)'.">点击修改</a></td>";
            echo "<td id='zuo' fid='1' width='200px'><a pos=".$nanchuan[0]['pos']." href=".'javascript:void(0)'.">点击上传</a></td>";
            echo "<td id='shang' fid='2' width='200px'><a pos=".$nanchuan[0]['pos']." href=".'javascript:void(0)'.">点击上传</a></td>";
        }elseif(count($nanchuan) == 2){
            foreach ($nanchuan as $key => $val) {
                echo "<td fid='$key' id=".$val['pos']." width='150px'><img src=".$val['pic']." width='80%'><a pos=".$val['pos']." href=".'javascript:void(0)'.">点击修改</a></td>";
            }

            echo "<td id='shang' width='200px' fid='2'><a pos=".$nanchuan[0]['pos']." href=".'javascript:void(0)'.">点击上传</a></td>";
        }elseif(count($nanchuan)==3){
            foreach ($nanchuan as $key => $val) {
                echo "<td fid='$key' id=".$val['pos']." width='150px'><img src=".$val['pic']." width='80%'><a pos=".$val['pos']." href=".'javascript:void(0)'.">点击修改</a></td>";
            }
        }
        ?>

    </tr>
    <tr>
        <td align="center" colspan="3">
            <input type="button" value="取消" class="gray">
        </td>
    </tr>
</table>
<script type="text/javascript">
    $('.mtable a').click(function(){
        if($(this).html() !== '点击上传'){
            var k = $(this);
            var v = $(k).attr('pos');
            var fid;
            if($(this).parent().attr('fid')==1 || $(this).parent().attr('fid')==2){
                fid = $(this).parent().attr('fid');
            }else{
                fid =0;
            }
            if(empty(v)) return false;
            var my = layer.msg('加载中', {icon: 16,shade:0.3});
            $.getJSON('<?php echo $this->get_url('nanchuan','upload')?>',{val:v,fid:fid},function(d){
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
            })
        }else{
            var k = $(this);
            var v = $(k).attr('pos');
            var fid;
            if($(this).parent().attr('fid')==1 || $(this).parent().attr('fid')==2){
                fid = $(this).parent().attr('fid');
            }else{
                fid =0;
            }
            if(empty(v)) return false;
            var my = layer.msg('加载中', {icon: 16,shade:0.3});
            $.getJSON('<?php echo $this->get_url('nanchuan','upload')?>',{val:v,fid:fid},function(d){
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
            })
        }

    });
    $('body').on('click','.gray',function(){
        layer.closeAll();
    });
</script>