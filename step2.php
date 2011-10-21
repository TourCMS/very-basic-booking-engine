<?php
	/*
		step2.php
		
		Calls the "Show Tour" API method
		Displays passenger number and date selection form
		based on the data returned
		
	*/
	
	include_once("inc/top.php");
	
	// Include the config file
	include('inc/config.php');
	
	// We need a booking key if we are calling the API as a Tour Operator
	// Marketplace Partner accounts won't have one and don't need one
	isset($_GET['booking_key']) ? $booking_key = $_GET['booking_key'] : $booking_key = "";
	
	// Tour ID based on previous selection should be in the querystring
	isset($_GET['tour']) ? $tour = (int)$_GET['tour'] : exit();
	
	// Query the TourCMS API, get back all the info on this Tour/Hotel
	$result = $tourcms->show_tour($tour, $channel);
	
	// Jump straight to the bit of XML related to making a new booking panel
	// includes rate and date info
	$booking_criteria = $result->tour->new_booking;
?>
<h1>Numbers of people and dates</h1>
<form action="step3.php" method="post">
	
	<?php 
		$rates = array();
		
		// Process the available rates for this Tour/Hotel
		foreach ($booking_criteria->people_selection->rate as $rate) {
			$rates[] = (string)$rate->rate_id;
			// Process the labels
			// Label_1 might be blank, for 
			(string)$rate->label_1 != "" ? $label = $rate->label_1 : $label = "Number of People";
			(string)$rate->label_2 != "" ? $label .= "(" . $rate->label_2 . ")" : null;
			?>
			<label><?php print $label; ?>
				<select name="<?php print $rate->rate_id; ?>">
					<?php
						$count = (int)$rate->minimum;
						$max = (int)$rate->maximum;
						
						while($count <= $max) {
							?>
								<option><?php print $count; ?></option>
							<?php	
							$count ++;
						}
					?>
				</select>
			</label>
			<?php
		}
		
		// Set some sensible default time		
		$default_date = strtotime("+2 weeks Saturday");
	?>
	<label>Date:<input type="text" name="date" value="<?php print date("Y-m-d", $default_date); ?>" /></label>
	<?php 
		$date_type = $booking_criteria->date_selection->date_type;
		if($date_type == "DATE_NIGHTS" || $date_type == "DATE_DAYS"):
			$min_hdur = 7;
			$max_hdur = 21;
			$def_hdur = (int)$result->tour->duration;
			?>
			<select name="hdur">
				<?php 
					for($i=$min_hdur; $i<=$max_hdur; $i++):
						?>
						<option value="<?php print $i; ?>"<?php 
						$i==$def_hdur ? print ' selected="selected"' : null;
						?>><?php print $i; ?></option>
						<?php
					endfor;
				?>
			</select>
			<?
		endif;
	?>
	
	<input type="hidden" name="rates" value="<?php print implode(",", $rates); ?>" />
	<input type="hidden" name="tour" value="<?php print $tour; ?>" />
	<input type="hidden" name="booking_key" value="<?php print $booking_key; ?>" />
	
	<input type="submit" name="submit" value="Go" />
</form>


<!-- Debug -->
	<div id="debug">
		<form>
			<label><input type="radio" name="showdebug" value="none" checked /> Hide debug info</label>
			<label><input type="radio" name="showdebug" value="simplexml" /> Show SimpleXML object</label>
			<label><input type="radio" name="showdebug" value="rawxml" /> Show raw XML</label>
		</form>
		<pre class="simplexml"><?php print_r($result); ?></pre>
		<pre class="rawxml"><?php 
			// Add indentation to XML output
			$dom = new DOMDocument('1.0');
			$dom->preserveWhiteSpace = false;
			$dom->formatOutput = true;
			$dom->loadXML($result->asXML());
			echo htmlspecialchars($dom->saveXML());
		 ?></pre>
	</div>
	
<?php 
	include_once("inc/bottom.php");
 ?>