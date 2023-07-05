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
            <td class="td_bg fieldKey">Name <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue">
                <div class="input-group">
                <?php
                $specdata = array(
                    "name" => "name",
                    "id" => "name",
                    "value" => set_value("name", $name),
                    "class" => 'form-control',
                    "placeholder" => "Name *",
                    "size" => 60
                );
                echo form_input($specdata);
                ?>
                </div>
            </td>
        </tr>
        
        <tr>
            <td class="td_bg fieldKey">Address <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue">
                <div class="input-group">
                <?php
                $specdata = array(
                    "name" => "address",
                    "id" => "address",
                    "value" => set_value("address", $address),
                    "class" => 'form-control',
                    "placeholder" => "Address *",
                    "cols" => 80,
                    "rows" => 5
                );

                echo form_textarea($specdata);
                ?>
                </div>
            </td>
        </tr>
        
        <tr>
            <td class="td_bg fieldKey"> Contact <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue">
                <div class="input-group">
                    <?php
                    $specdata		= array("name"			=> "contact_number",
                                            "id"			=> "contact_number",
                                            "value"			=> set_value("contact_number",$contact_number),
                                            "class"			=> "form-control contact_number",
                                            "placeholder"	=> "Cellphone Number *",
                                            "size" => 60
                                        );	
                    
                    echo form_input($specdata);
                    echo form_error("contact_number");
                    ?>
                </div>
            </td>
        </tr>
        
        <tr>
            <td class="td_bg fieldKey">Email <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue">
                <div class="input-group">
                <?php
                $specdata		= array("name"			=> "email",
                                        "id"			=> "email",
                                        "value"			=> set_value("email", $email),
                                        "class"			=> "form-control email",
                                        "placeholder"	=> "Email *",
                                        "size" => 60
                                    );
                
                echo form_input($specdata);
                echo form_error("email");
                ?>
                </div>
            </td>
		</tr>
        
        <tr>
            <td class="td_bg fieldKey">Occupation <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue">
                <div class="input-group">
                <?php
                $specdata		= array("name"			=> "occupation",
                                        "id"			=> "occupation",
                                        "value"			=> set_value("occupation", $occupation),
                                        "class"			=> "form-control occupation",
                                        "placeholder"	=> "Occupation *",
                                        "size" => 60
                                    );
                
                echo form_input($specdata);
                echo form_error("occupation");
                ?>
                </div>
            </td>
		</tr>
        
        <tr>
            <td class="td_bg fieldKey">Specialities <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue">
                <div class="input-group">
                <?php
                $specdata		= array("name"			=> "specialities",
                                        "id"			=> "specialities",
                                        "value"			=> set_value("specialities", $specialities),
                                        "class"			=> "form-control specialities",
                                        "placeholder"	=> "Specialities *",
                                        "size" => 60
                                    );
                
                echo form_input($specdata);
                echo form_error("specialities");
                ?>
                </div>
            </td>
		</tr>
        
        <tr>
            <td class="td_bg fieldKey">Citizenship <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue">
                <div class="input-group">
                <?php
                $specdata		= array("name"			=> "citizenship",
                                        "id"			=> "citizenship",
                                        "value"			=> set_value("citizenship", $citizenship),
                                        "class"			=> "form-control citizenship",
                                        "placeholder"	=> "Citizenship *",
                                        "size" => 60
                                    );
                
                echo form_input($specdata);
                echo form_error("citizenship");
                ?>
                </div>
            </td>
		</tr>
        
        <tr>
            <td class="td_bg fieldKey">Date of Birth <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue">
                <div class="input-group">
                <?php
                $specdata		= array("name"			=> "date_of_birth",
                                        "id"			=> "date_of_birth",
                                        "value"			=> set_value("date_of_birth", $date_of_birth),
                                        "class"			=> "form-control date_of_birth datepicker",
                                        "placeholder"	=> "Date of birth *",
                                        "size" => 63
                                    );
                
                echo form_input($specdata);
                echo form_error("date_of_birth");
                ?>
                </div>
            </td>
		</tr>
        
        <tr>
            <td class="td_bg fieldKey">Passport Number <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue">
                <div class="input-group">
                <?php
                $specdata		= array("name"			=> "passport_number",
                                        "id"			=> "passport_number",
                                        "value"			=> set_value("passport_number", $passport_number),
                                        "class"			=> "form-control passport_number",
                                        "placeholder"	=> "Passport Number *",
                                        "size" => 60
                                    );
                
                echo form_input($specdata);
                echo form_error("passport_number");
                ?>
                </div>
            </td>
		</tr>
        
        <tr>
            <td class="td_bg fieldKey">Date of Issue <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue">
                <div class="input-group">
                <?php
                $specdata		= array("name"			=> "date_of_issue",
                                        "id"			=> "date_of_issue",
                                        "value"			=> set_value("date_of_issue", $date_of_issue),
                                        "class"			=> "form-control date_of_issue datepicker",
                                        "placeholder"	=> "Date of Issue *",
                                        "size" => 63
                                    );
                
                echo form_input($specdata);
                echo form_error("date_of_issue");
                ?>
                </div>
            </td>
		</tr>
        
        <tr>
            <td class="td_bg fieldKey">Place of Issue <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue">
                <div class="input-group">
                <?php
                $specdata		= array("name"			=> "place_of_issue",
                                        "id"			=> "place_of_issue",
                                        "value"			=> set_value("place_of_issue", $place_of_issue),
                                        "class"			=> "form-control place_of_issue",
                                        "placeholder"	=> "Place of Issue *",
                                        "size" => 60
                                    );
                
                echo form_input($specdata);
                echo form_error("place_of_issue");
                ?>
                </div>
            </td>
		</tr>
        
        <tr>
            <td class="td_bg fieldKey">Date of Expiration <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue">
                <div class="input-group">
                <?php
                $specdata		= array("name"			=> "date_of_expiration",
                                        "id"			=> "date_of_expiration",
                                        "value"			=> set_value("date_of_expiration", $date_of_expiration),
                                        "class"			=> "form-control date_of_expiration datepicker",
                                        "placeholder"	=> "Date of Expiration *",
                                        "size" => 63
                                    );
                
                echo form_input($specdata);
                echo form_error("date_of_expiration");
                ?>
                </div>
            </td>
        </tr>
        
        <tr>
            <td class="td_bg fieldKey">Marital Status <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue">
                <div class="input-group">
                    <label class="fl_lft m_rite10 m_top15">
                        <input type="radio" name="marital_status" class="marital_status" value="single" <?php echo set_radio("marital_status", "single", format_bool( set_value("marital_status",$marital_status), "single"));?>  />
                        Single
                    </label>
                    &nbsp;
                    <label class="fl_lft m_rite10 m_top15">
                        <input type="radio" name="marital_status" class="marital_status" value="married" <?php echo set_radio("marital_status", "married", format_bool( set_value("marital_status",$marital_status), "married"));?>  />
                        Married
                    </label>
                    <?php echo form_error( "marital_status" ); ?>
                </div>
            </td>
		</tr>
        
        <tr>
            <td class="td_bg fieldKey">Tshirt Size <?php echo required_field();?></td>
            <td class="td_bg fieldValue">
                <div class="input-group">
                <?php
                $specdata		= array("name"			=> "tshirt_size",
                                        "id"			=> "tshirt_size",
                                        "value"			=> set_value("tshirt_size", $tshirt_size),
                                        "class"			=> "form-control tshirt_size",
                                        "placeholder"	=> "Tshirt Size *",
                                        "size" => 60
                                    );
                
                echo form_input($specdata);
                echo form_error("tshirt_size");
                ?>
                </div>
            </td>
        </tr>
        
        <tr>
            <td class="td_bg fieldKey">Why do you want to go on emergency relief missions? <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue">
                <div class="input-group">
                <?php
                $specdata		= array("name"			=> "question_why_to_go_on_emer_relief_mission",
                                        "id"			=> "question_why_to_go_on_emer_relief_mission",
                                        "value"			=> set_value("question_why_to_go_on_emer_relief_mission", $question_why_to_go_on_emer_relief_mission),
                                        "class"			=> "form-control question_why_to_go_on_emer_relief_mission",
                                        "placeholder"	=> "Why do you want to go on emergency relief missions?",
                                        "cols" => 80,
                                        "rows" => 5
                                    );
                
                echo form_textarea($specdata);
                echo form_error("question_why_to_go_on_emer_relief_mission");
                ?>
                </div>
            </td>
        </tr>
        
        <tr>
            <td class="td_bg fieldKey">How much time would you be able to take off at a short notice (eg 2 weeks; 10 days): <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue">
                <div class="input-group">
                <?php
                $specdata		= array("name"			=> "question_foreign_language_skills",
                                        "id"			=> "question_foreign_language_skills",
                                        "value"			=> set_value("question_foreign_language_skills", $question_foreign_language_skills),
                                        "class"			=> "form-control question_foreign_language_skills",
                                        "placeholder"	=> "How much time would you be able to take off at a short notice (eg 2 weeks; 10 days):  *",
                                        "cols" => 80,
                                        "rows" => 5
                                    );
                
                echo form_textarea($specdata);
                echo form_error("question_foreign_language_skills");
                ?>
                </div>
            </td>
        </tr>
        
        <tr>
            <td class="td_bg fieldKey">Do you have any foreign language skills? <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue">
                <div class="input-group">
                <?php
                $specdata		= array("name"			=> "question_time_to_take_off_short_notice",
                                        "id"			=> "question_time_to_take_off_short_notice",
                                        "value"			=> set_value("question_time_to_take_off_short_notice", $question_time_to_take_off_short_notice),
                                        "class"			=> "form-control question_time_to_take_off_short_notice",
                                        "placeholder"	=> "Do you have any foreign language skills?   *",
                                        "cols" => 80,
                                        "rows" => 5
                                    );
                
                echo form_textarea($specdata);
                echo form_error("question_time_to_take_off_short_notice");
                ?>
                </div>
            </td>
        </tr>
        
        <tr>
            <td class="td_bg fieldKey">What other skills do you have that might be utilized on emergency relief missions? <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue">
                <div class="input-group">
                <?php
                $specdata		= array("name"			=> "question_any_other_skills",
                                        "id"			=> "question_any_other_skills",
                                        "value"			=> set_value("question_any_other_skills", $question_any_other_skills),
                                        "class"			=> "form-control question_any_other_skills",
                                        "placeholder"	=> "What other skills do you have that might be utilized on emergency relief missions?    *",
                                        "cols" => 80,
                                        "rows" => 5
                                    );
                
                echo form_textarea($specdata);
                echo form_error("question_any_other_skills");
                ?>
                </div>
            </td>
        </tr>
       
        <tr>
            <td class="td_bg fieldKey">Have you ever been on an emergency relief operations or medical mission before? If so, where did you go and what was your experience like? <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue">
                <div class="input-group">
                <?php
                $specdata		= array("name"			=> "question_attended_emer_relief_before",
                                        "id"			=> "question_attended_emer_relief_before",
                                        "value"			=> set_value("question_attended_emer_relief_before", $question_attended_emer_relief_before),
                                        "class"			=> "form-control question_attended_emer_relief_before",
                                        "placeholder"	=> "Have you ever been on an emergency relief operations or medical mission before? If so, where did you go and what was your experience like?    *",
                                        "cols" => 80,
                                        "rows" => 5
                                    );
                
                echo form_textarea($specdata);
                echo form_error("question_attended_emer_relief_before");
                ?>
                </div>
            </td>
        </tr>
        
        <tr>
            <td class="td_bg fieldKey">How much time would you be able to take off at a short notice (eg 2 weeks; 10 days): <?php echo required_field(); ?></td>
            <td class="td_bg fieldValue">
                <div class="input-group">
                <?php
                $specdata		= array("name"			=> "question_time_to_take_off_short_notice",
                                        "id"			=> "question_time_to_take_off_short_notice",
                                        "value"			=> set_value("question_time_to_take_off_short_notice", $question_time_to_take_off_short_notice),
                                        "class"			=> "form-control question_time_to_take_off_short_notice",
                                        "placeholder"	=> "How much time would you be able to take off at a short notice (eg 2 weeks; 10 days):  *",
                                        "cols" => 80,
                                        "rows" => 5
                                    );
                
                echo form_textarea($specdata);
                echo form_error("question_time_to_take_off_short_notice");
                ?>
                </div>
            </td>
        </tr>
        
        <tr>
            <td class="td_bg fieldKey">Do you know of any reason that you may have difficulty functioning in a foreign country?  <?php echo required_field();?></td>
            <td class="td_bg fieldValue">
                <div class="input-group">
                <?php
                $specdata		= array("name"			=> "question_any_difficulty_in_foreign_country",
                                        "id"			=> "question_any_difficulty_in_foreign_country",
                                        "value"			=> set_value("question_any_difficulty_in_foreign_country", $question_any_difficulty_in_foreign_country),
                                        "class"			=> "form-control question_any_difficulty_in_foreign_country",
                                        "placeholder"	=> "Do you know of any reason that you may have difficulty functioning in a foreign country? *",
                                        "cols" => 80,
                                        "rows" => 5
                                    );
                
                echo form_textarea($specdata);
                echo form_error("question_any_difficulty_in_foreign_country");
                ?>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <h3>Medical Information</h3>
            </td>
        </tr>
        <tr>
            <td class="td_bg fieldKey">Is there any medical or physical reason why you would have to restrict yourself from strenuous activity?  <?php echo required_field();?></td>
            <td class="td_bg fieldValue">
                <label class="fl_lft m_rite10 m_bottom5">
                    <input type="radio" name="medical_physical_status" class="medical_physical_status" value="1" onclick="closeDisabled('input[name=\'medical_physical_status\']:checked', 'textarea[name=\'medical_physical_reason\']', '0', true)" <?php echo set_radio("medical_physical_status", "1", format_bool( set_value("medical_physical_status",$medical_physical_status), "1"));?>  />
                    Yes
                </label>
                
                <label class="fl_lft m_rite10 m_bottom5">
                    <input type="radio" name="medical_physical_status" class="medical_physical_status" value="0" onclick="closeDisabled('input[name=\'medical_physical_status\']:checked', 'textarea[name=\'medical_physical_reason\']', '0', true)" <?php echo set_radio("medical_physical_status", "0", format_bool( set_value("medical_physical_status",$medical_physical_status), "0"));?>  />
                    No
                </label>
                <br/>
                <label class="hwrap m_bottom5">If <strong>Yes</strong>, please explain:</label>
                <br/>
                <?php
                $TMP_name		= "medical_physical_reason";
                $specdata		= array(
                    "name"			=> $TMP_name,
                    "id"			=> $TMP_name,
                    "value"			=> set_value( $TMP_name ),
                    "class"			=> set_class( $TMP_name ),
                    "disabled"		=> "disabled",
                    "placeholder"	=> "Reason?",
                    "cols" => 80,
                    "rows" => 5
                );
                
                echo form_textarea($specdata);
                echo form_error( $TMP_name );
                ?>
        </td>
    </tr>

    <tr>
        <td class="td_bg fieldKey">Please list any medications that you take regularly:<?php echo required_field();?></td>
        <td class="td_bg fieldValue">
            <div class="input-group">
            <?php
            $specdata		= array("name"			=> "list_any_medications",
                                    "id"			=> "list_any_medications",
                                    "value"			=> set_value("list_any_medications", $list_any_medications),
                                    "class"			=> "form-control list_any_medications",
                                    "placeholder"	=> "Please list any medications that you take regularly: *",
                                    "cols" => 80,
                                    "rows" => 5
                                );
            
            echo form_textarea($specdata);
            echo form_error("list_any_medications");
            ?>
            </div>
        </td>
    </tr>

    <tr>
        <td class="td_bg fieldKey">Please list any allergies you have to food, medicine or the environment:<?php echo required_field();?></td>
        <td class="td_bg fieldValue">
            <div class="input-group">
            <?php
            $specdata		= array("name"			=> "list_any_allergies",
                                    "id"			=> "list_any_allergies",
                                    "value"			=> set_value("list_any_allergies", $list_any_allergies),
                                    "class"			=> "form-control list_any_allergies",
                                    "placeholder"	=> "Please list any allergies you have to food, medicine or the environment: *",
                                    "cols" => 80,
                                    "rows" => 5
                                );
            
            echo form_textarea($specdata);
            echo form_error("list_any_allergies");
            ?>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <h3>Primary Emergency Contact</h3>
        </td>
    </tr>
    <tr>
        <td class="td_bg fieldKey">Name: <?php echo required_field();?></td>
        <td class="td_bg fieldValue">
            <div class="input-group">
            <?php
            $specdata		= array("name"			=> "primary_emer_contact_name",
                                    "id"			=> "primary_emer_contact_name",
                                    "value"			=> set_value("primary_emer_contact_name", $primary_emer_contact_name),
                                    "class"			=> "form-control primary_emer_contact_name",
                                    "placeholder"	=> "Name: *",
                                    "size" => 60
                                );
            
            echo form_input($specdata);
            echo form_error("primary_emer_contact_name");
            ?>
            </div>
        </td>
    </tr>
    <tr>
        <td class="td_bg fieldKey">Relationship: <?php echo required_field();?></td>
        <td class="td_bg fieldValue">
            <div class="input-group">
            <?php
            $specdata		= array("name"			=> "primary_emer_contact_relationship",
                                    "id"			=> "primary_emer_contact_relationship",
                                    "value"			=> set_value("primary_emer_contact_relationship", $primary_emer_contact_relationship),
                                    "class"			=> "form-control primary_emer_contact_relationship",
                                    "placeholder"	=> "Relationship: *",
                                    "size" => 60
                                );
            
            echo form_input($specdata);
            echo form_error("primary_emer_contact_relationship");
            ?>
            </div>
        </td>
    </tr>
    <tr>
        <td class="td_bg fieldKey">Address: <?php echo required_field();?></td>
        <td class="td_bg fieldValue">
            <div class="input-group">
            <?php
            $specdata		= array("name"			=> "primary_emer_contact_address",
                                    "id"			=> "primary_emer_contact_address",
                                    "value"			=> set_value("primary_emer_contact_address", $primary_emer_contact_address),
                                    "class"			=> "form-control primary_emer_contact_address",
                                    "placeholder"	=> "Address: *",
                                    "cols" => 80,
                                    "rows" => 5
                                );
            
            echo form_textarea($specdata);
            echo form_error("primary_emer_contact_address");
            ?>
            </div>
        </td>
    </tr>
    <tr>
        <td class="td_bg fieldKey">Telephone: <?php echo required_field();?></td>
        <td class="td_bg fieldValue">
            <div class="input-group">
            <?php
            $specdata		= array("name"			=> "primary_emer_contact_telephone",
                                    "id"			=> "primary_emer_contact_telephone",
                                    "value"			=> set_value("primary_emer_contact_telephone", $primary_emer_contact_telephone),
                                    "class"			=> "form-control primary_emer_contact_telephone",
                                    "placeholder"	=> "Telephone: *",
                                    "size" => 60
                                );
            
            echo form_input($specdata);
            echo form_error("primary_emer_contact_telephone");
            ?>
            </div>
        </td>
    </tr>
    <tr>
        <td class="td_bg fieldKey">Email: <?php echo required_field();?></td>
        <td class="td_bg fieldValue">
            <div class="input-group">
            <?php
            $specdata		= array("name"			=> "primary_emer_contact_email",
                                    "id"			=> "primary_emer_contact_email",
                                    "value"			=> set_value("primary_emer_contact_email", $primary_emer_contact_email),
                                    "class"			=> "form-control primary_emer_contact_email",
                                    "placeholder"	=> "Email: *",
                                    "size" => 60
                                );
            
            echo form_input($specdata);
            echo form_error("primary_emer_contact_email");
            ?>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <h3>Secondary Emergency Contact</h3>
        </td>
    </tr>
    <tr>
        <td class="td_bg fieldKey">Name: <?php echo required_field();?></td>
        <td class="td_bg fieldValue">
            <div class="input-group">
                <?php
            $specdata		= array("name"			=> "secondary_emer_contact_name",
            "id"			=> "secondary_emer_contact_name",
            "value"			=> set_value("secondary_emer_contact_name", $secondary_emer_contact_name),
            "class"			=> "form-control secondary_emer_contact_name",
            "placeholder"	=> "Name: *",
            "size" => 60
        );
            
            echo form_input($specdata);
            echo form_error("secondary_emer_contact_name");
            ?>
            </div>
        </td>
    </tr>
    <tr>
        <td class="td_bg fieldKey">Relationship: <?php echo required_field();?></td>
        <td class="td_bg fieldValue">
            <div class="input-group">
                <?php
            $specdata		= array("name"			=> "secondary_emer_contact_relationship",
                                    "id"			=> "secondary_emer_contact_relationship",
                                    "value"			=> set_value("secondary_emer_contact_relationship", $secondary_emer_contact_relationship),
                                    "class"			=> "form-control secondary_emer_contact_relationship",
                                    "placeholder"	=> "Relationship: *",
                                    "size" => 60
                                );
            
            echo form_input($specdata);
            echo form_error("secondary_emer_contact_relationship");
            ?>
            </div>
        </td>
    </tr>
    <tr>
        <td class="td_bg fieldKey">Address: <?php echo required_field();?></td>
        <td class="td_bg fieldValue">
            <div class="input-group">
            <?php
            $specdata		= array("name"			=> "secondary_emer_contact_address",
                                    "id"			=> "secondary_emer_contact_address",
                                    "value"			=> set_value("secondary_emer_contact_address", $secondary_emer_contact_address),
                                    "class"			=> "form-control secondary_emer_contact_address",
                                    "placeholder"	=> "Address: *",
                                    "cols" => 80,
                                    "rows" => 5
                                );
                                
                                echo form_textarea($specdata);
                                echo form_error("secondary_emer_contact_address");
                                ?>
            </div>
        </td>
    </tr>
    <tr>
        <td class="td_bg fieldKey">Telephone: <?php echo required_field();?></td>
        <td class="td_bg fieldValue">
            <div class="input-group">
                <?php
            $specdata		= array("name"			=> "secondary_emer_contact_telephone",
            "id"			=> "secondary_emer_contact_telephone",
            "value"			=> set_value("secondary_emer_contact_telephone", $secondary_emer_contact_telephone),
            "class"			=> "form-control secondary_emer_contact_telephone",
            "placeholder"	=> "Telephone: *",
            "size" => 60
        );
        
        echo form_input($specdata);
        echo form_error("secondary_emer_contact_telephone");
        ?>
            </div>
        </td>
    </tr>
    <tr>
        <td class="td_bg fieldKey">Email: <?php echo required_field();?></td>
        <td class="td_bg fieldValue">
            <div class="input-group">
                <?php
            $specdata		= array("name"			=> "secondary_emer_contact_email",
            "id"			=> "secondary_emer_contact_email",
            "value"			=> set_value("secondary_emer_contact_email", $secondary_emer_contact_email),
            "class"			=> "form-control secondary_emer_contact_email",
            "placeholder"	=> "Email: *",
            "size" => 60
        );
        
        echo form_input($specdata);
        echo form_error("secondary_emer_contact_email");
        ?>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <h3>Biography</h3>
        </td>
    </tr>
    <tr>
        <td class="td_bg fieldKey">Biography: <?php echo required_field();?></td>
        <td class="td_bg fieldValue">
            <div class="input-group">
            <?php
            $specdata		= array("name"			=> "short_biography",
                                    "id"			=> "short_biography",
                                    "value"			=> set_value("short_biography", $short_biography),
                                    "class"			=> "form-control short_biography",
                                    "placeholder"	=> "Please write a short auto-biography (no more than 300 words) below, and send it by e-mail with your completed application. The bios will be shared to introduce everyone before deployment: *",
                                    "cols" => 80,
                                    "rows" => 5
                                );
            
            echo form_textarea($specdata);
            echo form_error("short_biography");
            ?>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <h3>Documents</h3>
        </td>
    </tr>
    <tr>
        <td class="td_bg fieldKey">Resume: <?php echo required_field();?></td>
        <td class="td_bg fieldValue">
            click here to <a href="<?php echo site_url().$resume ?>" download="download">download</a>
        </td>
    </tr>
    <tr>
        <td class="td_bg fieldKey">Passport: <?php echo required_field();?></td>
        <td class="td_bg fieldValue">
            click here to <a href="<?php echo site_url().$passport ?>" download="download">download</a>
        </td>
    </tr>
    <tr>
        <td class="td_bg fieldKey">Photo: <?php echo required_field();?></td>
        <td class="td_bg fieldValue">
            click here to <a href="<?php echo site_url().$photo_image ?>" download="download">download</a>
        </td>
    </tr>
    <tr>
        <td class="td_bg fieldKey">Signature: <?php echo required_field();?></td>
        <td class="td_bg fieldValue">
            <?php if ( $signature != "" ){?>click here to <a href="<?php echo site_url()."assets/files/emergency_roster/".$signature ?>" download="download">download</a><?php }?>
        </td>
    </tr>
    <tr>
        <td class="td_bg fieldKey">Parent/Guardian Signature: <?php echo required_field();?></td>
        <td class="td_bg fieldValue">
            <?php if ( $parent_signature != "" ){?>click here to <a href="<?php echo site_url()."assets/files/emergency_roster/".$parent_signature ?>" download="download">download</a><?php }?>
        </td>
    </tr>

    </table>
    <input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
    <input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />
    
    <div class="crud_controls">
        <button type="submit" data-operationid="manageemergencyrostersave" class="btn btn-warning btn-flat"><?php echo lang_line("text_save"); ?></button>
        <a class="btn btn-danger btn-flat" data-operationid="manageemergencyrosterview" href="<?php echo site_url($_directory . "controls/view"); ?>">
            <?php echo lang_line("text_cancel"); ?>
        </a>
    </div>

</form>

<script>
    $('input[name="preffered_mode_of_contact"]').on('ifChanged', function (event) {
        $('.home_phone').hide();
		$('.mobile_phone').hide();
		$('.work_phone').hide();
		$('.'+$(this).val().toLowerCase()+'_phone').show();
    });
</script>