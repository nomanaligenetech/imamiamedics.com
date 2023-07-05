<?php
class DropdownHelper 
{
	function __construct()
	{
		parent::__construct();
		#$this->CI 								=& get_instance();
	}
	
	static function runtime_dropdown( $data_array, $key_value = array(), $first_index = "" )
	{
		$CI													=& get_instance();
		$tmp_array											= array();
		
		if ( $first_index != "" )
		{
			$tmp_array[""]									= $first_index;
		}
		
		if ( count($key_value) > 0 )
		{
			if($data_array) {
				foreach ( $data_array as $row )
				{
					$tmp_array[ $row[ $key_value["key"] ] ] 		= $row[ $key_value["value"] ];
				}
			}
		}
		else
		{
			if($data_array) 
			{
				foreach ( $data_array as $row )
				{
					$tmp_array[ $row ] 		= $row;
				}
			}
		}
		
        return $tmp_array;
	}
	
	
	static function country_dropdown( $hide_first_index = FALSE, $id = 'id', $find_key = FALSE, $find_value = FALSE)
	{
		$CI											=& get_instance();
		$tmp_sql									= $CI->queries->fetch_records("countries");
		
		if ( !$hide_first_index )
		{
			$tmp_array[""]							= lang_line('label_select_country');
		}
		
		foreach ( $tmp_sql -> result_array() as $row )
		{
			$tmp_array[ $row[ $id ] ] 				= $row["countries_name"];
		}
		
		
		
		if ( $find_key != '' )
		{
			if ( array_key_exists($find_key, $tmp_array) )
			{
				return $tmp_array[ $find_key ];	
			}
			else
			{
				return $tmp_array[0];	
			}
		}

		if ( $find_value != '' )
		{
			return array_search($find_value, $tmp_array);
		}
		
        return $tmp_array;
	}
	static function state_dropdown( $hide_first_index = FALSE, $id = 'id', $find_key = FALSE,$WHERE_QUERY)
	{
		$CI											=& get_instance();
		$tmp_sql									= $CI->queries->fetch_records("states","{$WHERE_QUERY}");
		if ( !$hide_first_index )
		{
			$tmp_array[""]							= lang_line('label_select_state');
		}
		
		foreach ( $tmp_sql -> result_array() as $row )
		{
			$tmp_array[ $row[ $id ] ] 				= $row["name"];
		}
		
		if ( $find_key != '' )
		{
			if ( array_key_exists($find_key, $tmp_array) )
			{
				return $tmp_array[ $find_key ];	
			}
			else
			{
				return $tmp_array[0];	
			}
		} 
        return $tmp_array;
	}
	static function city_dropdown( $hide_first_index = FALSE, $id = 'id', $find_key = FALSE,$WHERE_QUERY)
	{
		$CI											=& get_instance();
		$tmp_sql									= $CI->queries->fetch_records("cities","{$WHERE_QUERY} ORDER BY name ASC");
		if ( !$hide_first_index )
		{
			$tmp_array[""]							= lang_line('label_select_city');
		}
		
		foreach ( $tmp_sql -> result_array() as $row )
		{
			$tmp_array[ $row[ $id ] ] 				= $row["name"];
		}
		
		if ( $find_key != '' )
		{
			if ( array_key_exists($find_key, $tmp_array) )
			{
				return $tmp_array[ $find_key ];	
			}
			else
			{
				return $tmp_array[0];	
			}
		} 
        return $tmp_array;
	}
	static function currency_dropdown( $hide_first_index = FALSE, $id = 'id', $find_key = FALSE)
	{
	 
		$CI											=& get_instance();
		$tmp_sql									= $CI->queries->fetch_records("currencies");

		if ( !$hide_first_index )
		{
			$tmp_array[""]							= lang_line('label_select_currency'). ' *';
		}
		
		foreach ( $tmp_sql -> result_array() as $row )
		{
			$tmp_array[ $row[ $id ] ] 				= $row["symbol"];
		}
		
		
		
		if ( $find_key != '' )
		{
			if ( array_key_exists($find_key, $tmp_array) )
			{
				return $tmp_array[ $find_key ];	
			}
			else
			{
				return $tmp_array[0];	
			}
		}
        return $tmp_array;
	}
	
	
	static function adminroles_dropdown( $hide_first_index = FALSE, $id = 'id')
	{
		$CI											=& get_instance();
		$tmp_sql									= $CI->queries->fetch_records("admin_roles");
		
		if ( !$hide_first_index )
		{
			$tmp_array[""]							= 'Select Role';
		}
		
		foreach ( $tmp_sql -> result_array() as $row )
		{
			$tmp_array[ $row[ $id ] ] 				= $row["name"];
		}
		
        return $tmp_array;
	}
	
	
	static function menu_dropdown( $dont_allow = FALSE, $hide_first_index = FALSE, $extra_where = '' )
	{
		$CI											=& get_instance();
		
		
		$TMP_where			= "";
		if ( $dont_allow )
		{
			$TMP_where		= " AND id not in (". $dont_allow .")";
		}
		
		#$tmp_sql									= $CI->queries->fetch_records("cmsmenu", " $TMP_where  $extra_where ORDER BY name ");
		
		$obj_parentchild = $CI->parentchild;
		$obj_parentchild->db_table						=	"tb_cmsmenu";	
		$obj_parentchild->item_identifier_field_name	=	"id";
		$obj_parentchild->parent_identifier_field_name	=	"parentid";
		$obj_parentchild->item_list_field_name			=	"name"; 
		$obj_parentchild->extra_condition 				= 	" $TMP_where  $extra_where"; //if required 
		$obj_parentchild->order_by_phrase 				= 	" ORDER BY `name` ";
		$obj_parentchild->level_identifier 				= 	"&nbsp;&nbsp;&nbsp;&nbsp;";
		$obj_parentchild->item_pointer="";
		$root_item_id									=	0;
		
		$tmp_sql = $obj_parentchild->getAllChilds($root_item_id);
		if ( !$hide_first_index )
		{
			$tmp_array[""]							= "Select Menu";
		}
		
	
		foreach ( $tmp_sql as $row )
		{
			$tmp_array[ $row["id"] ] 				= $row["name"];
		}
		
		//return $this->db-last_query(); 	
        return $tmp_array;
	}
	
