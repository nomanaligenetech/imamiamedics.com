<?php 
$this->load->view("global/Mobile_Detect.php"); 
$detect 			= new Mobile_Detect;
$deviceType 		= ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
$scriptVersion 		= $detect->getScriptVersion();


#rao:1-12-2014
if ( $_show_default_title )
{
	if ( $_pagetitle != "" )
	{
		$_pagetitle		.= " - ";	
	}
	$_pagetitle				.= SessionHelper::_get_session("SITE_META_TITLE", "site_settings");
}
else
{
	$_pagetitle				.= "";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="<?php echo http_https(FALSE, FALSE, 'http://www.w3.org/1999/xhtml');?>">

<head>
<meta name="viewport" content="initial-scale=1, maximum-scale=1"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/frontend/images/favicon.png'); ?>">
<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.6/css/flag-icon.min.css" integrity="sha256-YjcCvXkdRVOucibC9I4mBS41lXPrWfqY2BnpskhZPnw=" crossorigin="anonymous" />
<script src='https://www.google.com/recaptcha/api.js'></script>

<title><?php echo $_pagetitle;?></title>
<base href="<?php echo site_url();?>" />


<!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />-->





<?php $this->load->view("frontend/template/_includes.php");?>


</head>