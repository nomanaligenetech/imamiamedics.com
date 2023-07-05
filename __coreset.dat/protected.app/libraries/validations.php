<?php
class Validations
{
	function validations()
	{
		$this->CI =& get_instance();
	}
	
	function is_post()
	{
		if ( count( $_POST ) <= 0 )
		{
			return FALSE;
		}
		
		return TRUE;
	}
	
	function is_numeric( $id )
	{
		if ( !is_numeric( $id ) ) 
		{
			return FALSE;
		}
		else if ($id == "")
		{
			return FALSE;	
		}
		else if ($id == NULL)
		{
			return FALSE;	
		}
		
		
		return TRUE;
	}
	
	
	
	function is_dimension( $other_upload )
	{
		$proceed_further					= "";
		
		
		if (!array_key_exists('is_multiple', $other_upload))
		{
			$other_upload['is_multiple']		= FALSE;
		}
		
		
		if (!array_key_exists('validate_dimension', $other_upload))
		{
			$other_upload['validate_dimension']		= FALSE;
		}
		
		if (!array_key_exists('width', $other_upload))
		{
			$other_upload['width']		= FALSE;
		}
		
		if (!array_key_exists('height', $other_upload))
		{
			$other_upload['height']		= FALSE;
		}
		
		
		if ( $other_upload['validate_dimension'] )
		{
			if ( $other_upload['is_multiple'] )
			{
				$TMP_input_field					= $other_upload['hdn_field'] . '[]';
				foreach ($_FILES[$other_upload['input_field']]['tmp_name'] as $tmp_name )
				{
					if ( $tmp_name != "" )
					{
						$TMP_array					= getimagesize( $tmp_name );
						
						if (  ( $TMP_array[0] != $other_upload['width']  and $TMP_array[1] != $other_upload['height'] ) and  $other_upload['width'] and  $other_upload['height'] )
						{
							$proceed_further			= "All Image(s) width/height must be " . $other_upload['width'] . "px / " . $other_upload['height'] . "px";
		
						}
						else if (  $TMP_array[0] != $other_upload['width'] and $other_upload['width'] )
						{
							$proceed_further			= "All Image(s) width must be " . $other_upload['width'] . "px";
							
						}
						else if (  $TMP_array[1] != $other_upload['height'] and $other_upload['height'] )
						{
							$proceed_further			= "All Image(s) height must be " . $other_upload['height'] . "px";
							
						}
					}
					
				}
				
				
				
				
				if ( $proceed_further != "" )
				{
					$this->CI->form_validation->set_rules($TMP_input_field, "photo_image", "trim|callback_print_error[".$proceed_further."]");	
					return FALSE;
				}
			}
			else
			{
				$TMP_input_field					= $other_upload['hdn_field'];
				$tmp_name							= $_FILES[$other_upload['input_field']]['tmp_name'];
				if ( TRUE )
				{
					
					
					if ( $tmp_name != "" )
					{
						$TMP_array					= getimagesize( $tmp_name );
						
						if (  ( $TMP_array[0] != $other_upload['width']  and $TMP_array[1] != $other_upload['height'] ) and  $other_upload['width'] and  $other_upload['height'] )
						{
							$proceed_further			= "All Image(s) width/height must be " . $other_upload['width'] . "px / " . $other_upload['height'] . "px";
		
						}
						else if (  $TMP_array[0] != $other_upload['width'] and $other_upload['width'] )
						{
							$proceed_further			= "All Image(s) width must be " . $other_upload['width'] . "px";
							
						}
						else if (  $TMP_array[1] != $other_upload['height'] and $other_upload['height'] )
						{
							$proceed_further			= "All Image(s) height must be " . $other_upload['height'] . "px";
							
						}
					}
					
					
					if ( $proceed_further != "" )
					{
						return $proceed_further;
					}
					
				}
			}
		}
		
		
		
		
		return TRUE;
	}
	
	
	
	/*
	*
	*	is_session
	*
	*	@param string session_key (only to find session value with key)
	*	@param array is_array (if its array than give value)
	*	-- three conditions to check
	*	1- if its array and session_key empty - it will check only that array in session
	*	2- if its array and session_key have value - it will check session_key in that array
	*	3- if its not array and session_key have whatever value
	*	
	* 	@return set record in session
	*/
	function is_session( $session_key = FALSE, $is_array = FALSE )
	{
		
		$return_type				= FALSE;
		
		if ( $is_array and !$session_key)
		{
			if ( isset ($this->CI->session->userdata[ $is_array ]) )
			{
				if ( is_array ($this->CI->session->userdata[ $is_array ]) )
				{
					if ( count($this->CI->session->userdata[ $is_array ]) > 0 )
					{
						$return_type			= TRUE;
						
					}
				}
			}
		}
		else if ( $is_array and $session_key)
		{
			if ( isset ($this->CI->session->userdata[ $is_array ][ $session_key ] ) )
			{
				$return_type			= TRUE;
			}
		}
		else
		{
			if ( isset ($this->CI->session->userdata[ $session_key ] ) )
			{
				$return_type			= TRUE;
			}
		}
		
		
		return $return_type;
	}
	
	
	
	
	function is_date( $date  = FALSE )
	{
		if ( !strtotime( $date ) || strtotime( $date ) <= 0 )
		{
			return FALSE;
		}
		
		return TRUE;
	}

	function is_conference_registration_expired( $is_redirect = TRUE )
	{
		
		$is_expired						= FALSE;	
		if ( SessionHelper::_get_session("registration_days_remains", "shortconference") <= 0 )
		{
			#$is_expired					= TRUE;	
		}
		
		if ( SessionHelper::_get_session("registration_closed", "shortconference")  )
		{
			$is_expired					= TRUE;	
		}
		
	
		
		
		$is_Debug							= FALSE;
		
		if ( is_localhost() and !$is_Debug )
		{
			$is_expired					= FALSE;	
		}
		
		
		if ( array_key_exists("REMOTE_ADDR", $_SERVER) and !$is_Debug)
		{
			$allowed_ip					= array("202.142.145.170");
			
			if ( in_array($_SERVER['REMOTE_ADDR'], $allowed_ip) )
			{
				$is_expired					= FALSE;		
			}
		}
		

		
		if ( $is_redirect )
		{
			if ( $is_expired )
			{
				
				redirect( site_url( "shortconference/" . SessionHelper::_get_session("slug", "shortconference") . "/registration/closed" ) );
			}
		}
		else
		{
			return $is_expired;	
		}
		
	}
	function is_registration_valid( $conference, $is_earlybird	= TRUE )
	{
		$todaydate						= strtotime(date("Y-m-d"));
		
		if ( $is_earlybird )
		{
			
			$registrationdate			= date("Y-m-d", strtotime( $conference->row("registration_from") ) );
			$registrationdate			= strtotime($registrationdate);
			
			
			#if today date is greater than registration start date - than expired.
			if ( $todaydate <= $registrationdate )
			{
				return TRUE;	
			}
			
		}
		else
		{
			$registration_startdate			= date("Y-m-d", strtotime( $conference->row("registration_from") ) );
			$registration_startdate			= strtotime($registration_startdate);
			
			
			$registration_enddate			= date("Y-m-d", strtotime( $conference->row("registration_to") ) );
			$registration_enddate			= strtotime($registration_enddate);
			
			if ( $todaydate > $registration_startdate )
			{
				return TRUE;
			}
			
			
		}
		
		
		return FALSE;
		
	}
}
?>