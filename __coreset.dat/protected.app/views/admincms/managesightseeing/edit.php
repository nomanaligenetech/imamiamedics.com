<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    

	<table class="table table_form">
		
	


		<tr>
			<td class="td_bg fieldKey">Country <?php echo required_field(); ?></td>
			<td class="td_bg fieldValue" colspan="2">
			<div class="input-group">
				<?php
                    echo form_dropdown("countryid", DropdownHelper::country_dropdown(), set_value("countryid", $countryid), "class='form-control'" );
                ?>
            </div>
			</td>
		</tr>
		
		
        
       
		
		

		
		<tr>
			<td class="td_bg">Image <?php echo required_field(); ?></td>
			<td class="td_bg" colspan="2">
				<div class="input-group">
				<input type="file" class="btn btn-default" name="file_photo_image"/>
				<input type="hidden" value="<?php echo set_value("photo_image", $photo_image);?>" name="photo_image" />  
				<small><?php echo image_link("photo_image", $photo_image);?></small>
				</div>
			</td>
		</tr>
        
        
        
        <tr>
            <td class="td_bg">Photo Caption</td>
            <td class="td_bg" colspan="2">
            <div class="input-group">
            <?php
            $specdata		= array("name"		=> "caption",
                                    "id"		=> "caption",
                                    "size"		=> 50,
                                    "class"		=> "form-control",
                                    "value"		=> set_value("caption", $caption) );	
            
            echo form_input($specdata);
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
			<td class="td_bg">&nbsp;</td>
			<td colspan="2" class="td_bg">
				<input type="hidden" value="<?php echo set_value("id", $id);?>" name="hdn_id" />
			</td>
		</tr>
		
		
  </table>
<input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
  <input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />
    
    <div class="crud_controls">
        <button type="submit" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>
        <a class="btn btn-danger btn-flat" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php echo lang_line("text_cancel");?>
        </a>
    </div>

</form>