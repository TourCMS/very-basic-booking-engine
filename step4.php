<?php
	/*
		step4.php
		
		
		Calls "Check Availability" to see actual live availability
		If there's a choice then that's displayed to the customer
		Boxes for customer details displayed
		
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
	
	 /*<booking>
	   <total_customers>5</total_customers>
	 <components>   <component_key>HJ9bTSGoEDggHp8dsqabg6svjs0oaZiIx06jUrncRCt3gqWj5nNZOhRzjICSqeaFeh0MxgEanx7Dd5oLR3fQB4qFNQjr0wzxJ18odj2px0pJY/X33Umude2SskWytAVLQjbrpDb2cY7a7VoDgxVzGMIylZ8xX1AKeBoPE+6j8ZI=</component_key>
	</components>
	<customers>
	 <customer>
	  <customer_id>4496</customer_id>
	</customer>
	 <customer>
	  <customer_id>4496</customer_id>
	</customer>
	</customers>
	  </booking>*/
	  
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
<p>Are you sure you wish to book this Tour?</p>
<form method="post" action="step5.php">
	<input type="hidden" name="booking_id" value="<?php print $result->booking->booking_id; ?>" />
	<input type="submit" name="submit" value="Go" />
</form>
	
<?php 
	include_once("inc/debug.php");
	include_once("inc/bottom.php");
 ?>