<?php

/*
 * Helper functions for building a DataTables server-side processing SQL query
 *
 * The static functions in this class are just helper functions to help build
 * the SQL used in the DataTables demo server-side processing scripts. These
 * functions obviously do not represent all that can be done with server-side
 * processing, they are intentionally simple to show how it works. More complex
 * server-side processing operations will likely require a custom script.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */


// REMOVE THIS BLOCK - used for DataTables test environment only!
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/mysql.php';
if ( is_file( $file ) ) {
	include( $file );
}


class SSP {
	
	
	static function append_columns( &$append_columns, $ids_array = array("g.id", "id"), $indexes_array = array(0,4) )
	{
		
		if ( count($ids_array) > 0 )
		{
			$columns 			= array(	
												array( 'db'        	=> $ids_array[0],
													   'alias'		=> $ids_array[1],
													   'dt'        	=> $indexes_array[0],
													   'formatter' 	=> function( $d, $row ) {
															return form_checkbox( array("name" => "checkbox_options[]", "value" => $d)  );
														}
												),
												
												
												array( 'db'        	=> $ids_array[0],
													   'alias'		=> $ids_array[1],
													   'dt'			=> $indexes_array[1],
													   'formatter' 	=> function( $d, $row, $CI ) {
															$operationid = explode('/', $CI->data['_directory']);
															$operationid = $operationid[1].'edit';
															return anchor( site_url ( 	$CI->data['_directory'] . "controls/edit/" . $d), 
																						form_input( array("type"	=> "button",
								"data-operationid"      => $operationid, 
																										  "class"	=> "btn btn-success btn-sm",
																										  "value"	=>lang_line("text_edit")) 
																					)
																		 );
														}
												)
											);
		}
		
		for ($i=0; $i < count($append_columns); $i++)
		{
			$columns[]		= $append_columns[$i];
		}
		
		return $columns;
		
	}
	
	/**
	 * Create the data output array for the DataTables rows
	 *
	 *  @param  array $columns Column information array
	 *  @param  array $data    Data from the SQL get
	 *  @return array          Formatted data in a row based format
	 */
	static function data_output ( $columns, $data )
	{
		$out = array();
		$CI													=& get_instance();

		for ( $i=0, $ien=count($data) ; $i<$ien ; $i++ ) {
			$row = array();

			for ( $j=0, $jen=count($columns) ; $j<$jen ; $j++ ) {
				$column = $columns[$j];


				// Is there a formatter?
				
				
				if ( isset( $column['formatter'] ) ) 
				{
					
					$tmp_alias		= $column['db'];
					if (array_key_exists("alias", $column) )
					{
						$tmp_alias	= $column['alias'];
					}
					 
					$row[ $column['dt'] ] = $column['formatter']( $data[$i][ $tmp_alias ], $data[$i], $CI );
					
				}
				else  
				{
					
					$tmp_alias		= $columns[$j]['db'];
					if (array_key_exists("alias", $columns[$j]) )
					{
						$tmp_alias	= $columns[$j]['alias'];
					}
					
					$row[ $column['dt'] ] = $data[$i][ $tmp_alias ];
				}
			}

			$out[] = $row;
		}

		return $out;
	}


	/**
	 * Paging
	 *
	 * Construct the LIMIT clause for server-side processing SQL query
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $columns Column information array
	 *  @return string SQL limit clause
	 */
	static function limit ( $request, $columns )
	{
		$limit = '';

		if ( isset($request['start']) && $request['length'] != -1 ) {
			$limit = "LIMIT ".intval($request['start']).", ".intval($request['length']);
		}

		return $limit;
	}


	/**
	 * Ordering
	 *
	 * Construct the ORDER BY clause for server-side processing SQL query
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $columns Column information array
	 *  @return string SQL order by clause
	 */
	static function order ( $request, $columns)
	{
		$order = '';

		if ( isset($request['order']) && count($request['order']) ) {
			$orderBy = array();
			$dtColumns = self::pluck( $columns, 'dt' );

			for ( $i=0, $ien=count($request['order']) ; $i<$ien ; $i++ ) {
				// Convert the column index into the column data property
				$columnIdx = intval($request['order'][$i]['column']);
				$requestColumn = $request['columns'][$columnIdx];

				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $columns[ $columnIdx ];

				if ( $requestColumn['orderable'] == 'true' ) {
					$dir = $request['order'][$i]['dir'] === 'asc' ?
						'ASC' :
						'DESC';


					$tmp			= $column['db'];
					if ( array_key_exists('alias', $column) )
					{
						$tmp		= $column['alias'];
					}

					$orderBy[] = ''. $tmp .' '. $dir;
				}
			}

			$order = 'ORDER BY '.implode(', ', $orderBy);
		}

		return $order;
	}


	/**
	 * Searching / Filtering
	 *
	 * Construct the WHERE clause for server-side processing SQL query.
	 *
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here performance on large
	 * databases would be very poor
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $columns Column information array
	 *  @param  array $bindings Array of values for PDO bindings, used in the
	 *    sql_exec() function
	 *  @return string SQL where clause
	 */
	static function filter ( $request, $columns, &$bindings )
	{
		$globalSearch = array();
		$columnSearch = array();
		$dtColumns = self::pluck( $columns, 'dt' );

		if ( isset($request['search']) && $request['search']['value'] != '' ) {
			$str = $request['search']['value'];

			for ( $i=0, $ien=count($request['columns']) ; $i<$ien ; $i++ ) {
				$requestColumn = $request['columns'][$i];
				$columnIdx = array_search( $requestColumn['data'], $dtColumns );
				$column = $columns[ $columnIdx ];

				if ( $requestColumn['searchable'] == 'true' ) 
				{
					$tmp			= $column['db'];
					if ( array_key_exists("where", $column) )
					{
						$tmp		= $column['where'];
					}
					$binding = self::bind( $bindings, '%'.$str.'%', PDO::PARAM_STR );
					$globalSearch[] = "". $tmp ." LIKE ".$binding;
				}
			}
		}

	

		// Individual column filtering
		for ( $i=0, $ien=count(@$request['columns']) ; $i<$ien ; $i++ ) {  
			$requestColumn = $request['columns'][$i];
			$columnIdx = array_search( $requestColumn['data'], $dtColumns );
			$column = $columns[ $columnIdx ];

			$str = $requestColumn['search']['value'];

			if ( $requestColumn['searchable'] == 'true' &&
			 $str != '' ) {
				
				$tmp			= $column['db'];
				if ( array_key_exists("where", $column) )
				{
					$tmp		= $column['where'];
				}
				
				$binding = self::bind( $bindings, '%'.$str.'%', PDO::PARAM_STR );
				$columnSearch[] = "". $tmp ." LIKE ".$binding;
			}
		}
		
		
		// Combine the filters into a single string
		$where = '';


		if ( count( $globalSearch ) ) {
			
		

			$where = '('.implode(' OR ', $globalSearch).')';

		}


		if ( count( $columnSearch ) ) { 

			
			$where = $where === '' ?
				implode(' AND ', $columnSearch) :
				$where .' AND '. implode(' AND ', $columnSearch);
		}

		if ( $where !== '' ) {
			$where = ' AND '.$where;
		}
		
		
		return ( $where );
	}


	/**
	 * Perform the SQL queries needed for an server-side processing requested,
	 * utilising the helper functions of this class, limit(), order() and
	 * filter() among others. The returned array is ready to be encoded as JSON
	 * in response to an SSP request, or can be modified if needed before
	 * sending back to the client.
	 *
	 *  @param  array $request Data sent to server by DataTables
	 *  @param  array $sql_details SQL connection details - see sql_connect()
	 *  @param  string $table SQL table to query
	 *  @param  string $primaryKey Primary key of the table
	 *  @param  array $columns Column information array
	 *  @return array          Server-side processing response array
	 */
	static function simple ( $request, $table, $primaryKey, $columns, $extra_columns = array(), $db_details = false )
	{
		
		$CI													=& get_instance();
		if ( !$db_details )
		{
			
			$db_details										= $CI->db;
		}
		
		// SQL server connection information
		$sql_details = array(
			'user' => $db_details->username,
			'pass' => $db_details->password,
			'db'   => $db_details->database,
			'host' => $db_details->hostname
		);
		
		
		$bindings = array();
		$db = self::sql_connect( $sql_details );

		// Build the SQL query string from the request
		$limit = self::limit( $request, $columns );
		$order = self::order( $request, $columns );
		$where = self::filter( $request, $columns, $bindings );
		
		$tmp_select_columns		= self::pluck($columns, 'db');
		for ($i=0; $i < count($extra_columns); $i++)
		{
			$tmp_select_columns[] = $extra_columns[$i];
		}

		// Main query to actually get the data
		$data = self::sql_exec( $db, $bindings,
			"SELECT SQL_CALC_FOUND_ROWS ".implode(", ", $tmp_select_columns)."
			 FROM $table
			 $where
			 $order
			 $limit",
			 $db_details
		);

		// Data set length after filtering
		$resFilterLength = self::sql_exec( $db, "SELECT FOUND_ROWS() as total_rows", null, $db_details);

		$recordsFiltered = $resFilterLength[0]['total_rows'];

		// Total data set length
		$resTotalLength = self::sql_exec( $db, "SELECT COUNT({$primaryKey}) as total_count FROM   $table", null, $db_details );
		$recordsTotal = $resTotalLength[0]['total_count'];


		/*
		 * Output
		 */
		return array(
			"draw"            => intval( @$request['draw'] ),
			"recordsTotal"    => intval( $recordsTotal ),
			"recordsFiltered" => intval( $recordsFiltered ),
			"data"            => self::data_output( $columns, $data )
		);
	}


	/**
	 * Connect to the database
	 *
	 * @param  array $sql_details SQL server connection details array, with the
	 *   properties:
	 *     * host - host name
	 *     * db   - database name
	 *     * user - user name
	 *     * pass - user password
	 * @return resource Database connection handle
	 */
	static function sql_connect ( $sql_details )
	{
		try {
			$db = @new PDO(
				"mysql:host={$sql_details['host']};dbname={$sql_details['db']}",
				$sql_details['user'],
				$sql_details['pass'],
				array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION )
			);
		}
		catch (PDOException $e) {
			self::fatal(
				"An error occurred while connecting to the database. ".
				"The error reported by the server was: ".$e->getMessage()
			);
		}

		return $db;
	}


	/**
	 * Execute an SQL query on the database
	 *
	 * @param  resource $db  Database handler
	 * @param  array    $bindings Array of PDO binding values from bind() to be
	 *   used for safely escaping strings. Note that this can be given as the
	 *   SQL query string if no bindings are required.
	 * @param  string   $sql SQL query to execute.
	 * @return array         Result from the query (all rows)
	 */
	static function sql_exec ( $db, $bindings, $sql=null, $db_details = false )
	{
		#echo $sql;die;
		$CI													=& get_instance();
		
		if ( !$db_details )
		{
			$db_details		= $CI->db;
		}
		
		
		
		// Argument shifting
		if ( $sql === null ) {
			$sql = $bindings;
		}


		$stmt = $db->prepare( $sql );
		

		// Bind parameters
		if ( is_array( $bindings ) ) {
			for ( $i=0, $ien=count($bindings) ; $i<$ien ; $i++ ) {
				$binding = $bindings[$i];

				$stmt->bindValue( $binding['key'], $binding['val'], $binding['type'] );
				
			
				
				#added by Sadiq
				$Regex 			= '/'. $binding['key'] .'(?![0-9])/m';
				$Str 			= $sql;
				$sql			= preg_replace($Regex,  "'" . mysql_escape_string( $binding['val'] ) . "'" , $Str);



				#it also replaces :binding_1 and :binding_10 .
				#$sql			= str_replace($binding['key'], "'" . $binding['val'] . "'", $sql);

			}
		}
		
		$tmp_result		= $db_details->query( $sql );
	
		return $tmp_result->result_array();
		
					   
					   
		/*// Execute
		try {
			$stmt->execute();
		}
		catch (PDOException $e) {
			self::fatal( "An SQL error occurred: ".$e->getMessage() );
		}

		// Return all
		return $stmt->fetchAll();*/
	}


	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Internal methods
	 */

	/**
	 * Throw a fatal error.
	 *
	 * This writes out an error message in a JSON string which DataTables will
	 * see and show to the user in the browser.
	 *
	 * @param  string $msg Message to send to the client
	 */
	static function fatal ( $msg )
	{
		echo json_encode( array( 
			"error" => $msg
		) );

		exit(0);
	}

	/**
	 * Create a PDO binding key which can be used for escaping variables safely
	 * when executing a query with sql_exec()
	 *
	 * @param  array &$a    Array of bindings
	 * @param  *      $val  Value to bind
	 * @param  int    $type PDO field type
	 * @return string       Bound key to be used in the SQL where this parameter
	 *   would be used.
	 */
	static function bind ( &$a, $val, $type )
	{
		$key = ':binding_'.count( $a );

		$a[] = array(
			'key' => $key,
			'val' => $val,
			'type' => $type
		);

		return $key;
	}


	/**
	 * Pull a particular property from each assoc. array in a numeric array, 
	 * returning and array of the property values from each item.
	 *
	 *  @param  array  $a    Array to get data from
	 *  @param  string $prop Property to read
	 *  @return array        Array of property values
	 */
	static function pluck ( $a, $prop )
	{
		$out = array();

		for ( $i=0, $len=count($a) ; $i<$len ; $i++ ) {
			$out[] = $a[$i][$prop];
		}

		return $out;
	}
}

