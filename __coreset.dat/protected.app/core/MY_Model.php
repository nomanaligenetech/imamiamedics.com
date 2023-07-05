<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property CI_DB_mysqli_driver db
 */
class MY_Model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}


	function is_field_available($field, $field_value, $id = 0, $table)
	{
		$this->db->_protect_identifiers		= false;
		
		if ( $id  != '' )
		{
			$id			= "AND id != '". $id ."'";
		}
		else
		{
			$id			= '';	
		}
		
		$query			= $this->fetch_records( $table, " AND $field = '". $field_value ."'  " . $id, '1' );
		
		return $query->num_rows() == 0;
	}
	
	function make_slug($table, $id, $field, $title_field,  $TEXT_title, $TEXT_id, $CI_db = FALSE)
	{
		if ( !$CI_db )
		{
			$CI_db		= $this->db;
		}
		
		$config 		= array('table' 		=> $table,
								'id' 			=> $id,
								'field' 		=> $field,
								'title' 		=> $title_field,
								'replacement' 	=> 'dash',
								'CI_db'			=> $CI_db);
		
		
		$this->load->library('slug', $config);

		return $this->slug->create_uri(array($title_field	=> $TEXT_title), $TEXT_id);
		
		
		
		
		$slug = preg_replace('/\W/ism','-',trim(strtolower($name)));
		
		// Check here the slug
		if (!$this->is_field_available($alias, $slug, $id, $table))
		{
			$newslug = $slug . rand(0, 99);
			// Check again
			if (!$this->is_field_available($alias, $newslug, $id, $table))
			{
				$this->make_slug( $newslug, $id, $alias, $table );
			}
			else
			{
				
				return $newslug;
			}
		}
		
		else
		{
			// slug not found in our database. Let's use this
			return $slug;
		}
	}
	
	function make_slugss($name, $id=0, $alias = 'alias', $table = '')
	{
		$slug = preg_replace('/\W/ism','-',trim(strtolower($name)));
		// Check here the slug
		if (!$this->is_field_available($alias, $slug, $id, $table))
		{
			$newslug = $slug . rand(0, 99);
			// Check again
			if (!$this->is_field_available($alias, $newslug, $id, $table))
			{
				$this->make_slugss( $newslug, $id, $alias, $table );
			}
			else
			{
				
				return $newslug;
			}
		}
		
		else
		{
			// slug not found in our database. Let's use this
			return $slug;
		}
	}


    /**
     * @return CI_DB_mysqli_result
     */
	public function fetch_records_imiconf($table, $where = '', $select_where = '', $limit = 0, $start = 0 ) 
	{ 	// echo $table.'<br>';
		// 0 = select fields, 1 = where clause, 2 = return table name
	
		#{$this->db_imiconf->database}
		
		$this->db_imiconf->_protect_identifiers		= false;
		
		if ( $limit == 0 and $start == 0 )
		{
			
		}
		else
		{
			$this->db_imiconf->limit($limit, $start);
		}
	
		
		if ( $select_where == "" )
		{
			
			$this->db_imiconf->select( 	$this->$table(0) );
		}
		else
		{
			$this->db_imiconf->select( 	$select_where );
		}
		
		

	
		$this->db_imiconf->where( 	$this->$table(1, $where), NULL, FALSE );
		
		$query 						= $this->db_imiconf->get( $this->$table(2) );
		
		
	
		#$query 					= $this->db->get( $table );
	
		return $query;
	}
	
	

	public function fetch_records($table, $where = '', $select_where = '', $limit = 0, $start = 0 ) 
	{ 	// echo $table.'<br>';
		// 0 = select fields, 1 = where clause, 2 = return table name
	//echo $table."/".$where;

		if ( $limit == 0 and $start == 0 )
		{
			
		}
		else
		{
			$this->db->limit($limit, $start);
		}
	
		
		if ( $select_where == "" )
		{
			
			$this->db->select( 	$this->$table(0) );

			//echo $this->db->last_query();

			#var_dump($this->$table(0));die;
		}
		else
		{
			$this->db->select( 	$select_where );
		}
		
		

	
		$this->db->where( 	$this->$table(1, $where), NULL, FALSE );
		
		$query 						= $this->db->get( $this->$table(2) );
		
		
	
		#$query 					= $this->db->get( $table );
		
		return $query;
	}
	
	function SaveDeleteTables($saveData, $save_delete, $table_name, $colName = '', $where = '')
	{
		if ($colName == '')
		{
			$colName	= 'id';
		}
		else
		{
			$colName	= $colName;
		}
		
		
		if ($where != '')
		{
			$q	= $this->db->query("select * from ".$table_name." ".$where."");
			if ($q->num_rows() > 0)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		
		
		if ($save_delete == 'd')
		{
			$explode_colName	= explode('|', $colName);
			$where_clause		= '';
			for ($x = 0; $x < sizeof($explode_colName); $x++)
			{
				$where_clause	.= $explode_colName[$x]	. ' in ( "' . $saveData[$explode_colName[$x]] . '" ) and ';
			}
			
			$where_clause	= substr($where_clause, 0, strlen($where_clause)-4);

			$this->db->query("delete from ".$table_name." where ".$where_clause."");//".$colName." = '".$saveData[$colName]."'	
		}
		
		if ($save_delete == 's')
		{
			return $this->db->insert($table_name, $saveData); 
		}
		
		if ($save_delete == "e")
		{
			$explode_colName	= explode('|', $colName);
			$where_clause		= '';
			for ($x = 0; $x < sizeof($explode_colName); $x++)
			{
				$this->db->where($explode_colName[$x], $saveData[$explode_colName[$x]]);
			}
			
			#$this->db->where(array("language_id"=>$languages[$a]['id'],"affiliate_id"=>$id));
			#$this->db->where($colName, $saveData[$colName]);
			$saveData = $this->db->escape($saveData);			
			$this->db->update($table_name, $saveData);
		}
		
		
		//dc means DeleteCheck
		if ($save_delete == 'dc')
		{
			//Validate first if this code have Childrens
			$q = $this->db->query("select * from " . $table_name . " where ".$colName." = '".$saveData[$colName]."'");	
			if ($q->num_rows() > 0)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
	}
	
	
	function SaveDeleteTables_imiconf($saveData, $save_delete, $table_name, $colName = '', $where = '')
	{
		if ($colName == '')
		{
			$colName	= 'id';
		}
		else
		{
			$colName	= $colName;
		}
		
		
		if ($where != '')
		{
			$q	= $this->db_imiconf->query("select * from ".$table_name." ".$where."");
			if ($q->num_rows() > 0)
			{
				return false;
			}
			else
			{
				return true;
			}
		}
		
		
		if ($save_delete == 'd')
		{
			$explode_colName	= explode('|', $colName);
			$where_clause		= '';
			for ($x = 0; $x < sizeof($explode_colName); $x++)
			{
				$where_clause	.= $explode_colName[$x]	. ' in ( "' . $saveData[$explode_colName[$x]] . '" ) and ';
			}
			
			$where_clause	= substr($where_clause, 0, strlen($where_clause)-4);

			$this->db_imiconf->query("delete from ".$table_name." where ".$where_clause."");//".$colName." = '".$saveData[$colName]."'	
		}
		
		if ($save_delete == 's')
		{
			$data = $this->db_imiconf->insert($table_name, $saveData); 
			// var_dump($this->db_imiconf->last_query());
			return $data;
			// return $this->db_imiconf->insert($table_name, $saveData); 
		}
		
		if ($save_delete == "e")
		{
			$explode_colName	= explode('|', $colName);
			$where_clause		= '';
			for ($x = 0; $x < sizeof($explode_colName); $x++)
			{
				$this->db_imiconf->where($explode_colName[$x], $saveData[$explode_colName[$x]]);
			}
			
			#$this->db_imiconf->where(array("language_id"=>$languages[$a]['id'],"affiliate_id"=>$id));
			#$this->db_imiconf->where($colName, $saveData[$colName]);
			
			$this->db_imiconf->update($table_name, $saveData);
		}
		
		
		//dc means DeleteCheck
		if ($save_delete == 'dc')
		{
			//Validate first if this code have Childrens
			$q = $this->db_imiconf->query("select * from " . $table_name . " where ".$colName." = '".$saveData[$colName]."'");	
			if ($q->num_rows() > 0)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
	}
	
	
}

//include('Admin_C.php');
//include('Frontend_C.php');
 