<?php
	include('../post/tourcms-php/tourcms.php');
	
	include('config.php');
	
	$result = $tourcms->search_tours("", $channel);

	if((string)$result->error != "OK") :
		print $result->status;
	else:
		foreach ($result->tour as $tour):
			?>
			<li><a href="step1.php?tour=<?php print $tour->tour_id; ?>"><?php print $tour->tour_name; ?></a></li>
			<?php
		endforeach;
	endif;
?><pre><?php print_r($result); ?></pre>