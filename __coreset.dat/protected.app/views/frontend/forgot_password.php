<h2 class="h2Style2 m_bot25"><?php echo lang_line('button_forgot_password'); ?></h2>
<?php
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");

echo form_open(site_url( uri_string() ), $attributes);
?>
    <div class="formarea">
        
        <table cellpadding="0" cellspacing="0" width="100%"  class="tableform">
    
            <tr>
                <td width="70%">
                <?php
                $specdata		= array("name"			=> "email",
                                        "id"			=> "email",
                                        "class"			=> set_class("email") . " ",
                                        "value"			=> set_value("email"),
                                        "placeholder"	=> lang_line('text_email'));	
    
                echo form_input($specdata);
                
                echo form_error('email');
                ?>
                </td>            
            </tr>
    
        </table>
    </div>
    
    
    <div class="flt-rgt">
        <input type="submit" value="<?php echo lang_line("button_submit");?>" class="blackbuttons" />
    </div>
    
    
    <div class="logincantaccess">
        <a href="<?php echo site_url("memberlogin");?>"><?php echo lang_line('text_loginwithyourimiacnt');?></a>
        <br />
        <?php echo lang_line('text_donthveimiacnt');?> <a href="<?php echo site_url("register");?>"><?php echo lang_line('text_signupnow');?></a>
    </div>

<?php
echo form_close();
?>