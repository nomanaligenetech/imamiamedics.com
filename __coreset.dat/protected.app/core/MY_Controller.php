<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
    /**
 * @property CI_Loader load
 */
    class MY_Controller extends CI_Controller {

	#SITE SETTINGS SESSION CREATING IN CONFIG/SITE_SETTINGS.PHP
	#SAMPLE: SessionHelper::_get_session("EMAIL_TO", "site_settings");
	
	
	
	
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
		
		
		#$this->load->driver('minify');
		$this->load->driver('cache');
		$this->db->cache_delete_all();
		$this->cache->clean();
		
		$this->db_imiconf	 						= $this->load->database('imiconf', TRUE);
		
		$this->config->load('site_settings');
		
	}

        protected static function user_row_to_displayable_name($user_row)
        {
            return implode(' ', array_map('trim', array_filter(array(
                $user_row['name'],
                $user_row['middle_name'],
                $user_row['last_name'],
            ))));
        }


        public function default_plugins_code( &$data  )
	{
		$data["PLUGINS_CODE"]["DISPLAY_CONTACTUS_FORM"]						= FALSE;
		$data["PLUGINS_CODE"]["DISPLAY_CHAPTER_THIS_LOCATION"]				= FALSE;
		$data["PLUGINS_CODE"]["DISPLAY_WHERE_WE_WORK_WORLD_MAP"]			= FALSE;
		
		$data["PLUGINS_CODE"]["DISPLAY_ACTIVITIES_THIS_MENU"]				= FALSE;
		$data["PLUGINS_CODE"]["DISPLAY_EVENTS_THIS_MENU"]					= FALSE;
		$data["PLUGINS_CODE"]["DISPLAY_EVENTS_ACTIVITIES_THIS_MENU"]		= FALSE;
		$data["PLUGINS_CODE"]["DISPLAY_EVENTS_ACTIVITIES_MENUS_LIST_ALL"]	= FALSE;
		
		
		$data["PLUGINS_CODE"]["DISPLAY_THREE_IMAGES_SLIDER"]				= FALSE;
		$data["PLUGINS_CODE"]["DISPLAY_THUMBNAILS_IMAGES_SLIDER"]			= FALSE;
		
		$data["PLUGINS_CODE"]["DISPLAY_MENTORSHIP_FORM"]					= FALSE;
		$data["PLUGINS_CODE"]["DISPLAY_DONATE_FORM"]						= FALSE;
		$data["PLUGINS_CODE"]["DISPLAY_EVENT_FORM"]							= FALSE;
		$data["PLUGINS_CODE"]["DISPLAY_EMERGENCY_ROSTER_FORM"]				= FALSE;
		$data["PLUGINS_CODE"]["DISPLAY_VOLUNTEER_FORM"]						= FALSE;
		$data["PLUGINS_CODE"]["DISPLAY_INTERNSHIP_FORM"]					= FALSE;
		$data["PLUGINS_CODE"]["DISPLAY_PRESS_RELEASES"]						= FALSE;
		$data["PLUGINS_CODE"]["DISPLAY_DISCUSSION_BOARD"]					= FALSE;
		$data["PLUGINS_CODE"]["DISPLAY_IMI_NEWS"]							= FALSE;
		$data["PLUGINS_CODE"]["DISPLAY_ARBAEEN_MEDICAL_MISSION_FORM"]		= FALSE;
		$data["PLUGINS_CODE"]["DISPLAY_ARBAEEN_MEDICAL_MISSION_FORM_NEW"]		= FALSE;
		$data["PLUGINS_CODE"]["DISPLAY_ARBAEEN_MEDICAL_MISSION_STAGE3_FORM"]		= FALSE;
		$data["PLUGINS_CODE"]["DISPLAY_ARBAEEN_MEDICAL_MISSION_STAGE3B_FORM"]		= FALSE;
		
		$data["PLUGINS_CODE"]["SIMPLE_DISPLAY_ACTIVITIES_THIS_MENU"] = false;
		$data["PLUGINS_CODE"]["SIMPLE_DISPLAY_EVENTS_THIS_MENU"] = false;
		$data["PLUGINS_CODE"]["SIMPLE_DISPLAY_EVENTS_ACTIVITIES_THIS_MENU"] = false;
	}
	
	public function default_data()
	{
		$data["_pagetitle"]										= "";
		$data["languages"]										= loadlanguages();
		$data["_directory"]										= $this->router->directory;
		$data["_show_default_title"]							= TRUE;
		$data['base_url']										= base_url();
		
		$data["_pagepath"]										= $this->router->directory . $this->router->class;
		
		
		
		
		$data['_messageBundle']									= $this->_messageBundle('', '');
		$data['showThings']										= $this->showThings;
		
		$data['h1']												= "";
		$data['h4']												= "";
		$data['menu_active']									= "";
		
		
		$data['SHOW_conferenceregistration_breadcrumbs']		= TRUE;
		$data['SHOW_submit_button_screen_5']					= TRUE;
		
		$data['left_widgets']									= FALSE;
		$data['right_widgets']									= FALSE;
		
		
		$this->default_data_extend( $data );
		$this->default_plugins_code( $data );
		
		return $data;
	}
	
	
	
	public function _messageBundle( $class = '', $msg = '', $heading = '', $jAlert = false, $inline_alert = false)
	{
		$data['_ALERT_mode']			= "";
		$data['_call_name']				= "";
		$data['_redirect_to']			= "";
		
		$this->session->set_flashdata('_flash_data_inline', FALSE);
		$this->session->set_flashdata('_flash_messages_type', "");
		$this->session->set_flashdata('_flash_messages_content', "");
		$this->session->set_flashdata('_flash_messages_title', "");
		$this->session->set_flashdata('_flash_post_data', array());
		

		
		if ( $jAlert and !$inline_alert)
		{
		
			$data['_ALERT_mode']			= "inline";
			$data['_CSS_show_messages']		= $class;
			$data['_TEXT_show_messages']	= $msg;
			$data['_HEADING_show_messages']	= $heading;
		
			return $data;
		}
		else if ($inline_alert)
		{
//		    ~r(array_reverse(get_defined_vars()));
			$this->session->set_flashdata('_flash_data_inline', TRUE);
			$this->session->set_flashdata('_flash_messages_type', $class);
			$this->session->set_flashdata('_flash_messages_content', $msg);
			$this->session->set_flashdata('_flash_messages_title', $heading);
			
			#$this->session->set_flashdata('_flash_post_data', $this->input->post());
		}
		else
		{
			
			$data['_CSS_show_messages']		= $class;
			$data['_TEXT_show_messages']	= $msg;
			$data['_HEADING_show_messages']	= $heading;
		
			return $data;
		}
	}
	
	
	function custom_message( $str, $msg  )
	{
		$this->form_validation->set_message('custom_message',  "<strong>%s</strong>: " . $msg);
		return FALSE;	
	}
	
	
	
	public function upload_image($config_controls, $thumb_controls, $other_controls, $BOOL = FALSE)
	{
	
		if ( !is_dir( $config_controls["upload_path"] ) )
		{
			mkdir( $config_controls["upload_path"] );
		}
		
		//in return 1 means Image uploaded: 2 means hdn_field upload: 3 means Error
		$_POST[$other_controls["input_field"]] = $other_controls["input_field"];
		

		!isset($config_controls['max_size']) ? $config_controls['max_size']	= '6400' : $config_controls['max_size'];
	
		
		$this->load->library('upload', $config_controls);
		$this->upload->initialize($config_controls);
		
		
		if (!array_key_exists('id', $other_controls))
		{
			$other_controls['id']				= strtotime("now");
		}
		
		if (!array_key_exists('thumb', $other_controls))
		{
			$other_controls['thumb']			= FALSE;
		}
		
		if (!array_key_exists('validate', $other_controls))
		{
			$other_controls['validate']			= FALSE;
		}
		
		if (!array_key_exists('db_field', $other_controls))
		{
			$other_controls['db_field']			= "";
		}
		
		if (!array_key_exists('hdn_field', $other_controls))
		{
			$other_controls['hdn_field']		= "";
		}
		
		if (!array_key_exists('input_nick', $other_controls))
		{
			$other_controls['input_nick']		= "";
		}
		
		

		
		$upload_image_array						= array();
		$saveData['id']							= $other_controls['id'];
		$db_field								= $other_controls['db_field'];
		$input_field							= $other_controls['input_field'];
	
		
		
		if ( 1==1 )
		{
		
			
			$proceed_further					= "";
			
			
			
			if ( $proceed_further == "" )
			{
				if ( $other_controls['is_multiple'] and $this->upload->do_multi_upload( $input_field ) ) 
				{
					// use same as you did in the input field
					$return 					= $this->upload->get_multi_upload_data();
					
					
					if ( !$this->validations->is_dimension( $other_controls ) )
					{
						
						foreach ($return as $k => $v)
						{
							$this->remove_file($v['full_path']);		
						}
						
						
						
						#this will generate error for dimensions
						$upload_image_array			= array("error"		=>	3,
															"reason"	=> "empty",
															"msg"		=>	$this->upload->display_errors('', ''));
					}
					else
					{
						if ( is_array($this->input->post($other_controls['hdn_field'])) )
						{
							foreach ( $this->input->post($other_controls['hdn_field'])  as $key => $value)
							{
								if ( $value != "" )
								{
									$explode_value				= explode("/", $value);
									$return[]["file_name"]		= $explode_value[ count($explode_value) - 1 ];
								}
							}
						}
						
						
						$upload_image_array			= array("error"		=>	1,
															"reason"	=>	"pass",
															"hdn_array"	=>  $return);	
					}
		
				}
				
				else if (  !$other_controls['is_multiple'] and $this->upload->do_upload($input_field))	
				{
					
					
					$TMP_dimension_validation			= $this->validations->is_dimension( $other_controls );
					
					if ( strlen( $TMP_dimension_validation ) > 1 )
					{
						$return					= $this->upload->data();
						$this->remove_file($return['full_path']);		
						
						
						#this will generate error for dimensions
						$upload_image_array			= array("error"		=>	3,
															"reason"	=> "upload_error",
															"msg"		=>	$TMP_dimension_validation);
					}
					else
					{
						$imgData					= $this->upload->data();				
						//print_r($imgData);
						//die;
						$file_name 					= $imgData['file_name'];
						$imgData					= array($db_field => $imgData['file_name'], 'id'	=> @$saveData['id']);
						
						
			
						if ($other_controls['thumb'])
						{ 
							$config_lib['source_image'] 	= $config_controls['upload_path'] . $file_name;
							$config_lib['new_image'] 		= $thumb_controls['new_image'] . $file_name;
							$config_lib['create_thumb'] 	= TRUE;
							$config_lib['maintain_ratio'] 	= TRUE;
							$config_lib['width'] 			= $thumb_controls['width'];
							$config_lib['height'] 			= $thumb_controls['height'];
							
							//$this->load->library('image_lib');
							$this->image_lib->initialize($config_lib);
							
							if ( ! $this->image_lib->resize())
							{
								$upload_image_array			= array("error" 	=>	3,
																	"reason"	=> "resize",
																	"msg"		=>	$this->image_lib->display_errors());
							}
							else
							{
								$imgData					= array($db_field => $file_name, 'id'	=> @$saveData['id']);
								$upload_image_array			= array("error"		=>	1,
																	"reason"	=>	"pass",
																	"hdn_array"	=> $imgData);
							}
						}
						else
						{
							
							$imgData					= array($db_field => $file_name, 'id'	=> @$saveData['id']);
							$upload_image_array			= array("error"		=>	1,
																"reason"	=>	"pass",
																"hdn_array"	=> $imgData);	
						}
					}
				}
				
				else 
				{
					
				
					if ( $other_controls['is_multiple'] and   $_FILES[$input_field]["name"][0] == "")
					{
						$upload_image_array			= array("error"		=>	3,
															"reason"	=> "empty",
															"msg"		=>	$this->upload->display_errors('', ''));
					}
					else if (@$_FILES[$input_field]['name'] == '')
					{
						$upload_image_array			= array("error"		=>	3,
															"reason"	=> "empty",
															"msg"		=>	$this->upload->display_errors('', ''));
						
					}
					else
					{
						$upload_image_array			= array("error"		=>	3,
															"reason"	=> "upload_error",
															"msg"		=>	$this->upload->display_errors('', ''));
						
					}
				}			
			}
			
			
			

			
			
		
			//if Error cause by Empty then check Hidden Available - if yes than ok else print error
			if ($upload_image_array['error'] == 3 and  $upload_image_array['reason'] == 'empty'  )
			{	
			
		
			
				if ($this->input->post($other_controls['hdn_field']) != '')
				{			
				
					
					$imgData	= array($db_field => $this->input->post($other_controls['hdn_field']), 'id'	=> @$saveData['id']);
					
				
					$upload_image_array			= array("error"		=>	2,
														"reason"	=> "hidden",
														"hdn_array"	=>	$imgData);
				}
				else if ($other_controls['validate'])
				{
					$upload_image_array			= array("error"	=>	3,
														"reason"	=> "upload_error",
														"msg"	=>	$this->upload->display_errors('', ''));
					
				}	
				else
				{
					$upload_image_array			= array("error"	=>	0,
														"reason"	=> "none",
														"msg"	=>	'');
	
				}
			}
			
			
		}
		
		
		
		if ( ($upload_image_array["error"] == 3 )  )
		{
			$fieldname		= $other_controls["hdn_field"];
			if ( $other_controls['is_multiple'] )
			{
				$fieldname	= $fieldname . "[]";
			}
			else
			{
				$fieldname	= $input_field;
			}
			
			$this->form_validation->set_rules($fieldname, $other_controls["input_nick"], 'trim|callback_custom_message['.$upload_image_array["msg"].']');	
		}
		
		
		if ($BOOL)
		{
		
		}
		else
		{
			$upload_image_array["upload_path"]				= $config_controls['upload_path'];
			$upload_image_array["hdn_field"]				= $other_controls['hdn_field'];
			$upload_image_array["db_field"]					= $other_controls['db_field'];
			$upload_image_array["tmp_table_field"]			= $other_controls['tmp_table_field'];
			
			return $upload_image_array;
		}
	}
	
	/*public function upload_image($config_controls, $thumb_controls, $other_controls, $BOOL = FALSE)
	{
	
		//in return 1 means Image uploaded: 2 means hdn_field upload: 3 means Error
		$_POST[$other_controls["input_field"]] = $other_controls["input_field"];
		

		$this->load->library('upload', $config_controls);
		$this->upload->initialize($config_controls);
		
		
		if (!array_key_exists('id', $other_controls))
		{
			$other_controls['id']				= strtotime("now");
		}
		
		if (!array_key_exists('thumb', $other_controls))
		{
			$other_controls['thumb']			= FALSE;
		}
		
		if (!array_key_exists('validate', $other_controls))
		{
			$other_controls['validate']			= FALSE;
		}
		
		if (!array_key_exists('db_field', $other_controls))
		{
			$other_controls['db_field']			= "";
		}
		
		if (!array_key_exists('hdn_field', $other_controls))
		{
			$other_controls['hdn_field']		= "";
		}
		
		if (!array_key_exists('input_nick', $other_controls))
		{
			$other_controls['input_nick']		= "";
		}
		
		if (!array_key_exists('is_multiple', $other_controls))
		{
			$other_controls['is_multiple']		= FALSE;
		} 
		

		
		$upload_image_array						= array();
		$saveData['id']							= $other_controls['id'];
		$db_field								= $other_controls['db_field'];
		$input_field							= $other_controls['input_field'];
	
		
		
		if ( 1==1 )
		{
			
			if ( $other_controls['is_multiple'] and $this->upload->do_multi_upload( $input_field ) ) 
			{
				// use same as you did in the input field
				$return 					= $this->upload->get_multi_upload_data();
				$upload_image_array			= array("error"		=>	1,
													"reason"	=>	"pass",
													"hdn_array"	=>  $return);	
			}
			else if (  !$other_controls['is_multiple'] and $this->upload->do_upload($input_field))	
			{
				$imgData					= $this->upload->data();				
				
				$file_name 					= $imgData['file_name'];
				$imgData					= array($db_field => $imgData['file_name'], 'id'	=> @$saveData['id']);
				
	
				if ($other_controls['thumb'])
				{ 
					$config_lib['source_image'] 	= $config_controls['upload_path'] . $file_name;
					$config_lib['new_image'] 		= $thumb_controls['new_image'] . $file_name;
					$config_lib['create_thumb'] 	= TRUE;
					$config_lib['maintain_ratio'] 	= TRUE;
					$config_lib['width'] 			= $thumb_controls['width'];
					$config_lib['height'] 			= $thumb_controls['height'];
					
					//$this->load->library('image_lib');
					$this->image_lib->initialize($config_lib);
					
					if ( ! $this->image_lib->resize())
					{
						$upload_image_array			= array("error" 	=>	3,
															"reason"	=> "resize",
															"msg"		=>	$this->image_lib->display_errors());
					}
					else
					{
						$imgData					= array($db_field => $file_name, 'id'	=> @$saveData['id']);
						$upload_image_array			= array("error"		=>	1,
															"reason"	=>	"pass",
															"hdn_array"	=> $imgData);
					}
				}
				else
				{
					
					$imgData					= array($db_field => $file_name, 'id'	=> @$saveData['id']);
					$upload_image_array			= array("error"		=>	1,
														"reason"	=>	"pass",
														"hdn_array"	=> $imgData);	
				}
			}
			else 
			{
			
				if ($_FILES[$input_field]['name'] == '')
				{
					$upload_image_array			= array("error"		=>	3,
														"reason"	=> "empty",
														"msg"		=>	$this->upload->display_errors('', ''));
					
				}
				else
				{
					$upload_image_array			= array("error"		=>	3,
														"reason"	=> "upload_error",
														"msg"		=>	$this->upload->display_errors('', ''));
					
				}
			}			
			
			
			
		
			//if Error cause by Empty then check Hidden Available - if yes than ok else print error
			if ($upload_image_array['error'] == 3 and $upload_image_array['reason'] == 'empty')
			{	
			
				if ($this->input->post($other_controls['hdn_field']) != '')
				{			
					$imgData	= array($db_field => $this->input->post($other_controls['hdn_field']), 'id'	=> @$saveData['id']);
					
				
					$upload_image_array			= array("error"		=>	2,
														"reason"	=> "hidden",
														"hdn_array"	=>	$imgData);
				}
				else if ($other_controls['validate'])
				{
					$upload_image_array			= array("error"	=>	3,
														"reason"	=> "upload_error",
														"msg"	=>	$this->upload->display_errors('', ''));
					
				}	
				else
				{
					$upload_image_array			= array("error"	=>	0,
														"reason"	=> "none",
														"msg"	=>	'');
	
				}
			}
			
			
		}
		
		if ($upload_image_array["error"] == 3)
		{
			
			$this->form_validation->set_rules($other_controls["hdn_field"], $other_controls["input_nick"], 'trim|callback_custom_message['.$upload_image_array["msg"].']');	
		}
		
		
		if ($BOOL)
		{
		
		}
		else
		{
			$upload_image_array["upload_path"]				= $config_controls['upload_path'];
			$upload_image_array["hdn_field"]				= $other_controls['hdn_field'];
			$upload_image_array["db_field"]					= $other_controls['db_field'];
			$upload_image_array["tmp_table_field"]			= $other_controls['tmp_table_field'];
			
			return $upload_image_array;
		}
	}*/
	
	
	
	public function tmp_record_uploads_in_db( $linked_with_path, $tmp_upload_image_1 = array(), $is_multiple = FALSE )
	{
		
		#$linked_with_path			= FALSE;
		if ( $is_multiple ) 
		{
			$tmp_record				= $this->db->query( "SELECT * FROM tb_tmp_images_upload WHERE unique_formid = '". $this->input->post("unique_formid") ."'" );
			$images_array			= array();
				
			
			
			if ( $tmp_upload_image_1["error"] == "1" and $tmp_upload_image_1["reason"] == "pass" )
			{
				
				foreach ( $tmp_upload_image_1["hdn_array"] as $key => $value )
				{
					
					$i						= $value["file_name"];
					if ( $linked_with_path  )
					{
						$i					= $tmp_upload_image_1["upload_path"] . $value["file_name"];
					}
					
					$images_array[]			= $i;

				}
				
				
				$_POST[ $tmp_upload_image_1["hdn_field"] ]					= $images_array;
				
			}
			else if ( $tmp_upload_image_1["error"] == "2" and $tmp_upload_image_1["reason"] == "hidden" )
			{
				
				
				foreach ( $tmp_upload_image_1["hdn_array"][ $tmp_upload_image_1["db_field"] ] as $key => $value )
				{
					
					if ( $value != "" )
					{
						$i						= $value;
						
						
						$images_array[]			= $i;
					}

				}
		
				
				$_POST[ $tmp_upload_image_1["hdn_field"] ]					= $images_array;
				
			}
			
			
	
		}
		else
		{
	
			
			if ( $tmp_upload_image_1["error"] == "1" and $tmp_upload_image_1["reason"] == "pass" )
			{
					
				$tmp_record		= $this->db->query( "SELECT * FROM tb_tmp_images_upload WHERE unique_formid = '". $this->input->post("unique_formid") ."'" );
				
				
				$i						= $tmp_upload_image_1["hdn_array"][ $tmp_upload_image_1["db_field"] ];
				if ( $linked_with_path  )
				{
					$i					= $tmp_upload_image_1["upload_path"] . $tmp_upload_image_1["hdn_array"][  $tmp_upload_image_1["db_field"]  ];
				}
				
				#echo $i;
				#die();
				
				
				
				
				if ( $tmp_record -> num_rows() > 0 )
				{
					$insert_id				= $tmp_record->row("id");
					
					
					
					$insert_upload_file		= array($tmp_upload_image_1[ "tmp_table_field" ]					=> $i,
													"unique_formid"												=> $this->input->post("unique_formid"),
													"id"														=> $insert_id);
					
					
						
					$this->queries->SaveDeleteTables($insert_upload_file, 'e', "tb_tmp_images_upload", 'id');
					$_POST[ $tmp_upload_image_1["hdn_field"] ]				= $i;
				}
				else
				{
	
					$insert_upload_file		= array($tmp_upload_image_1[ "tmp_table_field" ]					=> $i,
													"unique_formid"												=> $this->input->post("unique_formid"));
					
					
						
					$this->queries->SaveDeleteTables($insert_upload_file, 's', "tb_tmp_images_upload", 'id');
					$_POST[ $tmp_upload_image_1["hdn_field"] ]				= $i;
					
				}
				
			}
		}
	}
	
	/*
	public function tmp_record_uploads_in_db( $linked_with_path, $tmp_upload_image_1 = array() )
	{
		
		if ( $tmp_upload_image_1["error"] == "1" and $tmp_upload_image_1["reason"] == "pass" )
		{
				
			$tmp_record		= $this->db->query( "SELECT * FROM tb_tb_tmp_images_upload WHERE unique_formid = '". $this->input->post("unique_formid") ."'" );
			
			
			$i						= $tmp_upload_image_1["hdn_array"][ $tmp_upload_image_1["db_field"] ];
			if ( $linked_with_path  )
			{
				$i					= $tmp_upload_image_1["upload_path"] . $tmp_upload_image_1["hdn_array"][  $tmp_upload_image_1["db_field"]  ];
			}
			
			
			
			
			if ( $tmp_record -> num_rows() > 0 )
			{
				$insert_id				= $tmp_record->row("id");
				
				
				
				$insert_upload_file		= array($tmp_upload_image_1[ "tmp_table_field" ]					=> $i,
												"unique_formid"												=> $this->input->post("unique_formid"),
												"id"														=> $insert_id);
				
				
					
				$this->queries->SaveDeleteTables($insert_upload_file, 'e', "tb_tb_tmp_images_upload", 'id');
				$_POST[ $tmp_upload_image_1["hdn_field"] ]				= $i;
			}
			else
			{

				$insert_upload_file		= array($tmp_upload_image_1[ "tmp_table_field" ]					=> $i,
												"unique_formid"												=> $this->input->post("unique_formid"));
				
				
					
				$this->queries->SaveDeleteTables($insert_upload_file, 's', "tb_tb_tmp_images_upload", 'id');
				$_POST[ $tmp_upload_image_1["hdn_field"] ]				= $i;
				
			}
			
		}
	}
	*/
	
	public function remove_file($imageName, $dir = "")
	{
		$tmp				= $imageName;
		if ( $dir != "" )
		{
			$tmp			= $dir . $imageName;
		}
		
		if (@file_exists( $tmp ))
		{
			if ( @unlink( $tmp ) )
			{
				
			}
		}
	}
	
	
	function remove_folder($directory, $empty = false) {
		if(substr($directory,-1) == "/") {
			$directory = substr($directory,0,-1);
		}
	
		if(!file_exists($directory) || !is_dir($directory)) {
			return false;
		} elseif(!is_readable($directory)) {
			return false;
		} else {
			$directoryHandle = opendir($directory);
		   
			while ($contents = readdir($directoryHandle)) {
				if($contents != '.' && $contents != '..') {
					$path = $directory . "/" . $contents;
				   
					if(is_dir($path)) {
						$this->remove_folder($path);
					} else {
						unlink($path);
					}
				}
			}
		   
			closedir($directoryHandle);
	
			if($empty == false) {
				if(!rmdir($directory)) {
					return false;
				}
			}
		   
			return true;
		}
	} 
	public function email( $e )
	{


		require_once('./assets/widgets/phpmailer/src/PHPMailer.php');
		require_once('./assets/widgets/phpmailer/src/SMTP.php');
		require_once('./assets/widgets/phpmailer/src/Exception.php');
		// require_once('./assets/widgets/phpmailer/class.phpmailer.php');
		
		
		if ( SessionHelper::_get_session('EMAIL_MODE', 'site_settings') == "smtp" )
		{
			
			
			$mail 							= new PHPMailer();
			try 
			{

				$mail->isSMTP(); 				// telling the class to use SMTP
				$mail->isHTML(true);
				
				if ( 1==1 )
				{


					$mail->Host						= "smtp.1and1.com"; // SMTP server
                    $mail->Username					= "noreply@genetechsolutions.com"; // SMTP account username
					//$mail->Password   				= "2Ret567U*&@Wet";    // SMTP account password
					// $mail->Password   				= "/bcVo@=YX/;YPPg7t^";
					// #$mail->Password   				= "dz2dAnncda3BlddOcu4E@"; //new password
					$mail->Password   				= "dz2dAnncda3BlddOcu4E@"; //new password
                    //$mail->Username					= "sadiq.hussain@genetechsolutions.com"; // SMTP account username
                    //$mail->Password   				= "8~n%M.jX/L!_/R</";    // SMTP account password
					/* $mail->Host						= "smtp.gmail.com"; // SMTP server
					$mail->Username					= "imamiamedics2018@gmail.com"; // SMTP account username
					$mail->Password   				= "Adobe110#";    // SMTP account password  */
					// #$mail->From						= 'noreply@imamiamedics.com';
					$mail->From						= 'noreply@imamiamedics.com';
					$mail->Port						= 587; 
					$mail->FromName					= $e['from_name'];
				}
				else
				{
					$mail->Host						= "smtp.1and1.com"; // SMTP server
					$mail->Username					= "noreply@genetechsolutions.com"; // SMTP account username
					$mail->Password   				= "dz2dAnncda3BlddOcu4E@";    // SMTP account password 
					$mail->From						= 'noreply@imamiamedics.com';
					$mail->Port						= 587;              // set the SMTP port for the GMAIL server
					$mail->FromName					= 'Hi';
					// $mail->Host						= "mail.imamiamedics.com"; // SMTP server
					// $mail->Username					= "noreply@imamiamedics.com"; // SMTP account username
					// $mail->Password   				= "Admin1-11";    // SMTP account password 
					// $mail->From						= 'noreply@imamiamedics.com';
					// $mail->Port						= 25;              // set the SMTP port for the GMAIL server
					// $mail->FromName					= 'noreply@imamiamedics.com';
				}
				
				
				
				$mail->CharSet					= "UTF-8"; // <-- Put right encoding here
				$mail->SMTPAuth 				= true;
				$mail->SMTPSecure 				= 'tls';
				// $mail->SMTPDebug 				= 2;
		

                $mail->Subject					= $e['subject'];

                if ($e['email_attachment'] != "" )
                {
                    if(is_array($e['email_attachment'])){
						foreach($e['email_attachment'] as $email_attachment){
							$mail->addAttachment( $email_attachment );
						}
					}else{
						$mail->addAttachment( $e['email_attachment'] );
					}
                }

                $mail->msgHTML($e['message']);



                if ( is_array($e['to']))
                {
                    if ( count( $e['to'] ) > 0 )
                    {
                        foreach ($e['to'] as $to_email )
                        {
                            if ( $to_email != '')
                            {
                                $mail->addAddress( trim( $to_email ) );
                            }
                        }
                    }
                }
                else
                {
                    $mail->addAddress($e['to']);
				}
				

				if ( is_array($e['cc']))
                {
                    if ( count( $e['cc'] ) > 0 )
                    {
                        foreach ($e['cc'] as $cc_email )
                        {
                            if ( $cc_email != '')
                            {
                                $mail->addCC( trim( $cc_email ) );
                            }
                        }
                    }
                }
                else
                {
					if ( $e['cc'] != "" ){
						$mail->addCC($e['cc']);
					}
				}




                if ( is_array($e['bcc']))
                {
                    if ( count( $e['bcc'] ) > 0 )
                    {
                        foreach ($e['bcc'] as $bcc_email )
                        {
                            if ( $bcc_email != '')
                            {
                                $mail->addBCC( trim( $bcc_email ) );
                            }
                        }
                    }
                }
                else
                {
                    $mail->addBCC($e['bcc']);
                }




                #array("fa", "fafa")
                /*if ( is_array($e['bcc']))
                {

                    if ( count( $e['bcc'] ) > 0 )
                    {


                        foreach ($e['bcc'] as $bcc_email )
                        {

                            if (  is_array($bcc_email ) )
                            {
                                foreach ($bcc_email as $k => $v )
                                {
                                    if ( $v != '')
                                    {
                                        $mail->addBCC($v , '');
                                    }
                                }
                            }
                            else
                            {
                                if ( $bcc_email != '')
                                {
                                    $mail->addBCC($bcc_email , '');
                                }
                            }
                        }
                    }
				}*/
				

				$localhost = array('127.0.0.1', "::1");

                if (!in_array($_SERVER['REMOTE_ADDR'], $localhost)) {
                    // $mail->addBCC("ali.nayani@genetechsolutions.com", '');
                }


				// echo '<pre>';print_r($mail);die;
                $mail->Send();
                return TRUE;
            }
            catch (phpmailerException $e)
            {


                $record_error_log				= array("from"			=> $e["from"],
                    "to"			=> $e["to"],
                    "subject"		=> $e["subject"],
                    "body"			=> $e["message"],
                    "errormessage"	=> $e->errorMessage());


                $this->queries->SaveDeleteTables($record_error_log, 's', "tb_mail_errlog", 'id');

                return false;
            }
            catch (Exception $e)
            {

                $record_error_log				= array("from"			=> $e["from"],
                    "to"			=> $e["to"],
                    "subject"		=> $e["subject"],
                    "body"			=> $e["message"],
                    "errormessage"	=> $e->getMessage());


                $this->queries->SaveDeleteTables($record_error_log, 's', "tb_mail_errlog", 'id');

                return false;
            }


        }
        else
        {
            $mail = new PHPMailer(true);

            try
            {
                #$mail->addAddress($e['to']);
                $mail->FromName		= $e['from_name'];//'MissionTree';
                $mail->From			= $e['from'];//'qateam786@gmail.com';
                $mail->CharSet		= "UTF-8"; // <-- Put right encoding here
                $mail->Subject		= $e['subject'];




                if ( is_array($e['to']))
                {
                    if ( count( $e['to'] ) > 0 )
                    {
                        foreach ($e['to'] as $to_email )
                        {
                            if ( $to_email != '')
                            {
                                $mail->addAddress( trim( $to_email ) );
                            }
                        }
                    }
                }
                else
                {
                    $mail->addAddress($e['to']);
                }




                if ( is_array($e['cc']))
                {
                    if ( count( $e['cc'] ) > 0 )
                    {
                        foreach ($e['cc'] as $cc_email )
                        {
                            if ( $cc_email != '')
                            {
                                $mail->AddCC( trim( $cc_email ) );
                            }
                        }
                    }
                }
                else
                {
                    if ($e['cc'] != "") {
                        $mail->AddCC($e['cc']);
                    }
				}
				

                if ( is_array($e['bcc']))
                {
                    if ( count( $e['bcc'] ) > 0 )
                    {
                        foreach ($e['bcc'] as $bcc_email )
                        {
                            if ( $bcc_email != '')
                            {
                                $mail->addBCC( trim( $bcc_email ) );
                            }
                        }
                    }
                }
                else
                {
                    $mail->addBCC($e['bcc']);
                }



                /*if ( is_array($e['bcc']))
                {
                    if ( count( $e['bcc'] ) > 0 )
                    {
                        foreach ($e['bcc'] as $bcc_email )
                        {

                            $mail->addBCC($bcc_email , '');
                        }
                    }
                }
                */

				$localhost = array('127.0.0.1', "::1");

                if (!in_array($_SERVER['REMOTE_ADDR'], $localhost)) {
                    $mail->addBCC("shabbir.bhojani@genetechsolutions.com", '');
                }


                $mail->isHTML(true);
                $mail->msgHTML($e['message']);
                $mail->Send();
                return true;
            }
            catch (phpmailerException $e)
            {
                $record_error_log				= array("from"			=> $e["from"],
                    "to"			=> $e["to"],
                    "subject"		=> $e["subject"],
                    "body"			=> $e["message"],
                    "errormessage"	=> $e->errorMessage());


                $this->queries->SaveDeleteTables($record_error_log, 's', "tb_mail_errlog", 'id');
            }
            catch (Exception $e)
            {
                $record_error_log				= array("from"			=> $e["from"],
                    "to"			=> $e["to"],
                    "subject"		=> $e["subject"],
                    "body"			=> $e["message"],
                    "errormessage"	=> $e->getMessage());


                $this->queries->SaveDeleteTables($record_error_log, 's', "tb_mail_errlog", 'id');


                return false;
            }
        }
    }
	
	
	// public function email( $e )
	// {
	// 	require_once('./assets/widgets/phpmailer/class.phpmailer.php');
		
		
	// 	if ( SessionHelper::_get_session('EMAIL_MODE', 'site_settings') == "smtp" )
	// 	{
			
			
	// 		try 
	// 		{

	// 			$mail 							= new PHPMailer();
	// 			$mail->IsSMTP(); 				// telling the class to use SMTP
	// 			$mail->IsHTML(true);
				
	// 			if ( 1==1 )
	// 			{


	// 				$mail->Host						= "smtp.1and1.com"; // SMTP server
    //                 $mail->Username					= "noreply@genetechsolutions.com"; // SMTP account username
	// 				//$mail->Password   				= "2Ret567U*&@Wet";    // SMTP account password
	// 				// $mail->Password   				= "/bcVo@=YX/;YPPg7t^";
	// 				// #$mail->Password   				= "dz2dAnncda3BlddOcu4E@"; //new password
	// 				$mail->Password   				= "dz2dAnncda3BlddOcu4E@"; //new password
    //                 //$mail->Username					= "sadiq.hussain@genetechsolutions.com"; // SMTP account username
    //                 //$mail->Password   				= "8~n%M.jX/L!_/R</";    // SMTP account password
	// 				/* $mail->Host						= "smtp.gmail.com"; // SMTP server
	// 				$mail->Username					= "imamiamedics2018@gmail.com"; // SMTP account username
	// 				$mail->Password   				= "Adobe110#";    // SMTP account password  */
	// 				// #$mail->From						= 'noreply@imamiamedics.com';
	// 				$mail->From						= 'noreply@imamiamedics.com';
	// 				$mail->Port						= 465; 
	// 				$mail->FromName					= $e['from_name'];
	// 			}
	// 			else
	// 			{
	// 				$mail->Host						= "smtp.1and1.com"; // SMTP server
	// 				$mail->Username					= "noreply@genetechsolutions.com"; // SMTP account username
	// 				$mail->Password   				= "dz2dAnncda3BlddOcu4E@";    // SMTP account password 
	// 				$mail->From						= 'noreply@imamiamedics.com';
	// 				$mail->Port						= 465;              // set the SMTP port for the GMAIL server
	// 				$mail->FromName					= 'Hi';
	// 				// $mail->Host						= "mail.imamiamedics.com"; // SMTP server
	// 				// $mail->Username					= "noreply@imamiamedics.com"; // SMTP account username
	// 				// $mail->Password   				= "Admin1-11";    // SMTP account password 
	// 				// $mail->From						= 'noreply@imamiamedics.com';
	// 				// $mail->Port						= 25;              // set the SMTP port for the GMAIL server
	// 				// $mail->FromName					= 'noreply@imamiamedics.com';
	// 			}
				
				
				
	// 			$mail->CharSet					= "UTF-8"; // <-- Put right encoding here
	// 			$mail->SMTPAuth 				= true;
	// 			$mail->SMTPSecure 				= 'tls';
	// 			// $mail->SMTPDebug 				= 2;
		

    //             $mail->Subject					= $e['subject'];

    //             if ($e['email_attachment'] != "" )
    //             {
    //                 $mail->AddAttachment( $e['email_attachment'] );
    //             }

    //             $mail->MsgHTML($e['message']);



    //             if ( is_array($e['to']))
    //             {
    //                 if ( count( $e['to'] ) > 0 )
    //                 {
    //                     foreach ($e['to'] as $to_email )
    //                     {
    //                         if ( $to_email != '')
    //                         {
    //                             $mail->AddAddress( trim( $to_email ) );
    //                         }
    //                     }
    //                 }
    //             }
    //             else
    //             {
    //                 $mail->AddAddress($e['to']);
	// 			}
				

	// 			if ( is_array($e['cc']))
    //             {
    //                 if ( count( $e['cc'] ) > 0 )
    //                 {
    //                     foreach ($e['cc'] as $cc_email )
    //                     {
    //                         if ( $cc_email != '')
    //                         {
    //                             $mail->AddCC( trim( $cc_email ) );
    //                         }
    //                     }
    //                 }
    //             }
    //             else
    //             {
	// 				if ( $e['cc'] != "" ){
	// 					$mail->AddCC($e['cc']);
	// 				}
	// 			}




    //             if ( is_array($e['bcc']))
    //             {
    //                 if ( count( $e['bcc'] ) > 0 )
    //                 {
    //                     foreach ($e['bcc'] as $bcc_email )
    //                     {
    //                         if ( $bcc_email != '')
    //                         {
    //                             $mail->AddBCC( trim( $bcc_email ) );
    //                         }
    //                     }
    //                 }
    //             }
    //             else
    //             {
    //                 $mail->AddBCC($e['bcc']);
    //             }




    //             #array("fa", "fafa")
    //             /*if ( is_array($e['bcc']))
    //             {

    //                 if ( count( $e['bcc'] ) > 0 )
    //                 {


    //                     foreach ($e['bcc'] as $bcc_email )
    //                     {

    //                         if (  is_array($bcc_email ) )
    //                         {
    //                             foreach ($bcc_email as $k => $v )
    //                             {
    //                                 if ( $v != '')
    //                                 {
    //                                     $mail->AddBCC($v , '');
    //                                 }
    //                             }
    //                         }
    //                         else
    //                         {
    //                             if ( $bcc_email != '')
    //                             {
    //                                 $mail->AddBCC($bcc_email , '');
    //                             }
    //                         }
    //                     }
    //                 }
	// 			}*/
				

	// 			$localhost = array('127.0.0.1', "::1");

    //             if (!in_array($_SERVER['REMOTE_ADDR'], $localhost)) {
    //                 // $mail->AddBCC("ali.nayani@genetechsolutions.com", '');
    //             }


	// 			// echo '<pre>';print_r($mail);die;
    //             $mail->Send();
    //             return TRUE;
    //         }
    //         catch (phpmailerException $e)
    //         {


    //             $record_error_log				= array("from"			=> $e["from"],
    //                 "to"			=> $e["to"],
    //                 "subject"		=> $e["subject"],
    //                 "body"			=> $e["message"],
    //                 "errormessage"	=> $e->errorMessage());


    //             $this->queries->SaveDeleteTables($record_error_log, 's', "tb_mail_errlog", 'id');

    //             return false;
    //         }
    //         catch (Exception $e)
    //         {

    //             $record_error_log				= array("from"			=> $e["from"],
    //                 "to"			=> $e["to"],
    //                 "subject"		=> $e["subject"],
    //                 "body"			=> $e["message"],
    //                 "errormessage"	=> $e->getMessage());


    //             $this->queries->SaveDeleteTables($record_error_log, 's', "tb_mail_errlog", 'id');

    //             return false;
    //         }


    //     }
    //     else
    //     {
    //         $mail = new PHPMailer(true);

    //         try
    //         {
    //             #$mail->AddAddress($e['to']);
    //             $mail->FromName		= $e['from_name'];//'MissionTree';
    //             $mail->From			= $e['from'];//'qateam786@gmail.com';
    //             $mail->CharSet		= "UTF-8"; // <-- Put right encoding here
    //             $mail->Subject		= $e['subject'];




    //             if ( is_array($e['to']))
    //             {
    //                 if ( count( $e['to'] ) > 0 )
    //                 {
    //                     foreach ($e['to'] as $to_email )
    //                     {
    //                         if ( $to_email != '')
    //                         {
    //                             $mail->AddAddress( trim( $to_email ) );
    //                         }
    //                     }
    //                 }
    //             }
    //             else
    //             {
    //                 $mail->AddAddress($e['to']);
    //             }




    //             if ( is_array($e['cc']))
    //             {
    //                 if ( count( $e['cc'] ) > 0 )
    //                 {
    //                     foreach ($e['cc'] as $cc_email )
    //                     {
    //                         if ( $cc_email != '')
    //                         {
    //                             $mail->AddCC( trim( $cc_email ) );
    //                         }
    //                     }
    //                 }
    //             }
    //             else
    //             {
    //                 if ($e['cc'] != "") {
    //                     $mail->AddCC($e['cc']);
    //                 }
	// 			}
				

    //             if ( is_array($e['bcc']))
    //             {
    //                 if ( count( $e['bcc'] ) > 0 )
    //                 {
    //                     foreach ($e['bcc'] as $bcc_email )
    //                     {
    //                         if ( $bcc_email != '')
    //                         {
    //                             $mail->AddBCC( trim( $bcc_email ) );
    //                         }
    //                     }
    //                 }
    //             }
    //             else
    //             {
    //                 $mail->AddBCC($e['bcc']);
    //             }



    //             /*if ( is_array($e['bcc']))
    //             {
    //                 if ( count( $e['bcc'] ) > 0 )
    //                 {
    //                     foreach ($e['bcc'] as $bcc_email )
    //                     {

    //                         $mail->AddBCC($bcc_email , '');
    //                     }
    //                 }
    //             }
    //             */

	// 			$localhost = array('127.0.0.1', "::1");

    //             if (!in_array($_SERVER['REMOTE_ADDR'], $localhost)) {
    //                 $mail->AddBCC("shabbir.bhojani@genetechsolutions.com", '');
    //             }


    //             $mail->IsHTML(true);
    //             $mail->MsgHTML($e['message']);
    //             $mail->Send();
    //             return true;
    //         }
    //         catch (phpmailerException $e)
    //         {
    //             $record_error_log				= array("from"			=> $e["from"],
    //                 "to"			=> $e["to"],
    //                 "subject"		=> $e["subject"],
    //                 "body"			=> $e["message"],
    //                 "errormessage"	=> $e->errorMessage());


    //             $this->queries->SaveDeleteTables($record_error_log, 's', "tb_mail_errlog", 'id');
    //         }
    //         catch (Exception $e)
    //         {
    //             $record_error_log				= array("from"			=> $e["from"],
    //                 "to"			=> $e["to"],
    //                 "subject"		=> $e["subject"],
    //                 "body"			=> $e["message"],
    //                 "errormessage"	=> $e->getMessage());


    //             $this->queries->SaveDeleteTables($record_error_log, 's', "tb_mail_errlog", 'id');


    //             return false;
    //         }
    //     }
    // }
	
	#array( "email_file", "email_subject", "email_heading", "email_to", "email_from", "email_from_name", "email_post", "email_attachment", "default_subject" )
	public function _send_email( $email_template )
	{
		if ( !isset( $email_template["email_heading"] ) )
		{
			$email_template["email_heading"]		= "";
		}
		
		if ( !isset( $email_template["email_to"] ) )
		{
			$email_template["email_to"]				= SessionHelper::_get_session("EMAIL_TO", "site_settings");
		}
		
		if ( !isset( $email_template["email_from"] ) )
		{
			$email_template["email_from"]			= SessionHelper::_get_session("EMAIL_FROM", "site_settings");
		}
		
		if ( !isset( $email_template["email_from_name"] ) )
		{
			$email_template["email_from_name"]		= SessionHelper::_get_session("EMAIL_FROM_NAME", "site_settings");
		}
		
		if ( !isset( $email_template["email_post"] ) )
		{
			$email_template["email_post"]			= $_POST;
		}
		
		if ( !isset( $email_template["email_attachment"] ) )
		{
			$email_template["email_attachment"]		= "";
		}
		
		if ( !isset( $email_template["email_cc"] ) )
		{
			$email_template["email_cc"]			= "";
		}
		
		if ( !isset( $email_template["email_bcc"] ) )
		{
			$email_template["email_bcc"]			= SessionHelper::_get_session("EMAIL_BCC", "site_settings");
		}
		
		
		if ( !isset( $email_template["default_subject"] ) )
		{
			$email_template["default_subject"]		= "";
		}
		else
		{
			$email_template["default_subject"]		= SessionHelper::_get_session("EMAIL_SUBJECT", "site_settings") . " - ";
		}

		
		$email_body									= $this->load->view("email/template/index.php", $email_template, TRUE);
		
		
		$email_array		= array( "from"					=> $email_template["email_from"],
									 "from_name"			=> $email_template["email_from_name"],//$this->session->userdata('site_title'),// $first_name . ' ' . $last_name,
									 "to"					=> $email_template["email_to"],
									 "cc"					=> $email_template["email_cc"],
									 "bcc"					=> $email_template["email_bcc"],
									 "subject"				=> $email_template["default_subject"] . $email_template["email_subject"],
									 "email_attachment"		=> $email_template["email_attachment"],
									 "message"				=> ( $email_body  ) );
		
		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Content-type: text/html; charset=iso-8859-1';
		
		// Additional headers
		$headers[] = 'To: '.$email_template["email_to"];
		$headers[] = 'From: '.$email_template["from_name"];
		$headers[] = 'Cc: '.$email_template["email_cc"];
		$headers[] = 'Bcc: '.$email_template["email_bcc"];
									 
	
		if ( isset( $email_template["debug"] ) )
		{
			print_r($email_array	);die;
		}

		return $this->email($email_array);
		// return mail($email_template["email_to"],$email_template["default_subject"] . $email_template["email_subject"] ,$email_array['message'] , implode("\r\n", $headers) );
		
	
	}
}

include("C_validationcallbacks.php");
include("C_admincms.php");
include("C_frontend.php");

include("C_mobilecontroller.php");
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */