<?php 
	/*
		step2.php
		
		This page should be invisible to the user
		they will be redirected from here to TourCMS
		then subsequently on to step3.php
	*/
	
	// Include the config file
	include('inc/config.php');
	
	
	// Process the form
	// We don't actually need any of this on this step, we will just be passing it on
	// in the querystring to Step 3
	$qs = "";
	// Tour ID
	isset($_POST['tour']) ? $tour = $_POST['tour'] : exit();
	$qs .= "?tour=" . $tour;
	// Date
	isset($_POST['date']) ? $date = $_POST['date'] : $date = "";
	$qs .= "&date=" . $date;
	// Duration
	isset($_POST['hdur']) ? $hdur = $_POST['hdur'] : $hdur = "";
	$qs .= "&hdur=" . $hdur;
	// Rates & number of people
	isset($_POST['rates']) ? $rate_string = $_POST['rates'] : exit();
	$qs .= "&rates=" . $rate_string;
	$rates = explode(",", $rate_string);
	$total_people = 0;
	foreach ($rates as $rate) {
		if(isset($_POST[$rate])) {
			$rate_count = (int)$_POST[$rate];
			
			if($rate_count > 0) {
				$qs .= "&" . $rate . "=" . $rate_count;
				$total_people += $rate_count;
			}
		}
	}
	$qs .= "&total_people=" . $total_people;
	
	// If this is a Marketplace partner we can just redirect to Step 3
	if($marketplace_account_id > 0) {
		header("Location: " . $response_url . $qs);
		exit();
	}	
	
	// Otherwise we need to redirect via TourCMS

	// Create a new SimpleXMLElement to hold the response url 
	$url_data = new SimpleXMLElement('<url />'); 
	$url_data->addChild('response_url', htmlentities($response_url . $qs)); 
	
	// Send the response URL to TourCMS
	$result = $tourcms->get_booking_redirect_url($url_data, $channel_id);
	
	// TourCMS should have returned a URL back to us, get that
	$redirect_url = $result->url->redirect_url;
	
	// Redirect the customer to the URL obtained from TourCMS
	// Comment these next two lines if you want to see the data sent and returned
	header("Location: " . $redirect_url);
	exit();
		
?><pre><?php htmlentities(print($url_data->asXML())); ?></pre><pre><?php print_r($result); ?></pre><pre><?php print $redirect_url; ?></pre>