<?php 
$attributes 			= array("method"		=> "post",
								"name"			=> "form_users",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    

	<table class="table table_form">
	   	<tr>
           <td class="td_bg">Category <?php echo required_field();?></td>
              <td colspan="2" class="td_bg">
              
                <div class="input-group">
                    <?php echo form_dropdown('category', DropdownHelper::category( set_value("id", $id) ), 
											set_value("id", $id), 
											"class='form-control '" )?>
                </div>
                
                </td>
          </tr>

		<tr>
		  <td class="td_bg fieldKey">Name <?php echo required_field(); ?></td>
		  <td class="td_bg fieldValue" colspan="2">
          <div class="input-group">
		    <?php
			$specdata		= array("name"			=> "name",
									"id"			=> "name",
									"size"			=> 50,
									"class"			=> "form-control",
									 "value"			=> set_value("name", $name));	

			echo form_input($specdata);
			?>
		    </div>
		    </td>
	  	</tr>

	  	<tr>
		  <td class="td_bg">Short Description</td>
		  <td class="td_bg">
          <div class="input-group">
		    <?php
			$specdata		= array("name"			=> "description",
									"id"			=> "description",
									"rows"			=> 10,
									"cols"			=> 70,
									"class"			=> "ckeditor1 form-control",
									"value"			=> set_value("description", $description ) );	

			echo form_textarea($specdata);
			?>
		    </div>
        </td>
	  </tr>

	<tr>
			<td class="td_bg">&nbsp;</td>
			<td class="td_bg" colspan="2">
				<input type="hidden" value="<?php echo set_value("id", $id);?>" name="hdn_id" />
			</td>
		</tr>
		
		
  </table>
<input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
  <input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />
    
    <div class="crud_controls">
  <button type="submit" data-operationid="manageforumsave" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>
        <a class="btn btn-danger btn-flat" data-operationid="manageforumview" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php echo lang_line("text_cancel");?>
        </a>
    </div>

</form>

<script>
$("form[name='form_users'] input[type='text']").attr("disabled", false);
$("form[name='form_users'] select").attr("disabled", false);
</script>