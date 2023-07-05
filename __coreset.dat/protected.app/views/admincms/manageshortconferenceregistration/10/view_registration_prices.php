<?php
$DD_EB_RG								= DropdownHelper::conferenceprice_earlybird_regular_dropdown(TRUE, FALSE );

if ($fetch_records_for_view_ROW["parentid"] == 0) 
{
	$screen_two_details 		= $this->queries->fetch_records("conference_registration_screen_two_details", " AND parentid = '". $fetch_records_for_view_ROW["screen_two_id"] ."' ");
?>
 <small>
    <table width="300px" border="0" class="table">
        <tr>
            <td width="200px;"><strong>Participant Type:</strong></td>
            <td width="100px;"><?php echo $fetch_records_for_view_ROW["VIEW_region_name"];?></td>
        </tr>
        
        <tr>
            <td><strong>Registration Type:</strong></td>
            <td><?php echo $DD_EB_RG[ $fetch_records_for_view_ROW["earlybird_regular"] ];?></td>
        </tr>
        
        <tr>
            <td><strong>Travelling With:</strong></td>
            <td><?php echo $fetch_records_for_view_ROW['VIEW_package_name'] ;?></td>
        </tr>
        
        <tr>
            <td><strong>Total Price:</strong></td>
            <td><?php echo format_price( $fetch_records_for_view_ROW["price_total_payable"], array("prefix" => $this->functions->getCurrencySymbol($fetch_records_for_view_ROW['region_show_rates_in_currency'] )) ) ;?></td>
        </tr>
       
    </table>
    
    <hr style="visibility:none;" />
   
    <table width="300px"  class="table table-striped ">
        <tr>
            <td colspan="2" ><strong>Package Details</strong></td>
        </tr>
        <?php
		foreach ($screen_two_details->result_array() as $std)
		{
			$conference_prices_details 		= $this->queries->fetch_records("conference_prices_details", " AND id = '". $std["price_details_id"] ."' ");
            
            if ( $conference_prices_details->num_rows() > 0 )
			{
				$explode_price_details_value		= explode("::", $std["price_details_value"]);
			?>
				<tr>
					<td width="200px;">
                        
                        <em style="text-decoration:underline;"><?php echo $conference_prices_details->row()->whoattend_nam;?>
                        <?php
						if ( $conference_prices_details->row()->prices_parent_id > 0 )
						{
							?>
                            <strong>- (Add-on)</strong>
                            <?php	
						}
						?>
                        </em>
                        <br />
                        <?php echo $conference_prices_details->row()->prices_title;?>
                        <br  />
                        <?php echo $conference_prices_details->row()->prices_description;?>
                        
                    </td>
					<td width="100px;">
					<?php echo $std["multply_by_no_of_people"] ;?> 
                    x 
					<?php echo format_price( $explode_price_details_value[1], array("prefix" => $this->functions->getCurrencySymbol($fetch_records_for_view_ROW['region_show_rates_in_currency'] )) );?>
                    </td>
				</tr>
			<?php
			}
		}
		?>
        


       
    </table>
    </small>
<?php
}
else
{
	?>
    <small>
    <table width="300px" border="0" class="table">
        <tr>
            <td width="200px;"><strong>Participant Type:</strong></td>
            <td width="100px;"><?php echo $fetch_records_for_view_ROW["VIEW_region_name"];?></td>
        </tr>
        
        
       
    </table>
    </small>
    <?php	
}
?>
