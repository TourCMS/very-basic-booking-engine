<?php
	/*
		step5.php
		
		Converts temp booking to a confirmed booking
		
	*/
	
	include_once("inc/top.php");
	
	// Include the config file
	include('inc/config.php');
	
	$booking_id = (isset($_POST['booking_id']) ? (int)$_POST['booking_id'] : 0);
	
	if($booking_id > 0) {
	  
	// Create a new SimpleXMLElement to hold the booking details 
	$booking = new SimpleXMLElement('<booking />'); 
	$booking->addChild('booking_id', $booking_id); 
		
	$result = $tourcms->commit_new_booking($booking, $channel);
	
	}
	
?>
<h1>Booking <?php print $result->booking->booking_id; ?> complete</h1>
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