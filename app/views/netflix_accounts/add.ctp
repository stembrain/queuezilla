<div class="netflixAccounts form">
<?php echo $this->Form->create('NetflixAccount');?>
	<fieldset>
 		<legend><?php __('Add Netflix Account'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('account_number');
		echo $this->Form->input('oauth_token');
		echo $this->Form->input('oauth_token_secret');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Netflix Accounts', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>