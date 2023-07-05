<?php
#$change_to_http, $change_to_SSL, 
#$external_link - can convert any external link to http/https - what ever server port is.
function http_https( $change_to_http, $change_to_SSL, $external_link = FALSE, $is_SSL = FALSE )
{
	$CI 							=& get_instance();
	
	
	if ($_SERVER['SERVER_PORT'] == 443  )
	{
		$TMP_mode					= "1";
	}
	else
	{
		$TMP_mode					= "0";
	}


	
	if ( $is_SSL )
	{
		return $TMP_mode;	
	}
	else
	{

		#changed to HTTPS://
		if ( $change_to_SSL )
		{
			$CI->config->config['base_url'] = str_replace('http://', 'https://', $CI->config->config['base_url']);
			$CI->config->config['language_url'] = str_replace('http://', 'https://', $CI->config->config['language_url']);
			$CI->config->config['mobile_url'] = str_replace('http://', 'https://', $CI->config->config['mobile_url']);
		}
		else if ($change_to_http)
		{
			$CI->config->config['base_url'] = str_replace('https://', 'http://', $CI->config->config['base_url']);
			$CI->config->config['language_url'] = str_replace('https://', 'http://', $CI->config->config['language_url']);
			$CI->config->config['mobile_url'] = str_replace('https://', 'http://', $CI->config->config['mobile_url']);
		}
		
		
		if ( $external_link )
		{
			if ( $TMP_mode == "1" )
			{
				return str_replace('http://', 'https://', $external_link);
			}
			else
			{
				return str_replace('https://', 'http://', $external_link);
			}
			
		}
	}
}


function generate_toccbcc_emails( $emails, $TMP_arr = array() )
{
	$TMP_emails						= explode("|",  $emails );
	$TMP							= array();
	for ($i=0; $i < count($TMP_emails); $i++)
	{
		$TMP[ $TMP_arr[$i] ]		= explode(",", $TMP_emails[$i]);
	}
	
	return $TMP;
}


function socialicons_link( $social_icon = "" )
{
	switch ( $social_icon )
	{
		case "fb":
		return "http://facebook.com/ImamiaMedics";
		break;

		case "vm":
		return "http://vimeo.com/imihq";
		break;

		case "tw":
		return "https://twitter.com/imi_hq";
		break;
	}
}


function admin_role( $role_id = FALSE, $only_display_to = '', $only_hide_from = '' )
{
	#admin
	#chieflogin
	#peerreviewer
	
	
	$CI 								= get_instance();

	if ( !$role_id )
	{
		
		#$role_id						= $CI->functions->_admincms_logged_in_details( "role" );
	}
	
	
	/*switch( $role_id )
	{
		case "1" :
			$mode					= 'cl';
			break;
			
		case "2" :
			$mode					= 'prl';
			break;
			
		case "0" :
			$mode					= 'admin';
			break;
		}*/



		if ( $only_display_to != '')
		{
			$explode						= explode(",", $only_display_to);
			if ( in_array($CI->functions->_admincms_logged_in_details( "role_name" ), $explode) )
			{
				return TRUE;	
			}

			return FALSE;
		}
		else if ( $only_hide_from != ''  )
		{

			$explode						= explode(",", $only_hide_from);
			if ( in_array($CI->functions->_admincms_logged_in_details( "role_name" ), $explode) )
			{
				return FALSE;	
			}

			return TRUE;
		}



	}



	function left_widgets( $to_find = FALSE, $return_key = "name", $order_by = FALSE )
	{	
		$CI 				= get_instance();

		$TMP[]				= array("id"			=> "testimonials",
			"name"			=> "Testimonials");


		$TMP[]				= array("id"			=> "getinvolved",
			"name"			=> "Get Involved");
		



		$TMP				= widgets_sort( $TMP, $order_by );


		
		if ( $to_find )
		{
			foreach ($TMP as $key => $value )
			{
				if ( in_array($to_find, $value ) )
				{

					if ( $return_key == "all" )
					{
						return $value;
					}
					else
					{
						return $value[ $return_key ];
					}
				}
			}
		}



		return $TMP;
	}

	function right_widgets( $to_find = FALSE, $return_key = "name", $board_order_by = FALSE )
	{
		$TMP_board_order_by							= FALSE;
		if ( $board_order_by )
		{
			foreach ( $board_order_by as $tkey => $tvalue )
			{
				$TMP_board_order_by[]					= $tkey;
			}


			$TMP_board_order_by							= "ORDER BY FIELD (name, '" . implode("', '", $TMP_board_order_by) . "')";

		}





		$CI 										=& get_instance();

		$TMP										= array();

		$tmp_sql									= $CI->queries->fetch_records("boards", " AND status = '1' $TMP_board_order_by");

		foreach ( $tmp_sql -> result_array() as $row )
		{
			$row['boardid']			= $row['id'];
			$TMP[] 					= array("id"			=> $row["name"],
				"name"			=> $row["name"],
				"widgetpage"	=> "frontend/template/widgets/boards",
				"data"			=> $row);
		}

		



		if ( $to_find )
		{
			foreach ($TMP as $key => $value )
			{
				if ( in_array($to_find, $value ) )
				{

					if ( $return_key == "all" )
					{
						return $value;
					}
					else
					{
						return $value[ $return_key ];
					}
				}
			}
		}

		return $TMP;
	}



	function center_widgets( $to_find = FALSE, $return_key = "name", $order_by = FALSE )
	{	
		$CI 				= get_instance();

		$TMP[]				= array("id"			=> "chapterlocations",
			"name"			=> "Chapter Locations");



		$TMP				= widgets_sort( $TMP, $order_by );


		
		if ( $to_find )
		{
			foreach ($TMP as $key => $value )
			{
				if ( in_array($to_find, $value ) )
				{

					if ( $return_key == "all" )
					{
						return $value;
					}
					else
					{
						return $value[ $return_key ];
					}
				}
			}
		}



		return $TMP;
	}



	function widgets_sort( $TMP, $order_by = FALSE )
	{
		$CI 				= get_instance();


		$TMP_array			= array();
		if ( $order_by )
		{
			foreach ( $order_by as $ko => $kv ) 
			{
				if ( $TMP_name = $CI->functions->search_array($TMP, "id", $ko, "name") )
				{
					$TMP_array[]					= array("id"		=> $ko,
						"name"		=> $TMP_name);
				}
			}

			foreach ( $TMP as $ko => $kv )
			{
				if ( !$CI->functions->search_array($TMP_array, "id", $kv['id'], "name") )
				{
					$TMP_array[]					= array("id"		=> $kv['id'],
						"name"		=> $kv['name']);
				}
			}

			$TMP			= $TMP_array;		
		}	

		return $TMP;
	}


	function get_languagecode_for_resort()
	{
		switch ( SessionHelper::_get_session('SITE_LANGUAGE_ID', 'site_settings')  )
		{
			case "2":
			return "_chs";
			break;
			
			case "3":
			return "_cht";
			break;
			
			default:
			return "";
			break;
		}
	}


	function _file_get_contents( $url )
	{
		if ( is_localhost() )
		{
			$aContext = array(
				'http' => array(
					'proxy' => 'tcp://192.168.14.114:3128',
					'request_fulluri' => true,
					),
				);
			$cxContext = stream_context_create($aContext);


			$_value				= @file_get_contents( $url,  false, $cxContext);		
		}
		else
		{
			$_value				= @file_get_contents( $url );		
		}

		return $_value;
	}


	function assets_include_url( $url )
	{
		return base_url( $url ) . '?version=' . strtotime("now");
	}

	function lang_line( $language_key = "", $args = array() )
	{
		$CI =& get_instance();

		return vsprintf($CI->lang->line($language_key),$args);
	}


	function loadlanguages()
	{
		$CI 							=& get_instance();

		$tmp_languages					= $CI->queries->fetch_records("languages", "", " *, languageCode as Code, LanguageDescription as description ");


		if ( $tmp_languages -> num_rows() <= 0 )
		{
			$tmp_languages				= $CI->db->query('SELECT "1" as "id", "en" as "Code", "English" as "description"');	
		}

		return $tmp_languages -> result_array();

	}


	function form_close()
	{
		return "</form>";	
	}


	function set_languageid_array_index( $result_box, $index_name = "languageid" )
	{
		$tmp_data						= array();

		if ( $result_box -> num_rows() > 0 )
		{
			foreach ( $result_box -> result_array() as $row )
			{
				$tmp_data[ $row[ $index_name ] ]		= $row;
			}
		}

		return $tmp_data;
	}


	function set_multiselect( $post_values = "", $db_values = array() )
	{
		$CI 							=& get_instance();
		$tmp_array						= array();


		if ( is_array( $CI->input->post( $post_values ) ) and count( $CI->input->post( $post_values ) ) > 0 )
		{
			foreach ( $CI->input->post( $post_values )  as $key => $value)
			{
				$tmp_array[ $key ]		= $value;
			}
		}
		else if ( is_array( $db_values ) and count( $db_values ) > 0 )
		{
			$tmp_array					= $db_values;
		}



		return $tmp_array;
	}


	function image_link( $input_name = "", $post_image, $runtime_popup = FALSE, $is_multiple = FALSE  )
	{
		$remove_image				= "";
		$image_link					= "";

		if ( $is_multiple )
		{		
			$images_array			=  set_multiselect($input_name, $post_image)  ;


			$___input				= "";
			$___text				= "";


			if ( is_array( $images_array) )
			{
				$___text						= " <ul class='ilinks_sortable'>";
				foreach ($images_array as $key => $value)
				{
					$random						= "_" . random_string('alnum', 16);

					$image_link					= '<a href="'. base_url( $value ) .'" class="modelImage">'. $value .'</a>';
					$remove_image				= '&nbsp;&nbsp;<a class="label label-danger"  href="javascript:;" onclick="remImage(\''. $input_name . $random .'\');">(removeimage)</a> ';


					$___text					.= '<li> <small class="'. $input_name . $random .'"> ' . $image_link . $remove_image . ' </small>';
					$___text					.= '<input type="hidden" value="'. $value .'" id="'. $input_name . $random . '" name="'. $input_name .'[]" /> </li> ';
				}
				$___text						.= '</ul>';

			}


			return $___text . $___input;
		}
		else
		{
			if ( set_value($input_name, $post_image) != "" )
			{
			#label label-danger

				$image_link					= '<a href="'. base_url( set_value($input_name, $post_image) ) .'" class="modelImage">'. set_value($input_name, $post_image) .'</a>';


				$remove_image				= '&nbsp;&nbsp;<a class="label label-danger"  href="javascript:;" onclick="remImage(\''. $input_name .'\');">(Remove Image)</a> ';
			}


			if ( !$runtime_popup )
			{
				$remove_image				= "";
			}

			return '<small>' . $image_link . $remove_image . ' </small>';
		}
	}


	function required_field( $fontsize = FALSE, $color = FALSE )
	{
		$className			 = '';
		if ( $fontsize )
		{
			$className		.= $fontsize;
		}
		if ( $color )
		{
			$className		.= $color;
		}

		$className			= '';

		return "<span class='required_field ". $className ."'>*</span>";	
	}
	

	function page_error( $data )
	{

		$CI =& get_instance();
		$data['_pagetitle']											= lang_line("text_404error");


		$data['content']											= "<div align='center' style='margin:50px;'><img src='" . base_url( 'assets/frontend/images/404.png' ) . "' /></div>";
		$data['_pageview']											= "global/_blank_page.php";		
		$CI->load->view( FRONTEND_TEMPLATE_LEFT_WIDGETS_VIEW, $data );	

	}


	function captchacode( $arr  = array() )
	{
		$CI =& get_instance();



		$CI->load->library('antispam');

		$configs = array('img_path' 		=> './assets/files/captcha/',
			'img_url' 			=> base_url("assets/files/captcha") . "/",
			'img_height' 		=> '50' );

		$configs		= merge_multi_arrays( array($configs, $arr) );


		$captcha = $CI->antispam->get_antispam_image($configs);

		$CI->session->set_userdata('captchaWord', $captcha['word']);

		return $captcha['image'];	
	}


	function get_column_result_array( $TMP_array, $TMP_column = FALSE )
	{
		$TMP_id														= array();
		if ( count($TMP_array) > 0 )
		{
			for ( $i = 0; $i < count($TMP_array); $i++ )
			{
				$TMP_id[]											= $TMP_array[$i][$TMP_column ];	
			}	
		}

		return $TMP_id;
	}


	function merge_multi_arrays( $array = array(), $array_name = "" )
	{
		$tmp				= array();

		for ($x=0; $x < count($array); $x++)
		{
			$settings_master					= $array[$x];



			foreach ( $settings_master as $k => $v )
			{
				if ( $array_name == "")
				{
					$tmp[$k]							= $v;
				}
				else
				{
					$tmp[ $array_name ][$k]				= $v;

				}
			}

		}

		return $tmp;
	}


	function is_localhost()
	{
		$local_ips 		= array('127.0.0.1', 'localhost', 'genetech002', '192.168.14.114', '192.168.11.1', '192.168.14.128', '::1');

		if(in_array($_SERVER['REMOTE_ADDR'], $local_ips))
		{
			return TRUE;
		}

		return FALSE;
	}




	function format_date( $return_format = "Y-m-d", $input = "", $given_format = FALSE, $seperator = "/" )
	{
		if ( $given_format )
		{
			$EXPLODE_input					= explode(" ", $input);
			$TMP_date						= explode( $seperator, $EXPLODE_input[0] );

			$TMP_return_text				= FALSE;

			switch( $given_format )
			{

				case "d-m-Y H:i:s":
				unset( $EXPLODE_input[0] );
				
				$TMP_return_text				= $TMP_date[2] . "-" . $TMP_date[1] . "-" . $TMP_date[0] . " " . implode(" ", $EXPLODE_input);
				break;
				
				
				
				case "m-d-Y H:i:s":
				unset( $EXPLODE_input[0] );
				
				$TMP_return_text				= $TMP_date[2] . "-" . $TMP_date[0] . "-" . $TMP_date[1] . " " . implode(" ", $EXPLODE_input);
				break;
				
				
				
				case "Y-m-d H:i:s":
				unset( $EXPLODE_input[0] );
				
				$TMP_return_text				= $TMP_date[0] . "-" . $TMP_date[1] . "-" . $TMP_date[2] . " " . implode(" ", $EXPLODE_input);
				break;
				
				
				

				case "d-m-Y":
				$TMP_return_text				= $TMP_return_text[2] . "-" . $TMP_return_text[1] . "-" . $TMP_return_text[0];
				break;
				
				case "m-d-Y":
				$TMP_return_text				= $TMP_return_text[2] . "-" . $TMP_return_text[0] . "-" . $TMP_return_text[1];
				break;
				
				case "Y-m-d":
				$TMP_return_text				= $TMP_return_text[0] . "-" . $TMP_return_text[1] . "-" . $TMP_return_text[2];
				break;
				
				default:
				$TMP_return_text				= FALSE;
				break;
				
			}


			return date( $return_format, strtotime( $TMP_return_text ));


		#return $TMP_return_text;
		}
		else
		{
			return date( $return_format, strtotime( $input ));
		}
	}


	function verify_time_format($value) {
		$pattern1 = '/^(0?\d|1\d|2[0-3]):[0-5]\d:[0-5]\d$/';
		$pattern2 = '/^(0?\d|1[0-2]):[0-5]\d\s(am|pm)$/i';
		return preg_match($pattern1, $value) || preg_match($pattern2, $value);
	}


	function format_input_else_null( $input = "" )
	{
		return (( $input ) && $input != "") ? $input : NULL;
	}


	function format_date_else_null( $format = "", $input = "" )
	{
		return (( $input ) && $input != "") ? format_date( "Y-m-d", $input ) : NULL;
	}


	function format_date_else_zero( $date, $format = "" )
	{
		if ( $format == "" )
		{
			$format		= "d-m-Y";
		}


		if ( !strtotime ( $date ) )
		{

			switch ($format)
			{
				case "Y-m-d":
				$date		= "0000-00-00";
				break;
				
				default:
				$date		= "00-00-0000";
				break;
				
			}

			return $date;
		}


		return date( $format, strtotime($date) );
	}


	function format_bool( $input = "", $match_value = FALSE, $debug = FALSE )
	{
		if ( $match_value != '' )
		{


			$return_value			= FALSE;

			if (  $input ==  $match_value )
			{
				$return_value	= TRUE;
			}

			return $return_value;
		}
		else
		{
			$return_value			= FALSE;
			if ( $input )
			{
				if ( $input == "1")
				{
					$return_value	= TRUE;
				}
			}

			return $return_value;
		#return ( $input ) ? 1 : 0;
		}
	}


/*
*
*	format_price
*
*	@param float price
*	@param array includes("decimal_places", "decimal_seperator", "thousand_seperator", "prefix")
*	
* 	@return get record from session
*/
function format_price( $price, $multi_param = "", $is_left = TRUE, $is_HTML = FALSE)
{
	
	if ( !isset( $multi_param["decimal_places"] ) )
	{
		$multi_param["decimal_places"]				= "2";
	}
	if ( !isset( $multi_param["decimal_seperator"] ) )
	{
		$multi_param["decimal_seperator"]			= ".";
	}
	if ( !isset( $multi_param["thousand_seperator"] ) )
	{
		$multi_param["thousand_seperator"]			= ",";
	}
	if ( !isset( $multi_param["prefix"] ) )
	{
		$multi_param["prefix"]						= "USD";
	}
	
	if ( !isset( $multi_param["round"] ) )
	{
		$multi_param["round"]						= FALSE;
	}
	
	
	if ( $multi_param["round"] )
	{
		$price		= round($price);
	}
	
	
	
	if ( $is_HTML )
	{
		$price			= $price;
	}
	else
	{
		$price			= number_format($price, $multi_param["decimal_places"], $multi_param["decimal_seperator"], $multi_param["thousand_seperator"]);
	}
	
	
	
	if ( $is_left )
	{		
		return $multi_param["prefix"] . "" . $price;	
	}
	
	return $price	. " " . $multi_param["prefix"];
}


function filter_post( $post, $is_date = FALSE, $is_db = TRUE )
{
	
	if ( $is_date )
	{
		
		if ( !strtotime ($post) )
		{
			$post			= NULL;
		}
		
		
		if (!$post)
		{
			return $post;
		}
		
		
		if ($is_db)
		{
			$date			=  (isset($post) && $post != "") ? date("Y-m-d",strtotime( $post )) : NULL;	
		}
		else
		{

			$date			=  (isset($post) && $post != "") ? date("d-m-Y",strtotime( $post )) : NULL;	
		}
		

		return $date;
	}
	return (isset( $post ) && $post != "") ? $post : NULL;
}


function substr_word( $string = '', $length = 0 )
{
	$s = substr($string, 0, $length);
	return $result = substr($s, 0, strrpos($s, ' '));	
}





####################
# CUSTOM FUNCTIONS #
####################

