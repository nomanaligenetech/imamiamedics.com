<style>
.error_style{ display:none;}
.inline_error_style .error_style{ display:block;}
</style>
<script Language="JavaScript">
    var objappVersion = navigator.appVersion;
    var browserAgent = navigator.userAgent;
    var browserName = navigator.appName;
    var browserVersion = '' + parseFloat(navigator.appVersion);
    var browserMajorVersion = parseInt(navigator.appVersion, 10);
    var Offset, OffsetVersion, ix, latestVersion, latestversion ; 

    // For Chrome
    if ((OffsetVersion = browserAgent.indexOf("Chrome")) != -1) {
        browserName = "Chrome";
        latestversion = '106';
        browserVersion = browserAgent.substring(OffsetVersion + 7);
    }

    // // For Microsoft internet explorer
    // else if ((OffsetVersion = browserAgent.indexOf("MSIE")) != -1) {
    //     browserName = "Microsoft Internet Explorer";
    //     browserVersion = browserAgent.substring(OffsetVersion + 5);
    // }

    // For Firefox
    else if ((OffsetVersion = browserAgent.indexOf("Firefox")) != -1) {
        browserName = "Firefox";
        browserVersion = browserAgent.substring(OffsetVersion + 7);
        latestversion = '105';
    }

    // For Safari
    else if ((OffsetVersion = browserAgent.indexOf("Safari")) != -1) {
        browserName = "Safari";
        latestversion = '16';
        browserVersion = browserAgent.substring(OffsetVersion + 7);
        if ((OffsetVersion = browserAgent.indexOf("Version")) != -1)
            browserVersion = browserAgent.substring(OffsetVersion + 8);
    }

    // For other browser "name/version" is at the end of userAgent
    else if ((Offset = browserAgent.lastIndexOf(' ') + 1) <
        (OffsetVersion = browserAgent.lastIndexOf('/'))) {
        browserName = browserAgent.substring(Offset, OffsetVersion);
        browserVersion = browserAgent.substring(OffsetVersion + 1);
        if (browserName.toLowerCase() == browserName.toUpperCase()) {
            browserName = navigator.appName;
        }
    }

    // Trimming the fullVersion string at
    // semicolon/space if present
    if ((ix = browserVersion.indexOf(";")) != -1)
        browserVersion = browserVersion.substring(0, ix);
    if ((ix = browserVersion.indexOf(" ")) != -1)
        browserVersion = browserVersion.substring(0, ix);


    browserMajorVersion = parseInt('' + browserVersion, 10);
    if (isNaN(browserMajorVersion)) {
        browserVersion = '' + parseFloat(navigator.appVersion);
        browserMajorVersion = parseInt(navigator.appVersion, 10);
    }
    
    if( browserMajorVersion < latestversion){
        alert('Important: we value your privacy, security and registration experience. The browser you are using is not compatible with this website. Your personal and financial details may be at risk due to the browser version you are using and you may also have issues completing a smooth registration. Please use Chrome or update your browser to '+latestversion+' version or higher. You can also call Br Hasnain at +1 (347) 839-6672 to securely register over the phone.');
    }
</script>
<?php 
    // if (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') && !strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome')) {
    //     $browser = 'Safari';
    // }
