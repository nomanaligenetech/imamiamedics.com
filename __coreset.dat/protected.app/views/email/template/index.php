<?php
$emailTemplateHelper			= new EmailTemplateHelper();
$data["emailTemplateHelper"]	= $emailTemplateHelper;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"   "<?php echo http_https(FALSE, FALSE, "http://www.w3.org/TR/html4/loose.dtd");?>">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title></title>
    <style>
	.line_breaker {
		margin-top: 20px;
	}
	.details_table{ font-size:13px;}
	.details_table .heading1 { background: none repeat scroll 0 0 #464646; }
	.details_table .heading span, .rooms_details .heading span{ font-size:14px; font-weight:bold; color:white; padding:0px; margin:0px;}
	.details_table span{ }
	.rooms_details { font-size:14px; border: 1px solid #c4c4c4;}
	.rooms_details .left{ color:white;}
	body{ font-family: Tahoma, 'Geneva', 'Kalimati', 'sans-serif'; }
	.empty_tr td{ font-size:1px;}
	h3{ margin: 0!important; padding: 0!important;}
	a:link, a:visited {
		text-decoration: none;
		color: #ec058d; outline: 0;
	}
	
	a:hover {
		text-decoration: underline;
	}
	</style>
</head>

<body style="font-family: Tahoma, 'Geneva', 'Kalimati', 'sans-serif'; margin: 10px; padding: 0; background-color: #ffffff;">
    
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family: Tahoma, 'Geneva', 'Kalimati', 'sans-serif'; margin: 10px; padding: 0; background-color: #ffffff;">
    <tr>
        <td width="600" valign="top">
        
        
            <table width="600" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff; padding: 20px; border: 1px #cccccc dashed;">              
                <tr>
                    <td align="left" width="600" valign="top">
                    
                        <table width="600" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff;">
                        
                            <tr>
                                <td align="left" style="background-color: #ffffff; background-image:url(<?php echo base_url("images/bg_stripes.png");?>); background-repeat:repeat-x;">
                                <a href="<?php echo site_url();?>" target="_blank">
                                    <img src="<?php echo base_url( "assets/frontend/images/logo-".is_countryCheck(true).".png" );?>" width="150" height="145" border="0">
                                </a>
                                </td>
                                
                                <td align="right" style="font-family: Tahoma, 'Geneva', 'Kalimati', 'sans-serif'; font-size: 11px; color: #888888; margin: 0; padding: 0; line-height: 130%; background-image:url(<?php echo base_url("images/bg_stripes.png");?>); background-repeat:repeat-x;">
                                    
                                    Website: 
                                    <a href="<?php echo site_url();?>" target="_blank" style="color: #069;text-decoration: underline;">
                                        <?php echo site_url();?>
                                    </a>
                                </td>
                            </tr>
                            
                            
                            <tr>
                                <td colspan="2" align="left" width="600">
                              
                                <h1 style="font-family: Tahoma, 'Geneva', 'Kalimati', 'sans-serif'; font-size: 18px; color: #069; padding-bottom: 3px; border-bottom: 1px solid #cccccc; margin: 0px; margin-bottom: 0.5em;">
                                
                                    <strong><?php echo $email_heading;?></strong>
                                    
                                </h1>
                                </td>
                            </tr>
                        </table>
                        
                    </td>
                </tr>
               
               
               
               
                <tr>
                    <td valign="top" width="600" style="margin: 0; padding: 10px 0px; background-color: #ffffff; font-size:12px;">
                    
                    
                    <?php $this->load->view( $email_file, $data ) ;?>
                    
                    
                    <!-- End inserted content -->
                    </td>
                </tr>
                
                
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <br />
                        
                        <p style="font-family: Tahoma, 'Geneva', 'Kalimati', 'sans-serif'; font-size: 13px; color: windowframe; text-decoration:underline; margin: 0; padding: 0; line-height: 130%;">
                        <strong><?php  echo is_countryCheck(FALSE,FALSE,TRUE) == 'medics' ? 'The Medics International Team' : "The Imamia Medics International Team"; ?><?php //echo lang_line("email_footer_sign_txt");?></strong>
                        </p>
                    </td>
                </tr>

            </table>
            
            
        </td>
    </tr>
</table>
    
</body>
</html>
        