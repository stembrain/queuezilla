<div class="queueMovies form">
<?php echo $this->Form->create('QueueMovie');?>
	<fieldset>
 		<legend><?php __('Edit Queue Movie'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('movie_id');
		echo $this->Form->input('queue_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('QueueMovie.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('QueueMovie.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Queue Movies', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Movies', true), array('controller' => 'movies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Movie', true), array('controller' => 'movies', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Queues', true), array('controller' => 'queues', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Queue', true), array('controller' => 'queues', 'action' => 'add')); ?> </li>
	</ul>
</div>