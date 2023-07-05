<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PP_Arbaeen_Medical_Mission_Stage3b_Form extends C_frontend {

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
	
	
	
	
	static public function show( &$data = array(), $ci )
	{
		if (in_array("payment_success", $ci->uri->segments)) {
			PP_Arbaeen_Medical_Mission_Stage3b_Form::payment_success($data, $ci);
		} else if (in_array("payment_notify", $ci->uri->segments)) {
			PP_Arbaeen_Medical_Mission_Stage3b_Form::payment_success($data, $ci);
		} else if (in_array("payment_cancel", $ci->uri->segments)) {
			PP_Arbaeen_Medical_Mission_Stage3b_Form::payment_cancel($data, $ci);
		}else{

			$content = $ci->imiconf_queries->fetch_records_imiconf("arbaeenmedicalmission_content", " and id = 1 ");

			$content_languages = $ci->imiconf_queries->fetch_records_imiconf("arbaeenmedicalmission_content_languages", " AND arbaeenmedicalmission_content_id = {$content->row()->id}");
		
			$data['content'] = $content_languages->num_rows() > 0 ? $content_languages->row()->stage3b_form : '';
			
			return $ci->load->view( "frontend/cms/page_plugins/pp_arbaeen_medical_mission_stage3b_form", $data, TRUE );
		}
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
						$success = array('step' => 1,'content' => $ci->load->view("frontend/cms/page_plugins/pp_arbaeen_medical_mission_stage3b_form/step2.php", $data, true));
						break;
					
					case 2:
						$_fields = array(
							'first_name' => array('title'=>lang_line('text_firstname'),'validation'=>'required|callback_validate_alpha_space'),
							'last_name' => array('title'=>lang_line('text_lastname'),'validation'=>'required|callback_validate_alpha_space'),
							'email' => array('title'=>lang_line('text_email'), 'validation'=>'required|valid_email'),
							'phone_number' => array('title'=>lang_line('text_phonenumber'),'validation'=>'required|callback_valid_phone'),
							'biography' => array('title'=>lang_line('text_biography'), 'validation'=>'required|max_length[300]'),
						);
						$success = array('step'=>2,'content'=> $ci->load->view("frontend/cms/page_plugins/pp_arbaeen_medical_mission_stage3b_form/step3.php", $data, true));
						break;

					case 3:
						$_fields = array(
							'citizenship' => array('title' => lang_line('text_citizenship'), 'validation'=> 'required'),
							'passport_number' => array('title' => lang_line('text_passportno'), 'validation' => 'required'),
							'passport_issue_date' => array('title' => lang_line('text_dateofissue'), 'validation' => 'required|callback_valid_date_yyyy_mm_dd'),
							'passport_expiry_date' => array('title' => lang_line('text_dateofexpiry'), 'validation' => 'required|callback_valid_date_yyyy_mm_dd'),
							'passport_issue_place' => array('title' => lang_line('text_placeofissue'), 'validation' => 'required'),
							'birth_date' => array('title' => lang_line('label_arbaeen_form_DOB'), 'validation' => 'required|callback_valid_date_yyyy_mm_dd'),
							'birth_place' => array('title' => lang_line('text_placeofbirth'), 'validation' => 'required')
						);
						
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
							$_fields['passport_pic'] = array('title' => 'Passport Sized Photograph Upload','validation' => 'required');
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
						
						$success = array('step' => 3, 'content' => $ci->load->view("frontend/cms/page_plugins/pp_arbaeen_medical_mission_stage3b_form/step4.php", $data, true));
						break;

					case 4:
						$_fields = array(
							'emergency_primary_first_name' => array('title' => lang_line('text_primaryemergency_firstname'), 'validation' => 'required'),
							'emergency_primary_last_name' => array('title' => lang_line('text_primaryemergency_lastname'), 'validation' => 'required'),
							'emergency_primary_email' => array('title' => lang_line('text_primaryemergency_email'), 'validation' => 'required|valid_email'),
							'emergency_primary_phone' => array('title' => lang_line('text_primaryemergency_phone'), 'validation' => 'required|callback_valid_phone'),
							'emergency_primary_address' => array('title' => lang_line('text_primaryemergency_address'), 'validation' => 'required'),
							'emergency_primary_city' => array('title' => lang_line('text_primaryemergency_city'), 'validation' => 'required'),
							'emergency_primary_state' => array('title' => lang_line('text_primaryemergency_state'), 'validation' => 'required'),
							'emergency_primary_postal_code' => array('title' => lang_line('text_primaryemergency_postalcode'), 'validation' => 'required'),
							'emergency_primary_country' => array('title' => lang_line('text_primaryemergency_country'), 'validation' => 'required'),
							'emergency_secondary_first_name' => array('title' => lang_line('text_secondaryemergency_firstname'), 'validation' => 'required'),
							'emergency_secondary_last_name' => array('title' =>lang_line('text_secondaryemergency_lastname'), 'validation' => 'required'),
							'emergency_secondary_email' => array('title' => lang_line('text_secondaryemergency_email'), 'validation' => 'required|valid_email'),
							'emergency_secondary_phone' => array('title' => lang_line('text_secondaryemergency_phone'), 'validation' => 'required|callback_valid_phone'),
							'emergency_secondary_address' => array('title' => lang_line('text_secondaryemergency_address'), 'validation' => 'required'),
							'emergency_secondary_city' => array('title' => lang_line('text_secondaryemergency_city'), 'validation' => 'required'),
							'emergency_secondary_state' => array('title' => lang_line('text_secondaryemergency_state'), 'validation' => 'required'),
							'emergency_secondary_postal_code' => array('title' => lang_line('text_secondaryemergency_postalcode'), 'validation' => 'required'),
							'emergency_secondary_country' => array('title' => lang_line('text_secondaryemergency_country'), 'validation' => 'required')
						);

						$success = array('step' => 4, 'content' => $ci->load->view("frontend/cms/page_plugins/pp_arbaeen_medical_mission_stage3b_form/step5.php", $data, true));
						break;
					case 5:
						$_fields = array(
							'program_cost' => array('title' => 'Program Cost', 'validation' => 'required'),
							'additional_donation' => array('title' => 'Additional Donation', 'validation' => 'required'),
							'accomodation_option' => array('title' => 'Accomodation Option', 'validation' => 'required')
						);

						$data['program_cost'] = $_POST['program_cost'];
						$data['additional_donation'] = $_POST['additional_donation'];
						$data['accomodation_option'] = $_POST['accomodation_option'];

						$success = array('step' => 5, 'last_step' => true, 'content' => $ci->load->view("frontend/cms/page_plugins/pp_arbaeen_medical_mission_stage3b_form/step6.php", $data, true));
						break;
					case 6:
						$_fields = array(
							'agree_terms' => array('title' => 'Terms of Service', 'validation' => 'callback_agree_terms_required'),
							'signature' => array('title' => 'Digital Signature', 'validation' => 'required'),
							//'total_amount' => array('title'=>'Total Amount','validation'=>'required')
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
						if ($_POST['paymode'] == 'paypal'){
							$data['__process_to_paypal'] = true;
						}
						$success = array('step' => 6, 'completed' => true, 'content' => $ci->load->view("frontend/cms/page_plugins/pp_arbaeen_medical_mission_stage3b_form/payment.php", $data, true));
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
						if ( $key != 'signature' && $key != "agree_terms" ){
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
					$ci->imiconf_queries->SaveDeleteTables_imiconf($__data, 's', "tb_arbaeen_medical_mission_stage3b", 'id');
					$inserted_id = $ci->db_imiconf->insert_id();

					$data['stage3_id'] = $inserted_id;
					$data['formdata'] = $success['session'];
					$success['content'] = $ci->load->view("frontend/cms/page_plugins/pp_arbaeen_medical_mission_stage3b_form/thankyou.html", $data, true);
					//Update Profile Options

					// if ( ( $user_id = $ci->functions->_user_logged_in_details( "id" ) ) > 0 ){

					// 	$user_profile_Data	= array(
					// 		"userid"							=> $user_id,
					// 		"cellphone_number"					=> $__data['phone_number'],

					// 		"home_full_address"					=> $__data['street_address'],
					// 		"home_country"						=> $__data['country'],
					// 		"home_state_province"				=> $__data['region'],
					// 		"home_city"							=> $__data['city'],
					// 		"home_zipcode"						=> $__data['postal_code'],

					// 		"occupation"						=> $__data['occupation'],
					// 		"specialties"						=> $__data['speciality']
					// 	);

					// 	$users_data = array(
					// 		'id'	=> $user_id,
					// 		'name' => $__data['first_name'],
					// 		'middle_name' => $__data['middle_name'],
					// 		'last_name' => $__data['last_name']
					// 	);

					// 	$q = $ci->db_imiconf->query('Select id FROM tb_users_profile where userid = ' . $user_id);
					// 	$user_profile_Data['id'] = $q->row()->id;
					// 	$ci->imiconf_queries->SaveDeleteTables_imiconf( $users_data, 'e', "tb_users", 'id');
					// 	$ci->imiconf_queries->SaveDeleteTables_imiconf($user_profile_Data, 'e', "tb_users_profile", 'id');
						
					// }

					//send email
					$email_template			= array(
												"email_heading"			=> "Stage 3b form submission for Arbaeen Medical Mission",
                                                "email_file"			=> "email/frontend/arbaeen_medical_stage3_submission_admin.php",
                                                "email_subject"			=> "Stage 3b form submission for Arbaeen Medical Mission",
												"default_subject"		=> true,
												//"email_attachment"		=> $upload_dir = SERVER_ABSOLUTE_PATH_IMICONF . "./assets/files/arbaeen-mission/".$__data['cv_resume'],
                                                "email_post"			=> $__data
											);
					$is_email_sent			= $ci->_send_email( $email_template );
					
					//send email
					$email_template			= array(
												"email_to"				=> $__data['email'],
												"email_heading"			=> "Your Stage 3b application has been recieved for Arbaeen Medical Mission",
                                                "email_file"			=> "email/frontend/arbaeen_medical_stage3_submission_user.php",
                                                "email_subject"			=> "Your Stage 3b application has been recieved for Arbaeen Medical Mission",
                                                "default_subject"		=> true,
                                                "email_post"			=> $__data
											);
					$is_email_sent			= $ci->_send_email( $email_template );

					//$ci->session->set_userdata(array('formdata' => array()));


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