	static function events_dropdown( $hide_first_index = FALSE, $isEvent)
	{
        $CI											=& get_instance();
		$tmp_sql									= $CI->queries->fetch_records("sitesectionswidgets", " ORDER BY title ");
		
		if ( !$hide_first_index )
		{
			$tmp_array[""]							= $isEvent?"Select Event":"Select Menu Type";
		}
		
		foreach ( $tmp_sql -> result_array() as $row )
		{
			$tmp_array[ $row["id"] ] 				= $row["title"];
		}
		
        return $tmp_array;
	}
	


	static function hreftarget_dropdown()
	{
		$droparray			= array("_parent"		=> "_parent",
									"_blank"		=> "_blank",
									"_self"			=> "_self",
									"_top"			=> "_top"
								   );
		
		return $droparray;
	}
	
	
	static function paymentmode_dropdown()
	{
		$droparray			= array("0"				=> "sandbox",
									"1"				=> "live" );
		
		return $droparray;
	}
	
	
	
	
	static function cmsmenutypes_dropdown( $hide_first_index = FALSE )
	{
		$CI											=& get_instance();
		$tmp_sql									= $CI->queries->fetch_records("cmsmenu_types", " ORDER BY name ");
		
		if ( !$hide_first_index )
		{
			$tmp_array[""]							= "Select Menu Type";
		}
		
		foreach ( $tmp_sql -> result_array() as $row )
		{
			$tmp_array[ $row["id"] ] 				= $row["name"];
		}
		
        return $tmp_array;
	}


	static function cmsmenubelongsto_dropdown( $hide_first_index = FALSE, $find_key = FALSE )
	{
		
		$CI											=& get_instance();

		$tmp_query				= $CI->db->query('SELECT * FROM `tb_belongs_country`');	

		$dynamic_countries = $tmp_query -> result_array();
		$first = true;

		foreach ($dynamic_countries as $key => $value) {

			$id 			= $value['id'];
			$country_title 	= $value['country_title'];

			if ( $first )
			{
				if ( !$hide_first_index )
				{
				//	$droparray[""]							= "Select Donation Frequency";
					$droparray[$id]								= $country_title;
				}
				$first = false;
			}
			else
			{
				$droparray[$id]								= $country_title;
			}
			
		}
		
		
		//For Manage Admin that have multiple belongs
		$strpos = strpos($find_key,',');
		$explode = explode(',',$find_key);
		$numItems = count($explode);
		
		$i = 0;
		if($strpos){
			$count = "";
			foreach ($explode as $key => $value) {
				$comma = (++$i < $numItems) ? ", ": "" ;
				$count .= $droparray[ $value ]. $comma;
			}
			return $count;
		}
		
		
		
		if ( $find_key != '' )
		{
			if ( array_key_exists($find_key, $droparray) )
			{
				return $droparray[ $find_key ];	
			}
			else
			{
				return $droparray[0];	
			}
		}
		
		
		return $droparray;
	}
	
	
	static function cmsmenupositions_dropdown( $only_allow = FALSE, $hide_first_index = FALSE )
		{
	
		$CI											=& get_instance();
	
		$TMP_where									= "";
		if ( $only_allow )
		{
			$TMP_where		= " AND id = ". $only_allow ." ";
			$hide_first_index						= TRUE;
		}


		$tmp_sql									= $CI->queries->fetch_records("cmsmenu_positions", " $TMP_where ORDER BY name ");
		
		if ( !$hide_first_index )
		{
			$tmp_array[""]							= "Select Menu Position";
		}
		
		foreach ( $tmp_sql -> result_array() as $row )
		{
			$tmp_array[ $row["id"] ] 				= $row["name"];
		}
		
        return $tmp_array;
	}
	
	


	
	static function user_dropdown( $hide_first_index = FALSE, $only_id = "" )
	{
		$CI											=& get_instance();
		
		if ($only_id != "" and $only_id > 0) 
		{
			$only_id = " AND id IN(".$only_id.")";
		}
		
		if ( !$hide_first_index )
		{
			$tmp_array[""]							= "Select User";
		}
	
		$tmp_sql									= $CI->queries->fetch_records("users", " $only_id ORDER BY name ");
			
		
		foreach ( $tmp_sql -> result_array() as $row )
		{
			$tmp_array[ $row["id"] ] 				= $row["name"] . ' ' . $row["last_name"];
		}
		
        return $tmp_array;
	}
	
	
	static function truefalse_dropdown( $text_option = 0 )
	{
		if ( $text_option == 1 )
		{
			$droparray			= array("F"				=> "No",
										"T"				=> "Yes"
									   );		
		}
		else
		{
			$droparray			= array("F"				=> "False",
										"T"				=> "True"
									   );	
		}
		
		
		return $droparray;
	}
	
	
	static function yesno_dropdown( $find_key = '')
	{
		
		
		
		
		$droparray[1]								= "Yes";
		$droparray[0]								= "No";
		
					
		
		if ( $find_key != '' )
		{
			if ( array_key_exists($find_key, $droparray) )
			{
				return $droparray[ $find_key ];	
			}
			else
			{
				return $droparray[0];	
			}
		}
		
		return $droparray;
	}
	
	
	static function enabledisable_dropdown( $find_key = '' )
	{
		
		$droparray			= array(1				=> "Enable",
									0				=> "Disable"
								   );
		
		if ( $find_key != '' )
		{
			if ( array_key_exists($find_key, $droparray) )
			{
				return $droparray[ $find_key ];	
			}
			else
			{
				return $droparray[0];	
			}
		}
		
		return $droparray;
	}
	
	static function per_dropdown()
	{
		$droparray			= array("Year"			=> "Year",
									"Month"			=> "Month"
								   );
		
		return $droparray;
	}
	
	
	static function emailmode_dropdown()
	{
		$droparray			= array("smtp"			=> "SMTP",
									"mail"			=> "MAIL"
								   );
		return $droparray;
	}
	
	
	
	
	##########################################
	############ CUSTOM functions ############
	##########################################
	
	
	
	
	static function chapterspersons_boards_dropdown( $hide_first_index = FALSE, $find_key = '' )
	{
		$CI											=& get_instance();
		$tmp_sql									= $CI->queries->fetch_records("boards", " AND status = '1' ORDER BY SORT ");
		
		if ( !$hide_first_index )
		{
			$tmp_array[""]							= "Select Board";
		}
		
		foreach ( $tmp_sql -> result_array() as $row )
		{
			$tmp_array[ $row["id"] ] 				= $row["name"];
		}
		
        return $tmp_array;
		
	}
	
	static function chapterspersons_designations_dropdown( $hide_first_index = FALSE, $find_key = '' )
	{
		$CI											=& get_instance();
		$tmp_sql									= $CI->queries->fetch_records("designation", " AND status = '1' ORDER BY SORT ");
		
		if ( !$hide_first_index )
		{
			$tmp_array[""]							= "Select Designation";
		}
		
		foreach ( $tmp_sql -> result_array() as $row )
		{
			$tmp_array[ $row["id"] ] 				= $row["name"];
		}
		
        return $tmp_array;
	}
	
	
	static function eventactivities_dropdown( $find_key = FALSE )
	{
		$droparray			= array("events"			=> lang_line('menu_events'),//"Events",
									"activities"		=> lang_line('menu_activites')//"Activities"
								   );
		
		if ( $find_key != '' )
		{
			if ( array_key_exists($find_key, $droparray) )
			{
				return $droparray[ $find_key ];	
			}
			else
			{
				return $droparray[0];	
			}
		}
		
		
		return $droparray;
	}
	
	
	static function donationmode_dropdown( $hide_first_index = FALSE, $find_key = FALSE )
	{		
		if ( !$hide_first_index )
		{
			$droparray[""]					= "Select Donation Mode";
		}
		
		
		$droparray["onetime"]				= lang_line("label_onetime");
		$droparray["recurring"]				= lang_line("label_recuring");
		
		if ( $find_key != '' )
		{
			if ( array_key_exists($find_key, $droparray) )
			{
				return $droparray[ $find_key ];	
			}
			else
			{
				return $droparray[0];	
			}
		}
		
		
		return $droparray;
	}
	
	static function donationmode_dropdown_2( $hide_first_index = FALSE, $find_key = FALSE )
	{		
		if ( !$hide_first_index )
		{
			$droparray[""]					= "Select Donation Mode";
		}
				
		$droparray["onetime"]				= "Single Donation";
		$droparray["recurring"]				= "Recurring Donation";
		
		if ( $find_key != '' )
		{
			if ( array_key_exists($find_key, $droparray) )
			{
				return $droparray[ $find_key ];	
			}
			else
			{
				return $droparray[0];	
			}
		}
		
		
		return $droparray;
	}
	
	static function donationfrequency_dropdown( $hide_first_index = FALSE, $find_key = FALSE )
	{
		
		
		if ( !$hide_first_index )
		{
		//	$droparray[""]							= "Select Donation Frequency";
		}
		
		
		$droparray["M-1"]							= lang_line('label_monthly');
		$droparray["M-3"]							= lang_line('label_quarterly');
		$droparray["M-6"]							= lang_line('label_halfyearly');
		$droparray["Y-1"]							= lang_line('label_yearly');
		
		
		if ( $find_key != '' )
		{
			if ( array_key_exists($find_key, $droparray) )
			{
				return $droparray[ $find_key ];	
			}
			else
			{
				return $droparray[0];	
			}
		}
		
		
		return $droparray;
	}
	
	
	static function donatetype_dropdown( $hide_first_index = FALSE, $find_key = FALSE )
	{
		
		
		if ( !$hide_first_index )
		{
	//		$droparray[""]							= "Select Donate Type";
		}
		
		
		$droparray["financial_support"]				= "Financial Support";
		$droparray["gift_of_securities"]			= "Gift of Securities";
		$droparray["request_in_wills"]				= "Request in Wills";
		
		if ( $find_key != '' )
		{
			if ( array_key_exists($find_key, $droparray) )
			{
				return $droparray[ $find_key ];	
			}
			else
			{
				return $droparray[0];	
			}
		}
		
		
		return $droparray;
	}
	
	
	
	static function modeofcontact_dropdown( $hide_first_index = FALSE, $find_key = FALSE )
	{
		
		
		if ( !$hide_first_index )
		{
			$droparray[""]							= "Select Contact Mode";
		}
		
		
		$droparray["telephone"]				= "Telephone";
		$droparray["cell"]					= "Cell";
		$droparray["home"]					= "Home";
		
		if ( $find_key != '' )
		{
			if ( array_key_exists($find_key, $droparray) )
			{
				return $droparray[ $find_key ];	
			}
			else
			{
				return $droparray[0];	
			}
		}
		
		
		return $droparray;
	}
	
	static function donation_projects_dropdown( $hide_first_index = FALSE, $find_key = '', $is_campaign = FALSE, $front_add_data = false, $is_event = false, $content_languages = [] )
	{
		$CI											=& get_instance();
		$addQry										= "";
		if($is_campaign){
			$addQry									= " AND campaign = 1";
		}
		if($is_event){
			$addQry									.= " AND is_event = 1";
		}
		if($front_add_data){
			$addQry									.= " AND show_front = 1";
		}

		if ( is_countryCheck(FALSE,FALSE,TRUE) == 'canada' ){
			$addQry							.= " AND belongsto IN (0, 1, 3)";
		}
		elseif(is_countryCheck(FALSE,FALSE,TRUE) == 'medics'){
			$addQry							.= " AND belongsto IN (0, 1, 4)";
		}
		else {
			$addQry							.= " AND belongsto IN (0, 1, 2)";
		}

		$tmp_sql									= $CI->queries->fetch_records("donation_projects", " AND status = '1'".$addQry." ORDER BY SORT ");

		if ( !$hide_first_index )
		{
			$tmp_array["0"]							= "Select Project";
			// $tmp_array[""]							= "Select Donation Projects";
		}
		
		foreach ( $tmp_sql -> result_array() as $row )
		{
			if(!empty($content_languages)){
				$donation_projects_languages = $CI->queries->fetch_records("donation_projects_languages", " AND donation_projects_id = {$row['id']}")->result_array();
				replace_data_for_lang($row, $content_languages, $donation_projects_languages, ['name'], SessionHelper::_get_session('LANG_CODE') );
			}

			if($front_add_data){
				$class 						= $row["campaign"] == 1 ? "camp" : "proj";
				$campaign_query 			= $CI->queries->fetch_records("donation_campaigns", " AND donation_project_id = {$row['id']}");
				$campaign_query 			= $campaign_query->result_array();
				$slug 						= $row["campaign"] == 1 ? $campaign_query[0]['slug'] : ''; 

				$tmp_array[ $row["id"] ] 	= array($row["name"], $class, $row['type'], $row['parentid'] , $slug , $row['sort'], $row['id'] );
				// if($parent){
					// 	$tmp_array[ $row["id"] ]['disabled'] 				= $row['parentid'] == $find_key;
					// }
			} else {
				$tmp_array[ $row["id"] ] 	= $row["name"];
			}
			
		}
		
		
		
		if ( $find_key != '' )
		{
			if ( array_key_exists($find_key, $tmp_array) )
			{
				return $tmp_array[ $find_key ];	
			}
			else
			{
				return $tmp_array[0];	
			}
		}

        return $tmp_array;
	}
	static function projects_type_dropdown($find_key = '')
	{
		$droparray			= array(""			=>"None",
									"Khums"		=>"Khums",
									"Fitrana"	=>"Fitrana"
								   );
		
		// return $droparray;
		if ( $find_key != '' )
		{
			if ( array_key_exists($find_key, $droparray) )
			{
				return $droparray[ $find_key ];	
			}
			else
			{
				return $droparray[0];	
			}
		}
		
		return $droparray;
	}
	static function content_languages_dropdown( $hide_first_index = FALSE, $find_key = '' )
	{
		$CI											=& get_instance();
		$tmp_sql									= $CI->queries->fetch_records("content_languages", " ORDER BY code <> '".DEFAULT_LANG_CODE."', code ASC ");
		
		if ( !$hide_first_index )
		{
			// $tmp_array[""]							= "Select Language";
		}
		
		foreach ( $tmp_sql -> result_array() as $row )
		{
			$tmp_array[ $row["code"] ] 				= $row["name"];
		}
		
        return $tmp_array;
		
	}
	static function language_direction_dropdown($find_key = '')
	{
		$droparray			= array(
									"LTR"	=>"LTR",
									"RTL"		=>"RTL"
								   );
		
		// return $droparray;
		if ( $find_key != '' )
		{
			if ( array_key_exists($find_key, $droparray) )
			{
				return $droparray[ $find_key ];	
			}
			else
			{
				return $droparray[0];	
			}
		}
		
		return $droparray;
	}
	static function marjaa_taqleed_dropdown()
	{
		$droparray			= array(null 			=> "Please Select",
									"Ayatullah Syed Ali Khamenei"			=>"Ayatullah Syed Ali Khamenei",
									"Ayatullah Syed Ali Seestani"			=>"Ayatullah Syed Ali Seestani",
									"Ayatullah Syed Rohullah Khomeini"			=>"Ayatullah Syed Rohullah Khomeini",
									"Ayatullah Syed Abdul Qasim Khoe"			=>"Ayatullah Syed Abdul Qasim Khoei",
									"Others ( I Don't Know )"			=>"Others ( I Don't Know )"
								   );
		
		return $droparray;
	}
	static function donation_campaigns_dropdown( $hide_first_index = FALSE, $find_key = '')
	{
		$CI											=& get_instance();

		$tmp_sql									= $CI->queries->fetch_records("donation_campaigns", " AND status = '1' ORDER BY id ");
		
		if ( !$hide_first_index )
		{
			$tmp_array[""]							= "Select Donation Campaign";
		}
		
		foreach ( $tmp_sql -> result_array() as $row )
		{
			$tmp_array[ $row["id"] ] 				= ucwords(str_replace("-", " ", $row["slug"]));
		}
		
		
		
		if ( $find_key != '' )
		{
			if ( array_key_exists($find_key, $tmp_array) )
			{
				return $tmp_array[ $find_key ];	
			}
			else
			{
				return $tmp_array[0];	
			}
		}
		
        return $tmp_array;
	}
	static function membership_package()
	{
		$CI											=& get_instance();
		$tmp_sql									= $CI->imiconf_queries->fetch_records_imiconf("conference_prices_not_a_member", " and `conferenceid` IS NULL AND `membership_classification_id` IS NOT NULL ");
		
		foreach ( $tmp_sql -> result_array() as $row )
		{
			$tmp_array[ $row["id"] ] 				= array('per' => $row['per'], 'name' => $row["name"]);
		}
		
        return $tmp_array;
	}
	
	########################################
	####   			 Forum             #####
	########################################

static function category_type( $hide_first_index = FALSE, $find_key = '' )
	{
		$CI											=& get_instance();
		$tmp_sql									= $CI->queries->fetch_records("categorytype", "ORDER BY id DESC ");
		
		if ( !$hide_first_index )
		{
			$tmp_array[""]							= "Select Category";
		}
		
		foreach ( $tmp_sql -> result_array() as $row )
		{
			$tmp_array[ $row["id"] ] 				= $row["cat_type_name"];
		}
		
        return $tmp_array;
		
	}
	
	static function getCategories( $dont_allow = FALSE, $hide_first_index = FALSE, $extra_where = '' )
	{
		$CI											=& get_instance();
		
		
		$TMP_where			= "";
		if ( $dont_allow )
		{
			$TMP_where		= " AND id not in (". $dont_allow .")";
		}
		
		#$tmp_sql									= $CI->queries->fetch_records("cmsmenu", " $TMP_where  $extra_where ORDER BY name ");
		
		$obj_parentchild = new ParentChild();
		$obj_parentchild->db_table						=	"tb_category";	
		$obj_parentchild->item_identifier_field_name	=	"id";
		$obj_parentchild->parent_identifier_field_name	=	"parent_id";
		$obj_parentchild->item_list_field_name			=	"cat_name"; 
		$obj_parentchild->extra_condition 				= 	" $TMP_where  $extra_where"; //if required 
		$obj_parentchild->order_by_phrase 				= 	" ORDER BY `cat_name` ";
		$obj_parentchild->level_identifier 				= 	"&nbsp;&nbsp;&nbsp;&nbsp;";
		$obj_parentchild->item_pointer="";
		$root_item_id									=	0;
		
		$tmp_sql = $obj_parentchild->getAllChilds($root_item_id);
		
		if ( !$hide_first_index )
		{
			$tmp_array[""]							= "Select Category";
		}
		
	
		foreach ( $tmp_sql as $row )
		{
			$tmp_array[ $row["id"] ] 				= $row["cat_name"];
		}
		
		
        return $tmp_array;
	}
	
	

static function category( $hide_first_index = FALSE, $find_key = '' )
	{
		$CI											=& get_instance();
		$tmp_sql									= $CI->queries->fetch_records("category", "ORDER BY id DESC ");
		
		if ( !$hide_first_index )
		{
			$tmp_array[""]							= "Select Category";
		}
		
		foreach ( $tmp_sql -> result_array() as $row )
		{
			$tmp_array[ $row["id"] ] 				= $row["cat_name"];
		}
		
        return $tmp_array;
		
	}

static function forum( $hide_first_index = FALSE, $find_key = '' )
	{
		$CI											=& get_instance();
		$tmp_sql									= $CI->queries->fetch_records("forum", "ORDER BY id DESC ");
		
		if ( !$hide_first_index )
		{
			$tmp_array[""]							= "Select Forum";
		}
		
		foreach ( $tmp_sql -> result_array() as $row )
		{
			$tmp_array[ $row["id"] ] 				= $row["name"];
		}
	
	    return $tmp_array;
		
	}


static function topic( $hide_first_index = FALSE, $find_key = '' )
	{
		$CI											=& get_instance();
		$tmp_sql									= $CI->queries->fetch_records("formtopics", "ORDER BY id DESC ");
		
		if ( !$hide_first_index )
		{
			$tmp_array[""]							= "Select Topic";
		}
		
		foreach ( $tmp_sql -> result_array() as $row )
		{
			$tmp_array[ $row["id"] ] 				= $row["name"];
		}

        return $tmp_array;
		
	}

static function posts( $hide_first_index = FALSE, $find_key = '' )
	{
	
		$CI											=& get_instance();
		$tmp_sql									= $CI->queries->fetch_records("posts", "ORDER BY id DESC ");
		
		if ( !$hide_first_index )
		{
		
				$tmp_array[""]							= "Select Post";
		
		}
		
		foreach ( $tmp_sql -> result_array() as $row )
		{
		
			$tmp_array[ $row["id"] ] 				= $row["name"];
		
		}

    return $tmp_array;
		
	}


