<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property Encrption encrption
 */
class C_validationcallbacks extends MY_Controller  {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	public function __construct()
	{
		parent::__construct();
	}
	
	function validate_commaseperated_multiemails( $str = '', $field_text = '', $text = '' )
	{
		
		$field_text				= explode(",", $field_text);
		
	
		$_explode				= explode(",", $str);
		
		
		$_bool					= TRUE;
		for ($x=0; $x < count( $_explode); $x++)
		{
			
			$email 			= trim ( $_explode[$x] );
			
			if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email) and $email != '') 
			{
				
				$this->form_validation->set_message('validate_commaseperated_multiemails',  "The <strong>". $field_text[1] ."</strong> field must contain a valid email address(es).");
				$_bool			= FALSE;
			}
			
		}
		
		return $_bool;
	}
	
	
	function validate_date_check($str, $format)
	{
		if ( !$format ) 
		{
			$format					= "dd-mm-yyyy";	
		}
		
		if ( $format == "dd-mm-yyyy" )
		{
			if (preg_match ("/^([0-9]{2})-([0-9]{2})-([0-9]{4})$/", $str, $parts))
			{
				//check weather the date is valid of not    
				
				$day			= $parts[1];
				$month			= $parts[2];
				$year			= $parts[3];
				
				/* 
				// for yyyy-mm-dd  
				$day       		= $parts[3];
				$month 			= $parts[2];
				$year        	= $parts[1];
				*/
				
				// checking 4 valid date
				
				if(checkdate($month,$day,$year))
				{
					return TRUE;	
				}
			}
		}
		else if ( $format == "yyyy-mm-dd" )
		{
			
			if (preg_match ("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$str, $parts))
			{
				//check weather the date is valid of not    
				
	
				// for yyyy-mm-dd  
				$day       		= $parts[2];
				$month 			= $parts[1];
				$year        	= $parts[0];
				
				
				// checking 4 valid date
				if(checkdate($month,$day,$year))
				{
					return TRUE;	
				}
			}
		}
		
		$this->form_validation->set_message('validate_date_check', "%s is not a valid date, use $format format");
		return false;
	}  
	
	function validate_date_time_check($str, $attributes)
	{
		//Array Index:
		//1- What input you are given 
		//2- Seperator
		
		
		$EXPLODE_attributes					= explode(",", $attributes);
		
		$TMP_return_text					= TRUE;
		switch ( $EXPLODE_attributes[0] )
		{
			case "H:i:s":
					$TMP_return_text		= verify_time_format( $EXPLODE_attributes[1] );
				break;
				
			default:
				break;
		}
		
		if ( !$TMP_return_text )
		{
			$this->form_validation->set_message('validate_date_time_check', $EXPLODE_attributes[2]);
			return false;	
		}
		else
		{
			return TRUE;	
		}
		
	}  


	public function validate_admincredentials()
	{
		$bool					= FALSE;
		
		$this->load->library("Encrption");
		
		$username 				= $this->input->post('username');
		$password 				= $this->input->post('password');
		
		
		
		
		$record					= $this->queries->fetch_records( "admin", " AND username = '$username' " );
		
		if ( $record -> num_rows() > 0 )
		{
			
			$decrypt_password 			= $this->encrption->decrypt( $record -> row("password") );
			
			
			if ( $password == $decrypt_password )
			{
				$bool			= TRUE;
			}
		}
		
		
		if ( $bool )
		{
			return TRUE;
		}
		else
		{
			# increment login attempt value
			if ( ! $this->session->userdata('login_attempt') ) {
				$this->session->set_userdata('login_attempt', 1);
			}
			else {
				$login_attempt = $this->session->userdata('login_attempt');
				$this->session->set_userdata('login_attempt', $login_attempt + 1);
			}
			
			$this->form_validation->set_message('validate_admincredentials', 'Credentials are not correct - Please retry');
			return FALSE;	
		}

	}
	
	
	public function validate_useremail()
	{
		$bool					= FALSE;
		$email 					= $this->input->post('email');
		
		
		
		
		
		$record					=  $this->imiconf_queries->fetch_records_imiconf( "users", " AND email = '$email' " );
		
		if ( $record -> num_rows() > 0 )
		{
			$bool			= TRUE;
		}
		
		
		if ( $bool )
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('validate_useremail', lang_line('text_callback_invalidemail'));
			return FALSE;	
		}

	}
	
	
	public function validate_usercredentials( $str, $mode )
	{
			
		$bool					= FALSE;
		$inactive				= FALSE;
		
		$this->load->library("Encrption");
		
		$email 					= $this->input->post('email');
		$password 				= $this->input->post('password');
		
		
		
		switch ( $mode )
		{
			case IMICONF_DATABASE_GROUP:
				$record					= $this->imiconf_queries->fetch_records_imiconf( "users", " AND email = '$email' " );
				break;
			
			default:
				$record					= $this->queries->fetch_records( "users", " AND email = '$email' " );
				break;
		}
		
		
		if ( $record -> num_rows() > 0 )
		{

			$row = $record->row();
			
			$decrypt_password 			= $this->encrption->decrypt( $record -> row("password") );
			
			
			if ( ($password == $decrypt_password) && $row->is_active == 1 && $row->is_blocked == 0 )
			{
				$bool			= TRUE;
			}elseif( ($password == $decrypt_password) && $row->is_active == 0 && $row->is_blocked == 0 ){
				$inactive		= TRUE;
			} elseif( ($password == $decrypt_password) && $row->is_blocked == 1 ){
				$blocked		= TRUE;
			}
		}
		
		
		if ( $bool )
		{
			return TRUE;
		}
		else
		{
			if ( $inactive ){

				/* $activation_code = random_string('alnum', 20);

				$updateData = array(
					"id" => $row->id,
					"activation_code" => $activation_code
				);

				$this->queries->SaveDeleteTables_imiconf($updateData, 'e', "tb_users", 'id');
				
				$email_data['name'] = $row->name;
				$email_data['last_name'] = $row->last_name;
				$email_data['email'] = $row->email;
				$email_data['password'] = $this->encrption->decrypt($row->password);
				$email_data['activation_link'] = site_url(). "register/activation/" . $activation_code;
				
				$email_template = array(
					"email_to" => $email,
					"email_heading" => lang_line('text_accountregistration/code'),
					"email_file" => "email/frontend/user_activation_code.php",
					"email_subject" => lang_line('text_accountregistration/code'),
					"default_subject" => true,
					"email_post" => $email_data
				);
				
				$is_email_sent = $this->_send_email($email_template); */
				$this->form_validation->set_message('validate_usercredentials', lang_line('text_callback_activationemailsent'));

			}elseif( $blocked ){
				$this->form_validation->set_message('validate_usercredentials', lang_line('text_callback_accountblocked'));
			}else{
				$this->form_validation->set_message('validate_usercredentials', lang_line('text_callback_credentialsnotcorrect'));
			}
			return FALSE;	
		}

	}
	

	public function validate_duplicate($db_data, $result)
	{
		
		$bool						= TRUE;
		
		if ( $result == "" )
		{
			$bool				= FALSE;
		}
		
		if ( $bool )
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('validate_duplicate', '%s contain duplicate values (already exsits in database)');
			return FALSE;	
			
		}
	}
	
	public function validate_confirm_password($new_password)
	{
		$this->load->library("Encrption");
		
		
		$old_password			= $this->queries->fetch_records("admin", " AND id = '". $this->functions->_admincms_logged_in_details( "id" ) ."' ")->row( "password" );
		
		
		$old_password			= $this->encrption->decrypt ( $old_password );
		
		if ($old_password != $new_password) 
		{
			$this->form_validation->set_message('validate_confirm_password', 'Old password is incorrect');
			return FALSE;
		} 
		else 
		{
			return TRUE;
		}
	}
	
	
	public function validate_user_confirm_password($new_password, $other_param = FALSE) //$other_param (1- which db to use, 2- error message
	{
		
		$this->load->library("Encrption");
		
		
		if ( $other_param )
		{
			$explode_other_param		= explode(",", $other_param);
			
			$DB2 						= $this->load->database($explode_other_param[0], TRUE);
		}
		else
		{
			$DB2						= $this->db;
			$explode_other_param[1]		= "Old password is incorrect";
		}
		
		$old_password				= $DB2->query("SELECT password FROM tb_users WHERE id = '". $this->functions->_user_logged_in_details( "id" ) ."' ")->row("password");
		
		$old_password				= $this->encrption->decrypt ( $old_password );					
		
		
		if ($old_password != $new_password) 
		{
			$this->form_validation->set_message('validate_user_confirm_password', $explode_other_param[1]);
			return FALSE;
		} 
		else 
		{
			return TRUE;
		}
	}
	
	function validate_urls($str)
	{	
	
		if( !filter_var( $str, FILTER_VALIDATE_URL ) )
		{
			$this->form_validation->set_message('validate_urls', 'Your URL of video is incorrect');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	
	}    
	
	function validate_captchacode($str)
    {
        if ( $this->session->userdata('captchaWord') != $str) 
		{
            $this->form_validation->set_message('validate_captchacode', lang_line('text_securitycode') . ' is Invalid');
            return FALSE;
        }
        return TRUE;
    }
	
	function validate_recaptcha($str)
    {
		$userIp = $this->input->ip_address();
		//$secret = '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe';  testing
		// $secret = '6Le_N_QUAAAAAMJ-3uK9dj283Ue3wBWTyAn6l8-K'; - old keys
		$secret = '6LdhgZgiAAAAAD-idgOIOxaMKODpBTG24v8ddfvl'; 
		$url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $str . "&remoteip=" . $userIp;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		curl_close($ch);

		$status = json_decode($output, true);
		if (!$status['success']) {
            $this->form_validation->set_message('validate_recaptcha', 'Google Recaptcha is Invalid! Try Again');
            return FALSE;
        }
        return TRUE;
		/*$ch = curl_init();
		$curlConfig = array(
			CURLOPT_URL            => "https://www.google.com/recaptcha/api/siteverify",
			CURLOPT_POST           => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_POSTFIELDS     => array(
				'secret' => $secret,
				'response' => $str,
				'remoteip' => $userIp
			)
		);
		curl_setopt_array($ch, $curlConfig);
		if($result = curl_exec($ch)){
			curl_close($ch);
			$response = json_decode($result); 
			var_dump($response); die('456');
			//return $response->success;
		}else{
			var_dump(curl_error($ch)); die('789');// this for debug remove after you test it
			//return false;
		}*/
    }	
	
	function validate_alpha_dash($str_in)
	{
		if (! preg_match("/^([-a-z])+$/i", $str_in)) 
		{
			$this->form_validation->set_message('validate_alpha_dash', 'The %s field may only contain alphabatic characters.');
			return FALSE;
		} else {
			return TRUE;
		}
	}  
	
	function validate_alpha_numeric_dash($str_in)
	{
		if (! preg_match("/^([-a-zA-Z0-9])+$/i", $str_in)) 
		{
			$this->form_validation->set_message( 'validate_alpha_numeric_dash', 'The %s field may only contain hyphens amd alpha numeric characters.');
			return FALSE;
		} else {
			return TRUE;
		}
    }  
	
	function validate_alpha_space($str_in)
	{
		if (! preg_match("/^([a-z ,])+$/i", $str_in))
		{
			$this->form_validation->set_message('validate_alpha_space', 'The %s field may only contain alphabatic characters.');
			return FALSE;
		} else {
			return TRUE;
		}
    }  
	
	function validate_alpha_space_slash($str_in)
	{
		if (! preg_match("/^([a-z ,\/*])+$/i", $str_in))
		{
			$this->form_validation->set_message('validate_alpha_space_slash', 'The %s field may only contain alphabatic characters.');
			return FALSE;
		} else {
			return TRUE;
		}
    }
	
	function validate_name($str_in)
	{
		if (! preg_match("/^([A-Z a-z])+$/i", $str_in)) 
		{
			$this->form_validation->set_message('validate_name', 'The %s field may only contain alphabatic characters.');
			return FALSE;
		} else {
			return TRUE;
		}
    }  
	

	public function print_error( $str, $error_name )
	{
		$this->form_validation->set_message('print_error', $error_name);
		return FALSE;
	}
	
	
	public function find_duplicate_values( $db_data, $orig_id, $fieldKey = "id" )
	{
		$bool						= TRUE;
		
		if ( $db_data -> num_rows() > 0 )
		{
			if ( $db_data -> row( $fieldKey ) != $orig_id )
			{
				$bool				= FALSE;
			}
		}
		
		if ( $bool )
		{
			return TRUE;
		}
		else
		{
			return FALSE;	
		}

	}

	public function validate_min_one_langauge()
	{
		if ( !isset($_POST['languages']) || empty($_POST['languages']) ){
			$this->form_validation->set_message('validate_min_one_langauge', 'Please select any one langauge');
			return FALSE;
		}
	}

	public function validate_min_one_health_cond()
	{
		if ( !isset($_POST['health_cond']) || empty($_POST['health_cond']) ){
			$this->form_validation->set_message('validate_min_one_health_cond', 'Please select atleast one option.');
			return FALSE;
		}
	}
	
	public function custom_required($str)
	{
		if ( $str == "" ){
			$this->form_validation->set_message('custom_required', 'This field is required');
			return FALSE;
		}
	}
	
	public function agree_terms_required($str)
	{
		if ( $str == "" ){
			$this->form_validation->set_message('agree_terms_required', 'You must agree with the terms of services.');
			return FALSE;
		}
	}

	public function valid_date_yyyy_mm_dd($str)
	{
		if ( $str != "" && !preg_match('/^(19[\d]{2}|2[\d]{3})-(0[1-9]|1[012])-([123]0|[012][1-9]|31)$/',$str) ){
			$this->form_validation->set_message('valid_date_yyyy_mm_dd', 'Please correct date format');
			return FALSE;
		}
	}
	
	public function valid_phone($str)
	{
		if ( $str != "" && !preg_match('/^\s*(?:\+?(\d{1,3}))?([-. (]*(\d{3})[-. )]*)?((\d{3})[-. ]*(\d{2,4})(?:[-.x ]*(\d+))?)\s*$/',$str) ){
			$this->form_validation->set_message('valid_phone', 'Please enter valid phone number');
			return FALSE;
		}
	}

	public function check_imi_id_exists($imi_id,$user_id)
	{
		if (strpos($_POST['imi_id'], 'autogenerated') !== false) {
            $imi_id = (int) filter_var($_POST['imi_id'], FILTER_SANITIZE_NUMBER_INT);
			$q = $this->db_imiconf->query('Select imi_id From generated_imi_ids Where imi_id = '.$imi_id.' and user_id != '.$user_id);
        }else{
			$q = $this->db_imiconf->query('Select imi_id From tb_users Where imi_id = '.$imi_id.' and id != '.$user_id);
		}

		if ($q->num_rows() > 0) {
			$this->form_validation->set_message('check_imi_id_exists','IMI ID already exist. Please try different');
			return FALSE;
		}
		return TRUE;
	}

	public function validate_imgdata($str)
	{
		$error = false;
		if (preg_match('/^data:image\/(\w+);base64,/', $str, $type)) {
			$img_data = substr( $str, strpos( $str, ',') + 1);
			$type = strtolower($type[1]); // jpg, png, gif

			if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
				$error = true;
			}

			$img_data = base64_decode($img_data);

			if ($img_data === false) {
				$error = true;
			}
		} else {
			$error = true;
		}

		if ( $error){
			$this->form_validation->set_message('validate_imgdata','Plea se provide proper signature');
			return false;
		}

		return TRUE;
	}

	public function validate_formatted_date($date)
	{
		if( !preg_match( '/^([0-9]{4})-(0[1-9]|1[012])-([123]0|[012][1-9]|31) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/',$date) ){
			$this->form_validation->set_message('validate_formatted_date', 'The %s field not contain valid date in format xxxx-xx-xx xx:xx:xx');
			return false;
		}
		return true;
	}
	
	public function validate_noofpersonscount($str_in)
	{
		$this->form_validation->set_message('validate_noofpersonscount', 'The no.of persons selected by you is less or greater than the no.of persons accompanying with you. The “Conference Registration” should match the total number of persons.' );
		return FALSE;
    }  
}