<?php
	if(isset($errors)){
		if(empty($errors)){	
			__("Netflix queue emptied.");
		}
		else{
			print_r($errors);
		}
	}
	
	echo $html->link('Clear my Netflix instant queue', array('controller' => 'queues', 'action' => 'clearNetflixQueue/instant'));
	echo '<br />';
?>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('View Netflix Queue', true), array('action' => 'viewNetflixQueue')); ?> </li>
		<li><?php echo $this->Html->link(__('List Saved Queues', true), array('action' => 'index')); ?> </li>
	</ul>
</div>
