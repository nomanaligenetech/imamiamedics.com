<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * @property MY_Session session
 * @property Functions functions
 */
class C_frontend extends C_validationcallbacks {

	public function __construct()
	{
		parent::__construct();
	
		

		if ( 1==2 and !is_localhost())
		{		
		
	
			
			$_query_string				= "";
			if ( $this->input->server('QUERY_STRING') )
			{
				$_query_string			= "?" . $this->input->server('QUERY_STRING') ;
			}
			
			
			
			$_current_page_segments		= $this->uri->rsegments;
			#print_r($_current_page_segments);die;
			
			$_switch_to_SSL				= FALSE;
			$_is_booking				= FALSE;
			if ( is_array($_current_page_segments) )
			{
				if ( count($_current_page_segments) > 0 )
				{
					switch ( TRUE )
					{
						case in_array( "rooms", $_current_page_segments ) and in_array( "resortsroomsinfo", $_current_page_segments ) and count($_current_page_segments) > 2:
							#$_switch_to_SSL		= TRUE;
							break;
							
						case in_array( "transportation", $_current_page_segments ) and in_array( "transporttype", $_current_page_segments ):
							$_switch_to_SSL		= TRUE;
							break;
							
						case in_array( "transportation", $_current_page_segments ) and in_array( "transportbooking", $_current_page_segments ):
							$_switch_to_SSL		= TRUE;
							break;
							
						case in_array( "transportation", $_current_page_segments ) and in_array( "transportccinfo", $_current_page_segments ):
							$_switch_to_SSL		= TRUE;
							break;
						
						case in_array( "rooms", $_current_page_segments ) and in_array( "booking", $_current_page_segments ):
							$_switch_to_SSL		= TRUE;
							break;
							
						case in_array( "rooms", $_current_page_segments ) and in_array( "bookingccinfo", $_current_page_segments ):
							$_switch_to_SSL		= TRUE;
							break;
							
						default:
							break;
					}
				}
			}
			
			
			if ( $_switch_to_SSL = TRUE)
			{
				
				if ( $_is_booking  and 1!=1)
				{
					#RESET currency with DEFAULT currency
					$default_currency			= $this->queries->fetch_records("site_settings_master", "", 
																			  "(SELECT csymbol FROM tb_currency WHERE currency_id = tb_site_settings_master.site_currency) as site_currency");
					
					$tmp_set['SITE_CURRENCY']	= $default_currency->row('site_currency');
					SessionHelper::_set_session($tmp_set, 'site_settings');
				}
				
				
				
				$this->config->config['base_url'] = str_replace('http://', 'https://', $this->config->config['base_url']);
				
				if ($_SERVER['SERVER_PORT'] != 443  )
				{
					redirect( site_url( uri_string() ) . $_query_string );
				}
			}
			else
			{
				
				
				$this->config->config['base_url'] = str_replace('https://', 'https//', $this->config->config['base_url']);
				
				if ($_SERVER['SERVER_PORT'] == 443  )
				{
					redirect( site_url( uri_string() ) . $_query_string );
				}
			}
			
		}	
		
		
		
		#visitor_log
		#$this->functions->visitor_log();
		$this->showThings['_show_CONF_NAVIGATION']			= TRUE;
		$this->showThings['_show_HEADER']					= TRUE;
		$this->showThings['_show_FOOTER']					= TRUE;	
		
		$this->showThings['_show_SLIDER']					= FALSE;	
		$this->showThings['_show_CONF_PARTNERS']			= FALSE;
		$this->showThings['_show_SUS_ASSOCIATE_PARTNERS']	= FALSE;
		$this->showThings['_show_PREV_CONF']				= FALSE;
		$this->showThings['_pagename']						= "";
		
		
		$this->showThings['_CSS_container']					= "";
		$this->showThings['_CSS_footer']					= "";
		$this->showThings['_CSS_show_messages']				= "";
		
		
		
		//$this->load->library('payeezy');
		

	}
	
