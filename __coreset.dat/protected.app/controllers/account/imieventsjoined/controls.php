<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controls extends C_frontend {

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
		
		
		$this->data["_heading"]										= 'Events Joined';
		$this->data["_pagetitle"]									= $this->data["_heading"];
		
		
		$this->TMP_dir												= "frontend/";
		$this->data['_pageview']									= $this->TMP_dir . $this->data["_directory"] . "view.php";
		
		#pre-filled values for input fields
		$this->_create_fields_for_form(false, $this->data);
	}
	
	
	public function view_table_properties()
	{
		$tmp["tr_heading"] = array	(
            'Event Name',
            'Joined Date',
            'Updated Date',
            'Status'
		);
		
		return $tmp;
	}
	
	public function view()
	{
		$data														= $this->data;
		
		$data["table_record"]										= $this->queries->fetch_records("joined_events", 
                                                                                                    " AND je.userid = ".$this->functions->_user_logged_in_details("id")." ORDER BY date_added DESC");
		
		$data["table_properties"]									= $this->view_table_properties();


		$data['_messageBundle2']									= $this->_messageBundle( 'danger' , '<p>' . lang_line("text_norecordfound") . '</p>', 'Error!');
		
		$this->load->view( FRONTEND_TEMPLATE_ACCOUNT_VIEW, $data );
		
	}
	
	public function index ()
	{
		
	}
	
	public function add()
	{
		$data												= $this->data;
		
		
		$data['_pageview']									= $this->TMP_dir . $data["_directory"] . "edit.php";

		
		$this->load->view( FRONTEND_TEMPLATE_ACCOUNT_VIEW, $data );	
	}
	
	public function save ()
	{
		$data														= $this->data;
		$languages													= $data["languages"];
		
		if ( ! $this->validations->is_post() )
		{
			redirect ( site_url( $data["_directory"] . "controls/view" ) );
		}
		
        $this->functions->unite_post_values_form_validation();
        
		$this->form_validation->set_rules("event", "Event Status", "trim|required");
		$this->form_validation->set_rules("id", "Event id", "trim|required");
		
		if( $this->form_validation->run() == FALSE )
		{
            if ($edit_id = $this->input->post('id') ){
                $edit_details = $this->queries->fetch_records("joined_events", " AND je.id = '$edit_id' AND je.userid = " . $this->functions->_user_logged_in_details("id") . " ORDER BY date_added DESC ");
                $edit_details = $edit_details->row_array();
                $edit_details['options'] = "edit";
                $edit_details['unique_formid'] = "";
                $this->_create_fields_for_form(true, $data, $edit_details);
            }
            
			$data['_pageview']									= $this->TMP_dir . $data["_directory"] . "edit.php";
			$data['_messageBundle']								= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			
			$this->load->view( FRONTEND_TEMPLATE_ACCOUNT_VIEW, $data );
		}
		else
		{
	
			$saveData['id']										= $this->input->post('id');
            $saveData['event']									= $this->input->post('event');
            
            $this->queries->SaveDeleteTables($saveData, 'e', "tb_join_event", 'id');  
			
			$data['_messageBundle']									= $this->_messageBundle( 'success' , 
																							 lang_line("operation_saved_success"), 
																							 lang_line("heading_operation_success"),
																							 false, 
																							 true);

			redirect( $data["_directory"] . "controls/view" );
		}
		
	}
	
	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array( "id", "userid", "event", "title", "date_added", "date_updated" , "options", "unique_formid" );
		
		$filled_inputs				= array( "id", "userid", "event", "title", "date_added", "date_updated", "options", "unique_formid" );
		
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
	
	public function edit( $edit_id )
	{
		
		$data														= $this->data;
		$data['_pageview']											= $this->TMP_dir . $data["_directory"] . "edit.php";
		
		$data["edit_id"]											= $edit_id;
		$edit_details												= $this->queries->fetch_records("joined_events", " AND je.id = '$edit_id' AND je.userid = " . $this->functions->_user_logged_in_details("id") . " ORDER BY date_added DESC ");
		
		if ( $edit_details -> num_rows() <= 0 )
		{
			show_404();
		}
		
		
		
		
		
		$edit_details												= $edit_details->row_array();
		$edit_details['options']									= "edit";
		$edit_details['unique_formid']								= "";
		
		$this->_create_fields_for_form(true, $data, $edit_details );
		
		$this->load->view( FRONTEND_TEMPLATE_ACCOUNT_VIEW, $data );
		
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */