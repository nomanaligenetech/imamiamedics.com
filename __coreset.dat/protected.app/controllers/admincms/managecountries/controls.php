<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
	 * So any other public methods not prefixed with an underscore will<strong></strong>
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
		
		
		$this->data["_heading"]										= 'Manage Countries';
		$this->data["_pagetitle"]									= $this->data["_heading"] . " - ";
		$this->data['_pageview']									= $this->data["_directory"] . "view.php";

		$this->_create_fields_for_form(false, $this->data);
	}
	
	
	public function view_table_properties()
	{
		$tmp["tr_heading"]											= array('Country Name','Iso Code 2','Iso Code 3','Paypal Email');
	
		return $tmp;
	}
	
	public function view()
	{
		$data														= $this->data;
		
		$records													= $this->imiconf_queries->fetch_records_imiconf("countries");

		if ( $records -> num_rows() <= 0) {
			show_404();
		}

		$data["table_record"]										= $records->result_array();
	
		$data["table_properties"]									= $this->view_table_properties();
	

		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		
		
	}

	public function edit($id)
	{

		$this->data['_pageview']									= $this->data["_directory"] . "edit.php";
		$data														= $this->data;
		
		$records													= $this->imiconf_queries->fetch_records_imiconf("countries"," and id = ".$id);

		if ( $records -> num_rows() <= 0) {
			show_404();
		}

		$edit_details												= $records->row_array();

        $edit_details['options']									= "edit";
        $edit_details['unique_formid']								= "";
        
        if ($THIS == null) {
            $THIS				= $this;
        }
        
        $THIS->_create_fields_for_form(true, $data, $edit_details);


		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
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

	public function save ()
	{
		$data														= $this->data;
		$languages													= $data["languages"];
		
		if ( ! $this->validations->is_post() )
		{
			redirect ( site_url( $data["_directory"] . "controls/view" ) );
		}
		
		$this->form_validation->set_rules("paypal_email", "Paypal Email", "trim|required|valid_email");
		
		
		if( $this->form_validation->run() == FALSE )
		{
			$data['_pageview']									= $data["_directory"] . "edit.php";
			$data['_messageBundle']								= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			
			$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		}
		else
		{
		
			$saveData['paypal_email']							= $this->input->post("paypal_email");
			$saveData['id']										= $this->input->post('id');
			$this->imiconf_queries->SaveDeleteTables_imiconf($saveData, 'e', "tb_countries", 'id');
			
			
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
	
	    $empty_inputs				= array("id","countries_name","countries_iso_code_2","countries_iso_code_3","paypal_email","options");
		
		$filled_inputs				= array("id","countries_name","countries_iso_code_2","countries_iso_code_3","paypal_email","options");
		
		//$filled_inputs				= array( "id", "resorts_id", "promo_code_percentage_discount_code", "promo_code_percentage_discount_percent", "promo_code_percentage_discount_datefrom", "promo_code_percentage_discount_expiry", "promo_code_value_add_code", "promo_code_value_add_details", "promo_code_value_add_datefrom", "promo_code_value_add_expiry",  "options" );
		
		
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */