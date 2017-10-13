<?php
$gus = $this->wxgroup;
//var_dump($gus);die;
foreach($gus as $k=>$v){
    $list[$k]=$v['attributes'];
}
function resolve(& $list, $pid = 0) {
    $manages = array();
    foreach ($list as $row) {
        if ($row['pid'] == $pid) {
            $manages[$row['id']] = $row;
            $children = resolve($list, $row['id']);
            $children && $manages[$row['id']]['children'] = $children;
        }
    }
    return $manages;
}
$nav = resolve($list,$pid=0);
$mid = $this->mid;
$nav = $nav[$mid];
/*echo '<pre>';
print_r($nav);
echo '</pre>';die;*/
?>
    <div class="admin_left">
        <div id="menubox">
            <ul id="J_navlist">
<?php
if(!empty($nav['children'])){
    $num1=-1;
    foreach($nav['children'] as $k=>$v){
        $num1++;
        ?>
        <li>
        <span><a class="first <?php echo $_REQUEST['mid'].'-'.$v['id']?>" href="<?php echo $v['url'] == '#'?'#':Yii::app()->createUrl($v['url'],array('mid'=>$_GET['mid'],'nid'=>$v['id'],'heightFlag1'=>$num1))?>" class="<?php echo !empty($_GET['nid']) && $_GET['nid'] == $v['id']?'hovered':''?>"><?php echo $v['name']?></a></span><ul>
        <?php
        if(!empty($v['children'])){
            $num2=-1;
            foreach($v['children'] as $key=>$val){
                $num2++;
                ?>
                <li>
                <span><a class="second <?php echo $_REQUEST['mid'].'-'.$val['id']?>" href="<?php echo $val['url'] == '#'?'#':Yii::app()->createUrl($val['url'],array('mid'=>$_GET['mid'],'nid'=>$val['id'],'classify'=>$val['name'],'heightFlag1'=>$num1,'heightFlag2'=>$num2))?>" class="<?php echo !empty($_GET['nid']) && $_GET['nid'] == $val['id']?'hovered':''?>">&nbsp;&nbsp;<?php echo $val['name']?></a></span>
                <ul>
                <?php

                if(!empty($val['children'])){
                    $num3=-1;

                    foreach($val['children'] as $keys=>$vals){
                        $num3++;
                        ?>

                        <li><span><a class="third <?php echo $_REQUEST['mid'].'-'.$vals['id']?>" href="<?php echo $vals['url'] == '#'?'#':Yii::app()->createUrl($vals['url'],array('mid'=>$_GET['mid'],'nid'=>$vals['id'],'classify'=>$val['name'],'heightFlag1'=>$num1,'heightFlag2'=>$num2,'heightFlag3'=>$num3))?>" class="<?php echo !empty($_GET['nid']) && $_GET['nid'] == $vals['id']?'hovered':''?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $vals['name']?></a></span></li>

                        <?php
                    }

                }
                ?>
                </ul>
                </li>
                <?php
            }
        }
        ?>
            </ul>
        </li>
        <?php
    }
}
?>
            </ul>
            <script type="text/javascript" language="javascript">
                navList(12);
            </script>
        </div>
        <div class="left_ico left_active"><a href="#"></a></div>
    </div>
<script type="text/javascript">
    window.onload = function(){
        $('li.thismenu div.submenu').show();
    };
    $('.left_ico').click(function(){
        $(this).toggleClass('left_active');
        $("#menubox").toggle();
    });
    $('.first').hover(function(){
        //$('.second').parent().parent().css('display','none');
        $(this).parent().next().children('li').css('display','block');
    })
    $(function(){
       
       var mid = "<?php echo !empty($_REQUEST['mid'])?$_REQUEST['mid']:''?>";
       var nid = "<?php echo !empty($_REQUEST['nid'])?$_REQUEST['nid']:''?>";
       if(!empty(nid)){
         var str = '.'+mid+'-'+nid;
       $(str).css('background','#52CAF4');
       }
       //var str = '.'+mid+'-'+nid;
       //$(str).css('background','#52CAF4');
    })
    /*$('.second').hover(function(){
     $('.third').parent().parent().css('display','none');
     $(this).parent().next().children('li').css('display','block');
     })*/
</script>
<?php

if(isset($_REQUEST['heightFlag1']) && isset($_REQUEST['heightFlag2']) && isset($_REQUEST['heightFlag3'])){
    echo   "<script>
                $('#J_navlist').children('li').eq(".$_REQUEST['heightFlag1'].").children('ul').children('li').eq(".$_REQUEST['heightFlag2'].").children('ul').children('li').eq(".$_REQUEST['heightFlag3'].").css('background','#52CAF4');
//                $('#J_navlist').children('li').eq(".$_REQUEST['heightFlag1'].").children('ul').children('li').eq(".$_REQUEST['heightFlag2'].").hide();
                 $('#J_navlist').children('li').eq(".$_REQUEST['heightFlag1'].").children('ul').children('li').eq(".$_REQUEST['heightFlag2'].").siblings('li').hide();
                $('#J_navlist').children('li').eq(".$_REQUEST['heightFlag1'].").children('ul').children('li').eq(".$_REQUEST['heightFlag2'].").children('ul').children('li').show();
                </script>";
}else if(isset($_REQUEST['heightFlag1']) && isset($_REQUEST['heightFlag2'])){
    echo "<script>
                $('#J_navlist').children('li').eq(".$_REQUEST['heightFlag1'].").children('ul').children('li').eq(".$_REQUEST['heightFlag2'].").css('background','#52CAF4');
                $('#J_navlist').children('li').eq(".$_REQUEST['heightFlag1'].").children('ul').children('li').show();
             </script>";
}else if(isset($_REQUEST['heightFlag1'])){
    echo "<script>
                $('#J_navlist').children('li').eq(".$_REQUEST['heightFlag1'].").css('background','#52CAF4');
                $('#J_navlist').children('li').eq(".$_REQUEST['heightFlag1'].").show();
             </script>";
}

?>





