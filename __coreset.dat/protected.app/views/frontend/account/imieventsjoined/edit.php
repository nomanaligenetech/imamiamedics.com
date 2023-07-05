<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    

	<table class="table table_form">
		<tr>
		  <td class="td_bg"><strong>Title</strong></td>
		  <td class="td_bg"><div class="input-group">
          <?php
			echo set_value("title", $title );
			?>
          </div></td>
	  </tr>

      <tr>
		  <td class="td_bg"><strong>Status</strong></td>
		  <td class="td_bg"><div class="input-group">
            <div>
            <input type="radio" name="event" id="event" value="Interested" <?php echo $event == "Interested" ? 'checked="checked"' : '';?> />
            <label class="control-label">Interested</label>
            </div>
            <div>
            <input type="radio" name="event" id="event" value="Going" <?php echo $event == "Going" ? 'checked="checked"' : ''; ?> />
            <label class="control-label">Going</label>
            </div>
            <div>
            <input type="radio" name="event" id="event" value="Not going" <?php echo $event == "Not going" ? 'checked="checked"' : ''; ?> />
            <label class="control-label">Not going</label>
            </div>
          </div></td>
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
       <button class="btn btn-success btn-flat" type="submit">
            <?php echo lang_line("text_save"); ?>
        </button>
        <a class="btn btn-danger btn-flat" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php echo lang_line("text_cancel");?>
        </a>
    </div>

</form>