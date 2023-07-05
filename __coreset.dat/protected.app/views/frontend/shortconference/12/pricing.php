<div class="conf-reg-page-top pak_pricing-top-content">
<h1><?php echo lang_line('text_conferenceregistration'); ?></h1>
<p><?php echo conference_fullname($conference); ?></p>
<span><?php echo conference_durationdates($conference); ?> </span>
<!-- <p class="click-pricing-register">Click below to register now</p>  --></div>



<?php
#if conf. registration is EXPIRED...

if ($this->validations->is_conference_registration_expired(FALSE)) 
{
    $expired_content        = $this->mixed_queries->fetch_records('conference_content_with_menu', " AND m.slug = 'conference-registration-closed' AND m.conferenceid = '" . $conference->row("id") . "' ");

    if ($expired_content->num_rows() > 0) {
        echo $expired_content->row("content");
    }
}
?>
<style>
    h4 {
        margin: 0;
        padding: 0;
        margin-bottom: 5px;
        margin-top: 5px;
    }
</style>
<?php
if ($conference_regions->num_rows() > 0) 
{?>
	<div class="conf-reg-page-content pak_pricing-desciption-content"> <?php echo $this->functions->content_shortcodes($content); ?> </div>
<?php
}
// $pricing_instructions		= $this->mixed_queries->fetch_records('conference_content_with_menu', 
// 																	" AND m.slug = 'conference-pricing-instructions' AND m.conferenceid = '". $conference->row()->id ."' ");

// if ( $pricing_instructions -> num_rows() > 0 )
// {
// 	echo $pricing_instructions->row("content");	
// }
?>







