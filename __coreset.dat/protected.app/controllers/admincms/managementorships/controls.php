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
		
		
		$this->data["_heading"]										= 'Manage Mentorships';
		$this->data["_pagetitle"]									= $this->data["_heading"] . " - ";
		$this->data['_pageview']									= $this->data["_directory"] . "view.php";
		
		
		
		#pre-filled values for input fields
		$this->_create_fields_for_form(false, $this->data);
	}


    public function view_table_properties()
    {
        $tmp["tr_heading"] = array('Name', 'Last Name', 'Email', 'Employer', 'Proffession', 'Submit By User', 'Submission Date');

        return $tmp;
    }

    public function view()
    {
        $data = $this->data;

		$data["table_record"] = $this->queries->fetch_records("mentorship_form", " ORDER BY id DESC ");

		$data["table_properties"] = $this->view_table_properties();
		$this->load->view(ADMINCMS_TEMPLATE_VIEW, $data);
	}

	public function edit($edit_id)
	{

		$data = $this->data;
		$data['_pageview'] = $data["_directory"] . "edit.php";

		$data["edit_id"] = $edit_id;
		$edit_details = $this->queries->fetch_records("mentorship_form", " AND mf.id = '$edit_id'");
		//echo $this->db->last_query(); die;


		if ($edit_details->num_rows() <= 0) {
			show_404();
		}

		$edit_details = $edit_details->row_array();
		$edit_details['options'] = "edit";
		$edit_details['unique_formid'] = "";

		$this->_create_fields_for_form(true, $data, $edit_details);



		$this->load->view(ADMINCMS_TEMPLATE_VIEW, $data);

	}
	
	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array("id", "user_name", "user_email", "first_name", "last_name", "address", "address_2", "state", "city", "email", "zip", "employer", "profession", "university", "university_state", "university_city", "degree_type", "major", "graduate_year", "type", "user_id", "date_added", "options", "unique_formid" );
		
		$filled_inputs				= array("id", "user_name", "user_email", "first_name", "last_name", "address", "address_2", "state", "city", "email", "zip", "employer", "profession", "university", "university_state", "university_city", "degree_type", "major", "graduate_year", "type", "user_id", "date_added", "options", "unique_formid" );
		
		if ($return_array == true)
		{
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				

				$explode_empty_inputs			= explode( "|", $empty_inputs[$x] );
				$empty_inputs[$x]				= $explode_empty_inputs[0];
				$tmp_value						= $db_data[ $filled_inputs[$x] ];
				
				if ( count($explode_empty_inputs) > 1 )
				{
					switch ( $explode_empty_inputs[1] )
					{
						
							
						case "default_date":	
							$tmp_value			= date("d-m-Y", strtotime( $db_data[ $filled_inputs[$x] ] ) );
							break;
							
						case "default":	
							break;
					}
				}
				
				$data[ $empty_inputs[$x] ]		= $tmp_value;
				
			}
			
			
			return $data;
		}
		else
		{
		
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				$explode_empty_inputs				= explode( "|", $empty_inputs[$x] );
				$empty_inputs[$x]					= $explode_empty_inputs[0];
				$tmp_value							= "";
				
				
				if ( count($explode_empty_inputs) > 1 )
				{
					switch ( $explode_empty_inputs[1] )
					{
						
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
			$this->imiconf_queries->SaveDeleteTables($saveData, 'd', "tb_mentorship_form", 'id') ;
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



		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|callback_validate_name');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|callback_validate_name'); //

		$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('address_2', 'Address 2', 'trim');
		$this->form_validation->set_rules('state', 'State', 'trim|required|callback_validate_name');

		$this->form_validation->set_rules('city', 'City', 'trim|required|callback_validate_name');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

		$this->form_validation->set_rules('zip', 'Zip', 'trim');
		$this->form_validation->set_rules('employer', 'Employer', 'trim|required');
		$this->form_validation->set_rules('profession', 'Profession', 'trim|required');
		$this->form_validation->set_rules('university', 'University', 'trim');
		$this->form_validation->set_rules('university_state', 'University State', 'trim');
		$this->form_validation->set_rules('university_city', 'University City', 'trim');
		$this->form_validation->set_rules('degree_type', 'Degree Type', 'trim');
		$this->form_validation->set_rules('major', 'Major', 'trim');
		$this->form_validation->set_rules('graduate_year', 'Graduate Year', 'trim');
		
		if ($this->form_validation->run() == false) {
			$data['_pageview'] = $data["_directory"] . "edit.php";
			$data['_messageBundle'] = $this->_messageBundle('danger', validation_errors(), 'Error!');
			
			$this->load->view(ADMINCMS_TEMPLATE_VIEW, $data);
		} else {

			$saveData = array(
				'first_name'=>$this->input->post('first_name'),
				'last_name'=>$this->input->post('last_name'),
				'address'=>$this->input->post('address'),
				'address_2'=>$this->input->post('address_2'),
				'state'=>$this->input->post('state'),
				'city'=>$this->input->post('city'),
				'email'=>$this->input->post('email'),
				'zip'=>$this->input->post('zip'),
				'employer'=>$this->input->post('employer'),
				'profession'=>$this->input->post('profession'),
				'university'=>$this->input->post('university'),
				'university_state'=>$this->input->post('university_state'),
				'university_city'=>$this->input->post('university_city'),
				'degree_type'=>$this->input->post('degree_type'),
				'major'=>$this->input->post('major'),
				'graduate_year'=>$this->input->post('graduate_year')
			);

			$saveData['id'] = $this->input->post('id');
			$this->queries->SaveDeleteTables($saveData, 'e', "tb_mentorship_form", 'id');


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