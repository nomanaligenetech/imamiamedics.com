<a id="hash_internship_form" name="hash_internship_form"></a>
<h3 class="h3Style1"><?php echo lang_line("text_residencies_observerships"); ?></h3>
<?php
if ($this->session->userdata('user_logged_in')) 
{
	
	//if ( $this->functions->_user_logged_in_details( "is_member" ) )
	//{
		$attributes 			= array("method"		=> "post",
										"name"			=> "form1",
										"enctype"		=> "multipart/form-data",
										"onsubmit"      => "submit_with_hash('form1', 'hash_internship_form',true)");
	
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
									"placeholder"	=> lang_line("text_name") ." *");
			
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
									"placeholder"	=> lang_line("text_birthday") ." *");
			
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
									"placeholder"	=> lang_line("text_email") . " *");
			
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
									"placeholder"	=> lang_line("text_phonenumber") . " *");
			
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
									"placeholder"	=> lang_line("text_city") . " *");
			
			echo form_input($specdata);
			echo form_error($TMP_name);
			?>
		</div>
        
        
        <div class="field_row w_50 p_left10">
			<?php
			$TMP_name		= "state";
			$specdata		= array("name"			=> $TMP_name,
									"id"			=> $TMP_name,
									"value"			=> set_value($TMP_name),
									"class"			=> set_class($TMP_name),
									"placeholder"	=> lang_line("text_state") . " *");
			
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
			$TMP_name		= "college_university";
			$specdata		= array("name"			=> $TMP_name,
									"id"			=> $TMP_name,
									"value"			=> set_value($TMP_name),
									"class"			=> set_class($TMP_name),
									"placeholder"	=> lang_line("text_collegeuniversity") . " *");
			
			echo form_input($specdata);
			echo form_error($TMP_name);
			?>
		</div>
        
        
        <div class="field_row w_50 p_right10">
			<?php
			$TMP_name		= "qualification";
			$specdata		= array("name"			=> $TMP_name,
									"id"			=> $TMP_name,
									"value"			=> set_value($TMP_name),
									"class"			=> set_class($TMP_name),
									"placeholder"	=> lang_line("text_qualification") . " *");
			
			echo form_input($specdata);
			echo form_error($TMP_name);
			?>
		</div>
        
        
        <div class="field_row w_50 p_left10">
			<?php
			$TMP_name		= "specialization";
			$specdata		= array("name"			=> $TMP_name,
									"id"			=> $TMP_name,
									"value"			=> set_value($TMP_name),
									"class"			=> set_class($TMP_name),
									"placeholder"	=> lang_line("text_specialization") . " *");
			
			echo form_input($specdata);
			echo form_error($TMP_name);
			?>
		</div>
        
        
        
        <!--<div>
        	<div class="field_row w_50 p_right10">
            Documents (resume etc.)
            <style>
			.ilinks_sortable{ float:left;}
			.ilinks_sortable li{ margin-bottom: 20px; font-size: 15px; line-height: 15px; }
			.ilinks_sortable a.label-danger{ background-color:orangered; color:white; padding:5px;}
			</style>
            <small style="font-family: arial;" class="field_row w_100 m_top10"><strong>File Types (allowed):</strong> <?php echo $pp_internship_form_images_types;?></small>
            <small style="font-family: arial; color:#039;" class="field_row w_100"><strong>Upload Multiple Files</strong></small>
            </div>
            
            <div class="field_row w_50 p_left10">
            <input type="file" class="btn btn-default" name="file_resume[]" multiple />
			<?php echo image_link("resume", FALSE, FALSE, TRUE);?>		
          	<?php
			echo form_error("resume");
			?>
            </div>            
		</div>-->
        
        <div class="field_row w_50 p_right10">
        	<div class="browse-field">
            <label><?php echo lang_line("text_documents_resume"); ?> </label>
            <div class="file-custom-field"><input type="file" class="btn btn-default" name="file_resume[]" multiple /></div>
          	<small class="w_100 file-type"><strong> <?php echo lang_line("text_upload_multiple_files"); ?> </strong> gif | jpg | png | doc | pdf<?php #echo $pp_internship_form_images_types;?></small>
			<?php
			echo form_error("resume[]");
			?>
            <!--<small style="font-family: arial; color:#039;" class="field_row w_100"><strong>Upload Multiple Files</strong></small>-->
            <?php echo image_link("resume", FALSE, FALSE, TRUE);?>	
            </div>
        </div>
        
      
        

		
		<div class="field_row w_50 p_left10" style="display:none;">
			<?php
			$specdata		= array("name"			=> "security_code",
									"id"			=> "security_code",
									"class"			=> set_class("security_code") . " m_bottom10",
									"placeholder"	=> lang_line("text_securitycode") . " *");	
			
			echo form_input($specdata);
			echo form_error("security_code");
			?>
            
            <?php
			echo captchacode();
			?>
		</div>
        
  
	
	
		<div align="center">
        	<input class="submit_btn submit_btn field_row w_50" name="btn_internship_form" type="submit" value="<?php echo lang_line("text_submit_application");?>" />
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