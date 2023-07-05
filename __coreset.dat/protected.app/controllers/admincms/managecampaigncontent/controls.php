<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include("controls_include.php");
class Controls extends Controls_Include {

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
		$this->data["_directory_adddonor"]							= "admincms/managecampaigncustomdonor/";
		$this->data["_pagepath"]									= $this->router->directory . $this->router->class;
		
		
		$this->data["_heading"]										= 'Manage Donation Campaigns Content';
		$this->data["_pagetitle"]									= $this->data["_heading"] . " - ";
		$this->data['_pageview']									= $this->data["_directory"] . "view.php";
		
		
		
		
		#upload files extensions
		$this->data["images_types"]									= "gif|jpg|jpeg|png";
		$this->data["images_dir"]	 								= "./assets/files/donationcampaigns/";

		$this->data["is_dimension"]									= TRUE;
		$this->data["images_width"]									= 500;
		$this->data["images_height"]								= 258;
		
		
		$this->data["is_dimension_2"]								= FALSE;
		$this->data["images_width_2"]								= 830;
		$this->data["images_height_2"]								= 480;
		
		$this->data['content_languages'] = $this->queries->fetch_records("content_languages", " ORDER BY id DESC ")->result_array();
		#pre-filled values for input fields
		$this->_create_fields_for_form(false, $this->data);	
		$this->_create_lang_fields_for_form(false, $this->data, array());
		$this->_create_child_for_form(false, $this->data, array());
		$this->_create_child2_for_form(false, $this->data, array());
	}
	
	
	public function view_table_properties()
	{
		$tmp["tr_heading"]											= array( 'Donation Project', "Slug", 'Goal Amount', 'Amount Received', 'Is Active ?', 'Int/Can', 'Last Updated' );
		
		return $tmp;
	}
	
	public function view()
	{
		$data														= $this->data;
		
		$data["table_record"]										= $this->queries->fetch_records("donation_campaigns", " ORDER BY id desc");
		$data["table_properties"]									= $this->view_table_properties();
		$data['controller']											= $this;
		// foreach ($table_record as $key => &$value) {
		// 	$value['image_gallary']	= $this->queries->fetch_records("image_gallery", " AND donation_campaigns_id = '". $value['id'] ."' ")-> result_array();
		// }

		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		
	}
	
	public function add()
	{
		$data												= $this->data;
		
		
		$data['_pageview']									= $data["_directory"] . "edit.php";

		
		$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );	
	}
	
	public function save ()
	{
		$data														= $this->data;
		$languages													= $data["languages"];
		
		if ( ! $this->validations->is_post() )
		{
			redirect ( site_url( $data["_directory"] . "controls/view" ) );
		}
	

		if(!$this->input->post('id')) {
			$is_unique =  '|is_unique[tb_donation_campaigns.donation_project_id]';
		} else {
			$is_unique =  '';
		}

		if($this->input->post('donation_project_id') == 0){
			$_POST['donation_project_id'] = '';
		}
		
		$this->form_validation->set_rules("id", "id", "trim");
		$this->form_validation->set_rules("options", "options", "trim");
		$this->form_validation->set_rules("unique_formid", "unique_formid", "trim");
		
		$this->form_validation->set_rules("donation_project_id", "Donation Project", "trim|required|$is_unique");
		// $this->form_validation->set_rules("short_desc", "Short Description", "trim|required|max_length[200]");
		$this->rules_for_array_content("short_desc", "Short Description");
		// $this->form_validation->set_rules("content", "Content", "trim|required");
		$this->rules_for_array_content("content", "Content");
		// $this->form_validation->set_rules("sidebar", "Sidebar", "trim");
		$this->rules_for_array_content("sidebar", "Sidebar");

		$this->form_validation->set_rules("goal_amount", "Goal Amount", "trim|required|numeric|greater_than[0]");
		$this->form_validation->set_rules("status", "Status", "trim|required");

		$this->form_validation->set_message('is_unique', 'The Selected %s already has a Campaign');
		

		if ( 1 == 1 )
		{
			
			#################################
			###  	upload_image_1  	  ###
			#################################
			$other_upload						= array("validate"											=> TRUE,
														"input_field"										=> "file_featured_image",
														"db_field"											=> "featured_image",
														"input_nick"										=> "Featured Image",
														"hdn_field"											=> "featured_image",
														"tmp_table_field"									=> "upload_1",
														"is_multiple"										=> FALSE,
														
														"validate_dimension"								=> $data['is_dimension'],
														"width"												=> $data['images_width'],
														"height"											=> $data['images_height']);
		
			
			$config_image						= array("upload_path"										=> $data["images_dir"]. 'featured/',
														"allowed_types"										=> $data['images_types'],
														"encrypt_name"										=> TRUE);
		
			$config_thumb						= array();
		
			
			$tmp_upload_image_1					= $this->upload_image($config_image, $config_thumb, $other_upload);
		
			
			#insert in tmp table	
			$this->tmp_record_uploads_in_db( TRUE, $tmp_upload_image_1  );
			
			#################################
			###  	upload_image_1  	  ###
			#################################
			
			
			
			
			
			#################################
			###  	gallery_image	  ###
			#################################
			$other_upload						= array("validate"											=> FALSE,
														"input_field"										=> "file_gallery_image",
														"db_field"											=> "gallery_image",
														"input_nick"										=> "Gallery Image",
														"hdn_field"											=> "gallery_image",
														"tmp_table_field"									=> "upload_1",
														"is_multiple"										=> TRUE,
														
														"validate_dimension"								=> $data['is_dimension_2'],
														"width"												=> $data['images_width_2'],
														"height"											=> $data['images_height_2']);
		
			
			$config_image						= array("upload_path"										=> $this->data["images_dir"] . 'gallery/',
														"allowed_types"										=> $data['images_types'],
														"encrypt_name"										=> TRUE,
														"max_size"											=> '5096');
		
			$config_thumb						= array();
		
			
			$tmp_upload_image_2					= $this->upload_image($config_image, $config_thumb, $other_upload);
			
			#insert in tmp table	
			$this->tmp_record_uploads_in_db( TRUE, $tmp_upload_image_2, TRUE  );
	
			#################################
			###  	product_main_image 	  ###
			#################################
			
		}
		
		
		
		
		// $this-> _widget_validate(); #controls_include
		
		
		
		if( $this->form_validation->run() == FALSE )
		{
			
			$data['_pageview']									= $data["_directory"] . "edit.php";
			$data['_messageBundle']								= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			
			$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		}
		else
		{
			$short_desc = $this->input->post("short_desc");
			$content = $this->input->post("content");
			$sidebar = $this->input->post("sidebar");
			$gallery_text = $this->input->post("gallery_text");
			$user_id =  $this->functions->_admincms_logged_in_details( "id" );
			$donation_project_id = $this->input->post('donation_project_id');
			$donation_project								= $this->queries->fetch_records("donation_projects", " AND id=$donation_project_id ")->row('name');
			$slug = str_replace(" ", "-", strtolower($donation_project));

			$saveData											= array("donation_project_id"	=> $donation_project_id,
																		"slug"					=> $slug,
																		"short_desc"			=> $short_desc[DEFAULT_LANG_CODE],
																		"content"				=> $content[DEFAULT_LANG_CODE],
																		"featured_image"		=> $this->input->post('featured_image'),
																		"goal_amount"			=> $this->input->post('goal_amount'),
																		"status"				=> $this->input->post('status'),
																		"belongsto"				=> $this->input->post('belongsto'),
																		"sidebar"				=> $sidebar[DEFAULT_LANG_CODE],
																		"gallery_text"			=> $gallery_text[DEFAULT_LANG_CODE],
																		"added_by"				=> $user_id
																	);
			
			
			
			
			if ($this->input->post('options') == "edit")
			{
				$saveData['id']										= $this->input->post('id');
				$this->queries->SaveDeleteTables($saveData, 'e', "tb_donation_campaigns", 'id');  

				$this->_save_lang_content($saveData['id'], 'e'); 
			}
			else
			{
				$this->queries->SaveDeleteTables($saveData, 's', "tb_donation_campaigns", 'id');  		
				$saveData['id']										= $this->db->insert_id();

				$this->_save_lang_content($saveData['id'], 's'); 
			}
			
			
			
			#multiple photos
			$TMP_child						= array("donation_campaigns_id"				=> $saveData['id'], 'type'=> 'image');
			$this->queries->SaveDeleteTables($TMP_child, 'd', "tb_donation_campaigns_gallery", 'donation_campaigns_id|type');  
			if ( $this->input->post("gallery_image") )
			{
				foreach ($this->input->post("gallery_image") as $key => $value )
				{
					$childData					= array("donation_campaigns_id"					=> $saveData['id'],
														"gallery_image"			=> $value,
														"type"					=> 'image'
													);
					
					
					
					
					$this->queries->SaveDeleteTables($childData, 's', "tb_donation_campaigns_gallery", 'id');  		
				}
			}

			$TMP_child						= array("donation_campaigns_id"				=> $saveData['id'], 'type'=> 'video');
			$this->queries->SaveDeleteTables($TMP_child, 'd', "tb_donation_campaigns_gallery", 'donation_campaigns_id|type');  
			if ( isset($_POST['video_iframe']) && !empty($_POST['video_iframe'])  )
			{
				
					
					$_POST['video_iframe']							= array_values($_POST['video_iframe']);
					$_POST['video_id']								= array_values($_POST['video_id']);
					
					for ($m=0; $m < count($_POST['video_iframe']); $m++)
					{		
						if(trim($_POST['video_iframe'][$m])){		
						$TMP_child						= array("donation_campaigns_id"		=> $saveData['id'],
																"gallery_image"				=> $_POST["video_iframe"][$m],
																"desc"						=> $_POST["video_id"][$m],
																"type"						=> 'video'
																);
						
						
						$this->queries->SaveDeleteTables($TMP_child, 's', "tb_donation_campaigns_gallery", 'id'); 
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
		$short_desc = $this->input->post("short_desc");
		$content = $this->input->post("content");
		$sidebar = $this->input->post("sidebar");
		$gallery_text = $this->input->post("gallery_text");

		$donation_campaigns = $this->queries->fetch_records("donation_campaigns_languages", " AND donation_campaigns_id = '$ref_id' ")->result_array();

		foreach ($this->data['content_languages'] as $lang_key => $lang) {
			$saveData = [
				'short_desc' => $short_desc[$lang['code']],
				'content' => $content[$lang['code']],
				'sidebar' => $sidebar[$lang['code']],
				'gallery_text' => $gallery_text[$lang['code']],
				'donation_campaigns_id' => $ref_id,
				'content_languages_id' => $lang['id']
			];
			
			// if(!$donation_campaigns && !in_array($lang['id'], array_column($donation_campaigns,'content_languages_id'))){
			if(!$donation_campaigns || ($donation_campaigns && !in_array($lang['id'], array_column($donation_campaigns,'content_languages_id')))){
				$col = 'id';
				$action = 's';
			}else{
				$col = 'content_languages_id|donation_campaigns_id';
				$action = 'e';
			}
			
			$this->queries->SaveDeleteTables($saveData, $action, "tb_donation_campaigns_languages", $col);
		}
	}
	
	
	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array( "id", "donation_project_id", "featured_image", "goal_amount", "options", "unique_formid", "status", "belongsto" );
		
		$filled_inputs				= array( "id", "donation_project_id", "featured_image", "goal_amount", "options", "unique_formid", "status", "belongsto" );
		
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
	
		$empty_inputs				= array("short_desc", "content", "sidebar","gallery_text");
		$filled_inputs				= array("short_desc", "content", "sidebar","gallery_text");
		
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
	
	public function _create_child_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array("gallery_image");
		
		$filled_inputs				= array("gallery_image");
				
		
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
					
						$data[ $empty_inputs[$x] ][]		= $db_data[$m][ $filled_inputs[$x] ];
					}
				}
				
			}
			
			
			return $data;
		}
		else
		{
		
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				$data[ $empty_inputs[$x] ]				= array();
			}
			
			return $data;
		
		}
	}
	public function _create_child2_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array("video_iframe", "video_id");
		
		$filled_inputs				= array("gallery_image", "desc");
				
		
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
					
					// if ( array_key_exists($empty_inputs[$x] , $db_data[$m]) )
					// {
					
						$data[ $empty_inputs[$x] ][]		= $db_data[$m][ $filled_inputs[$x] ];
						$_POST[ $empty_inputs[$x] ] []		= $db_data[$m][ $filled_inputs[$x] ];
					// }
				}
				
			}
			
			
			return $data;
		}
		else
		{
		
			for ($x=0;  $x < count($empty_inputs); $x++)
			{
				$data[ $empty_inputs[$x] ]				= array();
			}
			
			return $data;
		
		}
	}
	
	
	public function edit( $edit_id )
	{
		
		$data														= $this->data;
		$data['_pageview']											= $data["_directory"] . "edit.php";
		
		$data["edit_id"]											= $edit_id;
		$edit_details												= $this->queries->fetch_records("donation_campaigns", " AND id = '$edit_id' ");
		
		if ( $edit_details -> num_rows() <= 0 )
		{
			show_404();
		}
		
		
		
		
		$edit_details												= $edit_details->row_array();
		$edit_details['options']									= "edit";
		$edit_details['unique_formid']								= "";
		$data['amount_received']									= $this->amountReceived($edit_details['donation_project_id'], $edit_details['id']);

		$this->_create_fields_for_form(true, $data, $edit_details );	

		$edit_lang_details									= $this->queries->fetch_records("donation_campaigns_languages", " AND donation_campaigns_id = '$edit_id' ")->result_array();
		$this->_create_lang_fields_for_form(true, $data, $this->data['content_languages'], $edit_lang_details );
		
		$child_details												= $this->queries->fetch_records("donation_campaigns_gallery", " AND donation_campaigns_id = '$edit_id' ")->result_array();		
		$gallery_images = array_filter($child_details, function($child) {
			return $child['type'] == "image";
		});
		$this->_create_child_for_form(true, $data, array_values($gallery_images) );	
		$gallery_videos = array_filter($child_details, function($child) {
			return $child['type'] == "video";
		});
		$this->_create_child2_for_form(true, $data, array_values($gallery_videos) );	
		
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
		
		#remove images
		foreach ($id	as $key	=> $result)
		{
			$row											= $this->queries->fetch_records("donation_campaigns", " AND id = '$result' ")->row();
			$this->remove_file($row->featured_image);
			$res											= $this->queries->fetch_records("donation_campaigns_gallery", " AND donation_campaigns_id = '$result' ")->result();
			foreach ($res as $k => $v) {
				$this->remove_file($v->gallery_image);
			}
		}
		
		
		
		#remove record from DETAIL table
		foreach ($id	as $key	=> $result)
		{
			$saveData['donation_campaigns_id']									= $result;	
			$this->queries->SaveDeleteTables($saveData, 'd', "tb_donation_campaigns_gallery", 'donation_campaigns_id') ;
			$saveData['id']									= $result;	
			$this->queries->SaveDeleteTables($saveData, 'd', "tb_donation_campaigns", 'id') ;
			$this->queries->SaveDeleteTables(['donation_campaigns_id'=>$result], 'd', "tb_donation_campaigns_languages", 'donation_campaigns_id') ;
		}
		
		
		
		
		$data['_messageBundle']								= $this->_messageBundle('success' , 
																					lang_line("operation_delete_success"), 
																					lang_line("heading_operation_success"), 
																					false,
																					true);
		redirect(  site_url( $data["_directory"] . "controls/view" )  );
		
	}

	public function amountReceived($campId=0, $campaignId=0){
		$donation_amount									= 0;
		if($campId >= 1){
			$donation_data										= $this->queries->fetch_records("who_donate", " AND donation_projects_id = '". $campId ."' AND is_paid = 1 ")-> result_array();

			foreach ($donation_data as $k => $donation) {
				$donation_amount	+= $donation['donate_amount'];
				if($donation['donation_mode'] == "recurring"){
					if($donation['num_of_recurring'] > 0){
						$payments = $this->db->query("SELECT dcp.amount FROM tb_donation_payments dp INNER JOIN `tb_card_payments` dcp ON dp.id = dcp.payment_id WHERE dp.table_id_value = ".$donation['id']." AND dp.table_name = 'tb_donation_form' AND dp.payment_mode = 'payeezy' AND dcp.is_cron = 1 AND dcp.transaction_id != '' AND dcp.sequence_no != 0")->result_array();
						foreach($payments as $payment) {
							$donation_amount	+= $payment['amount'];			
						}
					}
				}
			}
		}
		
		if($campaignId >= 1){
			$camp_data											= $this->queries->fetch_records("dc_offline_donation", " AND camp_id = '". $campaignId ."' AND status = 1 ")-> result_array();
			foreach ($camp_data as $k => $donation) {
				$donation_amount	+= $donation['donate_amount'];
			}
		}
		return $donation_amount;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */