<?php 
$this->load->view("global/Mobile_Detect.php"); 
$detect 			= new Mobile_Detect;
$deviceType 		= ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
$scriptVersion 		= $detect->getScriptVersion();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_pagetitle;?> - <?php echo SessionHelper::_get_session("SITE_META_TITLE", "site_settings");?></title>
<base href="<?php echo site_url();?>" />

<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('/assets/frontend/images/favicon.png?v=2'); ?>">

<meta name="viewport" content="width=device-width, initial-scale=1" />





<?php $this->load->view("frontend/template_account/_includes.php");?>

</head>