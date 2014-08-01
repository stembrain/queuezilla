<div class="queueMovies form">
<?php echo $this->Form->create('QueueMovie');?>
	<fieldset>
 		<legend><?php __('Add Queue Movie'); ?></legend>
	<?php
		echo $this->Form->input('movie_id');
		echo $this->Form->input('queue_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Queue Movies', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Movies', true), array('controller' => 'movies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Movie', true), array('controller' => 'movies', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Queues', true), array('controller' => 'queues', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Queue', true), array('controller' => 'queues', 'action' => 'add')); ?> </li>
	</ul>
</div>