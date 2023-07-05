<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    

	<table class="table table_form">
		

		<tr>
				<td class="td_bg fieldKey">Parent Project </td>
				<td class="td_bg fieldValue">
				<div class="input-group">
					<?php
					echo form_dropdown("parentid", DropdownHelper::donation_projects_dropdown( FALSE, "" ), set_value("parentid", $parentid), "class='form-control'" );
					?>
				</div>
				
				
				
				</td>
			</tr>
			
		<tr>
        
       
		
		<tr>
				<td class="td_bg fieldKey">Name <?php echo required_field(); ?></td>
				<td class="td_bg fieldValue" colspan="2">
                <div class="input-group">
					<ul class="nav nav-tabs">
						<?php foreach ($content_languages as $lang_key => $lang): ?>
							<li class="<?php echo $lang_key < 1?'active':''; ?>"><a href="#name_<?php echo $lang['code']; ?>" data-toggle="tab"><?php echo $lang['name']; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<div class="tab-content">
						<?php foreach ($content_languages as $lang_key => $lang): ?>

							<div class="tab-pane <?php echo $lang_key < 1?'active':''; ?>" id="name_<?php echo $lang['code']; ?>">
								<div class="input-group">
								<?php
								$specdata		= array("name"			=> "name[{$lang['code']}]",
														"id"			=> "name[{$lang['code']}]",
														"size"			=> 50,
														"class"			=> " form-control",
														"value"			=> $lang_content[$lang['id']]['name'] );	

								echo form_input($specdata);
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
			<td class="td_bg">Type</td>
		  <td colspan="2" class="td_bg"><div class="input-group">
		  <?php echo form_dropdown('type', DropdownHelper::projects_type_dropdown(), set_value("type", $type), "class='form-control '" )?></div>
          </td>
		
		</tr>
      
     
      
      
		<tr>
		  <td class="td_bg">Status</td>
		  <td colspan="2" class="td_bg"><div class="input-group">
		  <?php echo form_dropdown('status', DropdownHelper::yesno_dropdown(), set_value("status", $status), "class='form-control '" )?></div>
          </td>
	  </tr>

	  <tr>
		  <td class="td_bg">International/Canada <?php echo required_field(); ?></td>
		  <td colspan="2" class="td_bg">
          
          	<div class="input-group">
				<?php 
				
				$get_role_id 					= $this->functions->_admincms_logged_in_details( "roleid" ); 
				
				$get_belongsto 					= $this->functions->_admincms_logged_in_details( "belongs_country" );
				

				 /****  Admin and Super Admins IDs 
				 * 	Admin 					= 1
				 * 	Super Admin 			= 4
				 ******/
				
				if($get_role_id == 1 || $get_role_id == 4){ // check if admin or super admin
					$Temp_value = DropdownHelper::cmsmenubelongsto_dropdown();
				}else{

					$explode = explode(',',$get_belongsto);
					foreach ($explode as $key => $value) {
						$Temp_value[$value] = DropdownHelper::cmsmenubelongsto_dropdown(false,$value);
					}

			
				}
				

				echo form_dropdown('belongsto', $Temp_value, set_value("belongsto", $belongsto), "class='form-control '" )?>
            </div>
            
            </td>
	  </tr>

	  <tr>
		  <td class="td_bg">Is A Campaign ?</td>
		  <td colspan="2" class="td_bg"><div class="input-group">
		  <?php echo form_dropdown('campaign', array_reverse(DropdownHelper::yesno_dropdown()), set_value("campaign", $campaign), "class='form-control '" )?></div>
          </td>
	  </tr>

	  <tr>
		  <td class="td_bg">Is An Event ?</td>
		  <td colspan="2" class="td_bg"><div class="input-group">
		  <?php echo form_dropdown('is_event', array_reverse(DropdownHelper::yesno_dropdown()), set_value("is_event", $is_event), "class='form-control '" )?></div>
          </td>
	  </tr>

	  <tr>
		  <td class="td_bg">Show on Front ?</td>
		  <td colspan="2" class="td_bg"><div class="input-group">
		  <?php echo form_dropdown('show_front', DropdownHelper::yesno_dropdown(), set_value("show_front", $show_front), "class='form-control '" )?></div>
          </td>
	  </tr>
		
		
		
		<tr>
			<td class="td_bg">&nbsp;</td>
			<td colspan="2" class="td_bg">
				<input type="hidden" value="<?php echo set_value("id", $id);?>" name="hdn_id" />
			</td>
		</tr>
		
		
  </table>
<input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
  <input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />
    
    <div class="crud_controls">
        <button type="submit" data-operationid="managedonationprojectssave" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>
        <a class="btn btn-danger btn-flat" data-operationid="managedonationprojectsview" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php echo lang_line("text_cancel");?>
        </a>
    </div>

</form>