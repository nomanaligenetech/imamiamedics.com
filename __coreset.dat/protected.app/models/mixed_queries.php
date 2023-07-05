<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Mixed_Queries extends Queries
{
	public function __construct()
	{
		parent::__construct();
	} 
	
	
	
	public function sightseeing_by_conference( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *  ";
		}
		if ($select_where == 2)
		{
			return " tb_sight_seeing  ";	
		}
		else
		{
			return " 1 = 1  AND id in (SELECT sight_seeingid FROM `tb_conference_sight_seeing` WHERE conferenceid = ". SessionHelper::_get_session("id", "conference") .") $where ";
		}
	}
	
	
	public function conf_academic_partners_by_conference( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *  ";
		}
		if ($select_where == 2)
		{
			return "  tb_conference_academic_partners_details  ";	
		}
		else
		{
			return " 1 = 1  AND parentid  in (SELECT id FROM `tb_conference_academic_partners` WHERE conferenceid = ". SessionHelper::_get_session("id", "conference") .") $where ";
		}
	}
	
	
	public function conference_sustaining_associate_partners( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *  ";
		}
		if ($select_where == 2)
		{
			return "  tb_conference_sustaining_associate_partners_details ";	
		}
		else
		{
			return " 1 = 1  AND parentid  in (SELECT id FROM `tb_conference_sustaining_associate_partners` WHERE conferenceid = ". SessionHelper::_get_session("id", "conference") .") $where ";
		}
	}
	
	
	public function chapterpersons_by_boardid( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  * ";
		}
		if ($select_where == 2)
		{
			return "  tb_chapterpersons_master ";	
		}
		else
		{
			
			$tmp_where						= "";
			if ( is_array( $where ) )
			{
				if( isset( $where["boardid"] )  )
				{
					$boardid			= $where["boardid"];
				}
				
				
				if( isset( $where["extra_cond"] ) )
				{
					$tmp_where				.= $where["extra_cond"];
				}
				
			}
			
			
			
			
			return " 1 = 1  AND id IN (SELECT parentid FROM `tb_chapterpersons_details` WHERE boardid = ". $boardid .") $tmp_where ";
		}
	}
	
	
	public function abstractformapproval_notcommented( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  *  ";
		}
		if ($select_where == 2)
		{
			return "  tb_abstract_submission_form_approval ";	
		}
		else
		{
			return " 1 = 1  AND id NOT IN (SELECT parentid FROM `tb_abstract_submission_form_approval_details`)  $where ";
		}
	}
	
	
	public function totalcountconferenceregistration_parentchild( $select_where = 0, $where = '' )
	{
		if ($select_where == 0)
		{
			return "  (SELECT count(*) FROM tb_conference_registration WHERE parentid = t.id) as count ";
		}
		if ($select_where == 2)
		{
			return "   tb_conference_registration t ";	
		}
		else
		{
			return " 1 = 1   $where ";
		}
	}
	
	public function previous_conference_master_and_detail( $select_where = 0, $where = '' )
	{
		$this->db->_protect_identifiers		= false;
		
		if ($select_where == 0)
		{
			return " m.*, d.*, m.id as id, (SELECT name FROM tb_conference WHERE id = m.conferenceid) as conference_name, 
					(SELECT theme FROM tb_conference WHERE id = m.conferenceid) as conference_theme ";
		}
		if ($select_where == 2)
		{
			return " tb_previous_conference m, tb_previous_conference_details d ";	
		}
		else
		{
			$tmp_where						= "";
			
			if ( is_array( $where ) )
			{
				
				if( isset( $where["not_conferenceid"] )  )
				{
					$tmp_where				.= " AND m.conferenceid not in ( '". $where["not_conferenceid"] ."' ) ";
				}
				
				
				if( isset( $where["conferenceid"] )  )
				{
					$tmp_where				.= " AND m.conferenceid = '". $where["conferenceid"] ."' ";
				}
				
				
				if( isset( $where["extra_cond"] ) )
				{
					$tmp_where				.= $where["extra_cond"];
				}
				
			}
			
			
			
			
			
			
			return " 1 = 1  AND m.id = d.parentid $tmp_where ";
		}
	}
	
	
	public function conference_prices_master_and_detail( $select_where = 0, $where = '' )
	{
		$this->db->_protect_identifiers		= false;
		
		if ($select_where == 0)
		{
			return " m.*, d.*, m.id as id, (SELECT name FROM tb_conference WHERE id = m.conferenceid) as conference_name, 
					(SELECT theme FROM tb_conference WHERE id = m.conferenceid) as conference_theme ";
		}
		if ($select_where == 2)
		{
			return "  tb_conference_prices_master m,  tb_conference_prices_details d ";	
		}
		else
		{
			return " 1 = 1   AND m.id = d.parentid  $where ";
		}
	}
	
	
	
	public function conference_content_with_menu( $select_where = 0, $where = '' )
	{
		$this->db->_protect_identifiers		= false;
		
		if ($select_where == 0)
		{
			return " m.*, d.*, m.id as id, (SELECT name FROM tb_conference WHERE id = m.conferenceid) as conference_name, 
					(SELECT theme FROM tb_conference WHERE id = m.conferenceid) as conference_theme ";
		}
		if ($select_where == 2)
		{
			return "   tb_conferencemenu m,  tb_conferencecontent d ";	
		}
		else
		{
			return " 1 = 1   AND m.id = d.menuid  $where ";
		}
	}
}
?>