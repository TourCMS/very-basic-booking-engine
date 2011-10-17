<?php
	include('../post/tourcms-php/tourcms.php');

	include('config.php');
	
	$booking_id = (isset($_POST['booking_id']) ? (int)$_POST['booking_id'] : 0);
	
	if($booking_id > 0) {
	  
	// Create a new SimpleXMLElement to hold the booking details 
	$booking = new SimpleXMLElement('<booking />'); 
	$booking->addChild('booking_id', $booking_id); 
		
	$result = $tourcms->commit_new_booking($booking, $channel);
	
	}
	
?>
<pre><?php print_r($result); ?></pre>