<?php
	include('../post/tourcms-php/tourcms.php');

	include('config.php');
	
	isset($_GET['booking_key']) ? $booking_key = $_GET['booking_key'] : $booking_key = "";
	
	isset($_GET['tour']) ? $tour = (int)$_GET['tour'] : exit();
	
	$result = $tourcms->show_tour($tour, $channel);
	
	$booking_criteria = $result->tour->new_booking;

	
?>
<form action="step3.php" method="post">
	
	<?php 
		
		$rates = array();
		// Process the available rates for this Tour/Hotel (found via "Show Tour")
		foreach ($booking_criteria->people_selection->rate as $rate) {
			$rates[] = (string)$rate->rate_id;
			// Process the labels
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


<pre><?php print_r($result); ?></pre>