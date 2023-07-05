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
		
		
		$this->data["_heading"]										= ' Add a post';
		$this->data["_pagetitle"]									= $this->data["_heading"];
		
		$this->TMP_dir												= "frontend/";
		$this->data['_pageview']									= $this->TMP_dir . $this->data["_directory"] . "view.php";
		
		
		
		#pre-filled values for input fields
		$this->_create_fields_for_form(false, $this->data);
		$this->load->library("Encrption");
		
	}
	
	
	public function view_table_properties()
	{
		$tmp["tr_heading"]											= array(lang_line("text_username") );
		
		return $tmp;
	}
	
	public function view()
	{
		$data														= $this->data;
		
		redirect ( site_url( $data["_directory"] . "controls/addpsot")  );
		
	}
	
	
	
	
	
	public function index ()
	{
		
	}
	
	
	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
	
		$empty_inputs				= array( "id", "topic_id",  "name", "created_by_user","options");
		
		$filled_inputs				= array( "id",  "topic_id",  "name",  "created_by_user","options");
		
		if ($return_array == true)
		{
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
			
				//echo $db_data[ $filled_inputs[$x] ]; die;		

				$explode_empty_inputs			= explode( "|", $empty_inputs[$x] );
				$empty_inputs[$x]				= $explode_empty_inputs[0];
		
				$tmp_value						= "";
				
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
	
	public function addpsot()
	{		
		$data														= $this->data;
		
		$data['_pageview']											= $this->TMP_dir . $data["_directory"] . "edit.php";
		
		$edit_details 												= $this->queries->fetch_records("getTopics", " ORDER BY `id` DESC");
		

		if ( $edit_details -> num_rows() <= 0 )
		{
			show_404();
		}
		
		$edit_details												= $edit_details->row_array();
		$edit_details['options']									= "edit";
		$edit_details['unique_formid']								= "";
		
		
		$this->_create_fields_for_form(true, $data, $edit_details );	
		
		
		#standard validation
		$this->functions->unite_post_values_form_validation();
		
        #To get user id 
        $userid=$this->functions->_user_logged_in_details('id'); 

		
		$this->form_validation->set_rules('name', 'Post', 'trim|required');
		$this->form_validation->set_rules('topic', 'Select topic', 'trim|required');
		
		if( $this->form_validation->run() == FALSE )
		{
			$data['_pageview']									= $this->TMP_dir . $data["_directory"] . "edit.php";
			$data['_messageBundle']								= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			$this->load->view( FRONTEND_TEMPLATE_ACCOUNT_VIEW, $data );
		}
		else
		{
			
			$saveData					= array(
												"name"					=> $this->input->post("name"),
												"topic_id"			    => $this->input->post("topic"),
												"slug"		            => $this->queries->make_slug("tb_posts",
																									   "id",
																									   "slug",
																									   "name",
																									   $this->input->post("name"),
																									 $this->input->post("id")),
												"created_by_user"       => $userid
												);
											
											
													
			
			
			$this->queries->SaveDeleteTables($saveData, 's', "tb_posts","id"); 
			
			
			$data['_messageBundle']									= $this->_messageBundle( 'success' , 
																							 "Your Post submited Successfully.", 
																							 lang_line("heading_operation_success"),
																							 false, 
																							 true);
				
			redirect ( site_url( $data["_directory"] . "controls/edit" ) );
			
	   	   }		
		
	    } 
	
	}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */