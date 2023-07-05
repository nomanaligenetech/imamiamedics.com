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
    
    
    <p class="align_center m_bottom25" ><strong>Note</strong> : In case of technical support, please reach out to <a href="mailto:neelam.raheel@genetechsolutions.com">neelam.raheel@genetechsolutions.com</a> or send whastapp message +92-3002522862. Live help with immediate assistance via WhatsApp is available from <strong>8:00 pm CST - 1:00 pm CST</strong>.</p>

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
    

    
    
    
    <?php $this->load->view("frontend/shortconference/12/include_screen_two.php");?>
    
    <div class="reg-ticket-section pak_step-form-info">
        <div class="reg-ticket-leftsection pak_step-form">
        <div class="pak_step-form-heading"><h2>Select your package for: <span class="blue"><?php echo $SUB_HEADING;?></span></h2></div>    
            
            
            
            <input type="hidden" name="hdn_options_selected"  value="<?php echo $LOOP_KEY;?>" />
            <input type="hidden" name="hdn_total_no_of_people_weight"  />
            
            <span class="fromerror_lft"><?php // echo form_error("hdn_options_selected");?></span>
            <span class="fromerror_lft"><?php // echo form_error("hdn_total_no_of_people_weight");?></span>

            <div class="reg-ticket-section-tabs" style="display:none;">
                
                <ul class="confreg_price_selection pak_step-form-wrapper reg-ticket-section-tab active-tab" data-tab-type="g-reg">
                    <?php
                    $TMP_perc_dd					= DropdownHelper::short_conferenceprice_earlybird_regular_dropdown(TRUE, TRUE, $conferenceregistration->row_array() );
                    foreach ($tmp_earlybird_regular as $e_key => $e_value)
                    {


                        foreach ($tmp_paymenttype[ $LOOP_KEY ] as $p_key => $p_value)
                        {

                            if ( $is_member == "1" && $p_key == IMI_NON_MEMBER )
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

                                    $_parentchart_loop			        = $prices_chart[ 'whoattendlist' ]['members'];
                                    $_parentchart_loop_addons			= $prices_chart[ 'whoattendlist' ]['addons'];
                                    
                                    break;
                            }
      
                      
                            switch ( TRUE )
                            {
                                case $eb_regular == "earlybird_price" and $p_key == 1:
                                    #$output_text	= "Early Bird Discounted Rates ( " . $registration_beforedate . " ) "; //for Non-IMI Members 
                                    $output_heading = "Early Bird";
                                    $output_text	= "Discounted Advance Rates For Non Members ( " . $registration_beforedate . " ) "; //for Non-IMI Members 
                                    $is_imi			= FALSE;
                                    break;
                                    
                                case $eb_regular == "earlybird_price" and $p_key == "2":
                                    #$output_text	= "Early Bird Discounted Rates ( " . $registration_beforedate . " ) "; //for IMI Members 
                                    $output_heading = "Early Bird";
                                    $output_text	= "Discounted Advance Rates For Members ( " . $registration_beforedate . " ) "; //for IMI Members 
                                    break;
                                    
                                case $eb_regular == "regular_price" and $p_key == 1:
                                    #$output_text	= "General Registration Rates ( " . $registration_afterdate . " ) "; //for Non-IMI Members 
                                    $output_heading = "General Registration";
                                    $output_text	= "Onsite Registration Rates For Non Members ( " . $registration_afterdate . " ) "; //for Non-IMI Members 
                                    $is_imi			= FALSE;
                                    break;
                                
                                case $eb_regular == "regular_price" and $p_key == 2:
                                    #$output_text	= "General Registration Rates ( " . $registration_afterdate . " ) "; //for IMI Members
                                    $output_heading = "General Registration";
                                    $output_text	= "Onsite Registration Rates For Members ( " . $registration_afterdate . " ) "; //for IMI Members
                                    break;
                                    
                                case $eb_regular == "earlybird_price" and $p_key == 3:
                                    #$output_text	= "Early Bird Rates ( " . $registration_beforedate . " ) ";
                                    $output_heading = "Early Bird";
                                    $output_text	= "Discounted Advance Rates ( " . $registration_beforedate . " ) ";
                                    $is_imi			= FALSE;
                                    break;
                                    
                                case $eb_regular == "regular_price" and $p_key == 3:
                                    #$output_text	= "General Registration Rates ( " . $registration_afterdate . " ) ";
                                    $output_heading = "General Registration";
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
                                                        
                            <li <?php echo ($is_member != "1" && $p_key != IMI_NON_MEMBER) ? 'style="display: none;"' : ''; ?> class="pak_step-form-package <?php echo $p_key == IMI_NON_MEMBER ? 'non_member_data' : 'member_data'; ?>">
                                <label class="pak_step-form-package-type">
                                    <input style="display:none;" <?php echo $is_disabled;?>  	 type="radio"  
                                    data-percentage="<?php echo $output_perc;?>"  data-isimi="<?php echo $is_imi;?>"    data-alwaysdisabled="<?php echo $is_always_disabled;?>"
                                    name="registration_tickets[<?php echo $eb_regular;?>][<?php echo $pricetype_id;?>]" 
                                    class="<?php echo set_class( "registration_tickets[". $eb_regular ."][". $pricetype_id ."]" );?>" 
                                    value="<?php echo $_parent_value;?>" <?php if(!$is_disabled && $is_member != "1" && $p_key == IMI_NON_MEMBER){ echo 'checked="checked"'; } elseif(!$is_disabled && $is_member == "1" && $p_key != IMI_NON_MEMBER) { echo 'checked="checked"'; } else{ echo ''; } ?>
                                    <?php echo set_checkbox("registration_tickets[". $eb_regular ."][". $pricetype_id ."]", $_parent_value,
                                                                                                     format_bool($_parent_value, $registration_tickets[$eb_regular][$pricetype_id] ));?>  />
                      
    
                                    <span class="pak_step-form-package-radio member_span"><?php echo 'Conference Registration Rates'; ?></span>
                                    <!-- <span class="pak_step-form-package-type-label display-member-text"><?php // echo $output_text;?></span> -->
                                </label>
                                
                                
                                
                                <?php
                                //echo $eb_regular . ' - ' . $pricetype_id . '<br />';
                                #if ( is_array($prices_chart['others'][ $eb_regular ][$pricetype_id]) )
                                if ( is_array($_parentchart_loop) )
                                {
                                    
                                    ?>
                                        
                                        
                                    
                                        
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
                if ( $conference_prices_not_a_member -> num_rows() > 0 && $is_member != "1")
                {
                ?>
                    <ul class="not_a_member reg-ticket-section-tab" data-tab-type="no-mem">
                        <li>
                            <label>
                                <?php
                                $tmp_name		= "be_a_member";
                                $tmp_value		= "1";
                                ?>

                                                            
                                <span class="member_span">Not a member? </span><span class="display-member-text">Click here to join first and enjoy many membership benefits like discounted conference registration:</span>
                            </label>
                        </li>
                    </ul>
                <?php
                }
                ?>
               
            </div>

                <div class="reg-ticket-section-content" style="display: none;">
                    <div class="empty-cart-note">
                        <p><strong>Note :</strong>You’ll need to reselect conference registration packages as the membership rates are discounted rates</p>
                    </div>
                    <label>
                        <!-- <input type="checkbox" onclick="toggle_not_a_member( $(this) )" name="be_a_member" class="" value="1"> -->
                        <input type="checkbox"  name="be_a_member" class="" value="1">
                                                    
                        <span class="member_span">Not a member? Click here to join first and enjoy many membership benefits like discounted conference registration:</span>
                    </label>
                    <?php
                        if (  $conference_prices_not_a_member -> num_rows() > 0 && $is_member != "1" && $conference_prices_not_a_member -> num_rows() > 0 )
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
                                                
                                                
                                                <span class="member_span">
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
                </div>
                <div class="reg-ticket-section-wrapper">
                <div class="reg-ticket-section-table conf-reg-s-two-table">
                    <table width="100%" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr class="conf-table-head">
                                <th>
                                    Conference Registration Rates
                                </th>
                            </tr>
                            <tr>
                                <td>

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="pkg-table">
                                        <?php
                                    foreach ($tmp_earlybird_regular as $e_key => $e_value)
                                    {
                                        $is_imi					= TRUE;
                                        $pricetype_id			= $p_key;
                                        $eb_regular				= $e_key;
                                        $is_disabled			= FALSE;
                                        $is_always_disabled		= FALSE;
                                        $output_perc			= $TMP_perc_dd[ $eb_regular ];
                                        $output_abspaid			= FALSE;                         
                                            foreach($tmp_paymenttype[ $LOOP_KEY ] as  $p_key => $p_value ){
                                        ?>
                                        <?php 
                                         if($is_member != "1" && $p_key != IMI_NON_MEMBER ){
                                            $style = 'style="display: none;"';
                                        }else if($is_member == "1" && $p_key == IMI_NON_MEMBER){
                                            $style = 'style="display: none;"';
                                        }else if($is_member == "1" && $p_key != IMI_NON_MEMBER ){
                                            $style = 'style="display: table-block;"';
                                        }else if($is_member != "1" && $p_key == IMI_NON_MEMBER){
                                            $style = 'style="display: table-block;"';
                                        } ?>
                                        <?php 
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
            
                                                $_parentchart_loop			        = $prices_chart[ 'whoattendlist' ]['members'];
                                                $_parentchart_loop_addons			= $prices_chart[ 'whoattendlist' ]['addons'];
                                                
                                                break;
                                        }
                  
                                  
                                        switch ( TRUE )
                                        {
                                            case $eb_regular == "earlybird_price" and $p_key == 1:
                                                #$output_text	= "Early Bird Discounted Rates ( " . $registration_beforedate . " ) "; //for Non-IMI Members 
                                                $output_text	= "Discounted Advance Rates For Non Members ( " . $registration_beforedate . " ) "; //for Non-IMI Members 
                                                $is_imi			= FALSE;
                                                break;
                                                
                                            case $eb_regular == "earlybird_price" and $p_key == "2":
                                                #$output_text	= "Early Bird Discounted Rates ( " . $registration_beforedate . " ) "; //for IMI Members 
                                                $output_text	= "Discounted Advance Rates For Members ( " . $registration_beforedate . " ) "; //for IMI Members 
                                                break;
                                                
                                            case $eb_regular == "regular_price" and $p_key == 1:
                                                #$output_text	= "General Registration Rates ( " . $registration_afterdate . " ) "; //for Non-IMI Members 
                                                $output_text	= "Onsite Registration Rates For Non Members ( " . $registration_afterdate . " ) "; //for Non-IMI Members 
                                                $is_imi			= FALSE;
                                                break;
                                            
                                            case $eb_regular == "regular_price" and $p_key == 2:
                                                #$output_text	= "General Registration Rates ( " . $registration_afterdate . " ) "; //for IMI Members
                                                $output_text	= "Onsite Registration Rates For Members ( " . $registration_afterdate . " ) "; //for IMI Members
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
                                        
                                        <tbody <?php echo $style; ?> class="<?php echo $p_key == IMI_NON_MEMBER ? 'non_member_data' : 'member_data'; ?>">
                                            <?php
                                                if ( is_array($_parentchart_loop) )
                                                {
                                                    foreach ($_parentchart_loop as $key => $value)
                                                    {
                                                        $a = array_keys($value[$eb_regular]);
                                                        $_description = $_parentchart_loop[$key][$eb_regular][$a[0]][$p_key]['whoattend_description'];
                                                        $__description = ( !empty($_description) ) ? $_description : "";
            
            
                                                        if ( !array_key_exists( $eb_regular, $value ) )
                                                        {
                                                            continue;
                                                        }
                                            ?>
                                            <tr>
                                                <td class="pkg-names">
                                                    <p><?php echo $key; ?></p>
                                                    <span class="pkg-description"><?php echo $__description; ?></span>
                                                </td>

                                            <?php
                                                foreach ($value[$eb_regular] as $price_master_id => $price_master_array)
                                                {
                                                    
                                                    $__ID					= $price_master_array[$p_key]["id"];
                                                    $__PRICE				= $price_master_array[$p_key]["price"];
                                                    $__PRICEDISPLAY			= $price_master_array[$p_key]["pricedisplay"];
                                                    $__TITLEFORPRICE		= $price_master_array[$p_key]["title_for_price"];
                                                    $__DESCFORPRICE			= $price_master_array[$p_key]["description_for_price"];
                                                    $__WHOATTENDWEIGHT		= $price_master_array[$p_key]["whoattend_weight"];
                                                    
                                                    
                                                    
                                                    $tmp_name 				= "registration_tickets_child[". $__ID ."]";
                                                    $tmp_value				= $__ID . '::' . $__PRICE;
                                                    $tmp_name_addons 		= "is_addon[".$__ID ."]";
                                            ?>
                                            <td class="pkg-prices">
                                                <label>
                                                    <input
                                                        type="hidden" name="<?php echo $tmp_name;?>"
                                                        data-price="<?php echo $__PRICE;?>"
                                                        class="<?php echo set_class( $tmp_name );?> pak_step-form-package-input" 
                                                        value="<?php echo $tmp_value;?>"  
                                                       /> 
                                                    
                                                       <input
                                                            type="hidden" name="<?php echo $tmp_name_addons;?>"
                                                            class="<?php echo set_class( $tmp_name_addons );?>" 
                                                            value="0"  
                                                                /> 
                                                        <span  data-price="<?php echo $__PRICE;?>" data-title="<?php echo $__TITLEFORPRICE ?>" class="<?php echo set_class( $tmp_name );?> pak_step-form-package-input" ><?php echo $__PRICEDISPLAY;?></span>
                                                    
                                                    <!-- <span class="pak_step-form-package-desc" ><?php echo nl2br( $__DESCFORPRICE );?></span> -->
                                                    
                                                </label>
                                            </td>
                                            <td class="no-of-persons">
                                                <?php
                                                    $class_weight			= "weight";
                                                    $array_weight			= $numbers_multiplyby;	
                                                    $max                    = 10;
                                                    $min                    = 0;
                                                    
                                                    if ( $__WHOATTENDWEIGHT > 0 )
                                                    {
                                                    ?>
                                                        <span class="<?php echo $class_weight;?>" >
                                                        <span class="sub-before add-sub" ></span>
                                                        <?php
                                                        $tmp_name 				= "multiply_by[". $__ID ."]";
                                                        echo form_number_input($tmp_name, 
                                                        set_value($tmp_mb, $multiply_by[ $__ID  ]),
                                                                            " class='form-control ". set_class( $tmp_mb ) ." '" ,
                                                                            $min,
                                                                            $max);
                                                        echo form_error( $tmp_mb );
                                                        ?>
                                                        <span class="add-after add-sub" ></span>
                                                        </span>
                                                    <?php
                                                    }
                                                    ?>
                                            </td>
                                            </tr>
                                            <?php
                                                }
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                        <?php

                                            }
                                        }
                                        ?>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php
                $parent_addon_loop = $prices_chart[ 'whoattendlist' ]["addons"];
                foreach ($tmp_earlybird_regular as $e_key => $e_value)
                {  
                foreach($tmp_paymenttype[ $LOOP_KEY ] as  $p_key => $p_value ){
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

                                    $_parentchart_loop			        = $prices_chart[ 'whoattendlist' ]['members'];
                                    $_parentchart_loop_addons			= $prices_chart[ 'whoattendlist' ]['addons'];
                                    
                                    break;
                            }
      
                      
                            switch ( TRUE )
                            {
                                case $eb_regular == "earlybird_price" and $p_key == 1:
                                    #$output_text	= "Early Bird Discounted Rates ( " . $registration_beforedate . " ) "; //for Non-IMI Members 
                                    $output_text	= "Discounted Advance Rates For Non Members ( " . $registration_beforedate . " ) "; //for Non-IMI Members 
                                    $is_imi			= FALSE;
                                    break;
                                    
                                case $eb_regular == "earlybird_price" and $p_key == "2":
                                    #$output_text	= "Early Bird Discounted Rates ( " . $registration_beforedate . " ) "; //for IMI Members 
                                    $output_text	= "Discounted Advance Rates For Members ( " . $registration_beforedate . " ) "; //for IMI Members 
                                    break;
                                    
                                case $eb_regular == "regular_price" and $p_key == 1:
                                    #$output_text	= "General Registration Rates ( " . $registration_afterdate . " ) "; //for Non-IMI Members 
                                    $output_text	= "Onsite Registration Rates For Non Members ( " . $registration_afterdate . " ) "; //for Non-IMI Members 
                                    $is_imi			= FALSE;
                                    break;
                                
                                case $eb_regular == "regular_price" and $p_key == 2:
                                    #$output_text	= "General Registration Rates ( " . $registration_afterdate . " ) "; //for IMI Members
                                    $output_text	= "Onsite Registration Rates For Members ( " . $registration_afterdate . " ) "; //for IMI Members
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
                if ( is_array($parent_addon_loop) )
                {
                    foreach ($parent_addon_loop[$eb_regular] as $key => $addon_detail)
                    {
                        
                        $a = array_keys($parent_addon_loop[$eb_regular]);
                        
                        $_title        = $addon_detail[$pricetype_id]['title_for_price'];
                        $_description  = $parent_addon_loop[$pricetype_id]['description_for_price'];
                        $__description = ( !empty($_description) ) ? $_description : "";


                        if($is_member != "1" && $p_key != IMI_NON_MEMBER ){
                            $style_ad = 'style="display: none;"';
                        }else if($is_member == "1" && $p_key == IMI_NON_MEMBER){
                            $style_ad = 'style="display: none;"';
                        }else if($is_member == "1" && $p_key != IMI_NON_MEMBER ){
                            $style_ad = 'style="display: table-block;"';
                        }else if($is_member != "1" && $p_key == IMI_NON_MEMBER){
                            $style_ad = 'style="display: table-block;"';
                        } 

                ?>
                <div <?php echo $style_ad ?> class="reg-ticket-section-table conf-reg-s-two-table <?php echo $p_key == IMI_NON_MEMBER ? 'non_member_data' : 'member_data'; ?>">
                    <table width="100%" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr class="conf-table-head">
                                <th>
                                    <?php echo $_title;   ?>
                                </th>
                            </tr>
                            <tr>
                                <td>

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="pkg-table">
                                        <tbody>
                                            <?php
                                                if ( array_key_exists("addon", $addon_detail) )
                                                {
                                                    $addonchild_data = $addon_detail['addon'];
                                                    $a = array_keys($addonchild_data);

                                               

                                                    foreach($addonchild_data as $addonchild_each){
                                                        $tmp_name 				= "registration_tickets_child[". $addonchild_each[$p_key]['id'] ."]";
                                                        $tmp_value				= $addonchild_each[$p_key]['id'] . '::' . $addonchild_each[$p_key]['price'];
                                                        $tmp_name_addons 		= "is_addon[". $addonchild_each[$p_key]['id'] ."]";
                                                        ?>
                                                        <tr>
                                                            <td class="pkg-names">
                                                                <p><?php echo $addonchild_each[$p_key]['title_for_price']; ?></p>
                                                                <span class="pkg-description"><?php echo $addonchild_each[$p_key]['description_for_price']; ?></span>
                                                            </td>
                                                            <td class="pkg-prices">
                                                                <label>
                                                                    <input
                                                                        type="hidden" name="<?php echo $tmp_name;?>"
                                                                        data-price="<?php echo $addonchild_each[$p_key]['price'];?>"
                                                                        class="<?php echo set_class( $tmp_name );?> pak_step-form-package-input" 
                                                                        value="<?php echo $tmp_value;?>"  
                                                                         /> 
                                                                    <input
                                                                        type="hidden" name="<?php echo $tmp_name_addons;?>"
                                                                        class="<?php echo set_class( $tmp_name_addons );?>" 
                                                                        value="1"  
                                                                         /> 
                                                                        <span data-price="<?php echo $addonchild_each[$p_key]['price'];?>"  data-title="<?php echo $addon_detail[$p_key]['title_for_price'] ?>"class=" pak_step-form-package-input"><?php echo $addonchild_each[$p_key]['pricedisplay'];?></span>
                                                                    
                                                                    <!-- <span class="pak_step-form-package-desc" ><?php //echo nl2br( $__DESCFORPRICE );?></span> -->
                                                                    
                                                                </label>
                                                            </td>
                                                            <td class="no-of-persons">
                                                                <?php
                                                                    $class_weight			= "weight";
                                                                    $array_weight			= $numbers_multiplyby;	
                                                                    $max                    = 10;
                                                                    $min                    = 0;
                                                                    
                                                                    // if ( $__WHOATTENDWEIGHT > 0 )
                                                                    // {
                                                                      
                                                                    ?>
                                                                        <span class="<?php echo $class_weight;?>" >
                                                                        <span class="sub-before add-sub" ></span>
                                                                        <?php
                                                                        $tmp_mb			= 'multiply_by['. $addonchild_each[$p_key]['id'] .']';
                                                                        // $val =  $_POST["multiply_by"][ $addonchild_each[$p_key]['id'] ] ? $_POST["multiply_by"][ $addonchild_each[$p_key]['id'] ] : 0;
                                                                        echo form_number_input($tmp_mb, 
                                                                        set_value($tmp_mb, $multiply_by[ $addonchild_each[$p_key]['id']  ]),
                                                                                            "class='form-control ". set_class( $tmp_mb ) ." '" ,
                                                                                            $min,
                                                                                            $max);
                                                                        echo form_error( $tmp_mb );
                                                                        ?>
                                                                        <span class="add-after add-sub" ></span>
                                                                        </span>
                                                                    <?php
                                                                    // }
                                                                    ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }else{
                                                        ?>
                                                    <tr>
                                                        <td class="pkg-names">
                                                            <p><?php echo $addon_detail[$p_key]['title_for_price']; ?></p>
                                                            <span class="pkg-description"><?php echo $addon_detail[$p_key]['description_for_price']; ?></span>
                                                        </td>
                                                        <td class="pkg-prices"> 
                                                            <label>
                                                                <input
                                                                    type="hidden" name="<?php echo $tmp_name;?>"
                                                                    data-price="<?php echo $addonchild_each[$p_key]['price'];?>"
                                                                    class="<?php echo set_class( $tmp_name );?> pak_step-form-package-input" 
                                                                    value="<?php echo $tmp_value;?>"  
                                                                   />
                                                                
                                                                
                                                                    <span class="pak_step-form-package-input" data-price="<?php echo $addonchild_each[$p_key]['price'];?>"><?php echo $addon_detail[$pricetype_id]['pricedisplay'];?></span>
                                                                
                                                                <!-- <span class="pak_step-form-package-desc" ><?php echo nl2br( $__DESCFORPRICE );?></span> -->
                                                                
                                                            </label>
                                                        </td>
                                                        <td class="no-of-persons">
                                                            <?php
                                                                $class_weight			= "weight";
                                                                $array_weight			= $numbers_multiplyby;	
                                                                $max                    = 10;
                                                                $min                    = 0;
                                                                
                                                                if ( $__WHOATTENDWEIGHT > 0 )
                                                                {
                                                                ?>
                                                                    <span class="<?php echo $class_weight;?>" >
                                                                    <span class="sub-before add-sub" ></span>
                                                                    <?php
                                                                    $tmp_mb			= 'multiply_by['. $__ID .']';
                                                                    echo form_number_input($tmp_mb, 
                                                                    set_value($tmp_mb, $multiply_by[ $__ID  ]),
                                                                                        "class='form-control ". set_class( $tmp_mb ) ." '" ,
                                                                                        $min,
                                                                                        $max);
                                                                    echo form_error( $tmp_mb );
                                                                    ?>
                                                                    <span class="add-after add-sub" ></span>
                                                                    </span>
                                                                <?php
                                                                }
                                                                ?>
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
                </div>
            <?php 
                }
            }
        }
    }
        ?>
        </div>
        </div>
        
        
        
        <?php ob_start();
        /*$prefix = "$";
        if($conferenceregistration->row("show_rates_in_currency") == "35"){
            $prefix = "Rs";
        }*/
		$prefix			= $this->functions->getCurrencySymbol($conferenceregistration->row("show_rates_in_currency")) ;
        
		$screentwo_data = $conferenceregistration_screentwo->result_array();
        ?>
        <div class="reg-ticket-rightsection pak_step-form-cart">
            <h1>In Your Cart</h1>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="cart-table">
                <!-- <?php //  $price_package_fee = $screentwo_data[0]["price_package_fee"] ? $screentwo_data[0]["price_package_fee"] : 0; ?>
                <tr class="package-fees">
                    <td height="35" width="50%">Package Fees :</td>
                    <td height="35" width="50%" align="right">
                    
                    <strong class="js_package_fee">
                    <?php // echo format_price("<span>".$price_package_fee."</span>", array("prefix" => $prefix), TRUE, TRUE );?>
                    <input type="hidden" name="txt_package_fee" value=<?php // echo $price_package_fee ?>  />
                    </strong>
                    </td>
                </tr> -->
                <?php // if ($screentwo_data[0]["be_a_member_fee"] > 0){
                    $be_a_member_fee = $screentwo_data[0]["be_a_member_fee"] ? $screentwo_data[0]["be_a_member_fee"] : 0;
                    ?> 
                <tr class="tr_nam" style="display:none;">
                  <td height="35">
                  <small>(Not a member FEE)</small>
                  </td>
                  <td height="35" align="right">
                    <strong class="js_not_a_member_fee">
                    <?php echo format_price("<span>".$be_a_member_fee."/span>", array("prefix" => $prefix), TRUE, TRUE );?>
                    <input type="hidden" name="txt_not_a_member_fee" value=<?php echo $be_a_member_fee ?>  />
                    </strong>
                  </td>
                </tr>
                <?php 
                //}
                foreach ($conferenceregistration_screentwo_details->result_array() as $std)
                {
                    $conference_prices_details 		= $this->queries->fetch_records("short_conference_prices_details", " AND id = '". $std["price_details_id"] ."' ");
                    $parent_addon  		            = $this->db->query("SELECT * from `tb_short_conference_prices_master` where id = '".$conference_prices_details->row()->prices_parent_id."'");

                    if ( $conference_prices_details->num_rows() > 0 )
                    {
                        $explode_price_details_value		= explode("::", $std["price_details_value"]);
                    ?>
                        <tr id="<?php echo $std['price_details_id'] ?>">
                            <td width="200px;" style="margin-bottom: 12px;display: block;">
                                <?php if($std['addon'] != 1){ ?>
                                    <strong><?php echo $conference_prices_details->row()->whoattend_nam;?></strong>
                                <?php } ?>
                                <p><strong><?php echo $parent_addon->row()->title;?></strong></p>
                                <?php echo $conference_prices_details->row()->prices_title;?>
                                <br  />
                            </td>
                            <td width="100px;" class="prices" height="35" align="right">
                            <?php echo $std["multply_by_no_of_people"] ;?> 
                            x 
                            <?php echo format_price( $explode_price_details_value[1], array("prefix" => $this->functions->getCurrencySymbol($conferenceregistration->row("show_rates_in_currency"))) );?>
                            </td>
                        </tr>
                    <?php
                    }
                }
                ?>
                <?php
                if ( $output_abspaid )
                {
                ?>
                    <tr class="tr_abspaid">
                        <td height="35">
                            <small>Abstract Submission Form (Paid)</small>
                        </td>
                        <td height="35" align="right">
                            <strong class="js_abs_paid">
                            <?php echo format_price("<span>(". $output_abspaid .")</span>", array("prefix" => $prefix), TRUE, TRUE );?>
                            </strong>
                        </td>
                    </tr>
                <?php
                }
                ?>
                
                <?php $payable_now = $screentwo_data[0]["price_payable_now"] ? $screentwo_data[0]["price_payable_now"] : 0; ?>
                <tr>
                    <td height="35">Payable Now : 
                    <span style="display:none;" class="parent_js_payable_now_perc">
                        (<span class="js_payable_now_perc">100</span>%)
                    </span>
                    </td>
                    <td height="35" align="right">
                   
                    <strong class="js_payable_now">
                    <?php echo format_price("<span>".$payable_now."</span>", array("prefix" => $prefix), TRUE, TRUE );?>
                    <input type="hidden" name="txt_payable_now" value=<?php echo $payable_now ?>  />
                    <input type="hidden" name="txt_abs_paid" value="<?php echo $output_abspaid;?>"  />
                    </strong>
                    </td>
                </tr>
<!--             
                <tr>
                    <td height="35">Cash OnSite :</td>
                    <td height="35" align="right">
                    <strong class="js_cash_onsite">
                    <?php // echo format_price("<span>0.00</span>", array("prefix" => $prefix), TRUE, TRUE );?>
                    <input type="hidden" name="txt_cash_onsite" value="0"  />
                    </strong>
                    </td>
                </tr> -->
                
                <tr style="border-bottom:1.5px solid rgba(90, 90, 90, 0.2);">
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>  
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>  
                </tr>
                <?php $payable_total = $screentwo_data[0]["price_total_payable"] ? $screentwo_data[0]["price_total_payable"] : 0 ?>
                <tr>
                    <td><strong>Total Payable:</strong></td>
                    <td align="right" class="totalpayable">
                   
                    <strong class="js_total_payable">
                    <?php echo format_price("<span>".$payable_total."</span>", array("prefix" => $prefix), TRUE, TRUE );?>
                    </strong>
                    
                    <input type="hidden" name="txt_total_payable" value=<?php echo $payable_total ?>  />
                    </td>
                </tr>
                <tr >
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>  
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>  
                </tr>
            </table>
            <div class="fix-on-scroll">
                <input type="hidden" name="id" value="<?php echo set_value("id", $id);?>"  />
                <input type="submit" name="proceedfurther" value="<?php echo lang_line('text_saveandproceed');?>" class="bluebuttons hidden" style="display:none;">
                <input type="button" name="Submit" onclick="$(this).attr('disabled', true); $(this).attr('value','Processing'); $('.hidden').click();" value="<?php echo lang_line('text_saveandproceed');?>" class="bluebuttons">
            </div>
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