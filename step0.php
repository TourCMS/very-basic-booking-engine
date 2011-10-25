<?php 
	/*
		step0.php
		
		Lists Tours/Hotels available in the API
	*/
	$title = "List of Tours/Hotels";
	include_once("inc/top.php");
 ?>
 <h1><?php print $title; ?></h1>
	<p>Not strictly part of the booking process, included here for navigation purposes, all Tours/Hotels <a href="http://www.tourcms.com/support/api/mp/useful.php" target="_blank">made available for the API</a> should be listed below:</p>
	
	
	<ul>
	<?php
	
	// Include the config file
	include('inc/config.php');
	
	// Search all Tours/Hotels
	$result = $tourcms->search_tours("", $channel_id);

	// Print out an error if there is one
	// Otherwise loop through Tours/Hotels and display them
	if((string)$result->error != "OK") :
		print $result->status;
	else:
		foreach ($result->tour as $tour):
			?>
			<li><a href="step1.php?tour=<?php print $tour->tour_id; ?>"><?php print $tour->tour_name; ?></a></li>
			<?php
		endforeach;
	endif;
	
	
	?>
	</ul>

<?php 
	include_once("inc/debug.php");
	include_once("inc/bottom.php");
 ?>