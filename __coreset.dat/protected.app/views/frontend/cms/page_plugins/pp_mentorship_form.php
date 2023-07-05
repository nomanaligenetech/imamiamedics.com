<a id="hash_mentorship_form" name="hash_mentorship_form"></a>
<h3 class="h3Style1"><?php echo lang_line("text_signup_mentor_form"); ?></h3>
<?php
if ($this->session->userdata('user_logged_in')) 
{
	
	//if ( $this->functions->_user_logged_in_details( "is_member" ) )
	//{
		$attributes 			= array("method"		=> "post",
									"name"			=> "form1",
									"enctype"		=> "multipart/form-data",
									"onsubmit"      => "submit_with_hash('form1', 'hash_mentorship_form',true)");
	
	echo form_open(site_url( uri_string() ), $attributes);
	?>
	
	<div class="form_sec fl_lft w_100">
	
		<div class="field_row w_50 p_right10">
			<?php
			$specdata		= array("name"			=> "first_name",
									"id"			=> "first_name",
									"value"			=> set_value("first_name", $first_name),
									"class"			=> set_class("first_name"),
									"placeholder"	=> lang_line("text_firstname") . " *");	
			
			echo form_input($specdata);
			echo form_error("first_name");
			?>
		</div>
		
		
		
		<div class="field_row w_50 p_left10">
			<?php
			$specdata		= array("name"			=> "last_name",
									"id"			=> "last_name",
									"value"			=> set_value("last_name", $last_name),
									"class"			=> set_class("last_name"),
									"placeholder"	=> lang_line("text_lastname") . " *");
			
			echo form_input($specdata);
			echo form_error("last_name");
			?>
		</div>
		
		
		
		<div class="field_row w_50 p_right10">
			<?php
			$specdata		= array("name"			=> "address",
									"id"			=> "address",
									"value"			=> set_value("address", $home_full_address),
									"class"			=> set_class("address"),
									"placeholder"	=> lang_line("mailing_address") . " *");
			
			echo form_textarea($specdata);
			echo form_error("address");
			?>
		</div>
		
		
		<div class="field_row w_50 p_left10">
			<?php
			$specdata		= array("name"			=> "address_2",
									"id"			=> "address_2",
									"value"			=> set_value("address_2"),
									"class"			=> set_class("address_2"),
									"placeholder"	=> lang_line("text_address_optional"));
			
			echo form_textarea($specdata);
			echo form_error("address_2");
			?>
		</div>
		
		
		
		<div class="field_row w_50 p_right10">
			
			<?php
			$TMP_name		= "state";
			$specdata		= array("name"			=> $TMP_name,
									"id"			=> $TMP_name,
									"value"			=> set_value( $TMP_name, $home_state_province ),
									"class"			=> set_class( $TMP_name ),
									"placeholder"	=> lang_line("text_state") ." *");
			
			echo form_input($specdata);
			echo form_error( $TMP_name );
			?>
		</div>
		
		
		<div class="field_row w_50 p_left10">
			
			<?php
			$TMP_name		= "city";
			$specdata		= array("name"			=> $TMP_name,
									"id"			=> $TMP_name,
									"value"			=> set_value( $TMP_name, $home_city ),
									"class"			=> set_class( $TMP_name ),
									"placeholder"	=> lang_line("text_city") ." *");
			
			echo form_input($specdata);
			echo form_error( $TMP_name );
			?>
		</div>
		
		
		
		<div class="field_row w_50 p_right10">
			<?php
			$specdata		= array("name"			=> "email",
									"id"			=> "email",
									"value"			=> set_value("email", $email),
									"class"			=> set_class("email"),
									"placeholder"	=> lang_line("text_email") ." *");	
			
			echo form_input($specdata);
			echo form_error("email");
			?>
		</div>
		
		
		
		<div class="field_row w_50 p_left10">
			<?php
			$specdata		= array("name"			=> "zip",
									"id"			=> "zip",
									"value"			=> set_value("zip"),
									"class"			=> set_class("zip"),
									"placeholder"	=> lang_line("text_zipcode"));
			
			echo form_input($specdata);
			echo form_error("zip");
			?>
		</div>
	
	
	
		<div class="field_row w_50 p_right10">
			<?php
			$specdata		= array("name"			=> "employer",
									"id"			=> "employer",
									"value"			=> set_value("employer"),
									"class"			=> set_class("employer"),
									"placeholder"	=> lang_line("text_employer") . " *");	
			
			echo form_input($specdata);
			echo form_error("employer");
			?>
		</div>
		
		
		
		<div class="field_row w_50 p_left10">
			<?php
			$TMP_name		= "profession";
			$specdata		= array("name"			=> $TMP_name,
									"id"			=> $TMP_name,
									"value"			=> set_value( $TMP_name, $occupation ),
									"class"			=> set_class( $TMP_name ),
									"placeholder"	=> lang_line("text_profession"). " *");
			
			echo form_input($specdata);
			echo form_error( $TMP_name );
			?>
		</div>
		
		
		<div class="field_row w_50 p_right10">
			<?php
			$specdata		= array("name"			=> "university",
									"id"			=> "university",
									"value"			=> set_value("university"),
									"class"			=> set_class("university"),
									"placeholder"	=> lang_line("text_university"));	
			
			echo form_input($specdata);
			echo form_error("university");
			?>
		</div>
		
		
		
		<div class="field_row w_50 p_left10">
			<?php
			$TMP_name		= "university_state";
			$specdata		= array("name"			=> $TMP_name,
									"id"			=> $TMP_name,
									"value"			=> set_value( $TMP_name ),
									"class"			=> set_class( $TMP_name ),
									"placeholder"	=> lang_line("text_universitystate") );
			
			echo form_input($specdata);
			echo form_error( $TMP_name );
			?>
		</div>
		
	
	
	
		<div class="field_row w_50 p_right10">
			<?php
			$TMP_name		= "university_city";
			$specdata		= array("name"			=> $TMP_name,
									"id"			=> $TMP_name,
									"value"			=> set_value( $TMP_name ),
									"class"			=> set_class( $TMP_name ),
									"placeholder"	=> lang_line("text_universitycity"));
			
			echo form_input($specdata);
			echo form_error( $TMP_name );
			?>
		</div>
		
		
		
		<div class="field_row w_50 p_left10">
			<?php
			$specdata		= array("name"			=> "degree_type",
									"id"			=> "degree_type",
									"value"			=> set_value("degree_type"),
									"class"			=> set_class("degree_type"),
									"placeholder"	=> lang_line("text_degreetype"));	
			
			echo form_input($specdata);
			echo form_error("degree_type");
			?>
		</div>
	
	
	
	
		<div class="field_row w_50 p_right10">
			<?php
			$TMP_name		= "major";
			$specdata		= array("name"			=> $TMP_name,
									"id"			=> $TMP_name,
									"value"			=> set_value( $TMP_name ),
									"class"			=> set_class( $TMP_name ),
									"placeholder"	=> lang_line("text_major"));
			
			echo form_input($specdata);
			echo form_error( $TMP_name );
			?>
		</div>
		
		
		
		<div class="field_row w_50 p_left10">
			<?php
			$specdata		= array("name"			=> "graduate_year",
									"id"			=> "graduate_year",
									"value"			=> set_value("graduate_year"),
									"class"			=> set_class("graduate_year"),
									"placeholder"	=> lang_line("text_graduateyear") );	
			
			echo form_input($specdata);
			echo form_error("graduate_year");
			?>
		</div>
		
		
	
		<!--<div class="field_row w_50 p_right10">
			<?php
			/*$specdata		= array("name"			=> "password",
									"id"			=> "password",
									"value"			=> set_value("password"),
									"class"			=> set_class("password"),
									"placeholder"	=> "Password ");	
			
			echo form_input($specdata);
			echo form_error("password");*/
			?>
		</div>
		
		
		<div class="field_row w_50 p_left10">
			<?php /*
			$specdata		= array("name"			=> "confirm_password",
									"id"			=> "confirm_password",
									"value"			=> set_value("confirm_password"),
									"class"			=> set_class("confirm_password"),
									"placeholder"	=> "Confirm Password ");	
			
			echo form_input($specdata);
			echo form_error("confirm_password"); */
			?>
		</div>-->
		
		
		
		<div class="field_row w_50 p_right10" style="display:none;">
			<?php
			$specdata		= array("name"			=> "security_code",
									"id"			=> "security_code",
									"value"			=> set_value("security_code"),
									"class"			=> set_class("security_code"),
									"placeholder"	=> lang_line("text_security_code"). " *");	
			
			echo form_input($specdata);
			echo form_error("security_code");
			?>
		</div>
        
        
        <div class="field_row w_50 p_left10" style="display:none;">
			<?php
			$TMP_arr		= array("img_width"			=> 400, 
									"img_height"		=> 60 );
			echo captchacode( $TMP_arr );
			?>
		</div>
	
	
		
		
		<input class="submit_btn" name="btn_mentorship_form" type="submit" value="<?php echo lang_line("text_send_request"); ?>"/>
	</div>
	<?php
	echo form_close();
	//}
	//else
	//{
	//	$data["_messageBundle"]				= $_messageBundle_not_a_member;
	//	$this->load->view('frontend/template/_show_messages.php', $data);
	//}
}
else
{
	$data["_messageBundle"]					= $_messageBundle_please_login;
	$this->load->view('frontend/template/_show_messages.php', $data);
}
?>