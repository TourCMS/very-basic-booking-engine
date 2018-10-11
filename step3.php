<?php
	/*
		step3.php


		Calls "Check Availability" to see actual live availability
		If there's a choice then that's displayed to the customer
		Boxes for customer details displayed

	*/
	$title = "Availability confirmed, enter passenger details";
	include_once("inc/top.php");

	// Include the config file
	include('inc/config.php');


	$qs = "";

	if($marketplace_account_id == 0)
	isset($_GET['booking_key']) ? $booking_key = $_GET['booking_key'] : exit();

	isset($_GET['date']) ? $date = $_GET['date'] : exit();


	$qs .= "date=" . $date;

	isset($_GET['hdur']) ? $hdur = $_GET['hdur'] :  $hdur = null;

	isset($hdur) ? $qs .= "&hdur=" . $hdur : null;

	isset($_GET['rates']) ? $rate_string = $_GET['rates'] : exit();

	isset($_GET['tour']) ? $tour = (int)$_GET['tour'] : exit();

	isset($_GET['channel']) ? $channel = (int)$_GET['channel'] : exit();

	$rates = explode(",", $rate_string);

	$total_people = 0;

	foreach ($rates as $rate) {
		if(isset($_GET[$rate])) {
			$rate_count = (int)$_GET[$rate];

			if($rate_count > 0) {
				$qs .= "&" . $rate . "=" . $rate_count;
				$total_people += $rate_count;
			}
		}
	}

	$result = $tourcms->check_tour_availability($qs, $tour, $channel);


	isset($result->available_components->component) ? $num_components = count($result->available_components->component) : $num_components = 0;

?>
<h1><?php print $title; ?></h1>
<?php
if($num_components>0) : ?>
<p>We have checked availability based on the rate and date selection, the available components should be displayed below alongside boxes for customer detail entry.</p>
<form method="post" action="step4.php" />
<?php
if($marketplace_account_id == 0) :
?>
<input type="hidden" name="booking_key" value="<?php print $booking_key; ?>" />
<?php
endif;
?>
<input type="hidden" name="total_people" value="<?php print $total_people; ?>" />
<input type="hidden" name="tour" value="<?php print $tour; ?>" />
<input type="hidden" name="channel" value="<?php print $channel; ?>" />
<fieldset>
<table>
<?php
	$counter = 1;

		foreach ($result->available_components->component as $component) {
			?>
			<tr>
				<td><input type="radio" name="component_key" value="<?php print $component->component_key; ?>"<?php
					($counter==1) ? print "checked" : null;
				 ?> /></td>
				<td><?php ($hdur>0) ? null : print $component->date_code ; ?></td>
				<td><?php print prettify_date($component->start_date); ?></td>
				<td><?php print ((string)$component->end_date <> (string)$component->start_date ? " to " . prettify_date($component->end_date) : null ); ?></td>
				<td><?php
					// For hotel type products, lets show the room type
					if ($hdur > 0):
							foreach ($component->price_breakdown->price_row as $price_row) {
								print "<strong>" . $price_row . "</strong> ";
							}
							print "(" . $component->note . ")";
					else:
						print $component->note;
					endif;
				?></td>
				<td><?php print $component->total_price_display; ?></td>
			</tr>
			<?php
			$counter ++;
		}

?>
</table>
</fieldset>
<?php
	for($i = 0; $i < $total_people; $i++) {
		?>
			<fieldset class="person">
				<label>Name
				<select name="title[]">
					<option>Mr</option>
					<option>Mrs</option>
					<option>Miss</option>
					<option>Sir</option>
					<option>Rev</option>
				</select>
				<input type="text" name="firstname[]" value="Joe" />
				<input type="text" name="surname[]" value="Bloggs" /></label>
				<?php if($i==0): ?>
				<label>Email
				<input type="email" name="email" value="test@example.com" />
				</label>
				<?php endif; ?>
			</fieldset>
		<?php
	}
?>
<input type="submit" name="submit" value="Go" />
</form>
<?php
else:
	print "Sorry no availability, please go back and try a different date / number of passengers";
endif; ?>

<?php
	include_once("inc/debug.php");
	include_once("inc/bottom.php");
 ?>
