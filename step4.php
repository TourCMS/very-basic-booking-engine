<?php
	/*
		step4.php
		
		
		Builds up an XML document representing the customers booking
		Posts that XML to TourCMS creating a temporary booking
		Temporary booking will be holding off space on any departures / rooms selected
		
	*/
	$title = "Temporary booking created, prompt for creation of confirmed booking";
	include_once("inc/top.php");
	
	// Include the config file
	include('inc/config.php');
	
	$component_key = isset($_POST['component_key']) ?  $_POST['component_key'] : null;

	$total_people = (int)$_POST['total_people'];
	
	$titles = $_POST['title'];
	$firstnames = $_POST['firstname'];
	$surnames = $_POST['surname'];
	$email = $_POST['email'];
	  
	// Create a new SimpleXMLElement to hold the booking details 
	$booking = new SimpleXMLElement('<booking />'); 
	$booking->addChild('total_customers', $total_people); 
	
	if($marketplace_account_id == 0)
		$booking->addChild('booking_key', $_POST['booking_key']); 
	
	$components = $booking->addChild('components'); 
	$component = $components->addChild('component_key', $component_key);
	
	$customers = $booking->addChild('customers');
	  
	// Add on the customers
	for($i=0; $i<$total_people; $i++) {
		$customer = $customers->addChild('customer');
		
		$customer->addChild('title', $titles[$i]);
		$customer->addChild('firstname', $firstnames[$i]);
		$customer->addChild('surname', $surnames[$i]);
		
		if($i==0)
			$customer->addChild('email', $email);
	} 
	
	$result = $tourcms->start_new_booking($booking, $channel_id);
	
?>
<h1><?php print $title; ?></h1>
<p>Are you sure you wish to book this Tour/Hotel?</p>
<form method="post" action="step5.php">
	<input type="hidden" name="booking_id" value="<?php print $result->booking->booking_id; ?>" />
	<input type="submit" name="submit" value="Go" />
</form>
	
<?php 
	include_once("inc/debug.php");
	include_once("inc/bottom.php");
 ?>