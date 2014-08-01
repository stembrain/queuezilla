<?php 
//echo '<pre>user';
//print_r($user);
//echo '</pre>';
//
//echo '<pre>netflix account';
//print_r($netflixAccount);
//echo '</pre>';

//Feeds in xml
$feeds = new SimpleXMLElement($feeds);
pr($feeds);

?>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New User', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Groups', true), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group', true), array('controller' => 'groups', 'action' => 'add')); ?> </li>
	</ul>
</div>
