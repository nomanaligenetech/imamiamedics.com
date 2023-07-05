<?php
class Functions
{
	function functions()
	{
		$this->CI =& get_instance();
	}

    /**
     * Returns `true` if the user is to be considered a paid member with a non-expired membership
     *
     * @param number $user_id
     * @param bool &$is_membership_expired Gets set to `true` if the user has an expired membership. The function's return value is `false` in that case.
     * @param bool &$is_membership_pending_approval Gets set to `true` if the user's membership has not yet been approved by the admin. The function's return value is `false` in that case.
     * @param bool &$is_membership_rejected Gets set to `true` if the user's membership has been rejected by the admin. The function's return value is `false` in that case.
     * @param array &$membership_details Gets set to an array containing the user's current membership details if the function returns `true`.
     * @return bool
     */
    function validate_if_user_is_a_paid_member($user_id, &$is_membership_expired = null, &$is_membership_pending_approval = null, &$is_membership_rejected = null, &$membership_details = null)
    {
		//TODO: Re-arrange the code below to check the latest membership package from (frontend ∪ conference) and only check coupon if neither is found. So, for someone who did both conference membership and frontend membership, the latest of the 2 would apply and define expiry etc.

        $coupon_code = $this->CI->imiconf_queries->fetch_records_imiconf(
            "site_settings_master",
            " ",
            "id, imi_coupon_code "
        )->row("imi_coupon_code");

        $this->CI->imiconf_queries->fetch_records_imiconf(
            "conference_registration_master",
            " AND userid = '" . $user_id . "' ",
            "id"
        ); // We are not using the result here but we ARE using a side-effect of it running: the last_query() call on the next line relies on this having been the last query run.
        $crm_query = $this->CI->db_imiconf->last_query();

        $membership_through_coupon_result = $this->CI->imiconf_queries->fetch_records_imiconf(
            "conference_registration_screen_two",
            " AND conferenceregistrationid IN (" . $crm_query . ") AND (coupon_code = '" . $coupon_code . "') "
        );
        if ($membership_through_coupon_result->num_rows() > 0) {
            $membership_details = array(
                'expiry_date' => null,
                'package_name' => 'Lifetime',
            );
            return true;
        }

        $membership_through_conference_result = $this->CI->imiconf_queries->fetch_records_imiconf(
            "conference_registration_screen_two",
            " AND conferenceregistrationid IN (" . $crm_query . ") AND (be_a_member = 1) order by date_added desc limit 1"
        );
        if ($membership_through_conference_result->num_rows() == 1) {
            $conference_prices_not_a_member_id = $membership_through_conference_result->row('be_a_member_fee');
            $membership_start_date = $membership_through_conference_result->row('date_added');
            /** @var CI_DB_mysqli_result $conference_prices_not_a_member_result */
            $conference_prices_not_a_member_result = $this->CI->db_imiconf->query(<<<EOQ
SELECT computeExpiryDate(per, ?) AS expiry_date
from tb_conference_prices_not_a_member where id = ?
EOQ
                ,
                array(
                    $membership_start_date,
                    $conference_prices_not_a_member_id,
                )
			);
            if ($conference_prices_not_a_member_result->num_rows() != 1) {
                return false;
            }
            $membership_expiry_date = $conference_prices_not_a_member_result->row('expiry_date');
            if (!$membership_expiry_date) {
                return false;
            } else {
                if (time() > strtotime($membership_expiry_date)) {
                    $is_membership_expired = true;
                    return false;
                } else {
                    // ~r(array_reverse(get_defined_vars())); //TODO: implement the check for the `is_paid_membership_approved` field in the `users` table without duplicating code.
                    // ~r(array_reverse(get_defined_vars())); // TODO: populate $membership_details
                    return true;
                }
            }
		}

        $membership_through_frontend_payment_result = $this->CI->imiconf_queries->fetch_records_imiconf(
            "users",
            " AND id = '" . $user_id . "' AND ispaid = 1 "
        );
        if ($membership_through_frontend_payment_result->num_rows() > 0) {
            $expiry_date_and_package_name_result = $this->CI->db_imiconf->query(<<<EOQ
SELECT 
	um.id,ifnull(member_expiry, computeExpiryDate(IF(um.membership_package_per IS NULL or um.membership_package_per = '', p.per, um.membership_package_per), date_purchased)) AS expiry_date,
	IF(um.membership_package_name IS NULL or um.membership_package_name = '', p.name, um.membership_package_name) as package_name,
	um.membership_package_id
FROM `tb_user_memberships` um
LEFT JOIN tb_conference_prices_not_a_member p on um.membership_package_id = p.id
WHERE `user_id` = ?
ORDER BY um.id DESC
LIMIT 1
EOQ
                ,
                array(
                    $user_id,
                )
			)->result_array();
            if (
                 (count($expiry_date_and_package_name_result) != 1) ||
                //(!isset($expiry_date_and_package_name_result[0]['expiry_date'])) ||
                false
            ) {
                return false;
            } else {
				$membership_expiry_date = $expiry_date_and_package_name_result[0]['expiry_date'];
				// if (!$membership_expiry_date) {
                //     return false;
                // } else {
                    if ( strtotime($membership_expiry_date) && time() > strtotime($membership_expiry_date) ) {
						$is_membership_expired = true;
						return false;
                    } else {
                        /** @var CI_DB_mysqli_result $membership_approval_query */
                        $membership_approval_query = $this->CI->db_imiconf->query(<<<EOQ
select is_paid_membership_approved from tb_users where id = ?
EOQ
                            ,
                            array(
                                $user_id,
                            )
                        );
                        if ($membership_approval_query->num_rows() != 1) {
                            $is_membership_pending_approval = true;
                            return false;
                        }
                        $membership_approval_row = $membership_approval_query->row_array();
                        if (!isset($membership_approval_row['is_paid_membership_approved'])) {
                            $is_membership_pending_approval = true;
                            return false;
                        }
                        switch ($membership_approval_row['is_paid_membership_approved']) {
                            case 0:
                                $is_membership_pending_approval = true;
                                return false;
                            case 1:
                                ( !strtotime($membership_expiry_date) || ( strtotime($membership_expiry_date) && strtotime($membership_expiry_date) > strtotime('now') ) );
								$membership_details = array(
									'expiry_date' => strtotime($membership_expiry_date) ? strtotime($membership_expiry_date) > strtotime('+6 years') ? null : $membership_expiry_date : null,
                                    'package_name' => $expiry_date_and_package_name_result[0]['package_name'],
                                    'membership_package_id' => $expiry_date_and_package_name_result[0]['membership_package_id']
                                );
                                return true;
                            case -1:
                                $is_membership_rejected = true;
                                return false;
                            default:
                                ~r(array_reverse(get_defined_vars()));
                                break;
                        }
                    }
                // }
            }
        }

        return false;
    }
	
	function _curl_init( $mode = "" )
	{
		switch ( $mode )
		{
			case "proxy":
				return "192.168.14.114";
				break;
				
			case "port":
				return "3128";
				break;
				
			default:
				return "";
				break;
		}
	}
		
	function formatSizeUnits($bytes)
	{
		if ($bytes >= 1073741824)
		{
			$bytes				= number_format($bytes / 1073741824, 2) . ' GB';
		}
		elseif ($bytes >= 1048576)
		{
			$bytes				= number_format($bytes / 1048576, 2) . ' MB';
		}
		elseif ($bytes >= 1024)
		{
			$bytes 				= number_format($bytes / 1024, 2) . ' KB';
		}
		elseif ($bytes > 1)
		{
			$bytes 				= $bytes . ' bytes';
		}
		elseif ($bytes == 1)
		{
			$bytes 				= $bytes . ' byte';
		}
		else
		{
			$bytes 				= '0 bytes';
		}
		
		return $bytes;
	}

	function retrieve_remote_file_size($url)
	{
		$ch = curl_init($url);
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, TRUE);
		curl_setopt($ch, CURLOPT_NOBODY, TRUE);
		
		curl_setopt($ch, CURLOPT_PROXY,              $this->_curl_init("proxy"));         
		curl_setopt($ch, CURLOPT_PROXYPORT,          $this->_curl_init("port"));
				
		
		curl_exec($ch);
		$status 									= curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
		$httpcode									= $status;
		
