<?php

$_query_string				= "";
if ( $this->input->server('QUERY_STRING') )
{
	$_query_string			= "?" . $this->input->server('QUERY_STRING') ;
}
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");

echo form_open(site_url( uri_string(). $_query_string  ), $attributes);
?>

<div class="field_row w_100">
	<?php
	$specdata		= array("name"			=> "email",
							"id"			=> "email",
							"class"			=> set_class("email") . " ",
							"value"			=> set_value("email"),
							"placeholder"	=> lang_line('text_email'));	

	echo form_input($specdata);
	
	echo form_error('email');
	?>
</div>

<div class="field_row w_100">
	<?php
	$specdata		= array("name"			=> "password",
							"id"			=> "password",
							"type"			=> "password",
							"class"			=> set_class("password") . " ",
							"value"			=> set_value("password"),
							"placeholder"	=> lang_line('placeholder_password'));	

	echo form_input($specdata);
	
	echo form_error('password');
	?>
</div>

<input class="submit_btn" type="submit" value="<?php echo lang_line('button_login'); ?>" />

<div class="login_bottom_text w_100">
	<?php echo lang_line('button_forgot_your_password'); ?> <a href="<?php echo site_url('forgot_password'); ?>"><?php echo lang_line('button_click_here'); ?></a><br />
    <?php echo lang_line('button_donthave_account'); ?> <a href="<?php echo site_url('register'); ?>"><?php echo lang_line('button_signup_now'); ?></a><br />
</div>
<?php
echo form_close();
?>