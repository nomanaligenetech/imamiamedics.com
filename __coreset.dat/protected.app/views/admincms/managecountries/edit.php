<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    

	<table class="table table_form">
		
        <tr>
            <td width="241" class="td_bg fieldKey">Country Name </td>
            <td class="td_bg fieldValue" colspan="2">
            <div class="input-group">
            <?php echo $countries_name; ?>
            </div>
            </td>
        </tr>
        
        <tr>
            <td width="241" class="td_bg fieldKey">Country Code 2 </td>
            <td class="td_bg fieldValue" colspan="2">
            <div class="input-group">
            <?php echo $countries_iso_code_2; ?>
            </div>
            </td>
        </tr>
        
        <tr>
            <td width="241" class="td_bg fieldKey">Country Code 3 </td>
            <td class="td_bg fieldValue" colspan="2">
            <div class="input-group">
            <?php echo $countries_iso_code_3; ?>
            </div>
            </td>
        </tr>

        <tr>
            <td width="241" class="td_bg fieldKey">Paypal Email <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue" colspan="2">
            <div class="input-group">
            <?php
            $specdata		= array("name"		=> "paypal_email",
                                    "id"		=> "paypal-email",
                                    "size"		=> 50,
                                    "class"		=> " form-control",
                                    "value"		=> set_value("paypal_email", $paypal_email) );	
            
            echo form_input($specdata);
            ?>
            </div>
            </td>
        </tr>
  </table>
<input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
  <input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />
    
    <div class="crud_controls">
        <button type="submit" data-operationid="managecountriessave" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>
        <a class="btn btn-danger btn-flat" data-operationid="managecountriesview" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php echo lang_line("text_cancel");?>
        </a>
    </div>

</form>