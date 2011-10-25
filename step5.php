<?php
	/*
		step5.php
		
		Converts temp booking to a confirmed booking
		
	*/
	$title = "Booking complete";
	include_once("inc/top.php");
	
	// Include the config file
	include('inc/config.php');
	
	$booking_id = (isset($_POST['booking_id']) ? (int)$_POST['booking_id'] : 0);
	$channel = (isset($_POST['channel']) ? (int)$_POST['channel'] : 0);
	
	if($booking_id > 0) {
	  
	// Create a new SimpleXMLElement to hold the booking details 
	$booking = new SimpleXMLElement('<booking />'); 
	$booking->addChild('booking_id', $booking_id); 
		
	$result = $tourcms->commit_new_booking($booking, $channel);
	
	}
	
?>
<h1>Booking <?php print $result->booking->booking_id; ?> complete</h1>

<p><a href="step0.php">Start a new booking</a></p>
<?php 
	include_once("inc/debug.php");
	include_once("inc/bottom.php");
 ?>