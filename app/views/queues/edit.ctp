<div class="queues form">
<?php echo $this->Form->create('Queue');?>
	<fieldset>
 		<legend><?php __('Edit Queue'); ?></legend>
	<?php
		echo $this->Form->hidden('id');
		echo $this->Form->hidden('account_number');
		echo $this->Form->input('name');
		__("Making a queue Public only allows users to view the titles in the queue and add the titles in the queue to their netflix queue. They will not have the ability to edit or delete the queue.");
		echo '<br />';
		__("Making a queue Private means that only you can view, load, edit, or delete the queue.");
		echo $this->Form->radio('privacy', array('public' => 'Public', 'private' => 'Private'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Queue.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Queue.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Queues', true), array('action' => 'index'));?></li>
	</ul>
</div>