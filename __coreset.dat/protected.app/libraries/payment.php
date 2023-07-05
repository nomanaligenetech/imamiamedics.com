<?php
class Payment
{
	function payment()
	{
		$this->CI =& get_instance();
		
	}
	
	function paypal_form_details()
	{
		
		$mode					= SessionHelper::_get_session("PAYPAL_MODE", "site_settings");
		
		#sandbox
		if ( $mode == 0 )
		{
			return (object) array("mode"					=> $mode,
								  "url"						=> SessionHelper::_get_session("PAYPAL_URL_SANDBOX", "site_settings"),
								  "business_email"			=> SessionHelper::_get_session("PAYPAL_EMAIL_SANDBOX", "site_settings") );
		}
		
		
		
		$pay_email = SessionHelper::_get_session("PAYPAL_EMAIL_LIVE", "site_settings");

		$user_id = $this->CI->functions->_user_logged_in_details('id');
		if ( NULL != $user_id ){
			$user_profile = $this->CI->imiconf_queries->fetch_records_imiconf("users_profile"," and userid = ".$user_id." and home_country is not null ","userid,home_country");
			if ( $user_profile->num_rows() > 0 ){
				if ( $user_profile->row()->home_country != "" ){
					$country = $this->CI->imiconf_queries->fetch_records_imiconf("countries", " and id = ".$user_profile->row()->home_country." and paypal_email is not null");

					if ($country->num_rows() > 0) {
						$pay_email = $country->row()->paypal_email;
					}
				}
			}
		}

		if ( isset($_POST['home_country']) && $_POST['home_country'] != "" ){
			$country = $this->CI->imiconf_queries->fetch_records_imiconf("countries"," and id = ".$_POST['home_country']." and paypal_email is not null");

			if ( $country->num_rows() > 0 ){
				$pay_email = $country->row()->paypal_email;
			}

		}
		return (object) array("mode"					=> $mode,
							  "url"						=> SessionHelper::_get_session("PAYPAL_URL_LIVE", "site_settings"),
							  "business_email"			=> $pay_email );
	}
}
?>