<!dctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title><?php $this->pageTitle= '设备绑定'?></title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.9.1.min.js"></script>
    <style>
        *{margin: 0;padding: 0;}
        .clear{clear:both}
        body{background-color: #F2F2F2;}
            header{width:6.4rem;text-align: center;line-height: 0.7rem;height:2.3rem}
            #header{}
            p{text-align: left;font-size: 0.38rem;margin:  0.5rem 0.5rem 0 0.5rem;}
            section{width:6.4rem;}
            span{font-size: 1rem}
            .button{
                background-color: #F2F2F2;background:url("<?php echo Yii::app()->request->baseUrl; ?>/images/bd.png") repeat-x  center;height:1rem;border-radius:10px;border:none;background-size: 100% 100%;
            }

            .stbid{display:inline-block;width: 5.6rem;height:1rem;line-height:1rem;outline:0;font-size: 0.29rem;padding-left: 0.2rem;padding-right: 0.2rem; margin-left:0.2rem;border: 0;background-color:#3A3A3F;border-radius:10px;color:white;}
            .center{font-size: 0.3rem;margin:0.2rem 0.5rem;}
            .spinner {
            margin: -1rem auto 0;
            width: 150px;
            text-align: center;
            display:none;
        }

        .spinner > div {
            width: 30px;
            height: 30px;
            background-color: #67CF22;

            border-radius: 100%;
            display: inline-block;
            -webkit-animation: bouncedelay 1.4s infinite ease-in-out;
            animation: bouncedelay 1.4s infinite ease-in-out;
            /* Prevent first frame from flickering when animation starts */
            -webkit-animation-fill-mode: both;
            animation-fill-mode: both;
        }

        .spinner .bounce1 {
            -webkit-animation-delay: -0.32s;
            animation-delay: -0.32s;
        }

        .spinner .bounce2 {
            -webkit-animation-delay: -0.16s;
            animation-delay: -0.16s;
        }

        @-webkit-keyframes bouncedelay {
            0%, 80%, 100% { -webkit-transform: scale(0.0) }
            40% { -webkit-transform: scale(1.0) }
        }

        @keyframes bouncedelay {
            0%, 80%, 100% {
                transform: scale(0.0);
                -webkit-transform: scale(0.0);
            } 40% {
                  transform: scale(1.0);
                  -webkit-transform: scale(1.0);
              }
        }
    </style>
</head>
<script type="text/javascript">
    (function (doc, win) {
        var docEl = doc.documentElement,
            resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
            recalc = function () {
                var clientWidth = docEl.clientWidth;
                if (!clientWidth) return;
                if(clientWidth>=640){
                    docEl.style.fontSize = '100px';
                }else{
                    docEl.style.fontSize = 100 * (clientWidth / 640) + 'px';
                }
            };

        if (!doc.addEventListener) return;
        win.addEventListener(resizeEvt, recalc, false);
        doc.addEventListener('DOMContentLoaded', recalc, false);
    })(document, window);
</script>
<body>

<header>
    <div id="header"><p>欢迎您在微信中绑定魔百和终端享受跨屏服务的精彩体验</p></div>
</header>
<section>
    <form action="./bd" method="post">
        <div>
            <input type="hidden" name="id" value="<?php echo !empty($list[0]['id'])?$list[0]['id']:'' ?>">
            <input type="text" placeholder="请输入设备号：" class="stbid" name="stbid"><br/>
            <div class="center">设置-设备信息-序列号</div>
            <div style="text-align:center;margin-top:10%">

                <input type='submit' class='button btn1' value="" style='width:40.7%'>

            </div>
            <div class="spinner">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
    </form>
</section>
<script type="text/javascript">
    $('.stbid').blur(function(){
        var isStbid = /^[a-zA-Z0-9]{8,32}$/;
        if(!isStbid.test($('.stbid').val()))
            alert('请输入8位序列号');
        return false;
    });
    $(function(){
        $('.btn1').click(function(){
            var k = $(this);
            var G = {};
            G.stbid =$('input[name=stbid]').val();
            if(G.stbid==''){
                alert('序列号不能为空');
                return false;
            }
            var isStbid = /^[a-zA-Z0-9]{8,32}$/;
            if(!isStbid.test($('.stbid').val())){
                alert('请输入正确的8位序列号');
                return false;
            }
            alert('绑定成功');
            $('.spinner').css('display','block');
        })
    });
</script>
</body>
</html>


