<?php
if(isset($errors)){
	__("Errors saving your queue: " . print_r($errors, true));
}

echo $form->create('Queue', array('action' => 'saveNetflixQueue'));
echo $form->input('name');
__("Making a queue Public only allows users to view the titles in the queue and load the titles in the queue to their netflix queue. They will not have the ability to edit or delete the queue.");
echo '<br />';
__("Making a queue Private means that only you can view, load, edit, or delete the queue.");
echo $this->Form->radio('privacy', array('public' => 'Public', 'private' => 'Private'));

$options = array(
	'name' => 'Backup my queue',
	'label' => 'Backup my queue',
	'div' => array(
		'class' => 'glass-pill',
 	)
);
echo $form->end($options);

?>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('View Netflix Queue', true), array('action' => 'viewNetflixQueue')); ?></li>
		<li><?php echo $this->Html->link(__('Clear Netflix Queue', true), array('action' => 'clearNetflixQueue')); ?> </li>
		<li><?php echo $this->Html->link(__('List Saved Queues', true), array('action' => 'index')); ?> </li>
	</ul>
</div>
