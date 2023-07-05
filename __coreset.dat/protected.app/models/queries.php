<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Queries extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
	} 
	
	
		
	public function visitorlog( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *  ";
		}
		if ($select_where == 2)
		{
			return " tb_visitorlog ";	
		}
		else
		{
			return " 1 = 1  $where ";
		}
	}
	
	
	public function countries( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *  ";
		}
		if ($select_where == 2)
		{
			return " tb_countries ";	
		}
		else
		{
			return " 1 = 1  $where ";
		}
	}	
	public function country_phone_codes( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *  ";
		}
		if ($select_where == 2)
		{
			return " tb_country_phone_codes ";	
		}
		else
		{
			return " 1 = 1  $where ";
		}
	}		
	public function states( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *  ";
		}
		if ($select_where == 2)
		{
			return " tb_states ";	
		}
		else
		{
			return " 1 = 1  $where ";
		}
	}	
	
	public function cities( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *  ";
		}
		if ($select_where == 2)
		{
			return " tb_cities ";	
		}
		else
		{
			return " 1 = 1  $where ";
		}
	}	

	public function admin( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *, (SELECT name FROM tb_admin_roles WHERE id = tb_admin.roleid) as role_name  ";
		}
		if ($select_where == 2)
		{
			return " tb_admin ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	
	public function admin_roles( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *  ";
		}
		if ($select_where == 2)
		{
			return " tb_admin_roles ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	public function languages( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *  ";
		}
		if ($select_where == 2)
		{
			return " languages ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}

	public function content_languages( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *  ";
		}
		if ($select_where == 2)
		{
			return " tb_content_languages ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function cmscontent_languages( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *  ";
		}
		if ($select_where == 2)
		{
			return " tb_cmscontent_languages ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function sitesectionswidgets_languages( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *  ";
		}
		if ($select_where == 2)
		{
			return " tb_sitesectionswidgets_languages ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function cmsmenu_languages( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *  ";
		}
		if ($select_where == 2)
		{
			return " tb_cmsmenu_languages ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function site_gallery_languages( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *  ";
		}
		if ($select_where == 2)
		{
			return " tb_site_gallery_languages ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function timelinehistory_languages( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *  ";
		}
		if ($select_where == 2)
		{
			return " tb_timelinehistory_languages ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function wherewework_languages( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *  ";
		}
		if ($select_where == 2)
		{
			return " tb_wherewework_languages ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function chapterslocation_master_languages( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *  ";
		}
		if ($select_where == 2)
		{
			return " tb_chapterslocation_master_languages ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function chapterpersons_master_languages( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *  ";
		}
		if ($select_where == 2)
		{
			return " tb_chapterpersons_master_languages ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function donation_projects_languages( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *  ";
		}
		if ($select_where == 2)
		{
			return " tb_donation_projects_languages ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function donation_campaigns_languages( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *  ";
		}
		if ($select_where == 2)
		{
			return " tb_donation_campaigns_languages ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function donation_ways_to_give_languages( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *  ";
		}
		if ($select_where == 2)
		{
			return " tb_donation_ways_to_give_languages ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function donation_campaigns_updates_languages( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *  ";
		}
		if ($select_where == 2)
		{
			return " tb_donation_campaigns_updates_languages ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	public function site_settings_master( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  * ";
		}
		if ($select_where == 2)
		{
			return " tb_site_settings_master ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	public function site_settings_child( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  * ";
		}
		if ($select_where == 2)
		{
			return " tb_site_settings_child ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	public function currency( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  * ";
		}
		if ($select_where == 2)
		{
			return " tb_currency ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}

	public function dump( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " * ";
		}
		if ($select_where == 2)
		{
			return " ci_sessions ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	
	public function site_gallery( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " 	*, (CASE WHEN (status = 1) THEN 'Yes' ELSE 'No' END) as status_name ";
		}
		if ($select_where == 2)
		{
			return " tb_site_gallery ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	public function cmsmenu( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " 	*, 
						(SELECT name FROM tb_cmsmenu_types WHERE id = tb_cmsmenu.typeid) as type_name,
						(SELECT name FROM tb_cmsmenu_positions WHERE id = tb_cmsmenu.positionid) as position_name ";
		}
		if ($select_where == 2)
		{
			return " tb_cmsmenu ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	public function cmsmenu_types( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  * ";
		}
		if ($select_where == 2)
		{
			return " tb_cmsmenu_types ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	public function cmsmenu_positions( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  * ";
		}
		if ($select_where == 2)
		{
			return " tb_cmsmenu_positions ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	public function cmscontent( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *, (SELECT name FROM tb_cmsmenu WHERE id = tb_cmscontent.menuid) as menu_name ";
		}
		if ($select_where == 2)
		{
			return " tb_cmscontent ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}

	public function donation_campaigns( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *, (SELECT name FROM tb_donation_projects WHERE id = tb_donation_campaigns.donation_project_id) as name ";
		}
		if ($select_where == 2)
		{
			return " tb_donation_campaigns ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}

	public function donation_campaigns_gallery( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  * ";
		}
		if ($select_where == 2)
		{
			return " tb_donation_campaigns_gallery ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}

	public function donation_campaigns_updates( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *, (SELECT slug FROM tb_donation_campaigns WHERE id = tb_donation_campaigns_updates.donation_campaigns_id) as name ";
		}
		if ($select_where == 2)
		{
			return " tb_donation_campaigns_updates ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	public function dc_offline_donation( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  * ";
		}
		if ($select_where == 2)
		{
			return " tb_dc_offline_donation ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	public function cmscontent_widgets( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  * ";
		}
		if ($select_where == 2)
		{
			return " tb_cmscontent_widgets ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}

	public function chapterlocation_widgets($select_where = 0, $where = '')
	{
		if ($select_where == 0) {
			return "  * ";
		}
		if ($select_where == 2) {
			return " tb_chapterlocation_widgets ";
		} else {
			return " 1 = 1 $where ";
		}
	}
	
	
	
	public function users( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " * ";
		}
		if ($select_where == 2)
		{
			return "imi_conf_restore2.tb_users";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	

	
	
	function recfunc ( $node )
	{
		if ( is_array($node) )
		{
			foreach($node as $m => $n) 
			{
				$this->recfunc( $n );	
			}	
		}
	}
	
	
	function SaveCopyTables ($type, $table, $table_content, $key_field = 'id', $id, $copy_content=0, $confid=0) {
		
		if ($type == 'menus') {
			
			$new_parent_menu_id = 0;		
			$new_children_menu_ids = array();
			$new_content_ids = array();
			
			$parent_child_menus = $this->db->query("SELECT * FROM {$table} WHERE id = {$id} OR parentid = {$id}")->result_array();
			
			foreach($parent_child_menus as $menu) {
			
				if ($menu['parentid'] == 0) {	# parent
				
					$this->db->query("INSERT INTO {$table} SET 
						conferenceid 	= '".($confid ? $confid : $menu['conferenceid'])."',
						name 			= 'Clone - ".$menu['name']."',
						slug 			= 'clone-".$menu['slug']."',
						target			= '".$menu['target']."',
						typeid			= '".$menu['typeid']."',
						status			= '".$menu['status']."',
						parentid		= '".$menu['parentid']."'
					");
					$new_parent_menu_id = $this->db->insert_id();
					
					if ($copy_content) {
						$menu_content = $this->db->query("SELECT * FROM {$table_content} WHERE menuid = {$menu['id']}")->result_array();						
						if (!empty($menu_content)) {
							foreach($menu_content as $content) {	
								$this->db->query("INSERT INTO {$table_content} SET 	
									menuid 		= '".$new_parent_menu_id."',
									content 	= '".$content['content']."'
								");
								$new_content_ids[] = $this->db->insert_id();
							}
						}
					}
					
				} else {	# children
					
					$this->db->query("INSERT INTO {$table} SET 	
						conferenceid 	= '".($confid ? $confid : $menu['conferenceid'])."',
						name 			= 'Clone - ".$menu['name']."',
						slug 			= 'clone-".$menu['slug']."',
						target			= '".$menu['target']."',
						typeid			= '".$menu['typeid']."',
						status			= '".$menu['status']."',
						parentid		= '".($new_parent_menu_id ? $new_parent_menu_id : $menu['parentid'])."'
					");
					
					$new_children_menu_id = $this->db->insert_id();
					$new_children_menu_ids[] = $new_children_menu_id;
					
					if ($copy_content) {
						$menu_content = $this->db->query("SELECT * FROM {$table_content} WHERE menuid = {$menu['id']}")->result_array();	
						if (!empty($menu_content)) {
							foreach($menu_content as $content) {
								$this->db->query("INSERT INTO {$table_content} SET 	
									menuid 		= '".$new_children_menu_id."',
									content 	= '".$content['content']."'
								");
								$new_content_ids[] = $this->db->insert_id();
							}
						}
					}
				}
				
			}
			
			$new_records = array( 
				'menus' => array(
					'parent'		=> $new_parent_menu_id,
					'children'		=> $new_children_menu_ids
				),
				'content' => $new_content_ids
			);
			
			return $new_records;
		
		} else if ($type == 'content') {
			
			$new_content_ids = array();
			
			$content = $this->db->query("
				SELECT *
				FROM {$table_content}
				WHERE id = {$id}
			")->row();
			
			$content = get_object_vars($content);
			
			$this->db->query("INSERT INTO {$table_content} SET 
				menuid 	= '".$content['menuid']."',
				content	= '".$content['content']."'
			");
			
			$new_content_ids[] = $this->db->insert_id();
			
			$new_records = array( 
				'content' => $new_content_ids
			);
			
			return $new_records;
		}
	}
	
	
	
	##########################################
	############ CUSTOM functions ############
	##########################################
	
	public function sitesectionswidgets( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  	*, 
						(CASE WHEN (status = 1) THEN 'Yes' ELSE 'No' END) as status_name, 
						full_desc as content ";
		}
		if ($select_where == 2)
		{
			return " tb_sitesectionswidgets ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function event_packages( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " * ";
		}
		if ($select_where == 2)
		{
			return " tb_event_packages ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function event_packages_languages( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " * ";
		}
		if ($select_where == 2)
		{
			return " tb_event_packages_languages ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	
	public function sitesectionswidgets_details( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  * ";
		}
		if ($select_where == 2)
		{
			return " tb_sitesectionswidgets_details ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	
	public function sitesectionswidgets_photos( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  * ";
		}
		if ($select_where == 2)
		{
			return " tb_sitesectionswidgets_photos ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	
	
	
	public function timelinehistory( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *, full_desc as content, (CASE WHEN (status = 1) THEN 'Yes' ELSE 'No' END) as status_name ";
		}
		if ($select_where == 2)
		{
			return " tb_timelinehistory ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	
	public function wherewework( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *, (CASE WHEN (status = 1) THEN 'Yes' ELSE 'No' END) as status_name ";
		}
		if ($select_where == 2)
		{
			return " tb_wherewework ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	
	public function wherewework_details( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  * ";
		}
		if ($select_where == 2)
		{
			return " tb_wherewework_details ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	public function testimonials( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *, (CASE WHEN (status = 1) THEN 'Yes' ELSE 'No' END) as status_name ";
		}
		if ($select_where == 2)
		{
			return " tb_testimonials ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	
	public function chapterslocation_master( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  	*, 	(CASE WHEN (status = 1) THEN 'Yes' ELSE 'No' END) as status_name,
							(SELECT countries_name FROM tb_countries WHERE id = tb_chapterslocation_master.countryid) as  country_name,
							(SELECT countries_iso_code_2 FROM tb_countries WHERE id = tb_chapterslocation_master.countryid) as  countries_iso_code_2,
							(SELECT countries_iso_code_3 FROM tb_countries WHERE id = tb_chapterslocation_master.countryid) as  countries_iso_code_3,
							full_desc as content ";
		}
		if ($select_where == 2)
		{
			return " tb_chapterslocation_master ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	
	public function chapterslocation_details( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  	* ";
		}
		if ($select_where == 2)
		{
			return " tb_chapterslocation_details ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	
	public function boards( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  	*, (CASE WHEN (status = 1) THEN 'Yes' ELSE 'No' END) as status_name ";
		}
		if ($select_where == 2)
		{
			return " tb_boards ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	
	public function designation( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  	*, (CASE WHEN (status = 1) THEN 'Yes' ELSE 'No' END) as status_name ";
		}
		if ($select_where == 2)
		{
			return " tb_designation ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	
	public function chapterpersons_master( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  	*, (CASE WHEN (status = 1) THEN 'Yes' ELSE 'No' END) as status_name, 
						(SELECT name FROM tb_designation WHERE id = tb_chapterpersons_master.designationid) as designation_name ";
		}
		if ($select_where == 2)
		{
			return " tb_chapterpersons_master ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	
	public function chapterpersons_details( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  	*, (SELECT name FROM tb_boards WHERE id = tb_chapterpersons_details.boardid) as board_name ";
		}
		if ($select_where == 2)
		{
			return " tb_chapterpersons_details ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	
	public function chapterslocation_breadcrumbs( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  	*  ";
		}
		if ($select_where == 2)
		{
			return " tb_chapterslocation_breadcrumbs ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function chapter_paypal_settings( $select_where = 0, $where = '' )
	{ 
		if ($select_where == 0)
		{
			return "  	*  ";
		}
		if ($select_where == 2)
		{
			return " tb_chapter_paypal_settings ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	
	public function donation_projects( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  	*, (CASE WHEN (status = 1) THEN 'Yes' ELSE 'No' END) as status_name  ";
		}
		if ($select_where == 2)
		{
			return " tb_donation_projects ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	public function get_donation_projectname( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  	*   ";
		}
		if ($select_where == 2)
		{
			return " tb_donation_projects ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	
	public function donation_payments( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " dp.*,pp.payment_gross,pp.ipn_track_id,pp.payer_id,pp.paypal_post,pp.reference_number,cp.*card_token,cp.card_expiry,cp.card_type,cp.card_name ";
		}
		if ($select_where == 2)
		{
			return " tb_donation_payments dp LEFT JOIN tb_paypal_payments pp ON pp.payment_id = dp.id LEFT JOIN tb_card_payments cp ON cp.payment_id = dp.id";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	
	public function csv_upload( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  	*  ";
		}
		if ($select_where == 2)
		{
			return " tb_csv_upload ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	public function csv_upload_not_updated( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  	*  ";
		}
		if ($select_where == 2)
		{
			return " tb_csv_upload_not_updated ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	public function volunteer_form( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " vf.*, c.countries_name as  country_name, u.name as user_name, u.email as user_email ";
		}
		if ($select_where == 2)
		{
			return "tb_volunteer_form vf join `imi_conf_restore2`.tb_users u ON u.id = vf.user_id JOIN tb_countries c ON c.id = vf.country";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	public function internship_form( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " *, (SELECT countries_name FROM tb_countries WHERE id = tb_internship_form.country) as  country_name ";
		}
		if ($select_where == 2)
		{
			return "tb_internship_form";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	public function mentorship_form( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " mf.*, u.name as user_name, u.email as user_email ";
		}
		if ($select_where == 2)
		{
			return "tb_mentorship_form mf join `imi_conf_restore2`.tb_users u ON u.id = mf.user_id";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
#====================================#
#      Forum Start                   #
#====================================#	

	public function category( $select_where = 0, $where = '' )
	{

		if ($select_where== 0)
		{
			 return "  * ";
		}
		if ($select_where == 2)
		{
			return "tb_category";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	} // end category

	public function currencies( $select_where = 0, $where = '' )
	{

		if ($select_where== 0)
		{
			 return "  * ";
		}
		if ($select_where == 2)
		{
			return "tb_currencies";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	} // end category


	public function categorytype( $select_where = 0, $where = '' )
	{

		if ($select_where== 0)
		{
			 return "  * ";
		}
		if ($select_where == 2)
		{
			return "tb_category_type";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}// end category type

	
	public function forum( $select_where = 0, $where = '' )
	{

		if ($select_where== 0)
		{
			 return "  * ,(SELECT `username` FROM tb_admin WHERE id = tb_forum.created_by_admin) as createdby, (SELECT COUNT(*) FROM tb_forum_topics where tb_forum_topics.frmid=tb_forum.id) as total_topics";
		}
		if ($select_where == 2)
		{
			return "tb_forum";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	} // end forum

	public function formtopics( $select_where = 0, $where = '' )
	{
		if ($select_where== 0)
		{
			 return "  *  ,(SELECT `username` FROM tb_admin WHERE id = tb_forum_topics.created_by_admin) as createdby , (SELECT COUNT(*) FROM tb_posts where tb_posts.topic_id=tb_forum_topics.id) as total_posts";
		}
		if ($select_where == 2)
		{
			return "tb_forum_topics";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	
	}// end formtopics

	public function posts( $select_where = 0, $where = '' )
	{
		if ($select_where== 0)
		{
			 return "  * ,(SELECT `username` FROM tb_admin WHERE id = tb_posts.created_by_admin) as createdby, (SELECT COUNT(*) FROM tb_comments WHERE tb_comments.post_id = tb_posts.id) as comments";

		}
		if ($select_where == 2)
		{
			return "tb_posts";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	
	}// end posts
	
	public function comments( $select_where = 0, $where = '' )
	{
		if ($select_where== 0)
		{
			 return "  * ,(SELECT `name` FROM 	tb_posts WHERE id = tb_comments.post_id) as post";
		}
		if ($select_where == 2)
		{
			return "tb_comments";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}//end comments

	public function getTopics( $select_where = 0, $where = '' )
	{
		if ($select_where== 0)
		{
			 return "  * ,(SELECT `username` FROM tb_admin WHERE id = tb_forum_topics.created_by_admin) as createdby";
		}
		if ($select_where == 2)
		{
			return "tb_forum_topics";	
		}
		else
		{
			return " 1 = 1  $where ";
		}
	}// end getTopics

	public function forumsdetails( $select_where = 0, $where = '')
	{
		if ($select_where== 0)
		{
			 return "  * ,(SELECT COUNT(*) FROM tb_forum_topics WHERE tb_forum_topics.frmid=tb_forum.id) as total_topics  ";
		}
		if ($select_where == 2)
		{
			return "tb_forum";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}//end forumdetails

	public function forums( $select_where = 0, $where = '')
	{
		if ($select_where== 0)
		{
			 return "  * ";
		}
		if ($select_where == 2)
		{
			return "tb_forum";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}

	public function getforumtopics($select_where = 0, $where = '')
	{

		if ($select_where== 0)
		{
			 return "  * ";
		}
		if ($select_where == 2)
		{
			return "tb_forum_topics";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
 
	}//end of getforumtopics
	
	public function getPosts($select_where = 0, $where = '')
	{

 		if ($select_where== 0)
		{
			 return "  * ";
		}
		if ($select_where == 2)
		{
			return "tb_posts";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}//end get Post


	public function getAdmin($select_where = 0, $where = '')
	{

 		if ($select_where== 0)
		{
			 return " * ";
		}
		if ($select_where == 2)
		{
			return "tb_admin";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}//end getForumTopics


	public function getComments($select_where = 0, $where = '')
	{
		if ($select_where== 0)
		{
				return " * ";
		}
		if ($select_where == 2)
		{
			return "tb_comments";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}//end of get Comments


	#====================================#
	#      Get User Data                 #
	#====================================#

	public function getUserdata($select_where = 0, $where = '')
	{
		if ($select_where== 0)
		{
				return " * ";
		}
		if ($select_where == 2)
		{
			return "tb_admin";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}//end of get Comments



	#====================================#
	#      Press Release                 #
	#====================================#


	public function pressRelease($select_where = 0, $where = '')
	{
		if ($select_where== 0)
		{
				return " *, description as content ";
		}
		if ($select_where == 2)
		{
			return "tb_pressrelease";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
			
	}//end of get pressRelease

	#====================================#
	#              News                  #
	#====================================#	

	public function news($select_where = 0, $where = '')
	{
		if ($select_where== 0)
		{
				return " * ";
		}
		if ($select_where == 2)
		{
			return "tb_news";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
			
	}//end of get pressRelease files
	
	public function news_videos($select_where = 0, $where = '')
	{
		if ($select_where== 0)
		{
				return " * ";
		}
		if ($select_where == 2)
		{
			return "tb_news_videos";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
		
	}//end of get pressRelease files

	public function news_pdf($select_where = 0, $where = '')
	{
 		if ($select_where== 0)
		{
			 return " * ";
		}
		if ($select_where == 2)
		{
			return "tb_news_pdf";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}//end of get pressRelease files


	#########  Donation get on will #########3

	public function  donation_give_on_will($select_where = 0, $where = '')
	{
		if ($select_where== 0)
		{
				return " * ";
		}
		if ($select_where == 2)
		{
			return "tb_donation_ways_to_give";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}

	public function who_donate($select_where = 0, $where = '')
	{
		if ($select_where== 0)
		{
				return " * ";
		}
		if ($select_where == 2)
		{
			return "tb_donation_form";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}

	#####################################
	#        IMI Conetnt                #   
	#####################################

	public function getEventDetail($select_where = 0, $where = '')
	{
        if ($select_where== 0)
		{
			 return " * ";
		}
		if ($select_where == 2)
		{
			return "tb_sitesectionswidgets";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}//end of get event detail

	public function whojoinevents($select_where = 0, $where = '')
	{
		if ($select_where== 0)
		{
			return " * ";
		}
		if ($select_where == 2)
		{
			return "tb_join_event";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}

	public function admin_operations($select_where = 0, $where = '')
	{
		if ($select_where == 0) {
			return " * ";
		}
		if ($select_where == 2) {
			return "tb_admin_operations";
		} else {
			return " 1 = 1 $where ";
		}
	}
	
	public function admin_roles_permissions($select_where = 0, $where = '')
	{
		if ($select_where == 0) {
			return " * ";
		}
		if ($select_where == 2) {
			return "tb_admin_roles_permissions";
		} else {
			return " 1 = 1 $where ";
		}
	}

	public function emergency_roster_form( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " erf.*, u.name as user_name ";
		}
		if ($select_where == 2)
		{
			return "tb_emergency_roster_form erf join `imi_conf_restore2`.tb_users u ON u.id = erf.user_id";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	public function joined_events( $select_where = 0, $where = '' )
	{
        if ($select_where == 0) {
            return "je.*,sw.title";
        }
        if ($select_where == 2) {
            return "tb_join_event je inner join tb_sitesectionswidgets sw ON sw.id = je.eventid";
        } else {
            return " 1 = 1 $where ";
        }
	}
	
	public function interviewers( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  a.*  ";
		}
		if ($select_where == 2)
		{
			return " tb_admin a LEFT JOIN tb_admin_roles ar ON ar.id = a.roleid";
		}
		else
		{
			return " 1 = 1 and ar.name = 'Interviewer' ";
		}
	}

	public function card_payments( $select_where = 0, $where = '' )
	{
		if ($select_where == 0) {
			return "  *  ";
		}
		if ($select_where == 2) {
			return 'tb_card_payments';
		} else {
			return ' 1 = 1 and payment_id in ( select id from tb_donation_payments where table_name = "tb_donation_form" and table_id_name = "id" and table_id_value IN ( select id from ( select *,(CASE WHEN donation_freq = "M-1" THEN DATE_ADD(date_added, INTERVAL ((num_of_recurring + 1) * 1) MONTH) WHEN donation_freq = "M-3" THEN DATE_ADD(date_added, INTERVAL ((num_of_recurring + 1) * 3) MONTH) WHEN donation_freq = "M-6" THEN DATE_ADD(date_added, INTERVAL ((num_of_recurring + 1) * 6) MONTH) WHEN donation_freq = "Y-1" THEN DATE_ADD(date_added, INTERVAL ((num_of_recurring + 1) * 12) MONTH)  END ) as next_recurring_date from tb_donation_form where donation_mode = "recurring" having next_recurring_date = CURDATE() order by next_recurring_date asc ) a ) ) and SUBSTRING_INDEX(card_expiry,"/",1) >= DATE_FORMAT(CURDATE(),"%m") and SUBSTRING_INDEX(card_expiry,"/",-1) >= DATE_FORMAT(CURDATE(),"%y") ';
		}
	}

	public function sight_seeing( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " *, 
					 (SELECT countries_name FROM tb_countries WHERE id = tb_sight_seeing.countryid) as country_name,
					 (CASE WHEN (status = 1) THEN 'Yes' ELSE 'No' END) as status_name ";
		}
		if ($select_where == 2)
		{
			return "tb_sight_seeing";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function spotlight( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *  ";
		}
		if ($select_where == 2)
		{
			return " tb_spotlight ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function short_conference( $select_where = 0, $where = '' )
	{
		
		$this->db->_protect_identifiers		= false;
		
		
		if ($select_where == 0)
		{
			return "  *,  
					(SELECT countries_name FROM tb_countries WHERE id = tb_short_conference.countryid) as country_name,
					(SELECT countries_iso_code_2 FROM tb_countries WHERE id = tb_short_conference.countryid) as country_code,
					(CASE WHEN (status = 1) THEN 'Yes' ELSE 'No' END) as status_name ";
		}
		if ($select_where == 2)
		{
			return " tb_short_conference";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function short_conference_sight_seeing( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			
			return "  *, (SELECT name FROM tb_short_conference WHERE id = tb_short_conference_sight_seeing.conferenceid) as conference_name ";
		}
		if ($select_where == 2)
		{
			return " tb_short_conference_sight_seeing ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}

	public function short_conference_prices_master( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " 	*, 
						(SELECT name FROM tb_short_conference WHERE id = tb_short_conference_prices_master.conferenceid) as conference_name,
						(SELECT id FROM  tb_short_conference_who_attend WHERE id = tb_short_conference_prices_master.whoattendid) as whoattend_id,
						(SELECT name FROM  tb_short_conference_who_attend WHERE id = tb_short_conference_prices_master.whoattendid) as whoattend_name,
						(SELECT no_of_people FROM  tb_short_conference_who_attend WHERE id = tb_short_conference_prices_master.whoattendid) as whoattend_weight,
						
						(SELECT description FROM  tb_short_conference_who_attend WHERE id = tb_short_conference_prices_master.whoattendid) as whoattend_description,
						(SELECT image_icon FROM  tb_short_conference_who_attend WHERE id = tb_short_conference_prices_master.whoattendid) as whoattend_image_icon,
						
						(SELECT name FROM  tb_short_conference_regions WHERE id = tb_short_conference_prices_master.regionid) as region_name,
						(SELECT show_rates_in_currency	 FROM  tb_short_conference_regions WHERE id = tb_short_conference_prices_master.regionid) as show_rates_in_currency	 ";
						/*						(CASE WHEN (earlybird_price > 0) THEN 'Yes' ELSE 'No' END) as is_earlybird */
		}
		if ($select_where == 2)
		{
			return " tb_short_conference_prices_master ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function short_conference_regions( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " 	*, 
						(SELECT name FROM tb_short_conference WHERE id = tb_short_conference_regions.conferenceid) as conference_name,
						(CASE WHEN (allow_payment = 1) THEN 'Yes' ELSE 'No' END) as allow_payment_name";
		}
		if ($select_where == 2)
		{
			return " tb_short_conference_regions ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function short_conference_who_attend( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "	*,
					(SELECT name FROM tb_short_conference WHERE id = tb_short_conference_who_attend.conferenceid) as conference_name ";
		}
		if ($select_where == 2)
		{
			return " tb_short_conference_who_attend ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function short_conference_prices_details( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return 	" 	*, 
					(SELECT title FROM `tb_short_conference_prices_master` where id = tb_short_conference_prices_details.parentid) as prices_title,
					(SELECT description FROM `tb_short_conference_prices_master` where id = tb_short_conference_prices_details.parentid) as prices_description,
					(SELECT parent_id FROM `tb_short_conference_prices_master` where id = tb_short_conference_prices_details.parentid) as prices_parent_id,
					(SELECT (SELECT name FROM `tb_short_conference_who_attend` where id = tb_short_conference_prices_master.whoattendid) FROM `tb_short_conference_prices_master` where id = tb_short_conference_prices_details.parentid) as whoattend_nam,
					(SELECT is_addon FROM `tb_short_conference_prices_master` where id = tb_short_conference_prices_details.parentid) as is_addon
					";
						/*						(CASE WHEN (earlybird_price > 0) THEN 'Yes' ELSE 'No' END) as is_earlybird */
		}
		if ($select_where == 2)
		{
			return " tb_short_conference_prices_details ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function short_conference_registration( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " * ";
		}
		if ($select_where == 2)
		{
			return "tb_short_conference_registration";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function users_profile( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " * ";
		}
		if ($select_where == 2)
		{
			return "tb_users_profile";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function short_conference_registration_master( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " *, 
					 (SELECT name FROM imiportal_2.tb_short_conference WHERE id = imiportal_2.tb_short_conference_registration_master.conferenceid) as conference_name,
					  (SELECT CONCAT (name, ' ', last_name) FROM imi_conf_restore2.tb_users WHERE id = imiportal_2.tb_short_conference_registration_master.userid) as user_name,
					 
					 (SELECT name FROM  imiportal_2.tb_short_conference_regions WHERE id = imiportal_2.tb_short_conference_registration_master.regionid) as region_name,
					 
					 (SELECT show_rates_in_currency	 FROM  imiportal_2.tb_short_conference_regions WHERE id = imiportal_2.tb_short_conference_registration_master.regionid) as show_rates_in_currency	,
					 
					  (SELECT email FROM  imi_conf_restore2.tb_users WHERE id = imiportal_2.tb_short_conference_registration_master.userid) as user_email,
					 
					  (SELECT email FROM  imiportal_2.tb_short_conference_registration_screen_one WHERE conferenceregistrationid = imiportal_2.tb_short_conference_registration_master.id ) as email ,
					 (SELECT phone FROM  imiportal_2.tb_short_conference_registration_screen_one WHERE conferenceregistrationid = imiportal_2.tb_short_conference_registration_master.id ) as phone ,	
		
					  (SELECT password FROM  imi_conf_restore2.tb_users WHERE id = imiportal_2.tb_short_conference_registration_master.userid) as user_password";
		}
		if ($select_where == 2)
		{
			return "tb_short_conference_registration_master";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}

	public function short_conference_registration_screen_one( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " * ";
		}
		if ($select_where == 2)
		{
			return "tb_short_conference_registration_screen_one";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	
	public function short_conference_registration_screen_one_family_details( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " *, (SELECT name FROM imi_conf_restore2.tb_family_relationships WHERE id = tb_short_conference_registration_screen_one_family_details.family_relationship) as family_relationship_name";
		}
		if ($select_where == 2)
		{
			return "tb_short_conference_registration_screen_one_family_details";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	
	public function short_conference_registration_screen_two( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " *, 
					(SELECT price FROM `tb_short_conference_prices_not_a_member` WHERE id = tb_short_conference_registration_screen_two.be_a_member_fee) as be_a_member_fee_price  ";
		}
		if ($select_where == 2)
		{
			return "tb_short_conference_registration_screen_two";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	
	
	public function short_conference_registration_screen_two_details( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " * ";
		}
		if ($select_where == 2)
		{
			return "tb_short_conference_registration_screen_two_details";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}

	public function short_conference_registration_screen_three( $select_where = 0, $where = '' )
	{
		$this->db->_protect_identifiers		= false;
		
		if ($select_where == 0)
		{
			return " *, 

					(SELECT date_added FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as conference_master_date_added,

					(SELECT name FROM `tb_short_conference`  WHERE id IN ( (SELECT conferenceid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid))) as conference_name,
			
					(SELECT CONCAT (name, ' ', last_name) FROM imi_conf_restore2.tb_users  WHERE id IN ( (SELECT userid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid))) as user_name,
					
					(SELECT payment_allow FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as  payment_allow,
					
					(SELECT payment_type FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as  payment_type,
					
					(SELECT userid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as userid,
					
					(SELECT conferenceid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as conferenceid,
					
					(SELECT regionid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as region_id,
					
					(SELECT show_rates_in_currency	 FROM  tb_short_conference_regions WHERE id IN ((SELECT regionid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ))) as region_show_rates_in_currency	,

					(SELECT  travelling_with FROM  tb_short_conference_registration_screen_one WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as travelling_with,
					
					(CASE WHEN ((SELECT   coupon_code  FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) != '' ) THEN 'Yes' ELSE 'No' END) as is_coupon_code  ,
		
					(SELECT   coupon_code  FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid )  as coupon_code  ,
		
					(SELECT CONCAT(name, ' :: $', price) FROM `tb_short_conference_prices_not_a_member` WHERE id = (SELECT be_a_member_fee  FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid )  ) as be_a_member_fee_desc  ,
					
					(SELECT  price_total_payable FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as  price_total_payable ,
					
					(SELECT  price_cash_onsite FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as  price_cash_onsite ,
					
					(SELECT  price_less_absfee FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as  price_less_absfee  ,
					
					(SELECT  earlybird_regular FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as earlybird_regular  ,
		
		(SELECT  be_a_member FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as be_a_member  ,
		
		(SELECT  price_package_fee FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as price_package_fee  ,
		
		(SELECT  speaker_coupon_code FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as speaker_coupon_code  ,
		
		(SELECT  paymenttypeid FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as paymenttypeid  ,
					
					(CASE WHEN ((SELECT  price_less_absfee FROM  tb_short_conference_registration_screen_two WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) > 0 ) THEN 'Yes' ELSE 'No' END) as is_abstract_submitted,
					
					(SELECT is_paid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid ) as is_paid,
					
					(SELECT date_added FROM tb_short_conference_payments WHERE conference_registration_id = tb_short_conference_registration_screen_three.conferenceregistrationid AND payment_status = 'Completed' LIMIT 1) as registration_date,
					
					(SELECT  email FROM  tb_short_conference_registration_screen_one WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as email ,
					
					(SELECT phone FROM  tb_short_conference_registration_screen_one WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid ) as phone ,
					
					phone as phone_screen_3,
		
					email as email_screen_3,
					
					(CASE WHEN ((SELECT is_paid FROM  tb_short_conference_registration_master WHERE id = tb_short_conference_registration_screen_three.conferenceregistrationid) = 1 ) THEN 'Yes' ELSE 'No' END) as is_paid_name,
					
					(SELECT family_email FROM `tb_short_conference_registration_screen_one_family_details` WHERE id = tb_short_conference_registration_screen_three.screen_one_detail_id) as family_email,
					
					(SELECT name FROM imi_conf_restore2.tb_family_relationships WHERE id = (SELECT family_relationship FROM `tb_short_conference_registration_screen_one_family_details` WHERE id = tb_short_conference_registration_screen_three.screen_one_detail_id)) as family_relationship ";
		}
		/**/
		if ($select_where == 2)
		{
			return "tb_short_conference_registration_screen_three";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}

	public function family_relationships( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  * ";
		}
		if ($select_where == 2)
		{
			return "  tb_family_relationships ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function short_conference_residence_country_notes( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " 	*, 
						(SELECT name FROM tb_short_conference WHERE id = tb_short_conference_residence_country_notes.conferenceid) as conference_name,
						(SELECT countries_name FROM tb_countries WHERE id = tb_short_conference_residence_country_notes.country_id) as country_name,
						(CASE WHEN (allow_payment_for_this_country = 1) THEN 'Yes' ELSE 'No' END) as allow_payment_for_this_country_name, ";
		}
		if ($select_where == 2)
		{
			return " tb_short_conference_residence_country_notes ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function short_conference_prices_not_a_member( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " 	*, 
						(SELECT name FROM tb_short_conference WHERE id = tb_short_conference_prices_not_a_member.conferenceid) as conference_name";
		}
		if ($select_where == 2)
		{
			return " tb_short_conference_prices_not_a_member ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function short_conference_prices_not_a_member_languages( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *  ";
		}
		if ($select_where == 2)
		{
			return " tb_short_conference_prices_not_a_member_languages ";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function conf_users( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return " * ";
		}
		if ($select_where == 2)
		{
			return "imi_conf_restore2.tb_users";	
		}
		else
		{
			return " 1 = 1 $where ";
		}
	}
	public function tb_all_payments_compiled_for_paypal( $select_where = 0, $where = '' )
	{
		return "SELECT 
		df.first_name, df.last_name, df.donation_mode, df.tax_receipt_num,df.email,
		cn.countries_name,
		apc.df_id,apc.um_id,apc.sc_id,
		ptd.card_holder_name, ptd.transaction_amount, ptd.transaction_status, ptd.transaction_id, ptd.custom_field, ptd.transaction_event_code, ptd.email_address, ptd.item_name, ptd.transaction_initiation_date as date, 
		u.name, u.last_name as user_last_name, u.email as user_email,
		pr.receipt_number,
		dp.name as reason,
		'paypal' as payment_type
	  	FROM 
		tb_all_payments_compiled apc 
		LEFT JOIN tb_donation_form df ON apc.df_id = df.id 
		LEFT JOIN `imi_conf_restore2`.tb_user_memberships um ON apc.um_id = um.id 
		LEFT JOIN tb_short_conference_registration_master sc ON apc.sc_id = sc.id 
		INNER JOIN tb_external_payments ep ON apc.external_payment_id = ep.id 
		INNER JOIN tb_paypal_transaction_data ptd ON ep.transaction_paypal_id = ptd.id
		LEFT JOIN `imi_conf_restore2`.tb_countries cn ON cn.id = df.home_country
		LEFT JOIN `imi_conf_restore2`.tb_users u ON um.user_id = u.id
		LEFT JOIN tb_payment_receipts pr ON um.id = pr.table_id_value AND 'tb_user_memberships' = pr.table_name
		LEFT JOIN tb_donation_projects dp ON df.donation_projects_id = dp.id
		WHERE DATE(ptd.transaction_initiation_date) >= SUBDATE(CURRENT_DATE, 180)";
	}
}