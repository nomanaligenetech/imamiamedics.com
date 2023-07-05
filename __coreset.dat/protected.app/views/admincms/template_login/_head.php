<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $_pagetitle . SessionHelper::_get_session("ADMINCMS_META_TITLE", "site_settings");?></title>
        
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('/assets/admincms/img/favicon.png?v=2'); ?>">
        
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        
        
        <?php $this->load->view("admincms/template_login/_includes.php");?>
        
    </head>