?>
<div class="screen_one_status">
    <div class="conf-reg-page-top">
        <h1><?php echo lang_line('text_conferenceregistration');?></h1>
        <p><?php echo conference_fullname( $conference );?></p>
        <span><?php echo conference_durationdates( $conference );?> </span>
    </div>
    
    


  	<?php $this->load->view("frontend/template/_confregistrationbreadcrumbs.php");?>
    
    
    
    <p>&nbsp;</p>
    
    
    
    
    
    <?php
    $attributes 			= array("method"		=> "post",
                                    "enctype"		=> "multipart/form-data",
                                    "name"			=> "form1",
                                    "id"			=> "form1");
    
    echo form_open(site_url( uri_string() ), $attributes);
	
	
	
	
	$data["_messageBundle"]				= $_messageBundle2;
	?>
	<div class="inline_error_style"><?php $this->load->view('frontend/template/_show_messages.php', $data); ?> </div>
    
    
    <input  class="bluebuttons btnSubmit" name="submitform" type="submit" value="Submit" style="display:none;" />
    
    
    
    <p class="align_center m_bottom25" ><strong>Note</strong> : In case of technical support, please reach out to <a href="mailto:neelam.raheel@genetechsolutions.com">neelam.raheel@genetechsolutions.com</a> or send whastapp message +92-3002522862. Live help with immediate assistance via WhatsApp is available from <strong>8:00 pm CST - 1:00 pm CST</strong>.</p>

    <div class="conf-reg-page-table">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="48%">
    				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tbody class="s-form-flex">
                            <tr class="field-block">
                                <td><label>Title   : <?php echo required_field('fontsize_1-4em');?></label></td>
                                <td width="100%"><?php

                                        $tmp_name = 'prefix';
                                        
                                        echo form_dropdown('prefix', DropdownHelper::prefix_dropdown(), set_value( $tmp_name, $$tmp_name ) === 0 ? '' : set_value( $tmp_name, $$tmp_name ), "class='form-control ". set_class( 'prefix' ) ." '" );
                                        echo form_error("prefix");
                                        ?></td>
                            </tr>
                            
                            <tr class="field-block">
                                <td><label>Name  : <?php echo required_field('fontsize_1-4em');?> </label> </td>
                                <td width="100%"><?php
                                $tmp_name		= 'name';
                                $tmp_value      = set_value( $tmp_name, $$tmp_name ) === 0 ? '' : set_value( $tmp_name, $$tmp_name );
                                $specdata		= array("name"			=> $tmp_name,
                                                        "id"			=> $tmp_name,
                                                        
                                                        "type"			=> "text",
                                                        "class"			=> set_class( $tmp_name ),
                                                        "value"			=> set_value( $tmp_name, $$tmp_name ) === 0 ? '' : set_value( $tmp_name, $$tmp_name ) ,
                                                        "placeholder"	=> "Name");	
                                // var_dump(set_value( $tmp_name, $$tmp_name ) === 0 ? ' ' : set_value( $tmp_name, $$tmp_name ) );
                                echo form_input($specdata);
                                echo form_error( $tmp_name );
                                ?>
                                    <small class="passport_note">(as it appears on your passport)</small>
                                </td>
                            </tr>
                            
                            <tr class="field-block">
                                <td><label>Email : <?php echo required_field('fontsize_1-4em');?></label></td>
                                <td><?php
                                    $tmp_name		= 'email';
                                    $tmp_value      = set_value( $tmp_name, $$tmp_name ) === 0 ? '' : set_value( $tmp_name, $$tmp_name );
                                    $specdata		= array("name"			=> $tmp_name,
                                                            "id"			=> $tmp_name,
                                                            
                                                            "type"			=> "text",
                                                            "class"			=> set_class( $tmp_name ),
                                                            "value"			=> set_value( $tmp_name, $$tmp_name ) === 0 ? '' : set_value( $tmp_name, $$tmp_name ) ,
                                                            "placeholder"	=> "Email");	
                            
                                    echo form_input($specdata);
                                    echo form_error( $tmp_name );
                                    ?>
                                </td>
                            </tr>
                            
                            <tr class="field-block">
                                <td><label>Phone : <?php echo required_field('fontsize_1-4em');?></label></td>
                                <td><?php
                                        $tmp_name		= 'phone';
                                        $specdata		= array("name"			=> $tmp_name,
                                                                "id"			=> $tmp_name,
                                                                
                                                                "type"			=> "text",
                                                                "class"			=> set_class( $tmp_name ),
                                                                "value"			=> set_value( $tmp_name, $$tmp_name ),
                                                                "placeholder"	=> "Phone");	
                                        
                                        echo form_input($specdata);
                                        echo form_error( $tmp_name );
                                        ?></td>
                            </tr>
                            
                        </tbody>
                  </table>
                </td>
                

                <!-- <td width="48%" valign="top">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                            
                            
                        </tbody>
                    </table>
                </td> -->
            </tr>
        </table>
    </div>
    
    
    <div class="conf-reg-page-table num_fam_table">

        <!-- CODE BY RIDA WAS REMOVED TO IMPLEMENT NEW CODE -->

        <!-- ISMAIL CODE FOR FAMILY MEMBER REGISTRATION TABLE -->

    <div class="mi-family-relation">
        <div class="mi-family-relation-head">
            <div class="mi-family-relation-head-data">
                 <h3>Number of 
                    <?php 
                    if ( is_conference_registered_for_local() )
                    {
                        ?>
                        Family Members / Persons
                        <?php
                    }
                    else
                    {
                        ?>
                        Family Members 
                        <?php
                    }
                    ?>
                    Accompanying you?
                    
                </h3>
                    
                <div class="mifamily-relation-members">

                <?php
                    $class_weight			= "weight";
                    $array_weight			= $numbers_multiplyby;	
                    $max                    = 8;
                    $min                    = 0;

                                                            ?>
                        <span class="<?php echo $class_weight;?>" >
                        <span class="sub-before add-sub remove-member" ></span>
                        <?php
                        $tmp_mb			= 'multiply_by['. $__ID .']';
                        echo form_number_input('no_of_family_members', 
                        // !empty($no_of_family_members) ? set_value("no_of_family_members", $no_of_family_members) : 0 ,
                            set_value("no_of_family_members", $no_of_family_members) ,
                                            " class='form-control". set_class( $tmp_mb ) ." '" ,
                                            $min,
                                            $max);
                        echo form_error( $tmp_mb );
                ?>
                <span class="add-after add-sub add-member"></span>
                </span>
                <?php
                    
                    $TMP_no					= 0;
                    if ( $conferenceregistration_screenone->num_rows() > 0 )
                    {
                        $TMP_no				= $conferenceregistration_screenone->row("no_of_family_members");
                    }
                ?>
                <input type="hidden" name="hdn_no_of_family_members" value="<?php echo $TMP_no;?>"  />
                </div>
            </div>
            <p class="align_center m_bottom25 m_top25" style="color:white;"><strong>Note: </strong>Please enter the names and details of those family members also registering for the conference, womens wing special program and youth program. For those joining you only for the banquet, please do not add names here-you may buy additional banquet tickets for guests under your own conference registration.</p>
        </div>
        <?php
            if ( set_value("no_of_family_members", $no_of_family_members) )
            {
        ?>
        <div class="mi-family-relation-info">
            <?php
                for($i=0; $i < set_value("no_of_family_members", $no_of_family_members); $i++)
                {
                    $index			= $i;
                    $index++;
            ?>
            <div class="mi-family-relation-info-row">
                <div class="mi-family-relation-info-name">
                    <label >Name:<sup>*</sup></label>
                    <?php
                        $tmp_name		= 'family_name['. $i .']';
                        $specdata		= array("name"			=> $tmp_name,
                                                "id"			=> $tmp_name,
                                                
                                                "type"			=> "text",
                                                "class"			=> set_class( $tmp_name ),
                                                "value"			=> set_value( $tmp_name, $family_name[$i] ),
                                                "placeholder"	=> "Name");	
                
                        echo form_input($specdata);
                        echo form_error( $tmp_name );
                        ?>
                        
                        <?php
                        $tmp_name		= 'family_id['. $i .']';
                        $specdata		= array("name"			=> $tmp_name,
                                                "id"			=> $tmp_name,
                                                
                                                "type"			=> "hidden",
                                                "class"			=> set_class( $tmp_name ),
                                                "value"			=> set_value( $tmp_name, $family_id[$i] ),
                                                "placeholder"	=> "Family ID");	
                
                        echo form_input($specdata);
                        echo form_error( $tmp_name );
                    ?>   
                </div>
                <div class="mi-family-relation-info-email">
                    <label >Email:<sup>*</sup></label>
                    <?php
                        $tmp_name		= 'family_email['. $i .']';
                        $specdata		= array("name"			=> $tmp_name,
                                                "id"			=> $tmp_name,
                                                "type"			=> "text",
                                                "class"			=> set_class( $tmp_name ),
                                                "value"			=> set_value( $tmp_name, $family_email[$i] ),
                                                "placeholder"	=> "Email");	
                
                        echo form_input($specdata);
                        echo form_error( $tmp_name );
                    ?>
                </div>
                <div class="mi-family-relation-info-relation">
                    <label >Relationship:</label>
                    <?php
                        $tmp_name				= 'family_relationship['. $i .']';
                        echo form_dropdown($tmp_name, 
                                            DropdownHelper::relationship_dropdown(), 
                                            set_value($tmp_name, $family_relationship[$i]), 
                                            "class='form-control ". set_class( $tmp_name ) ." '" );
                    ?>
                </div>
                <div class="mi-family-relation-info-age">
                    <label >Age:</label>
                    <?php
                        $tmp_name				= 'family_age['. $i .']';
                        $arrayindex				= NumberHelper::number_array( range("1", "90") );
                        echo form_dropdown($tmp_name, 
                                            $arrayindex, 
                                            set_value($tmp_name, $family_age[$i]), 
                                            "class='form-control ". set_class( $tmp_name ) ." '" );
                    ?>
                </div>
                <div class="mi-family-relation-info-delete">
                <?php
                                
                    if ( set_value( 'family_id['. $i .']', $family_id[$i] ) != '' )
                    {
                    ?>
                        <input type="image"  src="<?php echo base_url("assets/frontend/images/delete_icon.png");?>"  
                        name="delete[<?php echo set_value( $tmp_name, $family_id[$i] );?>]" value="delete" />
                    <?php
                    }
                    else
                    {
                        
                        ?>
                        <a href="javascript:;" onclick="window.location = '<?php echo site_url( uri_string() );?>';">
                            <img  src="<?php echo base_url("assets/frontend/images/delete_icon.png");?>"   />
                        </a>
                        <?php
                        
                    }
                ?>
                </div>
            </div>
            <?php
                    }
                }
            ?>
        </div>
        <?php
            if ( set_value("no_of_family_members", $no_of_family_members) )
            {
        ?>
        <div class="mi-family-relation-msg">
            <p>To remove any 
                <?php
                if ( is_conference_registered_for_local() )
                {
                    ?>
                    Family Member / Person
                    <?php
                }
                else
                {
                    ?>
                    Family Member 
                    <?php
                }
                ?>
                record, please click on the
                <span style="text-decoration:none;font-weight:bold;">
                    delete
                </span> 
                icon.
            </p>
        </div>
        <?php	
                }
        ?>
        <div class="mi-family-relation-btn">
        <input  name="id" type="hidden" value="<?php echo set_value("id", $id);?>" />
                            <input  class="bluebuttons"  type="button" onclick="$(this).attr('disabled', true); $(this).attr('value','Processing'); $('.btnSubmit').click();" value="<?php echo lang_line('text_saveandproceed');?>" />
        </div>
    </div>

    <!-- ISMAIL CODE END -->

    </div>
    <?php
    echo form_close();
    ?>
</div>