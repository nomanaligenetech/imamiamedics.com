<?php 
$attributes 			= array("method"		=> "post");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    
	<table class="table table_form">
		<tr>
			<td class="td_bg fieldKey">Campaign Name <?php echo required_field(); ?></td>
			<td class="td_bg fieldValue">
			<div class="input-group">
				<?php
                echo form_dropdown("camp_id", DropdownHelper::donation_campaigns_dropdown(), set_value("camp_id", $camp_id), "class='form-control'" );
                ?>
            </div>
            </td>
		</tr>

		<tr>
			<td class="td_bg fieldKey">Donor Name <?php echo required_field(); ?></td>
			<td class="td_bg">
				<div class="input-group">
				<?php
				$first_name_data		= array("name"			=> "first_name",
												"id"			=> "first_name",
												"size"			=> 50,
												"class"			=> "form-control",
												"value"			=>  set_value("first_name", $first_name));

				echo form_input($first_name_data);
				?>
				</div>
			</td>
		</tr>
		
		<tr>
			<td class="td_bg fieldKey">Mode of Payment <?php echo required_field(); ?></td>
			<td class="td_bg fieldValue">
			<div class="input-group">
				<?php
                echo form_dropdown("mode", DropdownHelper::modeofpayment_dropdown(), set_value("mode", $mode), "class='form-control'" );
                ?>
            </div>
            </td>
		</tr>

		<tr>
			<td class="td_bg fieldKey">Amount <?php echo required_field(); ?></td>
			<td class="td_bg fieldValue" colspan="2">
			<div class="input-group">
			<?php
			$donate_amount_data = array("name"		=> "donate_amount",
									"id"		=> "donate_amount",
									"size"		=> 50,
									"class"		=> "form-control",
									"type"		=> "number",
									"min"		=> 1,
									"value"		=> set_value("donate_amount", $donate_amount) );	
			
			echo form_input($donate_amount_data);
			?>
			</div>
			</td>
		</tr>

		<tr>
			<td class="td_bg fieldKey">Donate Date <?php echo required_field(); ?></td>
			<td class="td_bg fieldValue" colspan="2">
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-clock-o"></i>
					</div>						
					<?php
					$date_added_data       = array(	"name"      => "date_added",
													"id"        => "date_added",
													"size"      => 45,
													"class"     => "form-control datetimepicker1",
													"value"     => set_value("date_added", $date_added));  
					
					echo form_input($date_added_data);
					?>
				</div>
			</div>
			</td>
		</tr>

		<tr>
			<td class="td_bg fieldKey">Country <?php echo required_field(); ?></td>
			<td class="td_bg fieldValue">
			<div class="input-group">
				<?php
                echo form_dropdown("home_country", DropdownHelper::country_dropdown(), set_value("home_country", $home_country), "class='form-control'" );
                ?>
            </div>
            </td>
		</tr>

		<tr>
			<td class="td_bg fieldKey">Hide Identity <?php echo required_field(); ?></td>
			<td class="td_bg fieldValue">
			<div class="input-group">
				<?php
				echo form_dropdown("hide_identity", array_reverse(DropdownHelper::yesno_dropdown()), set_value("hide_identity", $hide_identity), "class='form-control'" );
                ?>
            </div>
            </td>
		</tr>
		
		<tr>
			<td class="td_bg fieldKey">Is Active <?php echo required_field(); ?></td>
			<td class="td_bg fieldValue">
			<div class="input-group">
				<?php
                echo form_dropdown("status", DropdownHelper::yesno_dropdown(), set_value("status", $status), "class='form-control'" );
                ?>
            </div>
            </td>
		</tr>

		<tr>
			<td class="td_bg">Donor Comment</td>
			<td class="td_bg">
			<div class="input-group">
			<?php
			$comment_data = array("name"			=> "comment",
									"id"			=> "comment",
									"rows"			=> 10,
									"cols"			=> 70,
									"class"			=> "form-control",
									"value"			=> set_value("comment", $comment ) );	

			echo form_textarea($comment_data);
			?>
			</div>
			</td>
		</tr>

		<tr>
			<td class="td_bg fieldKey">Show Donor Comment <?php echo required_field(); ?></td>
			<td class="td_bg fieldValue">
			<div class="input-group">
				<?php
                echo form_dropdown("comment_status", DropdownHelper::yesno_dropdown(), set_value("comment_status", $comment_status), "class='form-control'" );
                ?>
            </div>
            </td>
		</tr>
		
		<tr>
			<td class="td_bg">Other Info</td>
			<td class="td_bg">
			<div class="input-group">
			<?php
			$other_info_data = array("name"			=> "other_info",
									"id"			=> "other_info",
									"rows"			=> 10,
									"cols"			=> 70,
									"class"			=> "form-control",
									"value"			=> set_value("other_info", $other_info ) );	

			echo form_textarea($other_info_data);
			?>
			</div>
			</td>
		</tr>
            
        <tr>
			<td class="td_bg">&nbsp;</td>
			<td class="td_bg">
				<input type="hidden" value="<?php echo set_value("id", $id);?>" name="hdn_id" />
			</td>
		</tr>	
	</table>
	<input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
  	<input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />
    
    <div class="crud_controls">
        <button type="submit" data-operationid="managecampaigncustomdonorsave" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>
        <a class="btn btn-danger btn-flat" data-operationid="managecampaigncustomdonorview" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php echo lang_line("text_cancel");?>
        </a>
    </div>

</form>
<script type="text/javascript">
if($('.datetimepicker1').length > 0){
	$('.datetimepicker1').datetimepicker({
		format: 'YYYY/MM/DD HH:mm:00'
	});
}
</script>