function output_addons( $TMP_addons )
{
	$output						= '';
	foreach ($TMP_addons as $k => $v )
	{
		$output					.= '<div class="input-group">
		<input class=" form-control"  readonly="readonly" value="'. $v['plugin'] .'"  /> 
		<small>'. $v['description'] .'</small>
	</div><br />';
}

return $output;
}

function _return_cms_textarea(  $is_content = TRUE )
{
	$CI =& get_instance();
	
	if ( $is_content )
	{
		$roomdata				= array("name"			=> "content",
			"id"			=> "content",
			"cols"			=> 50,
			"rows"			=> 10,
			"class"			=> "ckeditor1",
			"value"			=> set_value("content", $CI->input->post('content') )
			);	

		
		

		
		$TMP_addons[]				= array("plugin"		=> '[ACTIVITIES_THIS_MENU]',
			"description"	=> 'Get Activities of this menu');
		
		$TMP_addons[]				= array("plugin"		=> '[EVENTS_THIS_MENU]',
			"description"	=> 'Get Events of this menu');
		
		$TMP_addons[]				= array("plugin"		=> '[EVENTS_ACTIVITIES_THIS_MENU]',
			"description"	=> 'Get Events and Activities of this menu');
		
		$TMP_addons[]				= array("plugin"		=> '[EVENTS_ACTIVITIES_MENUS_LIST_ALL]',
			"description"	=> 'Get Menu Lists for all Events & Activities (  <code> ul li structure </code> )');
		
		$TMP_addons[]				= array("plugin"		=> '[SIMPLE_ACTIVITIES_THIS_MENU]',
			"description"	=> 'Get Simple Activities of this menu');
		
		$TMP_addons[]				= array("plugin"		=> '[SIMPLE_EVENTS_THIS_MENU]',
			"description"	=> 'Get Simple Events of this menu');
		
		$TMP_addons[]				= array("plugin"		=> '[SIMPLE_EVENTS_ACTIVITIES_THIS_MENU]',
			"description"	=> 'Get Simple Events and Activities of this menu');
		
		$TMP_addons[]				= array("plugin"		=> '[MENTORSHIP_FORM]',
			"description"	=> 'Mentorship Full Form');
		
		$TMP_addons[]				= array("plugin"		=> '[DONATE_FORM]',
			"description"	=> 'Donation Form');
		$TMP_addons[]				= array("plugin"		=> '[NEW_DONATE_FORM]',
			"description"	=> 'New Donation Form');
		
		$TMP_addons[]				= array("plugin"		=> '[EMERGENCY_ROSTER_FORM]',
			"description"	=> 'Emergency Roster Form');
		
		$TMP_addons[]				= array("plugin"		=> '[VOLUNTEER_FORM]',
			"description"	=> 'Volunteer Form');
		
		$TMP_addons[]				= array("plugin"		=> '[INTERNSHIP_FORM]',
			"description"	=> 'Internship Form');

		$TMP_addons[]				= array("plugin"		=> '[PRESS_RELEASES]',
			"description"	=> 'Press Releases');
		$TMP_addons[]				= array("plugin"		=> '[IMI_NEWS]',
			"description"	=> 'IMI News');

			$TMP_addons[]				= array("plugin"		=> '[DISCUSSION_BOARD]',
			"description"	=> 'Discussion 	Board');
			$TMP_addons[]				= array("plugin"		=> '[TOPIC_DETAIL]',
			"description"	=> 'Topic Detail');
				$TMP_addons[]				= array("plugin"		=> '[COMMENTS]',
			"description"	=> 'Comments');
		$output					 = output_addons( $TMP_addons );
		$output					.= form_textarea($roomdata);
	}
	else
	{
		$roomdata				= array("name"			=> "content",
			"size"			=> 50,
			"class"			=> "form-control",
			"value"			=> set_value("content", $CI->input->post('content') )
			);	
		
		$output					= form_input($roomdata);	
	}
	
	return $output;
}

function _return_cms_textarea_with_lang(  $is_content = TRUE, $languages )
{
	$CI =& get_instance();
	$content = $CI->input->post('content');

	if ( $is_content )
	{

		$TMP_addons[]				= array("plugin"		=> '[ACTIVITIES_THIS_MENU]',
			"description"	=> 'Get Activities of this menu');
		
		$TMP_addons[]				= array("plugin"		=> '[EVENTS_THIS_MENU]',
			"description"	=> 'Get Events of this menu');
		
		$TMP_addons[]				= array("plugin"		=> '[EVENTS_ACTIVITIES_THIS_MENU]',
			"description"	=> 'Get Events and Activities of this menu');
		
		$TMP_addons[]				= array("plugin"		=> '[EVENTS_ACTIVITIES_MENUS_LIST_ALL]',
			"description"	=> 'Get Menu Lists for all Events & Activities (  <code> ul li structure </code> )');
		
		$TMP_addons[]				= array("plugin"		=> '[SIMPLE_ACTIVITIES_THIS_MENU]',
			"description"	=> 'Get Simple Activities of this menu');
		
		$TMP_addons[]				= array("plugin"		=> '[SIMPLE_EVENTS_THIS_MENU]',
			"description"	=> 'Get Simple Events of this menu');
		
		$TMP_addons[]				= array("plugin"		=> '[SIMPLE_EVENTS_ACTIVITIES_THIS_MENU]',
			"description"	=> 'Get Simple Events and Activities of this menu');
		
		$TMP_addons[]				= array("plugin"		=> '[MENTORSHIP_FORM]',
			"description"	=> 'Mentorship Full Form');
		
		$TMP_addons[]				= array("plugin"		=> '[DONATE_FORM]',
			"description"	=> 'Donation Form');
		$TMP_addons[]				= array("plugin"		=> '[NEW_DONATE_FORM]',
			"description"	=> 'New Donation Form');
		
		$TMP_addons[]				= array("plugin"		=> '[EMERGENCY_ROSTER_FORM]',
			"description"	=> 'Emergency Roster Form');
		
		$TMP_addons[]				= array("plugin"		=> '[VOLUNTEER_FORM]',
			"description"	=> 'Volunteer Form');
		
		$TMP_addons[]				= array("plugin"		=> '[INTERNSHIP_FORM]',
			"description"	=> 'Internship Form');

		$TMP_addons[]				= array("plugin"		=> '[PRESS_RELEASES]',
			"description"	=> 'Press Releases');
		$TMP_addons[]				= array("plugin"		=> '[IMI_NEWS]',
			"description"	=> 'IMI News');

			$TMP_addons[]				= array("plugin"		=> '[DISCUSSION_BOARD]',
			"description"	=> 'Discussion 	Board');
			$TMP_addons[]				= array("plugin"		=> '[TOPIC_DETAIL]',
			"description"	=> 'Topic Detail');
				$TMP_addons[]				= array("plugin"		=> '[COMMENTS]',
			"description"	=> 'Comments');
		$output					 = output_addons( $TMP_addons );


		

		$output .= '<div class="nav-tabs-custom">';
		
			$output .= '<ul class="nav nav-tabs">';
			foreach ($languages as $lang_key => $lang): 
				$output .= "<li class='". ($lang_key < 1?'active':'')."'><a href='#content_lang_".$lang['code']."' data-toggle='tab'>".$lang['name']."</a></li>";
			endforeach; 
			$output .= '</ul>';

			$output .= '<div class="tab-content">';
            foreach ($languages as $lang_key => $lang) {
                $output .= '<div class="tab-pane '.($lang_key < 1?'active':'').'" id="content_lang_'.$lang['code'].'">';
                $output .= '<div class="input-group">';
                                
                $specdata		= array("name"			=> "content[{$lang['code']}]",
                                        "id"			=> "content[{$lang['code']}]",
                                        "rows"			=> 10,
                                        "cols"			=> 50,
                                        "class"			=> "ckeditor1",
                                        "value"			=> ($content?$content[$lang['id']]['content']:'') );

                $output	.= form_textarea($specdata);
                                
                $output .= '</div>';
                $output .= '</div>';
            }
			$output .= '</div>';
			
		$output .= '</div>';
		
	}
	else
	{
		$output = '<div class="nav-tabs-custom">';
		
			$output .= '<ul class="nav nav-tabs">';
			foreach ($languages as $lang_key => $lang): 
				$output .= "<li class='". ($lang_key < 1?'active':'')."'><a href='#content_lang_".$lang['code']."' data-toggle='tab'>".$lang['name']."</a></li>";
			endforeach; 
			$output .= '</ul>';

			$output .= '<div class="tab-content">';
			foreach ($languages as $lang_key => $lang) {
				$output .= '<div class="tab-pane '.($lang_key < 1?'active':'').'" id="content_lang_'.$lang['code'].'">';
				$output .= '<div class="input-group">';
								
				$specdata		= array("name"			=> "content[{$lang['code']}]",
										"size"			=> 50,
										"class"			=> "form-control",
										"value"			=> ($content?$content[$lang['id']]['content']:'') );

				$output	.= form_input($specdata);
								
				$output .= '</div>';
				$output .= '</div>';
			}
			$output .= '</div>';
			
		$output .= '</div>';
			
	}
	
	return $output;
}



function site_sections( $to_find = FALSE, $is_key = TRUE )
{	
	$TMP[]				= array("id"			=> "what_we_do",
		"name"			=> "What We Do");
	
	$TMP[]				= array("id"			=> "events",
		"name"			=> "Events");
	
	$TMP[]				= array("id"			=> "activities",
		"name"			=> "Activities");
	
	
	if ( $to_find )
	{
		foreach ($TMP as $key => $value )
		{
			if ( in_array($to_find, $value ) )
			{
				return $value['name'];
			}
		}
	}
	
	return $TMP;
}


// get user name by user id//
function getUserNameByID($user_id){

	$CI 			=& get_instance();
	
	$data 			=  $CI->queries->fetch_records("getUserdata",' AND id = "'.$user_id.'"',"username");
	
	$result 		= $data->row();
	
	return $result->username;

}

// get user name by user id//
function getChapterId($id, $chapter_id){

	$CI 			=& get_instance();
	
	$tmp_query				= $CI->db->query('SELECT id FROM `tb_belongs_country` WHERE country_id = '.$id. ' AND chapter_id = '.$chapter_id );	
	return !empty($tmp_query -> result_array()) ? true: false;

}

// forum geting child comments//

function getChildComments($parentid,&$html,$number){

	$CI 						=& get_instance();
	$number=$number+10;

	$childComments = $CI->queries->fetch_records("getComments",' AND parentid = "'.$parentid.'"');

	if ( $childComments -> num_rows() > 0 ) { 

		$html .= ' <ul class="childcomment">';

		foreach ( $childComments -> result() as $comment ) {
			    $profile_detailss                                   = $CI->imiconf_queries->fetch_records_imiconf("conference_registration_screen_one", " AND conferenceregistrationid IN (SELECT id FROM tb_conference_registration_master WHERE userid = '".  $comment->user_id ."' )  " )->result()[0];  

                 //echo $profile_detailss->photo_image; die;
                   if($profile_detailss->photo_image!="") $commentpic=$profile_detailss->photo_image; else $commentpic=site_url()."assets/files/profileimages/noimage.png";

         $user = $CI->imiconf_queries->fetch_records_imiconf("users", " AND id='".$comment->user_id."' ORDER BY id desc ")->result()[0];
          $isChildComments=$CI->queries->fetch_records("getComments","","(SELECT COUNT(*) from tb_comments where parentid={$comment->id}) as childcomment")->result()[0];
     


			$html .= '<li style="margin-left:'.$number.'px;" data-id="'.$comment->id.'">';

			$html .= '<div class="commentInnerSec_left">';

				$html .= '<div class="commentbyImg"><img src="'.$commentpic.'"></div>';

			$html .= '</div>';

			$html .= '<div class="commentInnerSec_right">';

	        	$html .= '<div class="commentby">'.$user->name.' '.$user->last_name.'</div>';

				$html .= '<div class="comment">'.$comment->comment.'</div>';

				$html .= '<div class="comment-meta">';
	        			
	        		$user = $CI->imiconf_queries->fetch_records_imiconf("users", " AND id='".$comment->user_id."' ORDER BY id desc ")->result()[0];

	        		$html .= '<div class="replyLinks" data-id="'.$comment->id.'">';
	          	
	          		$html .= '<input type="hidden" name="display_replyuser" id="display_replyuser'.$comment->id.'" value="'.$user->name.' '.$user->last_name.'" />';

	          		$html .= '<a href="javascript:;" id="button" onclick="setIds(this)" name="reply">Reply</a>';

	          	    if($isChildComments->childcomment>0){
	          		$html .= '<span class="seperator"> | </span>';
	          		$html .= '<a href="javascript:;" class="viewReplies">View Replies</a></div>';
	      			}

	      		$html .= '</div>';

	      		getChildComments($comment->id,$html,$number);

	      	$html .= '</div>';

		$html .='</li>';
	} 

	$html .= '</ul>';
}

return $html;
}
function convert_in_hours($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now ';
}