	static function topics_dropdown( $dont_allow = FALSE, $hide_first_index = FALSE, $extra_where = '' )
	{
		$CI											=& get_instance();
		
		
		$TMP_where			= "";
		if ( $dont_allow )
		{
			$TMP_where		=  $dont_allow ;
		}
		
		#$tmp_sql									= $CI->queries->fetch_records("cmsmenu", " $TMP_where  $extra_where ORDER BY name ");
		

		$tmp_sql									= $CI->queries->fetch_records("getTopics","AND frmid=".$TMP_where." ORDER BY name ASC ");
		
		if ( !$hide_first_index )
		{
	
			$tmp_array[""]							= "Select Topic";
	
		}
		
		foreach ( $tmp_sql -> result_array() as $row )
		{
	
			$tmp_array[ $row["id"] ] 				= $row["name"];
	
		}
		
        return $tmp_array;
	}
	
	
	static function gender_dropdown( $hide_first_index = FALSE, $find_key = FALSE )
	{
		
		
		if ( !$hide_first_index )
		{
			$droparray[""]							= lang_line('text_selectgender');
		}
		
		
		$droparray["m"]						= lang_line('text_male');
		$droparray["f"]						= lang_line('text_female');

		
		if ( $find_key != '' )
		{
			if ( array_key_exists($find_key, $droparray) )
			{
				return $droparray[ $find_key ];	
			}
			else
			{
				return $droparray[0];	
			}
		}
		
		
		return $droparray;
	}

	static function donation_empnames_dropdown( $hide_first_index = FALSE, $find_key = FALSE ){

		if ( !$hide_first_index )
		{
			$droparray[""]							= lang_line('label_emp_list');
		}
		
		
		$droparray["Astra Zeneca"]						= "Astra Zeneca";
		$droparray["Bank of America"]					= "Bank of America";
		$droparray["Eli Lily"]							= "Eli Lily";
		$droparray["GSK"]								= "GSK";
		$droparray["Medtronic"]							= "Medtronic";
		$droparray["Microsoft"]							= "Microsoft";
		$droparray["Novo Nordisk"]						= "Novo Nordisk";
		$droparray["Pfizer"]							= "Pfizer";
		$droparray["Sanofi Aventis"]					= "Sanofi Aventis";
		$droparray["Shell Oil Company"]					= "Shell Oil Company";

		
		if ( $find_key != '' )
		{
			if ( array_key_exists($find_key, $droparray) )
			{
				return $droparray[ $find_key ];	
			}
			else
			{
				return $droparray[0];	
			}
		}
		
		
		return $droparray;

	}

	static function salutation_dropdown()
	{
		$droparray			= array(
									""					=> lang_line('text_pleaseselect'),
									"Mr"				=> lang_line('text_mr'),
									"Mrs"				=> lang_line('text_mrs'),
									"Ms"				=> lang_line('text_ms'),
									"Dr"				=> lang_line('text_dr')
								);
		
		return $droparray;
	}

	static function chapter_locations_dropdown( $hide_first_index = FALSE, $find_key = '' )
	{
		$CI											=& get_instance();
		$tmp_sql									= $CI->queries->fetch_records("chapterslocation_master", " AND status = '1' ORDER BY SORT ","title,slug");
		
		if ( !$hide_first_index )
		{
			$tmp_array[""]							= "Select Chapter";
		}
		
		foreach ( $tmp_sql -> result_array() as $row )
		{
			$tmp_array[ $row["slug"] ] 				= $row["title"];
		}
		
        return $tmp_array;
	}
	
	static function comments_status_dropdown(/*$find_key = false, $get_remain = false*/)
	{
		$droparray = array(
			0 => array("status"=>"Pending","update"=>"Pending","class"=>"btn-warning"),
			1 => array("status"=>"Approved","update"=>"Approve","class"=>"btn-success"),
			2 => array("status"=>"Rejected","update"=>"Reject","class"=>"btn-danger"),
		);
		/*if(is_int((int) $find_key) ){
			if(array_key_exists($find_key, $droparray)){
				return $droparray[$find_key];
			}
		}
		if(is_int((int) $get_remain) ){
			if(array_key_exists($find_key, $droparray)){
				return $droparray[$find_key];
			}
		}*/
		return $droparray;
	}
	
	static function modeofpayment_dropdown( $hide_first_index = FALSE, $find_key = FALSE )
	{				
		if ( !$hide_first_index )
		{
			$droparray[""]							= "Select Payment Mode";
		}
		
		$droparray["cash"]							= "Cash";
		$droparray["cheque"]						= "Cheque";
		$droparray["banktransfer"]					= "Via Bank Transfer";
		$droparray["others"]						= "Others";
		
		if ( $find_key != '' )
		{
			if ( array_key_exists($find_key, $droparray) )
			{
				return $droparray[ $find_key ];	
			}
			else
			{
				return $droparray[0];	
			}
		}
		return $droparray;
	}

	static function short_conferenceregistration_paymenttype( $hide_first_index = TRUE, $break_both = FALSE, $is_imi	= FALSE )
	{

		if ( !$hide_first_index )
		{
			$tmp_array[""]							= 'Select';
		}
		
		
		$new										= array();
		
		$tmp_array['2'] 							= "IMI Members"; //(Accomodation & Local Travel)
		$tmp_array['1'] 							= "Non Members"; //(Accomodation & Local Travel)
		if ( $is_imi )
		{
			if ( $is_imi == "2" )
			{
				return TRUE;
			}
			else
			{
				return FALSE;	
			}
		}
		
		
		
		
		if ( $break_both )
		{
			$new['members']							= $tmp_array;
			$tmp_array								= array();
		}
		
		
		$tmp_array['3'] 							= "Conference Registration Only";
		if ( $break_both )
		{                                                                                                                                                                                
			$new['others']							= $tmp_array;
			$tmp_array								= array();
			
			return $new;
		}
		
        return $tmp_array;
	}

