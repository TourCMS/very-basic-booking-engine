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
		
	$result = $tourcms->commit_new_booking($booking, $channel_id);
	
	}
	
?>
<h1>Booking <?php print $result->booking->booking_id; ?> complete</h1>

	
<?php 
	include_once("inc/debug.php");
	include_once("inc/bottom.php");
 ?>