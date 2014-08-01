<?php

//echo '<pre>request token';
//print_r($requestToken);
//echo '</pre>';
//
//echo '<pre>user';
//print_r($user);
//echo '</pre>';
//
//
//echo '<pre>netflix consumer with full response';
//print_r($netflix);
//echo '</pre>';
//
//echo '<pre>access token';
//print_r($accessToken);
//echo '</pre>';
//
//echo '<pre>netflix account';
//print_r($netflixAccount);
//echo '</pre>';
//
//echo '<pre>full response';
//print_r($fullResponse);
//echo '</pre>';

	if(isset($error) && strlen($error)){?>
		<strong>Error: <?php __($error); ?></strong><?php
	}
?>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Queues', true), array('controller' => 'queues', 'action' => 'index')); ?></li>
	</ul>
</div>