	static function short_conference_dropdown( $hide_first_index = FALSE, $only_id = "" )
	{
		$CI											=& get_instance();
		
		if ($only_id != "" and $only_id > 0) 
		{
			$only_id = " AND id IN(".$only_id.")";
		}

		if ( !$hide_first_index )
		{
			$tmp_array[""]							= "Select Conference";
		}
			
		$tmp_sql									= $CI->queries->fetch_records("short_conference", " $only_id ORDER BY name ");
		
		
		foreach ( $tmp_sql -> result_array() as $row )
		{
			$tmp_array[ $row["id"] ] 				= $row["name"];
		}
		
        return $tmp_array;
	}
	static function short_conferenceregions_dropdown( $hide_first_index = FALSE, $find_key = '', $show_for_active_conference = FALSE, $where_clause = '' )
	{
		$CI											=& get_instance();
		$TMP_where									= FALSE;
		if ($show_for_active_conference)
		{
			$activeConf_id		= $CI->queries->fetch_records("short_conference", "AND status = 1 " )->row()->id; 
										
											
			#SessionHelper::_get_session("id", "conference")
		
			$TMP_where								.= " AND conferenceid = '". $activeConf_id ."' ";
		}
		
		
		if ( $where_clause  != "" )
		{
			$TMP_where								.= $where_clause;
		}
		
		$tmp_sql									= $CI->queries->fetch_records("short_conference_regions", " AND 1=1 $TMP_where ORDER BY sort ");
		
		if ( !$hide_first_index )
		{
			$tmp_array[""]							= "Select Region";
		}
		
		foreach ( $tmp_sql -> result_array() as $row )
		{
			$tmp_array[ $row["id"] ] 				= $row["name"];
		}
		
		
		if ( $find_key != '' )
		{
			
			if ( array_key_exists($find_key, $tmp_array) )
			{
				return $tmp_array[ $find_key ];	
			}
			else
			{
				return '';
			}
		}
		
        return $tmp_array;
	}
	static function short_conferenceprices_dropdown( $hide_first_index = FALSE, $where = '', $key_name= 'title' )
	{
		$CI											=& get_instance();
		$tmp_sql									= $CI->queries->fetch_records("short_conference_prices_master", " $where ORDER BY title ");
		
		if ( !$hide_first_index )
		{
			$tmp_array[""]							= "Select";
		}

		if( !empty($tmp_sql) && $tmp_sql->num_rows() > 0 ){

			foreach ( $tmp_sql -> result_array() as $row )
			{
				$tmp_array[ $row["id"] ] 				= $row[ $key_name ];
			}
		}else{
			$tmp_array[""]							= "Select";
		}
		
        return $tmp_array;
	}
	static function pkgtype_dropdown($conferenceid)
	{
		$droparray			= array("ALL");

		$CI					=& get_instance();
		$TMP_regions		= $CI->queries->fetch_records("short_conference_regions", " AND conferenceid = '". $conferenceid ."' ");
		if ( $TMP_regions -> num_rows() > 1 )
		{
			foreach ( $TMP_regions -> result_array() as $row )
			{
				$droparray[$row["id"]]		= $row["name"];
			}
		}
		
		return $droparray;
	}
	static function short_conferencewhoattend_dropdown( $hide_first_index = FALSE, $where = '' )
	{
		$CI											=& get_instance();
		$tmp_sql									= $CI->queries->fetch_records("short_conference_who_attend", " $where ORDER BY name ");
		
		if ( !$hide_first_index )
		{
			$tmp_array[""]							= "Select";
		}
		
		foreach ( $tmp_sql -> result_array() as $row )
		{
			$tmp_array[ $row["id"] ] 				= $row["name"];
		}
		
        return $tmp_array;
	}
	static function education_dropdown( $hide_first_index = TRUE, $id = 'id')
	{

		if ( !$hide_first_index )
		{
			$tmp_array[""]							= 'Select';
		}
		
		
		$tmp_array['BSc'] 							= "BSc";
		$tmp_array['PhD'] 							= "PhD";
		
		$tmp_array['MD'] 							= "MD";
		$tmp_array['RN'] 							= "RN";
		
		
		$tmp_array['Faculty Member'] 				= "Faculty Member";
		$tmp_array['Consultant'] 					= "Consultant";
		
		$tmp_array['Medical Student'] 				= "Medical Student";
		$tmp_array['MSc'] 							= "MSc";
		
		$tmp_array['Post Doctorate'] 				= "Post Doctorate";
		
		$tmp_array['General Physician'] 			= "General Physician";
		$tmp_array['Religious Scholar'] 			= "Religious Scholar";
		
		
		$tmp_array['Student (Non-Medical)'] 		= "Student (Non-Medical)";
		$tmp_array['Non-Health Professional'] 		= "Non-Health Professional";
		
		
		$tmp_array['Other'] 						= "Other";
		
		
		
		
        return $tmp_array;
	}
	static function prefix_dropdown( $hide_first_index = TRUE, $id = 'id')
	{

		if ( !$hide_first_index )
		{
			$tmp_array[""]							= 'Select Prefix';
		}
		
		$tmp_array['Mr.'] 					= "Mr.";
		$tmp_array['Mrs.'] 					= "Mrs.";
		$tmp_array['Miss.'] 				= "Miss.";
		$tmp_array['Dr.'] 					= "Dr.";
		$tmp_array['Prof.'] 				= "Prof.";
		
		
        return $tmp_array;
	}
	static function conferenceregions_dropdown( $hide_first_index = FALSE, $find_key = '', $show_for_active_conference = FALSE, $where_clause = '' )
	{
		$CI											=& get_instance();
		$TMP_where									= FALSE;
		if ($show_for_active_conference)
		{
			$activeConf_id		= $CI->queries->fetch_records("short_conference", "AND status = 1 " )->row()->id; 
										
											
			#SessionHelper::_get_session("id", "conference")
		
			$TMP_where								.= " AND conferenceid = '". $activeConf_id ."' ";
		}
		
		
		if ( $where_clause  != "" )
		{
			$TMP_where								.= $where_clause;
		}
		
		$tmp_sql									= $CI->queries->fetch_records("short_conference_regions", " AND 1=1 $TMP_where ORDER BY sort ");
		
		if ( !$hide_first_index )
		{
			$tmp_array[""]							= "Select Region";
		}
		
		foreach ( $tmp_sql -> result_array() as $row )
		{
			$tmp_array[ $row["id"] ] 				= $row["name"];
		}
		
		
		if ( $find_key != '' )
		{
			
			if ( array_key_exists($find_key, $tmp_array) )
			{
				return $tmp_array[ $find_key ];	
			}
			else
			{
				return '';
			}
		}
		
        return $tmp_array;
	}
	static function relationship_dropdown( $hide_first_index = TRUE )
	{		
		
		$CI											=& get_instance();
		$tmp_sql									= $CI->queries->fetch_records("family_relationships", " ORDER BY name ");
		
		if ( !$hide_first_index )
		{
			$tmp_array[""]							= "Select";
		}
		
		foreach ( $tmp_sql -> result_array() as $row )
		{
			$tmp_array[ $row["id"] ] 				= $row["name"];
		}
		
        return $tmp_array;
	}

