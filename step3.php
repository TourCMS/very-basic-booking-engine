<?php
	include('../post/tourcms-php/tourcms.php');

	include('config.php');
	
	//$qs = "id=" . $tour;
	$qs = "";
	
	if($marketplace_account_id == 0)
		isset($_POST['booking_key']) ? $booking_key = $_POST['booking_key'] : exit();
	
	isset($_POST['date']) ? $date = $_POST['date'] : exit();
	
	$qs .= "date=" . $date;
	
	isset($_POST['hdur']) ? $hdur = $_POST['hdur'] :  $hdur = null;
	
	isset($hdur) ? $qs .= "&hdur=" . $hdur : null;
	
	isset($_POST['rates']) ? $rate_string = $_POST['rates'] : exit();
	
	isset($_POST['tour']) ? $tour = (int)$_POST['tour'] : exit();
	
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
	
	$result = $tourcms->check_tour_availability($qs, $tour, $channel);
	
	
	isset($result->available_components->component) ? $num_components = count($result->available_components->component) : $num_components = 0;
	
?>
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
<fieldset>
<table>
<?php
	
	if($num_components > 0) {
		foreach ($result->available_components->component as $component) {
			?>
			<tr>
				<td><input type="radio" name="component_key" value="<?php print $component->component_key; ?>" /></td>
				<td><?php print $component->date_code; ?></td>
				<td><?php print $component->start_date; ?></td>
				<td><?php print ($component->end_date != $component->start_date ? $component->end_date : null ); ?></td>
				<td><?php print $component->note . $component->special_offer_note; ?></td>
				<td><?php print $component->total_price_display; ?></td>
			</tr>
			<?php
		}
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
				<input type="email" name="email" value="ps@tourcms.com" />
				</label>
				<?php endif; ?>
			</fieldset>
		<?php
	}
?>
<input type="submit" name="submit" value="Go" />
</form>
<pre><?php print_r($result); ?></pre>