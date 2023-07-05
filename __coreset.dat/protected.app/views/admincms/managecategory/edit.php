<?php 
$attributes 			= array("method"		=> "post",
								"name"			=> "form_users",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    

	<table class="table table_form">


  <tr>
              <td class="td_bg">Category Type <?php echo required_field();?></td>
              <td colspan="2" class="td_bg">
              
                <div class="input-group">
                    <?php echo form_dropdown('category_type', DropdownHelper::category_type( set_value("id", $id) ), 
											set_value("id", $id), 
											"class='form-control '" )?>
                </div>
                
                </td>
          </tr>
 <tr>
		  <td class="td_bg fieldKey">Parent Category</td>
		  <td class="td_bg fieldValue" colspan="2">
            <div class="input-group">
                <?php echo form_dropdown('parent_category', DropdownHelper::getCategories( set_value("id", $id), FALSE), 
                                        set_value("id", $parent_id), 
                                        "class='form-control' size='10'  " )?>
            </div>
          </td>
	  </tr>

<tr>
		  <td class="td_bg fieldKey">Category Name <?php echo required_field(); ?></td>
		  <td class="td_bg fieldValue" colspan="2">
          <div class="input-group">
		    <?php
			$specdata		= array("name"			=> "cat_name",
									"id"			=> "cat_name",
									"size"			=> 50,
									"class"			=> "form-control",
									 "value"			=> set_value("cat_name", $cat_name));	

			echo form_input($specdata);
			?>
		    </div></td>
		      <td class="td_bg"><div class="badge bg-green"> <?php echo form_checkbox(	"show_title", 1, set_checkbox("show_title", 1, format_bool( $show_title, 1 ) ) );?> Show Title </div></td>
	 
	  </tr>
      
      
       <tr>
            <td class="td_bg">Image</td>
            <td class="td_bg" colspan="2"><span class="input-group">
              <div class="input-group">
                    <input type="file" class="btn btn-default" name="photo_path" value=""/>
                    <input type="hidden" value="<?php echo set_value("photo image", $photo_path);?>" name="photo_image"/>  
                    <small><?php echo image_link("photo image", $photo_path); ?></small>
			
            </span></td>
          </tr>
      
          <tr>
              <td class="td_bg">Status</td>
              <td colspan="2" class="td_bg"><div class="input-group">
              <?php echo form_dropdown('status', DropdownHelper::yesno_dropdown(), set_value("status", $status), "class='form-control '" )?></div>
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
    <button type="submit" data-operationid="managecategorysave" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>
    <a class="btn btn-danger btn-flat" data-operationid="managecategoryview" href="<?php echo site_url( $_directory . "controls/view");?>">
      <?php echo lang_line("text_cancel");?>
    </a>
  </div>
</form>

<script>
$("form[name='form_users'] input[type='text']").attr("disabled", false);
$("form[name='form_users'] select").attr("disabled", false);
</script>