	static function short_conferenceprice_earlybird_regular_dropdown( $hide_first_index = TRUE, $is_percent = FALSE, $registration_MASTER = array() )
	{
		$CI											=& get_instance();
		

		if ( !$hide_first_index )
		{
			$tmp_array[""]							= 'Select';
		}
		
		
		if ( $is_percent )
		{
			
			$TMP_allow_payment							= TRUE;
			if ( count($registration_MASTER) > 0 )
			{
				$TMP_regions							= $CI->queries->fetch_records("short_conference_regions", " AND id = '". $registration_MASTER['regionid'] ."' ");
				if ( $TMP_regions -> num_rows() > 0 )
				{
					if ( !$TMP_regions -> row("allow_payment") )
					{
						$TMP_allow_payment				= FALSE;
					}
				}
			}
			
			
			if ( $TMP_allow_payment )
			{
				//$tmp_array['0'] 							= "Non Members"; //(Accomodation & Local Travel)
				$tmp_array['earlybird_price'] 				= 100; //(Accomodation & Local Travel)
				$tmp_array['regular_price'] 				= 100;
			}
			else
			{
				$tmp_array['earlybird_price'] 				= 100; //(Accomodation & Local Travel)
				$tmp_array['regular_price'] 				= 100;
			}
		}
		else
		{
			//$tmp_array['0'] 							= "Non Members"; //(Accomodation & Local Travel)
			$tmp_array['earlybird_price'] 				= "Early Bird"; //(Accomodation & Local Travel)
			$tmp_array['regular_price'] 				= "General Registration";
		}
		
		

        return $tmp_array;
	}
	static function abstracttype_dropdown( $hide_first_index = TRUE, $find_key = '')
	{

		if ( !$hide_first_index )
		{
			$tmp_array[""]							= 'Select';
		}
		
		$tmp_array['facultymember'] 				= "Faculty Member";
		$tmp_array['student'] 						= "Student";
		
		
		if ( $find_key != '')
		{
			if ( array_key_exists($find_key, $tmp_array) )
			{
				return $tmp_array[ $find_key ];	
			}
			else
			{
				return '';
			}
		}
		
        return $tmp_array;
	}
	static function short_conferencepackage_dropdown()
	{
		$droparray			= array("imi_group"					=> "<span class='label bg-maroon btn-flat'>With IMI</span>",
									"independently"				=> "<span class='label bg-navy'>Independently</span>" );
		
		return $droparray;
	}
	static function short_conferenceregistration_guestfamilyguest( $hide_first_index = TRUE, $break_both = FALSE, $is_imi	= FALSE )
	{

		if ( !$hide_first_index )
		{
			$tmp_array[""]							= 'Select';
		}
		
		
		$new										= array();
		
		$tmp_array['2'] 							= "IMI Members"; //(Accomodation & Local Travel)
		$tmp_array['1'] 							= "Non Members"; //(Accomodation & Local Travel)
		if ( $is_imi )
		{
			if ( $is_imi == "2" )
			{
				return TRUE;
			}
			else
			{
				return FALSE;	
			}
		}
		
		
		
		
		if ( $break_both )
		{
			$new['members']							= $tmp_array;
			$tmp_array								= array();
		}
		
		
		$tmp_array['3'] 							= "Conference Registration Only";
		if ( $break_both )
		{
			$new['others']							= $tmp_array;
			$tmp_array								= array();
			
			return $new;
		}
		
        return $tmp_array;
	}
}

?>