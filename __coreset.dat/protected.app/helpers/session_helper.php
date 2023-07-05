<?php
class SessionHelper
{
	function __construct()
	{
		parent::__construct();
		
	}


	/*
	*
	*	get site settings session data
	*
	*	@param string index key
	*	
	* 	@return the value of requested key for Site Setting from Session
	*/
	static function _get_site_settings_session_data( $return_col = '' )
	{
		return SessionHelper::_get_session($return_col, "site_settings");
	}
	
	
	
	
	/*
	*
	*	unset session
	*
	*	@param array (array with key|value to unset in session)
	*	@param string array key (if want to unset any particular field from array)
	*	
	* 	@return set record in session
	*/
	static function _unset_session( $insert_array = array(), $array_key = FALSE )
	{
		$CI =& get_instance();
		
		if ( $array_key )
		{
			$tmp_session									= $CI->session->userdata[ $array_key ];
			

			#for now unset full array
			$CI->session->unset_userdata( $array_key );
			
			
			#now unset those index which you want to remove from this temporary array
			foreach ( $insert_array as $tmp_key => $tmp_value )
			{
				unset( $tmp_session[$tmp_key] );
			}
			
			
			#now set data with temporary table. it will not remove those index
			$CI->session->set_userdata( array($array_key		=> $tmp_session ) );
		}
		else
		{
			$CI->session->unset_userdata( $insert_array );
		}
	}
	
	
	
	/*
	*
	*	set session
	*
	*	@param array (array with key|value to insert in session)
	*	@param string array key (if want to make this session as full_array)
	*	
	* 	@return set record in session
	*/
	static  function _set_session( $insert_array = array(), $array_key = FALSE )
	{
		$CI =& get_instance();
		
		if ( $array_key )
		{
			$tmp_session										= array();
			if ( isset($CI->session->userdata[ $array_key ]) )
			{
				$tmp_session									= $CI->session->userdata[ $array_key ];
			}
			
			
			#unset( $tmp_session[$set_col] );
			foreach ( $insert_array as $tmp_key => $tmp_value )
			{
				$tmp_session[$tmp_key]							= $tmp_value;
			}
			
			
			
			$CI->session->set_userdata( array($array_key		=> $tmp_session ) );
		}
		else
		{
			$CI->session->set_userdata( $insert_array );
		}
	}
	
	
	
	
	
