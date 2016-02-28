<?php if (!defined('THINK_PATH')) exit();?><div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Friends <span class="badge"><?php echo ($friNum); ?></span></h3>
	</div>
	<div class="list-group">
		<?php if(is_array($friends)): foreach($friends as $key=>$f): ?><a href="#" class="list-group-item"><?php echo ($f['username']); ?></a><?php endforeach; endif; ?>
	</div>
</div>