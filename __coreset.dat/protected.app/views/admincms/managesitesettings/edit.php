<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    


                        
                        
<table class="table table_form">
    <tr>
        <td class="td_bg fieldKey">
            <div class="">
                               
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                    
                        <li class="active"><a href="#tab_1" data-toggle="tab">Site Settings</a></li>
                        
                        <li><a href="#tab_2" data-toggle="tab">Email Settings</a></li>
                        
                        <li><a href="#tab_3" data-toggle="tab">Paypal</a></li>

                        <li><a href="#tab_4" data-toggle="tab">Payeezy</a></li>
                        
                        <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                    </ul>
                    
                    
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                        	<table class="table table_form">
                            
                            <tr>
                                <td class="fieldKey" valign="top">Site Meta Title <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                    <?php 
                                        $roomdata		= array("name"			=> "site_meta_title",
                                                                "id"			=> "site_meta_title",
                                                                "size"			=> 50,
                                                                "class"			=> "form-control",
                                                                "value"			=> set_value("site_meta_title", $site_meta_title)
                                                                );	
                                        
                                        echo form_input($roomdata);
                                    ?>
                                    </div>
                                </td>
                            </tr>
                            
                            
                            
                            
                            <tr>
                                <td class="fieldKey" valign="top">AdminCMS Meta Title <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                    <?php 
                                        $roomdata		= array("name"			=> "admincms_meta_title",
                                                                "id"			=> "admincms_meta_title",
                                                                "size"			=> 50,
                                                                "class"			=> "form-control",
                                                                "value"			=> set_value("admincms_meta_title", $admincms_meta_title)
                                                                );	
                                        
                                        echo form_input($roomdata);
                                    ?>
                                    </div>
                                </td>
                            </tr>
                            
                            
                            
                            
                            
                            <tr>
                                <td class="fieldKey" valign="top">Get Involved (Select Menu) <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                	<div class="input-group">
                                        <?php 
                                        echo form_dropdown('getinvolved_menuid', DropdownHelper::menu_dropdown(), set_value("getinvolved_menuid", $getinvolved_menuid), "class='form-control '" )?>
                                    </div>
                                    
                                </td>
                            </tr>
                            
                            
                            
                            <tr>
                                <td class="fieldKey" valign="top">What We Do (Select Menu) <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                	<div class="input-group">
                                        <?php 
                                        echo form_dropdown('whatwedo_menuid', DropdownHelper::menu_dropdown(), set_value("whatwedo_menuid", $whatwedo_menuid), "class='form-control '" )?>
                                    </div>
                                    
                                </td>
                            </tr>
                            
                            
                             <tr>
                                <td class="fieldKey" valign="top">Events (Select Menu) <?php #echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                        <?php 
                                        echo form_dropdown('events_menuid', DropdownHelper::menu_dropdown(), set_value("events_menuid", $events_menuid), "class='form-control '" )?>
                                    </div>
                                    
                                </td>
                            </tr>

                            <tr>
                                <td class="fieldKey" valign="top">Super Admin Role (Select Role) <?php #echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                        <?php 
                                        echo form_dropdown('superadmin_roleid', DropdownHelper::adminroles_dropdown(), set_value("superadmin_roleid", $superadmin_roleid), "class='form-control '") ?>
                                    </div>
                                    
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="fieldKey" valign="top">Interviewer for Arbaeen Medical Mission (Select Role) <?php #echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                        <?php 
                                        echo form_dropdown('interviewer_roleid', DropdownHelper::adminroles_dropdown(), set_value("interviewer_roleid", $interviewer_roleid), "class='form-control '") ?>
                                    </div>
                                    
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="fieldKey" valign="top">Arbaeeen Stage 3A Link (Select Menu) <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                	<div class="input-group">
                                        <?php 
                                        echo form_dropdown('stage3a_menuid', DropdownHelper::menu_dropdown(), set_value("stage3a_menuid", $stage3a_menuid), "class='form-control '" )?>
                                    </div>
                                    
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="fieldKey" valign="top">Arbaeeen Stage 3B Link (Select Menu) <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                	<div class="input-group">
                                        <?php 
                                        echo form_dropdown('stage3b_menuid', DropdownHelper::menu_dropdown(), set_value("stage3b_menuid", $stage3b_menuid), "class='form-control '" )?>
                                    </div>
                                    
                                </td>
                            </tr>
                            

                            
                          </table>
            </div><!-- /.tab-pane -->
                
                
                
                        <div class="tab-pane" id="tab_2">
                            <table class="table table_form">
                            
                                <tbody>
                                
                                
                                <tr>
                                  <td class="fieldKey" valign="top">Email Mode</td>
                                  <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                        <?php 
                                        echo form_dropdown('email_mode', DropdownHelper::emailmode_dropdown(), set_value("email_mode", $email_mode), "class='form-control '" )?>
                                    </div>
                                  </td>
                                </tr>
                                
                                
                                <tr>
                                    <td class="fieldKey" valign="top">Email Subject <?php echo required_field(); ?></td>
                                    <td class="fieldValue" colspan="3">
                                        <div class="input-group">
                                        <?php 
                                            $roomdata		= array("name"			=> "email_subject",
                                                                    "id"			=> "email_subject",
                                                                    "size"			=> 50,
                                                                    "class"			=> "form-control",
                                                                    "value"			=> set_value("email_subject", $email_subject)
                                                                    );	
                                            
                                            echo form_input($roomdata);
                                        ?>
                                        </div>
                                    </td>
                                </tr>
                                
                                
                                
                                <tr>
                                    <td class="fieldKey" valign="top">Email From Name <?php echo required_field(); ?></td>
                                    <td class="fieldValue" colspan="3">
                                        <div class="input-group">
                                        <?php 
                                            $roomdata		= array("name"			=> "email_from_name",
                                                                    "id"			=> "email_from_name",
                                                                    "size"			=> 50,
                                                                    "class"			=> "form-control",
                                                                    "value"			=> set_value("email_from_name", $email_from_name)
                                                                    );	
                                            
                                            echo form_input($roomdata);
                                        ?>
                                        </div>
                                    </td>
                                </tr>
                                
        
                                
                                <tr>
                                    <td class="fieldKey">Email From <?php echo required_field(); ?></td>
                                    <td align="left" class="td_bg fieldValue">
                                        <div class="input-group  ">
                                            <span class="input-group ">
                                            <?php
                                            $specdata		= array("name"				=> "email_from",
                                                                    "id"				=> "email_from",
                                                                    "size"				=> 50,
                                                                    "class"				=> "form-control",
                                                                    "value"				=> set_value("email_from", $email_from) );
                                            
                                            echo form_input($specdata);
                                            ?>
                                            </span>
                                        </div>
                                    </td>
                                
                                </tr>
                                
                                
        
                                
                                <tr>
                                <td class="fieldKey">Email To <?php echo required_field(); ?><?php echo $email_desc_text;?></td>
                                <td align="left" class="td_bg fieldValue">
                                    <div class="input-group  "> 
                                        <span class="input-group ">
                                        <?php
                                        $specdata		= array("name"				=> "email_to",
                                                                "id"				=> "email_to",
                                                                "cols"				=> 47,
																"rows"				=> 4,
                                                                "class"				=> "form-control",
                                                                "value"				=> set_value("email_to", $email_to) );
                                        
                                        echo form_textarea($specdata);
                                        ?>
                                        </span> 
                                    </div>
                                </td>
                                </tr>
                                
                                
                                
                                </tbody>
                            
                            </table>
                    </div><!-- /.tab-pane -->
                        
                        
                        
                        <div class="tab-pane" id="tab_3">
                        	<table class="table table_form">
                            
                            <tr>
                                <td class="fieldKey" valign="top">Mode <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                
                                	<div class="input-group">
                                        <?php 
                                        echo form_dropdown('paypal_mode', DropdownHelper::paymentmode_dropdown(), set_value("paypal_mode", $paypal_mode), "class='form-control '" )?>
                                    </div>
                                    
                                </td>
                            </tr>
                            
                            
                            
                            
                            <tr>
                                <td class="fieldKey" valign="top">Sandbox Paypal URL <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                    <?php 
                                        $roomdata		= array("name"			=> "paypal_url_sandbox",
                                                                "id"			=> "paypal_url_sandbox",
                                                                "size"			=> 50,
                                                                "class"			=> "form-control",
                                                                "value"			=> set_value("paypal_url_sandbox", $paypal_url_sandbox)
                                                                );	
                                        
                                        echo form_input($roomdata);
                                    ?>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="fieldKey" valign="top">Live Paypal URL <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                    <?php 
                                        $roomdata		= array("name"			=> "paypal_url_live",
                                                                "id"			=> "paypal_url_live",
                                                                "size"			=> 50,
                                                                "class"			=> "form-control",
                                                                "value"			=> set_value("paypal_url_live", $paypal_url_live)
                                                                );	
                                        
                                        echo form_input($roomdata);
                                    ?>
                                    </div>
                                </td>
                            </tr>
                            
                            
                            <tr>
                                <td class="fieldKey" valign="top">Sandbox Paypal Email <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                    <?php 
                                        $roomdata		= array("name"			=> "paypal_email_sandbox",
                                                                "id"			=> "paypal_email_sandbox",
                                                                "size"			=> 50,
                                                                "class"			=> "form-control",
                                                                "value"			=> set_value("paypal_email_sandbox", $paypal_email_sandbox)
                                                                );	
                                        
                                        echo form_input($roomdata);
                                    ?>
                                    </div>
                                </td>
                            </tr>
                            
                            
                            <tr>
                                <td class="fieldKey" valign="top">Live Paypal Email <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                    <?php 
                                        $roomdata		= array("name"			=> "paypal_email_live",
                                                                "id"			=> "paypal_email_live",
                                                                "size"			=> 50,
                                                                "class"			=> "form-control",
                                                                "value"			=> set_value("paypal_email_live", $paypal_email_live)
                                                                );	
                                        
                                        echo form_input($roomdata);
                                    ?>
                                    </div>
                                </td>
                            </tr>

                            
                            
                            
                            
                            <tr>
                              <td class="td_bg fieldKey">&nbsp;</td>
                              <td class="td_bg fieldValue">&nbsp;</td>
                            </tr>
                            
                            
                          </table>
                          
         			   </div>




                        <div class="tab-pane" id="tab_4">
                        	<table class="table table_form">
                            
                            <tr>
                                <td class="fieldKey" valign="top">Mode <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                
                                	<div class="input-group">
                                        <?php 
                                        echo form_dropdown('payeezy_mode', DropdownHelper::paymentmode_dropdown(), set_value("payeezy_mode", $payeezy_mode), "class='form-control '" )?>
                                    </div>
                                    
                                </td>
                            </tr>
                            
                            
                            
                            
                            <tr>
                                <td class="fieldKey" valign="top">Sandbox Payeezy URL <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                    <?php 
                                        $roomdata		= array("name"			=> "payeezy_url_sandbox",
                                                                "id"			=> "payeezy_url_sandbox",
                                                                "size"			=> 50,
                                                                "class"			=> "form-control",
                                                                "value"			=> set_value("payeezy_url_sandbox", $payeezy_url_sandbox)
                                                                );	
                                        
                                        echo form_input($roomdata);
                                    ?>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="fieldKey" valign="top">Live Payeezy URL <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                    <?php 
                                        $roomdata		= array("name"			=> "payeezy_url_live",
                                                                "id"			=> "payeezy_url_live",
                                                                "size"			=> 50,
                                                                "class"			=> "form-control",
                                                                "value"			=> set_value("payeezy_url_live", $payeezy_url_live)
                                                                );	
                                        
                                        echo form_input($roomdata);
                                    ?>
                                    </div>
                                </td>
                            </tr>
                            
                            
                            <tr>
                                <td class="fieldKey" valign="top">Sandbox Payeezy Exact ID <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                    <?php 
                                        $roomdata		= array("name"			=> "payeezy_exactid_sandbox",
                                                                "id"			=> "payeezy_exactid_sandbox",
                                                                "size"			=> 50,
                                                                "class"			=> "form-control",
                                                                "value"			=> set_value("payeezy_exactid_sandbox", $payeezy_exactid_sandbox)
                                                                );	
                                        
                                        echo form_input($roomdata);
                                    ?>
                                    </div>
                                </td>
                            </tr>
                            
                            
                            <tr>
                                <td class="fieldKey" valign="top">Live Payeezy Exact ID <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                    <?php 
                                        $roomdata		= array("name"			=> "payeezy_exactid_live",
                                                                "id"			=> "payeezy_exactid_live",
                                                                "size"			=> 50,
                                                                "class"			=> "form-control",
                                                                "value"			=> set_value("payeezy_exactid_live", $payeezy_exactid_live)
                                                                );	
                                        
                                        echo form_input($roomdata);
                                    ?>
                                    </div>
                                </td>
                            </tr>


                            <tr>
                                <td class="fieldKey" valign="top">Sandbox Payeezy Password <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                    <?php 
                                        $roomdata		= array("name"			=> "payeezy_password_sandbox",
                                                                "id"			=> "payeezy_password_sandbox",
                                                                "size"			=> 50,
                                                                "class"			=> "form-control",
                                                                "value"			=> set_value("payeezy_password_sandbox", $payeezy_password_sandbox)
                                                                );	
                                        
                                        echo form_input($roomdata);
                                    ?>
                                    </div>
                                </td>
                            </tr>
                            
                            
                            <tr>
                                <td class="fieldKey" valign="top">Live Payeezy Password <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                    <?php 
                                        $roomdata		= array("name"			=> "payeezy_password_live",
                                                                "id"			=> "payeezy_password_live",
                                                                "size"			=> 50,
                                                                "class"			=> "form-control",
                                                                "value"			=> set_value("payeezy_password_live", $payeezy_password_live)
                                                                );	
                                        
                                        echo form_input($roomdata);
                                    ?>
                                    </div>
                                </td>
                            </tr>


                            <tr>
                                <td class="fieldKey" valign="top">Sandbox Payeezy HMAC ID <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                    <?php 
                                        $roomdata		= array("name"			=> "payeezy_hmacid_sandbox",
                                                                "id"			=> "payeezy_hmacid_sandbox",
                                                                "size"			=> 50,
                                                                "class"			=> "form-control",
                                                                "value"			=> set_value("payeezy_hmacid_sandbox", $payeezy_hmacid_sandbox)
                                                                );	
                                        
                                        echo form_input($roomdata);
                                    ?>
                                    </div>
                                </td>
                            </tr>
                            
                            
                            <tr>
                                <td class="fieldKey" valign="top">Live Payeezy HMAC ID <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                    <?php 
                                        $roomdata		= array("name"			=> "payeezy_hmacid_live",
                                                                "id"			=> "payeezy_hmacid_live",
                                                                "size"			=> 50,
                                                                "class"			=> "form-control",
                                                                "value"			=> set_value("payeezy_hmacid_live", $payeezy_hmacid_live)
                                                                );	
                                        
                                        echo form_input($roomdata);
                                    ?>
                                    </div>
                                </td>
                            </tr>


                            <tr>
                                <td class="fieldKey" valign="top">Sandbox Payeezy HMAC Key <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                    <?php 
                                        $roomdata		= array("name"			=> "payeezy_hmackey_sandbox",
                                                                "id"			=> "payeezy_hmackey_sandbox",
                                                                "size"			=> 50,
                                                                "class"			=> "form-control",
                                                                "value"			=> set_value("payeezy_hmackey_sandbox", $payeezy_hmackey_sandbox)
                                                                );	
                                        
                                        echo form_input($roomdata);
                                    ?>
                                    </div>
                                </td>
                            </tr>
                            
                            
                            <tr>
                                <td class="fieldKey" valign="top">Live Payeezy HMAC Key <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                    <?php 
                                        $roomdata		= array("name"			=> "payeezy_hmackey_live",
                                                                "id"			=> "payeezy_hmackey_live",
                                                                "size"			=> 50,
                                                                "class"			=> "form-control",
                                                                "value"			=> set_value("payeezy_hmackey_live", $payeezy_hmackey_live)
                                                                );	
                                        
                                        echo form_input($roomdata);
                                    ?>
                                    </div>
                                </td>
                            </tr>

                            <?php /*<hr/>

                            <tr>
                                <td class="fieldKey" valign="top">Payeezy Token URL <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                    <?php 
                                        $roomdata		= array("name"			=> "payeezy_token_url",
                                                                "id"			=> "payeezy_token_url",
                                                                "size"			=> 50,
                                                                "class"			=> "form-control",
                                                                "value"			=> set_value("payeezy_token_url", $payeezy_token_url)
                                                                );	
                                        
                                        echo form_input($roomdata);
                                    ?>
                                    </div>
                                </td>
                            </tr>                            
                            
                            <tr>
                                <td class="fieldKey" valign="top">Sandbox Payeezy API Key <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                    <?php 
                                        $roomdata		= array("name"			=> "payeezy_apikey_sandbox",
                                                                "id"			=> "payeezy_apikey_sandbox",
                                                                "size"			=> 50,
                                                                "class"			=> "form-control",
                                                                "value"			=> set_value("payeezy_apikey_sandbox", $payeezy_apikey_sandbox)
                                                                );	
                                        
                                        echo form_input($roomdata);
                                    ?>
                                    </div>
                                </td>
                            </tr>
                            
                            
                            <tr>
                                <td class="fieldKey" valign="top">Live Payeezy API Key <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                    <?php 
                                        $roomdata		= array("name"			=> "payeezy_apikey_live",
                                                                "id"			=> "payeezy_apikey_live",
                                                                "size"			=> 50,
                                                                "class"			=> "form-control",
                                                                "value"			=> set_value("payeezy_apikey_live", $payeezy_apikey_live)
                                                                );	
                                        
                                        echo form_input($roomdata);
                                    ?>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="fieldKey" valign="top">Sandbox Payeezy API Secret <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                    <?php 
                                        $roomdata		= array("name"			=> "payeezy_apisecret_sandbox",
                                                                "id"			=> "payeezy_apisecret_sandbox",
                                                                "size"			=> 50,
                                                                "class"			=> "form-control",
                                                                "value"			=> set_value("payeezy_apisecret_sandbox", $payeezy_apisecret_sandbox)
                                                                );	
                                        
                                        echo form_input($roomdata);
                                    ?>
                                    </div>
                                </td>
                            </tr>
                            
                            
                            <tr>
                                <td class="fieldKey" valign="top">Live Payeezy API Secret <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                    <?php 
                                        $roomdata		= array("name"			=> "payeezy_apisecret_live",
                                                                "id"			=> "payeezy_apisecret_live",
                                                                "size"			=> 50,
                                                                "class"			=> "form-control",
                                                                "value"			=> set_value("payeezy_apisecret_live", $payeezy_apisecret_live)
                                                                );	
                                        
                                        echo form_input($roomdata);
                                    ?>
                                    </div>
                                </td>
                            </tr>


                            <tr>
                                <td class="fieldKey" valign="top">Sandbox Payeezy Merchant Token <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                    <?php 
                                        $roomdata		= array("name"			=> "payeezy_mertoken_sandbox",
                                                                "id"			=> "payeezy_mertoken_sandbox",
                                                                "size"			=> 50,
                                                                "class"			=> "form-control",
                                                                "value"			=> set_value("payeezy_mertoken_sandbox", $payeezy_mertoken_sandbox)
                                                                );	
                                        
                                        echo form_input($roomdata);
                                    ?>
                                    </div>
                                </td>
                            </tr>
                            
                            
                            <tr>
                                <td class="fieldKey" valign="top">Live Payeezy Merchant Token <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                    <?php 
                                        $roomdata		= array("name"			=> "payeezy_mertoken_live",
                                                                "id"			=> "payeezy_mertoken_live",
                                                                "size"			=> 50,
                                                                "class"			=> "form-control",
                                                                "value"			=> set_value("payeezy_mertoken_live", $payeezy_mertoken_live)
                                                                );	
                                        
                                        echo form_input($roomdata);
                                    ?>
                                    </div>
                                </td>
                            </tr>


                            <tr>
                                <td class="fieldKey" valign="top">Sandbox Payeezy Transarmor Token <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                    <?php 
                                        $roomdata		= array("name"			=> "payeezy_transtoken_sandbox",
                                                                "id"			=> "payeezy_transtoken_sandbox",
                                                                "size"			=> 50,
                                                                "class"			=> "form-control",
                                                                "value"			=> set_value("payeezy_transtoken_sandbox", $payeezy_transtoken_sandbox)
                                                                );	
                                        
                                        echo form_input($roomdata);
                                    ?>
                                    </div>
                                </td>
                            </tr>
                            
                            
                            <tr>
                                <td class="fieldKey" valign="top">Live Payeezy Transarmor Token <?php echo required_field(); ?></td>
                                <td class="fieldValue" colspan="3">
                                    <div class="input-group">
                                    <?php 
                                        $roomdata		= array("name"			=> "payeezy_transtoken_live",
                                                                "id"			=> "payeezy_transtoken_live",
                                                                "size"			=> 50,
                                                                "class"			=> "form-control",
                                                                "value"			=> set_value("payeezy_transtoken_live", $payeezy_transtoken_live)
                                                                );	
                                        
                                        echo form_input($roomdata);
                                    ?>
                                    </div>
                                </td>
                            </tr>
                            */?>
                            
                            
                            
                            
                            <tr>
                              <td class="td_bg fieldKey">&nbsp;</td>
                              <td class="td_bg fieldValue">&nbsp;</td>
                            </tr>
                            
                            
                          </table>
                          
         			   </div>
                        
                        
                        
                        
                        
                        
                        
                  </div><!-- /.tab-content -->
                </div><!-- nav-tabs-custom -->
                            </div>
        </td>
    </tr>
    
    
</table>
<input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
  <input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />
    
    <div class="crud_controls">
        <button type="submit" data-operationid="managesitesettingssave" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>
        <!--<a class="btn btn-danger btn-flat" data-operationid="managesitesettingsview" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php lang_line("text_cancel");?>
        </a>-->
    </div>

</form>