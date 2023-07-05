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
            <td class="td_bg fieldKey">Submit by User </td>
            <td class="td_bg fieldValue" colspan="2">
                <?php echo $user_email; ?>
            </td>
        </tr>
        <tr>
            <td class="td_bg fieldKey">Name <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue" colspan="2">
                <div class="input-group">
                <?php
                $specdata = array(
                    "name" => "name",
                    "id" => "name",
                    "value" => set_value("name", $name),
                    "class" => 'form-control',
                    "placeholder" => "Name *",
                    "size" => 50
                );

                echo form_input($specdata);
                ?>
                </div>
            </td>
        </tr>

        <tr>
            <td class="td_bg fieldKey">Date of Birth <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue" colspan="2">
                <div class="input-group">
                <?php
                $specdata		= array("name"				=> 'date_of_birth',
                                        "id"				=> 'date_of_birth',
                                        "class"				=> "form-control birthdate_datepicker",
                                        "value"				=> set_value('date_of_birth', $date_of_birth) );
                
                echo form_input($specdata);

                ?>
                </div>
            </td>
		</tr>

        <tr>
            <td class="td_bg fieldKey">Email <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue" colspan="2">
                <div class="input-group">
                <?php
                $specdata = array(
                    "name" => "email",
                    "id" => "email",
                    "value" => set_value("email", $email),
                    "class" => 'form-control',
                    "placeholder" => "Email *",
                    "size" => 50
                );

                echo form_input($specdata);
                ?>
                </div>
            </td>
        </tr>
        
        <tr>
            <td class="td_bg fieldKey">Phone <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue" colspan="2">
                <div class="input-group">
                <?php
                $TMP_name = "phone";
                $specdata = array(
                    "name" => $TMP_name,
                    "id" => $TMP_name,
                    "value" => set_value($TMP_name, $state),
                    "class" => 'form-control',
                    "placeholder" => "Phone *",
                    "size" => 50
                );

                echo form_input($specdata);
                ?>
                </div>
            </td>
        </tr>
        
        <tr>
            <td class="td_bg fieldKey">City <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue" colspan="2">
                <div class="input-group">
                <?php
                $TMP_name = "city";
                $specdata = array(
                    "name" => $TMP_name,
                    "id" => $TMP_name,
                    "value" => set_value($TMP_name, $city),
                    "class" => 'form-control',
                    "placeholder" => "City *",
                    "size" => 50
                );

                echo form_input($specdata);
                ?>
                </div>
            </td>
		</tr>
        
        <tr>
            <td class="td_bg fieldKey">State <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue" colspan="2">
                <div class="input-group">
                <?php
                $TMP_name = "state";
                $specdata = array(
                    "name" => $TMP_name,
                    "id" => $TMP_name,
                    "value" => set_value($TMP_name, $state),
                    "class" => 'form-control',
                    "placeholder" => "State *",
                    "size" => 50
                );

                echo form_input($specdata);
                ?>
                </div>
            </td>
		</tr>
        
        <tr>
            <td class="td_bg fieldKey">Country <?php echo required_field(); ?></td>
            <td id="fakeSelectContaier" class="typeOne custom_dropdown">
                <span class="fakeSelect"></span>
                <?php echo form_dropdown('country', DropdownHelper::country_dropdown(), set_value("country", $country) )?>
            </td>
        </tr>

        <tr>
            <td class="td_bg fieldKey">Qualification <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue" colspan="2">
                <div class="input-group">
                <?php
                $TMP_name = "qualification";
                $specdata = array(
                    "name" => $TMP_name,
                    "id" => $TMP_name,
                    "value" => set_value($TMP_name, $qualification),
                    "class" => 'form-control',
                    "placeholder" => "Qualification *",
                    "size" => 50
                );

                echo form_input($specdata);
                ?>
                </div>
            </td>
		</tr>
        
        <tr>
            <td class="td_bg fieldKey">Area of interest <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue" colspan="2">
                <div class="input-group">
                <?php
                $TMP_name = "area_of_interest";
                $specdata = array(
                    "name" => $TMP_name,
                    "id" => $TMP_name,
                    "value" => set_value($TMP_name, $area_of_interest),
                    "class" => 'form-control selectize',
                    "placeholder" => "Area of interest *",
                    "size" => 50
                );

                echo form_input($specdata);
                ?>
                </div>
            </td>
		</tr>
    </table>
    <input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
    <input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />
    
    <div class="crud_controls">
        <button type="submit" data-operationid="managevolunteerssave" class="btn btn-warning btn-flat"><?php echo lang_line("text_save"); ?></button>
        <a class="btn btn-danger btn-flat" data-operationid="managevolunteersview" href="<?php echo site_url($_directory . "controls/view"); ?>">
            <?php echo lang_line("text_cancel"); ?>
        </a>
    </div>

</form>