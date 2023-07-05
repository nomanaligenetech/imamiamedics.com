<?php
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");

echo form_open(site_url( uri_string() ), $attributes);
?>
<h2 class="h2Style2 m_bot25"><?php echo lang_line('button_register'); ?></h2>
    <div class="w100prcnt">
        	 <?php
            	//echo form_label('Name', 'name',array('class'=>'lbl1'));
               
                $specdata		= array("name"			=> "name",
                                        "id"			=> "name",
                                        "class"			=> set_class("name") . " inputStyle1 bb",
                                        "value"			=> set_value("name"),
                                        "placeholder"	=> lang_line('text_name'));	
    
                echo form_input($specdata);
                
                echo form_error('name');
                ?>
              
                <?php
				//echo form_label('Last Name', 'last_name',array('class'=>'lbl1'));
                $specdata		= array("name"			=> "last_name",
                                        "id"			=> "last_name",
                                        
                                        "class"			=> set_class("last_name") . " inputStyle1 bb",
                                        "value"			=> set_value("last_name"),
                                        "placeholder"	=> lang_line('text_lastname'));	
    
                echo form_input($specdata);
                
                echo form_error('last_name');
                ?>
                
                <?php
				//echo form_label('Email', 'email',array('class'=>'lbl1'));
                $specdata		= array("name"			=> "email",
                                        "id"			=> "email",
                                        
                                        "class"			=> set_class("email") . " inputStyle1 bb",
                                        "value"			=> set_value("email"),
                                        "placeholder"	=> lang_line('text_email'));	
    
                echo form_input($specdata);
                
                echo form_error('email');
                ?>
                
                <?php
				//echo form_label('Address', 'address',array('class'=>'lbl1'));
                $specdata		= array("name"			=> "address",
                                        "id"			=> "address",
                                        
                                        "class"			=> set_class("address") . " inputStyle1 bb",
                                        "value"			=> set_value("address"),
                                        "placeholder"	=> lang_line('label_arbaeen_form_address'));	
    
                echo form_input($specdata);
                
                echo form_error('address');
                ?>
                
                <?php
				//echo form_label('Password', 'password',array('class'=>'lbl1'));
                $specdata		= array("name"			=> "password",
                                        "id"			=> "password",
                                        
                                        "type"			=> "password",
                                        "class"			=> set_class("password") . " inputStyle1 bb",
                                        "value"			=> set_value("password"),
                                        "placeholder"	=> lang_line('placeholder_password'));	
    
                echo form_input($specdata);
                
                echo form_error('password');
                ?>
                
                <?php
				//echo form_label('Confirm password', 'cpassword',array('class'=>'lbl1'));
                $specdata		= array("name"			=> "cpassword",
                                        "id"			=> "cpassword",
                                        
                                        "type"			=> "password",
                                        "class"			=> set_class("cpassword") . " inputStyle1 bb",
                                        "value"			=> set_value("cpassword"),
                                        "placeholder"	=> lang_line('placeholder_cpassword'));	
    
                echo form_input($specdata);
                
                echo form_error('cpassword');
                ?>
    </div>
    <div class="w100prcnt m_top15 g-recaptcha-wrap">
        <div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('google_key') ?>"></div> 
    </div>
    <div class="w100prcnt m_top15 m_rite20">
        
        <div style="text-align:right">
            <input type="submit" class="btn_style3 m_top10 blackbuttons" value="<?php echo lang_line('button_register'); ?>">
        </div>
    </div>
    <?php
    if(is_countryCheck(FALSE,FALSE,TRUE) == 'canada'){?>
        <div class="w100prcnt">
            <p class="regpg-ptg-cc">If you would like a printable version of the form to fill and send in via post, please <a href="<?php echo base_url( "assets/files_new/imicanada/ImamiaMedicsInternationalCanadaMembershipForm.pdf" );?>"><?php echo lang_line('button_click_here'); ?></a></p> 
        </div>
<?php
    }
echo form_close();
?>