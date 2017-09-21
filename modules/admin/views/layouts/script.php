<script type="text/javascript">
	(function(){
		<?php
			if($flash = Yii::app()->user->getFlashes()){
				foreach($flash as $k=>$v){
					if($k != 'test'){
						printf('layer.alert("%s", {title:"%s", icon:"%s"});', $v['message'],$v['title'],$v['info']);
					}
				}
			}
		?>
	})()
</script>