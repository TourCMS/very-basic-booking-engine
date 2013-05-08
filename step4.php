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

	$channel = isset($_POST['channel']) ?  $_POST['channel'] : null;

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
	$component = $components->addChild('component');
	$component->addChild('component_key', $component_key);
	
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
	
	$result = $tourcms->start_new_booking($booking, $channel);
	
?>
<h1><?php print $title; ?></h1>
<p>Are you sure you wish to book this Tour/Hotel?</p>
<form method="post" action="step5.php">
	<input type="hidden" name="booking_id" value="<?php print $result->booking->booking_id; ?>" />
	<input type="hidden" name="channel" value="<?php print $channel; ?>" />
	<input type="submit" name="submit" value="Go" />
</form>

<?php
// Hand off to standard booking engine
if(!empty($result->booking->booking_engine_url)) {
	?>
	<p>Or <a href="<?php echo $result->booking->booking_engine_url; ?>" target="_blank">hand off to the hosted booking engine to complete this booking</a><br />(if you were building a hand-off to the hosted booking engine for real you would probably have skipped the customer name collection on the previous page).</p>
	<?php
}	
?>
	
<?php 
	include_once("inc/debug.php");
	include_once("inc/bottom.php");
 ?>
