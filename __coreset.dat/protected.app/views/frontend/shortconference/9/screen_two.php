<style>
.error_style{ display:none;}
.inline_error_style .error_style{ display:block;}
</style>


<div class="screen_two_status">
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

    
    
    
    <?php $this->load->view("frontend/shortconference/include_screen_two.php");?>
    
    
    <div class="reg-ticket-section">
        <div class="reg-ticket-leftsection">
            <h1>Select your package for: <span class="blue"><?php echo $SUB_HEADING;?></span></h1>
            
            
            
            <input type="hidden" name="hdn_options_selected"  value="<?php echo $LOOP_KEY;?>" />
            <input type="hidden" name="hdn_total_no_of_people_weight"  />
            
            <span class="fromerror_lft"><?php echo form_error("hdn_options_selected");?></span>
            <span class="fromerror_lft"><?php echo form_error("hdn_total_no_of_people_weight");?></span>
            
            <ul class="confreg_price_selection">       
                <?php
                $TMP_perc_dd					= DropdownHelper::short_conferenceprice_earlybird_regular_dropdown(TRUE, TRUE, $conferenceregistration->row_array() );
				#earlybird_price
				#regular_price
			
                foreach ($tmp_earlybird_regular as $e_key => $e_value)
                {
					#members -> Member, NonImember
					#others -> conference registration only
                    foreach ($tmp_paymenttype[ $LOOP_KEY ] as $p_key => $p_value)
                    {
                        
                        
                        $is_imi					= TRUE;
                        $pricetype_id			= $p_key;
                        $eb_regular				= $e_key;
                        $is_disabled			= FALSE;
                        $is_always_disabled		= FALSE;
                        $output_perc			= $TMP_perc_dd[ $eb_regular ];
                        $output_abspaid			= FALSE;
                        
                        switch ( $LOOP_KEY )
                        {
                            #others
                            case "others":
                                $_parentchart_loop			= $prices_chart[ $LOOP_KEY ][ $eb_regular ];
                                $output_perc				= 0;
                                
                                if ( !$conferenceregistration->row("is_paid")  ) #if conf.reg. fee paid  than dont check this option (when user register conf. and not paid abs fee it will be charging 100$ - he pay this 100$ - than after he later pay abs fee and again come back to this page, it will be showing the amount (subtracting abs fee) - this will confuse user.
                                {
                                    foreach ( DropdownHelper::abstracttype_dropdown() as $key => $value)
                                    {
                                        $ABS_paid					= $this->queries->fetch_records("abstract_submission_form", 
                                                                                                   " AND userid = '". $this->functions->_user_logged_in_details( "id" ) ."' 
                                                                                                     AND type =  '". $key ."' AND is_paid = '1'  ");
                                        
                                        if ( $ABS_paid -> num_rows() > 0 )
                                        {
                                            switch ( $key )
                                            {
                                                case "student":
                                                    $output_abspaid			= "50.00";
                                                    break;
                                                    
                                                case "facultymember":
                                                    $output_abspaid			= "100.00";
                                                    break;
                                                    
                                                default:
                                                    break;
                                            }
                                            
                                            break;
                                        }
                                    }
                                }
                                break;
                                
                            #members
                            default:
                                $_parentchart_loop			= $prices_chart[ $LOOP_KEY ][ $eb_regular ][$pricetype_id];
                                break;
                        }
                        
                        
                        
                        switch ( TRUE )
                        {
                            case $eb_regular == "earlybird_price" and $p_key == 1:
                                $output_text	= "Early Bird Discounted Rates for Non-IMI Members ( Early Bird rates till " . $registration_beforedate . " ) ";
                                $is_imi			= FALSE;
                                break;
                                
                            case $eb_regular == "earlybird_price" and $p_key == "2":
                                $output_text	= "Early Bird Discounted Rates for IMI Members ( Early Bird rates till " . $registration_beforedate . " ) ";
                                break;
                                
                            case $eb_regular == "regular_price" and $p_key == 1:
                                $output_text	= "General Registration Rates for Non-IMI Members ( " . $registration_afterdate . " ) ";
                                $is_imi			= FALSE;
                                break;
                            
                            case $eb_regular == "regular_price" and $p_key == 2:
                                $output_text	= "General Registration Rates for IMI Members ( " . $registration_afterdate . " ) ";
                                break;
                                
                            case $eb_regular == "earlybird_price" and $p_key == 3:
                                $output_text	= "Early Bird Rates ( " . $registration_afterdate . " ) ";
                                $is_imi			= FALSE;
                                break;
                                
                            case $eb_regular == "regular_price" and $p_key == 3:
                                $output_text	= "General Registration Rates ( " . $registration_afterdate . " ) ";
                                $is_imi			= FALSE;
                                break;
                                
                            default:
                                break;
                        }
                        
                        
                                
                        
                        
                        if ( $eb_regular == "earlybird_price" )
                        {
                            if ( !$this->validations->is_registration_valid( $conference, TRUE ) )
                            {
                                $is_disabled			= "disabled='disabled'";
                                $is_always_disabled		= TRUE;
                            }
                        }
                        else
                        {
                            if (  $this->validations->is_registration_valid( $conference ) )
                            {
                                $is_disabled			= "disabled='disabled'";
                                $is_always_disabled		= TRUE;
                            }
                        }
                        
                        
                        
                        
                        
                        
                        
                        $_parent_value				= $eb_regular . "_" . $pricetype_id;
                        $tmp_name 					= "registration_tickets";
						
                    ?>
                        <li>
                            <label>
                                <input <?php echo $is_disabled;?>  	 type="radio"  
                                data-percentage="<?php echo $output_perc;?>"  data-isimi="<?php echo $is_imi;?>"    data-alwaysdisabled="<?php echo $is_always_disabled;?>"
                                name="registration_tickets[<?php echo $eb_regular;?>][<?php echo $pricetype_id;?>]" 
                                class="<?php echo set_class( "registration_tickets[". $eb_regular ."][". $pricetype_id ."]" );?>" 
                                value="<?php echo $_parent_value;?>"  
                                <?php echo set_checkbox("registration_tickets[". $eb_regular ."][". $pricetype_id ."]", $_parent_value,
                                                                                                 format_bool($_parent_value, $registration_tickets[$eb_regular][$pricetype_id] ));?>  />
                                
                                <?php echo $output_text;?>
                            </label>
                            
                            
                            
                            <?php
                            //echo $eb_regular . ' - ' . $pricetype_id . '<br />';
                            #if ( is_array($prices_chart['others'][ $eb_regular ][$pricetype_id]) )
                            if ( is_array($_parentchart_loop) )
                            {
                                ?>
                                    <ul>
                                        <?php
                                        #foreach ($prices_chart['others'][ $eb_regular ][$pricetype_id] as $key => $value)
                                        foreach ($_parentchart_loop as $key => $value)
                                        {
											
											$TMP_to_show			= FALSE;
											if 	( $value['is_free'] == 1 )
											{
												if ( set_value( "speaker_coupon_code", $speaker_coupon_code ) != "" )
												{ 
													
													if 
													( 
														SessionHelper::_get_session("IMI_SPEAKER_COUPON_CODE", "site_settings") == set_value( "speaker_coupon_code", $speaker_coupon_code )
														|| 
														SessionHelper::_get_session("IMI_SPEAKER_BANQUET_COUPON_CODE", "site_settings") == set_value( "speaker_coupon_code", $speaker_coupon_code )
														|| 
														SessionHelper::_get_session("IMI_SPEAKER_BANQUET_REGISTRATION_COUPON_CODE", "site_settings") == set_value( "speaker_coupon_code", $speaker_coupon_code )
													)
													{
														
														if ($value['discount_coupon_code'] == set_value( "speaker_coupon_code", $speaker_coupon_code ) )
														{
															$TMP_to_show		= TRUE;
														}
														
													}
												}
											}
											else
											{
												$TMP_to_show		= TRUE;
											}
											
											
											if ( $TMP_to_show )
											{
												$tmp_name 				= "registration_tickets_child[". $value['id'] ."]";
												$tmp_value				= $value['id'] . '::' . $value['price'];
												
	
												$bg_color				= "";
												$array_weight			= $numbers_multiplyby;
												
												if ( $value['is_optional'] == 1 )
												{
													$bg_color				= "background-color:lightgray;";
													
													
													if (strpos($value['whoattend_name'], "CME") !== false) 
													{
														$array_weight			= $numbers_multiplyby_optional;
													}
												}
												
												
												#is free - change the background color
												if ( $value['is_free'] == 1 )
												{
													$bg_color				= "background-color:steelblue; color:white;";
												}
												
                                        	?>
                                                <li style=" <?php echo $bg_color;?>">
                                                    <label>
                                                        <input <?php echo $is_disabled;?> type="checkbox" name="<?php echo $tmp_name;?>"
                                                        data-isfree="<?php echo $value['is_free'];?>"
                                                        data-price="<?php echo $value['price'];?>"
                                                        class="<?php echo set_class( $tmp_name );?>" 
                                                        value="<?php echo $tmp_value;?>"  
                                                        <?php echo set_checkbox( $tmp_name, 
                                                                                 $tmp_value,
                                                                                 format_bool( $tmp_value, $registration_tickets_child[ $value['id'] ] ) );?>  />
                                                        
                                                        
                                                      <span><?php echo $value['whoattend_name'];?>: <?php echo $value['pricedisplay'];?></span>
                                                      
                                                    </label>
                                                    
                                                    
                                                    <?php
                                                    $class_weight			= "weight";
                                                                                                
                                                    if ( $value['whoattend_weight'] <= 2   and $value['is_free'] != 1)
                                                    {
                                                    ?>
                                                        <span style="display:none;" class="<?php echo $class_weight;?>" > x 
                                                        <?php
                                                        $tmp_mb			= 'multiply_by['. $value['id'] .']';
                                                        echo form_dropdown($tmp_mb, 
                                                                           $array_weight, 
                                                                           set_value($tmp_mb, $multiply_by[ $value['id'] ]), "class='form-control ". set_class( $tmp_mb ) ." '" );
                                                        echo form_error( $tmp_mb );
                                                        ?>
                                                        </span>
                                                    <?php
                                                    }
                                                    ?>
                                                </li>
                                        	<?php
											}
                                        }
                                        ?>
                                    </ul>
                                <?php
                            }
                            ?>
                        </li>
                    <?php
                    
                    }
                    
                    
                }
                ?>
            </ul>
           
            
            <ul class="not_a_member">
                <li>
                    <label>
                        <?php
                        $tmp_name		= "be_a_member";
                        $tmp_value		= "1";
                        ?>
                        <input type="checkbox" onclick="toggle_not_a_member( $(this) )" name="<?php echo $tmp_name;?>"
                        class="<?php echo set_class( $tmp_name );?>" 
                        value="<?php echo $tmp_value;?>"  <?php echo set_checkbox($tmp_name, $tmp_value, format_bool( $tmp_value, $be_a_member));?>  />
                                                    
                        <span>Not a member? Click here to join first and enjoy many membership benefits like discounted conference registration:</span>
                    </label>
                    
                    
                    <?php
                    if ( $conference_prices_not_a_member -> num_rows() > 0 )
                    {
                    ?>
                        <div class="options">
                            <ul>
                                <?php
                                foreach ($conference_prices_not_a_member -> result_array() as $notamember)
                                {
                                    $tmp_name				= 'be_a_member_fee';
                                    
                                    /*,
                                                                     format_bool( $notamember['price'], $$tmp_name ) */
                                ?>
                                    <li>
                                        <label>
                                            <input type="radio" name="<?php echo $tmp_name;?>" data-price="<?php echo $notamember['price'];?>"
                                            class="<?php echo set_class( $tmp_name );?>" 
                                            value="<?php echo $notamember['id'];?>"  
                                            <?php echo set_checkbox( $tmp_name, 
                                                                     $notamember['id'],
                                                                     format_bool($notamember['id'], $$tmp_name)
                                                                     );?>  />
                                            
                                            
                                            <span>
                                            <?php echo $notamember['name'];?>: 
                                            <?php echo format_price(  '<span class="fee">' . $notamember['price'] . '</span>', array("prefix" => "$"), TRUE, TRUE);?>/
                                            <?php echo $notamember['per'];?>
                                            </span>
                                        </label>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    <?php
                    }
                    ?>
                </li>
            </ul>
        </div>
        
        
        
        <?php ob_start(); ?>
        <div class="reg-ticket-rightsection">
            <h1>In Your Cart</h1>
        
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td height="35" width="60%">Package Fees :</td>
                    <td height="35" width="40%" align="right">
                    
                    <strong style="display:;" class="js_package_fee">
                    <?php echo format_price("<span>0.00</span>", array("prefix" => "$"), TRUE, TRUE );?>
                    <input type="hidden" name="txt_package_fee" value="0"  />
                    </strong>
                    </td>
                </tr>
            
                <tr class="tr_nam" style="display:none;">
                  <td height="35">
                  <small>(Not a member FEE)</small>
                  </td>
                  <td height="35" align="right">
                    <strong style="display:;" class="js_not_a_member_fee">
                    <?php echo format_price("<span>0.00</span>", array("prefix" => "$"), TRUE, TRUE );?>
                    <input type="hidden" name="txt_not_a_member_fee" value="0"  />
                    </strong>
                  </td>
                </tr>
                
                
                <?php
                if ( $output_abspaid )
                {
                ?>
                    <tr class="tr_abspaid" style="display:;">
                        <td height="35">
                            <small>Abstract Submission Form (Paid)</small>
                        </td>
                        <td height="35" align="right">
                            <strong style="display:;" class="js_abs_paid">
                            <?php echo format_price("<span>(". $output_abspaid .")</span>", array("prefix" => "$"), TRUE, TRUE );?>
                            </strong>
                        </td>
                    </tr>
                <?php
                }
                ?>
                
                
                <tr>
                    <td height="35">Payable Now : 
                    <span style="display:none;" class="parent_js_payable_now_perc">
                        (<span class="js_payable_now_perc">0</span>%)
                    </span>
                    </td>
                    <td height="35" align="right">
                   
                    <strong style="display:;" class="js_payable_now">
                    <?php echo format_price("<span>0.00</span>", array("prefix" => "$"), TRUE, TRUE );?>
                    <input type="hidden" name="txt_payable_now" value="0"  />
                    <input type="hidden" name="txt_abs_paid" value="<?php echo $output_abspaid;?>"  />
                    </strong>
                    </td>
                </tr>
            
                <tr>
                    <td height="35">Cash OnSite :</td>
                    <td height="35" align="right">
                    <strong style="display:;" class="js_cash_onsite">
                    <?php echo format_price("<span>0.00</span>", array("prefix" => "$"), TRUE, TRUE );?>
                    <input type="hidden" name="txt_cash_onsite" value="0"  />
                    </strong>
                    </td>
                </tr>
                
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>  
                </tr>
                
                <tr>
                    <td><strong>Total Payable:</strong></td>
                    <td align="right" class="totalpayable">
                   
                    <strong style="display:;" class="js_total_payable">
                    <?php echo format_price("<span>0.00</span>", array("prefix" => "$"), TRUE, TRUE );?>
                    </strong>
                    
                    <input type="hidden" name="txt_total_payable" value="0"  />
                    </td>
                </tr>
            </table>
        
        </div>
        
        <?php
		$tmp_name		= 'email_text';
        $specdata		= array("name"			=> $tmp_name,
                                "id"			=> $tmp_name,
                                
                                "type"			=> "hidden",
                                "class"			=> set_class( $tmp_name ));	
    
        echo form_input($specdata);
		?>
        
    </div>
    
    
    
    
    <div class="couponsubmitbtn"> 
        Coupon Code : 
        
        <?php
        $tmp_name		= 'coupon_code';
        $specdata		= array("name"			=> $tmp_name,
                                "id"			=> $tmp_name,
                                
                                "type"			=> "text",
                                "class"			=> set_class( $tmp_name ),
                                "value"			=> set_value( $tmp_name, $$tmp_name ),
                                "placeholder"	=> "Coupon Code");	
    
        echo form_input($specdata);
        ?>
    </div>
    
    <div class="couponsubmitbtn fromerror_lft"> 
        <?php
        echo form_error( $tmp_name );
        ?>
    </div>
    
    
    <div class="speakercouponcode"> 
         Speaker/Exhibitor Promo Code: 
        
        <?php
        $tmp_name		= 'speaker_coupon_code';
        $specdata		= array("name"			=> $tmp_name,
                                "id"			=> $tmp_name,
                                "size"			=> 40,
                                "type"			=> "text",
                                "class"			=> set_class( $tmp_name ),
                                "value"			=> set_value( $tmp_name, $$tmp_name ),
                                "placeholder"	=> "Speaker Coupon Code");	
    
        echo form_input($specdata);
        ?>
    </div>
    <div class="speakercouponcode fromerror_lft"> 
        <?php
        echo form_error( $tmp_name );
        ?>
    </div>
                
                
                
    <div class="flt-rgt">
        <input type="hidden" name="id" value="<?php echo set_value("id", $id);?>"  />
        <input type="submit" name="proceedfurther" value="<?php echo lang_line('text_saveandproceed');?>" class="bluebuttons">
    </div>
    
    <?php
    echo form_close();
    ?>
</div>

<?php
if ( $goto_payment_page == 1 )
{
	?>
    	<style type="text/css">
		.screen_two_status{ display:none;}
        </style>
        <script  type="text/javascript">
		$(document).ready(function(){
		
			$("input[name='proceedfurther']").click();
			
		});
		</script>
    <?php
}
?>

