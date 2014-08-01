<?php
if(isset($netflixTitlesForBlockbusterQueue)){
	if(isset($error) && $error == true){?>
		<p class="warning">
			Some items from the blockbuster queue could not be found at the 
			Netflix site, or the items did not have a title that exactly matched
			a title at the Netflix site. In the case that the title did not match,
			the Netflix title that was most similar was used. If the title added
			is not appropriate, you will success finding and adding the titles at 
			Netflix' site.
		</p><?php
	}
	
	foreach($netflixTitlesForBlockbusterQueue as $netflixResult){
		if(empty($netflixResult['error'])){
			continue;
		}
		
		?><p class="warning">
			<?php 
				echo $netflixResult['blockbusterTitleName'] . " did not have an exact match. ";
				if(isset($netflixResult['netflixSearchResults'][0])){
					echo "The closest match '{$netflixResult['netflixSearchResults'][0]['name']}'".
						" has been added to the queue here"; 
				}
			?>			
		</p>
		<hr/>
		<?php		
	}	
}
else{
	?>
	<p>
	Use your web browser to save your blockbuster queue as an HTML file.
	Upload that HTML file here. This tool extracts the movie titles from the
	HTML file. 
	The tool then searches for each of these titles at Netflix. The top
	result that the search returns becomes an entry in a queue that exists here. 
	You can then load the queue that exists here in to your netflix queue.
	You can also use this tool to create a backup of your netflix queue, to load
	the backups in to your Netflix queue, and to empty your Netflix queue.
	
	Please note that this tool can only add titles to your netflix streaming queue
	due to technical limitations.
	</p>
	<?php 
	echo $form->create('Queue', array('action' => 'uploadBlockbusterQueue', 'type' => 'file'));
	?><input type="hidden" name="MAX_FILE_SIZE" value="3000000" /><?php
	echo $form->file('blockbusterQueue');
	echo $form->input('Queue.name');
	$options = array(
		'name' => 'Upload a blockbuster queue to convert to a queue of netflix titles',
		'label' => 'Upload Blockbuster queue',
		'div' => array(
			'class' => 'glass-pill',
		)
	);
	echo $form->end($options);
}
?>


<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Backup Netflix Queue', true), array('action' => 'saveNetflixQueue')); ?> </li>
		<li><?php echo $this->Html->link(__('Clear Netflix Queue', true), array('action' => 'clearNetflixQueue')); ?> </li>
		<li><?php echo $this->Html->link(__('List Queues', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Upload another blockbuster queue', true), array('action' => 'uploadBlockbusterQueue')); ?> </li>
	</ul>
</div>
