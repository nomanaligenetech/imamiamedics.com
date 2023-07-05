<!DOCTYPE html>
<html class="lockscreen">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $_pagetitle . SessionHelper::_get_session("ADMINCMS_META_TITLE", "site_settings");?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        
        
        <?php $this->load->view("admincms/template_lockscreen/_includes.php");?>
        
    </head>
