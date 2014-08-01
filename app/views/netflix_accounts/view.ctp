<div class="netflixAccounts view">
<h2><?php  __('Netflix Account');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $netflixAccount['NetflixAccount']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($netflixAccount['User']['id'], array('controller' => 'users', 'action' => 'view', $netflixAccount['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Account Number'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $netflixAccount['NetflixAccount']['account_number']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Oauth Token'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $netflixAccount['NetflixAccount']['oauth_token']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Oauth Token Secret'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $netflixAccount['NetflixAccount']['oauth_token_secret']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $netflixAccount['NetflixAccount']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $netflixAccount['NetflixAccount']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Show Netflix Account Number', true), array('action' => 'showNetflixAccountNumber', $netflixAccount['NetflixAccount']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Edit Netflix Account', true), array('action' => 'edit', $netflixAccount['NetflixAccount']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Netflix Account', true), array('action' => 'delete', $netflixAccount['NetflixAccount']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $netflixAccount['NetflixAccount']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Netflix Accounts', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Netflix Account', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