<?php
#if conf. registration is not expired
if (!$this->validations->is_conference_registration_expired(FALSE))
{?>
    <div class="pak_pricing-package-wrapper">
	<?php
    
	$TMP_whoattendlist_types			=  ( DropdownHelper::short_conferenceregistration_paymenttype(TRUE, TRUE) );
	krsort( $TMP_whoattendlist_types );
	#unset($TMP_whoattendlist_types ['others'] );

    ?>
    <!--  <p class="align_center" ><strong>Supported Browsers</strong> : Chrome (105.0.5195.127+) , Safari (15+) , Fire Fox (105.0.1+)</p> -->
        <div class='pricing-tabs'>
            <?php
                foreach (DropdownHelper::short_conferenceprice_earlybird_regular_dropdown() as $pricetype_earlybird_regular => $leavethis)
				{
					$heading_title          	= "";
					$class_title                = "";
					switch ($pricetype_earlybird_regular) 
					{
						case "earlybird_price":
							#$heading_title    	= "Discounted Early Bird Registration";
							$heading_title    	= "Early Birds (Discounted Advance)";
							$class_title        = "active-tab";
                            $data_type          = 'early';
							
					
					
							$TMP_to_date		= $conference->row("registration_from");
							$TMP_to_date		= date("F d, Y ", strtotime( $TMP_to_date ) );
	
							$date_text			=  "Deadline: ". $TMP_to_date ."";
							break;
	
						default:
							$heading_title      = "General Registration";
							#$heading_title      = "Onsite Registration";
                            $data_type          = 'regular';
							
							
							$TMP_to_date		= $conference->row("registration_from");
							$TMP_to_date		= date("F d, Y",  strtotime("+1 day", strtotime( $TMP_to_date )));
	
							$date_text			=  $TMP_to_date . " onwards";										
							break;
					}
                    ?>
                    <?php
                }
                ?>
                <div class="heading-prices" data-type='<?php echo 'early'; ?>'>
                    <!-- <h3>
                        <?php // echo "Conference Registration Rates"; ?>
                    </h3> -->
                    <!-- <span class='pricing-tabs-deadline'>
                        <?php // echo $date_text; ?>
                    </span> -->
                </div>
            
        </div>
        <p class="align_center m_bottom25" >Thank you for your interest in registering for the IMI FATIMA Conference. Online registration is now closed.  On-site registration for the conference will start on Friday, October 28, at 5pm at the Hilton Houston Post Oak Hotel. We look forward to seeing you in Houston!</p>
        <!-- <p class="align_center m_bottom25" ><strong>Note</strong> : In case of technical support, please reach out to <a href="mailto:neelam.raheel@genetechsolutions.com">neelam.raheel@genetechsolutions.com</a> or send whastapp message +92-3002522862. Live help with immediate assistance via WhatsApp is available from <strong>8:00 pm CST - 1:00 pm CST</strong>.</p> -->

    <!-- <div class="alng-mid pricing-btn m_bottom25">
        <?php if(!$this->session->userdata('user_logged_in')){?>
            <a href="<?php echo  site_url("shortconference/" . $conference->row("slug") . "/conference_login"); ?>" style="text-decoration:none">
                  <input class="bluebuttons" type="button" value="Login as IMI Member" />
              </a> 
            <span class="or-text"> Or </span>
              <a href="<?php echo site_url("shortconference/" . $conference->row("slug") . "/registration/screen/1"); ?>" style="text-decoration:none">
              <input class="bluebuttons guest-user-button" type="button" value="Continue as Guest" />
            </a> 
            <span>
                "To avail discount benefits for <strong>IMI Members</strong>, Please Login"
            </span>
        <?php }else{ ?>
            <a href="<?php echo site_url("shortconference/" . $conference->row("slug") . "/registration/screen/1");  ?>" style="text-decoration:none">
                <input class="bluebuttons" type="button" value="Register For Conference" />
            </a> 
        <?php } ?>
	</div> -->
    <?php
	
	if (count($prices_chart['whoattendlist']) > 0  ) 
	{
		?>
        <div class="rates-early-price">
        <div class="reg-ticket-section-table">
                <table class="mi-resp-no" width="100%" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr class="conf-table-head">
                            <th>
                                Conference Registration Rates
                            </th>
                        </tr>
                        <tr>
                            <td>

                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="pkg-table">
                                    <tbody>
                                        <tr class="rates-head">
                                            <th></th>
                                            <th>Rates (Members)</th>
                                            <th>Rates (Non-Members)</th>
                                        </tr>
                                        <?php
                                        
                                            if ( is_array($prices_chart['whoattendlist']['members']) )
                                            {
                                                foreach ($prices_chart['whoattendlist']['members'] as $key => $value)
                                                {
                                                    

                                                    $a = array_keys($value['earlybird_price']);
                                                    $_description = $value['earlybird_price'][$a[0]][1]['whoattend_description'];
                                                    $__description = ( !empty($_description) ) ? $_description : "";
        
        
                                        ?>
                                        <tr>
                                            <td class="pkg-names">
                                                <?php echo $key; ?>
                                                <span class="pkg-description"><?php echo $__description; ?></span>
                                            </td>

                                        <?php
                                            
                                                
                                        ?>
                                        <td class="pkg-prices">
                                            <label>
                                                
                                                <span><?php echo $value['earlybird_price'][$a[0]][2]['pricedisplay'];?></span>
                                                
                                            </label>
                                        </td>
                                        
                                        <td class="pkg-prices">
                                            <label>
                                                
                                                <span><?php echo $value['earlybird_price'][$a[0]][1]['pricedisplay'];?></span>
                                                
                                                <!-- <span class="pak_step-form-package-desc" ><?php echo nl2br( $__DESCFORPRICE );?></span> -->
                                                
                                            </label>
                                        </td>
                                        
                                        </tr>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- CODE BY ISMAIL CONFERENCE FOR REGISTRATION -->

                <div class="mi-conf-reg-main">
                    <div class="mi-conf-reg-main-head">
                        <h3>Conference Registration</h3>
                    </div>
                    <div class="mi-conf-reg-main-info">
                        <div class="mi-conf-reg-main-info-heading">
                            <p>Rates (Members)</p>
                            <p>Rates (Non-Members)</p>
                        </div>
                        <?php
                        
                            if ( is_array($prices_chart['whoattendlist']['members']) )
                            {
                                foreach ($prices_chart['whoattendlist']['members'] as $key => $value)
                                {
                                    

                                    $a = array_keys($value['earlybird_price']);
                                    $_description = $value['earlybird_price'][$a[0]][1]['whoattend_description'];
                                    $__description = ( !empty($_description) ) ? $_description : "";
                    
                    
                        ?>
                        <div class="mi-conf-reg-main-info-pkg">
                            <div class="mi-conf-reg-main-info-pkg-row">
                                <div class="mi-conf-reg-main-info-pkg-name">
                                    <h4><?php echo $key; ?></h4>
                                    <span><?php echo $__description; ?></span>
                                </div>
                                <div class="mi-conf-reg-main-info-pkg-price">
                                    <p><?php echo $value['earlybird_price'][$a[0]][2]['pricedisplay'];?></p>
                                    <p><?php echo $value['earlybird_price'][$a[0]][1]['pricedisplay'];?></p>
                                </div>
                            </div>
                        </div>
                        <?php
                                }
                            }
                        ?>
                    </div>
                </div>

                <!-- END OD CODE -->

            </div>
            <?php

            foreach($prices_chart['whoattendlist']['addons']['earlybird_price'] as $addondetail){
            ?>
            <div class="reg-ticket-section-table">
                <table class="mi-resp-no" width="100%" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr class="conf-table-head">
                            <th>
                                <?php echo $addondetail[2]['title_for_price']; ?>
                            </th>
                        </tr>
                        <tr>
                            <td>

                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="pkg-table">
                                    <tbody>
                                        <tr class="rates-head">
                                            <th></th>
                                            <th>Rates (Members)</th>
                                            <th>Rates (Non-Members)</th>
                                        </tr>
                                        

                                        <?php
                                            if(key_exists('addon', $addondetail)){
                                                foreach($addondetail['addon'] as $addon_child){
                                                ?>
                                                <tr>
                                                    
                                            <td class="pkg-names">
                                                <?php echo $addon_child[2]['title_for_price']; ?>
                                                <span class="pkg-description"><?php echo $addon_child[2]['description_for_price']; ?></span>
                                            </td>
                                            <td class="pkg-prices">
                                            <label>
                                                
                                                
                                                    <span><?php echo $addon_child[2]['pricedisplay']; ?></span>
                                                
                                                <!-- <span class="pak_step-form-package-desc" ><?php echo nl2br( $__DESCFORPRICE );?></span> -->
                                                
                                            </label>
                                        </td>
                                        
                                        <td class="pkg-prices">
                                            <label>
                                                
                                                    <span><?php echo $addon_child[1]['pricedisplay']; ?></span>
                                                
                                                <!-- <span class="pak_step-form-package-desc" ><?php echo nl2br( $__DESCFORPRICE );?></span> -->
                                                
                                            </label>
                                        </td>
                                                </tr>
                                                <?php
                                                    }
                                                    }else{
                                                
                                        ?>
                                        <tr>
                                            <td class="pkg-names">
                                                <?php echo $addondetail[2]['title_for_price']; ?>
                                                <span class="pkg-description"><?php echo $addon_child[2]['description_for_price']; ?></span>
                                            </td>
                                        <td class="pkg-prices">
                                            <label>
                                                
                                                
                                                    <span><?php echo $addondetail[2]['pricedisplay']; ?></span>
                                                
                                                <!-- <span class="pak_step-form-package-desc" ><?php echo nl2br( $__DESCFORPRICE );?></span> -->
                                                
                                            </label>
                                        </td>
                                        
                                        <td class="pkg-prices">
                                            <label>
                                                    <span><?php echo $addondetail[1]['pricedisplay']; ?></span>
                                                
                                                <!-- <span class="pak_step-form-package-desc" ><?php echo nl2br( $__DESCFORPRICE );?></span> -->
                                                
                                            </label>
                                        </td>
                                        </tr>
                                        <?php 
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- CODE BY ISMAIL FOR ADDONS -->

                <div class="mi-conf-reg-main">
                    <div class="mi-conf-reg-main-head">
                        <h3><?php echo $addondetail[2]['title_for_price']; ?></h3>
                    </div>
                    <div class="mi-conf-reg-main-info">
                        <div class="mi-conf-reg-main-info-heading">
                            <p>Rates (Members)</p>
                            <p>Rates (Non-Members)</p>
                        </div>
                        <?php
                        
                        
                            if(key_exists('addon', $addondetail)){
                            foreach($addondetail['addon'] as $addon_child){
                        ?>
                        <div class="mi-conf-reg-main-info-pkg">
                            <div class="mi-conf-reg-main-info-pkg-row">
                                <div class="mi-conf-reg-main-info-pkg-name">
                                    <h4><?php echo $addon_child[2]['title_for_price']; ?></h4>
                                </div>
                                <div class="mi-conf-reg-main-info-pkg-price">
                                    <p><?php echo $addon_child[2]['pricedisplay']; ?></p>
                                    <p><?php echo $addon_child[1]['pricedisplay']; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php
                            }
                            }else{
                                                            
                        ?>
                        <div class="mi-conf-reg-main-info-pkg">
                            <div class="mi-conf-reg-main-info-pkg-row">
                                <div class="mi-conf-reg-main-info-pkg-name">
                                    <h4><?php echo $addondetail[2]['title_for_price']; ?></h4>
                                </div>
                                <div class="mi-conf-reg-main-info-pkg-price">
                                    <p><?php echo $addondetail[2]['pricedisplay']; ?></p>
                                    <p><?php echo $addondetail[1]['pricedisplay']; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php 
                            }
                        ?>
                    </div>
                </div>

    <!-- END OF CODE -->

            </div>
        <?php
        }
	}
	?>

</div>
    <div class="rates-regular-price" style="display: none;">
        <div class="reg-ticket-section-table">
                <table class="mi-resp-no" width="100%" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr class="conf-table-head">
                            <th>
                                Conference Registration
                            </th>
                        </tr>
                        <tr>
                            <td>

                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="pkg-table">
                                    <tbody>
                                        <tr class="rates-head">
                                            <th></th>
                                            <th>Rates (Members)</th>
                                            <th>Rates (Non-Members)</th>
                                        </tr>
                                        <?php
                                        
                                            if ( is_array($prices_chart['whoattendlist']['members']) )
                                            {
                                                foreach ($prices_chart['whoattendlist']['members'] as $key => $value)
                                                {
                                                    

                                                    $a = array_keys($value['regular_price']);
                                                    $_description = $value['regular_price'][$a[0]][1]['whoattend_description'];
                                                    $__description = ( !empty($_description) ) ? $_description : "";
        
        
                                        ?>
                                        <tr>
                                            <td class="pkg-names">
                                                <?php echo $key; ?>
                                                <span class="pkg-description"><?php echo $__description; ?></span>
                                            </td>

                                        <?php
                                            
                                                
                                        ?>
                                        <td class="pkg-prices">
                                            <label>
                                                    <span><?php echo $value['regular_price'][$a[0]][2]['pricedisplay'];?></span>
                                                
                                                <!-- <span class="pak_step-form-package-desc" ><?php echo nl2br( $__DESCFORPRICE );?></span> -->
                                                
                                            </label>
                                        </td>
                                        
                                        <td class="pkg-prices">
                                            <label>
                                                
                                                    <span><?php echo $value['regular_price'][$a[0]][1]['pricedisplay'];?></span>
                                                
                                                <!-- <span class="pak_step-form-package-desc" ><?php echo nl2br( $__DESCFORPRICE );?></span> -->
                                                
                                            </label>
                                        </td>
                                        
                                        </tr>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- FOR RAGULAR RATES -->

                <!-- CODE BY ISMAIL CONFERENCE FOR REGISTRATION -->

                <div class="mi-conf-reg-main">
                    <div class="mi-conf-reg-main-head">
                        <h3>Conference Registration</h3>
                    </div>
                    <div class="mi-conf-reg-main-info">
                        <div class="mi-conf-reg-main-info-heading">
                            <p>Rates (Members)</p>
                            <p>Rates (Non-Members)</p>
                        </div>
                        <?php
                                                    
                            if ( is_array($prices_chart['whoattendlist']['members']) )
                            {
                                foreach ($prices_chart['whoattendlist']['members'] as $key => $value)
                                {
                                    

                                    $a = array_keys($value['regular_price']);
                                    $_description = $value['regular_price'][$a[0]][1]['whoattend_description'];
                                    $__description = ( !empty($_description) ) ? $_description : "";
                    
                    
                        ?>
                        <div class="mi-conf-reg-main-info-pkg">
                            <div class="mi-conf-reg-main-info-pkg-row">
                                <div class="mi-conf-reg-main-info-pkg-name">
                                    <h4><?php echo $key; ?></h4>
                                    <span><?php echo $__description; ?></span>
                                </div>
                                <div class="mi-conf-reg-main-info-pkg-price">
                                    <p><?php echo $value['regular_price'][$a[0]][2]['pricedisplay'];?></p>
                                    <p><?php echo $value['regular_price'][$a[0]][1]['pricedisplay'];?></p>
                                </div>
                            </div>
                        </div>
                        <?php
                                }
                            }
                        ?>
                    </div>
                </div>

                <!-- END OF CODE -->

            </div>

            <?php

            foreach($prices_chart['whoattendlist']['addons']['regular_price'] as $addondetail){
                
            ?>
            <div class="reg-ticket-section-table">
                <table class="mi-resp-no" width="100%" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr class="conf-table-head">
                            <th>
                                <?php echo $addondetail[2]['title_for_price']; ?>
                            </th>
                        </tr>
                        <tr>
                            <td>

                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="pkg-table">
                                    <tbody>
                                        <tr class="rates-head">
                                            <th></th>
                                            <th>Rates (Members)</th>
                                            <th>Rates (Non-Members)</th>
                                        </tr>
                                        

                                        <?php
                                            if(key_exists('addon', $addondetail)){
                                                foreach($addondetail['addon'] as $addon_child){
                                                ?>
                                                <tr>
                                            <td class="pkg-names">
                                                <?php echo $addon_child[2]['title_for_price']; ?>
                                                <span class="pkg-description"><?php echo $addon_child[2]['description_for_price']; ?></span>
                                            </td>
                                            <td class="pkg-prices">
                                            <label>
                                                
                                                    <span><?php echo $addon_child[2]['pricedisplay']; ?></span>
                                                
                                                <!-- <span class="pak_step-form-package-desc" ><?php echo nl2br( $__DESCFORPRICE );?></span> -->
                                                
                                            </label>
                                        </td>
                                        
                                        <td class="pkg-prices">
                                            <label>
                                                    <span><?php echo $addon_child[1]['pricedisplay']; ?></span>
                                                
                                                <!-- <span class="pak_step-form-package-desc" ><?php echo nl2br( $__DESCFORPRICE );?></span> -->
                                                
                                            </label>
                                        </td>
                                                </tr>
                                                <?php
                                                    }
                                            }else{
                                                
                                        ?>
                                        <tr>
                                            <td class="pkg-names">
                                                <?php echo $addondetail[2]['title_for_price']; ?>
                                                <span class="pkg-description"><?php echo $addon_child[2]['description_for_price']; ?></span>
                                            </td>
                                        <td class="pkg-prices">
                                            <label>
                                                
                                                    <span><?php echo $addondetail[2]['pricedisplay']; ?></span>
                                                
                                                <!-- <span class="pak_step-form-package-desc" ><?php echo nl2br( $__DESCFORPRICE );?></span> -->
                                                
                                            </label>
                                        </td>
                                        
                                        <td class="pkg-prices">
                                            <label>
                                                
                                                    <span><?php echo $addondetail[1]['pricedisplay']; ?></span>
                                                
                                                <!-- <span class="pak_step-form-package-desc" ><?php echo nl2br( $__DESCFORPRICE );?></span> -->
                                                
                                            </label>
                                        </td>
                                        </tr>
                                        <?php 
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- CODE BY ISMAIL FOR ADDONS -->

                <div class="mi-conf-reg-main">
                    <div class="mi-conf-reg-main-head">
                        <h3><?php echo $addondetail[2]['title_for_price']; ?></h3>
                    </div>
                    <div class="mi-conf-reg-main-info">
                        <div class="mi-conf-reg-main-info-heading">
                            <p>Rates (Members)</p>
                            <p>Rates (Non-Members)</p>
                        </div>
                        <?php
                            if(key_exists('addon', $addondetail)){
                                foreach($addondetail['addon'] as $addon_child){
                        ?>
                        <div class="mi-conf-reg-main-info-pkg">
                            <div class="mi-conf-reg-main-info-pkg-row">
                                <div class="mi-conf-reg-main-info-pkg-name">
                                    <h4><?php echo $addon_child[2]['title_for_price']; ?></h4>
                                </div>
                                <div class="mi-conf-reg-main-info-pkg-price">
                                    <p><?php echo $addon_child[2]['pricedisplay']; ?></p>
                                    <p><?php echo $addon_child[1]['pricedisplay']; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php
                            }
                            }else{
                                                            
                        ?>
                        <div class="mi-conf-reg-main-info-pkg">
                            <div class="mi-conf-reg-main-info-pkg-row">
                                <div class="mi-conf-reg-main-info-pkg-name">
                                    <h4><?php echo $addondetail[2]['title_for_price']; ?></h4>
                                </div>
                                <div class="mi-conf-reg-main-info-pkg-price">
                                    <p><?php echo $addondetail[2]['pricedisplay']; ?></p>
                                    <p><?php echo $addondetail[1]['pricedisplay']; ?></p>
                                </div>
                            </div>
                        </div>
                        <?php 
                            }
                        ?>
                    </div>
                </div>


                <!-- END OF CODE -->

            </div>
        <?php
        }
	?>



    </div>
    </div>

    </div>
    
   <!--  <div class="alng-mid pricing-btn">
        <?php if(!$this->session->userdata('user_logged_in')){?>
            <a href="<?php echo  site_url("shortconference/" . $conference->row("slug") . "/conference_login"); ?>" style="text-decoration:none">
                  <input class="bluebuttons" type="button" value="Login as IMI Member" />
              </a> 
            <span class="or-text"> Or </span>
              <a href="<?php echo site_url("shortconference/" . $conference->row("slug") . "/registration/screen/1"); ?>" style="text-decoration:none">
              <input class="bluebuttons guest-user-button" type="button" value="Continue as Guest" />
            </a> 
            <span>
                "To avail discount benefits for <strong>IMI Members</strong>, Please Login"
            </span>
        <?php }else{ ?>
            <a href="<?php echo site_url("shortconference/" . $conference->row("slug") . "/registration/screen/1");  ?>" style="text-decoration:none">
                <input class="bluebuttons" type="button" value="Register For Conference" />
            </a> 
        <?php } ?>
	</div> -->
    
    
	<script>
        $('.pricing-tabs > div').on('click', function(){
            elem = $(this);
            if(!elem.hasClass('active-tab')){
                elem.addClass('active-tab');
                elem.siblings().removeClass('active-tab');
// console.log(elem.data('type'))
                if(elem.data('type') == 'early'){
                    $('.rates-regular-price').hide();
                    $('.rates-early-price').show();
                }else{
                    $('.rates-regular-price').show();
                    $('.rates-early-price').hide();
                }
            }
            console.log($(this));
        });
    </script>
<?php
}
?>