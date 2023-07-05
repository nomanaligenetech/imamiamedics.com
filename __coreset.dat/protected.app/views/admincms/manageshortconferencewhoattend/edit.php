<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    

	<table class="table table_form">
		
	


		<tr>
			<td class="td_bg fieldKey">Select Conference <?php echo required_field(); ?></td>
			<td class="td_bg fieldValue" colspan="2">
			<div class="input-group">
				<?php
                    echo form_dropdown("conferenceid", DropdownHelper::short_conference_dropdown(), set_value("conferenceid", $conferenceid), "class='form-control'" );
                ?>
            </div>
			</td>
		</tr>
		
		
        
       
		
		<tr>
            <td class="td_bg">Name <?php echo required_field(); ?></td>
            <td class="td_bg" colspan="2">
            <div class="input-group">
            <?php
            $specdata		= array("name"		=> "name",
                                    "id"		=> "name",
                                    "size"		=> 50,
                                    "class"		=> "form-control",
                                    "value"		=> set_value("name", $name) );	
            
            echo form_input($specdata);
            ?>
            </div>
            </td>
        </tr>
        
        <tr>
            <td class="td_bg">Description <?php  required_field(); ?></td>
            <td class="td_bg" colspan="2">
            <div class="input-group">
            <?php
            $specdata		= array("name"		=> "description",
                                    "id"		=> "description",
                                    "size"		=> 50,
                                    "class"		=> "form-control",
                                    "value"		=> set_value("description", $description) );	
            
            echo form_input($specdata);
            ?>
            </div>
            </td>
        </tr>
        
        
        
        <tr>
            <td class="td_bg">No. of people <?php echo required_field(); ?></td>
            <td class="td_bg" colspan="2">
            <div class="input-group">
            <?php
            $specdata		= array("name"		=> "no_of_people",
                                    "id"		=> "no_of_people",
                                    "size"		=> 50,
                                    "class"		=> "form-control numericonly",
                                    "value"		=> set_value("no_of_people", $no_of_people) );	
            
            echo form_input($specdata);
            ?>
            </div>
            </td>
        </tr>
        
        
        <tr>
			<td class="td_bg">Image <?php  required_field(); ?></td>
			<td class="td_bg" colspan="2">
				<div class="input-group">
				<input type="file" class="btn btn-default" name="file_image_icon"/>
				<input type="hidden" value="<?php echo set_value("image_icon", $image_icon);?>" name="image_icon" />  
				<small><?php echo image_link("image_icon", $image_icon);?></small>
				</div>
			</td>
        </tr>
        
        <tr>
			<td class="td_bg fieldKey">Select Type <?php echo required_field(); ?></td>
			<td class="td_bg fieldValue" colspan="2">
			<div class="input-group targetBox_typeid">
				<?php
                    //echo form_dropdown("type", DropdownHelper::pkgtype_dropdown($conferenceid), set_value("type", $type), "class='form-control'" );
                    if ( empty( $ajax_output2 ) )
                    {
                    ?>
                        <small class="badge pull-right bg-green" style="">please select conference first</small>
                    <?php
                    }
                    else
                    {
                        echo $ajax_output2;	
                    }
                ?>
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
        <button type="submit" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>
        <a class="btn btn-danger btn-flat" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php echo lang_line("text_cancel");?>
        </a>
    </div>

</form>