<div class="netflixAccounts index">
	<h2><?php __('Netflix Accounts');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('account_number');?></th>
			<th><?php echo $this->Paginator->sort('oauth_token');?></th>
			<th><?php echo $this->Paginator->sort('oauth_token_secret');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($netflixAccounts as $netflixAccount):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $netflixAccount['NetflixAccount']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($netflixAccount['User']['id'], array('controller' => 'users', 'action' => 'view', $netflixAccount['User']['id'])); ?>
		</td>
		<td><?php echo $netflixAccount['NetflixAccount']['account_number']; ?>&nbsp;</td>
		<td><?php echo $netflixAccount['NetflixAccount']['oauth_token']; ?>&nbsp;</td>
		<td><?php echo $netflixAccount['NetflixAccount']['oauth_token_secret']; ?>&nbsp;</td>
		<td><?php echo $netflixAccount['NetflixAccount']['created']; ?>&nbsp;</td>
		<td><?php echo $netflixAccount['NetflixAccount']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $netflixAccount['NetflixAccount']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $netflixAccount['NetflixAccount']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $netflixAccount['NetflixAccount']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $netflixAccount['NetflixAccount']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Netflix Account', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>