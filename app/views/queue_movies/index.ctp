<div class="queueMovies index">
	<h2><?php __('Queue Movies');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('position');?></th>
			<th><?php echo $this->Paginator->sort('queue_id');?></th>
			<th><?php echo $this->Paginator->sort('title');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($queueMovies as $queueMovie):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $queueMovie['QueueMovie']['position']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($queueMovie['Queue']['name'], array('controller' => 'queues', 'action' => 'view', $queueMovie['Queue']['id'])); ?>
		</td>
		<td><?php echo $queueMovie['QueueMovie']['title']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $queueMovie['QueueMovie']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $queueMovie['QueueMovie']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $queueMovie['QueueMovie']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $queueMovie['QueueMovie']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Queue Movie', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Movies', true), array('controller' => 'movies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Movie', true), array('controller' => 'movies', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Queues', true), array('controller' => 'queues', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Queue', true), array('controller' => 'queues', 'action' => 'add')); ?> </li>
	</ul>
</div>