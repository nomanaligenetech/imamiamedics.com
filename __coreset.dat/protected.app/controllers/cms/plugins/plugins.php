<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plugins extends C_frontend {

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
	
	public function __construct(  &$data )
	{
		parent::__construct( );
		
		
		include_once(APPPATH . 'controllers/cms/plugins/pp_contactus_form.php');
		include_once(APPPATH . 'controllers/cms/plugins/pp_chapter_this_location.php');
		include_once(APPPATH . 'controllers/cms/plugins/pp_where_we_work_world_map.php');
		include_once(APPPATH . 'controllers/cms/plugins/pp_events_activities_this_menu.php');
		include_once(APPPATH . 'controllers/cms/plugins/pp_three_images_slider.php');
		include_once(APPPATH . 'controllers/cms/plugins/pp_thumbnails_images_slider.php');
		include_once(APPPATH . 'controllers/cms/plugins/pp_mentorship_form.php');
		include_once(APPPATH . 'controllers/cms/plugins/pp_arbaeen_medical_mission_form.php');
		include_once(APPPATH . 'controllers/cms/plugins/pp_arbaeen_medical_mission_form_new.php');
		include_once(APPPATH . 'controllers/cms/plugins/pp_arbaeen_medical_mission_stage3_form.php');
		include_once(APPPATH . 'controllers/cms/plugins/pp_arbaeen_medical_mission_stage3b_form.php');
		
		#we have done this because we have some variables that we need to load in construct.. so that we can change variable values in other function.
		include_once(APPPATH . 'controllers/cms/plugins/pp_new_donate_form.php');
		include_once(APPPATH . 'controllers/cms/plugins/pp_donate_form.php');
		$PP_Donate_Form							= new PP_Donate_Form( $data, $this );  
		$PP_New_Donate_Form							= new PP_New_Donate_Form( $data, $this );  

		
		include_once(APPPATH . 'controllers/cms/plugins/pp_emergency_roster_form.php');
		include_once(APPPATH . 'controllers/cms/plugins/pp_volunteer_form.php');
		include_once(APPPATH . 'controllers/cms/plugins/pp_internship_form.php');

		include_once(APPPATH . 'controllers/cms/plugins/pp_press_releases.php');
		include_once(APPPATH . 'controllers/cms/plugins/pp_imi_news.php');
		include_once(APPPATH . 'controllers/cms/plugins/pp_imi_forums.php');
		
	}
	
	
	
	
	public function render( &$data )
	{
		$TMP_show_array				= array();
		if ( $data['content_detail']->num_rows() > 0 )
		{
			$TMP_sc					= $this->functions->content_shortcodes(FALSE, $data['PLUGINS_CODE'], TRUE);
			
			
			foreach ( $TMP_sc as $t_key => $t_value )
			{
				if (strpos($data['content_detail']->row()->content, $t_value['shortcode']) !== FALSE)
				{
					$TMP_show_array[]			= $t_value['shortcode'];
				}
			}
		}
		
		#plugins_code written in MY_Controller.php file.
		if ( in_array( "[CONTACTUS_FORM]", $TMP_show_array ) )
		{
			$data["PLUGINS_CODE"]["DISPLAY_CONTACTUS_FORM"]						= PP_Contactus_Form::show( $data, $this ) ;
		}
		
		
		
		if ( in_array( "[CHAPTER_THIS_LOCATION]", $TMP_show_array ) )
		{
			$data["PLUGINS_CODE"]["DISPLAY_CHAPTER_THIS_LOCATION"]				= PP_Chapter_This_Location::show( $data, $this ) ;
		}
		
		if ( in_array( "[WHERE_WE_WORK_WORLD_MAP]", $TMP_show_array ) )
		{
			$data["PLUGINS_CODE"]["DISPLAY_WHERE_WE_WORK_WORLD_MAP"]			= PP_Where_We_Work_World_Map::show( $data, $this ) ;
		}
		
		if ( in_array( "[ACTIVITIES_THIS_MENU]", $TMP_show_array ) )
		{
			$data["PLUGINS_CODE"]["DISPLAY_ACTIVITIES_THIS_MENU"]				= PP_Events_Activities_This_Menu::show( $data, $this, SLUG_ACTIVITIES ) ;
		}
		
		if ( in_array( "[EVENTS_THIS_MENU]", $TMP_show_array ) )
		{
			$data["PLUGINS_CODE"]["DISPLAY_EVENTS_THIS_MENU"]					= PP_Events_Activities_This_Menu::show( $data, $this, SLUG_EVENTS ) ;
		}
		
		if ( in_array( "[EVENTS_ACTIVITIES_THIS_MENU]", $TMP_show_array ) )
		{
			$data["PLUGINS_CODE"]["DISPLAY_EVENTS_ACTIVITIES_THIS_MENU"]		= PP_Events_Activities_This_Menu::show( $data, $this, SLUG_EVENTS_ACTIVITIES ) ;
		}
		
		if ( in_array( "[EVENTS_ACTIVITIES_MENUS_LIST_ALL]", $TMP_show_array ) )
		{
			$data["PLUGINS_CODE"]["DISPLAY_EVENTS_ACTIVITIES_MENUS_LIST_ALL"]	= PP_Events_Activities_This_Menu::menus_list( $data, $this ) ;
		}
		
		if ( in_array( "[THREE_IMAGES_SLIDER]", $TMP_show_array ) )
		{
			$data["PLUGINS_CODE"]["DISPLAY_THREE_IMAGES_SLIDER"]				= PP_Three_Images_Slider::show( $data, $this ) ;
		}
		
		if ( in_array( "[THUMBNAILS_IMAGES_SLIDER]", $TMP_show_array ) )
		{
			$data["PLUGINS_CODE"]["DISPLAY_THUMBNAILS_IMAGES_SLIDER"]			= PP_Thumbnails_Images_Slider::show( $data, $this ) ;
		}
		
		if ( in_array( "[MENTORSHIP_FORM]", $TMP_show_array ) )
		{
			$data["PLUGINS_CODE"]["DISPLAY_MENTORSHIP_FORM"]					= PP_Mentorship_Form::show( $data, $this ) ;
		}
		
		if ( in_array( "[DONATE_FORM]", $TMP_show_array ) )
		{
			$data["PLUGINS_CODE"]["DISPLAY_DONATE_FORM"]						= PP_Donate_Form::show( $data, $this ) ;
		}
		if ( in_array( "[NEW_DONATE_FORM]", $TMP_show_array ) )
		{
			$data["PLUGINS_CODE"]["DISPLAY_NEW_DONATE_FORM"]						= PP_New_Donate_Form::show( $data, $this ) ;
		}

		if ( in_array( "[EVENT_FORM]", $TMP_show_array ) )
		{
			$data["PLUGINS_CODE"]["DISPLAY_EVENT_FORM"]							= PP_Events_Activities_This_Menu::show_form($data, $this, SLUG_EVENTS_ACTIVITIES, $is_simple = true);
		}
		if ( in_array( "[EVENT_FORM_CANADA]", $TMP_show_array ) )
		{
			$data["PLUGINS_CODE"]["DISPLAY_EVENT_FORM_CANADA"]							= PP_Events_Activities_This_Menu::show_form_canada($data, $this, SLUG_EVENTS_ACTIVITIES, $is_simple = true);
		}
		if ( in_array( "[EMERGENCY_ROSTER_FORM]", $TMP_show_array ) )
		{
			$data["PLUGINS_CODE"]["DISPLAY_EMERGENCY_ROSTER_FORM"]				= PP_Emergency_Roster_Form::show( $data, $this ) ;
		}
		
		if ( in_array( "[VOLUNTEER_FORM]", $TMP_show_array ) )
		{
			$data["PLUGINS_CODE"]["DISPLAY_VOLUNTEER_FORM"]						= PP_Volunteer_Form::show( $data, $this ) ;
		}
		
		if ( in_array( "[INTERNSHIP_FORM]", $TMP_show_array ) )
		{
			$data["PLUGINS_CODE"]["DISPLAY_INTERNSHIP_FORM"]					= PP_Internship_Form::show( $data, $this ) ;
		}
		
		if ( in_array( "[PRESS_RELEASES]", $TMP_show_array ) )
		{
			$data["PLUGINS_CODE"]["DISPLAY_PRESS_RELEASES"]					= PP_Press_Releases::show( $data, $this ) ;
		}
		if ( in_array( "[IMI_NEWS]", $TMP_show_array ) )
		{
			$data["PLUGINS_CODE"]["DISPLAY_IMI_NEWS"]					= PP_IMI_News::show( $data, $this ) ;
		}
		if ( in_array( "[DISCUSSION_BOARD]", $TMP_show_array ) )
		{
			
			$data["PLUGINS_CODE"]["DISPLAY_DISCUSSION_BOARD"]					= PP_IMI_Forums::show( $data, $this ) ;
		}
		if ( in_array( "[TOPIC_DETAIL]", $TMP_show_array ) )
		{
			
			$data["PLUGINS_CODE"]["DISPLAY_TOPIC_DETAIL"]					= PP_TOPIC_detail::show( $data, $this ) ;
		}
		
		if ( in_array( "[TOPIC_DETAIL]", $TMP_show_array ) )
		{
			
			$data["PLUGINS_CODE"]["DISPLAY_COMMENTS"]					= PP_COMMENTS_Detail::show( $data, $this ) ;
		}
		
		if (in_array("[SIMPLE_ACTIVITIES_THIS_MENU]", $TMP_show_array)) {
			$data["PLUGINS_CODE"]["SIMPLE_DISPLAY_ACTIVITIES_THIS_MENU"] = PP_Events_Activities_This_Menu::show($data, $this, SLUG_ACTIVITIES, $is_simple = true);
		}
		
		if (in_array("[SIMPLE_EVENTS_THIS_MENU]", $TMP_show_array)) {
			$data["PLUGINS_CODE"]["SIMPLE_DISPLAY_EVENTS_THIS_MENU"] = PP_Events_Activities_This_Menu::show($data, $this, SLUG_EVENTS, $is_simple = true);
		}
		
		if (in_array("[SIMPLE_EVENTS_ACTIVITIES_THIS_MENU]", $TMP_show_array)) {
			$data["PLUGINS_CODE"]["SIMPLE_DISPLAY_EVENTS_ACTIVITIES_THIS_MENU"] = PP_Events_Activities_This_Menu::show($data, $this, SLUG_EVENTS_ACTIVITIES, $is_simple = true);
		}
		
		if ( in_array( "[ARBAEEN_MEDICAL_MISSION_FORM]", $TMP_show_array ) )
		{
			$data["PLUGINS_CODE"]["DISPLAY_ARBAEEN_MEDICAL_MISSION_FORM"]						= PP_Arbaeen_Medical_Mission_Form::show( $data, $this ) ;
		}
		if ( in_array( "[ARBAEEN_MEDICAL_MISSION_FORM_NEW]", $TMP_show_array ) )
		{
			$data["PLUGINS_CODE"]["DISPLAY_ARBAEEN_MEDICAL_MISSION_FORM_NEW"]						= PP_Arbaeen_Medical_Mission_Form_New::show( $data, $this ) ;
		}
		if ( in_array( "[ARBAEEN_MEDICAL_MISSION_STAGE3_FORM]", $TMP_show_array ) )
		{
			$data["PLUGINS_CODE"]["DISPLAY_ARBAEEN_MEDICAL_MISSION_STAGE3_FORM"]						= PP_Arbaeen_Medical_Mission_Stage3_Form::show( $data, $this ) ;
		}
		if ( in_array( "[ARBAEEN_MEDICAL_MISSION_STAGE3B_FORM]", $TMP_show_array ) )
		{
			$data["PLUGINS_CODE"]["DISPLAY_ARBAEEN_MEDICAL_MISSION_STAGE3B_FORM"]						= PP_Arbaeen_Medical_Mission_Stage3b_Form::show( $data, $this ) ;
		}
	}
	
	
	public function checkout( &$data )
	{
		$TMP_loop_array												= array();
		if ( isset($_POST["btn_contactus_form"] ) )
		{
			$TMP_loop_array[]										= PP_Contactus_Form::index( $data, $this ) ;
		}
		
		if ( isset($_POST["btn_mentorship_form"] ) )
		{
			$TMP_loop_array[]										= PP_Mentorship_Form::index( $data, $this ) ;
		}
		
		if ( isset($_POST["btn_donate_form"] ) )
		{
			$TMP_loop_array[]										= PP_Donate_Form::index( $data, $this ) ;
		}

		if ( isset($_POST["btn_donate_form_new"] ) )
		{
			$TMP_loop_array[]										= PP_New_Donate_Form::index( $data, $this ) ;
		}
		
		if ( isset($_POST["btn_emergency_roster_form"] ) )
		{
			$TMP_loop_array[]										= PP_Emergency_Roster_Form::index( $data, $this ) ;
		}
		
		if ( isset($_POST["btn_volunteer_form"] ) )
		{
			$TMP_loop_array[]										= PP_Volunteer_Form::index( $data, $this ) ;
		}
		
		if ( isset($_POST["btn_internship_form"] ) )
		{
			$TMP_loop_array[]										= PP_Internship_Form::index( $data, $this ) ;
		}

		if ( isset($_POST["btn_arbaeen_medical_mission_form"] ) )
		{
			$TMP_loop_array[]										= PP_Arbaeen_Medical_Mission_Form::index( $data, $this ) ;
		}
		if ( isset($_POST["btn_arbaeen_medical_mission_form_new"] ) )
		{
			$TMP_loop_array[]										= PP_Arbaeen_Medical_Mission_Form_New::index( $data, $this ) ;
		}
		if ( isset($_POST["btn_arbaeen_medical_mission_stage3_form"] ) )
		{
			$TMP_loop_array[]										= PP_Arbaeen_Medical_Mission_Stage3_Form::index( $data, $this ) ;
		}
		if ( isset($_POST["btn_arbaeen_medical_mission_stage3b_form"] ) )
		{
			$TMP_loop_array[]										= PP_Arbaeen_Medical_Mission_Stage3b_Form::index( $data, $this ) ;
		}
		
		
	
		for ($i=0; $i < count( $TMP_loop_array ); $i++)
		{
			if ( $TMP_loop_array[ $i ] )
			{
				
				return TRUE;	
			}
		}
		
		return FALSE;
		
	}
}