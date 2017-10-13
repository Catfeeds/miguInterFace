<!doctype html>
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
            background:url("<?php echo Yii::app()->request->baseUrl; ?>/images/rebd1.png") repeat-x  center;height:1rem;border-radius:10px;border:none;background-size: 100% 100%;
        }

        .stbid{display:inline-block;width: 5.6rem;height:1rem;line-height:1rem;outline:0;font-size: 0.29rem;padding-left: 0.2rem;padding-right: 0.2rem; margin-left:0.2rem;border: 0;background-color:#3A3A3F;border-radius:10px;color:white;}
        .center{font-size: 0.3rem;margin:0.2rem 0.5rem;}

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
            <input type="text" placeholder="请输入设备号：" class="stbid" name="stbid" disabled="true" value="<?php echo
            !empty($list[0]['stbid'])?$list[0]['stbid']:'' ?>"><br/>
            <div class="center">设置-设备信息-序列号</div>
            <div style="text-align:center;margin-top:10%">
                <input type="submit" class="button btn1" value="" style="width:40.7%">
            </div>
        </div>
    </form>
</section>
</body>
</html>
