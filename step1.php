<?php 
	/*
		step1.php
		
		
		
		This page should be invisible to the user
		they will be redirected from here to TourCMS
		then subsequently on to step2.php
	*/
	
	// Include the config file
	include('inc/config.php');

	// Create a new SimpleXMLElement to hold the response url 
	$url_data = new SimpleXMLElement('<url />'); 
	
	// Add the response url, TourCMS will redirect to this, appending the key
	$url_data->addChild('response_url', str_replace("{tour_id}", (int)$_GET['tour'], $response_url)); 
	
	// Send the response URL to TourCMS
	$result = $tourcms->get_booking_redirect_url($url_data, $channel);
	
	// TourCMS should have returned a URL back to us, get that
	$redirect_url = $result->url->redirect_url;
	
	// Redirect the customer to the URL obtained from TourCMS
	header("Location: " . $redirect_url);
	exit();
		
?><pre><?php print_r($result); ?></pre>