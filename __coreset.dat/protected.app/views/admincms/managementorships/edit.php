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
            <td class="td_bg fieldKey">First Name <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue" colspan="2">
                <div class="input-group">
                <?php
                $specdata = array(
                    "name" => "first_name",
                    "id" => "first_name",
                    "value" => set_value("first_name", $first_name),
                    "class" => 'form-control',
                    "placeholder" => "First Name *",
                    "size" => 50
                );

                echo form_input($specdata);
                ?>
                </div>
            </td>
        </tr>
        
        <tr>
            <td class="td_bg fieldKey">Last Name <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue" colspan="2">
                <div class="input-group">
                <?php
                $specdata = array(
                    "name" => "last_name",
                    "id" => "last_name",
                    "value" => set_value("last_name", $last_name),
                    "class" => 'form-control',
                    "placeholder" => "Last Name *",
                    "size" => 50
                );
                echo form_input($specdata);
                ?>
                </div>
            </td>
        </tr>
        
        <tr>
            <td class="td_bg fieldKey">Address <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue" colspan="2">
                <div class="input-group">
                <?php
                $specdata = array(
                    "name" => "address",
                    "id" => "address",
                    "value" => set_value("address", $address),
                    "class" => 'form-control',
                    "placeholder" => "Address *",
                    "cols" => 60
                );

                echo form_textarea($specdata);
                ?>
                </div>
            </td>
		</tr>
        
        <tr>
            <td class="td_bg fieldKey">Address 2</td>
            <td class="td_bg fieldValue" colspan="2">
                <div class="input-group">
                <?php
                $specdata = array(
                    "name" => "address_2",
                    "id" => "address_2",
                    "value" => set_value("address_2", $address_2),
                    "class" => 'form-control',
                    "placeholder" => "Address 2",
                    "cols" => 60
                );

                echo form_textarea($specdata);
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
            <td class="td_bg fieldKey">Zip</td>
            <td class="td_bg fieldValue" colspan="2">
                <div class="input-group">
                <?php
                $specdata = array(
                    "name" => "zip",
                    "id" => "zip",
                    "value" => set_value("zip",$zip),
                    "class" => 'form-control',
                    "placeholder" => "Zip",
                    "size" => 50
                );

                echo form_input($specdata);
                ?>
                </div>
            </td>
        </tr>
        
        <tr>
            <td class="td_bg fieldKey">Employer <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue" colspan="2">
                <div class="input-group">
                <?php
                $specdata = array(
                    "name" => "employer",
                    "id" => "employer",
                    "value" => set_value("employer",$employer),
                    "class" => 'form-control',
                    "placeholder" => "Employer *",
                    "size" => 50
                );

                echo form_input($specdata);
                ?>
                </div>
            </td>
		</tr>
        
        <tr>
            <td class="td_bg fieldKey">Profession <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue" colspan="2">
                <div class="input-group">
                <?php
                $TMP_name = "profession";
                $specdata = array(
                    "name" => $TMP_name,
                    "id" => $TMP_name,
                    "value" => set_value($TMP_name, $profession),
                    "class" => 'form-control',
                    "placeholder" => "Profession *",
                    "size" => 50
                );

                echo form_input($specdata);
                ?>
                </div>
            </td>
		</tr>
        
        <tr>
            <td class="td_bg fieldKey">University</td>
            <td class="td_bg fieldValue" colspan="2">
                <div class="input-group">
                <?php
                $specdata = array(
                    "name" => "university",
                    "id" => "university",
                    "value" => set_value("university",$university),
                    "class" => 'form-control',
                    "placeholder" => "University",
                    "size" => 50
                );

                echo form_input($specdata);
                ?>
                </div>
            </td>
        </tr>
        
        <tr>
            <td class="td_bg fieldKey">University State</td>
            <td class="td_bg fieldValue" colspan="2">
                <div class="input-group">
                <?php
                $TMP_name = "university_state";
                $specdata = array(
                    "name" => $TMP_name,
                    "id" => $TMP_name,
                    "value" => set_value($TMP_name,$university_state),
                    "class" => 'form-control',
                    "placeholder" => "University State",
                    "size" => 50
                );

                echo form_input($specdata);
                ?>
                </div>
            </td>
        </tr>
        
        <tr>
            <td class="td_bg fieldKey">University City</td>
            <td class="td_bg fieldValue" colspan="2">
                <div class="input-group">
                <?php
                $TMP_name = "university_city";
                $specdata = array(
                    "name" => $TMP_name,
                    "id" => $TMP_name,
                    "value" => set_value($TMP_name,$university_city),
                    "class" => 'form-control',
                    "placeholder" => "University City",
                    "size" => 50
                );

                echo form_input($specdata);
                ?>
                </div>
            </td>
        </tr>
        
        <tr>
            <td class="td_bg fieldKey">Degree Type</td>
            <td class="td_bg fieldValue" colspan="2">
                <div class="input-group">
                <?php
                $specdata = array(
                    "name" => "degree_type",
                    "id" => "degree_type",
                    "value" => set_value("degree_type",$degree_type),
                    "class" => 'form-control',
                    "placeholder" => "Degree Type",
                    "size" => 50
                );

                echo form_input($specdata);
                ?>
                </div>
            </td>
		</tr>
        
        <tr>
            <td class="td_bg fieldKey">Major</td>
            <td class="td_bg fieldValue" colspan="2">
                <div class="input-group">
                <?php
                $specdata = array(
                    "name" => 'major',
                    "id" => 'major',
                    "value" => set_value('major',$major),
                    "class" => 'form-control',
                    "placeholder" => "Major",
                    "size" => 50
                );

                echo form_input($specdata);
                ?>
                </div>
            </td>
		</tr>
        
        <tr>
            <td class="td_bg fieldKey">Graduate Year</td>
            <td class="td_bg fieldValue" colspan="2">
                <div class="input-group">
                <?php
                $specdata = array(
                    "name" => "graduate_year",
                    "id" => "graduate_year",
                    "value" => set_value("graduate_year",$graduate_year),
                    "class" => 'form-control',
                    "placeholder" => "Graduate Year",
                    "size" => 50,
                    "pattern"    => "\d*",
                    "maxlength" =>  "4"
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
        <button type="submit" data-operationid="managementorshipssave" class="btn btn-warning btn-flat"><?php echo lang_line("text_save"); ?></button>
        <a class="btn btn-danger btn-flat" data-operationid="managementorshipsview" href="<?php echo site_url($_directory . "controls/view"); ?>">
            <?php echo lang_line("text_cancel"); ?>
        </a>
    </div>

</form>