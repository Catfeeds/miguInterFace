<style type="text/css">
    .up-main li{
        float: left;
        margin-right: 10px;
    }
    /*.up-h-1,.up-h-2,.up-h-8,.up-h-9{background-color:#fff;width:75px;height:150px;}
    .up-h-8,.up-h-9{width:150px;}
    .up-h-2{margin-top:10px;}
    .mt5{margin-top:10px;}
    .mr5{margin-right:5px;}
    .up-h-3,.up-h-7{width:150px;height:310px;background-color:#fff;}
    .up-h-4{width:310px;height:150px;background-color:#fff;}
    .up-h-5,.up-h-6{width:150px;background-color:#fff;height:150px;}*/
    #upload_file{background-color:#000;cursor:pointer;position: absolute;top:0;left:0;}
    #upload_file object{left:0;top:0;}
    .myt{text-align:center;position:relative;
        border: 1px solid #787878;}
    .myt1{text-align:center;position:relative;border: 1px solid #787878;}
    .myt1 span{display: inline-block;width:70px;height:25px;position: absolute;top:0;left:0;}
    .myt span{display: inline-block;width:70px;height:25px;position: absolute;top:0;left:0;}



</style>
<table class="mtables" width="100%" cellspacing="0" cellpadding="10">
    <tr width="900px">
        <td>
            <?php echo $html?>
        </td>
    </tr>
    <tr>
        <td align="center" colspan="3">
            <input type="button" value="取消" class="gray" style="margin-top:10px">
        </td>
    </tr>
</table>
<!--<input type="hidden" name="key" value="<?php /*echo !empty($ui[$address]['pic'])?$ui[$address]['pic']:''*/?>">-->
<!--<input type="hidden" name="position" value="<?php /*echo $address;*/?>">-->
<!--<input type="hidden" name="type" value="--><?php //echo $type;?><!--">-->
<input type="hidden" name="cid" value="<?php echo $cid;?>">

<script type="text/javascript">
    $('.mtables a').click(function(){
        //alert($(this).html());
        if($(this).html() != '点击上传'){
            //alert(1);
            var k = $(this);
            var v = $(k).attr('pos');
            //alert(v);
            //  var type = '<?php //echo $type?>';
            //alert(type);
            //var fid = $(k).parent().attr('fid');
            var cid = '<?php echo !empty($cid) ? $cid :''?>'
            var fid;
            if($(this).parent().attr('fid')==1 || $(this).parent().attr('fid')==2){
                //alert(1);
                fid = $(this).parent().attr('fid');
            }else{
                //alert(2);
                fid =0;
            }
            //alert(fid);
            if(empty(v)) return false;
            var my = layer.msg('加载中', {icon: 16,shade:0.3});
            $.getJSON('<?php echo $this->get_url('nation','uploads')?>',{val:v,fid:fid,cid:cid},function(d){
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
        }else{
            //alert(2);
            var k = $(this);
            var v = $(k).attr('pos');
            //alert(v);
            // var type = '<?php //echo $type?>';
            //alert(type);
            var cid = '<?php echo !empty($cid) ? $cid :''?>';
            var fid;
            if($(this).parent().attr('fid')==1 || $(this).parent().attr('fid')==2){
                //alert(1);
                fid = $(this).parent().attr('fid');
            }else{
                //alert(2);
                fid =0;
            }

            if(empty(v)) return false;
            var my = layer.msg('加载中', {icon: 16,shade:0.3});
            $.getJSON('<?php echo $this->get_url('nation','uploads')?>',{val:v,fid:fid,cid:cid},function(d){
                if(d.code == 200){
                    layer.closeAll;
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
    $('body').on('click','.gray',function(){
        layer.closeAll();
    });
</script>