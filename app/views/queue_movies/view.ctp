<div class="queueMovies view">
<h2><?php  __('Queue Movie');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $queueMovie['QueueMovie']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Movie'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($queueMovie['QueueMovie']['title'], array('controller' => 'queue_movies', 'action' => 'view', $queueMovie['QueueMovie']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Queue'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($queueMovie['Queue']['name'], array('controller' => 'queues', 'action' => 'view', $queueMovie['Queue']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Netflix Link'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($queueMovie['QueueMovie']['external_link']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Netflix Key'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $queueMovie['QueueMovie']['netflix_key']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $queueMovie['QueueMovie']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $queueMovie['QueueMovie']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Queue Movie', true), array('action' => 'edit', $queueMovie['QueueMovie']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Queue Movie', true), array('action' => 'delete', $queueMovie['QueueMovie']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $queueMovie['QueueMovie']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Queue Movies', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Queue Movie', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Queues', true), array('controller' => 'queues', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Queue', true), array('controller' => 'queues', 'action' => 'add')); ?> </li>
	</ul>
</div>
