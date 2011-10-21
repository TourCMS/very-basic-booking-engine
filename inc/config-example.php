<?php
	// Include the TourCMS API wrapper
	include_once($_SERVER['DOCUMENT_ROOT'] . '/tourcms.php');
	
	// Marketplace account ID
	// Leave this as zero if you are a supplier (i.e. not a Marketplace partner)
	$marketplace_account_id = 0;
		
	// Channel ID
	// Leave this as zero if you are a Marketplace partner (i.e. not a supplier)
	$channel = 0;
		
	// API Private Key (log in to TourCMS to get yours)
	$api_private_key = "API_KEY_HERE";
		
	// Result type required
	// 'raw' or 'simplexml', if not supplied defaults to 'raw'
	$result_type = 'simplexml';
	
	// Set the response URL, only required if being used by a Tour Operator
	// Point this to ".....step2.php?tour_id={tour_id}"
	// Explanation here: http://www.tourcms.com/support/api/mp/booking_getkey.php
	$response_url = "http://www.example.com/very-basic-booking-engine/step2.php?tour={tour_id}";
	
	// Create a new Instance of the TourCMS API class
	$tourcms = new TourCMS($marketplace_account_id, $api_private_key, $result_type);
?>