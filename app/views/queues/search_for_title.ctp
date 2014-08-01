<?php
if(isset($results)){
	if(empty($results)){
		__("No results for $searchTerm");
	}
	else{?>
		<p>Results for <?php echo $searchTerm; ?></p><?php 
		foreach($results as $result){
			echo $this->element('netflix_catalog_title', array('catalogTitle' => $result, 'addable' => true));
		}
	}
}

echo $form->create('Queue', array('action' => 'searchForTitle'));
echo $form->input('searchTerm');

$options = array(
	'name' => 'Search',
	'label' => 'Search',
	'div' => array(
		'class' => 'glass-pill',
)
);
echo $form->end($options);

?>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Saved Queues', true), array('action' => 'index')); ?> </li>
	</ul>
</div>
