<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    

	<table class="table table_form">
		

		
        
       
		
		<tr>
		  <td class="td_bg">First Column Text</td>
		  <td class="td_bg">
          <div class="input-group">

					<ul class="nav nav-tabs">
						<?php foreach ($content_languages as $lang_key => $lang): ?>
							<li class="<?php echo $lang_key < 1?'active':''; ?>"><a href="#column_first_text_<?php echo $lang['code']; ?>" data-toggle="tab"><?php echo $lang['name']; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<div class="tab-content">
						<?php foreach ($content_languages as $lang_key => $lang): ?>

							<div class="tab-pane <?php echo $lang_key < 1?'active':''; ?>" id="column_first_text_<?php echo $lang['code']; ?>">
								<div class="input-group">
								<?php
								$specdata		= array("name"			=> "column_first_text[{$lang['code']}]",
														"id"			=> "column_first_text[{$lang['code']}]",
														"rows"			=> 10,
														"cols"			=> 70,
														"class"			=> "ckeditor1 form-control",
														"maxlength"		=> "200",
														"value"			=> $lang_content[$lang['id']]['column_first_text'] );	

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
		  <td class="td_bg">Second Column Text</td>
		  <td class="td_bg">
          <div class="input-group">

					<ul class="nav nav-tabs">
						<?php foreach ($content_languages as $lang_key => $lang): ?>
							<li class="<?php echo $lang_key < 1?'active':''; ?>"><a href="#column_two_text_<?php echo $lang['code']; ?>" data-toggle="tab"><?php echo $lang['name']; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<div class="tab-content">
						<?php foreach ($content_languages as $lang_key => $lang): ?>

							<div class="tab-pane <?php echo $lang_key < 1?'active':''; ?>" id="column_two_text_<?php echo $lang['code']; ?>">
								<div class="input-group">
								<?php
								$specdata		= array("name"			=> "column_two_text[{$lang['code']}]",
														"id"			=> "column_two_text[{$lang['code']}]",
														"rows"			=> 10,
														"cols"			=> 70,
														"class"			=> "ckeditor1 form-control",
														"maxlength"		=> "200",
														"value"			=> $lang_content[$lang['id']]['column_two_text'] );	

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
		  <td class="td_bg"> Third Column Text</td>
		  <td class="td_bg">
          <div class="input-group">
			  
					<ul class="nav nav-tabs">
						<?php foreach ($content_languages as $lang_key => $lang): ?>
							<li class="<?php echo $lang_key < 1?'active':''; ?>"><a href="#column_three_text_<?php echo $lang['code']; ?>" data-toggle="tab"><?php echo $lang['name']; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<div class="tab-content">
						<?php foreach ($content_languages as $lang_key => $lang): ?>

							<div class="tab-pane <?php echo $lang_key < 1?'active':''; ?>" id="column_three_text_<?php echo $lang['code']; ?>">
								<div class="input-group">
								<?php
								$specdata		= array("name"			=> "column_three_text[{$lang['code']}]",
														"id"			=> "column_three_text[{$lang['code']}]",
														"rows"			=> 10,
														"cols"			=> 70,
														"class"			=> "ckeditor1 form-control",
														"maxlength"		=> "200",
														"value"			=> $lang_content[$lang['id']]['column_three_text'] );	

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
		  <td class="td_bg">Address</td>
		  <td class="td_bg">
           <div class="input-group">
			  
					<ul class="nav nav-tabs">
						<?php foreach ($content_languages as $lang_key => $lang): ?>
							<li class="<?php echo $lang_key < 1?'active':''; ?>"><a href="#donation_way_to_give_address_<?php echo $lang['code']; ?>" data-toggle="tab"><?php echo $lang['name']; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<div class="tab-content">
						<?php foreach ($content_languages as $lang_key => $lang): ?>

							<div class="tab-pane <?php echo $lang_key < 1?'active':''; ?>" id="donation_way_to_give_address_<?php echo $lang['code']; ?>">
								<div class="input-group">
								<?php
								$specdata		= array("name"			=> "donation_way_to_give_address[{$lang['code']}]",
														"id"			=> "donation_way_to_give_address[{$lang['code']}]",
														"rows"			=> 10,
														"cols"			=> 70,
														"class"			=> "ckeditor1 form-control",
														"maxlength"		=> "200",
														"value"			=> $lang_content[$lang['id']]['donation_way_to_give_address'] );	

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
		  <td class="td_bg">Belongs to <?php echo required_field(); ?></td>
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
    
    
     <!--  
		<tr>
		  <td class="td_bg">Status</td>
		  <td colspan="2" class="td_bg"><div class="input-group">
		  <?php echo form_dropdown('status', DropdownHelper::yesno_dropdown(), set_value("status", $status), "class='form-control '" )?></div>
          </td>
	  </tr> -->
		
		
		
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
        <button type="submit" data-operationid="managedonationgiveonwillsave" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>
        <a class="btn btn-danger btn-flat" data-operationid="managedonationgiveonwillview" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php echo lang_line("text_cancel");?>
        </a>
    </div>

</form>