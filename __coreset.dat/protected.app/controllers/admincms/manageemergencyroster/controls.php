<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property CI_Input input
 * @property CI_Output output
 * @property Functions functions
 */
class Controls extends C_admincms {

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
		
		$this->_auth_login( false );
		
		$this->data													= $this->default_data();
		
		$this->data["_directory"]									= $this->router->directory;
		$this->data["_pagepath"]									= $this->router->directory . $this->router->class;
		
		
		$this->data["_heading"]										= 'Manage Emergency Roster';
		$this->data["_pagetitle"]									= $this->data["_heading"] . " - ";
		$this->data['_pageview']									= $this->data["_directory"] . "view.php";
		
		
		
		#pre-filled values for input fields
		$this->_create_fields_for_form(false, $this->data);
	}


    public function view_table_properties()
    {
        $tmp["tr_heading"] = array('Name', 'Email', 'Resume', 'Passport', 'Photo', 'Signature', 'Parent Signature', 'Submission Date');

        return $tmp;
    }

    public function view()
    {
        $data = $this->data;

		$data["table_record"] = $this->queries->fetch_records("emergency_roster_form", " ORDER BY id DESC ");

		$data["table_properties"] = $this->view_table_properties();
		$this->load->view(ADMINCMS_TEMPLATE_VIEW, $data);
	}

	public function edit($edit_id)
	{

		$data = $this->data;
		$data['_pageview'] = $data["_directory"] . "edit.php";

		$data["edit_id"] = $edit_id;
		$edit_details = $this->queries->fetch_records("emergency_roster_form", " AND erf.id = '$edit_id'");
		//echo $this->db->last_query(); die;


		if ($edit_details->num_rows() <= 0) {
			show_404();
		}

		$edit_details = $edit_details->row_array();
		$edit_details['options'] = "edit";
		$edit_details['unique_formid'] = "";
        
		self::_create_fields_for_form(true, $data, $edit_details);

		$this->load->view(ADMINCMS_TEMPLATE_VIEW, $data);

	}
	
	public static function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
        $empty_inputs				= array( "id","name","address","preffered_mode_of_contact","contact_number","email","occupation","specialities","citizenship", "date_of_birth|default_date","passport_number", "date_of_issue|default_date","place_of_issue", "date_of_expiration|default_date","marital_status","tshirt_size","question_why_to_go_on_emer_relief_mission","question_time_to_take_off_short_notice","question_foreign_language_skills","question_any_other_skills","question_attended_emer_relief_before","question_any_difficulty_in_foreign_country","medical_physical_status","medical_physical_reason","list_any_medications","list_any_allergies","primary_emer_contact_name","primary_emer_contact_relationship","primary_emer_contact_address","primary_emer_contact_telephone","primary_emer_contact_email","secondary_emer_contact_name","secondary_emer_contact_relationship","secondary_emer_contact_address","secondary_emer_contact_telephone","secondary_emer_contact_email","short_biography","signature","parent_signature","user_id","resume","passport","photo_image","date_added","type","options" );
        
        $filled_inputs				= array( "id","name","address","preffered_mode_of_contact","contact_number","email","occupation","specialities","citizenship", "date_of_birth","passport_number", "date_of_issue","place_of_issue", "date_of_expiration","marital_status","tshirt_size","question_why_to_go_on_emer_relief_mission","question_time_to_take_off_short_notice","question_foreign_language_skills","question_any_other_skills","question_attended_emer_relief_before","question_any_difficulty_in_foreign_country","medical_physical_status","medical_physical_reason","list_any_medications","list_any_allergies","primary_emer_contact_name","primary_emer_contact_relationship","primary_emer_contact_address","primary_emer_contact_telephone","primary_emer_contact_email","secondary_emer_contact_name","secondary_emer_contact_relationship","secondary_emer_contact_address","secondary_emer_contact_telephone","secondary_emer_contact_email","short_biography","signature","parent_signature","user_id","resume","passport","photo_image","date_added","type","options" );
        
        if ($return_array == true) {
            for ($x=0;  $x < count($empty_inputs); $x++) {
                $explode_empty_inputs			= explode("|", $empty_inputs[$x]);
                $empty_inputs[$x]				= $explode_empty_inputs[0];
        
                $tmp_value						= $db_data[ $filled_inputs[$x] ];
                
                if (count($explode_empty_inputs) > 1) {
                    switch ($explode_empty_inputs[1]) {
                        case "default_date":
                            $tmp_value			= date("d-m-Y", strtotime($db_data[ $filled_inputs[$x] ]));
                            break;
                            
                        case "default":
                            break;
                    }
                }
                
                $data[ $empty_inputs[$x] ]		= $tmp_value;
            }
            
            
            return $data;
        } else {
            for ($x=0;  $x < count($empty_inputs); $x++) {
                $explode_empty_inputs				= explode("|", $empty_inputs[$x]);
                $empty_inputs[$x]					= $explode_empty_inputs[0];
                $tmp_value							= "";
                
                
                if (count($explode_empty_inputs) > 1) {
                    switch ($explode_empty_inputs[1]) {
                        case "default_date":
                            $tmp_value				= "00-00-0000";
                            break;
                            
                        case "default":
                            break;
                    }
                }
                
                $data[ $empty_inputs[$x] ]		= $tmp_value;
            }
            
            return $data;
        }
    }
	
	public function options()
	{
		$data					= $this->data;
		$is_post				= FALSE;
		
		if ( isset($_POST['checkbox_options']) )
		{
		
			if (count($_POST['checkbox_options']) > 0 )
			{
				$is_post		= TRUE;
			}
				
		}
		
		
		if ($is_post)
		{
			switch ($_POST['options'])
			{
				
				case "delete":
					$this->delete( $_POST['checkbox_options'] );
					break;
					
					
				default:
					$data['_messageBundle']								= $this->_messageBundle( 'danger' , "Invalid Operation", 'Error!', true);
					redirect(  site_url( $data["_directory"] . "controls/view" ) );
					break;
				
			}
		}
		else
		{
			$data['_messageBundle']								= $this->_messageBundle( 'danger' , "Invalid Operation", 'Error!', true);
			redirect( site_url( $data["_directory"] . "controls/view" ) );
		}

	}
	
	public function delete( $id )
	{
		$data												= $this->data;
		
		
		
		#remove record from DETAIL table
		foreach ($id	as $key	=> $result)
		{
			$saveData['id']									= $result;	
			$this->imiconf_queries->SaveDeleteTables($saveData, 'd', "tb_emergency_roster_form", 'id') ;
		}
		
		
		
		
		$data['_messageBundle']								= $this->_messageBundle('success' , 
																					lang_line("operation_delete_success"), 
																					lang_line("heading_operation_success"), 
																					false,
																					true);
		redirect(  site_url( $data["_directory"] . "controls/view" )  );
		
	}

	public function save()
	{
		$data = $this->data;
		
		if (!$this->validations->is_post()) {
			redirect(site_url($data["_directory"] . "controls/view"));
		}
		

		#standard validation
		$this->form_validation->set_rules("id", "id", "trim");
		$this->form_validation->set_rules("options", "options", "trim");
		$this->form_validation->set_rules("unique_formid", "unique_formid", "trim");



		$this->form_validation->set_rules('name', 'Name', 'trim|required|callback_validate_name');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        
        $this->form_validation->set_rules('occupation', 'Occupation', 'trim|required');
        $this->form_validation->set_rules('specialities', 'Specialities', 'trim|required');
        $this->form_validation->set_rules('citizenship', 'Citizenship', 'trim|required|callback_validate_name');
        $this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'trim|required|callback_validate_date_check[dd-mm-yyyy]');
        $this->form_validation->set_rules('passport_number', 'Passport Number', 'trim|required|callback_validate_alpha_numeric_dash');
        $this->form_validation->set_rules('date_of_issue', 'Date of Issue', 'trim|required|callback_validate_date_check[dd-mm-yyyy]');
        $this->form_validation->set_rules('place_of_issue', 'Place of Issue', 'trim|required|callback_validate_name');
        $this->form_validation->set_rules('date_of_expiration', 'Date of Expiration', 'trim|required|callback_validate_date_check[dd-mm-yyyy]');
        
        $this->form_validation->set_rules('marital_status', 'Marital Status', 'trim|required');
        $this->form_validation->set_rules('tshirt_size', 'T-shirt Size', 'trim|required');
        
        $this->form_validation->set_rules('question_why_to_go_on_emer_relief_mission', 'Why to go on Emergency Relief Mission', 'trim|required');
        $this->form_validation->set_rules('question_time_to_take_off_short_notice', 'Time to take off short notice', 'trim|required');
        $this->form_validation->set_rules('question_foreign_language_skills', 'Foreign Language Skills', 'trim|required');
        $this->form_validation->set_rules('question_any_other_skills', 'Any other skills', 'trim|required');
        $this->form_validation->set_rules('question_attended_emer_relief_before', 'Attended Emergency Relief Before', 'trim|required');
        $this->form_validation->set_rules('question_any_difficulty_in_foreign_country', 'Any difficulty in foreign country', 'trim|required');
        
        $this->form_validation->set_rules('medical_physical_status', 'Medical Physical Status', 'trim|required');
        if (($this->input->post("medical_physical_status"))) {
            $this->form_validation->set_rules('medical_physical_reason', 'Medical Physical Reason', 'trim|required');
        }
        
        $this->form_validation->set_rules('list_any_medications', 'List any Medications', 'trim|required');
        $this->form_validation->set_rules('list_any_allergies', 'List any Allergies', 'trim|required');
        $this->form_validation->set_rules('primary_emer_contact_name', 'Name', 'trim|required');
        $this->form_validation->set_rules('primary_emer_contact_relationship', 'Relationship', 'trim|required|callback_validate_name');
        $this->form_validation->set_rules('primary_emer_contact_address', 'Address', 'trim|required');
        $this->form_validation->set_rules('primary_emer_contact_telephone', 'Telephone', 'trim|required');
        $this->form_validation->set_rules('primary_emer_contact_email', 'Email', 'trim|required|valid_email');
        
        
        $this->form_validation->set_rules('secondary_emer_contact_name', 'Name', 'trim|required');
        $this->form_validation->set_rules('secondary_emer_contact_relationship', 'Relationship', 'trim|required|callback_validate_name');
        $this->form_validation->set_rules('secondary_emer_contact_address', 'Address', 'trim|required');
        $this->form_validation->set_rules('secondary_emer_contact_telephone', 'Telephone', 'trim|required');
        $this->form_validation->set_rules('secondary_emer_contact_email', 'Email', 'trim|required|valid_email');
        
        $this->form_validation->set_rules('short_biography', 'Short Biography', 'trim|required');

		
		if ($this->form_validation->run() == false) {
			$this->form_validation->set_error_delimiters('<p class="error">', '</p>');
			$data['_pageview'] = $data["_directory"] . "edit.php";
			$data['_messageBundle'] = $this->_messageBundle('danger', validation_errors(), 'Error!');
			
			$this->load->view(ADMINCMS_TEMPLATE_VIEW, $data);
		} else {

			$saveData = array(
				"name"											=> $this->input->post("name"),
				"address"			 							=> $this->input->post("address"),
				"preffered_mode_of_contact"						=> $this->input->post("preffered_mode_of_contact"),	
				"contact_number"								=> $this->input->post("contact_number"),
				"email"											=> $this->input->post("email"),
				"occupation"									=> $this->input->post("occupation"),
				"specialities"									=> $this->input->post("specialities"),
				"citizenship"									=> $this->input->post("citizenship"),
				"date_of_birth"									=> date("Y-m-d", strtotime($this->input->post("date_of_birth")) ),
				"passport_number"								=> $this->input->post("passport_number"),
				"date_of_issue"									=> date("Y-m-d", strtotime($this->input->post("date_of_issue")) ),
				"place_of_issue"								=> $this->input->post("place_of_issue"),
				"date_of_expiration"							=> date("Y-m-d", strtotime($this->input->post("date_of_expiration")) ),
				"marital_status"								=> $this->input->post("marital_status"),
				"tshirt_size"									=> $this->input->post("tshirt_size"),
				"question_why_to_go_on_emer_relief_mission"		=> $this->input->post("question_why_to_go_on_emer_relief_mission"),												
				"question_why_to_go_on_emer_relief_mission"		=> $this->input->post("question_why_to_go_on_emer_relief_mission"),
				"question_time_to_take_off_short_notice"		=> $this->input->post("question_time_to_take_off_short_notice"),
				"question_foreign_language_skills"				=> $this->input->post("question_foreign_language_skills"),
				"question_any_other_skills"						=> $this->input->post("question_any_other_skills"),
				"question_attended_emer_relief_before"			=> $this->input->post("question_attended_emer_relief_before"),
				"question_any_difficulty_in_foreign_country"	=> $this->input->post("question_any_difficulty_in_foreign_country"),
				"medical_physical_status"						=> format_bool( $this->input->post("medical_physical_status") ),
				"medical_physical_reason"						=> $this->input->post("medical_physical_reason"),
				"list_any_medications"							=> $this->input->post("list_any_medications"),
				"list_any_allergies"							=> $this->input->post("list_any_allergies"),
				"primary_emer_contact_name"						=> $this->input->post("primary_emer_contact_name"),
				"primary_emer_contact_relationship"				=> $this->input->post("primary_emer_contact_relationship"),
				"primary_emer_contact_address"					=> $this->input->post("primary_emer_contact_address"),
				"primary_emer_contact_telephone"				=> $this->input->post("primary_emer_contact_telephone"),
				"primary_emer_contact_email"					=> $this->input->post("primary_emer_contact_email"),
				"secondary_emer_contact_name"					=> $this->input->post("secondary_emer_contact_name"),
				"secondary_emer_contact_relationship"			=> $this->input->post("secondary_emer_contact_relationship"),
				"secondary_emer_contact_address"				=> $this->input->post("secondary_emer_contact_address"),												
				"secondary_emer_contact_telephone"				=> $this->input->post("secondary_emer_contact_telephone"),
				"secondary_emer_contact_email"					=> $this->input->post("secondary_emer_contact_email"),
				"short_biography"								=> $this->input->post("short_biography"),
			);

			$saveData['id'] = $this->input->post('id');
			$this->queries->SaveDeleteTables($saveData, 'e', "tb_emergency_roster_form", 'id');


			$data['_messageBundle'] = $this->_messageBundle(
				'success',
				lang_line("operation_saved_success"),
				lang_line("heading_operation_success"),
				false,
				true
			);

			redirect($data["_directory"] . "controls/view");

		}

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */