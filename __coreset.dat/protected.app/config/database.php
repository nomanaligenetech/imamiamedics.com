<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/


$active_group = 'default';
$active_record = TRUE;


/*
$tmp_cred					= json_decode(DATABASE_CRED);

$db['default']['hostname'] 	= $tmp_cred->hostname;
$db['default']['username'] 	= $tmp_cred->username;
$db['default']['password'] 	= $tmp_cred->password;
$db['default']['database'] 	= $tmp_cred->database;


$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;



$tmp_cred						= json_decode(SECRETARY_DATABASE_CRED);
$tmp_group_name						= 'secretary';
$db[$tmp_group_name]['hostname'] 	= $tmp_cred->hostname;
$db[$tmp_group_name]['username'] 	= $tmp_cred->username;
$db[$tmp_group_name]['password'] 	= $tmp_cred->password;
$db[$tmp_group_name]['database'] 	= $tmp_cred->database;


$db[$tmp_group_name]['dbdriver'] 	= 'mysql';
$db[$tmp_group_name]['dbprefix'] 	= '';
$db[$tmp_group_name]['pconnect'] 	= TRUE;
$db[$tmp_group_name]['db_debug'] 	= TRUE;
$db[$tmp_group_name]['cache_on']	= FALSE;
$db[$tmp_group_name]['cachedir']	= '';
$db[$tmp_group_name]['char_set'] 	= 'utf8';
$db[$tmp_group_name]['dbcollat'] 	= 'utf8_general_ci';
$db[$tmp_group_name]['swap_pre']	= '';
$db[$tmp_group_name]['autoinit']	= TRUE;
$db[$tmp_group_name]['stricton']	= FALSE;
*/





$tmp_cred					= json_decode(DATABASE_CRED);

foreach ( $tmp_cred as $credentials )
{

	$db[ $credentials->groupname ]['hostname'] 	= $credentials->hostname;
	$db[ $credentials->groupname ]['username'] 	= $credentials->username;
	$db[ $credentials->groupname ]['password'] 	= $credentials->password;
	$db[ $credentials->groupname ]['database'] 	= $credentials->database;
	
	$db[ $credentials->groupname ]['dbdriver'] = 'mysqli';
	$db[ $credentials->groupname ]['dbprefix'] = '';
	$db[ $credentials->groupname ]['pconnect'] = $credentials->pconnect;
	$db[ $credentials->groupname ]['db_debug'] = FALSE;
	$db[ $credentials->groupname ]['cache_on'] = FALSE;
	$db[ $credentials->groupname ]['cachedir'] = '';
	$db[ $credentials->groupname ]['char_set'] = 'utf8';
	$db[ $credentials->groupname ]['dbcollat'] = 'utf8_general_ci';
	$db[ $credentials->groupname ]['swap_pre'] = '';
	$db[ $credentials->groupname ]['autoinit'] = $credentials->autoinit;
	$db[ $credentials->groupname ]['stricton'] = FALSE;
	
}



/* End of file database.php */
/* Location: ./application/config/database.php */