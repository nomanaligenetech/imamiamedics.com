<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open($_directory . "controls/save", $attributes, $unique_form);
?>    

	<table class="table table_form">
		

		
        
       
		
		<tr>
				<td class="td_bg fieldKey">Caption h1 <?php echo required_field(); ?></td>
				<td class="td_bg fieldValue" colspan="2">
                <div class="input-group">

					<ul class="nav nav-tabs">
						<?php foreach ($content_languages as $lang_key => $lang): ?>
							<li class="<?php echo $lang_key < 1?'active':''; ?>"><a href="#caption_h1<?php echo $lang['code']; ?>" data-toggle="tab"><?php echo $lang['name']; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<div class="tab-content">
						<?php foreach ($content_languages as $lang_key => $lang): ?>

							<div class="tab-pane <?php echo $lang_key < 1?'active':''; ?>" id="caption_h1<?php echo $lang['code']; ?>">
								<div class="input-group">
								<?php
								$specdata		= array("name"			=> "caption_h1[{$lang['code']}]",
														"id"			=> "caption_h1[{$lang['code']}]",
														"size"			=> 50,
														"class"			=> "form-control",
														"value"			=> $lang_content[$lang['id']]['caption_h1'] );	

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
		  <td class="td_bg fieldKey">Caption h2 <?php //echo required_field(); ?></td>
		  <td class="td_bg" colspan="2">
          	<div class="input-group">
			  		<ul class="nav nav-tabs">
						<?php foreach ($content_languages as $lang_key => $lang): ?>
							<li class="<?php echo $lang_key < 1?'active':''; ?>"><a href="#caption_h2<?php echo $lang['code']; ?>" data-toggle="tab"><?php echo $lang['name']; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<div class="tab-content">
						<?php foreach ($content_languages as $lang_key => $lang): ?>

							<div class="tab-pane <?php echo $lang_key < 1?'active':''; ?>" id="caption_h2<?php echo $lang['code']; ?>">
								<div class="input-group">
								<?php
								$specdata		= array("name"			=> "caption_h2[{$lang['code']}]",
														"id"			=> "caption_h2[{$lang['code']}]",
														"size"			=> 50,
														"class"			=> "form-control",
														"value"			=> $lang_content[$lang['id']]['caption_h2'] );	

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
			<td class="td_bg">Image <?php echo required_field(); ?><br />
            <small class="badge  bg-blue">width: <?php echo $images_width;?> / height: <?php echo $images_height;?></small>
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
		  <td class="td_bg">Target</td>
		  <td colspan="2" class="td_bg">
          	<div class="input-group">
            	<?php echo form_dropdown('target', DropdownHelper::hreftarget_dropdown(), set_value("target", $target), "class='form-control '" )?>
            </div>        
          
          </td>
	  </tr>
		<tr>
		  <td class="td_bg">Type</td>
		  <td colspan="2" class="td_bg">
          	<div class="input-group">
				<?php echo form_dropdown('typeid', DropdownHelper::cmsmenutypes_dropdown(), set_value("typeid", $typeid), "class='form-control '" )?>
            </div>
          </td>
	  </tr>
      
      
      <tr>
		  <td class="td_bg">URL (content) <?php echo required_field(); ?></td>
		  <td colspan="2" class="td_bg">
          
          	<div class="input-group targetBox_cmsarea">
            	<?php
				if ( empty( $ajax_output1 ) )
				{
				?>
					<small class="badge pull-right bg-green" style="">please select type first</small>
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
				<input type="hidden" value="<?php echo set_value("id", $id);?>" name="hdn_id" />
			</td>
		</tr>
		
		
  </table>
<input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
  <input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />
    
    <div class="crud_controls">
        <button type="submit" data-operationid="managesitebannerssave" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>
        <a class="btn btn-danger btn-flat" data-operationid="managesitebannersview" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php echo lang_line("text_cancel");?>
        </a>
    </div>

</form>