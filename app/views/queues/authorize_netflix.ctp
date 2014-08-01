<?php 
	echo '<pre>request token';
	print_r($netflixRequestToken);
	echo '</pre>'; 

	echo "<a href=\"$redirectURL\" target=\"_blank\">redirect:$redirectURL</a>";

?>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New User', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Groups', true), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group', true), array('controller' => 'groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
