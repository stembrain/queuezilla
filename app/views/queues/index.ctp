<h3>The Action links below allow you to:</h3>
<ol>
  <li> Save your Netflix streaming queue as a queue here.</li>
  <li> Load a queue from here in to your Netflix streaming queue.</li>
  <li> Empty your netflix streaming queue. This is useful for swapping your streaming queue between multiple queues stored here.</li>
  <li> Upload a blockbuster queue in HTML format for storage here as a queue. The queue can then be added to your netflix streaming queue.</li>
</ol>

<p>
If you would like to share a queue with other users of this site, click Edit
beside the name of the queue. From there you can change the privacy of the queue.
</p> 
<div class="queues index">
	<h2><?php __('Queues');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($queues as $queue):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $queue['Queue']['account_number']; ?>&nbsp;</td>
		<td><?php echo $queue['Queue']['name']; ?>&nbsp;</td>
		<td><?php echo $queue['Queue']['created']; ?>&nbsp;</td>
		<td><?php echo $queue['Queue']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Load', true), array('action' => 'appendNetflixQueue', $queue['Queue']['id'])); ?>
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $queue['Queue']['id'])); ?>
			<?php 
				if($userId == $queue['Queue']['account_number']){
					echo $this->Html->link(__('Edit', true), array('action' => 'edit', $queue['Queue']['id']));
					echo $this->Html->link(__('Delete', true), array('action' => 'delete', $queue['Queue']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $queue['Queue']['id'])); 
				}
			?>
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
		<li><?php echo $this->Html->link(__('View my netflix streaming queue', true), array('action' => 'viewNetflixQueue')); ?></li>
		<li><?php echo $this->Html->link(__('Backup my netflix queue', true), array('action' => 'saveNetflixQueue')); ?></li>
		<li><?php echo $this->Html->link(__('Empty my netflix queue', true), array('action' => 'clearNetflixQueue')); ?> </li>
		<li><?php echo $this->Html->link(__('Upload blockbuster queue', true), array('action' => 'uploadBlockbusterQueue')); ?></li>
        <li><?php echo $this->Html->link(__('Add instant message control', true), array('controller' => 'netflix_accounts', 'action' => 'edit')); ?></li>
	</ul>
</div>