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
		
		
		$this->data["_heading"]										= 'Manage Where We Work';
		$this->data["_pagetitle"]									= $this->data["_heading"] . " - ";
		$this->data['_pageview']									= $this->data["_directory"] . "view.php";
		
		
		
		#upload files extensions
		$this->data["images_types"]									= "gif|jpg|png";
		$this->data["images_dir"]	 								= "./assets/files/wherewework/";
		
		$TMP_record													= $this->queries->fetch_records("wherewework", " ORDER BY id desc ");
		$this->main_id												= FALSE;
		if ( $TMP_record -> num_rows() > 0 )
		{
			$this->main_id											= $TMP_record -> row("id");
		}
		
		$this->data['content_languages'] = $this->queries->fetch_records("content_languages", " ORDER BY id DESC ")->result_array();
		#pre-filled values for input fields
		$this->_create_fields_for_form(false, $this->data);	
		$this->_create_lang_fields_for_form(false, $this->data, array());
		
	}
	
	
	public function view_table_properties()
	{
		$tmp["tr_heading"]											= array('Title', 'Short Desc', 'Sort', 'Status');
		
		return $tmp;
	}
	
	public function view( $is_ajax = 0 )
	{
		$data														= $this->data;
		
		
		
		if ( $this->main_id )
		{
			redirect ( site_url( $data["_directory"] . "controls/edit/" . $this->main_id ) );	
		}
		else
		{
			$data["table_record"]										= $this->queries->fetch_records("wherewework", " ORDER BY id desc ");
			$data["table_properties"]									= $this->view_table_properties();
	

	
			$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );	
		}
				
		
	}
	
	public function add()
	{
		$data												= $this->data;
		
		
		if ( $this->main_id )
		{
			redirect ( site_url( $data["_directory"] . "controls/edit/" . $this->main_id ) );	
		}
		else
		{
			$data['_pageview']									= $data["_directory"] . "edit.php";
	
			
			$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );	
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
		
		
		
	
		#re-unite post values + language array with form_validations
		$this->functions->unite_post_values_form_validation();
		
		
		
		
		// $this->form_validation->set_rules("title", "Title", "trim|required");
		$this->rules_for_array_content("title", "Title");
		// $this->form_validation->set_rules("short_desc", "Short Description", "trim|required");
		$this->rules_for_array_content("short_desc", "Short Description");
		// $this->form_validation->set_rules("full_desc", "Full Description", "trim|required");
		$this->rules_for_array_content("full_desc", "Full Description");
		

		$this->form_validation->set_rules("map_title[]", "Map Title", "trim|required");
		$this->form_validation->set_rules("map_address[]", "Map Address", "trim|required");
		$this->form_validation->set_rules("map_country[]", "Map Country", "trim|required");
		$this->form_validation->set_rules("map_lat[]", "Map Latitude", "trim|required");
		$this->form_validation->set_rules("map_lon[]", "Map Longtitude", "trim|required");
		$this->form_validation->set_rules("chapter_link[]", "Chapter Link", "trim|required");
		
		
		
		
		if( $this->form_validation->run() == FALSE )
		{
			
			$data['_pageview']									= $data["_directory"] . "edit.php";
			$data['_messageBundle']								= $this->_messageBundle( 'danger' , validation_errors(), 'Error!');
			
			$this->load->view( ADMINCMS_TEMPLATE_VIEW, $data );
		}
		else
		{
			
			$short_desc = $this->input->post("short_desc");
			$full_desc = $this->input->post("full_desc");
			$title = $this->input->post("title");
			
			 $saveData											= array	(
																			"title"					=> $title[DEFAULT_LANG_CODE],
																			"short_desc"			=> $short_desc[DEFAULT_LANG_CODE],
																			"full_desc"				=> $full_desc[DEFAULT_LANG_CODE],
																			"status"				=> format_bool( $this->input->post('status') ),
																			"date_added"			=> date("Y-m-d H:i:s")
																		);
			if ($this->input->post('options') == "edit")
			{
				$saveData['id']										= $this->input->post('id');
				$this->queries->SaveDeleteTables($saveData, 'e', "tb_wherewework", 'id');  

				$this->_save_lang_content($saveData['id'], 'e'); 
			}
			else
			{
				$this->queries->SaveDeleteTables($saveData, 's', "tb_wherewework", 'id');  		
				$saveData['id']										= $this->db->insert_id();

				$this->_save_lang_content($saveData['id'], 's'); 
			}
			
			
			
			
			
			
			$TMP_child						= array("parentid"				=> $saveData['id']);
			$this->queries->SaveDeleteTables($TMP_child, 'd', "tb_wherewework_details", 'parentid');  
			if ( isset($_POST['map_title']) )
			{
				
				$_POST['map_title']						= array_values($_POST['map_title']);
				$_POST['map_address']					= array_values($_POST['map_address']);
				$_POST['map_country']					= array_values($_POST['map_country']);
				$_POST['map_lat']						= array_values($_POST['map_lat']);
				$_POST['map_lon']						= array_values($_POST['map_lon']);
				$_POST['chapter_link']					= array_values($_POST['chapter_link']);
				
				for ($m=0; $m < count($_POST['map_title']); $m++)
				{
					
					$TMP_child						= array("parentid"				=> $saveData['id'],
															"map_title"				=> $_POST["map_title"][$m],
															"map_address"			=> $_POST["map_address"][$m],
															"map_country"			=> $_POST["map_country"][$m],
															"map_lat"				=> $_POST["map_lat"][$m],
															"map_lon"				=> $_POST["map_lon"][$m],
															"chapter_link"			=> $_POST["chapter_link"][$m]
															);
					
					
					$this->queries->SaveDeleteTables($TMP_child, 's', "tb_wherewework_details", 'parentid');  
				}
			}
			
			
			
			
			
			$details												= $this->queries->fetch_records("wherewework");
			$details_child											= $this->queries->fetch_records("wherewework_details", " AND parentid = '". $details -> row("id") ."' ");
			$TMP_details											= array();
			foreach ( $details_child -> result_array() as $dc )
			{
				
			
				$TMP_details['places'][]							= array("id"				=> $dc['id'],
																			"name"				=> $dc['map_title'],
																			"lat"				=> $dc['map_lat'],
																			"lng"				=> $dc['map_lon'],
																			"country"			=> $dc['map_country'],
																			"info"				=> $dc['map_address'],
																			"chapter_link"		=> 'chapters/'.$dc['chapter_link']
																		);
			}
			
			if ( file_exists ("./assets/widgets/jquery.travelmap/cities.json") )
			{
				$file			= "./assets/widgets/jquery.travelmap/cities.json";
				// The new person to add to the file
				$person			= json_encode( $TMP_details );
				// Write the contents to the file, 
				// using the LOCK_EX flag to prevent anyone else writing to the file at the same time
				file_put_contents($file, $person, LOCK_EX);
			}
			
			
			$data['_messageBundle']									= $this->_messageBundle( 'success' , 
																							 lang_line("operation_saved_success"), 
																							 lang_line("heading_operation_success"),
																							 false, 
																							 true);


			redirect ( site_url( $data["_directory"] . "controls/edit/" . $this->main_id ) );	
			#redirect( $data["_directory"] . "controls/view" );
			
		
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
		$full_desc = $this->input->post("full_desc");
		$title = $this->input->post("title");

		$wherewework = $this->queries->fetch_records("wherewework_languages", " AND wherewework_id = '$ref_id' ")->result_array();

		foreach ($this->data['content_languages'] as $lang_key => $lang) {
			$saveData = [
				'short_desc' => $short_desc[$lang['code']],
				'full_desc' => $full_desc[$lang['code']],
				'title' => $title[$lang['code']],
				'wherewework_id' => $ref_id,
				'content_languages_id' => $lang['id']
			];
			
			// if(!$wherewework && !in_array($lang['id'], array_column($wherewework,'content_languages_id'))){
			if(!$wherewework || ($wherewework && !in_array($lang['id'], array_column($wherewework,'content_languages_id')))){
				$col = 'id';
				$action = 's';
			}else{
				$col = 'content_languages_id|wherewework_id';
				$action = 'e';
			}
			
			$this->queries->SaveDeleteTables($saveData, $action, "tb_wherewework_languages", $col);
		}
	}
	
	

	public function _create_fields_for_form( $return_array = false, &$data, $db_data = array() )
	{
	
		$empty_inputs				= array( "id", "status", "options", "unique_formid" );
		
		$filled_inputs				= array( "id", "status", "options", "unique_formid" );
		
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

	public function _create_lang_fields_for_form( $return_array = false, &$data, $loop_object = array(), $db_data = array() )
	{
	
		$empty_inputs				= array("title", "short_desc", "full_desc");
		$filled_inputs				= array("title", "short_desc", "full_desc");
		
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
		#print_r($db_data);
		$empty_inputs				= array("map_title", "map_address", "map_country", "map_lat", "map_lon", "chapter_link");
		
		$filled_inputs				= array("map_title", "map_address", "map_country", "map_lat", "map_lon", "chapter_link");
				
				
				
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
				$data[ $empty_inputs[$x] ][] = '';
			}
			
			return $data;
		
		}

	}
	
	public function edit( $edit_id )
	{
		
		$data														= $this->data;
		$data['_pageview']											= $data["_directory"] . "edit.php";
		
		$data["edit_id"]											= $edit_id;
		$edit_details												= $this->queries->fetch_records("wherewework", " AND id = '$edit_id' ");
		//echo $this->db->last_query(); die;
		
		
		if ( $edit_details -> num_rows() <= 0 )
		{
			show_404();
		}
		
		
		
		
		
		
		
		$edit_details												= $edit_details->row_array();
		$edit_details['options']									= "edit";
		$edit_details['unique_formid']								= "";
		
		$this->_create_fields_for_form(true, $data, $edit_details );	
		
		$edit_lang_details									= $this->queries->fetch_records("wherewework_languages", " AND wherewework_id = '$edit_id' ")->result_array();
		$this->_create_lang_fields_for_form(true, $data, $this->data['content_languages'], $edit_lang_details );
		
		
		
		$child_details												= $this->queries->fetch_records("wherewework_details", " AND parentid = '$edit_id' ");
		$this->_create_child_for_form(true, $data, $child_details->result_array());
		
		
		
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
			$this->queries->SaveDeleteTables($saveData, 'd', "tb_wherewework", 'id') ;
			$this->queries->SaveDeleteTables(['wherewework_id'=>$result], 'd', "tb_wherewework_languages", 'wherewework_id') ;
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