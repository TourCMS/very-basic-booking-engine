<?php 
	/*
		step0.php
		
		Lists Tours/Hotels available in the API
	*/

	include_once("inc/top.php");
 ?>
 <h1>List of Tours/Hotels</h1>
	<p>Not strictly part of the booking process, included here for navigation purposes, all Tours/Hotels <a href="http://www.tourcms.com/support/api/mp/useful.php" target="_blank">made available for the API</a> should be listed below:</p>
	
	
	<ul>
	<?php
	
	// Include the config file
	include('inc/config.php');
	
	// Search all Tours/Hotels
	$result = $tourcms->search_tours("", $channel);

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
	
	<!-- Debug -->
	<div id="debug">
		<form>
			<label><input type="radio" name="showdebug" value="none" checked /> Hide debug info</label>
			<label><input type="radio" name="showdebug" value="simplexml" /> Show SimpleXML object</label>
			<label><input type="radio" name="showdebug" value="rawxml" /> Show raw XML</label>
		</form>
		<pre class="simplexml"><?php print_r($result); ?></pre>
		<pre class="rawxml"><?php 
			// Add indentation to XML output
			$dom = new DOMDocument('1.0');
			$dom->preserveWhiteSpace = false;
			$dom->formatOutput = true;
			$dom->loadXML($result->asXML());
			echo htmlspecialchars($dom->saveXML());
		 ?></pre>
	</div>
	
<?php 
	include_once("inc/bottom.php");
 ?>