<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    

	<table class="table table_form">
		
            
            
            
            <tr>
                <td class="td_bg">Year</td>
                <td colspan="2" class="td_bg">
                <div class="input-group">
                <?php 
				$arrayindex				= NumberHelper::number_array( range("1980", "2030") );
				$arrayindex[""]			= "Select";
				ksort( $arrayindex );
				echo form_dropdown('year', DropdownHelper::runtime_dropdown( $arrayindex ), set_value("year", $year), "class='form-control '" )
				?>
                </div>
                </td>
            </tr>
            

		
        	<tr>
				<td class="td_bg fieldKey">Title <?php echo required_field(); ?></td>
				<td class="td_bg fieldValue" colspan="2">
                <div class="input-group">

					<ul class="nav nav-tabs">
						<?php foreach ($content_languages as $lang_key => $lang): ?>
							<li class="<?php echo $lang_key < 1?'active':''; ?>"><a href="#title_<?php echo $lang['code']; ?>" data-toggle="tab"><?php echo $lang['name']; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<div class="tab-content">
						<?php foreach ($content_languages as $lang_key => $lang): ?>

							<div class="tab-pane <?php echo $lang_key < 1?'active':''; ?>" id="title_<?php echo $lang['code']; ?>">
								<div class="input-group">
								<?php
								$specdata		= array("name"			=> "title[{$lang['code']}]",
														"id"			=> "title[{$lang['code']}]",
														"size"			=> 50,
														"class"			=> "form-control",
														"value"			=> $lang_content[$lang['id']]['title'] );	

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
				<td class="td_bg fieldKey">Short Description <?php echo required_field(); ?></td>
				<td class="td_bg fieldValue" colspan="2">
                <div class="input-group">

					<ul class="nav nav-tabs">
						<?php foreach ($content_languages as $lang_key => $lang): ?>
							<li class="<?php echo $lang_key < 1?'active':''; ?>"><a href="#short_desc_<?php echo $lang['code']; ?>" data-toggle="tab"><?php echo $lang['name']; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<div class="tab-content">
						<?php foreach ($content_languages as $lang_key => $lang): ?>

							<div class="tab-pane <?php echo $lang_key < 1?'active':''; ?>" id="short_desc_<?php echo $lang['code']; ?>">
								<div class="input-group">
								<?php
								$specdata		= array("name"			=> "short_desc[{$lang['code']}]",
														"id"			=> "short_desc[{$lang['code']}]",
														"rows"			=> 10,
														"cols"			=> 70,
														"class"			=> " form-control",
														"value"			=> $lang_content[$lang['id']]['short_desc'] );	

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
				<td class="td_bg fieldKey">Full Description <?php echo required_field(); ?></td>
				<td class="td_bg fieldValue" colspan="2">
                <div class="input-group">
					
					<ul class="nav nav-tabs">
						<?php foreach ($content_languages as $lang_key => $lang): ?>
							<li class="<?php echo $lang_key < 1?'active':''; ?>"><a href="#full_desc_<?php echo $lang['code']; ?>" data-toggle="tab"><?php echo $lang['name']; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<div class="tab-content">
						<?php foreach ($content_languages as $lang_key => $lang): ?>

							<div class="tab-pane <?php echo $lang_key < 1?'active':''; ?>" id="full_desc_<?php echo $lang['code']; ?>">
								<div class="input-group">
								<?php
								$specdata		= array("name"			=> "full_desc[{$lang['code']}]",
														"id"			=> "full_desc[{$lang['code']}]",
														"rows"			=> 10,
														"cols"			=> 70,
														"class"			=> "ckeditor1 form-control",
														"value"			=> $lang_content[$lang['id']]['full_desc'] );	

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
                <td class="td_bg">Image <?php echo required_field(); ?><br />
                <!--<small class="badge  bg-blue">width: <?php #echo $images_width;?> / height: <?php #echo $images_height;?></small>-->
                </td>
                <td class="td_bg" colspan="2">
                    <div class="input-group">
                    <input type="file" class="btn btn-default" name="file_photo_image"/>
                    <input type="hidden" value="<?php echo set_value("photo_image", $photo_image);?>" name="photo_image" />  
                    <small><?php echo image_link("photo_image", $photo_image);?></small>
                    </div>
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
			<td class="td_bg">&nbsp;</td>
			<td colspan="2" class="td_bg">
			</td>
		</tr>
		<tr>
		  <td colspan="3" class="td_bg">
          <table class="table table-striped table-bordered">
                	<tr>
                        <td><strong>
                        Inner Page Widgets Information
                        </strong></td>
                    </tr>
                    
                    <tr>
                        <td>
                        	<?php echo $this->load->view( "admincms/managecmscontent/_table_widget.php" ) ;?>
                        </td>
                    </tr>
                </table>
          </td>
	  </tr>
		
		
  </table>
<input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
  <input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />
    
    <div class="crud_controls">
        <button type="submit" data-operationid="managetimelinehistorysave" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>
        <a class="btn btn-danger btn-flat" data-operationid="managetimelinehistoryview" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php echo lang_line("text_cancel");?>
        </a>
    </div>

</form>