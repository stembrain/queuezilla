<?php
//pr($queuedMovies);
foreach($queuedMovies as $queuedMovie){
	echo $this->element('netflix_catalog_title', array('catalogTitle' => $queuedMovie, 'addable' => false));
}
?>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Backup Netflix Queue', true), array('action' => 'saveNetflixQueue')); ?> </li>
		<li><?php echo $this->Html->link(__('Clear Netflix Queue', true), array('action' => 'clearNetflixQueue')); ?> </li>
		<li><?php echo $this->Html->link(__('List Queues', true), array('action' => 'index')); ?> </li>
	</ul>
</div>