	/**
	*
	*	get session
	*
	*	@param string index key
	*	@param string array key (if want to have value of any array)
	*	
	* 	@return mixed get record from session
	*/
	static function _get_session( $return_col = '', $array_key = FALSE )
	{		
		$CI =& get_instance();
		
		if ( $array_key )
		{
			
			if ( isset($CI->session->userdata[ $array_key ][ $return_col ] )  )
			{
		
				return $CI->session->userdata[ $array_key ][ $return_col ];
			}
		}
		else
		{
			if ( isset($CI->session->userdata[ $return_col ] )  )
			{
		
				return $CI->session->userdata[ $return_col ];
			}
		}
		
		
		return FALSE;
	}
	
	
	
	
	static function site_settings_session()
	{
		
		
		#SessionHelper::_unset_session("site_settings");
		$CI =& get_instance();
		
	
		
	
		//re-declare session parameters (muslim)
		$settings_master				= $CI->queries->fetch_records("site_settings_master", "",
			"email_mode, 
																	   email_from, 
																	   email_to, 
																	   site_meta_title, 
																	   admincms_meta_title, 
																	   email_subject, 
																	   email_from_name,
																	   getinvolved_menuid,
																	   whatwedo_menuid,
																	   stage3a_menuid,
																	   stage3b_menuid,
																	   events_menuid,
																	   superadmin_roleid,
																	   interviewer_roleid,
																	   paypal_mode, 
																	   paypal_email_sandbox, 
																	   paypal_email_live, 
																	   paypal_url_sandbox, 
																	   paypal_url_live,
																	   payeezy_mode,
																	   payeezy_url_sandbox, 
																	   payeezy_url_live,
																	   payeezy_exactid_sandbox, 
																	   payeezy_exactid_live, 
																	   payeezy_password_sandbox, 
																	   payeezy_password_live, 
																	   payeezy_hmacid_sandbox, 
																	   payeezy_hmacid_live,
																	   payeezy_hmackey_sandbox, 
																	   payeezy_hmackey_live"/*,
																	   payeezy_token_url,
																	   payeezy_apikey_sandbox, 
																	   payeezy_apikey_live, 
																	   payeezy_apisecret_sandbox, 
																	   payeezy_apisecret_live, 
																	   payeezy_mertoken_sandbox, 
																	   payeezy_mertoken_live,
																	   payeezy_transtoken_sandbox, 
	payeezy_transtoken_live"*/);
		

		#define SITE_SETTINGS CONSTANT
		$config							= $settings_master->row_array();

//        ~r($config);
		
		$TMP_alter_emails3				= generate_toccbcc_emails( $config['email_to'], array("email_to", "email_bcc"));
		
		$config							= merge_multi_arrays( array($config, $TMP_alter_emails3) );
		
		
		
		$session_array					= array_change_key_case($config,CASE_UPPER);
		
		
		
		
		$TMP_site_language				= 1;
		
		
		#now, fetch the language details from database-table to get languagefolder and set again in Site_Settings
		$change_site_language						= $CI->queries->fetch_records("languages", " AND id = '". $TMP_site_language ."'");
		
		$session_array["SITE_LANGUAGE_ID"]			= $change_site_language->row("id");
		$session_array["SITE_LANGUAGE"]				= $change_site_language->row("languageCode");
		$session_array["SITE_LANGUAGE_FOLDER"]		= $change_site_language->row("languagefolder");
		// $CI->lang->load('general', $change_site_language->row("languagefolder"));	
		$LANG_CODE = SessionHelper::_get_session('LANG_CODE');
		if(isset($_GET['lang']) && isset($LANG_CODE)){
			if($_GET['lang'] != $LANG_CODE){
				$LANG_CODE = $_GET['lang'];
				SessionHelper::_set_session(['LANG_CODE'=>$_GET['lang']]);
			}
		}
		if(!$LANG_CODE){
			SessionHelper::_set_session(['LANG_CODE'=>DEFAULT_LANG_CODE]);
		}
		$CI->lang->load('general', strtolower($LANG_CODE?$LANG_CODE:DEFAULT_LANG_CODE));	
		$CI->lang->load('general_frontend', strtolower($LANG_CODE?$LANG_CODE:DEFAULT_LANG_CODE));	
		$CI->lang->load('form_validation', strtolower($LANG_CODE?$LANG_CODE:DEFAULT_LANG_CODE));	

		
		$session_array["IMICONF_COUPON_CODE"]		= "";
		$imi_coupon_code							= $CI->db_imiconf->query("SELECT imi_coupon_code FROM tb_site_settings_master");
		if ( $imi_coupon_code -> num_rows() > 0 )
		{
			$session_array["IMICONF_COUPON_CODE"]	= $imi_coupon_code->row("imi_coupon_code");
		}

		if ( is_countryCheck(FALSE,FALSE,TRUE) == 'canada' ){
			$session_array['SITE_META_TITLE'] = $CI->functions->find_and_replace(0,"Imamia Medics Canada",$session_array['SITE_META_TITLE']);
			$session_array['EMAIL_FROM_NAME'] = $CI->functions->find_and_replace(0,"Imamia Medics Canada",$session_array['EMAIL_FROM_NAME']);
			$session_array['EMAIL_SUBJECT'] = $CI->functions->find_and_replace(0,"Imamia Medics Canada",$session_array['EMAIL_SUBJECT']);
			//$session_array['EMAIL_FROM'] = $CI->functions->find_and_replace(2,array(2=>'internationalconf@att.net'),$session_array['EMAIL_FROM']);
		}

		if ( is_countryCheck(FALSE,FALSE,TRUE) == 'medics' ){
			$session_array['SITE_META_TITLE'] = $CI->functions->find_and_replace(0,"Medics International",$session_array['SITE_META_TITLE']);
			$session_array['EMAIL_FROM_NAME'] = $CI->functions->find_and_replace(0,"Medics International",$session_array['EMAIL_FROM_NAME']);
			$session_array['EMAIL_SUBJECT'] = $CI->functions->find_and_replace(0,"Medics International",$session_array['EMAIL_SUBJECT']);
			//$session_array['EMAIL_FROM'] = $CI->functions->find_and_replace(2,array(2=>'internationalconf@att.net'),$session_array['EMAIL_FROM']);
		}

		SessionHelper::_unset_session("site_settings");
		SessionHelper::_set_session($session_array, "site_settings");

		if (  !$CI->validations->is_session("site_settings")  )
		{
			die("fa");
			SessionHelper::site_settings_session();
		}
	
	}
	static function active_conference_session()
	{
		$CI =& get_instance();
		
		
		$active_conference						= $CI->queries->fetch_records("short_conference", " AND status = '1'");
		$tmp_conf								= $active_conference->row_array();
		
		$conf_country							= $CI->queries->fetch_records("countries", " AND id = '". $tmp_conf['countryid'] ."'", "countries_name,countries_iso_code_2");
		$tmp_conf['country']					= $conf_country->row('countries_name');
		$tmp_conf['country_code']				= $conf_country->row('countries_iso_code_2');
		
		
		#remaining days in registration
		$TMP_todays_date						= date("Y-m-d", strtotime("now"));
		$TMP_registration_to_date				= date("Y-m-d", strtotime( $tmp_conf["registration_to"] ) );
		$tmp_conf['registration_days_remains']	= $CI->functions->days_between_dates(	$TMP_todays_date, $TMP_registration_to_date );
		
		if ( $TMP_registration_to_date ==  $TMP_todays_date)
		{
			$tmp_conf['registration_days_remains']			= 1;
		}
		#remaining days in registration
		
		
		
		
		if ( "conf_registration" == "conf_registration" )
		{
			$conf_registration									= $CI->queries->fetch_records("short_conference_registration_master", 
																							  "  AND conferenceid = '". $tmp_conf['id'] ."' 
																								 AND userid = '". $CI->functions->_user_logged_in_details( "id" ) ."' " , "id");
			
			$tmp_conf['registrationid']							= FALSE;
			if ( $conf_registration	-> num_rows() > 0 )
			{
				$tmp_conf['registrationid']		= $conf_registration->row('id');
			}
		}
		
		
		
		SessionHelper::_unset_session("conference");
		SessionHelper::_set_session($tmp_conf, "conference");
		
		
		return $tmp_conf;
	}
}