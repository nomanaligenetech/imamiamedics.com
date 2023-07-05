<a id="hash_emergency_roster_form" name="hash_emergency_roster_form"></a>
<h2 class="h2Style1"><?php echo lang_line("text_delegate_application"); ?> </h2>
<?php
if ($this->session->userdata('user_logged_in')) {

	if ($this->functions->_user_logged_in_details("is_member")) {
		$attributes 			= array(
			"method"		=> "post",
			"name"			=> "form1",
			"enctype"		=> "multipart/form-data",
			"onsubmit"      => "submit_with_hash('form1', 'hash_emergency_roster_form',true)"
		);

		echo form_open(site_url(uri_string()), $attributes);
		?>

<div class="form_sec fl_lft w_100">

    <div class="field_row w_100">
        <?php
		$specdata		= array(
			"name"			=> "name",
			"id"			=> "name",
			"value"			=> set_value("name", $name),
			"class"			=> set_class("name"),
			"placeholder"	=> lang_line("text_name") . " *"
		);

		echo form_input($specdata);
		echo form_error("name");
		?>
    </div>

    <div class="field_row w_100">
        <?php
		$specdata		= array(
			"name"			=> "address",
			"id"			=> "address",
			"value"			=> set_value("address", $home_full_address),
			"class"			=> set_class("address"),
			"placeholder"	=> lang_line("mailing_address") . " *"
		);

		echo form_textarea($specdata);
		echo form_error("address");
		?>
    </div>

    <div class="field_row w_50 p_right10">
        <div style="float:left;width:auto;margin-right:5px;">
            <input type="radio" name="preffered_mode_of_contact" class="preffered_mode_of_contact" value="Home" <?php echo set_radio("preffered_mode_of_contact", "Home", format_bool(set_value("preffered_mode_of_contact", $preffered_mode_of_contact), "Home")); ?> />

            <label>Home</label>
        </div>
        <div style="float:left;width:auto;margin-right:5px;">
            <input type="radio" name="preffered_mode_of_contact" class="preffered_mode_of_contact" value="Mobile" <?php echo set_radio("preffered_mode_of_contact", "Mobile", format_bool(set_value("preffered_mode_of_contact", $preffered_mode_of_contact), "Mobile")); ?> />

            <label>Mobile</label>
        </div>
        <div style="float:left;width:auto;margin-right:5px;">
            <input type="radio" name="preffered_mode_of_contact" class="preffered_mode_of_contact" value="Work" <?php echo set_radio("preffered_mode_of_contact", "Work", format_bool(set_value("preffered_mode_of_contact", $preffered_mode_of_contact), "Work")); ?> />

            <label>Work</label>
        </div>
        <div class="mobile_phone" style="<?php echo $preffered_mode_of_contact != 'Mobile' ? 'display:none;' : ''; ?>">
            <?php
			$specdata		= array(
				"name"			=> "cellphone_number",
				"id"			=> "cellphone_number",
				"value"			=> set_value("cellphone_number", $cellphone_number),
				"class"			=> set_class("cellphone_number"),
				"placeholder"	=> lang_line("text_cellphonenumber") . " *"
			);

			echo form_input($specdata);
			echo form_error("cellphone_number");
			?>
        </div>
        <div class="home_phone" style="<?php echo $preffered_mode_of_contact != 'Home' ? 'display:none;' : ''; ?>">
            <?php
			$specdata		= array(
				"name"			=> "home_phone_number",
				"id"			=> "home_phone_number",
				"value"			=> set_value("home_phone_number", $home_phone_number),
				"class"			=> set_class("home_phone_number"),
				"placeholder"	=> lang_line("text_homephoneno") . " *"
			);

			echo form_input($specdata);
			echo form_error("home_phone_number");
			?>
        </div>
        <div class="work_phone" style="<?php echo $preffered_mode_of_contact != 'Office' ? 'display:none;' : ''; ?>">
            <?php
			$specdata		= array(
				"name"			=> "office_phone_number",
				"id"			=> "office_phone_number",
				"value"			=> set_value("office_phone_number", $office_phone_number),
				"class"			=> set_class("office_phone_number"),
				"placeholder"	=> lang_line("text_office_phone") . " *"
			);

			echo form_input($specdata);
			echo form_error("office_phone_number");
			?>
        </div>
    </div>

    <div class="field_row w_50 p_left10" style="vertical-align:bottom;">
        <?php
		$specdata		= array(
			"name"			=> "email",
			"id"			=> "email",
			"value"			=> set_value("email", $email),
			"class"			=> set_class("email"),
			"placeholder"	=> lang_line("text_email") . " *"
		);

		echo form_input($specdata);
		echo form_error("email");
		?>
    </div>

    <div class="field_row w_50 p_right10">

        <?php
		$TMP_name		= "occupation";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name, $occupation),
			"class"			=> set_class($TMP_name),
			"placeholder"	=>  lang_line("label_arbaeen_form_occupation") . " *"
		);

		echo form_input($specdata);
		echo form_error($TMP_name);
		?>
    </div>

    <div class="field_row w_50 p_left10">

        <?php
		$TMP_name		= "specialities";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name, $TMP_name),
			"class"			=> set_class($TMP_name),
			"placeholder"	=> lang_line("text_specialities"). " *"
		);

		echo form_input($specdata);
		echo form_error($TMP_name);
		?>
    </div>

    <div class="field_row w_50 p_right10">

        <?php
		$TMP_name		= "citizenship";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name, $$TMP_name),
			"class"			=> set_class($TMP_name),
			"placeholder"	=> lang_line("text_citizenship"). " *"
		);

		echo form_input($specdata);
		echo form_error($TMP_name);
		?>
    </div>

    <div class="field_row w_50 p_left10">

        <?php
		$TMP_name		= "date_of_birth";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name, $$TMP_name),
			"class"			=> set_class($TMP_name) . " datepicker",
			"placeholder"	=> lang_line("label_arbaeen_form_DOB") . " (dd-mm-yy) *"
		);

		echo form_input($specdata);
		echo form_error($TMP_name);
		?>
    </div>

    <div class="field_row w_50 p_right10">

        <?php
		$TMP_name		= "passport_number";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name),
			"class"			=> set_class($TMP_name),
			"placeholder"	=> lang_line("text_passportno"). " *"
		);

		echo form_input($specdata);
		echo form_error($TMP_name);
		?>
    </div>

    <div class="field_row w_50 p_left10">

        <?php
		$TMP_name		= "date_of_issue";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name),
			"class"			=> set_class($TMP_name) . " datepicker",
			"placeholder"	=> lang_line("text_dateofissue") . " (dd-mm-yy) *"
		);

		echo form_input($specdata);
		echo form_error($TMP_name);
		?>
    </div>

    <div class="field_row w_50 p_right10">

        <?php
		$TMP_name		= "place_of_issue";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name),
			"class"			=> set_class($TMP_name),
			"placeholder"	=> lang_line("text_placeofissue") . " *"
		);

		echo form_input($specdata);
		echo form_error($TMP_name);
		?>
    </div>

    <div class="field_row w_50 p_left10">

        <?php
		$TMP_name		= "date_of_expiration";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name),
			"class"			=> set_class($TMP_name) . " datepicker",
			"placeholder"	=> lang_line("text_dateofexpiry") . " (dd-mm-yy) *"
		);

		echo form_input($specdata);
		echo form_error($TMP_name);
		?>
    </div>

    <div class="field_row w_50 p_right10">
        <label class="fl_lft m_rite10 m_top15">
            <input type="radio" name="marital_status" class="marital_status" value="single" <?php echo set_radio("marital_status", "single", format_bool(set_value("marital_status"), "single")); ?> />
            Single
        </label>

        <label class="fl_lft m_rite10 m_top15">
            <input type="radio" name="marital_status" class="marital_status" value="married" <?php echo set_radio("marital_status", "married", format_bool(set_value("marital_status"), "married")); ?> />
            Married
        </label>
        <?php echo form_error("marital_status"); ?>
    </div>

    <div class="field_row w_50 p_left10">

        <?php
		$TMP_name		= "tshirt_size";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name),
			"class"			=> set_class($TMP_name),
			"placeholder"	=> lang_line("text_tshirtsize") . " *"
		);

		echo form_input($specdata);
		echo form_error($TMP_name);
		?>
    </div>

    <div class="field_row w_100 ">

        <?php
		$TMP_name		= "question_why_to_go_on_emer_relief_mission";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name),
			"class"			=> set_class($TMP_name),
			"placeholder"	=> "Why do you want to go on emergency relief missions?  "
		);

		echo form_textarea($specdata);
		echo form_error($TMP_name);
		?>
    </div>

    <div class="field_row w_100 ">

        <?php
		$TMP_name		= "question_time_to_take_off_short_notice";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name),
			"class"			=> set_class($TMP_name),
			"placeholder"	=> "How much time would you be able to take off at a short notice (eg 2 weeks; 10 days):  *"
		);

		echo form_textarea($specdata);
		echo form_error($TMP_name);
		?>
    </div>

    <div class="field_row w_100 ">

        <?php
		$TMP_name		= "question_foreign_language_skills";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name),
			"class"			=> set_class($TMP_name),
			"placeholder"	=> "Do you have any foreign language skills?   *"
		);

		echo form_textarea($specdata);
		echo form_error($TMP_name);
		?>
    </div>

    <div class="field_row w_100 ">

        <?php
		$TMP_name		= "question_any_other_skills";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name),
			"class"			=> set_class($TMP_name),
			"placeholder"	=> "What other skills do you have that might be utilized on emergency relief missions?    *"
		);

		echo form_textarea($specdata);
		echo form_error($TMP_name);
		?>
    </div>

    <div class="field_row w_100 ">

        <?php
		$TMP_name		= "question_attended_emer_relief_before";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name),
			"class"			=> set_class($TMP_name),
			"placeholder"	=> "Have you ever been on an emergency relief operations or medical mission before? If so, where did you go and what was your experience like?    *"
		);

		echo form_textarea($specdata);
		echo form_error($TMP_name);
		?>
    </div>

    <div class="field_row w_100 ">

        <?php
		$TMP_name		= "question_any_difficulty_in_foreign_country";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name),
			"class"			=> set_class($TMP_name),
			"placeholder"	=> "Do you know of any reason that you may have difficulty functioning in a foreign country?   *"
		);

		echo form_textarea($specdata);
		echo form_error($TMP_name);
		?>
    </div>

    <h2 class="h2Style1">Medical Information</h2>
    <div class="field_row w_100">
        <label class="hwrap m_bottom5">Is there any medical or physical reason why you would have to restrict yourself from strenuous activity?</label>

        <label class="fl_lft m_rite10 m_bottom5">
            <input type="radio" name="medical_physical_status" class="medical_physical_status" value="1" onclick="closeDisabled('input[name=\'medical_physical_status\']:checked', 'textarea[name=\'medical_physical_reason\']', '0', true)" <?php echo set_radio("medical_physical_status", "1", format_bool(set_value("medical_physical_status"), "1")); ?> />
            Yes
        </label>

        <label class="fl_lft m_rite10 m_bottom5">
            <input type="radio" name="medical_physical_status" class="medical_physical_status" value="0" onclick="closeDisabled('input[name=\'medical_physical_status\']:checked', 'textarea[name=\'medical_physical_reason\']', '0', true)" <?php echo set_radio("medical_physical_status", "0", format_bool(set_value("medical_physical_status"), "0")); ?> />
            No
        </label>

        <label class="hwrap m_bottom5">If <strong>Yes</strong>, please explain:</label>
        <?php
		$TMP_name		= "medical_physical_reason";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name),
			"class"			=> set_class($TMP_name),
			"disabled"		=> "disabled",
			"placeholder"	=> "Reason?"
		);

		echo form_textarea($specdata);
		echo form_error($TMP_name);
		?>
    </div>



    <div class="field_row w_100 ">

        <?php
		$TMP_name		= "list_any_medications";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name),
			"class"			=> set_class($TMP_name),
			"placeholder"	=> "Please list any medications that you take regularly:  *"
		);

		echo form_textarea($specdata);
		echo form_error($TMP_name);
		?>
    </div>


    <div class="field_row w_100 ">

        <?php
		$TMP_name		= "list_any_allergies";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name),
			"class"			=> set_class($TMP_name),
			"placeholder"	=> "Please list any allergies you have to food, medicine or the environment:  *"
		);

		echo form_textarea($specdata);
		echo form_error($TMP_name);
		?>
    </div>

    <h2 class="h2Style1">Primary Emergency Contact</h2>
    <div class="field_row w_50 p_right10">
        <?php
		$TMP_name		= "primary_emer_contact_name";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name),
			"class"			=> set_class($TMP_name),
			"placeholder"	=> "Name *"
		);

		echo form_input($specdata);
		echo form_error($TMP_name);
		?>
    </div>

    <div class="field_row w_50 p_left10">
        <?php
		$TMP_name		= "primary_emer_contact_relationship";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name),
			"class"			=> set_class($TMP_name),
			"placeholder"	=> "Relationship *"
		);

		echo form_input($specdata);
		echo form_error($TMP_name);
		?>
    </div>


    <div class="field_row w_100">
        <?php
		$TMP_name		= "primary_emer_contact_address";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name),
			"class"			=> set_class($TMP_name),
			"placeholder"	=> "Address *"
		);

		echo form_textarea($specdata);
		echo form_error($TMP_name);
		?>
    </div>

    <div class="field_row w_50 p_right10">
        <?php
		$TMP_name		= "primary_emer_contact_telephone";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name),
			"class"			=> set_class($TMP_name),
			"placeholder"	=> "Telephone *"
		);

		echo form_input($specdata);
		echo form_error($TMP_name);
		?>
    </div>


    <div class="field_row w_50 p_left10">
        <?php
		$TMP_name		= "primary_emer_contact_email";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name),
			"class"			=> set_class($TMP_name),
			"placeholder"	=> "Email *"
		);

		echo form_input($specdata);
		echo form_error($TMP_name);
		?>
    </div>

    <h2 class="h2Style1">Secondary Emergency Contact</h2>
    <div class="field_row w_50 p_right10">
        <?php
		$TMP_name		= "secondary_emer_contact_name";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name),
			"class"			=> set_class($TMP_name),
			"placeholder"	=> "Name *"
		);

		echo form_input($specdata);
		echo form_error($TMP_name);
		?>
    </div>

    <div class="field_row w_50 p_left10">
        <?php
		$TMP_name		= "secondary_emer_contact_relationship";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name),
			"class"			=> set_class($TMP_name),
			"placeholder"	=> "Relationship *"
		);

		echo form_input($specdata);
		echo form_error($TMP_name);
		?>
    </div>


    <div class="field_row w_100">
        <?php
		$TMP_name		= "secondary_emer_contact_address";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name),
			"class"			=> set_class($TMP_name),
			"placeholder"	=> "Address *"
		);

		echo form_textarea($specdata);
		echo form_error($TMP_name);
		?>
    </div>

    <div class="field_row w_50 p_right10">
        <?php
		$TMP_name		= "secondary_emer_contact_telephone";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name),
			"class"			=> set_class($TMP_name),
			"placeholder"	=> "Telephone *"
		);

		echo form_input($specdata);
		echo form_error($TMP_name);
		?>
    </div>


    <div class="field_row w_50 p_left10">
        <?php
		$TMP_name		= "secondary_emer_contact_email";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name),
			"class"			=> set_class($TMP_name),
			"placeholder"	=> "Email *"
		);

		echo form_input($specdata);
		echo form_error($TMP_name);
		?>
    </div>

    <h2 class="h2Style1">Biography</h2>
    <div class="field_row w_100">
        <?php
		$TMP_name		= "short_biography";
		$specdata		= array(
			"name"			=> $TMP_name,
			"id"			=> $TMP_name,
			"value"			=> set_value($TMP_name),
			"class"			=> set_class($TMP_name),
			"placeholder"	=> "Please write a short auto-biography (no more than 300 words) below, and send it by e-mail with your completed application. The bios will be shared to introduce everyone before deployment. *"
		);

		echo form_textarea($specdata);
		echo form_error($TMP_name);
		?>
    </div>

    <h3>Please check that you have completed all parts of this application, sign & date below:</h3>

    <div class="field_row w_100">
        <div class="field_row w_50 p_right10">
            <strong>Resume (CV) *</strong><br />(Allowed: .doc .docx .pdf)<br />(Max: 2mb)
        </div>

        <div class="field_row w_50 p_left10">
            <input type="file" class="btn btn-default" name="file_resume" />
            <input type="hidden" value="<?php echo set_value("resume"); ?>" name="resume" />
            <small><?php echo image_link("resume", false); ?></small>

            <?php echo form_error("file_resume"); ?>
        </div>
    </div>

    <div class="field_row w_100 ">
        <div class="field_row w_50 p_right10">
            <strong>Passport Copy *</strong><br />(Allowed: .jpg .gif .png)<br />(Max: 2mb)
            <br />
            (must be valid for at least 6 months AFTER the travel dates)
        </div>


        <div class="field_row w_50 p_left10">
            <input type="file" class="btn btn-default" name="file_passport" />
            <input type="hidden" value="<?php echo set_value("passport"); ?>" name="passport" />
            <small><?php echo image_link("passport", false); ?></small>

            <?php echo form_error("file_passport"); ?>
        </div>
    </div>

    <div class="field_row w_100 ">
        <div class="field_row w_50 p_right10">
            <strong>Passport Size Photos *</strong><br />(Allowed: .jpg .gif .png)<br />(Max: 2mb)
        </div>

        <div class="field_row w_50 p_left10">
            <input type="file" class="btn btn-default" name="file_photo_image" />
            <input type="hidden" value="<?php echo set_value("photo_image"); ?>" name="photo_image" />
            <small><?php echo image_link("photo_image", false); ?></small>

            <?php echo form_error("file_photo_image"); ?>
        </div>
    </div>

    <h3>PERSONAL COVENANT AND LIABILITY RELEASE FORM (signature required below)</h3>

    <p>
        The guidelines listed below are provided for those participating with Imamia Medics International to familiarize you with what to anticipate and to advise you of our policies. You go not as a tourist, but as a guest of another country to provide valuable medical services. Many countries do not have the same conveniences you are used to at home. It is very important to be flexible and willing to adjust culture, environment, and accommodations.
    </p>
    <p>
        I recognize and accept the following conditions which will further the usefulness and safety of our trip.<br />
        As a member of this team, I agree to:
    </p>
    <ol>
        <li>
            Release and discharge the organizations and individuals which helped make these arrangements, including Imamia Medics International, its agents, employees, officers, and volunteers, from all claims, demands, actions, judgments, or executions that I have ever had, or now have, or may have, or which my heirs, executors, administrators, or assigns may have claim to have against these organizations, their agents, employees, officers, or volunteers, and their successors or assigns. For all personal injuries, known or unknown, and injuries to property, real or personal, caused by, or arising out of this trip. I intend to be legally bound by this statement.
        </li>
        <li>
            Maintain an attitude that I am on this medical mission to try to have an open mind and understand the host culture, not to convince them of my own viewpoint or style. I will go acknowledging that there are many different ways to accomplish the same objective, and that my way is not necessarily the best.
        </li>
        <li>
            Abstain from derogatory comments or arguments regarding people, politics, sports, religion, gender, race, cultural differences or traditions.
        </li>
        <li>
            Go as a team member and servant, and will have that attitude when dealing with my fellow team members and the people I meet during the trip.
        </li>
        <li>
            Accept and submit to the leadership role and authority of the team leader and promise to abide by his or her decisions as they concern this trip.
        </li>
        <li>
            Observe the rules set by Imamia Medics International and/or partnering organizations, including reporting on time for my shifts and understanding that my primary responsibility is to provide medical care as part of this delegation.
        </li>
        <li>
            Acknowledge that by during this journey, I am subjecting myself to certain risks voluntarily, including and in addition to those risks that I normally face in my personal and business life, including, but not limited to such things as health hazards due to poor food and water, diseases, pests, and poor sanitation; potential danger from lack of control of the local population; potential injury while working; and inadequate medical facilities.
        </li>
        <li>
            Understand that our team's work is only a portion of the bigger picture that Imamia Medics International and our partners are trying to accomplish. I promise not to be overly demanding, to do my best not to offend or cause embarrassment for the local partners, and to do my best to help them to attain their long-term goals.
        </li>
        <li>
            Attend all team meetings possible&dash;including those prior to, during, and after the trip.
        </li>
        <li>
            Expeditiously follow up on all requirements for passports, visas, financial obligations, vaccinations, travel insurance, etc.
        </li>
        <li>
            Refrain from meddling, complaining, obscene or insensitive humor. I realize that others on my team, and those in Iraq will consider me to be a representative of Imamia Medics International, and I will not treat that responsibility lightly.
        </li>
        <li>
            I understand that travel, especially to remote locations, can be uncomfortable and sometimes difficult, and I promise to adopt a flexible attitude, and be supportive as plans may need to be changed. I understand that I must travel with the rest of the team, unless other prior arrangements are made.
        </li>
        <li>
            If a family member, loved one or dear friend is traveling with me, we agree to interact with all members of the team, not just one another.
        </li>
        <li>
            I agree that in the event that my conduct is considered so unsatisfactory that it jeopardizes that success of the trip, and that counseling or mediation during the trip has failed to correct my behavior, that my services in connection with this trip shall end, and I shall return home immediately at my own expense.
        </li>
        <li>
            I release all photographs and consent that these may be used in IMI materials.
        </li>
        <li>
            I agree to pay all fees and submit all necessary forms by the deadlines established by IMI.
        </li>
        <li>
            Agree to provide a full report of my activities as a member of this delegation within two weeks of my return.
        </li>
    </ol>

    <p>
        <b>In signing this agreement, I represent that I am 18 years of age or older, and I understand and agree to all the terms above. If under 18 years of age my parent/guardian signs below, accepting the above conditions on my behalf.</b>
    </p>


    <div class="field_row w_100">
        <strong>Signature:</strong>
        <div id="signature" class="signature"></div>
        <input type="hidden" name="signature" value="" />
        <?php echo form_error('signature'); ?>
    </div>
    <div class="field_row w_100">
        <strong>Parent/Guardian Signature ( if under 18 ):</strong>
        <div id="parent-signature" class="signature"></div>
        <input type="hidden" name="parent_signature" value="" />
        <?php echo form_error('parent_signature'); ?>
    </div>
    <div class="field_row w_50">
        <strong>Date:</strong>
        <?php echo date('F j, Y'); ?>
    </div>
    <input class="submit_btn field_row w_100" name="btn_emergency_roster_form" type="submit" value="Submit Application" />

