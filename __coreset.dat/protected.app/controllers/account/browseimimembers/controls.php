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
		
		
		$this->data["_heading"]										= 'Browse IMI Members';
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
		
		
		redirect ( site_url( $data["_directory"] . "controls/browse")  );
		
	}
	
	
	
	
	
	public function index ()
	{
		
	}
	
	public function save ()
	{
		$data														= $this->data;
		$languages													= $data["languages"];
		
		if ( ! $this->validations->is_post() )
		{
			redirect ( site_url( $data["_directory"] . "controls/view" ) );
		}
		

		#standard validation
		$this->functions->unite_post_values_form_validation();
		
		
		
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		
		$tmp_validate_DB				= $this->imiconf_queries->fetch_records_imiconf("users", " AND email = '". $this->input->post("email") ."' ");
		$tmp_validate_VALUES			= $this->find_duplicate_values($tmp_validate_DB, $this->input->post("id"));
		$this->form_validation->set_rules('email', 'Email', "trim|required|valid_email|callback_validate_duplicate[". $tmp_validate_VALUES ."]"); //
		
		
		
		$this->form_validation->set_rules("txt_password", "Password", "trim|required|callback_validate_user_confirm_password[imiconf]|xss_clean");
        $this->form_validation->set_rules("txt_newpassword", "New password", "trim|required|min_length[8]|xss_clean");
        $this->form_validation->set_rules("txt_cnewpassword", "Confirm password", "trim|required|matches[txt_newpassword]|xss_clean");
		

					
		if( $this->form_validation->run() == FALSE )
		{
			

			$data['_pageview']									= $this->TMP_dir . $data["_directory"] . "edit.php";
			
			$data['_messageBundle']								= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			$this->load->view( FRONTEND_TEMPLATE_ACCOUNT_VIEW, $data );
		}
		else
		{
		
			$insertData					= array("id"					=> $this->functions->_user_logged_in_details( "id" ),
												"name"					=> $this->input->post("name"),
												"last_name"				=> $this->input->post("last_name"),
												#"email"					=> $this->input->post("email"),
												"password"				=> $this->encrption->encrypt( $this->input->post("txt_newpassword") ));
											
											
													
			
			
			$this->queries->SaveDeleteTables_imiconf($insertData, 'e', "tb_users", 'id'); 
			
			
			
			$data['_messageBundle']									= $this->_messageBundle( 'success' , 
																							 lang_line("text_credentialsupdated"), 
																							 lang_line("heading_operation_success"),
																							 false, 
																							 true);

			redirect( site_url("logout") ) ;	

		
		}
		
	}
	
	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array( "id", "name", "last_name", "email", "password", "registration_site", "activation_code", "is_active", "is_blocked", "date_added|default_date",  "options", "unique_formid" );
		
		$filled_inputs				= array( "id", "name", "last_name", "email", "password", "registration_site", "activation_code", "is_active", "is_blocked", "date_added", "options", "unique_formid" );
		
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
	
	public function _create_array_fields_for_form( $return_array = false, &$data, $loop_object = array(), $db_data = array() )
	{
	
		$empty_inputs				= array( "bh_name", "bh_descr", "bh_announce" );
		$filled_inputs				= array( "bh_name", "bh_descr", "bh_announce" );
		$languages					= $data["languages"];

		
		
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
						if ( $loop["languageid"] == $language_id )
						{
							$detail_array[ $main["id"] ] [ $empty_inputs[$x] ]			= $loop[ $filled_inputs[$x] ];	
						}
						
					}
				}
			}			
			
			ksort( $detail_array );
		
			$data["_detail_array"]	= $detail_array;
			
			
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
			
			$data["_detail_array"]	= $detail_array;
			
			return $data;
		
		}
	}
	
	
	public function edit( $edit_id )
	{		
		
		$data														= $this->data;
		
		
		if ( !$this->_auth_user_id($edit_id) )
		{
			redirect ( site_url( $this->TMP_dir . $data["_directory"] . "controls/edit/" . $this->functions->_user_logged_in_details( "id" ) ) );
		}
		
		
		$data['_pageview']											= $this->TMP_dir . $data["_directory"] . "edit.php";
		
		$data["edit_id"]											= $edit_id;
		$edit_details												= $this->imiconf_queries->fetch_records_imiconf("users", " AND id = '$edit_id' ");
		
		if ( $edit_details -> num_rows() <= 0 )
		{
			show_404();
		}
		
		
		#$child_data													= $this->queries->fetch_records("beaches_and_hotels_detail", " AND station_id = '$edit_id' ");
		#$data["child_record"]										= set_languageid_array_index( $child_data) ;
		
		
		#print_r( $edit_details -> row_array() );
		#die();
		#pre-filled values for input fields
		
		$edit_details												= $edit_details->row_array();
		$edit_details['options']									= "edit";
		$edit_details['unique_formid']								= "";
		
		$data['_messageBundle']										= $this->_messageBundle( 'info' , lang_line("text_logoutonceupdatedinfo"), 'Please note: ');
	
		$this->_create_fields_for_form(true, $data, $edit_details );	
		#$this->_create_array_fields_for_form(true, $data, $data['languages'], $child_data->result_array() );	
		
		
		$this->load->view( FRONTEND_TEMPLATE_ACCOUNT_VIEW, $data );
		
	}
	
	
	
	public function search( $is_ajax = 0 )
	{
		$data														= $this->data;
		
		if ( $is_ajax )
		{
			$TMP_where												= FALSE;
			if ( $this->input->post("search_name") != "" )
			{
				$TMP_where			.= " AND name like '%". $this->input->post("search_name") ."%' ";
			}
			if ( $this->input->post("search_occupation") != "" )
			{
				$TMP_where			.= " AND (SELECT occupation FROM tb_conference_registration_screen_three where conferenceregistrationid = tb_conference_registration_screen_one.conferenceregistrationid AND parentid = 0 AND  screen_one_detail_id  = 0 ) = '". $this->input->post("search_occupation") ."' ";
			}
			if ( $this->input->post("search_location") != "" )
			{
				$TMP_where			.= " AND (SELECT regionid FROM tb_conference_registration_master WHERE id = tb_conference_registration_screen_one.conferenceregistrationid) = '". $this->input->post("search_location") ."'";
			}
			if ( $this->input->post("search_name") != "" )
			{
				$TMP_where			.= " AND name like '%". $this->input->post("search_name") ."%' ";
			}
			
			
			
			$tmp_columns[]			= array('db'        	=> 'id',
											"where"			=> "id > 0 AND name", #takes 1 field but i also have to pass ID - this scenerio will return correct output.
											'dt'			=> 0 ,
										    'formatter' 	=>  function( $d, $row, $CI ) 
											 					{
																	$finded_users		= $CI->imiconf_queries->fetch_records_imiconf("conference_registration_screen_one", 
																																	  " AND id = '". $row['id'] ."' ");	
																	return $CI->load->view("frontend/account/browseimimembers/search.php", array("fu" => $finded_users->row_array()), TRUE);
																}
											);


			$columns						= SSP::append_columns( $tmp_columns, array(), array(0,1) );
			$primaryKey 					= 'id';
			$table 							= ' tb_conference_registration_screen_one WHERE 1=1  AND conferenceregistrationid IN ( SELECT conferenceregistrationid FROM `tb_conference_registration_screen_two` WHERE ( be_a_member = 1 || coupon_code = "IMIMEMBER2015%" )  ) ' . $TMP_where; 
			
		
			echo json_encode( SSP::simple( $_POST, $table, $primaryKey, $columns, array(), $this->db_imiconf ) );
		}
		
	}
	
	public function browse()
	{		
		
		$data														= $this->data;
		
			
		#occupations dropdown
		$occupations_list											= $this->imiconf_queries->fetch_records_imiconf("conference_registration_screen_three", 
																													" AND parentid = 0 AND  screen_one_detail_id  = 0 " , 
																													" DISTINCT(occupation) occupation ");
		
		$tmp_olist[]												= array("id"				=> "",
																			"occupation"		=> "-Select-");
		foreach ( $occupations_list->result_array() as $ll )
		{
			$tmp_olist[]											= array("id"				=> $ll['occupation'],
																			"occupation"		=> $ll['occupation']);
		}
		
		array_multisort($tmp_olist, SORT_ASC);		
		$data['occupations_dropdown']								= $tmp_olist;
		#occupations dropdown
		
		
		
		
		
		
		#location dropdown
		$locations_list												= $this->imiconf_queries->fetch_records_imiconf("conference_regions", 
																													"" , " id, name");
		$tmp_llist													= $locations_list->result_array();
		$tmp_llist[]												= array("id"			=> "",
																			"name"			=> "-Select-");
		
		array_multisort($tmp_llist, SORT_ASC);
		$data['locations_dropdown']									= $tmp_llist;
		#location dropdown
		
	
		
	
	
		
		$data['_pageview']											= $this->TMP_dir . $data["_directory"] . "browse.php";
		
		
		
		$TMP_where													= FALSE;
		$data['finded_users']										= FALSE;
		if ( $this->validations->is_post() )
		{
			$this->functions->unite_post_values_form_validation();
			$this->form_validation->run();
			
			if ( $this->input->post("name") != "" )
			{
				$TMP_where											.= " AND name like '%". $this->input->post("name") ."%' ";
			}
			
			
			$data['finded_users']									= $this->imiconf_queries->fetch_records_imiconf("conference_registration_screen_one", $TMP_where);		
			
		}
		
		
		
		
		
		
		/*$edit_details												= $edit_details->row_array();
		$edit_details['options']									= "browse";
		$edit_details['unique_formid']								= "";
		
		
		$this->_create_fields_for_form(true, $data, $edit_details );	*/
		#$this->_create_array_fields_for_form(true, $data, $data['languages'], $child_data->result_array() );	
		
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
	
	public function delete( $id )
	{
		$data												= $this->data;
		#remove images
		foreach ($id	as $key	=> $result)
		{
			$row											= $this->queries->fetch_records("beaches_and_hotels", " AND id = '$result' ")->row();
			$this->remove_file($row->bh_image2);
			$this->remove_file($row->bh_image);
			$this->remove_file($row->bh_map);
		}
		
		
		
		
		#remove record from DETAIL table
		foreach ($id	as $key	=> $result)
		{
			$saveData['station_id']									= $result;	
			$this->queries->SaveDeleteTables($saveData, 'd', "tb_beaches_and_hotels_detail", 'station_id') ;
		}
		
		
		#remove record from DETAIL table
		foreach ($id	as $key	=> $result)
		{
			$saveData['id']									= $result;	
			$this->queries->SaveDeleteTables($saveData, 'd', "tb_beaches_and_hotels", 'id') ;
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