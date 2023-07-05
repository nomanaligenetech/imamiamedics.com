<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    

	<table class="table table_form">
		<tr>
			<td class="td_bg fieldKey">Menu <?php echo required_field(); ?></td>
			<td class="td_bg fieldValue">
			<div class="input-group">
				<?php
                echo form_dropdown("menuid", DropdownHelper::menu_dropdown( FALSE, TRUE ), set_value("menuid", $menuid), "class='form-control' size='10'" );
                ?>
            </div>
            
            
            
			</td>
		</tr>
		<tr style="display:none;">
		  <td class="td_bg">Include Title</td>
		  <td class="td_bg">
          <table>
          	<tr>
            	<td>
				<?php echo form_checkbox("include_title", $include_title, set_checkbox("include_title", $include_title) );?>
                </td>
                <td>
                <div class="input-group">
                <?php
                $specdata		= array("name"			=> "custom_title",
                                        "id"			=> "custom_title",
                                        "size"			=> 50,
                                        "class"			=> "form-control",
                                        "value"			=> set_value("custom_title", $custom_title ) );	
                
                echo form_input($specdata);
                ?>
                </div>
                </td>
            </tr>
          </table>
          
          </td>
          
          
          
          
          <tr>
              <td class="td_bg" colspan="2">
              
              		<?php echo $this->load->view( "admincms/managecmscontent/_table_widget.php" ) ;?>
              	
              </td>
          </tr>
          
          
          
          
      
      
      
      
      
      
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
		  <td class="td_bg">Short Description</td>
		  <td class="td_bg">

			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<?php foreach ($content_languages as $lang_key => $lang): ?>
						<li class="<?php echo $lang_key < 1?'active':''; ?>"><a href="#lang_<?php echo $lang['code']; ?>" data-toggle="tab"><?php echo $lang['name']; ?></a></li>
					<?php endforeach; ?>
				</ul>
				<div class="tab-content">
					<?php foreach ($content_languages as $lang_key => $lang): ?>

						<div class="tab-pane <?php echo $lang_key < 1?'active':''; ?>" id="lang_<?php echo $lang['code']; ?>">
							<div class="input-group">
							<?php
							$specdata		= array("name"			=> "short_desc[{$lang['code']}]",
													"id"			=> "short_desc[{$lang['code']}]",
													"rows"			=> 10,
													"cols"			=> 70,
													"class"			=> "ckeditor1 form-control",
													"value"			=> $lang_content[$lang['id']]['short_desc'] );	

							echo form_textarea($specdata);
							?>
							</div>
						</div>

					<?php endforeach; ?>
					
				</div>
				<!-- /.tab-content -->
			</div>
			<!-- nav-tabs-custom -->

        </td>
	  </tr>
      
      
      
		<tr>
		  <td class="td_bg">Content <?php echo required_field(); ?></td>
		  <td class="td_bg">
          
          	<div class="input-group targetBox_cmsarea">
            	<?php
				if ( empty( $ajax_output1 ) )
				{
				?>
					<small class="badge pull-right bg-green" style="">please select menu first</small>
                <?php
				}
				else
				{
					echo $ajax_output1;	
				}
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
        <button type="submit" data-operationid="managecmscontentsave" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>
        <a class="btn btn-danger btn-flat" data-operationid="managecmscontentview" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php echo lang_line("text_cancel");?>
        </a>
    </div>

</form>