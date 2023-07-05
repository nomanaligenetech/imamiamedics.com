<a id="hash_volunteer_form" name="hash_volunteer_form"></a>
<h3 class="h3Style1"><?php echo lang_line("text_volunteer_application")?></h3>
<?php
if ($this->session->userdata('user_logged_in')) 
{
	
	//if ( $this->functions->_user_logged_in_details( "is_member" ) )
	//{
		$attributes 			= array("method"		=> "post",
										"name"			=> "form1",
										"enctype"		=> "multipart/form-data",
										"onsubmit"      => "submit_with_hash('form1', 'hash_volunteer_form',true)");
	
		echo form_open(site_url( uri_string() ), $attributes);
	?>
	
	<div class="form_sec fl_lft w_100">
	
		<div class="field_row w_50 p_right10">
			<?php
			$TMP_name		= "name";
			$specdata		= array("name"			=> $TMP_name,
									"id"			=> $TMP_name,
									"value"			=> set_value($TMP_name, $$TMP_name),
									"class"			=> set_class($TMP_name),
									//"placeholder"	=> "Name *"
									"placeholder"	=> lang_line("text_name") . " *"
								);
			
			echo form_input($specdata);
			echo form_error($TMP_name);
			?>
		</div>
		
		
		
		
		
		
		
		
		
		
		<div class="field_row w_50 p_left10">
			<?php
			$TMP_name		= "date_of_birth";
			$specdata		= array("name"			=> $TMP_name,
									"id"			=> $TMP_name,
									"value"			=> set_value($TMP_name, $$TMP_name),
									"class"			=> set_class($TMP_name) . " datepicker",
									"placeholder"	=> lang_line("text_birthday"). " *");
			
			echo form_input($specdata);
			echo form_error($TMP_name);
			?>
		</div>
        
        
        <div class="field_row w_50 p_right10">
			<?php
			$TMP_name		= "email";
			$specdata		= array("name"			=> $TMP_name,
									"id"			=> $TMP_name,
									"value"			=> set_value($TMP_name, $$TMP_name),
									"class"			=> set_class($TMP_name),
									"placeholder"	=> lang_line("text_email"). " *");
			
			echo form_input($specdata);
			echo form_error($TMP_name);
			?>
		</div>
        
        <div class="field_row w_50 p_left10">
			<?php
			$TMP_name		= "phone";
			$specdata		= array("name"			=> $TMP_name,
									"id"			=> $TMP_name,
									"value"			=> set_value($TMP_name, $$TMP_name),
									"class"			=> set_class($TMP_name),
									"placeholder"	=> lang_line("text_phonenumber"). " *");
			
			echo form_input($specdata);
			echo form_error($TMP_name);
			?>
		</div>
        
        
        <div class="field_row w_50 p_right10">
			<?php
			$TMP_name		= "city";
			$specdata		= array("name"			=> $TMP_name,
									"id"			=> $TMP_name,
									"value"			=> set_value($TMP_name, $$TMP_name),
									"class"			=> set_class($TMP_name),
									"placeholder"	=> lang_line("text_city"). " *");
			
			echo form_input($specdata);
			echo form_error($TMP_name);
			?>
		</div>
        
        
        <div class="field_row w_50 p_left10">
			<?php
			$TMP_name		= "state";
			$specdata		= array("name"			=> $TMP_name,
									"id"			=> $TMP_name,
									"value"			=> set_value($TMP_name, $$TMP_name),
									"class"			=> set_class($TMP_name),
									"placeholder"	=> lang_line("text_state")." *");
			
			echo form_input($specdata);
			echo form_error($TMP_name);
			?>
		</div>
        
        
        <div class="field_row w_50 p_right10">
        	<?php 
			echo form_dropdown('country', DropdownHelper::country_dropdown(), set_value("country", $country), "class='form-control ". set_class("country") ."'" );
			echo form_error("country");
			?>
		</div>
        
        
        <div class="field_row w_50 p_left10">
			<?php
			$TMP_name		= "qualification";
			$specdata		= array("name"			=> $TMP_name,
									"id"			=> $TMP_name,
									"value"			=> set_value($TMP_name),
									"class"			=> set_class($TMP_name),
									"placeholder"	=> lang_line("text_qualification")." *");
			
			echo form_input($specdata);
			echo form_error($TMP_name);
			?>
		</div>
        
        
        <div class="field_row w_50 p_right10">
			<?php
			$TMP_name		= "area_of_interest";
			$specdata		= array("name"			=> $TMP_name,
									"id"			=> $TMP_name,
									"value"			=> set_value($TMP_name),
									"class"			=> set_class($TMP_name) . " imi_selectize",
									"placeholder"	=> lang_line("text_area_interest")." *");
			
			echo form_input($specdata);
			echo form_error($TMP_name);
			?>
		</div>
        
		
		<div class="field_row w_50 p_left10" style="display:none;">
			<?php
			$specdata		= array("name"			=> "security_code",
									"id"			=> "security_code",
									"class"			=> set_class("security_code") . " m_bottom10",
									"placeholder"	=> lang_line("text_security_code")." *");	
			
			echo form_input($specdata);
			echo form_error("security_code");
			?>
            
            <?php
			echo captchacode();
			?>
		</div>
        
  
	
	
		<div align="center">
        	<input class="submit_btn submit_btn field_row w_50" name="btn_volunteer_form" type="submit" value="<?php echo lang_line("text_submit_application"); ?>" />
        </div>
		
		
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