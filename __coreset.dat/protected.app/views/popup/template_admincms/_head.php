<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_pagetitle;?> - <?php echo SessionHelper::_get_session("SITE_META_TITLE", "site_settings");?></title>

<base href="<?php echo site_url();?>" />

<meta name="viewport" content="width=device-width, initial-scale=1.0" />





<?php $this->load->view("popup/template_admincms/_includes.php");?>

</head>