	public function default_data_extend( &$data )
	{
		$siteIdQuery											= getSiteId();
		
		$data['content_languages'] = $this->queries->fetch_records("content_languages", " ORDER BY id DESC ")->result_array();


		$data['bigfootermenus']									= $this->queries->fetch_records('cmsmenu', 
																								" 	AND (SELECT name FROM tb_cmsmenu_positions WHERE id = tb_cmsmenu.positionid) = '". MENUPOSITION_BIGFOOTER ."' 
																									AND status = '1' AND parentid = '0' ".$siteIdQuery." ORDER BY sort ");
		
		
		$data['footermenus_parent']								= $this->queries->fetch_records('cmsmenu', 
																								" 	AND (SELECT name FROM tb_cmsmenu_positions WHERE id = tb_cmsmenu.positionid) = '". MENUPOSITION_FOOTER ."' 
																									AND status = '1' AND parentid = '0' ".$siteIdQuery." ORDER BY sort ");
		
		
		$data['footermenus_child']								= $this->queries->fetch_records('cmsmenu', 
																								" 	AND (SELECT name FROM tb_cmsmenu_positions WHERE id = tb_cmsmenu.positionid) = '". MENUPOSITION_FOOTER ."' 
																									AND status = '1' AND parentid != '0' ".$siteIdQuery." ORDER BY sort ");
		
		
		$data['header_socialbuttons']							= $this->queries->fetch_records('cmsmenu', 
																								" 	AND (SELECT name FROM tb_cmsmenu_positions WHERE id = tb_cmsmenu.positionid) = '". MENUPOSITION_HEADERSOCIALBUTTONS ."' 
																									AND status = '1' AND parentid = '0' ".$siteIdQuery." ORDER BY sort ");
		
		
		$data['footer_socialbuttons']							= $this->queries->fetch_records('cmsmenu', 
																								" 	AND (SELECT name FROM tb_cmsmenu_positions WHERE id = tb_cmsmenu.positionid) = '". MENUPOSITION_FOOTERSOCIALBUTTONS ."' 
																									AND status = '1' AND parentid = '0' ".$siteIdQuery." ORDER BY sort ");
		
		
		
		
		$data['getinvolved']									= $this->queries->fetch_records('cmsmenu', 
																								" 	AND (SELECT name FROM tb_cmsmenu_positions WHERE id = tb_cmsmenu.positionid) = '". MENUPOSITION_GETINVOLVED ."' 
																									AND status = '1' AND parentid != '0' ".$siteIdQuery." ORDER BY sort ");
		
		
		$data['getinvolved']									= $this->queries->fetch_records('cmsmenu', 
																								" 	AND (SELECT name FROM tb_cmsmenu_positions WHERE id = tb_cmsmenu.positionid) = '". MENUPOSITION_HEADER ."' 
																									AND parentid = '". SessionHelper::_get_session("GETINVOLVED_MENUID", "site_settings") ."'
																									AND status = '1' ".$siteIdQuery." ORDER BY sort");		
		
		
		
		$data['_js_timeline_history_count']						= 0;
		$data['_is_breadcrumbs']								= FALSE;


        if ($this->session->userdata('user_logged_in')) {
            if (!$this->functions->validate_if_user_is_a_paid_member(
                $this->session->userdata('user_logged_details')['id'],
                $is_membership_expired,
                $is_membership_pending_approval,
                $is_membership_rejected,
                $membership_details
            )) {
                $data['_messageBundle_not_a_paid_member'] = $this->_messageBundle(
                    'warning',
                    (
                        '<p>' .
                        (
                        $is_membership_expired ?
                            lang_line('text_membership_expired_msg') :
                            (
                            $is_membership_pending_approval ?
								lang_line('text_membership_pendingapproval_msg') :
                                (
                                $is_membership_rejected ? lang_line('text_membership_rejected_msg') : lang_line('text_membership_duespaying_msg')
                                )
                            )
                        ) .
                        (
                        $is_membership_pending_approval || $is_membership_rejected ?
                            '' :
                            (
                                ' <a href="' .
                                site_url('joinus/payment/' . $this->functions->_user_logged_in_details("id")) .
                                lang_line('text_membership_clicktojointoday')
                            )
                        ) .
                        '</p>'
                    ),
                    (
                    $is_membership_pending_approval ?
					lang_line('text_membership_pending_msg') :
                        (
                        $is_membership_rejected ?
						lang_line('text_membership_notapproved_msg') :
						lang_line('text_membership_notduepaying_msg')
                        )
                    )
                );
            } else {
                /* $data['_messageBundle_paid_membersip_details'] = $this->_messageBundle(
                    'info',
                    (
                        '<b>' .
                        'You are a paid IMI' .
                        (
                        $membership_details['package_name'] ?
                            (' ' . $membership_details['package_name']) :
                            ''
                        ) .
                        ' member.' .
                        (
                        $membership_details['expiry_date'] ?
                            (
                                ' Your membership expiry date is ' .
                                date('jS M Y', strtotime($membership_details['expiry_date'])) .
                                '.'
                            ) :
                            ''
                        ) .
                        '</b>'
                    ),
                    ''
                ); */
            }

            $data['_messageBundle_work_in_progress'] = $this->_messageBundle('info', lang_line('text_profile_welcome_msg'), '');
        }
		
		
	}
	
	public function _auth_user_id( $compare_with )
	{
		if ( $compare_with == $this->functions->_user_logged_in_details( "id" ) )
		{
			return TRUE;	
		}
		
		return FALSE;
	}
	
	public function _auth_login( $login_or_not = true, $show_msg = false, $msg_array = array() )
	{
		if ($login_or_not)
		{
			if ($this->session->userdata('user_logged_in'))
			{
				if ($show_msg)
				{
					$this->_messageBundle( $msg_array['class'] , $msg_array['msg'], $msg_array['title'], TRUE);
				}
				
				#return TRUE;
				redirect( "account/myprofile/controls/view" );
			}
			
			#return FALSE;
		}
		else
		{
			
			if (!$this->session->userdata('user_logged_in'))
			{
				if ($show_msg)
				{
					$this->_messageBundle( $msg_array['class'] , $msg_array['msg'], $msg_array['title'], FALSE, TRUE);
				}
				
				
				$tmp_lasturl		= array("last_url"		=> uri_string());
				SessionHelper::_set_session( $tmp_lasturl );
				
				redirect( "memberlogin" );
			}
		}
	}
	
	public function _create_User_Session($user_details)
	{
		/*$newdata = array('user_id'					=> $user_details['id'],
						 'user_password'  			=> $user_details['password'],
						 'user_real_name'  			=> $user_details['real_name'],
						 'user_last_name'     		=> $user_details['last_name'],
						 'user_fullname'     		=> $user_details['first_name'] . ' ' . $user_details['last_name'],
						 'user_username'     		=> $user_details['username'],
						 'user_email'     			=> $user_details['email'],
						 'user_role'     			=> $user_details['role'],
						 'user_logged_in'			=> TRUE);*/
	
		$newdata	= array("user_logged_in"				=> TRUE,
							"user_logged_details"			=> $user_details);
							
		SessionHelper::_set_session( $newdata );
	}


}
