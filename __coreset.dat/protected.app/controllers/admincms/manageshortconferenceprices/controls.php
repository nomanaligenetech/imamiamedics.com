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
		
		
		$this->data["_heading"]										= 'Manage Conference Prices';
		$this->data["_pagetitle"]									= $this->data["_heading"] . " - ";
		$this->data['_pageview']									= $this->data["_directory"] . "view.php";
		
		
		
		#upload files extensions
		$this->data["images_types"]									= "gif|jpg|png";
		$this->data["images_dir"]	 								= "./assets/files/conferenceprices/";
		
		
		$this->data["images_width"]									= 1378;
		$this->data["images_height"]								= 575;
	
	
		$this->data['tmp_dd']										= DropdownHelper::short_conferenceregistration_paymenttype(TRUE, TRUE);
		
		#pre-filled values for input fields
		$this->_create_fields_for_form(false, $this->data);	
		$this->_create_array_fields_for_form(false, $this->data, $this->data["tmp_dd"]);	
		
		
	}
	
	
	public function view_table_properties()
	{
		$tmp["tr_heading"]											= array('Conference', 'Title', 'Who Attend', 'Region', 'Type');
		
		return $tmp;
	}
	
	public function view( $is_ajax = 0 )
	{
		$data														= $this->data;
		
		
		$data["table_record"]										= $this->queries->fetch_records("short_conference_prices_master", " AND parent_id IS NULL OR is_addon = 1 ORDER BY id desc ");
		
		$data["table_properties"]									= $this->view_table_properties();
	

	
		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		
		
	}
	
	public function index ()
	{
		
	}
	
	public function add()
	{
		$data												= $this->data;
		
		
		$data['_pageview']									= $data["_directory"] . "edit.php";

		
		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );	
	}
	
	
	public function __ajax_update_sorting( $id )
	{
		
		foreach ($id	as $key	=> $result)
		{
			$saveData['sort']										= $result;	
			$saveData['id']											= $key;	
			
			$this->queries->SaveDeleteTables($saveData, 'e', "tb_short_conference_prices_master", 'id') ;
		}
		
		$data['_messageBundle']									= $this->_messageBundle( 'success' , "Sort Updated", 'Success!', FALSE, TRUE);
		
		redirect ( site_url( $this->data["_directory"] . "controls/view" ) );
	}
	
	
	public function save ()
	{
		$data														= $this->data;
		$languages													= $data["languages"];
		
		if ( ! $this->validations->is_post() )
		{
			redirect ( site_url( $data["_directory"] . "controls/view" ) );
		}
		

		include_once(APPPATH.'controllers/ajaxmethods.php');
		
		
		
		
		#re-unite post values + language array with form_validations
		$this->functions->unite_post_values_form_validation();
		
		
		
		/*$tmp_validate_DB				= $this->queries->fetch_records("short_conference_prices_master", " 	AND conferenceid = '". $this->input->post("conferenceid") ."' 
																										AND whoattendid = '". $this->input->post("whoattendid") ."'
																										AND regionid = '". $this->input->post("regionid") ."' ");
		$tmp_validate_VALUES			= $this->find_duplicate_values($tmp_validate_DB, $this->input->post("id"));		
		$this->form_validation->set_rules("name", "Name", "trim|required|callback_validate_duplicate[". $tmp_validate_VALUES ."]");*/
		
		
		
		$this->form_validation->set_rules("conferenceid", "Conference", "trim|required");

	
		$whoattendid_validation = $_POST['is_addon'] == 1 ? "trim" : "trim|required";

		$this->form_validation->set_rules("whoattendid", "Who Attend", $whoattendid_validation);
		// $this->form_validation->set_rules("whoattendid", "Who Attend", "trim");
		$this->form_validation->set_rules("regionid", "Conference Region", "trim|required");
		
		$this->form_validation->set_rules("parent_id", "Parent", "trim");
		
		
		
		$this->form_validation->set_rules("title", "Title", "trim");
		$this->form_validation->set_rules("description", "Description", "trim");
		
		
		if ( 1==1 )
		{
			#################################
			###  	upload_image_1  	  ###
			#################################
			$other_upload						= array("validate"											=> FALSE,
														"input_field"										=> "file_image_icon",
														"db_field"											=> "image_icon",
														"input_nick"										=> "Icon",
														"hdn_field"											=> "image_icon",
														"tmp_table_field"									=> "upload_1",
														"is_multiple"										=> FALSE);
		
			
			$config_image						= array("upload_path"										=> $data["images_dir"],
														"allowed_types"										=> $data['images_types'],
														"encrypt_name"										=> TRUE);
		
			$config_thumb						= array();
		
			
			$tmp_upload_image_1					= $this->upload_image($config_image, $config_thumb, $other_upload);
			
			
			#insert in tmp table	
			$this->tmp_record_uploads_in_db( TRUE, $tmp_upload_image_1  );
			
			#################################
			###  	upload_image_1  	  ###
			#################################
			
		}
		
		$this->form_validation->set_rules("paymenttype_key", "Payment Type", "trim");
		$this->form_validation->set_rules("is_addon", "Is Addon", "trim");
		$this->form_validation->set_rules("is_validated", "Is Validated", "trim");
		$this->form_validation->set_rules("is_optional", "Is Optional", "trim");
		$this->form_validation->set_rules("is_free", "Is Free", "trim");
		$this->form_validation->set_rules("apply_for_visa", "Apply for Visa", "trim");
		$this->form_validation->set_rules("discount_coupon_code", "Discount Coupon Code", "trim");
		
		


		foreach ($data['tmp_dd'] as $key => $value)
		{
			if ( $key == $this->input->post("paymenttype_key") )
			{
				foreach ($value as $k => $v)
				{
					$this->form_validation->set_rules("earlybird_price[". $k ."]	", "EarlyBird Price <strong>(". $v .")</strong>", "trim|required|numeric");
					$this->form_validation->set_rules("regular_price[". $k ."]	", "Regular Price <strong>(". $v .")</strong>", "trim|required|numeric");			
				}
			}
		}
		
	
		
		
		if( $this->form_validation->run() == FALSE )
		{
			$tmp_ajax_output1									= (new AjaxMethods())->whoattend_by_short_conferenceid( set_value("conferenceid"), set_value("regionid"), FALSE );
			
			if ( $tmp_ajax_output1["_CSS_show_messages"] != "error" )
			{
				$data['ajax_output1']							= $tmp_ajax_output1["_TEXT_show_messages"];
			}
			
			
			
			
			$tmp_ajax_output2									= (new AjaxMethods())->short_conferenceregion_by_conferenceid( set_value("conferenceid"), FALSE );
			if ( $tmp_ajax_output2["_CSS_show_messages"] != "error" )
			{
				$data['ajax_output2']							= $tmp_ajax_output2["_TEXT_show_messages"];
			}
			
			
			
			$tmp_ajax_output3									= (new AjaxMethods())->short_conferencepriceparent_by_conferenceid_whoattendid_regionid( 	set_value("conferenceid"), 
																																			set_value("whoattendid"), 
																																			set_value("regionid"), 
																																			FALSE );
			if ( $tmp_ajax_output3["_CSS_show_messages"] != "error" )
			{
				$data['ajax_output3']							= $tmp_ajax_output3["_TEXT_show_messages"];
			}
			
			
			/*
			$_POST["parent_id"]									= $edit_details["parent_id"];
		$tmp_ajax_output3									= AjaxMethods::conferencepriceparent_by_conferenceid_whoattendid_regionid	(
																																			$edit_details["conferenceid"], 
																																			$edit_details["whoattendid"], 
																																			$edit_details["regionid"], 
																																			FALSE 
																																		);
		if ( $tmp_ajax_output3["_CSS_show_messages"] != "error" )
		{
			$data['ajax_output3']							= $tmp_ajax_output3["_TEXT_show_messages"];
		}
		*/
			
			
			
			$data['_pageview']									= $data["_directory"] . "edit.php";
			$data['_messageBundle']								= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			// die('hdsghf');
			// var_dump($data); die;
			
			$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		}
		else
		{
			if ( $_POST["regionid"] == "" )
			{
				$_POST["regionid"]								= NULL;
			}
			
			
			if ( "copy_to_all"  and false )
			{
				die("fa");
				$tmp_ajax_output1									= (new AjaxMethods())->whoattend_by_short_conferenceid( set_value("conferenceid"), FALSE, FALSE );
				
				foreach ($tmp_ajax_output1['_TEXT_show_messages'] as $tmp__whoattendid => $vvvvv)
				{
					if ( $key != "" )
					{
						
	
						
						
						
						$tmp_ajax_output3									= (new AjaxMethods())->short_conferencepriceparent_by_conferenceid_whoattendid_regionid( 	set_value("conferenceid"), 
																																			$tmp__whoattendid, 
																																			set_value("regionid"), 
																																			FALSE,
																																			FALSE );

						if ( $this->input->post("parent_id") != "" )
						{		
							
							$___parent_id									= $tmp_ajax_output3['_TEXT_show_messages']; #array_search($cpm->row()->title, $tmp_ajax_output3['_TEXT_show_messages']);
						}
						else
						{
							$___parent_id									= array(
																				""		=> "",
																			);
						}
						
						$i = 0;
						foreach ($___parent_id as $pppp =>  $tttt)
						{
							
							$saveData											= array("conferenceid"				=> $this->input->post('conferenceid'),
																						"whoattendid"				=> $tmp__whoattendid,
																						"regionid"					=> $this->input->post('regionid'),
																						
																						"parent_id"					=> format_input_else_null( $pppp ),
																						
																						"title"						=> $this->input->post('title'),
																						"description"				=> $this->input->post('description'),
																						"image_icon"				=> $this->input->post('image_icon'),
																						
																						"paymenttype_key"			=> $this->input->post('paymenttype_key'),
																						"is_addon"				    => format_bool ( $this->input->post("is_addon") ),
																						"is_validated"				=> format_bool ( $this->input->post("is_validated") ),
																						"is_optional"				=> format_bool ( $this->input->post("is_optional") ),
																						"is_free"					=> format_bool ( $this->input->post("is_free") ),
																						"apply_for_visa"			=> format_bool ( $this->input->post("apply_for_visa") ),
																						"discount_coupon_code"		=> $this->input->post('discount_coupon_code'),
																						/*"currency"					=> $this->input->post('currency')*/ );
								
								
							if ( $i == 1 )
							{
								
								#print_r($saveData);die;
							}

							if ( true)
							{
								if ($this->input->post('options') == "edit")
								{
									$saveData['id']										= $this->input->post('id');
									$this->queries->SaveDeleteTables($saveData, 'e', "tb_short_conference_prices_master", 'id');  
								}
								else
								{
									$this->queries->SaveDeleteTables($saveData, 's', "tb_short_conference_prices_master", 'id');  		
									$saveData['id']										= $this->db->insert_id();
								}
								
								
								
								
								
								$this->queries->SaveDeleteTables(array("parentid" => $saveData['id']), 'd', "tb_short_conference_prices_details", 'parentid');  
								if ( $this->input->post("earlybird_price") )
								{
									foreach ( $_POST['earlybird_price'] as $key => $value )
									{
										$childData['parentid']						= $saveData['id'];
					
										$childData['typeid']						= $key;
										$childData['earlybird_price']				= $_POST['earlybird_price'][$key];
										$childData['regular_price']					= $_POST['regular_price'][$key];
										
										$this->queries->SaveDeleteTables($childData, 's', "tb_short_conference_prices_details", 'id');  
									}
								}
							}
							
							$i++;
						}
					}
				}
			}
			else
			{
				$saveData											= array("conferenceid"				=> $this->input->post('conferenceid'),
																		"whoattendid"				=> empty($this->input->post('whoattendid')) ? 0 : $this->input->post('whoattendid'),
																		"regionid"					=> $this->input->post('regionid'),
																		
																		"parent_id"					=> format_input_else_null( $this->input->post('parent_id') ),
																		
																		"title"						=> $this->input->post('title'),
																		"description"				=> $this->input->post('description'),
																		"image_icon"				=> $this->input->post('image_icon'),
																		
																		"paymenttype_key"			=> $this->input->post('paymenttype_key'),
																		"is_addon"				    => format_bool ( $this->input->post("is_addon") ),
																		"is_validated"				=> format_bool ( $this->input->post("is_validated") ),
																		"is_optional"				=> format_bool ( $this->input->post("is_optional") ),
																		"is_free"					=> format_bool ( $this->input->post("is_free") ),
																		"apply_for_visa"			=> format_bool ( $this->input->post("apply_for_visa") ),
																		"discount_coupon_code"		=> $this->input->post('discount_coupon_code'),
																		/*"currency"					=> $this->input->post('currency')*/ );
			if ($this->input->post('options') == "edit")
			{

				$saveData['id']										= $this->input->post('id');
				$this->queries->SaveDeleteTables($saveData, 'e', "tb_short_conference_prices_master", 'id');  
			}
			else
			{
				$this->queries->SaveDeleteTables($saveData, 's', "tb_short_conference_prices_master", 'id');  		
				$saveData['id']										= $this->db->insert_id();
			}
			
			
			
			
			
			$this->queries->SaveDeleteTables(array("parentid" => $saveData['id']), 'd', "tb_short_conference_prices_details", 'parentid');  
			if ( $this->input->post("earlybird_price") )
			{
				foreach ( $_POST['earlybird_price'] as $key => $value )
				{
					$childData['parentid']						= $saveData['id'];

					$childData['typeid']						= $key;
					$childData['earlybird_price']				= $_POST['earlybird_price'][$key];
					$childData['regular_price']					= $_POST['regular_price'][$key];
					
					$this->queries->SaveDeleteTables($childData, 's', "tb_short_conference_prices_details", 'id');  
				}
			}
			}
			
			$data['_messageBundle']									= $this->_messageBundle( 'success' , 
																							 lang_line("operation_saved_success"), 
																							 lang_line("heading_operation_success"),
																							 false, 
																							 true);

			redirect( $data["_directory"] . "controls/view" );
			
		
		}
		
	}
	
	
	
	public function _create_child_for_form( $return_array = false, &$data, $db_data = array() )
	{
		#print_r($db_data);
		$empty_inputs				= array("earlybird_price", "regular_price", "typeid");
		
		$filled_inputs				= array("earlybird_price", "regular_price", "typeid");
				
				
				
		if ($return_array == true)
		{
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				#$data[ $empty_inputs[$x] ]					= array();
			}
			
			

			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				
			
				
				for ($m=0; $m < count($db_data); $m++)
				{
					
					if ( array_key_exists($empty_inputs[$x] , $db_data[$m]) )
					{
						$data[ $empty_inputs[$x] ][ $m ]	= $db_data[$m][ $filled_inputs[$x] ];
						$_POST[ $empty_inputs[$x] ] []		= $db_data[$m][ $filled_inputs[$x] ];
						
					}
				}
				
				#$this->form_validation->set_rules( $empty_inputs[$x] . "[]", $empty_inputs[$x], "trim");
				
			}
			
			
			
			
			#$this->form_validation->run();
		
		
			return $data;
		}
		else
		{
			
			
			
		
		
		
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				foreach ($data['tmp_dd'] as $key => $value)
				{
					if ( $key == $data['paymenttype_key'] )
					{
						foreach ($value as $k => $v)
						{
							$data[ $empty_inputs[$x] ][ $k ]				= '';			
						}
					}
				}
				
			}
			
			return $data;
		
		}

	}
	
	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array( "id", "parent_id", "title", "description", "image_icon",  "is_addon", "is_validated", "is_optional", "is_free", "apply_for_visa", "discount_coupon_code", "conferenceid", "whoattendid", "regionid", "paymenttype_key", "options", "unique_formid", "currency" );
		
		$filled_inputs				= array( "id", "parent_id", "title", "description", "image_icon",  "is_addon", "is_validated", "is_optional", "is_free", "apply_for_visa", "discount_coupon_code", "conferenceid", "whoattendid", "regionid", "paymenttype_key", "options", "unique_formid", "currency" );
		
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
							
						case "default_price":	
							$tmp_value			= $db_data[ $filled_inputs[$x] ];
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
							
						case "default_price":	
							$tmp_value				= "0.00";
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
	
		$empty_inputs				= array("earlybird_price", "regular_price", "typeid");
		$filled_inputs				= array("earlybird_price", "regular_price", "typeid");
		$languages					= $data["languages"];

		
		
		if ($return_array == true and count($db_data) > 0 )
		{
			
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				
				foreach ($loop_object as $key => $value)
				{
					foreach ($value as $k => $v)
					{
						$detail_array[ $empty_inputs[$x] ][ $k ]		= "";
					}
				}

			}
			
			
			#loop with the parent object... for e.g. Types of Promo Codes
			foreach ($loop_object as $main_key => $main_value)
			{
				foreach ( $main_value as $k => $v)
				{
				
					$language_id				= $k;
					
					for ($x=0;  $x < count($empty_inputs); $x++)
					{
						#second - if value found it will overwrite above array.
						foreach ( $db_data as $loop )
						{
							if ( $loop["typeid"] == $language_id )
							{
								$detail_array[ $empty_inputs[$x] ][ $k ] 				= $loop[ $filled_inputs[$x] ];	
							}
							
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
				
				/*foreach ($data['tmp_dd'] as $key => $value)
				{
					if ( $key == $data['paymenttype_key'] )
					{
						foreach ($value as $k => $v)
						{
							$data[ $empty_inputs[$x] ][ $k ]				= '';			
						}
					}
				}*/
				
				
				
				
				foreach ($loop_object as $key => $value)
				{
					
					if ( ($key == $data['paymenttype_key']) || ( $data['paymenttype_key'] == '' ) )
					{
						foreach ($value as $k => $v)
						{
							$detail_array[ $empty_inputs[$x] ][ $k ]		= "";
						}
						
						
					}
				}
			}

			$data["_detail_array"]	= $detail_array;
			
			return $data;
		
		}
	}
	
	
	public function edit( $edit_id )
	{
		
		$data														= $this->data;
		$data['_pageview']											= $data["_directory"] . "edit.php";
		
		$data["edit_id"]											= $edit_id;
		$edit_details												= $this->queries->fetch_records("short_conference_prices_master", " AND id = '$edit_id' ");
		//echo $this->db->last_query(); die;
		
		
		if ( $edit_details -> num_rows() <= 0 )
		{
			show_404();
		}
		
		
		
		
		
		
		
		$edit_details												= $edit_details->row_array();
		$edit_details['options']									= "edit";
		$edit_details['unique_formid']								= "";
		
		$this->_create_fields_for_form(true, $data, $edit_details );	
		
		
		$child_data												= $this->queries->fetch_records("short_conference_prices_details", " AND parentid = '$edit_id' ");		
		$this->_create_array_fields_for_form(true, $data, $data['tmp_dd'], $child_data->result_array() );	
		
		
		
		
		include_once(APPPATH.'controllers/ajaxmethods.php');

		$_POST["regionid"]									= $edit_details["regionid"];
		$tmp_ajax_output2									= (new AjaxMethods())->short_conferenceregion_by_conferenceid( $edit_details["conferenceid"], FALSE );
		if ( $tmp_ajax_output2["_CSS_show_messages"] != "error" )
		{
			$data['ajax_output2']							= $tmp_ajax_output2["_TEXT_show_messages"];
		}
		
		$_POST["whoattendid"]								= $edit_details["whoattendid"];
		$tmp_ajax_output1									= (new AjaxMethods())->whoattend_by_short_conferenceid( $edit_details["conferenceid"], FALSE );
		if ( $tmp_ajax_output1["_CSS_show_messages"] != "error" )
		{
			$data['ajax_output1']							= $tmp_ajax_output1["_TEXT_show_messages"];
		}
		
		
		$_POST["parent_id"]									= $edit_details["parent_id"];
		$tmp_ajax_output3									= (new AjaxMethods())->short_conferencepriceparent_by_conferenceid_whoattendid_regionid	(
																																			$edit_details["conferenceid"], 
																																			$edit_details["whoattendid"], 
																																			$edit_details["regionid"], 
																																			FALSE 
																																		);
		if ( $tmp_ajax_output3["_CSS_show_messages"] != "error" )
		{
			$data['ajax_output3']							= $tmp_ajax_output3["_TEXT_show_messages"];
		}
		
		
		
		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		
	}
	
	public function options()
	{
		$data					= $this->data;
		$is_post				= FALSE;
		
		
		if ( $_POST['options'] == "ajax_update_sorting" )
		{
			$is_post		= TRUE;
		}
		else if ( isset($_POST['checkbox_options']) )
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
					
				case "ajax_update_sorting":
					$this->ajax_update_sorting( $_POST['sorting'] );
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
			$this->queries->SaveDeleteTables($saveData, 'd', "tb_short_conference_prices_master", 'id') ;
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