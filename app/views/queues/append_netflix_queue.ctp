<?php
	if(empty($errors)){
		__(count($queueMovies) . "Items added to the netflix queue");
	}
	else{
		__("Errors adding items to your active netflix queue:");
		foreach($errors as $error){
			pr($error);
		}
	}
?>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('View Netflix Queue', true), array('action' => 'viewNetflixQueue')); ?> </li>
		<li><?php echo $this->Html->link(__('List Saved Queues', true), array('action' => 'index')); ?> </li>
	</ul>
</div>
