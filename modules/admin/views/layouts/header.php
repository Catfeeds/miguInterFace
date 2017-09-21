<!--[if lt IE 8]>
<!--<link href="/css/bootstrap-ie7.css" rel="stylesheet">-->
<![endif]-->
<!--<link rel="stylesheet" href="/css/bootstrap-theme.css">-->
<!--<link rel="stylesheet" href="/css/bootstrap.css">-->
<link rel="stylesheet" href="/css/common.css">
<link rel="stylesheet" href="/css/admin.css">
<link rel="stylesheet" href="/css/style.css">
<script src="/js/jquery-1.9.1.min.js"></script>
<script src="/js/layer/layer.js"></script>
<script src="/js/func.js"></script>
<script type="text/javascript">
	function navList(id) {
		var $obj = $("#J_navlist"), $item = $("#J_nav_" + id);
		$item.addClass("on").parent().parent().addClass("thismenu");
		$obj.find("span").hover(function () {
			$(this).addClass("hover");
		}, function () {
			$(this).removeClass("hover");
		});
		$obj.find("a").hover(function () {
			if ($(this).hasClass("on")) {
				return;
			}
			$(this).addClass("hover");
		}, function () {
			if ($(this).hasClass("on")) {
				return;
			}
			$(this).removeClass("hover");
		});
		$obj.find("span").click(function () {
			var $div = $(this).siblings(".submenu");
			if ($(this).parent().hasClass("thismenu")) {
				$div.slideUp(600);
				$(this).parent().removeClass("thismenu");
			}
			if ($div.is(":hidden")) {
				$("#J_navlist li").find(".submenu").slideUp(600);
				$("#J_navlist li").removeClass("thismenu");
				$(this).parent().addClass("thismenu");
				$div.slideDown(600);
			} else {
				$div.slideUp(600);
			}
		});
	};
</script>
