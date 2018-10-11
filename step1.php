<?php
	/*
		step1.php

		Calls the "Show Tour" API method
		Displays passenger number and date selection form
		based on the data returned

	*/
	$title = "Numbers of people and dates";
	include_once("inc/top.php");

	// Include the config file
	include('inc/config.php');

	// Tour ID based on previous selection should be in the querystring
	isset($_GET['tour']) ? $tour = (int)$_GET['tour'] : exit();

	// Channel ID based on previous selection should be in the querystring
	isset($_GET['channel']) ? $channel = (int)$_GET['channel'] : exit();

	// Query the TourCMS API, get back all the info on this Tour/Hotel
	$result = $tourcms->show_tour($tour, $channel);

	// Jump straight to the bit of XML related to making a new booking panel
	// includes rate and date info
	$booking_criteria = $result->tour->new_booking;
?>
<h1><?php print $title; ?></h1>
<p>Below you should be able to select the number of people for each rate that is loaded against this Tour/Hotel (Adults, Children, Premium etc) plus a start date entry. In the case of hotel products there will also be a box for the duration.</p>
<form action="step2.php" method="post">

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
			$min_hdur = $booking_criteria->date_selection->duration_minimum;
			$max_hdur = $booking_criteria->date_selection->duration_maximum;
			$def_hdur = (int)$result->tour->duration;

			if($min_hdur == $max_hdur):
			?>
				<input type="text" name="hdur" value="3" readonly="true" />
			<?
			else :
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
			<?php
			endif;

		endif;
	?>

	<input type="hidden" name="rates" value="<?php print implode(",", $rates); ?>" />
	<input type="hidden" name="tour" value="<?php print $tour; ?>" />
	<input type="hidden" name="channel" value="<?php print $channel; ?>" />
	<input type="submit" name="submit" value="Go" />
</form>

<?php
	include_once("inc/debug.php");
	include_once("inc/bottom.php");
 ?>
