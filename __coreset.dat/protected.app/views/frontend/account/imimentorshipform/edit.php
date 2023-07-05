<?php 
$attributes 			= array("name"			=> "myForm",
                                "method"		=> "post",
                                "enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( uri_string()), $attributes, $unique_form);
?>

<p>Below are the details you entered for the Mentorship Form. Please review and adjust as necessary. For any questions, please contact <a href="mailto:IMIHQ@imamiamedics.com">IMIHQ@imamiamedics.com</a>.</p>
<div class="profileSettings fl_lft w_100">

    <div class="profileForm m_bottom30 fl_lft w_100">
        <div class="form_sec fl_lft w_100">
            <div class="field_row myLabel w_50 p_right10">
                <label class="">First Name :</label>
				<?php
				$TMP_input		= "first_name";
                $specdata		= array("name"				=> $TMP_input,
										"id"				=> $TMP_input,										
										"class"				=> "form-control",
										"value"				=> set_value($TMP_input, $$TMP_input) );
                
                echo form_input($specdata);
                ?>
            </div>
            
            <div class="field_row myLabel w_50 p_right10">
                <label class="">Last Name :</label>
				<?php
				$TMP_input		= "last_name";
                $specdata		= array("name"				=> $TMP_input,
										"id"				=> $TMP_input,										
										"class"				=> "form-control",
										"value"				=> set_value($TMP_input, $$TMP_input) );
                
                echo form_input($specdata);
                ?>
            </div>
            
            <div class="field_row myLabel w_50 p_right10">
                <label class="">Address :</label>
                <?php
				$TMP_input		= "address";
                $specdata		= array("name"				=> $TMP_input,
										"id"				=> $TMP_input,										
										"class"				=> "form-control",
										"value"				=> set_value($TMP_input, $$TMP_input) );
                
                echo form_input($specdata);
                ?>
            </div>
            
            <div class="field_row myLabel w_50 p_right10">
                <label class="">Address 2 :</label>
                <?php
				$TMP_input		= "address_2";
                $specdata		= array("name"				=> $TMP_input,
										"id"				=> $TMP_input,										
										"class"				=> "form-control",
										"value"				=> set_value($TMP_input, $$TMP_input) );
                
                echo form_input($specdata);
                ?>
            </div>
            
            <div class="field_row myLabel w_50 p_right10">
                <label class="">State :</label>
                <?php
				$TMP_input		= "state";
                $specdata		= array("name"				=> $TMP_input,
										"id"				=> $TMP_input,										
										"class"				=> "form-control",
										"value"				=> set_value($TMP_input, $$TMP_input) );
                
                echo form_input($specdata);
                ?>
            </div>
            
            
            <div class="field_row myLabel w_50 p_right10">
                <label class="">City :</label>
                <?php
				$TMP_input		= "city";
                $specdata		= array("name"				=> $TMP_input,
										"id"				=> $TMP_input,										
										"class"				=> "form-control",
										"value"				=> set_value($TMP_input, $$TMP_input) );
                
                echo form_input($specdata);
                ?>
            </div>
            
            <div class="field_row myLabel w_50 p_right10">
                <label class="">Email :</label>
                <?php
				$TMP_input		= "email";
                $specdata		= array("name"				=> $TMP_input,
										"id"				=> $TMP_input,										
										"class"				=> "form-control",
										"value"				=> set_value($TMP_input, $$TMP_input) );
                
                echo form_input($specdata);
                ?>
            </div>
            
            
            <div class="field_row myLabel w_50 p_right10">
                <label class="">Zip :</label>
                <?php
				$TMP_input		= "zip";
                $specdata		= array("name"				=> $TMP_input,
										"id"				=> $TMP_input,										
										"class"				=> "form-control",
										"value"				=> set_value($TMP_input, $$TMP_input) );
                
                echo form_input($specdata);
                ?>
            </div>
            
            
            <div class="field_row myLabel w_50 p_right10">
                <label class="">Employer :</label>
                <?php
				$TMP_input		= "employer";
                $specdata		= array("name"				=> $TMP_input,
										"id"				=> $TMP_input,										
										"class"				=> "form-control",
										"value"				=> set_value($TMP_input, $$TMP_input) );
                
                echo form_input($specdata);
                ?>
            </div>
            
            
            
            <div class="field_row myLabel w_50 p_right10">
                <label class="">Profession :</label>
                <?php
				$TMP_input		= "profession";
                $specdata		= array("name"				=> $TMP_input,
										"id"				=> $TMP_input,										
										"class"				=> "form-control",
										"value"				=> set_value($TMP_input, $$TMP_input) );
                
                echo form_input($specdata);
                ?>
            </div>
            
            
            <div class="field_row myLabel w_50 p_right10">
                <label class="">University :</label>
                <?php
				$TMP_input		= "university";
                $specdata		= array("name"				=> $TMP_input,
										"id"				=> $TMP_input,										
										"class"				=> "form-control",
										"value"				=> set_value($TMP_input, $$TMP_input) );
                
                echo form_input($specdata);
                ?>
            </div>
            
            
            <div class="field_row myLabel w_50 p_right10">
                <label class="">University State :</label>
                <?php
				$TMP_input		= "university_state";
                $specdata		= array("name"				=> $TMP_input,
										"id"				=> $TMP_input,										
										"class"				=> "form-control",
										"value"				=> set_value($TMP_input, $$TMP_input) );
                
                echo form_input($specdata);
                ?>
            </div>
            
            <div class="field_row myLabel w_50 p_right10">
                <label class="">University City :</label>
                <?php
				$TMP_input		= "university_city";
                $specdata		= array("name"				=> $TMP_input,
										"id"				=> $TMP_input,										
										"class"				=> "form-control",
										"value"				=> set_value($TMP_input, $$TMP_input) );
                
                echo form_input($specdata);
                ?>
            </div>
            
            <div class="field_row myLabel w_50 p_right10">
                <label class="">Degree Type :</label>
                <?php
				$TMP_input		= "degree_type";
                $specdata		= array("name"				=> $TMP_input,
										"id"				=> $TMP_input,										
										"class"				=> "form-control",
										"value"				=> set_value($TMP_input, $$TMP_input) );
                
                echo form_input($specdata);
                ?>
            </div>
            
            
            <div class="field_row myLabel w_50 p_right10">
                <label class="">Major :</label>
                <?php
				$TMP_input		= "major";
                $specdata		= array("name"				=> $TMP_input,
										"id"				=> $TMP_input,										
										"class"				=> "form-control",
										"value"				=> set_value($TMP_input, $$TMP_input) );
                
                echo form_input($specdata);
                ?>
            </div>
            
            <div class="field_row myLabel w_50 p_right10">
                <label class="">Graduation Year :</label>
                <?php
				$TMP_input		= "graduate_year";
                $specdata		= array("name"				=> $TMP_input,
										"id"				=> $TMP_input,										
										"class"				=> "form-control",
										"value"				=> set_value($TMP_input, $$TMP_input) );
                
                echo form_input($specdata);
                ?>
            </div>
            
            <div class="fl_lft w_100 memProLink">
            	<a class="blue_btn1 big fontFam_aleoReg m_top20" href="javascript:;" onclick="$('input[name=submit]').click()">
                	Update Mentorship Form Info
                </a>
                
                <input type="submit" name="submit"  style="display:none;" />
            </div>
        </div>
    </div>

</div>




<input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
<input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />

</form>