/**
 * Copied from https://stackoverflow.com/a/15102185/7160631
 */
function _group_by($array, $key)
{
    $return = array();
    foreach ($array as $val) {
        $return[$val[$key]][] = $val;
    }
    return $return;
}

function _admin_menu_child($parent_id){
	$CI = &get_instance();
	$admin_role_id = $CI->functions->_admincms_logged_in_details("role_id");
	return $CI->queries->fetch_records("admin_operations", " AND operationid IN (SELECT operationid FROM tb_admin_roles_permissions Where admin_role_id = $admin_role_id) AND is_menu > 0 AND parent = ". $parent_id);
}

function is_has_child_admin_menu($menu_id)
{
	$CI = &get_instance();
	$q = $CI->queries->fetch_records("admin_operations", " AND parent = " . $menu_id);

	if( $q->num_rows() > 0 ){
		return true;
	}else{
		return false;
	}
}

function _admin_permissions_list($directories,&$data, $recursionDepth = 1, $maxDepth = false)
{
	$CI = &get_instance();
	foreach ($directories as $directory) {
		$directory->level = $recursionDepth;
		$data[] = $directory;

		$childrens = $CI->queries->fetch_records("admin_operations"," AND parent = '".$directory->id."'");
		
		if( $childrens->num_rows() > 0 ){
			$d = $childrens->result();
			_admin_permissions_list($d,$data, $recursionDepth + 1, $maxDepth);
		}

		
	}

	return $data;
}

function _parent_menus_ids_by_child_id($child_id,&$ids){

	$CI = &get_instance();

	$parent = $CI->queries->fetch_records("admin_operations", " AND id = '" . $child_id . "'","parent");
	if ( $parent->num_rows() > 0 ){
		$row = $parent->row();

		if ( $row->parent != 0 ){
			$ids[] = $row->parent;
			_parent_menus_ids_by_child_id($row->parent,$ids);
		}
	}

	return $ids;
}

function searchArrayKeyVal($sKey, $id, $array) {
   $keys = array();
    foreach ($array as $key => $val) {
       if (strpos($val[$sKey],$id) != false) {
           $keys[] = $key;
       }
   }
   return $keys;
}

function albhabeticRange($limit = 26)
{
	$alpha_limit = 26;
	if ( $limit > 702 ){
        return false;
    }
    $return = array();
    $parts = ceil($limit/$alpha_limit);
    
    for( $a=0;$a<$parts;$a++ ){
        $i = ($a*$alpha_limit)+1;
        
        $return = array_merge($return,alphaLoop($i,$limit,$a));
	}
    
    return $return;
}

function alphaLoop($i,$limit,$a)
{
    $range = range('A','Z');
    $return = array();
    $b = 0;
    foreach( $range as $alpha){
        for($z=0;$z<$a;$z++){
            $alpha = $range[$a-1].$range[$b];
        }
        $return[$i] = $alpha;
        if ( $i == $limit ){
            break;
        }
        $i++;
        $b++;
    }
    return $return;
}


function calculateAge($date) { // birthday is a date

		$current_year = date('Y',$date);
		$birth_year = date('Y',$date);
		$current_month = date('m',$date);
		$birth_month = date('m',$date);
		$current_day = date('d',$date);
		$birth_day = date('d',$date);
		
		$year = $current_year - $birth_year;
		$month = $current_month - $birth_month;

		if ($month < 0 || ($month === 0 && $current_day < $birth_day)) {
			$year--;
		}

		return $year;
	}


	function get_country_by_id($country_id){
		$CI 										=& get_instance();

		$query									= $CI->imiconf_queries->fetch_records_imiconf("countries"," and id = $country_id");
		
		if( $query->num_rows() > 0 ){
			return $query->result()[0];
		}
		return false;
	}

	function is_countryCheck( $return_slug = FALSE, $belongsto_id = FALSE, $slugCheck = FALSE ){
		//for e.g. 192.168.14.8:81 = imi
		//for e.g. localhost:81 = medics
		
		$canada = array(VIRTUALHOST_IMI_CANADA_LOCALHOST,VIRTUALHOST_IMI_CANADA);
		$international_medics = array(VIRTUALHOST_IMI_MEDICS_INTERNATIONAL_LOCALHOST,VIRTUALHOST_IMI_MEDICS_INTERNATIONAL);
	
	
		$_return_value			= FALSE;
		$international_id = 2;
		$_slug					= VIRTUALHOST_SLUG_IMI_INTERNATIONAL;
	
		switch ( $_SERVER['HTTP_HOST'] )
		{
			case in_array(  $_SERVER['HTTP_HOST'], $canada):
				$_return_value		= TRUE;
				$international_id = 3;
				$_slug				= VIRTUALHOST_SLUG_IMI_CANADA;
				$slug = $_slug;
				break;
	
				case in_array(  $_SERVER['HTTP_HOST'], $international_medics):
				$_return_value		= TRUE;
				$international_id = 4;
				$_slug				= VIRTUALHOST_SLUG_IMI_INTERNATIONAL_MEDICS;
				$slug = $_slug;
				break;
	
				
			default:
				break;
		}
		
		if ( $return_slug )
		{
			return $_slug;
		}else if($belongsto_id){
			return $international_id;
		}else if($slugCheck){
			return $slug;
		}
		else
		{
			return $_return_value;	
		}
		
	}
function is_imicanada( $return_slug = FALSE ){
	//for e.g. 192.168.14.8:81 = imi
	//for e.g. localhost:81 = medics
	
	$_return_value			= FALSE;
	$_slug					= VIRTUALHOST_SLUG_IMI_INTERNATIONAL;

	$_array_LOCALHOST		= unserialize(VIRTUALHOST_IMI_CANADA_LOCALHOST);
	//$_array_IP				= unserialize(VIRTUALHOST_CONF_IP);
	$_array_LIVE			= unserialize(VIRTUALHOST_IMI_CANADA);

	switch ( $_SERVER['HTTP_HOST'] )
	{
		case in_array(  $_SERVER['HTTP_HOST'], $_array_LIVE):
		case in_array(  $_SERVER['HTTP_HOST'], $_array_LOCALHOST):
			$_return_value		= TRUE;
			$_slug				= VIRTUALHOST_SLUG_IMI_CANADA;
			break;

			
		default:
			break;
	}
	
	if ( $return_slug )
	{
		return $_slug;
	}
	else
	{
		return $_return_value;
	}
	
}
	function getSiteId(){
		if ( is_countryCheck(FALSE,FALSE,TRUE) == 'canada' ){
			return "AND belongsto IN (1, 3)";
		} else if (is_countryCheck(FALSE,FALSE,TRUE) == 'medics') {
			return "AND belongsto IN (4)";
		}
		else {
			return "AND belongsto IN (1, 2)";
		}
	}

