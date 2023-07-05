<?php
class EmailTemplateHelper
{
	var $p			= "font-family: Tahoma, 'Geneva', 'Kalimati', 'sans-serif'; font-size: 13px; color: #000000; margin: 0; padding: 0; line-height: 130%;";
	
	
	
	public function __call( $function_name, $param )
	{
		$CI											=& get_instance();
		if ( is_array ( $param ) )
		{
			if ( count ( $param ) > 0 )
			{
				
				
				return $this->$param[0];
				
				
			}
		}
	}
	
	
	
	public function get_recipient_email( $mode = ''  )
	{
		$send_to_live_emails										= 1;
		
		$default_email												= SessionHelper::_get_session("EMAIL_TO", 'site_settings');
		$email_list["reservations_email"]							= "reservations@myboracayguide.com"; #desktop site developer
		$email_list["dsite_developer_email"]						= "sadiq.hussain@genetechsolutions.com"; #mobile site developer
		$email_list["msite_developer_email"]						= "rida.fatima@genetechsolutions.com";
		$email_list["qateam_email"]									= "qateam786@gmail.com";
		
		if ( array_key_exists($mode, $email_list) )
		{
			return 	$email_list[ $mode ];
		}
		else
		{
			return $default_email;
		}
	}
	
	
}
?>