</div>
<?php
echo form_close();
} else {
	$data["_messageBundle"]				= $_messageBundle_not_a_member;
	$this->load->view('frontend/template/_show_messages.php', $data);
}
} else {
	$data["_messageBundle"]					= $_messageBundle_please_login;
	$this->load->view('frontend/template/_show_messages.php', $data);
}
?>
<script>
    $('input[name="preffered_mode_of_contact"]').on('change', function() {
        $('.home_phone').hide();
        $('.mobile_phone').hide();
        $('.work_phone').hide();
        $('.' + $(this).val().toLowerCase() + '_phone').show();
    });

    var signdiv = $("#signature").jSignature({
        UndoButton: true,
        height: '200px',
        width: '100%'
    });

    signdiv.bind('change', function(e) {
        if (signdiv.jSignature('getData', 'native').length > 0) {
            $('input[name="signature"]').val(signdiv.jSignature("getData", "default"));
        } else {
            $('input[name="signature"]').val("");
        }
    });

    var signdiv2 = $("#parent-signature").jSignature({
        UndoButton: true,
        height: '200px',
        width: '100%'
    });

    signdiv2.bind('change', function(e) {
        if (signdiv.jSignature('getData', 'native').length > 0) {
            $('input[name="parent_signature"]').val(signdiv2.jSignature("getData", "default"));
        } else {
            $('input[name="parent_signature"]').val("");
        }
    });
</script> 