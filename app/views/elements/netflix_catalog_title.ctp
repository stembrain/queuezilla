<?php
$netflixLink = $catalogTitle['externalLink'];
$title = $catalogTitle['name'];
$boxArtSmall = $catalogTitle['boxArtSmallLink'];
$year = $catalogTitle['year'];

//echo '<pre>'; print_r($catalogTitle); echo "</pre>";
?>
<div class="catalogTitle">
	<a href="<?php echo $netflixLink;?>">
		<img src="<?php echo $boxArtSmall; ?>"></img>
		<span class="catalogTitle"><?php echo $title; ?></span>&nbsp;
		<span class="catalogTitleReleaseYear"><?php echo "($year)";?></span>
	</a>
	
	<?php if(array_key_exists('score', $catalogTitle)){ ?>
		<span class="note">Score: <?php echo $catalogTitle['score'];?></span>
	<?php } ?>		
	
	<?php 
	if($addable){
		?>
		<br />
		<form action="/lab/queues/addTitle" method="post">
			<input type="hidden" name="data[QueueMovie][netflix_key]" value="<?php echo $netflixLink; ?>"></input>
			<input type="submit" value="Add to queue"></input>
		</form><?php
	} ?>	
</div>