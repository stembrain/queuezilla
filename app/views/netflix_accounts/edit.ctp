<div class="netflixAccounts form">
<?php echo $this->Form->create('NetflixAccount');?>
	<fieldset>
 		<legend><?php __('Edit Netflix Account'); ?></legend>
	<?php
		echo $this->Form->input('jabber_account');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('View my netflix streaming queue', true), array('action' => 'viewNetflixQueue')); ?></li>
		<li><?php echo $this->Html->link(__('Backup my netflix queue', true), array('action' => 'saveNetflixQueue')); ?></li>
		<li><?php echo $this->Html->link(__('Empty my netflix queue', true), array('action' => 'clearNetflixQueue')); ?> </li>
		<li><?php echo $this->Html->link(__('Upload blockbuster queue', true), array('action' => 'uploadBlockbusterQueue')); ?></li>
	</ul>
</div>