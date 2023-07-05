<?php

if(!empty($_POST['file']))
{
	//echo $_POST['file'];
	$file_name = $_POST['file'];
	
	if ( file_exists ( $file_name ) )
	{
		unlink($file_name);
	}
	elseif ( file_exists ( "." . $file_name ) )
	{
		unlink( "." . $file_name);
	}
	elseif ( file_exists ( $_SERVER['DOCUMENT_ROOT'] . "/" . $file_name ) )
	{
		unlink( $_SERVER['DOCUMENT_ROOT'] . "/" . $file_name );
	}
	else
	{
		
	}
}

?>