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
		
		
		$this->data["_heading"]										= 'Manage Event Packages';
		$this->data["_pagetitle"]									= $this->data["_heading"] . " - ";
		$this->data['_pageview']									= $this->data["_directory"] . "view.php";
		
		
		$this->data['content_languages'] = $this->queries->fetch_records("content_languages", " ORDER BY id DESC ")->result_array();
		#pre-filled values for input fields
		$this->_create_fields_for_form(false, $this->data);	
		$this->_create_lang_fields_for_form(false, $this->data, array());
	}
	
	
	public function view_table_properties()
	{
		$tmp["tr_heading"]											= array( 'Title','Seats', 'Amount', 'Status');
		
		return $tmp;
	}
	
	public function view()
	{
		$data														= $this->data;
		
		$data["table_record"]										= $this->queries->fetch_records("event_packages", " ORDER BY id desc")->result_array();
		$data["table_properties"]									= $this->view_table_properties();
		// $data['controller']											= $this;
		// foreach ($table_record as $key => &$value) {
		// 	$value['image_gallary']	= $this->queries->fetch_records("image_gallery", " AND donation_campaigns_id = '". $value['id'] ."' ")-> result_array();
		// }

		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		
	}
	
	public function add()
	{
		$data												= $this->data;
		
		$data['events'] 									= $this->queries->fetch_records("getEventDetail", " ORDER BY id desc");
		$data['_pageview']									= $data["_directory"] . "edit.php";

		
		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );	
	}
	
	public function save ()
	{
		$data														= $this->data;
		
		if ( ! $this->validations->is_post() )
		{
			redirect ( site_url( $data["_directory"] . "controls/view" ) );
		}
	

		$this->form_validation->set_rules("id", "id", "trim");
		$this->form_validation->set_rules("options", "options", "trim");
		$this->form_validation->set_rules("unique_formid", "unique_formid", "trim");
		
		$this->form_validation->set_rules("event_id", "Event", "trim|required");
		$this->rules_for_array_content("package_title", "Title");
		$this->rules_for_array_content("available_seats", "Seats");
		$this->form_validation->set_rules("amount", "Amount", "trim|required");
		$this->form_validation->set_rules("status", "Status", "trim|required");
		
		
		if( $this->form_validation->run() == FALSE )
		{
			
			$data['_pageview']									= $data["_directory"] . "edit.php";
			$data['_messageBundle']								= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			
			$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		}
		else
		{
			$package_title = $this->input->post("package_title");
			$available_seats = $this->input->post("available_seats");

			$saveData											= array("event_id"				=> $this->input->post('event_id'),
																		"package_title"			=> $package_title[DEFAULT_LANG_CODE],
																		"available_seats"		=> $available_seats[DEFAULT_LANG_CODE],
																		"amount"				=> $this->input->post('amount'),
																		"status"				=> $this->input->post('status'),
																		"created_by"			=> $this->functions->_user_logged_in_details("id"),
																	);
			
			
			
			
			if ($this->input->post('options') == "edit")
			{
				$saveData['updated_by']								= $this->functions->_user_logged_in_details("id");
				$saveData['id']										= $this->input->post('id');
				$this->queries->SaveDeleteTables($saveData, 'e', "tb_event_packages", 'id');  

				$this->_save_lang_content($saveData['id'], 'e'); 
			}
			else
			{
				$this->queries->SaveDeleteTables($saveData, 's', "tb_event_packages", 'id');  		
				$saveData['id']										= $this->db->insert_id();

				$this->_save_lang_content($saveData['id'], 's'); 
			}
			
			
			$data['_messageBundle']									= $this->_messageBundle( 'success' , 
																							 lang_line("operation_saved_success"), 
																							 lang_line("heading_operation_success"),
																							 false, 
																							 true);

			redirect( $data["_directory"] . "controls/view" );
			
		
		}
		
		
	}

	private function rules_for_array_content($field = 'content', $label = "Content", $rules = "trim|required")
	{
		$content = $this->input->post($field);
		if($field){
			$isAllEmpty = true;
			foreach ($content as $key => $record) {
				if(!empty($record)){
					$isAllEmpty = false;
				}
			}
			if($isAllEmpty)
			{
				$this->form_validation->set_rules($field, $label, $rules);
			}
		}
	}

	private function _save_lang_content($ref_id, $action){
		$package_title = $this->input->post("package_title");
		$available_seats = $this->input->post("available_seats");

		$event_packages = $this->queries->fetch_records("event_packages_languages", " AND event_packages_id = '$ref_id' ")->result_array();

		foreach ($this->data['content_languages'] as $lang_key => $lang) {
			$saveData = [
				'package_title' => $package_title[$lang['code']],
				'available_seats' => $available_seats[$lang['code']],
				'event_packages_id' => $ref_id,
				'content_languages_id' => $lang['id']
			];
			
			if(!$event_packages || ($event_packages && !in_array($lang['id'], array_column($event_packages,'content_languages_id')))){
				$col = 'id';
				$action = 's';
			}else{
				$col = 'content_languages_id|event_packages_id';
				$action = 'e';
			}
			
			$this->queries->SaveDeleteTables($saveData, $action, "tb_event_packages_languages", $col);
		}
	}
	
	
	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array( "id", 'amount', "status", "event_id", "options", "unique_formid" );
		
		$filled_inputs				= array( "id", 'amount', "status", "event_id", "options", "unique_formid" );
		
		//$filled_inputs				= array( "id", "resorts_id", "promo_code_percentage_discount_code", "promo_code_percentage_discount_percent", "promo_code_percentage_discount_datefrom", "promo_code_percentage_discount_expiry", "promo_code_value_add_code", "promo_code_value_add_details", "promo_code_value_add_datefrom", "promo_code_value_add_expiry",  "options" );
		
		
		if ($return_array == true)
		{
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				$data[ $empty_inputs[$x] ]		= $db_data[ $filled_inputs[$x] ];
			}
			
			
			return $data;
		}
		else
		{
		
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				$data[ $empty_inputs[$x] ]		= "";
			}
			
			return $data;
		
		}
	}

	public function _create_lang_fields_for_form( $return_array = false, &$data, $loop_object = array(), $db_data = array() )
	{
	
		$empty_inputs				= array("package_title", "available_seats");
		$filled_inputs				= array("package_title", "available_seats");
		
		if ($return_array == true and count($db_data) > 0 )
		{
			
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				foreach ($loop_object as $loop)
				{
					$detail_array[ $loop["id"] ] [ $empty_inputs[$x]]		= "";
				}
			}
			
			
			#loop with the parent object... for e.g. Types of Promo Codes
			foreach ($loop_object as $main)
			{
				
				$language_id				= $main["id"];
				
				for ($x=0;  $x < count($empty_inputs); $x++)
				{
					#second - if value found it will overwrite above array.
					foreach ( $db_data as $loop )
					{
						if ( $loop["content_languages_id"] == $language_id )
						{
							$detail_array[ $main["id"] ] [ $empty_inputs[$x] ]			= $loop[ $filled_inputs[$x] ];	
						}
						
					}
				}
			}			
			
			ksort( $detail_array );
		
			$data["lang_content"]	= $detail_array;
			
			
			return $data;
		}
		else
		{
			
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				foreach ($loop_object as $loop)
				{
					$detail_array[ $loop["id"] ] [ $empty_inputs[$x]]		= "";
				}
			}
			
			$data["lang_content"]	= $detail_array;
			
			return $data;
		
		}
	}
	
	
	public function edit( $edit_id )
	{
		
		$data														= $this->data;
		$data['_pageview']											= $data["_directory"] . "edit.php";
		
		$data["edit_id"]											= $edit_id;
		$edit_details												= $this->queries->fetch_records("event_packages", " AND id = '$edit_id' ");
		
		if ( $edit_details -> num_rows() <= 0 )
		{
			show_404();
		}
		
		
		
		
		$edit_details												= $edit_details->row_array();
		$edit_details['options']									= "edit";
		$edit_details['unique_formid']								= "";

		$this->_create_fields_for_form(true, $data, $edit_details );

		$edit_lang_details									= $this->queries->fetch_records("event_packages_languages", " AND event_packages_id = '$edit_id' ")->result_array();
		$this->_create_lang_fields_for_form(true, $data, $this->data['content_languages'], $edit_lang_details );


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
			$this->queries->SaveDeleteTables($saveData, 'd', "tb_event_packages", 'id') ;
			$this->queries->SaveDeleteTables(['event_packages_id'=>$result], 'd', "tb_event_packages_languages", 'event_packages_id') ;
		}
		
		
		
		
		$data['_messageBundle']								= $this->_messageBundle('success' , 
																					lang_line("operation_delete_success"), 
																					lang_line("heading_operation_success"), 
																					false,
																					true);
		redirect(  site_url( $data["_directory"] . "controls/view" )  );
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */