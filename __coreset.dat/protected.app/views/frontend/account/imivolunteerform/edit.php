<?php 
$attributes 			= array("name"			=> "myForm",
                                "method"		=> "post",
                                "enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( uri_string()), $attributes, $unique_form);
?>    

<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididuon proident, sunt in culpa qui officia cmollit anim id est laborum. uis aute irure dolor in reprehenderit in voluptate velit esse cillum dolor</p>
<div class="profileSettings fl_lft w_100">

    <div class="profileForm m_bottom30 fl_lft w_100">
        <div class="form_sec fl_lft w_100">
            <div class="field_row myLabel w_50 p_right10">
                <label class="">Name :</label>
				<?php
				$TMP_input		= "name";
                $specdata		= array("name"				=> $TMP_input,
										"id"				=> $TMP_input,										
										"class"				=> "form-control",
										"value"				=> set_value($TMP_input, $$TMP_input) );
                
                echo form_input($specdata);
                ?>
            </div>
            
            
            <div class="field_row myLabel w_50 p_right10">
                <label class="">Date of Birth :</label>
                <?php
				$TMP_input		= "date_of_birth";
                $specdata		= array("name"				=> $TMP_input . '_1',
										"id"				=> $TMP_input . '_1',										
										"class"				=> "form-control datepicker hasDatepicker",
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
										"disabled"			=> "disabled",
										"value"				=> set_value($TMP_input, $$TMP_input) );
                
                echo form_input($specdata);
                ?>
            </div>
            
            
            <div class="field_row myLabel w_50 p_right10">
                <label class="">Phone :</label>
                <?php
				$TMP_input		= "phone";
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
                <label class="">Country :</label>
                <div id="fakeSelectContaier" class="typeOne custom_dropdown">
                <span class="fakeSelect"></span>
                    <?php echo form_dropdown('country', DropdownHelper::country_dropdown(), set_value("country", $country) )?>
                </div>
            </div>
            
            
            
            <div class="field_row myLabel w_50 p_right10">
                <label class="">Qualification :</label>
                <?php
				$TMP_input		= "qualification";
                $specdata		= array("name"				=> $TMP_input,
										"id"				=> $TMP_input,										
										"class"				=> "form-control",
										"value"				=> set_value($TMP_input, $$TMP_input) );
                
                echo form_input($specdata);
                ?>
            </div>
            
            
            <div class="field_row myLabel w_50 p_right10">
                <label class="">Area of Interest :</label>
                <?php
				$TMP_input		= "area_of_interest";
                $specdata		= array("name"				=> $TMP_input,
										"id"				=> $TMP_input,										
										"class"				=> "form-control",
										"value"				=> set_value($TMP_input, $$TMP_input) );
                
                echo form_input($specdata);
                ?>
            </div>
            
            
            
            <div class="fl_lft w_100 memProLink">
            	<a class="blue_btn1 big fontFam_aleoReg m_top20" href="javascript:;" onclick="$('input[name=submit]').click()">
                	Update Volunteer Form Info
                </a>
                
                <input type="submit" name="submit"  style="display:none;" />
            </div>
        </div>
    </div>

</div>




<input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
<input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />

</form>