		curl_close($ch);
		return $status;
	}
		
		
		
	function _user_logged_in_details( $return_col = '' )
	{
		$this->CI =& get_instance();
		
		if ($this->CI->session->userdata('user_logged_in'))
		{
	
			return $this->CI->session->userdata['user_logged_details'][ $return_col ];
		}
		
		return 0;
	}
	
	
	function _admincms_logged_in_details( $return_col = '' )
	{
		$this->CI =& get_instance();
		
		if ($this->CI->session->userdata('admincms_logged_in'))
		{
	
			return $this->CI->session->userdata['admincms_logged_details'][ $return_col ];
		}
		
		return 0;
	}
	
	
	public function search_array($array, $index, $index_val, $tofind)
	{
		$results 	= array();
		$myval		= FALSE;
		
		if (is_array($array))
		{
				
				foreach ($array as $key => $value)
				{
					
					if (is_array($value))
					{
						if($value[$index] == $index_val)
						{
							$myval	= $value[$tofind];	
						}
					}
				}
		}
		
		return $myval;
	}
	
	
	function find_array_count( $post_array, $db_array )
	{
		if ( isset( $post_array ) )
		{
			
			return count( $post_array );	
		}
		else
		{
			return count( $db_array );
		}
	}
	
	
	/*$loop_with
	1- if FALSE - than it will only check single values (without array)
	2- if any array passed it will loop thru that array
	3- if empty array passed than it will loop thru language array
	*/
	function unite_post_values_form_validation( $loop_with = array(), $field = "id", $field2 = "description" )
	{
		if ( count($loop_with) > 0 )
		{
			$languages				= $loop_with;
		}
		else if ( !$loop_with and !is_array($loop_with) )
		{
			$languages				= FALSE;
		}
		else
		{
			$languages				= $this->CI->data["languages"];
		}
		
		
		$languages					= FALSE;
		
		foreach ( $_POST as $key => $value )
		{
			
			if ( is_array ( $value ) and $languages ) 
			{			
				for($a=0; $a < sizeof( $languages ); $a++) 
				{		
					$this->CI->form_validation->set_rules( $key . "[" . $languages[$a][ $field ] . "]", 	"$key (". $languages[$a][ $field2 ] . ")","trim");
				}
			}
			else if ( is_array ( $value ) )
			{
				
				$this->CI->form_validation->set_rules($key . "[]", $key ,"trim");
			}
			else
			{
				$this->CI->form_validation->set_rules($key, $key ,"trim");
			}
		}	
	}
	
	function timthumb($image_name = '', $width = '', $height = '', $other_param = '', $return_image = TRUE, $popup = FALSE, $base_url_type = FALSE)
	{
		
		
		$img_size						= "";
		
		if ($width != '')
		{
			$img_size		.= '&w=' . $width;
		}
		
		if ($height != '')
		{
			$img_size		.= '&h=' . $height;
		}
		
		$img_size						.= $other_param;
		
		
		
		switch ( $base_url_type )
		{
			case "imiconf":
				$fullimage_path					= imiconf_base_url( 'assets/widgets/timthumb.php?src=' . imiconf_base_url( $image_name ) . $img_size  );	
				break;
			
			default:
				$fullimage_path					= base_url( 'assets/widgets/timthumb.php?src=' . base_url( $image_name ) . $img_size  );	
				break;
		}
		
	
		$onclick_runtime				= "";
		if ( $popup )
		{
			#". $image_name ."
			$onclick_runtime			= 'onclick="_runtimePopup(\'modalImage\', \''. $fullimage_path .'\');" ';
			$fullimage_path				= "javascript:;";
		}
		
		if ($return_image)
		{
			return "<img ". $onclick_runtime ." src='" . $fullimage_path . "' />";
		}
		else
		{
			return $fullimage_path ;
			/*return 	"<a ". $onclick_runtime ." href='" . $fullimage_path . "'>"
					
					. $image_name .
					
					"</a>";*/
		}
	}
	
	
	function imiconf_timthumb($image_name = '', $width = '', $height = '', $other_param = '', $return_image = TRUE, $popup = FALSE)
	{
		return $this->timthumb($image_name, $width, $height, $other_param, $return_image, $popup, "imiconf");
	}
	
	function formatTree($tree, $parent)
	{
		$tree2 = array();
		foreach($tree as $i => $item)
		{
			if($item['parentid'] == $parent)
			{
				$tree2[$item['id']] = $item;
				$tree2[$item['id']]['submenu'] 		= $this->formatTree($tree, $item['id']);
			}
		}
	
		return $tree2;
	}
	
	
	function footermenunavigation()
	{
		
		$TMP_menus					= $this->CI->mixed_queries->fetch_records("cmsmenu", " AND  positionid  = '2' AND status = '1'  ");
		$TMP_array					= $this->formatTree( $TMP_menus ->result_array(), 0);
		
		$footer_navigation_menus		= array();
		foreach ($TMP_menus->result_array() as $TMP)
		{
			$TMP_content					= $this->CI->mixed_queries->fetch_records("cmscontent", " AND  menuid = '". $TMP['id'] ."' ");	
			
			if ( $TMP['type_name'] == "content" )
			{
				$href						= site_url( "page/" . $TMP['slug'] );
				if ( $TMP_content->num_rows() <= 0 and 1!=1)
				{
					$href						= "javascript:;";
				}		
			}
			else if ( $TMP_content->num_rows() > 0 )
			{
				
				if ( $TMP['type_name'] == "url_internal" )
				{
					$href						= site_url( $TMP_content->row('content') );
				}
				else
				{
					$href						= $TMP_content->row('content');	
				}
			}
			else
			{
				$href						= "javascript:;";
			}
			
			$footer_navigation_menus[]			= array("href"				=> $href,
														"target"			=> $TMP['target'],
														"name"				=> $TMP['name']);
			
		}
		
		
		return $footer_navigation_menus;
		
	}
	
	
	
	function getchild_navigation( $TMP = array(), $slug = '' )
	{
		$TMP_content					= $this->CI->mixed_queries->fetch_records("cmscontent", " AND  menuid = '". $TMP['id'] ."' ");	
		
		$login_required					= array(18);
		
		
		
		$TMP_attributes					= $this->set_link_attributes( $TMP, $TMP_content, $slug );
		
		
		return $TMP_attributes['href'];
	}
	
	
	function set_link_attributes( $TMP = array(), $TMP_content = FALSE, $append_slug = FALSE )
	{
		if ( $append_slug )
		{
			$append_slug			.= "/";	
		}
		
		
		
		
		if ( $TMP['type_name'] == "content" )
		{
			
			$href							= site_url( $append_slug .  $TMP['slug'] );
		
		}
		else if ( $TMP_content->num_rows() > 0 )
		{
			
			if ( $TMP['type_name'] == "url_internal" )
			{
				$href						= site_url( $TMP_content->row('content') );
			}
			else
			{
				$href						= $TMP_content->row('content');	
			}
			
		}
		else
		{
			$href						= "javascript:;";
		}
		
		
		
		$short_desc						= FALSE;
		$content						= FALSE;
		if ( $TMP_content->num_rows() > 0 )
		{
			$short_desc					= $TMP_content->row('short_desc') ;
			$content					= $TMP_content->row('content') ;
		}
		
		return array("href"			=> $href,
					 "target"		=> $TMP['target'],
					 "name"			=> $TMP['name'],
					 "short_desc"	=> $short_desc,
					 "content"		=> $content);
	}
	

	function topmenunavigation($content_languages)
	{			
		$siteIdQuery				= getSiteId();
		$TMP_menus					= $this->CI->mixed_queries->fetch_records("cmsmenu", " AND  positionid  = '1' AND parentid = '0' AND status = '1' ".$siteIdQuery." ORDER BY sort ASC  ");
		
		$TMP_array					= $this->formatTree( $TMP_menus ->result_array(), 0);
		
		$top_navigation_menus		= array();
		$append_slug				= "page";
		foreach ($TMP_menus->result_array() as &$TMP)
		{
			$cmsmenu_languages = $this->CI->mixed_queries->fetch_records("cmsmenu_languages", " AND cmsmenu_id = {$TMP['id']}")->result_array();
			replace_data_for_lang($TMP, $content_languages, $cmsmenu_languages, ['name','subheading'], SessionHelper::_get_session('LANG_CODE') );

			$TMP_content					= $this->CI->mixed_queries->fetch_records("cmscontent", " AND  menuid = '". $TMP['id'] ."' ");	
			
			$TMP_attributes					= $this->set_link_attributes( $TMP, $TMP_content, $append_slug );
			
			
			$href							= $TMP_attributes['href'];
		
			
			
			
			
			
			$is_child						= array();
			$TMP_child_menus				= $this->CI->mixed_queries->fetch_records("cmsmenu", " AND  parentid = '". $TMP['id'] ."' AND status = '1' ".$siteIdQuery." ORDER BY sort ASC");
			$count							= 0;
			if ( $TMP_child_menus->num_rows() > 0 )
			{
				foreach ($TMP_child_menus->result_array() as $TMP_child)
				{
					$cmsmenu1_languages = $this->CI->mixed_queries->fetch_records("cmsmenu_languages", " AND cmsmenu_id = {$TMP_child['id']}")->result_array();
					replace_data_for_lang($TMP_child, $content_languages, $cmsmenu1_languages, ['name','subheading'], SessionHelper::_get_session('LANG_CODE') );
					
					$is_child[ $count ]		= array("href"				=> $this->getchild_navigation( $TMP_child, $append_slug),
													"target"			=> $TMP_child['target'],
													"name"				=> $TMP_child['name']);
					
					
					
					$TMP_sub_child_menus	= $this->CI->mixed_queries->fetch_records("cmsmenu", " AND  parentid = '". $TMP_child['id'] ."' AND status = '1' ".$siteIdQuery." ORDER BY sort ASC");
					$is_sub_child			= array();
					$count_sub_child		= 0;
					if ( $TMP_sub_child_menus->num_rows() > 0 )
					{
						foreach ($TMP_sub_child_menus->result_array() as $TMP_sub_child)
						{
							$cmsmenu2_languages = $this->CI->mixed_queries->fetch_records("cmsmenu_languages", " AND cmsmenu_id = {$TMP_sub_child['id']}")->result_array();
							replace_data_for_lang($TMP_sub_child, $content_languages, $cmsmenu2_languages, ['name','subheading'], SessionHelper::_get_session('LANG_CODE') );

							$is_sub_child[ $count_sub_child ]			= array("href"				=> $this->getchild_navigation( $TMP_sub_child, $append_slug),
																				"target"			=> $TMP_sub_child['target'],
																				"name"				=> $TMP_sub_child['name']);
							
							
							
							
							#### SUB 3 MENUS ####
							$count_sub_3_child			= 0;
							$is_sub_3_child				= array();
							$TMP_sub_3_child_menus		= $this->CI->mixed_queries->fetch_records("cmsmenu", 
																								  " AND  parentid = '". $TMP_sub_child['id'] ."' AND status = '1' ".$siteIdQuery." ORDER BY sort ASC");
							if ( $TMP_sub_3_child_menus->num_rows() > 0 )
							{
								
								foreach ($TMP_sub_3_child_menus->result_array() as $TMP_sub_3_child)
								{
									$cmsmenu3_languages = $this->CI->mixed_queries->fetch_records("cmsmenu_languages", " AND cmsmenu_id = {$TMP_sub_3_child['id']}")->result_array();
									replace_data_for_lang($TMP_sub_3_child, $content_languages, $cmsmenu3_languages, ['name','subheading'], SessionHelper::_get_session('LANG_CODE') );

									$is_sub_3_child[ $count_sub_3_child ]		= array("href"				=> $this->getchild_navigation( $TMP_sub_3_child, $append_slug),
																						"target"			=> $TMP_sub_3_child['target'],
																						"name"				=> $TMP_sub_3_child['name']);
									
									
									
									
									
									#### SUB 4 MENUS ####
									$count_sub_4_child			= 0;
									$is_sub_4_child				= array();
									$TMP_sub_4_child_menus		= $this->CI->mixed_queries->fetch_records("cmsmenu", 
																										  " AND  parentid = '". $TMP_sub_3_child['id'] ."' AND status = '1' ".$siteIdQuery." ORDER BY sort ASC");
									if ( $TMP_sub_4_child_menus->num_rows() > 0 )
									{
										
										foreach ($TMP_sub_4_child_menus->result_array() as $TMP_sub_4_child)
										{
											$cmsmenu4_languages = $this->CI->mixed_queries->fetch_records("cmsmenu_languages", " AND cmsmenu_id = {$TMP_sub_4_child['id']}")->result_array();
											replace_data_for_lang($TMP_sub_4_child, $content_languages, $cmsmenu4_languages, ['name','subheading'], SessionHelper::_get_session('LANG_CODE') );
		
											$is_sub_4_child[ $count_sub_4_child ]			= array("href"				=> $this->getchild_navigation( $TMP_sub_4_child, $append_slug),
																									"target"			=> $TMP_sub_4_child['target'],
																									"name"				=> $TMP_sub_4_child['name']);
											
											
											
											
											
											
											#### SUB 4 MENUS ####
											$is_sub_5_child				= array();
											$TMP_sub_5_child_menus		= $this->CI->mixed_queries->fetch_records("cmsmenu", 
																												  " AND  parentid = '". $TMP_sub_4_child['id'] ."' AND status = '1' ".$siteIdQuery." ORDER BY sort ASC");
											if ( $TMP_sub_5_child_menus->num_rows() > 0 )
											{
												foreach ($TMP_sub_5_child_menus->result_array() as $TMP_sub_5_child)
												{
													$cmsmenu5_languages = $this->CI->mixed_queries->fetch_records("cmsmenu_languages", " AND cmsmenu_id = {$TMP_sub_5_child['id']}")->result_array();
													replace_data_for_lang($TMP_sub_5_child, $content_languages, $cmsmenu5_languages, ['name','subheading'], SessionHelper::_get_session('LANG_CODE') );
				
													$is_sub_5_child[]			= array("href"				=> $this->getchild_navigation( $TMP_sub_5_child, $append_slug),
																						"target"			=> $TMP_sub_5_child['target'],
																						"name"				=> $TMP_sub_5_child['name']);
												}
											}
											#### SUB 4 MENUS ####
											
											
											
											$is_sub_4_child[ $count_sub_4_child ]['is_child']	= $is_sub_5_child;
											$count_sub_4_child++;
									
											
										}
									}
									#### SUB 4 MENUS ####
									
									
									
									$is_sub_3_child[ $count_sub_3_child ]['is_child']	= $is_sub_4_child;
									$count_sub_3_child++;
									
									
								}
							}
							#### SUB 3 MENUS ####
							
							
							
							$is_sub_child[ $count_sub_child ]['is_child']	= $is_sub_3_child;
							$count_sub_child++;
						}
						
					}
					
					
					$is_child[ $count ]['is_child']	= $is_sub_child;					
					$count++;
			
				}
				
			}
			
			
			
			$top_navigation_menus[]			= array("href"				=> $href,
													"target"			=> $TMP['target'],
													"name"				=> $TMP['name'],
													"is_child"			=> $is_child);
			
		}
	
		
		return $top_navigation_menus;
	}
	

	function runtime_image($image_name = '', $width = '', $height = '', $return_image = TRUE, $popup = FALSE)
	{
		$img_size						= "";
		
		if ($width != '')
		{
			$img_size		.= '&w=' . $width;
		}
		
		if ($height != '')
		{
			$img_size		.= '&h=' . $height;
		}
		
		
		$fullimage_path					= base_url( 'assets/widgets/timthumb.php?src=' . base_url( $image_name ) . $img_size  );
		$onclick_runtime				= "";
		if ( $popup )
		{
			#". $image_name ."
			$onclick_runtime			= 'onclick="_runtimePopup(\'modalImage\', \''. $fullimage_path .'\');" ';
			$fullimage_path				= "javascript:;";
		}
		
		if ($return_image)
		{
			return "<img ". $onclick_runtime ." src='" . $fullimage_path . "' />";
		}
		else
		{
			return 	"<a ". $onclick_runtime ." href='" . $fullimage_path . "'>"
					
					. $image_name .
					
					"</a>";
		}
	}
	
	function runtime_video($image_name = '', $show_as_link = FALSE, $popup = FALSE)
	{

		
		$fullimage_path					= $image_name ;
		$onclick_runtime				= "";
		
		if ( $popup )
		{
			#". $image_name ."
			$onclick_runtime			= 'onclick="_runtimePopup(\'modalVideo\', \''. $fullimage_path .'\');" ';
			$fullimage_path				= "javascript:;";
		}
		
		if ( $show_as_link )
		{
			return 	"<a ". $onclick_runtime ." href='" . $fullimage_path . "'>"
					
					. $image_name .
					
					"</a>";
		}
		else
		{
			return  $image_name;	
		}
	}
	
	function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) 
	{
		$output = NULL;
		if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
			$ip = $_SERVER["REMOTE_ADDR"];
			if ($deep_detect) 
			{
				if ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) )
				{
					if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
					{
						$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
					}
				}
				
				if ( isset( $_SERVER['HTTP_CLIENT_IP'] ) )
				{
					if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
					{
						$ip = $_SERVER['HTTP_CLIENT_IP'];
					}	
				}
				
			}
		}
		
		
		if ( $purpose == "ip")
		{
			return $ip;
		}
		
		$purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
		$support    = array("country", "countrycode", "state", "region", "city", "location", "address");
		$continents = array(
			"AF" => "Africa",
			"AN" => "Antarctica",
			"AS" => "Asia",
			"EU" => "Europe",
			"OC" => "Australia (Oceania)",
			"NA" => "North America",
			"SA" => "South America"
		);
		if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
			$ipdat = @json_decode(_file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
			if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
				switch ($purpose) {
					case "location":
						$output = array(
							"city"           => @$ipdat->geoplugin_city,
							"state"          => @$ipdat->geoplugin_regionName,
							"country"        => @$ipdat->geoplugin_countryName,
							"country_code"   => @$ipdat->geoplugin_countryCode,
							"continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
							"continent_code" => @$ipdat->geoplugin_continentCode
						);
						break;
					case "address":
						$address = array($ipdat->geoplugin_countryName);
						if (@strlen($ipdat->geoplugin_regionName) >= 1)
							$address[] = $ipdat->geoplugin_regionName;
						if (@strlen($ipdat->geoplugin_city) >= 1)
							$address[] = $ipdat->geoplugin_city;
						$output = implode(", ", array_reverse($address));
						break;
					case "city":
						$output = @$ipdat->geoplugin_city;
						break;
					case "state":
						$output = @$ipdat->geoplugin_regionName;
						break;
					case "region":
						$output = @$ipdat->geoplugin_regionName;
						break;
					case "country":
						$output = @$ipdat->geoplugin_countryName;
						break;
					case "countrycode":
						$output = @$ipdat->geoplugin_countryCode;
						break;
				}
			}
		}
		return $output;
	}

	
	function visitor_log()
	{
		$visitor_ip					= $this->ip_info(NULL, "ip");
		
		$session_id					= SessionHelper::_get_session("session_id");
		$visitor_registered			= $this->CI->queries->fetch_records('visitorlog', ' AND ipaddress = "'. $visitor_ip .'" AND sessionid = "'. $session_id .'"' ); 
		if ( $visitor_registered->num_rows() <= 0 )
		{
			$tmp_visitor_registered			= array("ipaddress"			=> $visitor_ip,
													"sessionid"			=> $session_id);
			
			$this->CI->queries->SaveDeleteTables($tmp_visitor_registered, 's', "tb_visitorlog", 'id');
		}	
	}
	
	function is_serialized($value, &$result = null)
	{
		if ( 1==1 )
		{
					// Bit of a give away this one
					if (!is_string($value))
					{
						return false;
					}
					 
					// Serialized false, return true. unserialize() returns false on an
					// invalid string or it could return false if the string is serialized
					// false, eliminate that possibility.
					if ($value === 'b:0;')
					{
						$result = false;
						return true;
					}
					 
					$length	= strlen($value);
					$end	= '';
					
			
					switch ($value[0])
					{
						case 's':
						if ($value[$length - 2] !== '"')
						{
							return false;
						}
						case 'b':
						case 'i':
						case 'd':
						// This looks odd but it is quicker than isset()ing
						$end .= ';';
						case 'a':
						case 'O':
						$end .= '}';
					 
						if ($value[1] !== ':')
						{
							return false;
						}
					 
						switch ($value[2])
						{
							case 0:
							case 1:
							case 2:
							case 3:
							case 4:
							case 5:
							case 6:
							case 7:
							case 8:
							case 9:
							break;
							 
							default:
							return false;
						}
					
						case 'N':
						$end .= ';';
						 
						if ($value[$length - 1] !== $end[0])
						{
							return false;
						}
						break;
						 
						default:
						return false;
					}
				 
					if (($result = @unserialize($value)) === false)
					{
						$result = null;
						return false;
					}
					return true;
		}
	}
	
	
	
	
	public function indexx( $data )
	{
		
		$TMP_loop_array												= array();
		if ( isset($_POST["btn_feedback"] ) )
		{
			include_once(APPPATH.'controllers/page_right/feedback.php');
			$TMP_loop_array[]										=  Feedback::index( $site_mode_url, $data) ;
			
		}
		
		if ( isset($_POST["btn_enrolled_other_invitation_key"] ) )
		{
			include_once(APPPATH.'controllers/page_right/enrolled_invitationkey.php');
			$TMP_loop_array[]										=  Enrolled_InvitationKey::index( $site_mode_url, $data) ;
			
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
	
	
	
	/*array("shortcode"			=> "",
			"replacedvalue"		=> "");*/
	function content_shortcodes( $content = FALSE, $PLUGINS_CODE = FALSE, $return_short_codes = FALSE )
	{
		#$this->CI->load->library( '../controllers/cms/page_widgets' );
		
		$TMP_shortcodes[]				= array("shortcode"				=> "[CONTACTUS_FORM]",
												"replacedvalue"			=> $PLUGINS_CODE['DISPLAY_CONTACTUS_FORM']);
		
			
		$TMP_shortcodes[]				= array("shortcode"				=> "[DURATION_DATE_CURRENT_CONFERENCE]",
												"replacedvalue"			=> "" );
		
		$TMP_shortcodes[]				= array("shortcode"				=> "[CHAPTER_THIS_LOCATION]",
												"replacedvalue"			=> $PLUGINS_CODE['DISPLAY_CHAPTER_THIS_LOCATION']);
		
		$TMP_shortcodes[]				= array("shortcode"				=> "[WHERE_WE_WORK_WORLD_MAP]",
												"replacedvalue"			=> $PLUGINS_CODE['DISPLAY_WHERE_WE_WORK_WORLD_MAP']);
		
		
		
		
		
		$TMP_shortcodes[]				= array("shortcode"				=> "[ACTIVITIES_THIS_MENU]",
												"replacedvalue"			=> $PLUGINS_CODE['DISPLAY_ACTIVITIES_THIS_MENU']);
		
		$TMP_shortcodes[]				= array("shortcode"				=> "[EVENTS_THIS_MENU]",
												"replacedvalue"			=> $PLUGINS_CODE['DISPLAY_EVENTS_THIS_MENU']);
		
		$TMP_shortcodes[]				= array("shortcode"				=> "[EVENTS_ACTIVITIES_THIS_MENU]",
												"replacedvalue"			=> $PLUGINS_CODE['DISPLAY_EVENTS_ACTIVITIES_THIS_MENU']);
		
		$TMP_shortcodes[]				= array("shortcode"				=> "[EVENTS_ACTIVITIES_MENUS_LIST_ALL]",
												"replacedvalue"			=> $PLUGINS_CODE['DISPLAY_EVENTS_ACTIVITIES_MENUS_LIST_ALL']);
		
		
		
		
		
		$TMP_shortcodes[]				= array("shortcode"				=> "[THREE_IMAGES_SLIDER]",
												"replacedvalue"			=> $PLUGINS_CODE['DISPLAY_THREE_IMAGES_SLIDER']);
		
		$TMP_shortcodes[]				= array("shortcode"				=> "[THUMBNAILS_IMAGES_SLIDER]",
												"replacedvalue"			=> $PLUGINS_CODE['DISPLAY_THUMBNAILS_IMAGES_SLIDER']);
		
		$TMP_shortcodes[]				= array("shortcode"				=> "[MENTORSHIP_FORM]",
												"replacedvalue"			=> $PLUGINS_CODE['DISPLAY_MENTORSHIP_FORM']);
		
		$TMP_shortcodes[]				= array("shortcode"				=> "[DONATE_FORM]",
												"replacedvalue"			=> $PLUGINS_CODE['DISPLAY_DONATE_FORM']);
		$TMP_shortcodes[]				= array("shortcode"				=> "[NEW_DONATE_FORM]",
												"replacedvalue"			=> $PLUGINS_CODE['DISPLAY_NEW_DONATE_FORM']);

		$TMP_shortcodes[]				= array("shortcode"				=> "[EVENT_FORM]",
												"replacedvalue"			=> $PLUGINS_CODE['DISPLAY_EVENT_FORM']);										
												$TMP_shortcodes[]				= array("shortcode"				=> "[EVENT_FORM_CANADA]",
												"replacedvalue"			=> $PLUGINS_CODE['DISPLAY_EVENT_FORM_CANADA']);										
		$TMP_shortcodes[]				= array("shortcode"				=> "[EMERGENCY_ROSTER_FORM]",
												"replacedvalue"			=> $PLUGINS_CODE['DISPLAY_EMERGENCY_ROSTER_FORM']);
		
		$TMP_shortcodes[]				= array("shortcode"				=> "[VOLUNTEER_FORM]",
												"replacedvalue"			=> $PLUGINS_CODE['DISPLAY_VOLUNTEER_FORM']);
		
		$TMP_shortcodes[]				= array("shortcode"				=> "[INTERNSHIP_FORM]",
												"replacedvalue"			=> $PLUGINS_CODE['DISPLAY_INTERNSHIP_FORM']);
		
		
		$TMP_shortcodes[]				= array("shortcode"				=> "[PRESS_RELEASES]",
												"replacedvalue"			=> $PLUGINS_CODE['DISPLAY_PRESS_RELEASES']);

		$TMP_shortcodes[]				= array("shortcode"				=> "[IMI_NEWS]",
												"replacedvalue"			=> $PLUGINS_CODE['DISPLAY_IMI_NEWS']);
		
		
		$TMP_shortcodes[]				= array("shortcode"				=> "[DISCUSSION_BOARD]",
												"replacedvalue"			=> $PLUGINS_CODE['DISPLAY_DISCUSSION_BOARD']);
		
		
		
		
		
		$TMP_shortcodes[]				= array("shortcode"				=> "[BASE_URL]",
												"replacedvalue"			=> base_url() );

		$TMP_shortcodes[]				= array("shortcode"				=> "[SIMPLE_ACTIVITIES_THIS_MENU]",
												"replacedvalue"			=> $PLUGINS_CODE['SIMPLE_DISPLAY_ACTIVITIES_THIS_MENU']);
		
		$TMP_shortcodes[]				= array("shortcode"				=> "[SIMPLE_EVENTS_THIS_MENU]",
												"replacedvalue"			=> $PLUGINS_CODE['SIMPLE_DISPLAY_EVENTS_THIS_MENU']);
		
		$TMP_shortcodes[]				= array("shortcode"				=> "[SIMPLE_EVENTS_ACTIVITIES_THIS_MENU]",
												"replacedvalue"			=> $PLUGINS_CODE['SIMPLE_DISPLAY_EVENTS_ACTIVITIES_THIS_MENU']);

		$TMP_shortcodes[]				= array("shortcode"				=> "[ARBAEEN_MEDICAL_MISSION_FORM]",
												"replacedvalue"			=> $PLUGINS_CODE['DISPLAY_ARBAEEN_MEDICAL_MISSION_FORM']);

		$TMP_shortcodes[]				= array("shortcode"				=> "[ARBAEEN_MEDICAL_MISSION_FORM_NEW]",
												"replacedvalue"			=> $PLUGINS_CODE['DISPLAY_ARBAEEN_MEDICAL_MISSION_FORM_NEW']);										
		
		$TMP_shortcodes[]				= array("shortcode"				=> "[ARBAEEN_MEDICAL_MISSION_STAGE3_FORM]",
												"replacedvalue"			=> $PLUGINS_CODE['DISPLAY_ARBAEEN_MEDICAL_MISSION_STAGE3_FORM']);

		$TMP_shortcodes[]				= array("shortcode"				=> "[ARBAEEN_MEDICAL_MISSION_STAGE3B_FORM]",
												"replacedvalue"			=> $PLUGINS_CODE['DISPLAY_ARBAEEN_MEDICAL_MISSION_STAGE3B_FORM']);

		
		if ( $content )
		{
			foreach ( $TMP_shortcodes as $key => $value )
			{
				$content			= str_replace($value["shortcode"], $value["replacedvalue"], $content );	
			}
		}
		
		
		if ( $return_short_codes )
		{ 
			return $TMP_shortcodes;
		}
		else
		{
			return $content;
		}
	}
	
	
	
	
	function sortArrayByArray($array = array(), $orderArray = array(), $orderArray_Key = FALSE)
	{
		$TMP_new_orderarray		= array();
		if ( !$orderArray_Key )
		{
			foreach($orderArray as $key => $value )
			{
				$TMP_new_orderarray[]		= $key;	
			}
		}
		else
		{
			for( $x=0; $x < count( $orderArray ); $x++ )
			{
				$TMP_new_orderarray[]		= $orderArray[$x][ $orderArray_Key ];
			}
		}
		$orderArray				= $TMP_new_orderarray;
		#print_r($orderArray	);die;
		
		
		
		$ordered			= array();
		foreach($orderArray as $key) 
		{
			if(array_key_exists($key,$array)) 
			{
				$ordered[$key]			= $array[$key];
				unset($array[$key]);
			}
		}
		
		return $ordered + $array;
	}
	
	
	
	function days_between_dates( $start, $end )
	{
		$now 							= strtotime( date("Y-m-d", strtotime( $start )) ); // or your date as well
		$your_date 						= strtotime( date("Y-m-d", strtotime( $end )) );
		$datediff 						= $your_date - $now;
		return $data['TMP_no_of_days']	= floor($datediff/(60*60*24));
	}
	
	function minutes_between_dates( $to_time, $from_time )
	{
		return round(abs($to_time - $from_time) / 60,2). " minute";
	}
	
	
	function nested_three_images_slider( $sliderdetails, $key = FALSE, &$out = array(), $max_display = 3, $count = 0 )
	{
		
		if ( count($sliderdetails) > 0 )
		{
			foreach ( $sliderdetails as $pconf)
			{
				$count++;
				
				
				$out[]				= $pconf[ $key ];
				
			}	
			
			
	
			if ( $count <= $max_display )
			{
				$this->nested_three_images_slider( $sliderdetails, $key, $out, $max_display, $count );
			}	
		}
		
	}

	function find_and_replace( $find_value_case, $replace_value, $original_text, $external_find_value = FALSE )
	{
		$case[0]				= array("Imamia Medics International", "Imamia Medics International (IMI)", /*"(IMI's)", "(IMIs)", "(IMI)", "IMI&rsquo;s", "IMI's", "IMIs", "IMI"*/);
		//$case[1]				= array("Imamia");
		//$case[2]				= array("imisilverjubilee@gmail.com","imisilverjubilee@att.net", "noreply@imamiamedics.com");

		

		if ( array_key_exists($find_value_case, $case) )
		{
			
			foreach ( $case[$find_value_case] as $key => $find_text)
			{
				if($find_value_case == 2)
				{
					$original_text			= @str_replace($find_text, $replace_value[$key], $original_text);
				} 
				else 
				{
					$original_text			= @str_replace($find_text, $replace_value, $original_text);
				}
			}
		}
		else if ( is_array($external_find_value) ) 
		{
			foreach ($external_find_value as $find_text)
			{
				$original_text			= str_replace($find_text, $replace_value, $original_text);
			}
		}
		else if ( $external_find_value != "" )
		{
			
			$original_text			= str_replace($external_find_value, $replace_value, $original_text);	
		}
		
		return $original_text;
	}

	function replace_img_by_lang( $imgwithpath)
	{
		$explodedimg = explode("/",$imgwithpath);
		$img = str_replace(".","_" . strtolower(SessionHelper::_get_session('LANG_CODE')) . ".", $explodedimg[count($explodedimg)-1]);
		$explodedimg[count($explodedimg)-1] = $img;
		$file = implode("/", $explodedimg);
		clearstatcache();
		return file_exists($file)?$file:$imgwithpath;
	}
	/* function dump_receipt_data($ci){
		$all_receipts	= $ci->db->query("SELECT id,tax_receipt_num,belongs_country FROM `tb_donation_form` WHERE tax_receipt_num != ''")->result_array();
		foreach($all_receipts as $receipt){
			$dataForReceipt	= array();
			$dataForReceipt['receipt_number']	= $receipt['tax_receipt_num'];
			$dataForReceipt['receipt_prefix']	= ($receipt['belongs_country'] == '3') ? 'C' : 'A';
			$dataForReceipt['table_name']		= 'tb_donation_form';
			$dataForReceipt['table_id_name']	= 'id';
			$dataForReceipt['table_id_value']	= $receipt['id'];

			$ci->queries->SaveDeleteTables($dataForReceipt, 's', "tb_payment_receipts", 'id');
		}
	} */
	function send_tax_receipt($df_id, $ci, $is_recurring=false){

		// pdfwork start			
		$TMP_receipt	= $ci->db->query("SELECT df.*, dcc.comment as comments, dpp.name as dpdesc, dc.name as home_city_name, ds.name as home_state_name FROM tb_donation_form df LEFT JOIN `tb_dc_comments` dcc ON df.id = dcc.df_id LEFT JOIN tb_donation_projects dpp ON dpp.id = df.donation_projects_id LEFT JOIN tb_cities dc ON dc.id = df.home_city LEFT JOIN tb_states ds ON ds.id = df.home_state WHERE df.id = '". $df_id ."' ");	
		$_POST['donation_details']['first_name'] = isset($TMP_receipt->row()->first_name) ? $TMP_receipt->row()->first_name : '';
		if( $TMP_receipt->num_rows() > 0 && ($TMP_receipt->row()->belongs_country == '2' || $TMP_receipt->row()->belongs_country == '3') )
		{

			$belongs_to  = $TMP_receipt->row()->belongs_country; // belongs country
			// canada
			if($belongs_to == '3'){
				$receipt_pdf 	= "receipts/canada.php";
				$receipt_email 	= "email/frontend/donate_receipt_canada.php";
				$email_subject	= "Your Tax Receipt for the donation made to Imamia Canada";
				$receipt_prefix = 'C';
				$email_bcc		= array("drsyahaider@yahoo.ca","mali.kermali@outlook.com","imamiacanada@gmail.com","neelam.raheel@genetechsolutions.com");
			}
			// international
			elseif($belongs_to == '4'){
				$receipt_pdf 	= "receipts/medics-international.php";
				$receipt_email 	= "email/frontend/donate_receipt_medics.php";
				$receipt_prefix = 'MI';
				$email_subject	= "Your Tax Receipt for the donation made to Medics International";				
				$email_bcc		= array("imifinance786@gmail.com" ,"sakinarizviimi@gmail.com", "neelam.raheel@genetechsolutions.com");
			} else {
				$receipt_pdf 	= "receipts/global.php";
				$receipt_email 	= "email/frontend/donate_receipt.php";
				$email_subject	= "Your Tax Receipt for the donation made to Imamia Medics International";
				$receipt_prefix = 'A';
				$email_bcc		= array("IMIFinance786@gmail.com", "imihq@imamiamedics.com","imiwaiting@att.net","sakinarizviimi@gmail.com", "neelam.raheel@genetechsolutions.com");
			}

				$get_max_receipt_no	= $ci->db->query("SELECT MAX(receipt_number) AS largest_receipt_no FROM `tb_payment_receipts` WHERE receipt_prefix = '$receipt_prefix'");
				// $get_max_receipt_no	= $ci->db->query("SELECT MAX(tax_receipt_num) AS largest_receipt_no FROM `tb_donation_form` WHERE belongs_country = ".$belongs_to);

				if( count($get_max_receipt_no->row()) > 0 ){
					$max_receipt_num	= intval($get_max_receipt_no->row()->largest_receipt_no);
					// $max_receipt_num	= $max_receipt_num + 1;

					if($belongs_to == '3'){
						$max_receipt_num	= ($max_receipt_num <= 120000) ? 120001 : $max_receipt_num + 1;
					} elseif( $belongs_to == '4') {
						$max_receipt_num	= ($max_receipt_num <= 130000) ? 130001 : $max_receipt_num + 1;
					} else {
						$max_receipt_num	= ($max_receipt_num <= 110000) ? 110001 : $max_receipt_num + 1;
					}
					$current_date = new DateTime();
					$dataForReceipt	= array();
					$dataForReceipt['receipt_number']	= $max_receipt_num;
					$dataForReceipt['receipt_prefix']	= $receipt_prefix;
					$dataForReceipt['table_name']		= 'tb_donation_form';
					$dataForReceipt['table_id_name']	= 'id';
					$dataForReceipt['table_id_value']	= $df_id;
					$dataForReceipt['created_at']	    = $current_date->format('Y-m-d H:i:s');

					$ci->queries->SaveDeleteTables($dataForReceipt, 's', "tb_payment_receipts", 'id');
					
					if($is_recurring == false){
						$editDataForReceipt	= array();
						$editDataForReceipt['tax_receipt_num']	= $max_receipt_num;
						$editDataForReceipt['id']				= $df_id;

						$ci->queries->SaveDeleteTables($editDataForReceipt, 'e', "tb_donation_form", 'id');
					}
				}

			$_homestate	= ($TMP_receipt->row()->home_state_name) ? ', ' . $TMP_receipt->row()->home_state_name : "";
			$_receipt_date	=  date("Y-m-d", strtotime( $TMP_receipt->row()->date_added));
			if($is_recurring){
				$_receipt_date	=  date("Y-m-d");
			}

			$pdfData = array(
				"name"			=> $TMP_receipt->row()->first_name,
				"address"		=> $TMP_receipt->row()->home_city_name . $_homestate,
				// "address"		=> $TMP_receipt->row()->home_address,
				"email"			=> $TMP_receipt->row()->email,
				"project"		=> $TMP_receipt->row()->dpdesc,
				"amount"		=> $TMP_receipt->row()->donate_amount,
				"date" 			=> $_receipt_date,
				"serial_num" 	=> $receipt_prefix . $max_receipt_num
			);
			$ci->load->library('pdf');
			$file_name = './assets/temp-tax-files/tax-receipt-' . $df_id . '.pdf';
			$html_code = "";
			$html_code .= '<link rel="preconnect" href="https://fonts.googleapis.com">';
			$html_code .= $ci->load->view( $receipt_pdf, $pdfData, TRUE );
			$pdf = new Pdf();
			$pdf->load_html($html_code);
			$pdf->render();
			$file = $pdf->output();
			file_put_contents($file_name, $file);

			$email_template		= array("email_to"					=> $TMP_receipt->row()->email,
										"email_heading"				=> "Donation Tax Receipt",
										"email_file"				=> $receipt_email,
										"email_subject"				=> $email_subject,
										"default_subject"			=> TRUE,
										"email_post"				=> $_POST,
										// "email_bcc"					=> ( SessionHelper::_get_session("EMAIL_TO", "site_settings") ),
										"email_bcc"					=> $email_bcc,
										"email_attachment"			=> $file_name
										);

			$is_email_sent_2				= $ci->_send_email( $email_template );
			unlink($file_name);
		
		}
		// pdfwork end
	}

	function send_tax_receipt_shortconference($userid, $ci, $conference_slug){
		
		$_POST['conference']						= $ci->queries->fetch_records('short_conference', " AND slug = '". $conference_slug ."' ");
		
		$_POST['conferenceregistration']			= $ci->queries->fetch_records('short_conference_registration_master', 
		" AND userid = '". $userid . "' 
		  AND conferenceid = '". $_POST['conference'] -> row("id") ."' ");
		  		
		$_POST['conferenceregistration_screenone']		= $ci->queries->fetch_records('short_conference_registration_screen_one', " AND conferenceregistrationid = '". $_POST['conferenceregistration']->row("id") ."' ");

		$_POST['conferenceregistration_screenone_family_details']	= $ci->queries->fetch_records('short_conference_registration_screen_one_family_details'," AND parentid = '". $_POST['conferenceregistration_screenone']->row("id") ."' ");
		
		$_POST['conferenceregistration_screentwo']		= $ci->queries->fetch_records('short_conference_registration_screen_two', " AND conferenceregistrationid = '". $_POST['conferenceregistration']->row("id") ."' ");

		$_POST['conferenceregistration_screentwo_details']	= $ci->queries->fetch_records('short_conference_registration_screen_two_details', " AND parentid = '". $_POST['conferenceregistration_screentwo']->row("id") ."' ");
		
		$_POST['donation_details']['name'] = isset($_POST['conferenceregistration_screenone']->row()->name) ? $_POST['conferenceregistration_screenone']->row()->name : '';

		if( $_POST['conferenceregistration_screenone']->num_rows() > 0 )
		{
			$receipt_pdf 	= "receipts/global-shortconference.php";
			$receipt_email 	= "email/frontend/conference_payment.php";
			$email_subject	= "Your Registration Receipt";
			$receipt_prefix = 'SC';
			$email_bcc		= array('Imifinance786@gmail.com','sakinarizviimi@gmail.com','imiwaiting@att.net','rida.fatima@genetechsolutions.com','imihq@imamiamedics.com');
		
			$get_max_receipt_no	= $ci->db->query("SELECT MAX(receipt_number) AS largest_receipt_no FROM `tb_payment_receipts` WHERE receipt_prefix = '$receipt_prefix'");
			
			if( count($get_max_receipt_no->row()) > 0 ){
				$max_receipt_num	= intval($get_max_receipt_no->row()->largest_receipt_no);
				// $max_receipt_num	= $max_receipt_num + 1;

				// if($belongs_to == '3'){
				// 	$max_receipt_num	= ($max_receipt_num <= 120000) ? 120001 : $max_receipt_num + 1;
				// } elseif( $belongs_to == '4') {
				// 	$max_receipt_num	= ($max_receipt_num <= 130000) ? 130001 : $max_receipt_num + 1;
				// } else {
				$max_receipt_num	= ($max_receipt_num <= 110000) ? 110001 : $max_receipt_num + 1;
				// }
				
				$current_date = new DateTime();
				$dataForReceipt	= array();
				$dataForReceipt['receipt_number']	= $max_receipt_num;
				$dataForReceipt['receipt_prefix']	= $receipt_prefix;
				$dataForReceipt['table_name']		= 'tb_short_conference_registration_master';
				$dataForReceipt['table_id_name']	= 'id';
				$dataForReceipt['table_id_value']	= $userid;
				$dataForReceipt['created_at']	    = $current_date->format('Y-m-d H:i:s');

				$ci->queries->SaveDeleteTables($dataForReceipt, 's', "tb_payment_receipts", 'id');

					$editDataForReceipt	= array();
					$editDataForReceipt['tax_receipt_num']	= $max_receipt_num;
					$editDataForReceipt['userid']				= $userid;

				$ci->queries->SaveDeleteTables($editDataForReceipt, 'e', "tb_short_conference_registration_master", 'userid');
				// var_dump($ci->db->last_query());die;
			}
 
			$pdfData = array(
				"pdf_post"		=> $_POST,
				"name"			=> $_POST['conferenceregistration_screenone']->row()->name,
				"email"			=> $_POST['conferenceregistration_screenone']->row()->email,
				"project"		=> $_POST['conferenceregistration']->row()->conference_name,
				"amount"		=> $_POST['conferenceregistration_screentwo']->row()->price_total_payable,
				"date" 			=> $_POST['conferenceregistration']->row()->date_added,
				"serial_num" 	=> $receipt_prefix . $max_receipt_num
			);
			$ci->load->library('pdf');
			$file_name = './assets/temp-tax-files/registration-receipt-' . $userid . '.pdf';
			$html_code = "";
			$html_code .= '<link rel="preconnect" href="https://fonts.googleapis.com">';
			$html_code .= $ci->load->view( $receipt_pdf, $pdfData, TRUE );
			$pdf = new Pdf();
			$pdf->load_html($html_code);
			$pdf->render();
			$file = $pdf->output();
			file_put_contents($file_name, $file);
			
			$email_template		= array("email_to"					=> $_POST['conferenceregistration_screenone']->row()->email,
										"email_heading"				=> "Conference Registration Receipt",
										"email_file"				=> $receipt_email,
										"email_subject"				=> $email_subject,
										"default_subject"			=> TRUE,
										"email_post"				=> $_POST,
										// "email_bcc"					=> ( SessionHelper::_get_session("EMAIL_TO", "site_settings") ),
										"email_bcc"					=> $email_bcc,
										"email_attachment"			=> $file_name
										);

			$is_email_sent_2				= $ci->_send_email( $email_template );
			unlink($file_name);
		
		}
		// pdfwork end
	}
	function validate_if_require_visa( $conferenceregistration )
	{
		if($this->CI->functions->_user_logged_in_details( "id" )){
			$if_price_package_contains_applyvisa					= 0;
			if ( $conferenceregistration -> num_rows() > 0 )
			{
				$crm				= $conferenceregistration->row("id");
				$crso				= $this->CI->queries->fetch_records("short_conference_registration_screen_one", 
																	" AND  conferenceregistrationid  = '". $crm ."' ", 
																	"id, no_of_family_members " );
				
				if ( $crso -> num_rows() > 0 )
				{
				
					if ( $this->CI->queries->fetch_records("short_conference_registration_screen_two", " AND  conferenceregistrationid  = '". $crm ."' ", "id" ) -> num_rows() > 0 )
					{
						
						
						$screen_two_query							= $this->CI->db->last_query();
						$if_price_package_contains_applyvisa		= $this->CI->db->query(	"	SELECT id FROM `tb_short_conference_prices_master` 
																							WHERE ID IN (SELECT parentid FROM `tb_short_conference_prices_details` where id IN 
																											(	SELECT price_details_id FROM `tb_short_conference_registration_screen_two_details` 
																												WHERE parentid IN 
																													(". $screen_two_query .") 
																											)
																										)
																							AND apply_for_visa = 1")->num_rows();
						
						
						#SELECT apply_for_visa FROM `tb_short_conference_prices_master` where id IN (SELECT parentid FROM `tb_conference_prices_details` where id = 314) AND apply_for_visa = 1
						$this->CI->queries->fetch_records("short_conference_registration_screen_two_details", " AND  parentid IN (". $screen_two_query .")  ", "id" );
						
					}
				}                
			}	
		}
		
		
		#for now - dont show step 3/4 always - muslimraza:15-11-2019
		return false;
		#return $if_price_package_contains_applyvisa;
	}

	function conferencepayment_array( $TMP_parameters = array(), $coupon_codes_array = array() )
	{	
		$newtable_for_details								= array();
		$TMP_prices['others']['earlybird_price']			= array();
		$TMP_prices['others']['regular_price']				= array();
		$TMP_prices['members']['earlybird_price']			= array();
		$TMP_prices['members']['regular_price']				= array();
		
		$TMP_where											= "";
		if ( ! array_key_exists("imi_speaker_coupon_code", $coupon_codes_array) )
		{
			//$TMP_where										.= " AND is_free != 1 ";
		}
		
		//this includes in 9th Conference on|y.
		$prices_others										= $this->CI->queries->fetch_records("short_conference_prices_master", 
																								"AND conferenceid = '". $TMP_parameters['conferenceid'] ."' 
																								 AND regionid = '". $TMP_parameters['regionid'] ."' 
																								 AND paymenttype_key  = 'others' 
																								 AND (parent_id IS NULL AND is_addon = 0)
																								 $TMP_where ORDER BY whoattend_id ASC ");
																								 
		if ( $prices_others -> num_rows() > 0 )
		{
			foreach ( $prices_others -> result_array() as $p )
			{
				
				
				$details_price			= $this->CI->queries->fetch_records("short_conference_prices_details", " AND parentid = '". $p['id'] ."' ");
				foreach ($details_price->result_array() as $d)
				{
					 
					$other_price_array									= $this -> create_array_for_price_for_others( $p, $d);
					$other_price_array["price"]							= $d['earlybird_price'];
					#print_r($p);die;
					$other_price_array["pricedisplay"]					= format_price( $d['earlybird_price'], array("prefix" => $this->getCurrencySymbol($p['show_rates_in_currency'] )) );
					
			
					$TMP_prices['others']['earlybird_price'][]			= $other_price_array;
					$TMP_prices['whoattendlist']['others'][  $p['whoattend_name'] ]['earlybird_price'][$d['parentid']][ $d['typeid'] ]			= $other_price_array;
					
					/*array("whoattend_name"			=> $p['whoattend_name'],
																				"whoattend_weight"			=> $p['whoattend_weight'],
																				"discount_coupon_code" 		=> $p['discount_coupon_code'],
																				"id"						=> $d['id'],
																				"typeid"					=> $d['typeid'],
																				"price"						=> $d['earlybird_price'],
																				"pricedisplay"				=> format_price( $d['earlybird_price'], array("prefix" => "$") ),
																				"is_optional"				=> $p['is_optional'],
																				"is_free"					=> $p['is_free'],
																				"title_for_price"			=> $p['title'],
																				"description_for_price"		=> $p['description'],
																				"image_icon_for_price"		=> $p['image_icon'],
																				
																				);
					*/
					
					
					
					$other_price_array									= $this -> create_array_for_price_for_others( $p, $d);
					$other_price_array["price"]							= $d['regular_price'];
					$other_price_array["pricedisplay"]					= format_price( $d['regular_price'], array("prefix" => $this->getCurrencySymbol($p['show_rates_in_currency'] )) );
					$TMP_prices['others']['regular_price'][]			= $other_price_array;
					$TMP_prices['whoattendlist']['others'][  $p['whoattend_name'] ]['regular_price'][$d['parentid']][ $d['typeid'] ]			= $other_price_array;
					
					
					/*array("whoattend_name"			=> $p['whoattend_name'],
																				"whoattend_weight"			=> $p['whoattend_weight'],
																				"discount_coupon_code" 		=> $p['discount_coupon_code'],
																				"id"						=> $d['id'],
																				"typeid"					=> $d['typeid'],
																				"price"						=> $d['regular_price'],
																				"pricedisplay"				=> format_price( $d['regular_price'], array("prefix" => "$") ),
																				"is_optional"				=> $p['is_optional'],
																				"is_free"					=> $p['is_free'],
																				"title_for_price"			=> $p['title'],
																				"description_for_price"		=> $p['description'],
																				"image_icon_for_price"		=> $p['image_icon'],
																				
																				);*/
																				
																				
									
									
									
									
					
					
					$addons_others			= $this->CI->queries->fetch_records("short_conference_prices_master", " AND parent_id  = '". $p["id"] ."'  ");
					foreach ( $addons_others -> result_array() as $p_addon )
					{
						$details_price_addon		= $this->CI->queries->fetch_records("short_conference_prices_details", " AND parentid = '". $p_addon['id'] ."' ");	
									
						foreach ($details_price_addon->result_array() as $d_addon)
						{
							
							$tmp_array_addon						= $this->create_array_for_price_for_others( $p_addon, $d_addon );
							
							
							
							
							$_NEW_Array_addon						= $tmp_array_addon;
							
							$_NEW_Array_addon["pricedisplay"]							= format_price( $d_addon['earlybird_price'], array("prefix" => $this->getCurrencySymbol($p_addon['show_rates_in_currency']) ) );
							$_NEW_Array_addon["price"]									= $d_addon['earlybird_price'];
							$TMP_prices['whoattendlist']['others'][  $p_addon['whoattend_name'] ]['earlybird_price'][  $p["id"]  ]['addon'][$d_addon['parentid']][ $d_addon['typeid'] ]		= $_NEW_Array_addon;
						
							
							$_NEW_Array_addon["pricedisplay"]							= format_price( $d_addon['regular_price'], array("prefix" => $this->getCurrencySymbol($p_addon['show_rates_in_currency']) ) );
							$_NEW_Array_addon["price"]									= $d_addon['regular_price'];
							$TMP_prices['whoattendlist']['others'][  $p_addon['whoattend_name'] ]['regular_price'][  $p["id"]  ]['addon'][$d_addon['parentid']][ $d_addon['typeid'] ]		= $_NEW_Array_addon;
							
						}
						
					}											
																				
																				
																				
				}
			}
		}

		
		
		// var_dump($TMP_parameters);die;
		
		$prices_others							= $this->CI->queries->fetch_records("short_conference_prices_master", 
																					"AND conferenceid = '". $TMP_parameters['conferenceid'] ."' 
																					 AND regionid = '". $TMP_parameters['regionid'] ."' 
																					 AND paymenttype_key  = 'members'
																					 AND ( parent_id IS NULL AND is_addon = 0 )
																					 $TMP_where  ORDER BY whoattend_id ASC");
		if ( $prices_others -> num_rows() > 0 )
		{
			foreach ( $prices_others -> result_array() as $p )
			{
				$details_price			= $this->CI->queries->fetch_records("short_conference_prices_details", " AND parentid = '". $p['id'] ."' ");
				$combine_imi_nonmem		= array();
				
				foreach ($details_price->result_array() as $d)
				{
					
					#add in array - after this loop.
					$tmp_array						= $this->create_array_for_price( $p, $d );
					$combine_imi_nonmem				= $tmp_array['combine_imi_nonmem'];
					$_NEW_Array						= $tmp_array['structured_array'];
					
														
					$_NEW_Array["pricedisplay"]													= format_price( $d['earlybird_price'], array("prefix" => $this->getCurrencySymbol($p['show_rates_in_currency'] )) );
					$_NEW_Array["price"]														= $d['earlybird_price'];
					$TMP_prices['members']['earlybird_price'][ $d['typeid'] ][]					= $_NEW_Array;
					$TMP_prices['whoattendlist']['members'][  $p['whoattend_name'] ]['earlybird_price'][$d['parentid']][ $d['typeid'] ]		= $_NEW_Array;
					
					
					
					
					
					
					$_NEW_Array["pricedisplay"]													= format_price( $d['regular_price'], array("prefix" => $this->getCurrencySymbol($p['show_rates_in_currency'] )) );
					$_NEW_Array["price"]														= $d['regular_price'];
					$TMP_prices['members']['regular_price'][ $d['typeid'] ][]					= $_NEW_Array;
					$TMP_prices['whoattendlist']['members'][  $p['whoattend_name'] ]['regular_price'][$d['parentid']][ $d['typeid'] ]		= $_NEW_Array;
					
					
					
					
					
					
					
					
					
					
					
					
					$addons_others			= $this->CI->queries->fetch_records("short_conference_prices_master", " AND parent_id  = '". $p["id"] ."'  ");
					foreach ( $addons_others -> result_array() as $p_addon )
					{
						$details_price_addon		= $this->CI->queries->fetch_records("short_conference_prices_details", " AND parentid = '". $p_addon['id'] ."' ");	
									
						foreach ($details_price_addon->result_array() as $d_addon)
						{
							
							$tmp_array_addon						= $this->create_array_for_price( $p_addon, $d_addon );
							
							
							
							$combine_imi_nonmem_addon				= $tmp_array_addon['combine_imi_nonmem'];
							$_NEW_Array_addon						= $tmp_array_addon['structured_array'];
							
							$_NEW_Array_addon["pricedisplay"]							= format_price( $d_addon['earlybird_price'], array("prefix" => $this->getCurrencySymbol($p_addon['show_rates_in_currency']) ) );
							$_NEW_Array_addon["price"]									= $d_addon['earlybird_price'];
							$TMP_prices['whoattendlist']['members'][  $p_addon['whoattend_name'] ]['earlybird_price'][  $p["id"]  ]['addon'][$d_addon['parentid']][ $d_addon['typeid'] ]		= $_NEW_Array_addon;
						
							
							$_NEW_Array_addon["pricedisplay"]							= format_price( $d_addon['regular_price'], array("prefix" => $this->getCurrencySymbol($p_addon['show_rates_in_currency']) ) );
							$_NEW_Array_addon["price"]									= $d_addon['regular_price'];
							$TMP_prices['whoattendlist']['members'][  $p_addon['whoattend_name'] ]['regular_price'][  $p["id"]  ]['addon'][$d_addon['parentid']][ $d_addon['typeid'] ]		= $_NEW_Array_addon;
							
						}
						
					}
				
					
		
				}
					
				
				$TMP_prices['members']['all'][]	= $combine_imi_nonmem;
			}
		}

		$prices_others							= $this->CI->queries->fetch_records("short_conference_prices_master", 
																					"AND conferenceid = '". $TMP_parameters['conferenceid'] ."' 
																					 AND regionid = '". $TMP_parameters['regionid'] ."' 
																					 AND paymenttype_key  = 'members'
																					 AND ( parent_id IS NULL AND is_addon = 1 )
																					 $TMP_where  ORDER BY whoattend_id ASC");

		if ( $prices_others -> num_rows() > 0 )
		{
			foreach ( $prices_others -> result_array() as $p )
			{ 
				
				foreach ( $prices_others -> result_array() as $p )
			{
				$details_price			= $this->CI->queries->fetch_records("short_conference_prices_details", " AND parentid = '". $p['id'] ."' ");
				$combine_imi_addons		= array();
				
				foreach ($details_price->result_array() as $d)
				{
					
					#add in array - after this loop.
					$tmp_array						= $this->create_array_for_price( $p, $d );
					/* echo '<pre>';
					print_r($tmp_array);
					echo '</pre>'; */
					$combine_imi_addons				= $tmp_array['combine_imi_nonmem'];
					$_NEW_Array						= $tmp_array['structured_array'];
					
														
					$_NEW_Array["pricedisplay"]													= format_price( $d['earlybird_price'], array("prefix" => $this->getCurrencySymbol($p['show_rates_in_currency'] )) );
					$_NEW_Array["price"]														= $d['earlybird_price'];
					$TMP_prices['addons']['earlybird_price'][ $d['typeid'] ][]					= $_NEW_Array;
					$TMP_prices['whoattendlist']['addons']['earlybird_price'][$d['parentid']][ $d['typeid'] ]		= $_NEW_Array;
					
					
					
					
					
					
					$_NEW_Array["pricedisplay"]													= format_price( $d['regular_price'], array("prefix" => $this->getCurrencySymbol($p['show_rates_in_currency'] )) );
					$_NEW_Array["price"]														= $d['regular_price'];
					$TMP_prices['addons']['regular_price'][ $d['typeid'] ][]					= $_NEW_Array;
					$TMP_prices['whoattendlist']['addons']['regular_price'][$d['parentid']][ $d['typeid'] ]		= $_NEW_Array;
					
					
					
					
					
					
					
					
					
					
					
					
					$addons_others			= $this->CI->queries->fetch_records("short_conference_prices_master", " AND parent_id  = '". $p["id"] ."'  ");
					foreach ( $addons_others -> result_array() as $p_addon )
					{
						$details_price_addon		= $this->CI->queries->fetch_records("short_conference_prices_details", " AND parentid = '". $p_addon['id'] ."' ");	
									
						foreach ($details_price_addon->result_array() as $d_addon)
						{
							
							$tmp_array_addon						= $this->create_array_for_price( $p_addon, $d_addon );
							
							
							
							$combine_imi_addons_addon				= $tmp_array_addon['combine_imi_addons'];
							$_NEW_Array_addon						= $tmp_array_addon['structured_array'];
							
							$_NEW_Array_addon["pricedisplay"]							= format_price( $d_addon['earlybird_price'], array("prefix" => $this->getCurrencySymbol($p_addon['show_rates_in_currency']) ) );
							$_NEW_Array_addon["price"]									= $d_addon['earlybird_price'];
							$TMP_prices['whoattendlist']['addons']['earlybird_price'][  $p["id"]  ]['addon'][$d_addon['parentid']][ $d_addon['typeid'] ]		= $_NEW_Array_addon;
						
							
							$_NEW_Array_addon["pricedisplay"]							= format_price( $d_addon['regular_price'], array("prefix" => $this->getCurrencySymbol($p_addon['show_rates_in_currency']) ) );
							$_NEW_Array_addon["price"]									= $d_addon['regular_price'];
							$TMP_prices['whoattendlist']['addons']['regular_price'][  $p["id"]  ]['addon'][$d_addon['parentid']][ $d_addon['typeid'] ]		= $_NEW_Array_addon;
							
						}
						
					}
				
					
		
				}
					
				
				$TMP_prices['addons']['all'][]	= $combine_imi_addons;
				
			}
			}
		}

		return $TMP_prices;
	}

	function create_array_for_price_for_others( $p, $d )
	{
		$TMP_array							= array("whoattend_name"			=> $p['whoattend_name'],
													"whoattend_weight"			=> $p['whoattend_weight'],
													"discount_coupon_code" 		=> $p['discount_coupon_code'],
													"id"						=> $d['id'],
													"typeid"					=> $d['typeid'],
													/*"price"						=> $d['earlybird_price'],
													"pricedisplay"				=> format_price( $d['earlybird_price'], array("prefix" => "$") ),*/
													"is_optional"				=> $p['is_optional'],
													"is_free"					=> $p['is_free'],
													"title_for_price"			=> $p['title'],
													"description_for_price"		=> $p['description'],
													"image_icon_for_price"		=> $p['image_icon'],
													
													);
													
		return $TMP_array;
	}
	function create_array_for_price( $p, $d )
	{
		
		
		$combine_imi_nonmem[ $d['typeid'] ]								= array("whoattend_name"			=> $p['whoattend_name'],
																				"whoattend_description"		=> $p['whoattend_description'],
																				"discount_coupon_code" 		=> $p['discount_coupon_code'],
																				"typeid"					=> $d['typeid'],
																				"earlybird_price"			=> $d['earlybird_price'],
																				"earlybird_pricedisplay"	=> format_price( $d['earlybird_price'], array("prefix" => $this->getCurrencySymbol($p['show_rates_in_currency'] )) ),
																				"regular_price"				=> $d['regular_price'],
																				"regular_pricedisplay"		=> format_price( $d['regular_price'], array("prefix" => $this->getCurrencySymbol($p['show_rates_in_currency'] )) ),
																				
																				"title_for_price"			=> $p['title'],
																				"description_for_price"		=> $p['description'],
																				"image_icon_for_price"		=> $p['image_icon'],
																				
																				);
							
		
		
		
		
		$_NEW_Array														= array("id"					=> $d['id'],
																				"whoattend_weight"		=> $p['whoattend_weight'],
																				"whoattend_name"		=> $p['whoattend_name'],
																				"whoattend_description"		=> $p['whoattend_description'],
																				"discount_coupon_code" 	=> $p['discount_coupon_code'],
																				/*"price"					=> $d['earlybird_price'],
																				"pricedisplay"			=> format_price( $d['earlybird_price'], array("prefix" => "$") ),*/
																				"is_optional"			=> $p['is_optional'],
																				"is_free"				=> $p['is_free'],
																				
																				"title_for_price"		=> $p['title'],
																				"description_for_price"	=> $p['description'],
																				"image_icon_for_price"	=> $p['image_icon'],
																				
																				);	
																				
		return [
					"combine_imi_nonmem"		=> $combine_imi_nonmem, 
					"structured_array"			=> $_NEW_Array 
				];
	}
	function getCurrencySymbol($currId){
		
		
		$currency_list										=  DropdownHelper::currency_dropdown();
		
		if ( array_key_exists($currId, $currency_list) )
		{
			return $currency_list[ $currId ];	
		}
		
		return "$";
		
		/*
		$prices_others										= $this->CI->queries->fetch_records("currency", "AND currency_id = '". $currId ."'", "csymbol");
		if ( $prices_others -> num_rows() > 0 ){
			$row = $prices_others->row_array(0);
			return $row['csymbol'];
		} else {
			return "$";
		}*/
	}
	
	function get_post_or_data( $post_string, $db_string )
	{
		if ( isset( $_POST[$post_string] ) )
		{
			return $_POST[$post_string];
		}
		else  
		{
			return $db_string;
		}
	}

	
	function is_paid_by_cash( $value = array() )
	{
		//|| $value['payment_type'] == 'paypal'
		if ( $value['is_paid'] == 0 and ($value['payment_allow'] == 0 || $value['payment_allow'] == 1) and $value['payment_type'] == 'cash' )
		{
			return TRUE;
		}
		
		return FALSE;
	}
}
?>