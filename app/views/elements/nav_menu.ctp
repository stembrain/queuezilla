<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('View queues here', true), array('controller' => 'queues', 'action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('View my netflix streaming queue', true), array('action' => 'viewNetflixQueue')); ?></li>
		<li><?php echo $this->Html->link(__('Backup my netflix queue', true), array('action' => 'saveNetflixQueue')); ?></li>
		<li><?php echo $this->Html->link(__('Empty my netflix queue', true), array('action' => 'clearNetflixQueue')); ?> </li>
		<li><?php echo $this->Html->link(__('Upload blockbuster queue', true), array('action' => 'uploadBlockbusterQueue')); ?></li>
        <li><?php echo $this->Html->link(__('Add instant message control', true), array('controller' => 'netflix_accounts', 'action' => 'edit')); ?></li>
	</ul>
</div>