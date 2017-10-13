<style type="text/css">
    table,tr,td{border:1px solid grey}
    .search{width:120px;border:1px solid #808080;line-height:35px;height: 40px;border-radius: 5px;font-size: 20px;}
    .search_btn{width: 40px;  height: 40px;  cursor: pointer; border-radius: 5px;position: relative;top:-2px}
    .fenlei ul li:nth-child(1){background-color: #0099CC;color:white;font-size: 25px;text-align: center;line-height:45px}
    .fenlei ul li{background-color: #A1A1A1;color:white;font-size: 20px;text-align: center;line-height:40px;border-radius: 5px;cursor: pointer}
    .fenlei ul .active{color:#000000;background-color: #D7D7D7}
    .load{text-align: center;width:900px;float:right;cursor: pointer}
    .btn,.gray{font-size: 20px;width:200px}
</style>
<body>
<div  class="content" style="height:550px;overflow: auto">
    <div style="float:left;width:190px">
        <div>
            <input type="text" class="search" placeholder="输入片名搜索" value="<?php echo !empty($_GET['word'])?$_GET['word']:''?>">
            <input type="submit" class="search_btn" value="搜索">
        </div>
        <div class="fenlei">
            <ul>
                <li>按牌照方</li>
                <li class="cp-1">华数</li>
                <li class="cp-2">百视通</li>
                <li class="cp-4">南传</li>
                <li class="cp-7">银河</li>
                <li class="cp-3">未来电视</li>
                <li class="cp-6">芒果</li>
                <li class="cp-5">国广</li>
            </ul>
        </div>
    </div>
    <table width="800px" style="float:right">
        <?php if(!empty($list)) {
            foreach ($list as $k=>$v){
                ?>
                <tbody>
                <tr>
                    <td rowspan="6" style="width:190px"><img src="<?php echo $v['img']?>" width="180px"></td>
                    <td width="100px">片名：</td>
                    <td colspan="4"><?php echo $v['title']?></td>
                </tr>
                <tr>
                    <td>导演：</td>
                    <td colspan="4"><?php echo $v['director']?></td>
                </tr>
                <tr>
                    <td>演员：</td>
                    <td colspan="4"><?php echo $v['actor']?></td>
                </tr>
                <tr>
                    <td>简介：</td>
                    <td colspan="4"><?php echo $v['info']?></td>
                </tr>
                <tr>
                    <td>牌照方：</td>
                    <td><?php
                         if($v['cp']==1) echo '华数';
                        if($v['cp']==2) echo '百视通';
                        if($v['cp']==4) echo '南传';
                        if($v['cp']==7) echo '银河';
                        if($v['cp']==3) echo '未来电视';
                        if($v['cp']==5) echo '国广';
                        if($v['cp']==6) echo '芒果';
                        ?></td>
                    <td>分类：</td>
                    <td><?php
                        echo $v['classify'];
                        ?></td>
                    <td><input type="checkbox" class="checkbox" name="id" value="<?php echo $v['id']?>"></td>
                </tr>
                </tbody>
                <?php
            }
        }else{ ?>
            <tr>
                <td colspan="7" style="text-align: center">暂无数据</td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
<div class="load" page=1>
    <button>加载更多</button>
</div>
<!-- <div>
        <?php /*echo $page;*/?>
    </div>-->
<div style="background:#808080;text-align:center;line-height: 70px;width:920px;float:right">
    <input type="submit" value="确定" class="btn">
    <input type="button" value="取消" class="gray" onclick="window.location.href='<?php echo $this->get_url('mov','movie')?>'">
</div>
</body>
<script>
     var cp = <?php echo !empty($_GET['cp'])?$_GET['cp']:'0'?>;
    if(cp!='0'){
        var str = '.cp-'+cp;
        $(str).addClass('active');
    }
    $('.fenlei ul li').click(function(){
        //alert($(this).html());
        var cp = $(this).html();
        if(cp!='按牌照方'){
            $(this).addClass('active').siblings().removeClass('active');
            switch(cp){
                case '华数':
                    cp="1";
                    break;
                case '百视通':
                    cp="2";
                    break;
                case '南传':
                    cp="4";
                    break;
                case '银河':
                    cp="7";
                    break;
                case '未来电视':
                    cp="3";
                    break;
                case '国广':
                    cp="5";
                    break;
                case '芒果':
                    cp="6";
                    break;
            }

        }else{
            cp = '';
            $(this).siblings().removeClass('active');
        }
        var word = $('.search').val();
        var p = 1;
        window.location.href = "/wechat/recommend/add.html?mid=<?php echo $this->mid?>&nid=<?php echo $_GET['nid']?>&classify=<?php echo $_GET['classify']?>&cp="+cp+"&page="+p+"&word="+word;
        /*$.post('/wechat/mov/search?mid=<?php echo $this->mid?>&nid=<?php echo $nid?>',{word:word,cp:cp,p:p},function(data){
            $('table').empty();
            if(data.code==200){
                //console.log(data.list);
                var data = data.list;
                var li ='';
                $.each(data,function(i){
                    li +='<tbody><tr><td rowspan="6" style="width:190px"><img src="'+data[i]['img']+'" width="180px"></td><td width="100px">片名：</td><td colspan="4">'+data[i]['title']+'</td></tr>';
                    li +='<tr><td>导演：</td><td colspan="4">'+data[i]['director']+'</td></tr>';
                    li +='<tr><td>演员：</td><td colspan="4">'+data[i]['actor']+'</td></tr>';
                    li +='<tr><td>简介</td><td colspan="4">'+data[i]['info']+'</td></tr>';
                    li +='<tr><td>牌照方：</td><td>'+data[i]['cp']+'</td><td>分类：</td><td>'+data[i]['type']+'</td><td><input type="checkbox" class="checkbox" name="id" value="'+data[i]['id']+'"></td></tr>';
                    li +='</tbody>';
                })
            }else{
                var li ='<tr><td colspan="7" style="text-align: center">暂无数据</td></tr>';
            }
            $('table').append(li);
        },'json')*/
         

    })

    $('.search_btn').click(function(){
        var word = $('.search').val();
        var cp = $('.fenlei .active').html();
        if(cp == undefined){
            cp ='';
        }
        switch(cp){
            case '华数':
                cp="1";
                break;
            case '百视通':
                cp="2";
                break;
            case '南传':
                cp="4";
                break;
            case '银河':
                cp="7";
                break;
            case '未来电视':
                cp="3";
                break;
            case '国广':
                cp="5";
                break;
            case '芒果':
                cp="6";
                break;
        }
        var p = 1;
        $.post('/wechat/recommend/search?mid=<?php echo $this->mid?>&nid=<?php echo $nid?>&classify=<?php echo $_GET['classify']?>',{word:word,cp:cp,p:p},function(data){
            $('table').empty();
            if(data.code==200){
                //console.log(data.list);
                var data = data.list;
                //$('table').empty();
                var li ='';
                $.each(data,function(i){
                    li +='<tbody><tr><td rowspan="6" style="width:190px"><img src="'+data[i]['pic']+'" width="180px"></td><td width="100px">片名：</td><td colspan="4">'+data[i]['title']+'</td></tr>';
                    li +='<tr><td>导演：</td><td colspan="4">'+data[i]['directors']+'</td></tr>';
                    li +='<tr><td>演员：</td><td colspan="4">'+data[i]['actor']+'</td></tr>';
                    li +='<tr><td>简介</td><td colspan="4">'+data[i]['con']+'</td></tr>';
                    li +='<tr><td>牌照方：</td><td>'+data[i]['cp']+'</td><td>分类：</td><td>'+data[i]['type']+'</td><td><input type="checkbox" class="checkbox" name="id" value="'+data[i]['id']+'"></td></tr>';
                    li +='</tbody>';
                })
                //$('table').append(li);
            }else{
                var li ='<tr><td colspan="7" style="text-align: center">暂无数据</td></tr>';
            }
            $('table').append(li);
        },'json')
    })

    $('.load').click(function(){
        var cp = $('.fenlei .active').html();
        if(cp == undefined){
            cp = '';
        }
        var word = $('.search').val();
        switch(cp){
            case '华数':
                cp="1";
                break;
            case '百视通':
                cp="2";
                break;
            case '南传':
                cp="4";
                break;
            case '银河':
                cp="7";
                break;
            case '未来电视':
                cp="3";
                break;
            case '国广':
                cp="5";
                break;
            case '芒果':
                cp="6";
                break;
        }
        var p = $(this).attr('page');
        $.post('/wechat/recommend/search?mid=<?php echo $this->mid?>&nid=<?php echo $nid?>&classify=<?php echo $_GET['classify']?>',{word:word,cp:cp,p:p},function(data){
            if(data.code==200){
                 var p = data.p;
                //console.log(data.list);
                var data = data.list;
                //$('table').empty();
                var li ='';
                $.each(data,function(i){
                    li +='<tbody><tr><td rowspan="6" style="width:190px"><img src="'+data[i]['img']+'" width="180px"></td><td width="100px">片名：</td><td colspan="4">'+data[i]['title']+'</td></tr>';
                    li +='<tr><td>导演：</td><td colspan="4">'+data[i]['director']+'</td></tr>';
                    li +='<tr><td>演员：</td><td colspan="4">'+data[i]['actor']+'</td></tr>';
                    li +='<tr><td>简介</td><td colspan="4">'+data[i]['info']+'</td></tr>';
                    li +='<tr><td>牌照方：</td><td>'+data[i]['cp']+'</td><td>分类：</td><td>'+data[i]['classify']+'</td><td><input type="checkbox" class="checkbox" name="id" value="'+data[i]['id']+'"></td></tr>';
                    li +='</tbody>';
                })
                p = p+1;
                $('.load').attr('page',p);
                //$('table').append(li);
            }else{
                var li ='<tr><td colspan="7" style="text-align: center">暂无数据</td></tr>';
            }
            $('table').append(li);
        },'json')
    })

    $('.btn').click(function(){

        var ids="";
        $("input[name='id']:checked").each(function() {

            ids += $(this).val()+' ';

        });
        if(ids==''){
            alert('请选择要添加的视频')
        }else{
            $.post('/wechat/recommend/doadd?mid=<?php echo $this->mid?>&nid=<?php echo $nid?>&classify=<?php echo $_REQUEST['classify']?>',{ids:ids},function(data){
                window.location.href="<?php echo Yii::app()->createUrl('/wechat/recommend/video',array('mid'=>$this->mid,'nid'=>$_GET['nid'],'classify'=>$_REQUEST['classify']))?>";
            })
        }

    })
</script>
