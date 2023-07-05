<?php
$attributes             = array(
    "method"        => "post",
    "name"            => "form_users",
    "enctype"        => "multipart/form-data"
);
$unique_form            = array("unique_formid"    => set_value("unique_formid", random_string("unique")));

echo form_open(site_url($_directory . "controls/save"), $attributes, $unique_form);
?>

<table class="table table_form">
    <tr>
        <td>
            <div class="profileSettings fl_lft w_100">
                <div class="form_sec fl_lft w_100">
                    <div class="field_row myLabel p_right10">
                        <div class="profile_image_wrap">
                            <div class="memImg ronded">
                                <?php if (isset($profile_image) && $profile_image != "") {
                                    echo $this->functions->timthumb($profile_image, 200, 200);
                                } else {
                                    echo $this->functions->timthumb("assets/frontend/images/no-image.jpg", 200, 200);
                                } ?>
                            </div>
                            <label class="profile_image_lbl">Change Profile Image</label>
                            <input type="file" name="profile_image" value="" class="profile_image" />
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <tr class="clear_border_bottom">
        <td height="10" colspan="2">
            <br /><br />
            <strong>Personal Details</strong></td>
    </tr>

    <tr>
        <td class="td_bg fieldKey">IMI ID<?php echo required_field(); ?></td>
        <td class="td_bg fieldValue" colspan="2">
            <div class="input-group">
                <?php
                $specdata        = array(
                    "name"            => "imi_id",
                    "id"            => "imi_id",
                    "size"            => 50,
                    "class"            => "form-control",
                    "value"            => set_value("imi_id", $imi_id)
                );

                echo form_input($specdata);
                ?>
            </div>
        </td>
    </tr>
    <tr>
        <td class="td_bg">Salutation :</td>
        <td class="td_bg" colspan="2"><span class="input-group">
                <?php echo form_dropdown('prefix_title', DropdownHelper::salutation_dropdown(), set_value("prefix_title", str_replace('.', '', $prefix_title)), 'class="form-control"'); ?>
        </td>
    </tr>
    <tr>
        <td class="td_bg fieldKey">First Name <?php echo required_field(); ?></td>
        <td class="td_bg fieldValue" colspan="2">
            <div class="input-group">
                <?php
                $specdata        = array(
                    "name"            => "name",
                    "id"            => "name",
                    "size"            => 50,
                    "class"            => "form-control",
                    "value"            => set_value("name", $name)
                );

                echo form_input($specdata);
                ?>
            </div>
        </td>
    </tr>
    <tr>
        <td class="td_bg fieldKey">Middle Name</td>
        <td class="td_bg fieldValue" colspan="2">
            <div class="input-group">
                <?php
                $specdata        = array(
                    "name"            => "middle_name",
                    "id"            => "middle_name",
                    "size"            => 50,
                    "class"            => "form-control",
                    "value"            => set_value("middle_name", $middle_name)
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
                $specdata        = array(
                    "name"            => "last_name",
                    "id"            => "last_name",
                    "size"            => 50,
                    "class"            => "form-control",
                    "value"            => set_value("last_name", $last_name)
                );

                echo form_input($specdata);
                ?>
            </div>
        </td>
    </tr>

    <tr>
        <td class="td_bg">Cell Phone No :</td>
        <td class="td_bg" colspan="2"><span class="input-group">
                <?php
                $TMP_input = "cellphone_number";
                $specdata = array(
                    "name" => $TMP_input,
                    "id" => $TMP_input,
                    "size" => 50,
                    "class" => "form-control",
                    "value" => set_value($TMP_input, ${$TMP_input})
                );

                echo form_input($specdata);
                ?>
        </td>
    </tr>

    <tr>
        <td class="td_bg">Gender :</td>
        <td class="td_bg" colspan="2"><span class="input-group">
                <?php echo form_dropdown('gender', DropdownHelper::gender_dropdown(), set_value("gender", $gender), 'class="form-control"'); ?>
        </td>
    </tr>

    <tr>
        <td class="td_bg">Institute School :</td>
        <td class="td_bg" colspan="2"><span class="input-group">
                <?php
                $TMP_input = "institute_school";
                $specdata = array(
                    "name" => $TMP_input,
                    "id" => $TMP_input,
                    "size" => 50,
                    "class" => "form-control",
                    "value" => set_value($TMP_input, ${$TMP_input})
                );

                echo form_input($specdata);
                ?>
        </td>
    </tr>

    <tr>
        <td class="td_bg">Web Address :</td>
        <td class="td_bg" colspan="2"><span class="input-group">
                <?php
                $TMP_input = "web_address";
                $specdata = array(
                    "name" => $TMP_input,
                    "id" => $TMP_input,
                    "size" => 50,
                    "class" => "form-control",
                    "value" => set_value($TMP_input, ${$TMP_input})
                );

                echo form_input($specdata);
                ?>
        </td>
    </tr>
    <tr>
        <td class="td_bg">Password :</td>
        <td class="td_bg" colspan="2"><span class="input-group">
                <?php
                $TMP_input = "password";
                $specdata = array(
                    "name" => $TMP_input,
                    "id" => $TMP_input,
                    "class" => "form-control",
                    'size' => 50,
                    "value" => set_value($TMP_input, ${$TMP_input})
                );

                echo form_input($specdata);
                ?>
        </td>
    </tr>

    <tr class="clear_border_bottom">
        <td height="10" colspan="2">
            <br /><br />
            <strong></strong></td>
    </tr>

    <tr class="clear_border_bottom">
        <td height="10" colspan="2">
            <br /><br />
            <strong>Email Addresses</strong></td>
    </tr>

    <tr>
        <td class="td_bg">Primary Email Address :</td>
        <td class="td_bg" colspan="2"><span class="input-group">
                <?php
                $TMP_input = "email";
                $specdata = array(
                    "name" => $TMP_input,
                    "id" => $TMP_input,
                    "readonly" => "readonly",
                    "class" => "form-control",
                    "value" => set_value($TMP_input, ${$TMP_input})
                );

                echo form_input($specdata);
                ?>
        </td>
    </tr>



    <tr>
        <td class="td_bg">Secondary Email Address 01 :</td>
        <td class="td_bg" colspan="2"><span class="input-group">
                <?php
                $TMP_input = "secondary_email_1";
                $specdata = array(
                    "name" => $TMP_input,
                    "id" => $TMP_input,
                    "class" => "form-control",
                    "value" => set_value($TMP_input, ${$TMP_input})
                );

                echo form_input($specdata);
                ?>
        </td>
    </tr>


    <tr>
        <td class="td_bg">Secondary Email Address 02 :</td>
        <td class="td_bg" colspan="2"><span class="input-group">
                <?php
                $TMP_input = "secondary_email_2";
                $specdata = array(
                    "name" => $TMP_input,
                    "id" => $TMP_input,
                    "size" => 50,
                    "class" => "form-control",
                    "value" => set_value($TMP_input, ${$TMP_input})
                );

                echo form_input($specdata);
                ?>
        </td>
    </tr>

    <tr class="clear_border_bottom">
        <td height="10" colspan="2">
            <br /><br />
            <strong>Titles</strong></td>
    </tr>

    <tr>
        <td class="td_bg">Previous Title With IMI:</td>
        <td class="td_bg" colspan="2"><span class="input-group">
                <?php
                $TMP_input = "previous_title_with_imi";
                $specdata = array(
                    "name" => $TMP_input,
                    "id" => $TMP_input,
                    "size" => 50,
                    "class" => "form-control",
                    "value" => set_value($TMP_input, ${$TMP_input})
                );

                echo form_input($specdata);
                ?>
        </td>
    </tr>

    <tr>
        <td class="td_bg">Current IMI Title :</td>
        <td class="td_bg" colspan="2"><span class="input-group">
                <?php
                $TMP_input = "current_imi_title";
                $specdata = array(
                    "name" => $TMP_input,
                    "id" => $TMP_input,
                    "size" => 50,
                    "class" => "form-control",
                    "value" => set_value($TMP_input, ${$TMP_input})
                );

                echo form_input($specdata);
                ?>
        </td>
    </tr>

    <tr class="clear_border_bottom">
        <td height="10" colspan="2">
            <br /><br />
            <strong></strong></td>
    </tr>

    <tr class="clear_border_bottom">
        <td height="10" colspan="2">
            <br /><br />
            <strong>Home Address</strong></td>
    </tr>

    <tr>
        <td class="td_bg">Home Full Address :</td>
        <td class="td_bg" colspan="2"><span class="input-group">
                <?php
                $TMP_input = "home_full_address";
                $specdata = array(
                    "name" => $TMP_input,
                    "id" => $TMP_input,
                    "size" => 50,
                    "class" => "form-control",
                    "value" => set_value($TMP_input, ${$TMP_input})
                );

                echo form_textarea($specdata);
                ?>
        </td>
    </tr>
    <tr>
        <td class="td_bg">Home Country :</td>
        <td class="td_bg" colspan="2"><span class="input-group">
                <div id="fakeSelectContaier" class="typeOne custom_dropdown">
                    <span class="fakeSelect"></span>
                    <?php echo form_dropdown('home_country', DropdownHelper::country_dropdown(), set_value("home_country", $home_country), 'class="form-control"') ?>
                </div>
        </td>
    </tr>
    <tr>
        <td class="td_bg">Home State/Province :</td>
        <td class="td_bg" colspan="2"><span class="input-group">
                <?php
                $TMP_input = "home_state_province";
                $specdata = array(
                    "name" => $TMP_input,
                    "id" => $TMP_input,
                    "size" => 50,
                    "class" => "form-control",
                    "value" => set_value($TMP_input, ${$TMP_input})
                );

                echo form_input($specdata);
                ?>
        </td>
    </tr>
    <tr>
        <td class="td_bg">Home City :</td>
        <td class="td_bg" colspan="2"><span class="input-group">
                <?php
                $TMP_input = "home_city";
                $specdata = array(
                    "name" => $TMP_input,
                    "id" => $TMP_input,
                    "size" => 50,
                    "class" => "form-control",
                    "value" => set_value($TMP_input, ${$TMP_input})
                );

                echo form_input($specdata);
                ?>
        </td>
    </tr>

    <tr>
        <td class="td_bg">Home Phone Number :</td>
        <td class="td_bg" colspan="2"><span class="input-group">
                <?php
                $TMP_input = "home_phone_number";
                $specdata = array(
                    "name" => $TMP_input,
                    "id" => $TMP_input,
                    "size" => 50,
                    "class" => "form-control",
                    "value" => set_value($TMP_input, ${$TMP_input})
                );

                echo form_input($specdata);
                ?>
        </td>
    </tr>

    <tr>
        <td class="td_bg">Home Zip/Postal Code :</td>
        <td class="td_bg" colspan="2"><span class="input-group">
                <?php
                $TMP_input = "home_zipcode";
                $specdata = array(
                    "name" => $TMP_input,
                    "id" => $TMP_input,
                    "size" => 50,
                    "class" => "form-control",
                    "value" => set_value($TMP_input, ${$TMP_input})
                );

                echo form_input($specdata);
                ?>
        </td>
    </tr>
    
    <tr class="clear_border_bottom">
        <td height="10" colspan="2">
            <br /><br />
            <strong>Office Address</strong></td>
    </tr>

    <tr>
        <td class="td_bg">Office Full Address :</td>
        <td class="td_bg" colspan="2"><span class="input-group">
                <?php
                $TMP_input = "office_full_address";
                $specdata = array(
                    "name" => $TMP_input,
                    "id" => $TMP_input,
                    "size" => 50,
                    "class" => "form-control",
                    "value" => set_value($TMP_input, ${$TMP_input})
                );

                echo form_textarea($specdata);
                ?>
        </td>
    </tr>

    <tr>
        <td class="td_bg">Office Country :</td>
        <td class="td_bg" colspan="2"><span class="input-group">
                <div id="fakeSelectContaier" class="typeOne custom_dropdown">
                    <span class="fakeSelect"></span>
                    <?php echo form_dropdown('office_country', DropdownHelper::country_dropdown(), set_value("office_country", $office_country), 'class="form-control"') ?>
                </div>
        </td>
    </tr>

    <tr>
        <td class="td_bg">Office State/Province :</td>
        <td class="td_bg" colspan="2"><span class="input-group">
                <?php
                $TMP_input = "office_state_province";
                $specdata = array(
                    "name" => $TMP_input,
                    "id" => $TMP_input,
                    "size" => 50,
                    "class" => "form-control",
                    "value" => set_value($TMP_input, ${$TMP_input})
                );

                echo form_input($specdata);
                ?>
        </td>
    </tr>
    <tr>
        <td class="td_bg">Office City :</td>
        <td class="td_bg" colspan="2"><span class="input-group">
                <?php
                $TMP_input = "office_city";
                $specdata = array(
                    "name" => $TMP_input,
                    "id" => $TMP_input,
                    "size" => 50,
                    "class" => "form-control",
                    "value" => set_value($TMP_input, ${$TMP_input})
                );

                echo form_input($specdata);
                ?>
        </td>
    </tr>

    <tr>
        <td class="td_bg">Office Phone Number :</td>
        <td class="td_bg" colspan="2"><span class="input-group">
                <?php
                $TMP_input = "office_phone_number";
                $specdata = array(
                    "name" => $TMP_input,
                    "id" => $TMP_input,
                    "size" => 50,
                    "class" => "form-control",
                    "value" => set_value($TMP_input, ${$TMP_input})
                );

                echo form_input($specdata);
                ?>
        </td>
    </tr>

    <tr>
        <td class="td_bg">Office Zip/Postal Code :</td>
        <td class="td_bg" colspan="2"><span class="input-group">
                <?php
                $TMP_input = "office_zip_code";
                $specdata = array(
                    "name" => $TMP_input,
                    "id" => $TMP_input,
                    "size" => 50,
                    "class" => "form-control",
                    "value" => set_value($TMP_input, ${$TMP_input})
                );

                echo form_input($specdata);
                ?>
        </td>
    </tr>

    <tr>
        <td class="td_bg">Occupation :</td>
        <td class="td_bg" colspan="2"><span class="input-group">
                <?php
                $TMP_input = "occupation";
                $specdata = array(
                    "name" => $TMP_input,
                    "id" => $TMP_input,
                    "size" => 50,
                    "class" => "form-control",
                    "value" => set_value($TMP_input, ${$TMP_input})
                );

                echo form_input($specdata);
                ?>
        </td>
    </tr>

    <tr>
        <td class="td_bg">specialities :</td>
        <td class="td_bg" colspan="2"><span class="input-group">
                <?php
                $TMP_input = "specialties";
                $specdata = array(
                    "name" => $TMP_input,
                    "id" => $TMP_input,
                    "size" => 50,
                    "class" => "form-control",
                    "value" => set_value($TMP_input, ${$TMP_input})
                );

                echo form_input($specdata);
                ?>
        </td>
    </tr>

    <tr class="clear_border_bottom">
        <td height="10" colspan="2">
            <br /><br />
            <strong>Preferences</strong></td>
    </tr>

    <tr>
        <td class="td_bg">Preffered Address Mode :</td>
        <td class="td_bg" colspan="2"><span class="input-group">
                <p class="fl_lft">

                    <input type="radio" name="prefered_mode_address" class="<?php echo set_class("prefered_mode_address"); ?>" value="Personal" <?php echo set_radio("prefered_mode_address", "Personal", format_bool(set_value("prefered_mode_address", $prefered_mode_address), "Personal")); ?> />

                    <label>Home (Personal)</label>
                </p>
                <p class="fl_lft">

                    <input type="radio" name="prefered_mode_address" class="<?php echo set_class("prefered_mode_address"); ?>" value="Work" <?php echo set_radio("prefered_mode_address", "Work", format_bool(set_value("prefered_mode_address", $prefered_mode_address), "Work")); ?> />

                    <label>Office (Work)</label>
                </p>
        </td>
    </tr>

    <tr>
        <td class="td_bg">Preffered Phone :</td>
        <td class="td_bg" colspan="2"><span class="input-group">
                <p class="fl_lft">

                    <input type="radio" name="preffered_mode_of_contact" class="<?php echo set_class("preffered_mode_of_contact"); ?>" value="Home" <?php echo set_radio("preffered_mode_of_contact", "Home", format_bool(set_value("preffered_mode_of_contact", $preffered_mode_of_contact), "Home")); ?> />

                    <label>Home</label>
                </p>
                <p class="fl_lft">

                    <input type="radio" name="preffered_mode_of_contact" class="<?php echo set_class("preffered_mode_of_contact"); ?>" value="Mobile" <?php echo set_radio("preffered_mode_of_contact", "Mobile", format_bool(set_value("preffered_mode_of_contact", $preffered_mode_of_contact), "Mobile")); ?> />

                    <label>Mobile</label>
                </p>
                <p class="fl_lft">

                    <input type="radio" name="preffered_mode_of_contact" class="<?php echo set_class("preffered_mode_of_contact"); ?>" value="Work" <?php echo set_radio("preffered_mode_of_contact", "Work", format_bool(set_value("preffered_mode_of_contact", $preffered_mode_of_contact), "Work")); ?> />

                    <label>Work</label>
                </p>
        </td>
    </tr>

    <tr>
        <td class="td_bg">Registration Site</td>
        <td class="td_bg" colspan="2"><span class="input-group">
                <?php
                $specdata        = array(
                    "name"            => "registration_site",
                    "id"            => "registration_site",
                    "size"            => 50,
                    "class"            => "form-control",
                    "value"            => set_value("registration_site", $registration_site)
                );

                echo form_input($specdata);
                ?>
            </span></td>
    </tr>


    <tr>
        <td class="td_bg">Is Active</td>
        <td class="td_bg" colspan="2">
            <div class="input-group">
                <?php echo form_dropdown('is_active', DropdownHelper::yesno_dropdown(), set_value("is_active", $is_active), "class='form-control '") ?>
            </div>
        </td>
    </tr>

    <tr>
        <td class="td_bg">Is Blocked</td>
        <td class="td_bg" colspan="2">
            <div class="input-group">
                <?php echo form_dropdown('is_blocked', DropdownHelper::yesno_dropdown(), set_value("is_blocked", $is_blocked), "class='form-control '") ?>
            </div>
        </td>
    </tr>

    <tr>
        <td class="td_bg">Is Paid</td>
        <td class="td_bg" colspan="2">
            <div class="input-group">
                <?php echo form_dropdown('ispaid', DropdownHelper::yesno_dropdown(), set_value("ispaid", $ispaid), "class='form-control '") ?>
            </div>
        </td>
    </tr>

    <tr>
        <td class="td_bg">Membership Package</td>
        <td class="td_bg" colspan="2">
            <div class="input-group">
                <?php 
                ?>
                <select name="membership_package_id" id="membership_package_id" class="form-control">
                    <option value="" data-per="">Please Select</option>
                    <?php
                    foreach (DropdownHelper::membership_package() as $package_id => $package) {
                        $selected = isset($membership_package_id) && $membership_package_id == $package_id ? 'selected="selected"' : '';
                        echo '<option value="' . $package_id . '" data-per="' . $package['per'] . '" ' . $selected . ' >' . $package['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>
        </td>
    </tr>

    <tr>
        <td class="td_bg">Membership Start Date</td>
        <td class="td_bg" colspan="2">
            <div class="input-group">
                <?php $specdata        = array(
                    "name"            => "membership_date_purchased",
                    "id"            => "membership_date_purchased",
                    "size"            => 50,
                    "class"            => "form-control membership_date",
                    "value"            => set_value("membership_date_purchased", $membership_date_purchased)
                );

                echo form_input($specdata); ?>
                <input type="hidden" name="current_membership_date_purchased" value="<?php echo set_value("membership_date_purchased", $membership_date_purchased); ?>" />
                <input type="hidden" name="membership_id" value="<?php echo $membership_id; ?>">
            </div>
        </td>
    </tr>

    <tr>
        <td class="td_bg">Membership End Date</td>
        <td class="td_bg" colspan="2">
            <div class="input-group">
                <?php $specdata        = array(
                    "name"            => "membership_expiry",
                    "id"            => "membership_expiry",
                    "size"            => 50,
                    "class"            => "form-control membership_date",
                    "value"            => set_value("membership_expiry", $membership_expiry)
                );

                echo form_input($specdata); ?>
                <input type="hidden" name="current_membership_expiry" value="<?php echo set_value("membership_expiry", $membership_expiry); ?>" />
            </div>
        </td>
    </tr>

    <tr class="clear_border_bottom">
        <td height="10" colspan="2">
            <br /><br />
            <strong>Family Members</strong></td>
    </tr>



    <tr>
        <td colspan="2" class="td_bg">
            <table width="100%" class="family_relationships">
                <tr>
                    <td>
                        <table width="100%" class="relationships_data">
                            <tr>
                                <td class="td_bg" style="text-decoration:underline"><strong>Relationship</strong></td>
                                <td class="td_bg" style="text-decoration:underline"><strong>Name</strong></td>
                                <td class="td_bg" style="text-decoration:underline"><strong>Email</strong></td>
                                <td class="td_bg" style="text-decoration:underline"><strong>Age</strong></td>
                                <td class="td_bg" style="text-decoration:underline"><strong>Birth Date</strong></td>
                                <td class="td_bg" style="text-decoration:underline"><strong>Action</strong></td>
                            </tr>
                            <tr height="10">
                                <td colspan="6"></td>
                            </tr>
                            <?php if (count($family) > 0) {
                                ?>
                                <?php foreach ($family as $f) {
                                    ?>
                                    <tr>
                                        <td class="relationship">
                                            <select name="family_relationship" disabled="disabled">
                                                <?php foreach ($family_relationships as $f_r) { ?>
                                                    <option value="<?php echo $f_r['id'] ?>" <?php echo $f_r['id'] == $f['family_relationship'] ? 'selected="selected"' : '' ?>><?php echo $f_r['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td class="family_name">
                                            <input type="text" name="family_name" value="<?php echo $f['family_name']; ?>" disabled="disabled" />
                                        </td>
                                        <td class="family_email">
                                            <input type="text" name="family_email" value="<?php echo $f['family_email']; ?>" disabled="disabled" />
                                        </td>
                                        <td class="family_age">
                                            <input type="number" name="family_age" value="<?php echo $f['family_age']; ?>" min="1" disabled="disabled" />
                                        </td>
                                        <td class="family_birthdate">
                                            <input type="text" class="birthdate_datepicker" name="family_birthdate" value="<?php echo null != $f['family_birthdate'] ? date('Y-m-d', strtotime($f['family_birthdate'])) : ''; ?>" disabled="disabled" autocomplete="off" />
                                        </td>
                                        <td><a href="javascript:;" class="edit-family" data-id="<?php echo $f['id']; ?>">Edit</a> <a href="javascript:;" class="delete-family" data-id="<?php echo $f['id']; ?>">Delete</a></td>
                                    </tr>
                                <?php
                            } ?>
                            <?php
                        } else {
                            ?>
                                <tr class="no-family">
                                    <td colspan="6" align="center" style="font-size:18px;">
                                        <strong>No Family Members</strong>
                                    </td>
                                </tr>
                            <?php
                        } ?>
                        </table>
                    </td>
                </tr>
                <tr height="10">
                    <td colspan="6">
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%">
                            <tr>
                                <td colspan="6"><b>Add new member</b></td>
                            </tr>
                            <tr class="add">
                                <td class="relationship">
                                    <select name="family_relationship">
                                        <?php foreach ($family_relationships as $f_r) { ?>
                                            <option value="<?php echo $f_r['id'] ?>"><?php echo $f_r['name']; ?></option>
                                        <?php
                                    } ?>
                                    </select>
                                </td>
                                <td class="family_name">
                                    <input type="text" name="family_name" value="" />
                                </td>
                                <td class="family_email">
                                    <input type="text" name="family_email" value="" />
                                </td>
                                <td class="family_age">
                                    <input type="number" name="family_age" value="" min="1" />
                                </td>
                                <td class="family_birthdate">
                                    <input type="text" class="birthdate_datepicker" name="family_birthdate" value="" autocomplete="off" />
                                </td>
                                <td><a href="javascript:;" class="save-new-family" data-id="<?php echo $id; ?>">Submit</a></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="savenew_error" style="color:red;"></div>
                                </td>
                            </tr>
                            <tr height="10">
                                <td>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <?php /*<tr class="clear_border_bottom">
	        <td height="10" colspan="2">
                <br /><br />
                <strong>Documents</strong>
            </td>
        </tr>
        
        <tr>
        <td colspan="2" class="td_bg">
            <table width="100%">
                <tr>
                    <td class="td_bg"  style="text-decoration:underline"><strong>Document</strong></td>
                    <td class="td_bg" style="text-decoration:underline"><strong>Uploaded On</strong></td>
                    <td class="td_bg"  style="text-decoration:underline"><strong>Document Type</strong></td>
                </tr>
        	    <?php if (count($document) > 0) {
                ?>
    <?php foreach ($document as $f) {
                    ?>
    <tr>
        <td><?php echo $f['document']; ?></td>
        <td><?php echo $f['uploaded_on']; ?></td>
        <td><?php echo $f['document_type']; ?></td>
    </tr>
    <?php
                }
            } else {
                ?>
    <tr>
        <td colspan="3" align="center" style="font-size:18px;">
            <strong>No Documents</strong>
        </td>
    </tr>
    <?php
            } ?>
</table>
</td>
</tr>*/ ?>

<tr class="clear_border_bottom">
    <td height="10" colspan="2">
        <br /><br />
        <strong>Payments</strong>
    </td>
</tr>

<tr>
    <td colspan="2" class="td_bg">
        <table width="100%">
            <tr>
                <td class="td_bg" style="text-decoration:underline"><strong>Name</strong></td>
                <td class="td_bg" style="text-decoration:underline"><strong>Reason</strong></td>
                <td class="td_bg" style="text-decoration:underline"><strong>Amount</strong></td>
                <td class="td_bg" style="text-decoration:underline"><strong>By</strong></td>
                <td class="td_bg" style="text-decoration:underline"><strong>Reciept</strong></td>
                <td class="td_bg" style="text-decoration:underline"><strong>Date</strong></td>
            </tr>
            <?php if (count($payment) > 0) {
                ?>
                <?php foreach ($payment as $p) {
                    $pay = unserialize($p['paypal_post']);
                    ?>
                    <tr>
                        <td><?php echo isset($pay['first_name']) ? $pay['first_name'] . ' ' : '' . isset($pay['last_name']) ? $pay['last_name'] : ''; ?></td>
                        <td><?php echo isset($pay['item_name']) ? $pay['item_name'] : ''; ?></td>
                        <td><?php echo isset($pay['payment_gross']) ? $pay['payment_gross'] : ''; ?></td>
                        <td><?php echo isset($pay['payer_email']) ? $pay['payer_email'] : ''; ?></td>
                        <td><?php echo isset($pay['txn_id']) ? $pay['txn_id'] : ''; ?></td>
                        <td><?php echo isset($pay['payment_date']) ? date('F d, Y', strtotime($pay['payment_date'])) : ''; ?></td>
                    </tr>
                <?php
            }
            foreach ($card_payment as $p) {
                ?>
                    <tr>
                        <td><?php echo $p['name']; ?></td>
                        <td><?php echo 'donation via payeezy' ?></td>
                        <td><?php echo $p['amount'] ?></td>
                        <td><?php echo $p['email']; ?></td>
                        <td><?php echo $p['transaction_id']; ?></td>
                        <td><?php echo  date('F d, Y', strtotime($p['date'])); ?></td>
                    </tr>
                <?php
            }
        } else {
            ?>
                <tr>
                    <td colspan="6" align="center" style="font-size:18px;">
                        <strong>No Payments</strong>
                    </td>
                </tr>
            <?php
        } ?>
        </table>
    </td>
</tr>

<tr>
    <td class="td_bg">&nbsp;</td>
    <td class="td_bg" colspan="2">
        <input type="hidden" value="<?php echo set_value("id", $id); ?>" name="hdn_id" />
    </td>
</tr>


</table>
<input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
<input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />

<div class="crud_controls">
    <button type="submit" data-operationid="manageuserssave" class="btn btn-warning btn-flat"><?php echo lang_line("text_save"); ?></button>
    <a class="btn btn-danger btn-flat" data-operationid="manageusersview" href="<?php echo site_url($_directory . "controls/view"); ?>">
        <?php echo lang_line("text_cancel"); ?>
    </a>
</div>

</form>