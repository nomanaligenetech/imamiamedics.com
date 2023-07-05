<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    

	<table class="table table_form">
		<tr>
			<td class="td_bg fieldKey">Donation Campaign <?php echo required_field(); ?></td>
			<td class="td_bg fieldValue">
			<div class="input-group">
				<?php
                echo form_dropdown("donation_campaigns_id", DropdownHelper::donation_campaigns_dropdown( FALSE, "", true ), set_value("donation_campaigns_id", $donation_campaigns_id), "class='form-control'" );
                ?>
            </div>
            
            
            
			</td>
		</tr>
		
      
      
	  <tr>
		  <td class="td_bg">Description <?php echo required_field(); ?></td>
		  <td class="td_bg">
          <div class="input-group">
			  
					<ul class="nav nav-tabs">
						<?php foreach ($content_languages as $lang_key => $lang): ?>
							<li class="<?php echo $lang_key < 1?'active':''; ?>"><a href="#description_<?php echo $lang['code']; ?>" data-toggle="tab"><?php echo $lang['name']; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<div class="tab-content">
						<?php foreach ($content_languages as $lang_key => $lang): ?>

							<div class="tab-pane <?php echo $lang_key < 1?'active':''; ?>" id="description_<?php echo $lang['code']; ?>">
								<div class="input-group">
								<?php
								$specdata		= array("name"			=> "description[{$lang['code']}]",
														"id"			=> "description[{$lang['code']}]",
														"rows"			=> 10,
														"cols"			=> 70,
														"class"			=> "ckeditor1 form-control",
														"maxlength"		=> "200",
														"value"			=> $lang_content[$lang['id']]['description'] );	

								echo form_textarea($specdata);
								?>
								</div>
							</div>

						<?php endforeach; ?>
						
					</div>
					<!-- /.tab-content -->
		    </div>
        </td>
	  </tr>

	  <tr>
          <td class="td_bg fieldKey"> Date <?php  required_field(); ?></td>
              <td class="td_bg fieldValue" colspan="2">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                        </div>
                        
                        <?php
                        $specdata       = array("name"      => "date",
                                                "id"        => "date",
                                                "size"      => 45,
                                                "class"     => "form-control datepicker",
                                                "value"     => set_value("date", $date));  
                        
                        echo form_input($specdata);
                        ?>
                    </div>
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
			<td class="td_bg">&nbsp;</td>
			<td class="td_bg">
				<input type="hidden" value="<?php echo set_value("id", $id);?>" name="hdn_id" />
			</td>
		</tr>
		
		
  </table>
<input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
  <input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />
    
    <div class="crud_controls">
        <button type="submit" data-operationid="managedonationcampaignssave" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>
        <a class="btn btn-danger btn-flat" data-operationid="managedonationcampaignsview" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php echo lang_line("text_cancel");?>
        </a>
    </div>

</form>
