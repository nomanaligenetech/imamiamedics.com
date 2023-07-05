<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );
echo form_open(site_url( $_directory . "controls/update/{$edit_id}" ), $attributes, $unique_form);

$this->load->view("admincms/manageshortconferenceregistrationfinance/include_view");

?>    

<input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
  <input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />
    
    <div class="crud_controls"> <?php
       if(isset($show_update_page) && $show_update_page){?>
        <button type="submit" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>	<?php	}?>
        
        <a class="btn btn-danger btn-flat" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php echo lang_line("text_cancel");?>
        </a>
    </div>

</form>

