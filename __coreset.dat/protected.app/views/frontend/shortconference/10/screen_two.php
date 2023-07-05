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
    
    
    
    <?php
	if ( $country_notes->num_rows() > 0 )
	{
		
		if ( $country_notes->row()->note_2 != "" )
		{
			$TMP_message["_messageBundle"]["_ALERT_mode"]					= "";
			$TMP_message["_messageBundle"]["_TEXT_show_messages"]			= $country_notes->row()->note_2;
			$TMP_message["_messageBundle"]["_CSS_show_messages"]			= "danger";
						
			?>
			<div class="inline_error_style"><?php $this->load->view('frontend/template/_show_messages.php', $TMP_message); ?> </div>
			<?php		
		}
	}
	?>
    

    
    
    
    <?php $this->load->view("frontend/shortconference/10/include_screen_two.php");?>
    
    
    <div class="reg-ticket-section pak_step-form-info">
        <div class="reg-ticket-leftsection pak_step-form">
        <div class="pak_step-form-heading"><h2>Select your package for: <span class="blue"><?php echo $SUB_HEADING;?></span></h2></div>    
            
            
            
            <input type="hidden" name="hdn_options_selected"  value="<?php echo $LOOP_KEY;?>" />
            <input type="hidden" name="hdn_total_no_of_people_weight"  />
            
            <span class="fromerror_lft"><?php echo form_error("hdn_options_selected");?></span>
            <span class="fromerror_lft"><?php echo form_error("hdn_total_no_of_people_weight");?></span>
            
            <ul class="confreg_price_selection pak_step-form-wrapper">       
                <?php
                $TMP_perc_dd					= DropdownHelper::short_conferenceprice_earlybird_regular_dropdown(TRUE, TRUE, $conferenceregistration->row_array() );
                foreach ($tmp_earlybird_regular as $e_key => $e_value)
                {
					

                    foreach ($tmp_paymenttype[ $LOOP_KEY ] as $p_key => $p_value)
                    {
                        
						if ( $p_key == IMI_NON_MEMBER )
						{
							continue;
						}
                        
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
								$_parentchart_loop			= $prices_chart[ 'whoattendlist' ]['others'];
								
								
                                $output_perc				= 0;
                                
                                if ( !$conferenceregistration->row("is_paid") || (1==1) ) #if conf.reg. fee paid  than dont check this option (when user register conf. and not paid abs fee it will be charging 100$ - he pay this 100$ - than after he later pay abs fee and again come back to this page, it will be showing the amount (subtracting abs fee) - this will confuse user.
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
								
								
								$_parentchart_loop			= $prices_chart[ 'whoattendlist' ]['members'];
                                break;
                        }
                        
                       
                        switch ( TRUE )
                        {
                            case $eb_regular == "earlybird_price" and $p_key == 1:
                                #$output_text	= "Early Bird Discounted Rates ( " . $registration_beforedate . " ) "; //for Non-IMI Members 
								$output_text	= "Discounted Advance Rates ( " . $registration_beforedate . " ) "; //for Non-IMI Members 
                                $is_imi			= FALSE;
                                break;
                                
                            case $eb_regular == "earlybird_price" and $p_key == "2":
                                #$output_text	= "Early Bird Discounted Rates ( " . $registration_beforedate . " ) "; //for IMI Members 
								$output_text	= "Discounted Advance Rates ( " . $registration_beforedate . " ) "; //for IMI Members 
                                break;
                                
                            case $eb_regular == "regular_price" and $p_key == 1:
                                #$output_text	= "General Registration Rates ( " . $registration_afterdate . " ) "; //for Non-IMI Members 
								$output_text	= "Onsite Registration Rates ( " . $registration_afterdate . " ) "; //for Non-IMI Members 
                                $is_imi			= FALSE;
                                break;
                            
                            case $eb_regular == "regular_price" and $p_key == 2:
                                #$output_text	= "General Registration Rates ( " . $registration_afterdate . " ) "; //for IMI Members
								$output_text	= "Onsite Registration Rates ( " . $registration_afterdate . " ) "; //for IMI Members
                                break;
                                
                            case $eb_regular == "earlybird_price" and $p_key == 3:
                                #$output_text	= "Early Bird Rates ( " . $registration_beforedate . " ) ";
								$output_text	= "Discounted Advance Rates ( " . $registration_beforedate . " ) ";
                                $is_imi			= FALSE;
                                break;
                                
                            case $eb_regular == "regular_price" and $p_key == 3:
                                #$output_text	= "General Registration Rates ( " . $registration_afterdate . " ) ";
								$output_text	= "Discounted Advance Rates ( " . $registration_afterdate . " ) ";
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
						
						if ( $is_always_disabled )
						{
							continue;	
						}
						
						
						
                    ?>
                        <li class="pak_step-form-package">
                            <label class="pak_step-form-package-type">
                                <input <?php echo $is_disabled;?>  	 type="radio"  
                                data-percentage="<?php echo $output_perc;?>"  data-isimi="<?php echo $is_imi;?>"    data-alwaysdisabled="<?php echo $is_always_disabled;?>"
                                name="registration_tickets[<?php echo $eb_regular;?>][<?php echo $pricetype_id;?>]" 
                                class="<?php echo set_class( "registration_tickets[". $eb_regular ."][". $pricetype_id ."]" );?>" 
                                value="<?php echo $_parent_value;?>"  
                                <?php echo set_checkbox("registration_tickets[". $eb_regular ."][". $pricetype_id ."]", $_parent_value,
                                                                                                 format_bool($_parent_value, $registration_tickets[$eb_regular][$pricetype_id] ));?>  />

                                <span class="pak_step-form-package-radio">a</span>
                                <span class="pak_step-form-package-type-label"><?php echo $output_text;?></span>
                            </label>
                            
                            
                            
                            <?php
                            //echo $eb_regular . ' - ' . $pricetype_id . '<br />';
                            #if ( is_array($prices_chart['others'][ $eb_regular ][$pricetype_id]) )
                            if ( is_array($_parentchart_loop) )
                            {
								
                                ?>
                                	
                                    
                                
                                    <ul class="pak_step-form-package-details">
                                        <?php
                                        #foreach ($prices_chart['others'][ $eb_regular ][$pricetype_id] as $key => $value)
										
                                        foreach ($_parentchart_loop as $key => $value)
                                        {
											
											
											if ( !array_key_exists( $eb_regular, $value ) )
											{
												continue;
											}
											?>
                                            <li class="pak_step-form-package-detail parent_package closed">
                                            	<p class="pak_step-form-package-name"><?php echo $key ;?></p>
											
                                            
                                            	<ul class="pak_step-form-package-about ">
                                                	<?php
													foreach ($value[$eb_regular] as $price_master_id => $price_master_array)
													{
														
														$__ID					= $price_master_array[$pricetype_id]["id"];
														$__PRICE				= $price_master_array[$pricetype_id]["price"];
														$__PRICEDISPLAY			= $price_master_array[$pricetype_id]["pricedisplay"];
														$__TITLEFORPRICE		= $price_master_array[$pricetype_id]["title_for_price"];
														$__DESCFORPRICE			= $price_master_array[$pricetype_id]["description_for_price"];
														$__WHOATTENDWEIGHT		= $price_master_array[$pricetype_id]["whoattend_weight"];
														
														
														
														$tmp_name 				= "registration_tickets_child[". $__ID ."]";
			                                           	$tmp_value				= $__ID . '::' . $__PRICE;
														
														?>
                                                        <li class="pak_step-form-package-about-wrapper this_is_package">
														
														<label>
                                                            <input <?php echo $is_disabled;?> type="checkbox" name="<?php echo $tmp_name;?>"
                                                           
                                                            data-price="<?php echo $__PRICE;?>"
                                                            class="<?php echo set_class( $tmp_name );?> pak_step-form-package-input" 
                                                            value="<?php echo $tmp_value;?>"  
                                                            <?php echo set_checkbox( $tmp_name, 
                                                                                     $tmp_value,
                                                                                     format_bool( $tmp_value, $registration_tickets_child[ $__ID ] ) );?> />
                                                            
                                                            <span class="pak_step-form-package-check">a</span>
                                                          
                                                          	<span><?php echo $__TITLEFORPRICE;?>: <?php echo $__PRICEDISPLAY;?></span>
                                                            
                                                            <span class="pak_step-form-package-desc" ><?php echo nl2br( $__DESCFORPRICE );?></span>
                                                          
                                                        </label>
														
                                                        <?php
														$class_weight			= "weight";
														$array_weight			= $numbers_multiplyby;											
														
														if ( $__WHOATTENDWEIGHT > 0 )
														{
														?>
															<span style="display:none;" class="<?php echo $class_weight;?>" > x 
															<?php
															$tmp_mb			= 'multiply_by['. $__ID .']';
															echo form_dropdown($tmp_mb, 
																			   $array_weight, 
																			   set_value($tmp_mb, $multiply_by[ $__ID ]), "class='form-control ". set_class( $tmp_mb ) ." '" );
															echo form_error( $tmp_mb );
															?>
															</span>
														<?php
														}
														?>
														
														
                                                        
                                                        <?php
														if ( array_key_exists("addon", $price_master_array) )
														{
															$_AddonsPerPerson_Text				= "Add-ons Per Person";
															
															if ( 
																	$__WHOATTENDWEIGHT == 4 
																	&&
																	( 
																		$__TITLEFORPRICE != "Pick & Choose Package for Graduates / Retired / NGO Persons Willing to Attend Both Conferences" 
																		&&
																		$__TITLEFORPRICE != "Pick & Choose Package for Students Willing to Attend Both Conferences"
		
																	) 
															
																)
															{
																$_AddonsPerPerson_Text				= "Add-ons Per Group";	
															}
															else if ( $__WHOATTENDWEIGHT == 2 )
															{
																$_AddonsPerPerson_Text				= "Add-ons Per Couple";	
															}
															?>
                                                           	<span class="addonsperperson"><?php echo $_AddonsPerPerson_Text;?></span>
                                                            <ul class="pak_step-form-package-about">
																<?php
                                                                foreach ($price_master_array["addon"] as $addon_key => $addon_array )
                                                                {
																	
																	
																	$__PRICE				= $addon_array[$pricetype_id]["price"];
																	
																	if ( $__PRICE > 0 )
																	{
																		$__ID					= $addon_array[$pricetype_id]["id"];
																		$__PRICEDISPLAY			= $addon_array[$pricetype_id]["pricedisplay"];
																		$__TITLEFORPRICE		= $addon_array[$pricetype_id]["title_for_price"];
																		$__DESCFORPRICE			= $addon_array[$pricetype_id]["description_for_price"];
																		$__WHOATTENDWEIGHT		= $addon_array[$pricetype_id]["whoattend_weight"];
																		
																		
																		
																		
																		$tmp_name 			= "registration_tickets_child[". $__ID ."]";
																		$tmp_value			= $__ID . '::' . $__PRICE;
																		/*
																		print_r($registration_tickets_child);
																		var_dump($registration_tickets_child[ $price_master_array[$pricetype_id]["id"] ]);
																		var_dump($tmp_value);
																		var_dump(format_bool( $tmp_value, $registration_tickets_child[ $addon_array[$pricetype_id]["id"] ] ) );
																		*/
                                                                    	?>
                                                                        <li class="pak_step-form-package-about-wrapper ">
                                                                        
                                                                            <label>
                                                                                <input disabled="disabled"  type="checkbox" name="<?php echo $tmp_name;?>"
                                                                               
                                                                                data-price="<?php echo $__PRICE;?>"
                                                                                class="child-addon <?php echo set_class( $tmp_name );?> pak_step-form-package-input" 
                                                                                value="<?php echo $tmp_value;?>"  
                                                                                <?php echo set_checkbox( $tmp_name, 
                                                                                                         $tmp_value,
                                                                                                         format_bool( $tmp_value, $registration_tickets_child[ $__ID ] ) );?>  />
                                                                                
                                                                                <span class="pak_step-form-package-check">a</span>
                                                                                <span><?php echo $__TITLEFORPRICE;?>: <?php echo $__PRICEDISPLAY;?></span>
                                                                                <span class="pak_step-form-package-desc"><?php echo nl2br( $__DESCFORPRICE );?></span>
                                                                              
                                                                            </label>
                                                                            
                                                                            
                                                                            
                                                                            
                                                                            <?php
                                                                            $class_weight			= "weight";
                                                                            $array_weight			= $numbers_multiplyby;											
                                                                            
                                                                            if ( $__WHOATTENDWEIGHT > 0  )
                                                                            {
                                                                            ?>
                                                                                <span style="display:none;" class="<?php echo $class_weight;?>" > x 
                                                                                <?php
                                                                                $tmp_mb			= 'multiply_by['. $__ID .']';
                                                                                echo form_dropdown($tmp_mb, 
                                                                                                   $array_weight, 
                                                                                                   set_value($tmp_mb, $multiply_by[ $__ID  ]), "class='form-control ". set_class( $tmp_mb ) ." '" );
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
													?>
                                                </ul>
                                            </li>
                                            
                                            
                                            
                                            
                                            <?php
                                            $tmp_name 				= "registration_tickets_child[". $value['id'] ."]";
                                            $tmp_value				= $value['id'] . '::' . $value['price'];
                                        ?>
                                            <li style="display: none;">
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
                                                $array_weight			= $numbers_multiplyby;											
                                                if ( $value['whoattend_weight'] <= 2 )
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
           
            
            <?php
			if ( $conference_prices_not_a_member -> num_rows() > 0 )
			{
			?>
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
            <?php
			}
			?>
        </div>
        
        
        
        <?php ob_start();
        /*$prefix = "$";
        if($conferenceregistration->row("show_rates_in_currency") == "35"){
            $prefix = "Rs";
        }*/
		$prefix			= $this->functions->getCurrencySymbol($conferenceregistration->row("show_rates_in_currency")) ;
        ?>
        <div class="reg-ticket-rightsection pak_step-form-cart">
            <h1>In Your Cart</h1>
        
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td height="35" width="50%">Package Fees :</td>
                    <td height="35" width="50%" align="right">
                    
                    <strong style="display:;" class="js_package_fee">
                    <?php echo format_price("<span>0.00</span>", array("prefix" => $prefix), TRUE, TRUE );?>
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
                    <?php echo format_price("<span>0.00</span>", array("prefix" => $prefix), TRUE, TRUE );?>
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
                            <?php echo format_price("<span>(". $output_abspaid .")</span>", array("prefix" => $prefix), TRUE, TRUE );?>
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
                    <?php echo format_price("<span>0.00</span>", array("prefix" => $prefix), TRUE, TRUE );?>
                    <input type="hidden" name="txt_payable_now" value="0"  />
                    <input type="hidden" name="txt_abs_paid" value="<?php echo $output_abspaid;?>"  />
                    </strong>
                    </td>
                </tr>
            
                <tr>
                    <td height="35">Cash OnSite :</td>
                    <td height="35" align="right">
                    <strong style="display:;" class="js_cash_onsite">
                    <?php echo format_price("<span>0.00</span>", array("prefix" => $prefix), TRUE, TRUE );?>
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
                    <?php echo format_price("<span>0.00</span>", array("prefix" => $prefix), TRUE, TRUE );?>
                    </strong>
                    
                    <input type="hidden" name="txt_total_payable" value="0"  />
                    </td>
                </tr>
            </table>
        
        </div>
        
        <div class="fix-on-scroll flt-rgt">
            <input type="hidden" name="id" value="<?php echo set_value("id", $id);?>"  />
            <input type="submit" name="proceedfurther" value="<?php echo lang_line('text_saveandproceed');?>" class="bluebuttons">
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
    
    <div class="couponsubmitbtn1" style="display:none;"> 
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