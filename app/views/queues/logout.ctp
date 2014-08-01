<?php
print_r($_SESSION);
echo $form->create('User', array('action' => 'login'));
echo $form->input('username');
echo $form->password('password	');

$options = array(
	'name' => 'Login',
	'label' => 'Login',
	'div' => array(
		'class' => 'glass-pill',
 	)
);
echo $form->end($options);

?>