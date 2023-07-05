<?php $this->carabiner->js(  FRONTEND_FOLDER_JS . 'shortconferenceonepagecalc.js'); ?>
<div class="screen_one_status">
    `<div class="conf-reg-page-top">
        <h1><?php echo lang_line('text_conferenceregistration');?></h1>
        <p><?php echo conference_fullname( $conference );?></p>
        <span><?php echo conference_durationdates( $conference );?> </span>
    </div>
	<div class="alert alert-danger print-error-msg" style="display:none"></div>
	<!-- <form> -->
<?php
   
	?>
	
    <?php
    $attributes 			= array("method"		=> "post",
                                    "enctype"		=> "multipart/form-data",
                                    "name"			=> "form1",
                                    "id"			=> "form1",
                                    "novalidate"    => true
                                );
    
    echo form_open(site_url( uri_string() ), $attributes);
    $data["_messageBundle"]				= $_messageBundle2;
	?>
		<div class="inline_error_style"><?php $this->load->view('frontend/template/_show_messages.php', $data); ?> </div>

		<input class="bluebuttons btnSubmit" name="submitform" type="submit" value="Submit" style="display:none;">
		<p class="align_center m_bottom25"><strong>Note</strong> : In case of technical support, please reach out to <a href="mailto:neelam.raheel@genetechsolutions.com">neelam.raheel@genetechsolutions.com</a> or send whastapp message +92-3002522862. Live help with immediate assistance via WhatsApp is available from <strong>8:00 pm CST - 1:00 pm CST</strong>.</p>
		<div class="conf-reg-page-table">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						<td width="48%">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tbody class="s-form-flex">
									<tr class="field-block">
										<td>
											<label>Title : </label>
										</td>
										<td width="100%">
											<?php

                                        $tmp_name = 'prefix';
                                        
                                        echo form_dropdown('prefix', DropdownHelper::prefix_dropdown(), set_value( $tmp_name, $$tmp_name ) === 0 ? '' : set_value( $tmp_name, $$tmp_name ), "class='form-control ". set_class( 'prefix' ) ." '" );
                                        echo form_error("prefix");
                                        ?>
										</td>
									</tr>
									<tr class="field-block">
										<td>
											<label>Name :
												<?php echo required_field('fontsize_1-4em');?>
											</label>
										</td>
										<td width="100%">
											<?php
                                $tmp_name		= 'name';
                                if($this->functions->_user_logged_in_details("id")){
                                    $tmp_value      = $this->functions->_user_logged_in_details("name");
                                }else{
                                    $tmp_value      = set_value( $tmp_name, $$tmp_name ) === 0 ? '' : set_value( $tmp_name, $$tmp_name );
                                }
                                $specdata		= array("name"			=> $tmp_name,
                                                        "id"			=> $tmp_name,
                                                        
                                                        "type"			=> "text",
                                                        "class"			=> set_class( $tmp_name ),
                                                        "value"			=> $tmp_value ,
                                                        "placeholder"	=> "Name");	
                                // var_dump(set_value( $tmp_name, $$tmp_name ) === 0 ? ' ' : set_value( $tmp_name, $$tmp_name ) );
                                echo form_input($specdata);
                                echo form_error( $tmp_name );
                                ?> <small class="passport_note">(as it appears on your passport)</small> </td>
									</tr>
									<tr class="field-block">
										<td>
											<label>Email :
												<?php echo required_field('fontsize_1-4em');?>
											</label>
										</td>
										<td>
											<?php
                                    $tmp_name		= 'email';
                                    if($this->functions->_user_logged_in_details("id")){
                                        $tmp_value      = $this->functions->_user_logged_in_details("email");
                                    }else{
                                        $tmp_value      = set_value( $tmp_name, $$tmp_name ) === 0 ? '' : set_value( $tmp_name, $$tmp_name );
                                    }
                                    $specdata		= array("name"			=> $tmp_name,
                                                            "id"			=> $tmp_name,
                                                            
                                                            "type"			=> "text",
                                                            "class"			=> set_class( $tmp_name ),
                                                            "value"			=> $tmp_value ,
                                                            "placeholder"	=> "Email");	
                            
                                    echo form_input($specdata);
                                    echo form_error( $tmp_name );
                                    ?>
										</td>
									</tr>
									<tr class="field-block">
										<td>
											<label>Phone :
												<?php echo required_field('fontsize_1-4em');?>
											</label>
										</td>
										<td>
											<?php
                                        $tmp_name		= 'phone';
                                        $specdata		= array("name"			=> $tmp_name,
                                                                "id"			=> $tmp_name,
                                                                
                                                                "type"			=> "text",
                                                                "class"			=> set_class( $tmp_name ),
                                                                "value"			=> set_value( $tmp_name, $$tmp_name ),
                                                                "placeholder"	=> "Phone");	
                                        
                                        echo form_input($specdata);
                                        echo form_error( $tmp_name );
                                        ?>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="conf-reg-page-table num_fam_table">
			<div class="mi-family-relation">
				<div class="mi-family-relation-head">
					<div class="mi-family-relation-head-data">
						<h3>Number of Family Members Accompanying you? </h3>
						<div class="mifamily-relation-members"> <span class="weight">
                        <span class="sub-before remove-member"></span>
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
                                // $tmp_value      = $_POST['no_of_family_members'] == 0 ? 1 : $_POST['no_of_family_members'] ;
                                $tmp_value      =  $_POST['no_of_family_members'] ;
                                echo form_number_input('no_of_family_members', 
                                   $tmp_value  ,
                                                    " class='form-control". set_class( $tmp_mb ) ." '" ,
                                                    $min,
                                                    $max);
                                echo form_error( $tmp_mb );
                            ?>							<span class="add-after add-member"></span> </span>
							<input type="hidden" name="hdn_no_of_family_members" value="<?php echo $tmp_value ?>"> </div>
					</div>
                    <p style="color:#4c3d3d; font-weight:700">(Add only If they're attending the conference)</p>

					<p class="align_center m_bottom25 m_top25" style="color:white;"><strong>Note: </strong>Please enter the names and details of those family members also registering for the conference, womens wing special program and youth program. For those joining you only for the banquet, please do not add names here-you may buy additional banquet tickets for guests under your own conference registration.</p>
				</div>
				<div class="mi-family-relation-info">
                    
                    <?php if($tmp_value > 0){ 
                        
                        for($i=1; $i <= $tmp_value; $i++)
                        {
                            $index			= $i;
                            $index++;

                        ?>
					<div class="mi-family-relation-info-row">
						<div class="mi-family-relation-info-name">
							<label>Name:<sup>*</sup></label>
							<?php
                                $tmp_name		= 'family_name['.$i.']';
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
                                $tmp_name		= 'family_id['.$i.']';
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
							<label>Email:<sup>*</sup></label>
							<?php
                                $tmp_name		= 'family_email['.$i.']';
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
							<label>Relationship:</label>
							<?php
                                $tmp_name				= 'family_relationship['.$i.']';
                                echo form_dropdown($tmp_name, 
                                                    DropdownHelper::relationship_dropdown(), 
                                                    set_value($tmp_name, $family_relationship[$i]), 
                                                    "class='form-control ". set_class( $tmp_name ) ." '" );
                                ?>
						</div>
						<div class="mi-family-relation-info-age">
							<label>Age:</label>
							<?php
                                $tmp_name				= 'family_age['.$i.']';
                                $arrayindex				= NumberHelper::number_array( range("1", "90") );
                                echo form_dropdown($tmp_name, 
                                                    $arrayindex, 
                                                    set_value($tmp_name, $family_age[$i]), 
                                                    "class='form-control ". set_class( $tmp_name ) ." '" );
                            ?>
						</div>
						
					</div>
                    <?php 
                        }
                    } ?> 
				</div>
			</div>
			<!-- ISMAIL CODE END -->
		</div>
		<div class="screen_two_status">
			<div class="reg-ticket-section pak_step-form-info">
				<div class="reg-ticket-leftsection pak_step-form">
					<div class="pak_step-form-heading">
						<h2>Select your package for: <span class="blue">IMI Conference Registration</span></h2></div>
					<?php
          

                $todaydate					    = strtotime(date("Y-m-d"));
                $registration_beforedatet		= strtotime($registration_beforedate);



                

            ?>
						<input type="hidden" name="hdn_options_selected" value="members">
						<input type="hidden" name="hdn_total_no_of_people_weight">
                        <input type="hidden" name="already_registered_conference">
                        
                        <span class="fromerror_lft"></span> <span class="fromerror_lft"></span>
						<div class="reg-ticket-section-tabs">
							<ul class="confreg_price_selection pak_step-form-wrapper reg-ticket-section-tab active-tab" data-tab-type="g-reg">
								<?php 
                    
                    if($todaydate <= $registration_beforedatet){
                    
                        $output_heading = "Early Bird";
                        $output_text	= "Discounted Advance Rates  ( " . $registration_beforedate . " ) ";  
                        $eb_regular     = 'earlybird_price';
                    }else if ($todaydate > $registration_beforedatet){
                        
                        $eb_regular     = 'regular_price';
                        $output_heading = "General Registration";
                        $output_text	= "Onsite Registration Rates ( " . $registration_afterdate . " ) "; 
                    }

                    ?>                                                       
                    <li  class="pak_step-form-package">
                        <label class="pak_step-form-package-type">
                            <input style="display:none;" type="radio" data-percentage="100" data-isimi="1" data-alwaysdisabled="" name="registration_tickets[earlybird_price][2]" class="" value="earlybird_price_2"> 

                            <span class="pak_step-form-package-radio member_span"><?php echo $output_heading ?></span>
                            <span class="pak_step-form-package-type-label display-member-text"><?php echo $output_text ?></span>
                        </label>
                    </li>
                </ul>

              
               
            </div>
               
                <div class="reg-ticket-section-wrapper">
                <div class="reg-ticket-section-table conf-reg-s-two-table">
                <table width="100%" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr class="conf-table-head">
                                <th>
                                    Conference Registration
                                </th>
                            </tr>
                            <tr>
                                <td>

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="pkg-table">
                                        <?php
                                     
                                        foreach($tmp_paymenttype["members"] as  $p_key => $p_value ){

                                              
                                                $pricetype_id			= $p_key;
                                                // $eb_regular				= $e_key;

                                                $_parentchart_loop			        = $prices_chart[ $LOOP_KEY ][ $eb_regular ][$pricetype_id];

                                                $_parentchart_loop			        = $prices_chart[ 'whoattendlist' ]['members'];
                                                $_parentchart_loop_addons			= $prices_chart[ 'whoattendlist' ]['addons'];
                                                
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
                                        <?php // var_dump($style); ?>
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
                                                        $tmp_value 				= $_POST['multiply_by'][ $__ID  ];
                                                        echo form_number_input($tmp_name, 
                                                        $tmp_value,
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
                                        // }
                                        ?>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
               
                </div>
                <?php
                $parent_addon_loop = $prices_chart[ 'whoattendlist' ]["addons"];
               
                foreach($tmp_paymenttype["members"] as  $p_key => $p_value ){
                   
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
                                                                        $tmp_value 				= $_POST['multiply_by'][ $addonchild_each[$p_key]['id'] ];
                                                                        // $val =  $_POST["multiply_by"][ $addonchild_each[$p_key]['id'] ] ? $_POST["multiply_by"][ $addonchild_each[$p_key]['id'] ] : 0;
                                                                        echo form_number_input($tmp_mb, 
                                                                        $tmp_value,
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
                                                                    $tmp_value 		= $_POST['multiply_by'][ $__ID  ];

                                                                    echo form_number_input($tmp_mb, 
                                                                    $tmp_value,
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
        ?>
                    </div>
        </div>

      
        
        
                <div class="reg-ticket-rightsection pak_step-form-cart">
            <h1>In Your Cart</h1><div class="theme-selector"></div><div class="theme-selector"></div>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="cart-table">
                <!--                 <tr class="package-fees">
                    <td height="35" width="50%">Package Fees :</td>
                    <td height="35" width="50%" align="right">
                    
                    <strong class="js_package_fee">
                                        <input type="hidden" name="txt_package_fee" value=  />
                    </strong>
                    </td>
                </tr> -->
						<tbody>
							<tr class="tr_nam" style="display:none;">
								<td height="35"> <small>(Not a member FEE)</small> </td>
								<td height="35" align="right"> <strong class="js_not_a_member_fee">
                    $<span>0/span&gt;                    <input type="hidden" name="txt_not_a_member_fee" value="0">
                    </span></strong> </td>
							</tr>
							<tr>
								<td height="35">Payable Now : <span style="display:none;" class="parent_js_payable_now_perc">
                        (<span class="js_payable_now_perc">100</span>%) </span>
								</td>
								<td height="35" align="right"> <strong class="js_payable_now">
                    $<span><?php echo $_POST['txt_total_payable'] ? $_POST['txt_total_payable'] : 0?></span>                    <input type="hidden" name="txt_payable_now" value="<?php echo $_POST['txt_payable_now']?>">
                    <input type="hidden" name="txt_abs_paid" value="">
                    </strong> </td>
							</tr>
							<!--             
                <tr>
                    <td height="35">Cash OnSite :</td>
                    <td height="35" align="right">
                    <strong class="js_cash_onsite">
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
							<tr>
								<td><strong>Total Payable:</strong></td>
								<td align="right" class="totalpayable"> <strong class="js_total_payable">
                    $<span><?php echo $_POST['txt_total_payable'] ? $_POST['txt_total_payable'] : 0?></span>                    </strong>
									<input type="hidden" name="txt_total_payable" value="<?php echo $_POST['txt_total_payable']?>"> </td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
						</tbody>
					</table>
					<div class="fix-on-scroll">
						<input type="hidden" name="id" value="">
						<input type="submit" name="proceedfurther" value="Save &amp; Proceed" class="bluebuttons hidden" style="display:none;">
						<!-- <input type="button" name="Submit" onclick="$(this).attr('disabled', true); $(this).attr('value','Processing'); $('.hidden').click();" value="Save &amp; Proceed" class="bluebuttons"> -->
					</div>
				</div>
				<input type="hidden" name="email_text" value="" id="email_text" class=""> </div>
			<div class="couponsubmitbtn1" style="display:none;"> Coupon Code :
				<input type="text" name="coupon_code" value="" id="coupon_code" class="" placeholder="Coupon Code"> </div>
			<div class="couponsubmitbtn fromerror_lft"> </div>
		</div>
        <?php if (isset($card_error)) { ?>
            <p class="form_error col-sm-12 no-padding">
                <?php echo $card_error; ?>
            </p>
        <?php } ?>
		<div class="flt-rgt mq-imi-pay-sec">
			<input type="hidden" name="id" value="">
			<div class="payment-div no-padding m_bottom10 custom_style1">
				<label class=" m_bottom5 paypal ">
					<input type="radio" name="payment_type" value="paypal" id="paypal">Pay via PayPal </label>
				<label class=" m_bottom5 m_rite10 credit-card active">
					<input type="radio" name="payment_type" value="card" checked="checked" id="card">Pay via Credit Card </label>
			</div>
			<input type="submit" name="makepayment" value="Pay Now" class="blackbuttons flt-rgt makepayment" style="display:none;">
			<div class="formarea mq-main-head-2">
                
            <form class="mq-form-payment-5 " name="payment_form" action="<?php echo site_url( uri_string() ); ?>" method="post" target="_top">
                <table cellpadding="2" cellspacing="5" width="100%" class="semiform mq-semiform">
					<tbody>
						<tr>
							<td class="mq-layout-fixed">
                            <div class="card-details col-sm-12 no-padding m_bottom10 mq-card-details">
                                    <div class="col-sm-12 no-padding scal-bttom mq-card-content">
                                        <div class="col-sm-12 no-padding m_bottom10 mq-input-div">
                                            <div class="col-sm-6 paddzERo mq-input">
                                                <?php
                                                $card_name       = array(
                                                    "name"          => "card_name",
                                                    "id"            => "card_name",
                                                    "value"         => set_value("card_name"),
                                                    "class"         => "donationPclass",
                                                    "placeholder"   => "Card Holder Name" . " * "
                                                );
        
                                                echo form_input($card_name);
        
                                                echo form_error('card_name');
                                                ?>
                                            </div>
                                            <div class="col-sm-6 paddRzERo mq-input">
                                                <?php
                                                $card_number       = array(
                                                    "name"          => "card_number",
                                                    "id"            => "card_number",
                                                    "value"         => set_value("card_number"),
                                                    "class"         => "donationPclass",
                                                    "placeholder"   => "Card Number" . " * "
                                                );
        
                                                echo form_input($card_number);
        
                                                echo form_error('card_number');
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 no-padding m_bottom10 mq-input-div">
                                            <div class="col-sm-6 paddzERo mq-input">
                                                <?php
                                                $card_expiry       = array(
                                                    "name"          => "card_expiry",
                                                    "id"            => "card_expiry",
                                                    "value"         => set_value("card_expiry"),
                                                    "class"         => "donationPclass",
                                                    "placeholder"   => "Card Expiry" . " * "
                                                );
        
                                                echo form_input($card_expiry);
        
                                                echo form_error('card_expiry');
                                                ?>
                                            </div>
                                            <div class="col-sm-6 paddRzERo mq-input">
                                                <?php
                                                $card_cvv       = array(
                                                    "name"          => "card_cvv",
                                                    "id"            => "card_cvv",
                                                    "value"         => set_value("card_cvv"),
                                                    "class"         => "donationPclass",
                                                    "placeholder"   => "Card CVV Code" . " * ",
                                                    "pattern"       => "\d*",
                                                    "maxlength"     => "4"
                                                );
        
                                                echo form_input($card_cvv);
        
                                                echo form_error('card_cvv');
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 no-padding m_bottom10 mq-btn-submit">
                                            <!-- <button class="btn-payezzy-submit" name="card_payment" type="submit" onclick="submitForm(); return false;" value="Pay Now">Pay Now</button> -->
                                            <button class="btn-payezzy-submit" name="card_payment" type="submit" value="Pay Now">Pay Now</button>
                                        </div>
                                    </div>
                                </div>
							</td>
						</tr>
					</tbody>
				</table>
            </form>
            <?php 
            $user_id = $this->functions->_user_logged_in_details( "id" ) > 0 ? $this->functions->_user_logged_in_details( "id" ) : SessionHelper::_get_session("userid", "conferenceregistrationguestuser");
            ?>
            
			</div>
		</div> 
		
<script type="text/javascript">
function submitForm(){
    $("button.btn-payezzy-submit").prop("onclick", null).off("click");
    $("button.btn-payezzy-submit").trigger("click");
    $("button.btn-payezzy-submit").attr('disabled', true);
}
document.addEventListener('DOMContentLoaded', () => {
    const cleave = new Cleave('#card_number', {
		creditCard: true,
		// onCreditCardTypeChanged: function(type) {
		// 	 update UI ...
		// }
	});
	const cleave1 = new Cleave('#card_expiry', {
		date: true,
		datePattern: ['m', 'y']
	});
});
$(document).on('change', 'input[name="payment_type"]', function() {
    if ($(this).val() == "card") {
		$('.card-details').show();
        $(this).parent().siblings().removeClass('active');   
        $(this).parent().addClass('active');	
		$('.makepayment').hide();

    } else {        	
        $(this).parent().siblings().removeClass('active');   
        $(this).parent().addClass('active');
		$('.card-details').hide();
		$('.makepayment').show();
	}
});

</script>                            


	<!-- </form> -->
	<?php
     echo form_close();
    ?>