<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PP_Arbaeen_Medical_Mission_Form_New extends C_frontend {

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
	
	public function __construct(&$data, $ci)
	{
		
		parent::__construct();
		$ci->load->library('session');

		
		#$ci->data													= $ci->default_data();
		
	}
	
	
	
	
	static public function show( $data = array(), $ci )
	{
		$content = $ci->imiconf_queries->fetch_records_imiconf("arbaeenmedicalmission_content", " and id = 1 ");

		$content_languages = $ci->imiconf_queries->fetch_records_imiconf("arbaeenmedicalmission_content_languages", " AND arbaeenmedicalmission_content_id = {$content->row()->id}")->result_array();
		replace_data_for_lang($content, $data['content_languages'], $content_languages, ['content','content_fp'], SessionHelper::_get_session('LANG_CODE'));
		
		$data['content']       = $content->content ? $content->content : '';
		$data['content_fp']    = $content->content_fp ? $content->content_fp : '';
		// $data['countries']     = $ci->queries->fetch_records('countries')->result_array();
		// $data['country_codes'] = $ci->queries->fetch_records('country_phone_codes')->result_array();
		$data['countries'] = $ci->db->query("SELECT * from `tb_country_phone_codes` cpc inner join `tb_countries` c on cpc.country = c.id")->result_array();
		
		// var_dump($data['country']); die;

		if ( ( $id = $ci->functions->_user_logged_in_details( "id" ) ) > 0 ){
			$user = $ci->imiconf_queries->fetch_records_imiconf('users',' and id = '.$id);
			$user_profile = $ci->imiconf_queries->fetch_records_imiconf('users_profile',' and userid = '.$id);
			$data['user'] = (object) array_merge((array)$user->row(),(array)$user_profile->row());
		}
		
		if ( ! ( $id = $ci->functions->_user_logged_in_details( "id" ) ) > 0 ){
			$currentURL 		= uri_string();
			$tmp_lasturl		= array("last_url"		=> $currentURL);
			SessionHelper::_set_session($tmp_lasturl);
		}
		return $ci->load->view( "frontend/cms/page_plugins/pp_arbaeen_medical_mission_form_new", $data, TRUE );
	}
	
	
	static public function index( &$data = array(), $ci )
	{
		
		$ci->form_validation->set_error_delimiters('', '');
		if ( isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest") {
			
			$return = array();
			$success = array();
			$error = false;
			$errors = array();
			$__data = $ci->session->userdata('formdata');
						$_fields = array();
						$_fields = array(
				'first_name' 	   => array('title' => lang_line('text_firstname'),'validation'=>'required|callback_validate_alpha_space'),
				'middle_name'	   => array('title' => lang_line('text_middlename'),'validation'=>'required|callback_validate_alpha_space_slash'),
				'last_name'  	   => array('title' => lang_line('text_lastname'),'validation'=>'required|callback_validate_alpha_space'),
				'other_name'  	   => array('title' => lang_line('label_othername'),'validation'=>''),
				'street_address'   => array('title' => lang_line('placeholder_arbaeen_form_street'),'validation'=>''),
				'street_address_2' => array('title' => lang_line('placeholder_arbaeen_form_street_2'),'validation'=>''),
				'city' 			   => array('title' => lang_line('placeholder_arbaeen_form_city'),'validation'=>''),
				'region'		   => array('title' => lang_line('placeholder_arbaeen_form_region'),'validation'=>''),
				'postal_code' 	   => array('title' => lang_line('placeholder_arbaeen_form_zipcode'),'validation'=>''),
				'country' 		   => array('title' => lang_line('text_country'),'validation'=>'required'),
				'occupation' 	   => array('title' => lang_line('label_role'),'validation'=>'required'),
				'email' 		   => array('title' => lang_line('text_email'),'validation'=>'required|valid_email'),
				'phone_country_code' => array('title' => lang_line('text_phone_country_code'),'validation'=>'required'),
				'phone_number'     => array('title' => lang_line('text_phonenumber'),'validation'=>'required|callback_valid_phone'),
				'health_his'       => array('title' => lang_line('label_arbaeen_form_health_his'),'validation'=>'callback_custom_required|max_length[3000]'),
				'citizenship'      => array('title' => lang_line('label_arbaeen_form_citizenship'), 'validation' => 'trim|required'),
				'birth_date'       => array('title' => lang_line('label_arbaeen_form_DOB'), 'validation' => 'required|callback_valid_date_yyyy_mm_dd'),
				'passportno'       => array('title' => lang_line('text_passportno'), 'validation' => 'trim|required|max_length[12]'),
				'passport_expiry'  => array('title' => lang_line('text_dateofexpiry'), 'validation' => 'required|callback_valid_date_yyyy_mm_dd'),
				'agree_terms'      => array('title' => lang_line('text_termsofservice'), 'validation' => 'callback_agree_terms_required'),
				'signature'        => array('title' => lang_line('text_digitalsignature'), 'validation' => 'required'),
				// 'phone_country_code' => array('title' => lang_line('text_phone_country_code'),'validation'=>''),
				// 'available_on_date' => array('title' => lang_line('text_whichdatewillyouavail'), 'validation' => 'required'),
							//'activities_applying_for' => array('title' => lang_line('text_whichactivityapplying'), 'validation' => 'required'),
				// 'applying_position' => array('title' => lang_line('text_whichpositionapplying'), 'validation' => ''),
				// 'your_intention' => array('title' => lang_line('text_whydoyouwantmedicalmission'), 'validation' => 'required'),
							//'stay_with_family' => array('title' => lang_line('text_interestedstayingwithfamily'), 'validation' => 'trim|required'),
				// 'languages' => array('title' => lang_line('text_whatlangcanyouspeak'), 'validation' => 'callback_validate_min_one_langauge'),
				// 'extra_information' => array('title' => lang_line('text_includeanyotherdetails'), 'validation' => 'max_length[3000]'),
							// 'gender' => array('title'=>explode(":",lang_line('label_gender'))[0],'validation'=>'required'),
							// 'birth_date' => array('title'=>lang_line('label_arbaeen_form_DOB'),'validation'=>'required|callback_valid_date_yyyy_mm_dd'),
							// 'age' => array('title'=>lang_line('label_arbaeen_form_age'),'validation'=>'required'),
							// 'occupation' => array('title'=>lang_line('label_arbaeen_form_occupation'),'validation'=>'required|callback_validate_alpha_space_slash'),
							// 'speciality' => array('title'=>lang_line('label_arbaeen_form_speciality'),'validation'=>'required|callback_validate_alpha_space_slash'),
				// 'how_old' => array('title'=>lang_line('label_arbaeen_form_how_old'),'validation'=>'callback_custom_required'),
				// 'know_bmi' => array('title'=>lang_line('label_arbaeen_form_know_bmi'),'validation'=>'callback_custom_required'),
				// 'bmi' => array('title'=>lang_line('label_arbaeen_form_bmi'),'validation'=>'callback_custom_required'),
				// 'smoking_hist' => array('title'=>lang_line('label_arbaeen_form_smoking_hist'),'validation'=>'callback_custom_required'),
				// 'med_his' => array('title'=>lang_line('label_arbaeen_form_med_his'),'validation'=>'callback_custom_required'),
				// 'med_curr' => array('title'=>lang_line('label_arbaeen_form_med_curr'),'validation'=>'callback_custom_required'),
				// 'med_list' => array('title'=>lang_line('label_arbaeen_form_med_list'),'validation'=>'max_length[3000]'),
				// 'health_cond' => array('title'=>lang_line('label_arbaeen_form_health_cond'),'validation'=>'callback_validate_min_one_health_cond'),
				// "type_covid19" => array('title'=>'Covid19','validation'=>''),
				// "type_diabetes" => array('title'=>'Type of Diabetes','validation'=>''),
				// "type_heart_disease" => array('title'=>'Heart Disease','validation'=>''),
				// 'covid_vacc' => array('title'=>lang_line('label_arbaeen_form_covid_vacc'),'validation'=>'callback_custom_required'),
				// "covid_vacc_det" => array('title'=>'Covid Details','validation'=>'max_length[3000]'),
				// 'available_on_date' => array('title' => lang_line('text_whichdatewillyouavail'), 'validation' => 'required'),
				//'activities_applying_for' => array('title' => lang_line('text_whichactivityapplying'), 'validation' => 'required'),
				// 'applying_position' => array('title' => lang_line('text_whichpositionapplying'), 'validation' => ''),
				// 'your_intention' => array('title' => lang_line('text_whydoyouwantmedicalmission'), 'validation' => 'required'),
				//'stay_with_family' => array('title' => lang_line('text_interestedstayingwithfamily'), 'validation' => 'trim|required'),
				// 'languages' => array('title' => lang_line('text_whatlangcanyouspeak'), 'validation' => 'callback_validate_min_one_langauge'),
				// 'extra_information' => array('title' => lang_line('text_includeanyotherdetails'), 'validation' => 'max_length[3000]'),
				// 'agree_active_paying_member' => array('title' => lang_line('text_activepayingmember'), 'validation' => 'callback_custom_required'),
				// 'agree_general_medical_camp' => array('title' => lang_line('text_generalmedicalcamp'), 'validation' => ''),
				// 'agree_work_diligently' => array('title' => lang_line('text_workdiligently'), 'validation' => ''),
				// 'agree_work_with_professionalism' => array('title' => lang_line('text_workwithprofessionalism'), 'validation' => ''),
				// 'agree_additional_shifts' => array('title' => lang_line('text_additionalshifts'), 'validation' => ''),
				// 'agree_commit_adhering_imi_governance' => array('title' => lang_line('text_committoadheringimi'), 'validation' => 'callback_custom_required'),
				// 'agree_covid19_risk' => array('title' => lang_line('text_agree_covid19_risk'), 'validation' => ''),
				// 'agree_medical_camp' => array('title' => lang_line('text_understand_med_camp'), 'validation' => ''),
				// 'agree_represent_imi_in_the_field' => array('title' => lang_line('text_representimiinfield'), 'validation' => ''),
				// 'agree_activity_reported_to_imi' => array('title' => lang_line('text_activityreportedimi'), 'validation' => ''),
						);

						if ( empty($_FILES) || !isset($_FILES['cv_resume']['name']) ){
							$_fields['cv_resume'] = array('title' => lang_line('text_cvresume'),'validation' => 'required');
						}else{
							
							$allowed_file_types = array(
								'application/msword',
								'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
								'application/pdf',
								'image/jpeg',
								'image/jpg',
								'image/png'
							);
							if( !in_array($_FILES['cv_resume']['type'],$allowed_file_types) ){
								$_err['cv_resume'] = 'Allowed upload formats are: .pdf .doc .docx .png .jpg .jpeg';
							}else{
								$tmp_name = $_FILES["cv_resume"]["tmp_name"];
								$file_name = basename($_FILES["cv_resume"]["name"]);
								$upload_dir = SERVER_ABSOLUTE_PATH_IMICONF . "./assets/files/arbaeen-mission/";
								if( !is_file($upload_dir.$file_name) ){
									$uploaded = move_uploaded_file($tmp_name, $upload_dir.$file_name);
								}else{
									$explode = explode('.',$file_name);
									$file_name = $explode[0].time().rand(1,99).'.'.$explode[1];
									$uploaded = move_uploaded_file($tmp_name, $upload_dir.$file_name);
								}
									
								if (is_dir($upload_dir) && is_writable($upload_dir)) {
									if ( $uploaded ){
										$__data['cv_resume'] = $file_name;
									}else{
										$_err['cv_resume'] = 'Error in uploading. Please contact administartor.';
									}
								}else{
									$_err['cv_resume'] = 'Upload directory is not writable, or does not exist.';
								}
							}
						}
						
			if ( empty($_FILES) || !isset($_FILES['passport_copy']['name']) ){
							$_fields['passport_copy'] = array('title' => lang_line('text_passportcopyupload'),'validation' => 'required');
						}else{

							$allowed_file_types = array(
								'image/jpeg',
								'image/jpg',
								'image/gif',
								'image/png'
						);
							if( !in_array($_FILES['passport_copy']['type'],$allowed_file_types) ){
								$_err['passport_copy'] = 'Allowed upload formats are: .jpeg .jpg .png .gif';
							}else{
								$tmp_name = $_FILES["passport_copy"]["tmp_name"];
								$file_name = basename($_FILES["passport_copy"]["name"]);
								$upload_dir = SERVER_ABSOLUTE_PATH_IMICONF . "./assets/files/arbaeen-mission/";
								if( !is_file($upload_dir.$file_name) ){
									$uploaded = move_uploaded_file($tmp_name, $upload_dir.$file_name);
								}else{
									$explode = explode('.',$file_name);
									$file_name = $explode[0].time().rand(1,99).'.'.$explode[1];
									$uploaded = move_uploaded_file($tmp_name, $upload_dir.$file_name);
								}
								if (is_dir($upload_dir) && is_writable($upload_dir)) {
									if ( $uploaded ){
										$__data['passport_copy'] = $file_name;
									}else{
										$_err['passport_copy'] = 'Error in uploading. Please contact administartor.';
									}
								}else{
									$_err['passport_copy'] = 'Upload directory is not writable, or does not exist.';
								}
							}
						}
						
						if ( empty($_FILES) || !isset($_FILES['passport_pic']['name']) ){
							$_fields['passport_pic'] = array('title' => lang_line('text_passportsizephotoupload'),'validation' => 'required');
						}else{
							
							$allowed_file_types = array(
								'image/jpeg',
								'image/jpg',
								'image/gif',
								'image/png'
							);
							if( !in_array($_FILES['passport_pic']['type'],$allowed_file_types) ){
								$_err['passport_pic'] = 'Allowed upload formats are: .jpeg .jpg .png .gif';
							}else{
								$tmp_name = $_FILES["passport_pic"]["tmp_name"];
								$file_name = basename($_FILES["passport_pic"]["name"]);
								$upload_dir = SERVER_ABSOLUTE_PATH_IMICONF . "./assets/files/arbaeen-mission/";
								if( !is_file($upload_dir.$file_name) ){
									$uploaded = move_uploaded_file($tmp_name, $upload_dir.$file_name);
								}else{
									$explode = explode('.',$file_name);
									$file_name = $explode[0].time().rand(1,99).'.'.$explode[1];
									$uploaded = move_uploaded_file($tmp_name, $upload_dir.$file_name);
								}
								if (is_dir($upload_dir) && is_writable($upload_dir)) {
									if ( $uploaded ){
										$__data['passport_pic'] = $file_name;
									}else{
										$_err['passport_pic'] = 'Error in uploading. Please contact administartor.';
									}
								}else{
									$_err['passport_pic'] = 'Upload directory is not writable, or does not exist.';
								}
							}
			}

						if ( isset($_POST['signature']) ){

							$img_data = $_POST['signature'];

							if (preg_match('/^data:image\/(\w+);base64,/', $img_data, $type)) {
								$img_data = substr($img_data, strpos($img_data, ',') + 1);
								$type = strtolower($type[1]); // jpg, png, gif

								if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
									$_err['signature'] = 'Please provide proper signature';
								}

								$img_data = base64_decode($img_data);

								if ($img_data === false) {
									$_err['signature'] = 'Please provide proper signature';
								}
							} else {
								$_err['signature'] = 'Please provide proper signature';
							}

							$file_name = 'signature'.time().rand(1,99).'.png';
							$upload_dir = SERVER_ABSOLUTE_PATH_IMICONF . "./assets/files/arbaeen-mission/";
							$uploaded = file_put_contents($upload_dir.$file_name,$img_data);
							if (is_dir($upload_dir) && is_writable($upload_dir)) {
								if ($uploaded) {
									$__data['signature'] = $file_name;
								} else {
									$_err['signature'] = 'Error in uploading. Please contact administartor.';
								}
							} else {
								$_err['signature'] = 'Upload directory is not writable, or does not exist.';
							}
						}
						
			$PII_fields = ['phone_number', 'passportno', 'passport_expiry', 'birth_date'];
			$ci->load->library("Encrption");
			if (!empty($_fields)){
					$i = 1;
					foreach ($_fields as $key => $field) {

						
						//validations
                        if ($field['validation'] != "") {
                            $ci->form_validation->set_rules($key, $field['title'], $field['validation']);

                            if ($ci->form_validation->run() == false) {
                                //errors
                                $_err[$key] = form_error($key);
                            }
                        }

						if (count($_fields) == $i){
							if (!empty($_err)) {
								$error = true;
								$errors = array_filter($_err);
							}
						}

						if ( $key == 'passport_expiry' ){
							if($key == 'passport_expiry'){
								if( strtotime( $ci->input->post('passport_expiry') ) <= strtotime('2024-02-09') ){
									$data['text_expired_passport_submission_line'] = lang_line('text_expired_passport_submission_line');
									$data['text_expired_passport_submission_line_contd'] = lang_line('text_expired_passport_submission_line_contd');
								}
							}
						}
						
						//set post in temp var for session
						if ( $key != 'signature' ){
							$__data[$key] = $ci->input->post($key);
						}

						if ( $key == 'phone_number' ){
							$__data[$key] = '+' . $__data['phone_country_code'] . $__data[$key];
						}

						if(in_array($key, $PII_fields)){
							$__data[$key] = $ci->encrption->encrypt($__data[$key]);
						}

						$i++;
					}
					unset($__data['phone_country_code']);
				}
				
				//set temp data into session
				$ci->session->set_userdata(array('formdata' => $__data));
			if ( $error ){
				$return['error'] = $error;
				$return['error_messages'] = $errors;
			}else{
				$__data = $ci->session->userdata('formdata');
				$success['session'] = $__data;

				// if ( isset($success['completed']) ){

					//save in db
					foreach ($__data as $key => $value) {
						if ( is_array($value) ){
							$__data[$key] = serialize($value);
						}
					}
					$__data['status'] = 'pending';
					/* echo '<pre>';
					print_r($__data);
					echo '</pre>'; die; */
					$data_arbaeeen_added = $ci->imiconf_queries->SaveDeleteTables_imiconf($__data, 's', "tb_arbaeen_medical_mission", 'id');

					if($data_arbaeeen_added){

					//Update Profile Options

					if ( ( $user_id = $ci->functions->_user_logged_in_details( "id" ) ) > 0 ){

						$user_profile_Data	= array(
							"userid"							=> $user_id,
							"cellphone_number"					=> $ci->encrption->decrypt($__data['phone_number']),
							"home_full_address"					=> $__data['street_address'],
							//"home_country"					=> $__data['country'],
							"home_state_province"				=> $__data['region'],
							"home_city"							=> $__data['city'],
							"home_zipcode"						=> $__data['postal_code'],

							"occupation"						=> $__data['occupation'],
							// "specialties"						=> $__data['speciality'],

							"gender"							=> $__data['gender']
						);
						$countryId = DropdownHelper::country_dropdown(false, 'id', false, $__data['country']);
						if($countryId){
							$user_profile_Data["home_country"]	= $countryId;
						}

						$users_data = array(
							'id'	=> $user_id,
							'name' => $__data['first_name'],
							'middle_name' => $__data['middle_name'],
							'last_name' => $__data['last_name']
						);

						$q = $ci->db_imiconf->query('Select id FROM tb_users_profile where userid = ' . $user_id);
						$user_profile_Data['id'] = $q->row()->id;
						$ci->imiconf_queries->SaveDeleteTables_imiconf( $users_data, 'e', "tb_users", 'id');
						$ci->imiconf_queries->SaveDeleteTables_imiconf($user_profile_Data, 'e', "tb_users_profile", 'id');
						
					}

					//send email
					$email_template			= array(
												"email_to"				=> array("imihq@imamiamedics.com", "imiwaiting@att.net", "imiarbaeen@gmail.com", "sakinarizviimi@gmail.com", "jaffrysyed@gmail.com"),
												"email_heading"			=> "New application has been recieved for Arbaeen Medical Mission",
                                                "email_file"			=> "email/frontend/arbaeen_medical_submission_admin.php",
                                                "email_subject"			=> "New application has been recieved For Arbaeen Medical Mission",
												"default_subject"		=> true,
												"email_attachment"		=> array($upload_dir = SERVER_ABSOLUTE_PATH_IMICONF . "./assets/files/arbaeen-mission/".$__data['cv_resume'], SERVER_ABSOLUTE_PATH_IMICONF . "./assets/files/arbaeen-mission/".$__data['passport_copy'], SERVER_ABSOLUTE_PATH_IMICONF . "./assets/files/arbaeen-mission/".$__data['passport_pic']),
                                                "email_post"			=> $__data,
												"email_decrypted"       => array(
													'phone_number'    => $ci->encrption->decrypt($__data['phone_number']),
													'passportno'      => $ci->encrption->decrypt($__data['passportno']),
													'passport_expiry' => $ci->encrption->decrypt($__data['passport_expiry']),
													'birth_date'      => $ci->encrption->decrypt($__data['birth_date'])
													)
											);
					$is_email_sent			= $ci->_send_email( $email_template );
					
					//send email
					$email_template			= array(
												"email_to"				=> $__data['email'],
												"email_heading"			=> "Your application has been recieved for Arbaeen Medical Mission",
                                                "email_file"			=> "email/frontend/arbaeen_medical_submission_user.php",
                                                "email_subject"			=> "Your application has been recieved for Arbaeen Medical Mission",
                                                "default_subject"		=> true,
                                                "email_post"			=> $__data
											);
					$is_email_sent			= $ci->_send_email( $email_template );


					$ci->session->set_userdata(array('formdata' => array()));
				// }

				$success = array('step' => 5,'content' => $ci->load->view("frontend/cms/page_plugins/pp_arbaeen_medical_mission_form_new/thankyou.php", $data, true));

				$return['success'] = true;
				$return['success_data'] = $success;
			}else{
				$return['error'] = $error;
				$return['error_messages'] = 'Something went wrong, your application was not submitted. Please try again.';
			}
			}

			echo json_encode($return);
			exit;
		}
		return true;
	}
}