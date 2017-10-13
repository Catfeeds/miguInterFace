<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.9.1.min.js"></script>
    <style>
        *{margin:0px;padding:0px 0px}
        table{width:100%;}
        .bid{width:100%;}
        .button{
            width: 100px;
            height:40px;
            line-height: 38px;
            text-align: center;
            font-weight: bold;
            color: #fff;
            text-shadow:1px 1px 1px #333;
            border-radius: 5px;
            margin:0 20px 20px 0;
            position: relative;
            overflow: hidden;
        }
        ul{
            margin-left:70px;
        }
        ul li{
            list-style-type:none;
            float:left;
        }
    </style>
</head>
<body>
<section>
    <!--<form action="./deng" method="post" >-->
        <table>
            <?php if(!empty($list)):?>
                <tr>
                    <th>用户名</th>
                    <th>序列号</th>
                </tr>
                <?php foreach ($list as $val):?>
                    <tr>
                        <td style="text-align:center;width:30%">
                            <input type="radio" class="radio" name="id" value="<?php echo $val['id']?>">
                            <?php echo $val['name']?>
                        </td>
                        <td  style="text-align:center"><?php echo $val['bid']?></td>
                    </tr>
                <?php endforeach;?>
                <tr><td colspan='2'><?php echo $page?></td></tr> 
                <tr><td colspan="2" style="text-align:center"><input type="submit" class="button btn1" onclick="select(true)" value="确认"></td></tr>
            <?php else:?>
            <?php endif?>
        </table>

    <!--</form>-->
    <!--<form action="./deng" method="post" style="margin-top:20px">-->
        <span style="font-size:20px;margin-top:10px;">请输入标识：</span>
        <div style="padding:5px 5px;border:1px solid #123465;border-radius:10px">
            <input type="text" placeholder="请输入标识" name="name" style="display:inline-block;width: 100%;height:30px;line-height:30px;outline:0;font-size: 20px;padding: 0; margin-left: .13889rem;border: 0;color: #333;"><br/>
        </div>
        <span style="font-size:20px;margin-top:10px;">请输入盒子序列号：</span>
        <div style="padding:5px 5px;border:1px solid #123456;border-radius:10px">
            <input type="text" class="bid" placeholder="请输入32位序列号" name="bid" style="display:inline-block;width: 100%;outline: 0;font-size: 100%;padding: 0; margin-left: .13889rem;border: 0;color: #333;border-radius:10px"><br/>
        </div>
        <div style="text-align:center;margin-top:20px">
            <input type="submit" class="button btn" value="注册">
        </div>
    <!--</form>-->
</section>
<script type="text/javascript">
    $('.bid').blur(function(){
        var isBid = /^[a-zA-Z0-9]{32,32}$/;
        if(!isBid.test($(this).val()))
            alert('请输入32位序列号');
    });

    $('.btn').click(function(){
        var k = $(this);
        var G = {};
        G.name =$('input[name=name]').val();
        G.bid = $('input[name=bid]').val();
        //alert(G.bid);
        if(G.name==''){
            alert('标识不能为空');
            return false;
        }
        if(G.bid==''){
            alert('序列号不能为空');
            return false;
        }
        $(".btn").one("click", function () { 
          alert('注册完成')
        }); 

        $.post('/weixin/demo/deng',G,function(d){
            window.location.href='/weixin/demo/demo.html';
        })
        
    });
    $(function(){
         $(".btn1").click(function(){
            var val=$('input:radio[name="id"]:checked').val();
            if(val==null){
                alert("请选择");
                return false;
            }
            else{
                var k = $(this);
                var G = {};
                G.id =$('input[name=id]').val();
               $.post('/weixin/demo/deng',G,function(d){
            window.location.href='/weixin/demo/demo.html';
        }) 
            }
           
         });
     });
    
</script>
</body>
</html>