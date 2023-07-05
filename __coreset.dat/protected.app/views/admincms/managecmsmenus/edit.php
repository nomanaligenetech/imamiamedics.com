<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    

	<table class="table table_form">
    
    	<tr>
              <td class="td_bg">Position <?php echo required_field();?></td>
              <td colspan="2" class="td_bg">
              
                <div class="input-group">
                    <?php echo form_dropdown('positionid', DropdownHelper::cmsmenupositions_dropdown( set_value("positionid", $positionid) ), 
											set_value("positionid", $positionid), 
											"class='form-control '" )?>
                </div>
                
                </td>
          </tr>
      
      
      
		<tr>
			<td class="td_bg fieldKey">Parent Menu</td>
			<td colspan="2" class="td_bg fieldValue">
            
            
            <div class="input-group targetBox_cmsarea">
            	<?php
				if ( empty( $ajax_output1 ) )
				{
				?>
					<small class="badge pull-right bg-green" style="">please select position first</small>
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
		  <td class="td_bg">Name <?php echo required_field(); ?></td>
		  <td class="td_bg">
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
													"class"			=> "form-control",
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
		  <td class="td_bg">
            <div class="badge bg-green">
                <?php echo form_checkbox(	"show_title", 1, set_checkbox("show_title", 1, format_bool( $show_title, 1 ) ) );?>
                Show Title
            </div>
          </td>
      </tr>
      
      
      <tr>
		  <td class="td_bg">Sub-heading </td>
		  <td colspan="2" class="td_bg">
          <div class="input-group">

				<ul class="nav nav-tabs">
					<?php foreach ($content_languages as $lang_key => $lang): ?>
						<li class="<?php echo $lang_key < 1?'active':''; ?>"><a href="#subheading_<?php echo $lang['code']; ?>" data-toggle="tab"><?php echo $lang['name']; ?></a></li>
					<?php endforeach; ?>
				</ul>
				<div class="tab-content">
					<?php foreach ($content_languages as $lang_key => $lang): ?>

						<div class="tab-pane <?php echo $lang_key < 1?'active':''; ?>" id="subheading_<?php echo $lang['code']; ?>">
							<div class="input-group">
							<?php
							$specdata		= array("name"			=> "subheading[{$lang['code']}]",
													"id"			=> "subheading[{$lang['code']}]",
													"size"			=> 50,
													"class"			=> "form-control",
													"value"			=> $lang_content[$lang['id']]['subheading'] );	

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
      
      
		<tr style="display:none;">
		  <td class="td_bg">Slug <?php echo required_field(); ?><br />
          <small class="label label-danger">only allow alpha and dash (a-z,-)</small>
          </td>
		  <td colspan="2" class="td_bg">
          	<div class="input-group">
		    <?php
			$specdata		= array("name"			=> "slug",
									"id"			=> "slug",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("slug", $slug ) );	

			echo form_input($specdata);
			?>
		    </div>
          </td>
	  </tr>
		
		<tr>
		  <td class="td_bg">Image </td>
		  <td colspan="2" class="td_bg">
          	<div class="input-group">
            <input type="file" class="btn btn-default" name="file_photo_image"/>
            <input type="hidden" value="<?php echo set_value("photo_image", $photo_image);?>" name="photo_image" />  
            <small><?php echo image_link("photo_image", $photo_image);?></small>
            </div>
          </td>
	  </tr>
      
      
      <tr>
		  <td class="td_bg">Icon </td>
		  <td class="td_bg">
          	<div class="input-group">
                <input type="file" class="btn btn-default" name="file_photo_image_icon"/>
                <input type="hidden" value="<?php echo set_value("photo_image_icon", $photo_image_icon);?>" name="photo_image_icon" />  
                <small><?php echo image_link("photo_image_icon", $photo_image_icon);?></small>
            </div>
          </td>
		  <td class="td_bg">
            <div class="badge bg-green">
				<?php echo form_checkbox(	"show_icon_with_title", 1, set_checkbox("show_icon_with_title", 1, format_bool( $show_icon_with_title, 1 ) ) );?>
                Show Icon With Title
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
		  <td class="td_bg">Target <?php echo required_field(); ?></td>
		  <td colspan="2" class="td_bg">
            <div class="input-group">
            	<?php echo form_dropdown('target', DropdownHelper::hreftarget_dropdown(), set_value("target", $target), "class='form-control '" )?>
            </div>            
            </td>
	  </tr>
		<tr>
		  <td class="td_bg">Type <?php echo required_field(); ?></td>
		  <td colspan="2" class="td_bg">
          
          	<div class="input-group">
				<?php echo form_dropdown('typeid', DropdownHelper::cmsmenutypes_dropdown(), set_value("typeid", $typeid), "class='form-control '" )?>
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
        <button type="submit" data-operationid="managecmsmenussave" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>
        <a class="btn btn-danger btn-flat" data-operationid="managecmsmenusview" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php echo lang_line("text_cancel");?>
        </a>
    </div>

</form>