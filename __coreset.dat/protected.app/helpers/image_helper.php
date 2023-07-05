<?php
class ImageHelper 
{
	function __construct()
	{
		parent::__construct();
		
	}

	function create_transporttype_image_table($data, $column_name = "", $param = "") 
	{
		
		$res 			= "<table $param >";
		$max_data 		= sizeof($data);
		$ctr 			= 1;
		
		foreach ($data as $db_data) 
		{
			if ($ctr % 2 == 0)
			{
				$res .= '<td align="center">' . $db_data[ $column_name ]. '</td></tr>';
			}
			else 
			{
				if ($ctr < $max_data) 
				{
					$res .= '<tr><td align="center">' . $db_data[ $column_name ]. '</td>';
				}
				else 
				{
					$res .= '<tr><td colspan="2" align="center">' . $db_data[ $column_name ]. '</td></tr>';
				}
			}
			
			
			$ctr++;
		}
		
		return $res . '</table>';
		
	}
}