function replace_data_for_lang(&$data, $loop_object = array(), $db_data = array(), $fields = array(), $language )
{
	if(!$language){
		$language = DEFAULT_LANG_CODE;
	}
	foreach ($fields as $field) {
		if(is_object($data)){
			$data->{$field} = '';
		}
		if(is_array($data)){
			$data[$field] = '';
		}
	}

	if (count($db_data) > 0 )
	{
		foreach ($loop_object as $main)
		{
			
			$language_id				= $main["id"];
			
			for ($x=0;  $x < count($fields); $x++)
			{
				#second - if value found it will overwrite above array.
				foreach ( $db_data as $loop )
				{
					if ( $loop["content_languages_id"] == $language_id && strtolower($language) == strtolower($main["code"]) )
					{
						if (is_object($data)) {
							$data->{$fields[$x]}			= $loop[ $fields[$x] ];	
						}
						if(is_array($data)){
							$data[ $fields[$x] ]			= $loop[ $fields[$x] ];	
						}
					}
					
				}
			}
		}			
		
	}
}

function getAdminEmails(){
	$email_admin = ( SessionHelper::_get_session("EMAIL_TO", "site_settings") );
	
	// use this if imicanada.org
	if( is_countryCheck(FALSE,FALSE,TRUE) == "canada" ){
		$email_admin = "imamiacanada@gmail.com";
	}

	return $email_admin;
}

function getCurrentLang($languages = [])
{
	$lang = array_filter($languages, function($lang){
		$LANG_CODE = SessionHelper::_get_session('LANG_CODE');
		return strtolower($lang['code']) === strtolower($LANG_CODE?$LANG_CODE:DEFAULT_LANG_CODE);
	});
	return array_values($lang)[0];
}

