<?php 
	include('../post/tourcms-php/tourcms.php');

	include('config.php');
	
	// Create a new SimpleXMLElement to hold the response url 
	$url_data = new SimpleXMLElement('<url />'); 
	// Add the response url, TourCMS will redirect to this, appending the key
	$url_data->addChild('response_url', str_replace("{tour_id}", (int)$_GET['tour'], $response_url)); 
	
	
	// Call TourCMS API, updating the customer
	$result = $tourcms->get_booking_redirect_url($url_data, $channel);
	
	// Process the redirect URL
	$redirect_url = $result->url->redirect_url;
	
	// Redirect the customer to TourCMS
	header("Location: " . $redirect_url);
	exit();
		
?><pre><?php print_r($result); ?></pre>