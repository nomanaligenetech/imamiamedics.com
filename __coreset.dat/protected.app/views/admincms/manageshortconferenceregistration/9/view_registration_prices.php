<?php 
	
	$TMP_imi_or_nonimi = DropdownHelper::short_conferenceregistration_paymenttype();
	
	if ($row) 
	{
		$conferenceregistration_screenthree = $row;
	}
	else 
	{
		$conferenceregistration_screenthree = $conferenceregistration_screenthree->row_array();		
	}
	
	if ($conferenceregistration_screenthree["parentid"] == 0) { 

		$screen_two_details = $this->queries->fetch_records("short_conference_registration_screen_two_details", " AND parentid = '". $conferenceregistration_screenthree["screen_two_id"] ."' ");
		
		?>
		
			<table style="width:500px;">

				<tr>
					<td style="width:70%"><strong>Payment Type:</strong> </td>
					<td style="width:30%">
						
						<?php echo $conferenceregistration_screenthree["earlybird_regular"] == "earlybird_price" ? "Earlybird" : "Regular"; ?> (<?php echo $TMP_imi_or_nonimi[$conferenceregistration_screenthree["paymenttypeid"]]; ?>)
						
					</td>
				</tr>
				
				<tr>
					<td><strong>Registrations:</strong> </td>
				</tr>
				
				<?php 
					foreach($screen_two_details->result_array() as $trow) 
					{
						$price = $this->db->query("
							SELECT 
							pd.earlybird_price as earlybird_price,
							pd.regular_price as regular_price,
							wh.name as price_name,
							wh.no_of_people as no_of_people
							FROM tb_conference_prices_details pd 
							LEFT JOIN tb_conference_prices_master pm ON pd.parentid = pm.id
							LEFT JOIN tb_conference_who_attend wh ON pm.whoattendid = wh.id
							WHERE pd.id = '". $trow["price_details_id"] ."'
						")->row();
						
						echo "<tr>";
						
						if ($conferenceregistration_screenthree["earlybird_regular"] == 'earlybird_price') 
						{
							echo "<td>".wordwrap($price->price_name, 50, "<br>", true).":</td>";
							echo "<td>".$price->no_of_people." x ".$price->earlybird_price."</td>";
						} 
						else 
						{
							echo "<td>".wordwrap($price->price_name, 50, "<br>", true).":</td>";
							echo "<td>".$price->no_of_people." x ".$price->regular_price."</td>";
						}
						
						echo "</tr>";
					} 
				?>
			
				<?php if ($conferenceregistration_screenthree["coupon_code"] || $conferenceregistration_screenthree["speaker_coupon_code"]) { ?>

					<tr>
						<td><strong>Coupons:</strong> </td>
					</tr>
					
					<?php if ($conferenceregistration_screenthree["coupon_code"]) { ?>
						<tr>
							<td>IMI Coupon Code: </td>
							<td><?php echo $conferenceregistration_screenthree["coupon_code"]; ?></td>
						</tr>
					<?php } ?>
						
					<?php if ($conferenceregistration_screenthree["speaker_coupon_code"]) { ?>
						<tr>
							<td>Speaker Discount Coupon Code: </td>
							<td><?php echo $conferenceregistration_screenthree["speaker_coupon_code"]; ?></td>
						</tr>
					<?php } ?>		
					
				<?php } ?>
				
			</table>

		<?php

	} else { 
		echo '--'; 
	} 
?>