function total_conferenceregistrations( $userid, $conferenceid, $is_paid = 0 )
{
	$CI 								= get_instance();


	if ( $is_paid )
	{
		$t = $CI->queries->fetch_records(	"short_conference_registration_master" , 
											"	AND conferenceid = '". $conferenceid ."' AND userid = '". $userid ."' 
												AND 
												( 
													is_paid = '1' 
													
													|| 
													
													( 
														is_paid = 0
														
														AND 
														
														( payment_allow = 0 ||  payment_allow = 1 )
														
														AND 
														
														payment_type = 'cash' 
													) 
												)
										 	"
										 );

		return $t->num_rows();
	}
	else
	{
		$t = $CI->queries->fetch_records(	"short_conference_registration_master" , 
											" AND conferenceid = '". $conferenceid ."' AND userid = '". $userid ."' 
											
											  AND 
											  (
											   		is_paid = '0' 
													
													AND 
													
													( payment_allow = 0 || payment_allow = 1 )
													
													AND 
													
													payment_type != 'cash'
											  )
											  
											"
										 );
		
		return $t->num_rows();
	}

}
function is_short_conference_registered_for_local( $from_database = TRUE, $region_id = FALSE )
{
	$CI =& get_instance();
	
	$data['conference']						= $CI->queries->fetch_records('short_conference', " AND status = '1' ");
	if ( $data['conference'] -> num_rows() <= 0 )
	{
		return false;
	}
	

	
	if ( $from_database )
	{
		$data['conferenceregistration']			= $CI->queries->fetch_records('short_conference_registration_master', 
																				" AND userid = '". $CI->functions->_user_logged_in_details( "id" ) . "' 
																				  AND conferenceid = '". $data['conference'] -> row("id") ."' ");
																				  
		if ( $data['conferenceregistration']-> num_rows() <= 0) 
		{
			return false;	
		}
																				  
		if ( strpos(strtolower(DropdownHelper::conferenceregions_dropdown( TRUE, $data['conferenceregistration']->row()->regionid  )), 'local') !== FALSE  )
		{
			return TRUE;	
		}
	}
	else if ($region_id)
	{
		if ( strpos(strtolower(DropdownHelper::conferenceregions_dropdown( TRUE, $region_id  )), 'local') !== FALSE  )
		{
			return TRUE;	
		}
	}
	return FALSE;
}
function conference_fullname( $conference, $replace_superscript = TRUE )
{
    $o		 = $conference->row("name") . ', ';
	
	if ( $replace_superscript )
	{
		#replaced 10th with superscript
		$o		 = replace_with_superscript( $o );
	}

    //$o		.= strtoupper( $conference->row("country_code") ) . ' ';
    $o		.= $conference->row("country_name");
	
	return $o;
}
function replace_with_superscript( $_text )
{
	$_text		 	= str_replace("10th", date("d<\s\up>S</\s\up>", strtotime("10-10-10") ), $_text); 
	
	return $_text;
}
function conference_durationdates( $conference )
{
    $duration_from_m		= date("m", strtotime( $conference->row("duration_from") ));
    $duration_to_m			= date("m", strtotime( $conference->row("duration_to") ));
    $o						= '';
    if ( $duration_from_m == $duration_to_m )
    {
		$o					.= date("F ", strtotime( $conference->row("duration_from") ));

		$o					.= date("j<\s\up>S</\s\up>  - ", strtotime( $conference->row("duration_from")));
        $o					.= date("j<\s\up>S</\s\up>, ", strtotime( $conference->row("duration_to") ));
        
        $o					.= date("Y", strtotime( $conference->row("duration_from") ));
    }
    else
    {
        $o					.= date("F ", strtotime( $conference->row("duration_from") ));
        $o					.= date("j<\s\up>S</\s\up> / ", strtotime( $conference->row("duration_from") ));
        
        
        $o					.= date("F ", strtotime( $conference->row("duration_to") ));
        $o					.= date("j<\s\up>S</\s\up>, ", strtotime( $conference->row("duration_to") ));
    
        
        $o					.= date("Y", strtotime( $conference->row("duration_from") ));
    }
	
	return $o;
}
function is_conference_registered_for_local( $from_database = TRUE, $region_id = FALSE )
{
	$CI =& get_instance();
	
	$data['conference']						= $CI->queries->fetch_records('short_conference', " AND status = '1' ");
	if ( $data['conference'] -> num_rows() <= 0 )
	{
		return false;
	}
	

	
	if ( $from_database )
	{
		$data['conferenceregistration']			= $CI->queries->fetch_records('short_conference_registration_master', 
																				" AND userid = '". $CI->functions->_user_logged_in_details( "id" ) . "' 
																				  AND conferenceid = '". $data['conference'] -> row("id") ."' ");
																				  
		if ( $data['conferenceregistration']-> num_rows() <= 0) 
		{
			return false;	
		}
																				  
		if ( strpos(strtolower(DropdownHelper::conferenceregions_dropdown( TRUE, $data['conferenceregistration']->row()->regionid  )), 'local') !== FALSE  )
		{
			return TRUE;	
		}
	}
	else if ($region_id)
	{
		if ( strpos(strtolower(DropdownHelper::conferenceregions_dropdown( TRUE, $region_id  )), 'local') !== FALSE  )
		{
			return TRUE;	
		}
	}
	return FALSE;
}
function conference_registrationdates( $conference, $increase_days_in_FROM_DATE = TRUE )
{
	$FROM_DATE				= "registration_from";
	$TO_DATE				= "registration_to";
	
    $duration_from_m		= date("m", strtotime( $conference->row($FROM_DATE) ));
    $duration_to_m			= date("m", strtotime( $conference->row($TO_DATE) ));
    $o						= '';
	
	
	$TMP_from_date			= $conference->row($FROM_DATE);
	$TMP_to_date			= $conference->row($TO_DATE);
	
	
	if ( $increase_days_in_FROM_DATE)
	{
		$TMP_from_date		= date("Y-m-d", strtotime("+1 day", strtotime( $TMP_from_date )) );
		
	}
	
    if ( $duration_from_m == $duration_to_m )
    {
       // $o					.= date("d - ", strtotime( $TMP_from_date ));//Commented on miss neelam's call
        $o					.= date("d ", strtotime( $TMP_to_date ));
        
        $o					.= date("F, ", strtotime( $TMP_from_date ));
        
        
        $o					.= date("Y", strtotime( $TMP_from_date ));
    }
    else
    {
        $o					.= date("F ", strtotime( $TMP_from_date ));
        $o					.= date("d - ", strtotime( $TMP_from_date ));
        
        
        $o					.= date("F ", strtotime( $TMP_to_date ));
        $o					.= date("d, ", strtotime( $TMP_to_date ));
    
        
        $o					.= date("Y", strtotime( $TMP_from_date ));
    }
	
	return $o;
}
function generate_participant_UID( $id = FALSE )
{
	return base64_encode( $id );	
}
function conferenceregistrations_cleanfilter( $table_record = array(), $remove_HTML = FALSE )
{		
	$CI =& get_instance();
	
	$TMP_dd_regions									= DropdownHelper::short_conferenceregions_dropdown();
	$TMP_dd_package									= DropdownHelper::short_conferencepackage_dropdown();
			
			
	#FILTER RECORDS (avoid error)
	$newTable												= array();
	
	//print_r($table_record); die();
	
	foreach ( $table_record as $key => $value )
	{
		$value['VIEW_conference_master_date_added']			= date("d-m-Y", strtotime($value["conference_master_date_added"]) );
		$value['VIEW_is_paid_name']							= '---';
		$value['VIEW_region_name']							= $TMP_dd_regions [ $value["region_id"] ] ;
		$value['VIEW_package_name']							= $TMP_dd_package [ $value["travelling_with"] ] ;
		$value['VIEW_total_paid']							= '---';
		$value['VIEW_cash_on_site']							= '---';
		$value['VIEW_is_abstract_submitted']				= '---';
		$value['VIEW_screen_5']								= FALSE;
		$value['VIEW_coupon_code']							= '---';
		$value['VIEW_be_a_member_fee_desc']					= '---';
		$value['VIEW_payment_type']							= '---';
		
		$value['VIEW_total_price']							= '---';
		
		
		$value['VIEW_need_to_change_status']				= FALSE;
		
		$value['VIEW_phone']								= '';
		$value['VIEW_email']								= $value['family_email'];
		
		$value['VIEW_phone_screen_3']						= $value["phone_screen_3"];
		$value['VIEW_email_screen_3']						= $value['email_screen_3'];
		
		
		if ( $value["parentid"] == 0)
		{
			
			$value['VIEW_date_added']						= date("d-m-Y", strtotime($value["registration_date"]) );
			$value['VIEW_is_paid_name']						= $value["is_paid_name"];			
			$value['VIEW_total_paid']						= $value["price_total_payable"];
			$value['VIEW_cash_on_site']						= $value["price_cash_onsite"];
			$value['VIEW_is_abstract_submitted']			= $value["is_abstract_submitted"];
			$value['VIEW_screen_5']							= TRUE;
			
			$value['VIEW_coupon_code']						= $value["is_coupon_code"];
			
			
			
			if ( $value["be_a_member_fee_desc"] != "" )
			{
				$value['VIEW_be_a_member_fee_desc']			= $value["be_a_member_fee_desc"];
			}
			$CI->load->helper('short_conference_helper');
			$value['VIEW_total_price']						= format_price( ShortConferenceHelper::calculate_screentwo_from_database( $value["conferenceregistrationid"] ), array("prefix" => $CI->functions->getCurrencySymbol($value['region_show_rates_in_currency'] )) );
			$value['VIEW_payment_type']						= $value["payment_type"];
			
			
			if ( $CI->functions->is_paid_by_cash( $value ) )
			{
				$value['VIEW_need_to_change_status']		= TRUE;
			}
			
			
			$value['VIEW_phone']							= '[ ' . $value["phone"] . ' ]';
			$value['VIEW_email']							= $value["email"];
			
		}
		
		
		if ( $value["full_name"] == "" )
		{
			$value["full_name"] 							= $value["name"] ;
		}
		
		
		$T													= $value;
		if ( $remove_HTML )
		{
			foreach (  $value as $k => $v )
			{
				$T[ $k ]			= strip_tags( $v );
			}
		}
		
		
				
		if ( $value['parentid'] == 0 and $value['screen_one_detail_id'] == 0 )
		{
			$newTable[]											= $T;
		}
		else if ( $value['parentid'] > 0 and $value['screen_one_detail_id'] > 0 )
		{
			$newTable[]											= $T;
		}
		
	}
	return $table_record												= $newTable;
}