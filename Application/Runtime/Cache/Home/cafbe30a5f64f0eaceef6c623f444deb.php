<?php if (!defined('THINK_PATH')) exit();?><div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">User <span class="badge"><?php echo ($userNum); ?></span></h3>
	</div>
	<div class="list-group">
		<?php if(is_array($users)): foreach($users as $key=>$user): ?><a href="#" class="list-group-item"><?php echo ($user['username']); ?></a><?php endforeach; endif; ?>
	</div>
</div>