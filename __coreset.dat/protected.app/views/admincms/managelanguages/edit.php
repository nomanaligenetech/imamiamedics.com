<?php 
$attributes = array(
    "method" => "post",
    "enctype" => "multipart/form-data"
);
$unique_form = array("unique_formid" => set_value("unique_formid", random_string("unique")));

echo form_open(site_url($_directory . "controls/save"), $attributes, $unique_form);
?>    

	<table class="table table_form">
        <tr>
            <td class="td_bg fieldKey">Language <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue" colspan="2">
                <div class="input-group">
                <?php
                $specdata = array(
                    "name" => "name",
                    "id" => "name",
                    "value" => set_value("name", $name),
                    "class" => 'form-control',
                    "placeholder" => "Language *",
                    "size" => 50
                );

                echo form_input($specdata);
                ?>
                </div>
            </td>
        </tr>
        
        <tr>
            <td class="td_bg fieldKey">Code <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue" colspan="2">
                <div class="input-group">
                <?php
                $specdata = array(
                    "name" => "code",
                    "id" => "code",
                    "value" => set_value("code", $code),
                    "class" => 'form-control',
                    "placeholder" => "Code *",
                    "size" => 2
                );
                echo form_input($specdata);
                ?>
                </div>
            </td>
        </tr>
        
        <tr>
            <td class="td_bg fieldKey">Direction <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue" colspan="2">
                <div class="input-group">
					<?php
					echo form_dropdown("direction", DropdownHelper::language_direction_dropdown( FALSE, "" ), set_value("direction", $direction), "class='form-control'" );
					?>
				</div>
            </td>
		</tr>
        
    </table>
    <input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
    <input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />
    
    <div class="crud_controls">
        <button type="submit" data-operationid="managelanguagessave" class="btn btn-warning btn-flat"><?php echo lang_line("text_save"); ?></button>
        <a class="btn btn-danger btn-flat" data-operationid="managelanguagesview" href="<?php echo site_url($_directory . "controls/view"); ?>">
            <?php echo lang_line("text_cancel"); ?>
        </a>
    </div>

</form>