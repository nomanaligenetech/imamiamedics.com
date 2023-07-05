<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PP_Arbaeen_Medical_Mission_Form extends C_frontend {

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
		replace_data_for_lang($content, $data['content_languages'], $content_languages, ['content'], SessionHelper::_get_session('LANG_CODE'));
		
		$data['content'] = $content->content ? $content->content : '';
		
		return $ci->load->view( "frontend/cms/page_plugins/pp_arbaeen_medical_mission_form", $data, TRUE );
	}
	
	
	static public function index( &$data = array(), $ci )
	{
		
		if ( ( $id = $ci->functions->_user_logged_in_details( "id" ) ) > 0 ){
			$user = $ci->imiconf_queries->fetch_records_imiconf('users',' and id = '.$id);
			$user_profile = $ci->imiconf_queries->fetch_records_imiconf('users_profile',' and userid = '.$id);
			$data['user'] = (object) array_merge((array)$user->row(),(array)$user_profile->row());
		}

		$data['countries'] = $ci->queries->fetch_records('countries')->result_array();

		$ci->form_validation->set_error_delimiters('', '');
		if ( isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest") {
			
			$return = array();
			$success = array();
			$error = false;
			$errors = array();
			$__data = $ci->session->userdata('formdata');

			
			if ( isset($_POST['step']) && (int) $_POST['step'] > 0 ){
				
				$step = $_POST['step'];

				switch ($step) {
					case 1:
						$_fields = array();
						$success = array('step' => 1,'content' => $ci->load->view("frontend/cms/page_plugins/pp_arbaeen_medical_mission_form/step2.php", $data, true));
						break;
					
					case 2:
						$_fields = array(
							'first_name' => array('title'=>lang_line('text_firstname'),'validation'=>'required|callback_validate_alpha_space'),
							'middle_name' => array('title'=>lang_line('text_middlename'),'validation'=>'required|callback_validate_alpha_space'),
							'last_name' => array('title'=>lang_line('text_lastname'),'validation'=>'required|callback_validate_alpha_space'),
							'birth_date' => array('title'=>lang_line('label_arbaeen_form_DOB'),'validation'=>'required|callback_valid_date_yyyy_mm_dd'),
							'age' => array('title'=>lang_line('label_arbaeen_form_age'),'validation'=>'required'),
							'occupation' => array('title'=>lang_line('label_arbaeen_form_occupation'),'validation'=>'required|callback_validate_alpha_space'),
							'speciality' => array('title'=>lang_line('label_arbaeen_form_speciality'),'validation'=>'required|callback_validate_alpha_space'),
							'email' => array('title'=>lang_line('text_email'),'validation'=>'required|valid_email'),
							'phone_number' => array('title'=>lang_line('text_phonenumber'),'validation'=>'required|callback_valid_phone'),
							'street_address' => array('title'=>lang_line('placeholder_arbaeen_form_street'),'validation'=>'required'),
							'street_address_2' => array('title'=>lang_line('placeholder_arbaeen_form_street_2'),'validation'=>''),
							'city' => array('title'=>lang_line('placeholder_arbaeen_form_city'),'validation'=>'required|callback_validate_alpha_space'),
							'region' => array('title'=>lang_line('placeholder_arbaeen_form_region'),'validation'=>'required|callback_validate_alpha_space'),
							'postal_code' => array('title'=>lang_line('placeholder_arbaeen_form_zipcode'),'validation'=>'required'),
							'country' => array('title'=>lang_line('text_country'),'validation'=>'required')
						);
						$success = array('step'=>2,'content'=> $ci->load->view("frontend/cms/page_plugins/pp_arbaeen_medical_mission_form/step3.php", $data, true));
						break;

					case 3:
						$_fields = array(
							'available_on_date' => array('title' => lang_line('text_whichdatewillyouavail'), 'validation' => 'required'),
							'activities_applying_for' => array('title' => lang_line('text_whichactivityapplying'), 'validation' => 'required'),
							'applying_position' => array('title' => lang_line('text_whichpositionapplying'), 'validation' => ''),
							'your_intention' => array('title' => lang_line('text_whydoyouwantmedicalmission'), 'validation' => 'required'),
							'stay_with_family' => array('title' => lang_line('text_interestedstayingwithfamily'), 'validation' => 'trim|required'),
							'languages' => array('title' => lang_line('text_whatlangcanyouspeak'), 'validation' => 'callback_validate_min_one_langauge'),
							'extra_information' => array('title' => lang_line('text_includeanyotherdetails'), 'validation' => 'max_length[3000]'),
						);

						if ( isset($_POST['activities_applying_for']) && $_POST['activities_applying_for'] != "To serve as international faculty for the IMI Arbaeen Health Conference" ){
							$_fields['applying_position']['validation'] = 'required'; 
						}
						
						if (isset($_POST['languages']) && in_array('Other',$_POST['languages'])){
							$_fields['other_language'] = array('title' => lang_line('text_other'),'validation' => 'required');
						}
						if ( empty($_FILES) || !isset($_FILES['cv_resume']['name']) ){
							$_fields['cv_resume'] = array('title' => lang_line('text_cvresume'),'validation' => 'required');
						}else{
							
							$allowed_file_types = array(
								'application/msword',
								'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
								'application/pdf'
							);
							if( !in_array($_FILES['cv_resume']['type'],$allowed_file_types) ){
								$_err['cv_resume'] = 'Allowed upload formats are: .pdf .doc .docx';
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
						
						$success = array('step' => 3, 'last_step'=>true, 'content' => $ci->load->view("frontend/cms/page_plugins/pp_arbaeen_medical_mission_form/step4.php", $data, true));
						break;

					case 4:
						$_fields = array(
							'agree_terms' => array('title' => lang_line('text_termsofservice'), 'validation' => 'callback_agree_terms_required'),
							'agree_active_paying_member' => array('title' => lang_line('text_activepayingmember'), 'validation' => 'callback_custom_required'),
							'agree_general_medical_camp' => array('title' => lang_line('text_generalmedicalcamp'), 'validation' => 'callback_custom_required'),
							'agree_work_diligently' => array('title' => lang_line('text_workdiligently'), 'validation' => ''),
							'agree_work_with_professionalism' => array('title' => lang_line('text_workwithprofessionalism'), 'validation' => ''),
							'agree_additional_shifts' => array('title' => lang_line('text_additionalshifts'), 'validation' => ''),
							'agree_commit_adhering_imi_governance' => array('title' => lang_line('text_committoadheringimi'), 'validation' => ''),
							'agree_represent_imi_in_the_field' => array('title' => lang_line('text_representimiinfield'), 'validation' => ''),
							'agree_activity_reported_to_imi' => array('title' => lang_line('text_activityreportedimi'), 'validation' => ''),
							'signature' => array('title' => lang_line('text_digitalsignature'), 'validation' => 'required')
						);

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

						$success = array('step' => 4, 'completed' => true, 'content' => $ci->load->view("frontend/cms/page_plugins/pp_arbaeen_medical_mission_form/thankyou.php", $data, true));
						break;
					
					default:
						$_fields = array();
						$success = array();
						break;
				}

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

						//set post in temp var for session
						if ( $key != 'signature' ){
							$__data[$key] = $ci->input->post($key);
						}

						$i++;
					}
				}
				//set temp data into session
				$ci->session->set_userdata(array('formdata' => $__data));
			}else{
				$_err = array(
					'step' => 'Invalid Form Step. Please Contact Administrator.'
				);
				$error = true;
				$errors = array_filter($_err);
			}

			if ( $error ){
				$return['error'] = $error;
				$return['error_messages'] = $errors;
			}else{
				$__data = $ci->session->userdata('formdata');
				$success['session'] = $__data;

				if ( isset($success['completed']) ){

					//save in db
					foreach ($__data as $key => $value) {
						if ( is_array($value) ){
							$__data[$key] = serialize($value);
						}
					}
					$__data['status'] = 'pending';
					$ci->imiconf_queries->SaveDeleteTables_imiconf($__data, 's', "tb_arbaeen_medical_mission", 'id');

					//Update Profile Options

					if ( ( $user_id = $ci->functions->_user_logged_in_details( "id" ) ) > 0 ){

						$user_profile_Data	= array(
							"userid"							=> $user_id,
							"cellphone_number"					=> $__data['phone_number'],

							"home_full_address"					=> $__data['street_address'],
							"home_country"						=> $__data['country'],
							"home_state_province"				=> $__data['region'],
							"home_city"							=> $__data['city'],
							"home_zipcode"						=> $__data['postal_code'],

							"occupation"						=> $__data['occupation'],
							"specialties"						=> $__data['speciality']
						);

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
												"email_heading"			=> "New application has been recieved for Arbaeen Medical Mission",
                                                "email_file"			=> "email/frontend/arbaeen_medical_submission_admin.php",
                                                "email_subject"			=> "New application has been recieved For Arbaeen Medical Mission",
												"default_subject"		=> true,
												"email_attachment"		=> $upload_dir = SERVER_ABSOLUTE_PATH_IMICONF . "./assets/files/arbaeen-mission/".$__data['cv_resume'],
                                                "email_post"			=> $__data
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
				}

				$return['success'] = true;
				$return['success_data'] = $success;
			}

			echo json_encode($return);
			exit;
		}
		return true;
	}
}