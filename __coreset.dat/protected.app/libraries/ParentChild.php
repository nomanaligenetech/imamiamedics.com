<?php 	
class ParentChild {	

   /* 
	* Class Name : ParentChild
	* Purpose : This class is made for populating a tree/list of items based on the parent child relationships among them with unlimited level of hierarchy . 
	* Author : Mrinal Nandi <nandi.mrinal2005@gmail.com> - mrinal.0fees.net 
	* Copyright (c) Mrinal Nandi 
	* 
	* Permission is hereby granted, free of charge, to any person obtaining a copy
	* of this script/software , to deal in the Script/Software without restriction, including without limitation the rights
	* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
	* copies of the Script/Software, and to permit persons to whom the Script/Software is
	* furnished to do so, subject to the following conditions:
	* 
	* The above copyright notice, the information about the author and this permission notice shall be included in
	* all copies or substantial portions of the Script/Software.
	* 
	* THE SCRIPT/SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	* OUT OF OR IN CONNECTION WITH THE SCRIPT/SOFTWARE OR THE USE OR OTHER DEALINGS IN
	* THE SCRIPT/SOFTWARE.
	* 
	*/
	
	//properties which hold database and table related information  : start 	
	var $db_host;
	var $db_user;
	var $db_pass;
	var $db_database;
	var $db_table; 
	var $db_groupname;
	
	
	var $item_identifier_field_name;  //may be the primary key of the table : as decided by the db designer 
	var $parent_identifier_field_name; //the fileld name in the table which holds the value of the item_identifier_field_name any item's parent	: as decided by the db designer
	var $item_list_field_name; //field name in the table whose value will be shown in the list or tree (like name or any id etc.) : as choosen by the programmer 
	
	var $extra_condition="";  //if any extra condition should be added with the query : as desided by the programmer 
	var $order_by_phrase="";  //if any order by phrase should be added with the query : as desided by the programmer 
	//properties which hold database and table related information  : end
	
	
	
	var $level_identifier = "  ";  //no. of level of any item as per the generated tree : it will appear number of level times before the item in the list/tree
	var $item_pointer = "|-"; 
	
	
	
	var $all_childs = array(); //contains the entire tree or list starting from a given root element
	
	var $item_path = array(); //contains the total path of a given element/node(the list of elements starting from the top level root node to the given element/node)
	
	
	public function ParentChild()
	{
		$this->CI			=& get_instance();
		
		$this->db			= array();
	}
	
	public function getAllChilds($Parent_ID, $level_identifier="", $start=true, $extra_select="*", $db_details = false) 
	{ 
		
		if ( !$db_details )
		{
			$this->db										= $this->CI->db;
		}
		else
		{
			$this->db										= $db_details;
		}
	
		
		// get all the childs of all the levels under a parent as a tree		
		$immediate_childs=$this->getImmediateChilds($Parent_ID,  $this->extra_condition, $this->order_by_phrase, $extra_select);
		if(count($immediate_childs)) {
			foreach($immediate_childs as $chld) {
				$chld[$this->item_list_field_name]=$level_identifier.$this->item_pointer.$chld[$this->item_list_field_name];
				array_push($this->all_childs,$chld);
				$this->getAllChilds($chld[$this->item_identifier_field_name], ($level_identifier.$this->level_identifier), false, $extra_select);
			}
		}
		if($start) {
			return $this->all_childs; 
		}
	} 
	
	private function getImmediateChilds($parent_identifier_field_value, $extra_condition="", $order_by_phrase="", $extra_select="*") { // get only the direct/immediate childs under a parent 
		
		
		$sql		= "SELECT {$extra_select} FROM `".$this->db_table."` WHERE `".$this->parent_identifier_field_name."`='".$parent_identifier_field_value."' ".$extra_condition." ".$order_by_phrase;
		$res		= $this->db->query( $sql );
		
		
		// var_dump($this->db->last_query());die;
		$childs		= array();
		
		foreach ( $res->result_array() as $val )
		{
			array_push($childs,$val);
		}
		
		return $childs;	
	}
	
	public function getItemPath($item_id,$start=true){ //returns the total path of a given item/node(the list of elements starting from the top level root node to the given item/node)
		
		if($item_id != 0) {
			echo $sql="SELECT * FROM `".$this->db_table."` WHERE `".$this->item_identifier_field_name."`='".$item_id."' ";
			die;
			$res=mysql_query($sql);
			$itemdata=mysql_fetch_assoc($res);
			array_push($this->item_path,$itemdata); 
		
			if($itemdata[$this->parent_identifier_field_name]!=0) {
				$this->item_path=$this->getItemPath($itemdata[$this->parent_identifier_field_name],false);
			} 
			if ($start) {
				$this->item_path=array_reverse($this->item_path);
			}
		}
		return $this->item_path;
		
	}
	
	public function db_connect(){
		$conn = mysql_connect($this->db_host, $this->db_user, $this->db_pass); 
		if($conn) {
			mysql_select_db($this->db_database, $conn);
		} 
		return $conn;
	}
	
	public function db_disconnect(){
		mysql_close();
	}
} 
?>