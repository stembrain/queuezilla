<div class="queues form">
<?php echo $this->Form->create('Queue');?>
	<fieldset>
 		<legend><?php __('Add Queue'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('name');
		echo $this->Form->input('etag');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Queues', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Queue Movies', true), array('controller' => 'queue_movies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Queue Movie', true), array('controller' => 'queue_movies', 'action' => 'add')); ?> </li>
	</ul>
</div>