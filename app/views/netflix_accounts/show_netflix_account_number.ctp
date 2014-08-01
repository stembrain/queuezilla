<div class="netflixAccounts view">
<h2><?php  __('Netflix Account');?></h2>
	<?php pr($accountNumber); ?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Show Netflix Account Info', true), array('action' => 'showNetflixAccountInfo', $netflixAccount['NetflixAccount']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Edit Netflix Account', true), array('action' => 'edit', $netflixAccount['NetflixAccount']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Netflix Account', true), array('action' => 'delete', $netflixAccount['NetflixAccount']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $netflixAccount['NetflixAccount']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Netflix Accounts', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Netflix Account', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
