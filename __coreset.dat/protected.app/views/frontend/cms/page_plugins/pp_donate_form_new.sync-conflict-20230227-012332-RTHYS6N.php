<style>
    .custom_style1 label {
        float: none !important;
    }

    .custom_style1 input {
        float: none !important;
    }
</style>
<script>
locationID = '<?php echo $locationID ?>'
</script>
<?php
$from_name = '';
$from_first_name = '';
$from_last_name = '';
$email_address = '';
$home_country = 0;
$lang = getCurrentLang($content_languages);
if ($this->session->userdata('user_logged_in')) {
    if ($this->functions->_user_logged_in_details("is_member") || true) {
        $from_name = $this->functions->_user_logged_in_details("name") . ' ' . $this->functions->_user_logged_in_details("last_name");
        $from_first_name = $this->functions->_user_logged_in_details("name");
        $from_last_name = $this->functions->_user_logged_in_details("last_name");
        $email_address = $this->functions->_user_logged_in_details("email");

        $user_id = $this->functions->_user_logged_in_details("id");

        $users_profile = $this->imiconf_queries->fetch_records_imiconf("users_profile", " AND userid = '" . $user_id . "' ");

        if ($users_profile->num_rows() > 0) {
            $home_country = $users_profile->result()[0]->home_country;
        }
    }
}
//$sitekey = '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI'; testing
$sitekey = '6Le_N_QUAAAAAKzKoKE3aopntNguOy7ppf7kzafV';
?>
<script>
function addItem(id){
    $('#'+id).attr('disabled', true);
    $('#'+id).addClass('submitthis');
    grecaptcha.execute();
}
function onSubm(token){
    $("input#hiderecap").val(token);
    if($.trim(token)){
        $("button.submitthis").attr('disabled', false);
        $("button.submitthis").prop("onclick", null).off("click");
        $("button.submitthis").trigger("click");
        $("button.submitthis").attr('disabled', true);
    } else {
        $("button.submitthis").removeClass("submitthis");
    }
}
</script>
<div class="g-recaptcha" data-sitekey="<?php echo $sitekey; ?>" data-size="invisible" data-callback="onSubm"></div>
<div class="new-donate-page">
<div class="donate-div-view">
    <div class="DonateNow donate-content-section" id="give-now" >
        <?php if(validation_errors() != false || isset($card_error)) { 
            echo '<div class="error-exist">';
                echo "There are some invalid/missing data. Please review the form and submit again.";
            echo '</div>'; 
        }?>
        <div id="donation-err-msg" class="error-exist" style="display:none;">You cannot proceed to next step before selecting the donation cause</div>
        <div class="donation-allow-other-country">
            <ul class="country-listing-donation" data-post-country="<?php echo isset( $_POST['currency_code'] ) ? $_POST['currency_code'] : ""; ?>">
                <?php $country_ids = array_column($chapter_countries,'country_id');
                $is_user_country = in_array($locationID ,$country_ids)?>
            
                <?php foreach($chapter_countries as $chapter_country):?>
                     <?php 
                         if( $chapter_country['country_id'] == $locationID)
                        {
                            $active_payPal['code'] = $chapter_country['code']; 
                            $active_payPal['paypal_email'] = $chapter_country['paypal_email']; 
                            $active_payPal['id'] = $chapter_country['id']; 
                        }
                    endforeach;
                   
                if(is_countryCheck(FALSE,FALSE,TRUE) == 'canada'){
                    ?>
                   
                    <li class="giving-to-imi" data-currency-code="USD" data-country-id="223" data-paypal-email="imi@imamiamedics.com" data-belongs-country="2" ><div class='cust-flag-div'><img class="flag-image" src="<?php echo site_url('/assets/frontend/images/flags')."/".strtolower('US').".png" ?>"></div><small>Giving to </small> IMI Global</li>
                <?php 
                     
                }else if(site_url() == 'https://imicanada.org/' ){
                    ?>
                    <li class="giving-to-imi" data-currency-code="CAD" data-country-id="38" data-paypal-email="imamiacanada@gmail.com" data-belongs-country="3" ><div class='cust-flag-div'><img class="flag-image" src="<?php echo site_url('/assets/frontend/images/flags')."/".strtolower('CA').".png" ?>"></div><small>Giving to </small> IMI Canada</li>
                    <?
               } ?> 
            </ul>
        </div>
        <div class="hundred">
            <a id="hash_donate_form" name="hash_donate_form"></a>
            <div class="form_sec fl_lft w_100 donate_form_continer">
                <?php
                if ($this->session->userdata('user_logged_in') || TRUE) {

                    if ($this->functions->_user_logged_in_details("is_member") || TRUE) {

                        if ($DONATEFORM['_process_to_paypal']) {

                            $data["_messageBundle"]             = $DONATEFORM['_messageBundle_redirect_paypal'];
                            $this->load->view('frontend/template/_show_messages.php', $data);

                            if($this->session->userdata('site_settings')['PAYPAL_MODE'] == 0){
                                $payment_type = $this->session->userdata('site_settings')['PAYPAL_EMAIL_SANDBOX'];
                             }else{
                                 $payment_type = $DONATEFORM['_business_email'];
                             }
                             
                            ?>

                            <form name="form_donateform" action="<?php echo $this->payment->paypal_form_details()->url; ?>" method="post" novalidate>
                                <input type="hidden" value="<?php echo $payment_type; ?>" name="business">
                                <input type="hidden" value="<?php echo $DONATEFORM['currency_code']; ?>" name="currency_code">
                                <input type="hidden" value="<?php echo $this->functions->_user_logged_in_details("id"); ?>" name="item_number">
                                <?php if ($_POST["donation_mode"] == "recurring") {
                                    $TMP_explode_donation_freq              = explode("-", set_value("donation_freq"));
                                    ?>
                                    <input type="hidden" value="_xclick-subscriptions" name="cmd">
                                    <input type="hidden" value="<?php echo set_value("donate_amount"); ?>" name="a3"> <!-- PRICE -->
                                    <input type="hidden" value="<?php echo $TMP_explode_donation_freq[1]; ?>" name="p3"> <!-- DURATION OF t3 -->
                                    <input type="hidden" value="<?php echo $TMP_explode_donation_freq[0]; ?>" name="t3"> <!-- D, W, M, Y -->
                                    <input type="hidden" value="<?php echo set_value("donation_occ"); ?>" name="srt"> <!-- NO. OF OCCURANCE -->

                                    <input type="hidden" value="1" name="src"> <!-- 1, SUBSCRIBE ----- 0, UN-SUBSCRIBE -->
                                    <input type="hidden" value="1" name="sra"> <!-- RE-ATTEMPT if FAILS -->
                                <?php } elseif ($_POST["donation_mode"] == "onetimepay") { ?>
                                    <input type="hidden" value="_xclick" name="cmd">
                                    <input type="hidden" value="<?php echo set_value("donating_amount"); ?>" name="amount">
                                <?php }  else { ?>
                                    <input type="hidden" value="_xclick" name="cmd">
                                    <input type="hidden" value="<?php echo set_value("donate_amount"); ?>" name="amount">
                                <?php } ?>
                                <input type="hidden" value="2" name="rm">
                                <input type="hidden" value="1" name="no_shipping">
                                <input type="hidden" value="1" name="no_note">
                                <input type="hidden" value="US" name="lc">

                                <?php if ($_POST["donation_mode"] == "onetimepay") { ?>
                                    <input type="hidden" value="tb_give_honor_someone|id|<?php echo $donation_id; ?>" name="custom">
                                <?php } else { ?>
                                    <input type="hidden" value="tb_donation_form|id|<?php echo $donation_id; ?>" name="custom">
                                <?php } ?>
                                <?php if ($_POST["donation_mode"] == "onetimepay") { ?>
                                    <input type="hidden" value="<?php echo site_url(uri_string() . "/payment_success_honor"); ?>" name="return">
                                    <input type="hidden" value="<?php echo site_url(uri_string() . "/payment_notify_honor"); ?>" name="notify_url">
                                <?php } else { ?>
                                    <input type="hidden" value="<?php echo site_url(uri_string() . "/payment_success"); ?>" name="return">
                                    <input type="hidden" value="<?php echo site_url(uri_string() . "/payment_notify"); ?>" name="notify_url">
                                <?php } ?>
                                <input type="hidden" value="<?php echo site_url(uri_string() . "/payment_cancel"); ?>" name="cancel_return">
                                <?php if ($_POST["donation_mode"] == "onetimepay") { ?>
                                    <input type="hidden" value="<?php echo set_value("name", $from_name); ?>" name="first_name">
                                    <input type="hidden" value="" name="last_name">
                                    <input type="hidden" value="<?php echo $_POST['donation_projects']; ?>" name="item_name">
                                <?php } else { ?>
                                    <input type="hidden" value="<?php echo DropdownHelper::donation_projects_dropdown(FALSE, set_value("donation_projects")); ?>" name="item_name">
                                    <input type="hidden" value="<?php echo set_value("first_name", $from_first_name); ?>" name="first_name">
                                    <input type="hidden" value="<?php echo set_value("last_name", $from_last_name); ?>" name="last_name">
                                <?php } ?>
                                <input type="hidden" value="<?php echo set_value("address"); ?>" name="address1">
                                <input type="hidden" value="" name="address2">
                                <input type="hidden" value="<?php echo $DONATEFORM['city']; ?>" name="city">
                                <input type="hidden" value="<?php echo $DONATEFORM['country']; ?>" name="country">
                                <input type="hidden" value="<?php echo $DONATEFORM['state']; ?>" name="state">
                                <input type="hidden" value="<?php echo $DONATEFORM['zip']; ?>" name="zip">

                            </form>

                            <script>
                                $("form[name='form_donateform']").submit();
                            </script>
                        <?php
                        } 
                        else {
                            $attributes             = array(
                                "method"            => "post",
                                "name"              => "form_donate",
                                "enctype"           => "multipart/form-data",
                                "onsubmit"          => "submit_with_hash('form_donate', 'hash_donate_form',true)",
                                "novalidate"        => "novalidate"
                            );

                            echo form_open(site_url(uri_string()), $attributes);
                            ?>
                            <!-- Start from here -->
                                <div class="donate-form-container">
                                    <div class="form-section step-cause activetab">
                                        <h3 class="step-title ntab_1">
                                            <span>01</span> Select Cause
                                        </h3>
                                        <div class="fields-contianer nfieldset_1">
                                            <?php 
                                                $donProjVal                                     = "";
                                                $valueCause                                     = "";
                                                if(trim(set_value("donation_projects")) != ""){
                                                    $donProjVal                                 = set_value("donation_projects");
                                                    $valueCause = DropdownHelper::donation_projects_dropdown(false, "$donProjVal", false, true, false, $content_languages);
                                                } elseif (trim($_GET['donation_campaign'])){
                                                    $donProjVal                                 = $_GET['donation_campaign'];
                                                }
                                                ?>
                                            
                                            <input type="hidden" id="donation_projects" name="donation_projects" class="" value="<?php echo $donProjVal ?>" >
                                            <?php echo form_error("donation_projects"); ?>
                                            <?php
                                            echo PP_Donate_Form::form_projects_accordion('donation_projects', DropdownHelper::donation_projects_dropdown(false, '', false, true, false, $content_languages), $donProjVal, "class='form-control donationPclass" . set_class("donation_projects") . "'", $this);
                                            // echo PP_Donate_Form::form_dropdown_custom('donation_projects', DropdownHelper::donation_projects_dropdown(false, '', false, true, false, $content_languages), $donProjVal, "class='form-control donationPclass" . set_class("donation_projects") . "'", $this);
                                            ?>

                                        </div>
                                    </div>
                                    <div class="form-section step-amount ">
                                        <h3 class="step-title ntab_2">
                                            <span>02</span> Select Amount
                                        </h3>
                                        <div class="fields-contianer nfieldset_2">
                                            
                                            <div class="donationPclass container-radio_waper">
                                                <?php
                                                foreach (DropdownHelper::donationmode_dropdown_2(TRUE) as $dm_key => $dm_value) {  ?>
                                                    <label class="fl_lft m_rite10 m_bottom5 container-radio <?php //echo $dm_key; ?>" <?php //echo $cus_style;?>>
                                                        <?php
                                                        $checked_mode = (set_value("donation_mode") == $dm_key ) ? TRUE : (($dm_key == 'onetime') ? TRUE : FALSE);
                                                        echo form_radio(array('name' => 'donation_mode', 'value' => $dm_key, 'checked' => $checked_mode, 'id' => $dm_key, 'onclick' => "hideElement('input[name=\'donation_mode\']:checked', '.hideElement', 'onetime', true)"));
                                                        echo $dm_value;
                                                        ?>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                <?php }
                                                echo form_error("donation_mode");?>
                                            </div>
                                            <div style="display:none" class="field_row w_100 p_right10 customclass donation_freq">
                                                <span class="projectDspan"><?php echo lang_line('label_donation_frequency'); ?></span>
                                                <?php
                                                echo form_dropdown('donation_freq', DropdownHelper::donationfrequency_dropdown(FALSE), set_value("donation_freq"), "class='form-control donationPclass" . set_class("donation_freq") . "'");
                                                echo form_error("donation_freq");
                                                ?>
                                            </div>
                                            <!--   <div class="field_row w_50 p_left10 hideElement"  style="display:none;">
                                                    <?php
                                                    $specdata       = array(
                                                    "name"          => "donation_occ",
                                                    "id"            => "donation_occ",
                                                    "value"         => set_value("donation_occ"),
                                                    "class"         => set_class("donation_occ"),
                                                    "placeholder"   => "Donate Occurrences *"
                                                    );

                                                    echo form_input($specdata);
                                                    echo form_error("donation_occ");
                                                    ?>
                                                    </div> -->
                                                <!--     <div class="field_row w_50 p_right10">
                                                    <?php
                                                    echo form_dropdown('donate_type', DropdownHelper::donatetype_dropdown(FALSE), set_value("donate_type"), "onchange='donationType()' id='donationid' ", "class='form-control" . set_class("donate_type") . "'");
                                                    echo form_error("donate_type");
                                                    ?>
                                                </div>
                                            -->
                                            <!--   <div class="field_row w_50 p_left10">
                                                    <?php
                                                    $specdata       = array(
                                                        "name"          => "donate_amount",
                                                        "id"            => "donate_amount",
                                                        "value"         => set_value("donate_amount"),
                                                        "class"         => set_class("donate_amount"),
                                                        "placeholder"   => "Donate Amount *"
                                                    );

                                                        echo form_input($specdata);
                                                        echo form_error("donate_amount");
                                                        ?>
                                                    </div>


                                                <div class="field_row w_100">
                                                    <?php
                                                    $specdata       = array(
                                                        "name"          => "comments",
                                                        "id"            => "comments",
                                                        "value"         => set_value("comments"),
                                                        "class"         => set_class("comments"),
                                                        "placeholder"   => "Comments *"
                                                    );

                                                    echo form_textarea($specdata);
                                                    echo form_error("comments");
                                                    ?>
                                                </div>

                                            -->
                                            <!--     <div class="field_row w_50 p_left10" style="display:none;">
                                                        <?php
                                                        $specdata       = array(
                                                            "name"          => "security_code",
                                                            "id"            => "security_code",
                                                            "value"         => set_value("security_code"),
                                                            "class"         => set_class("security_code"),
                                                            "style"         => "margin-bottom:10px;",
                                                            "placeholder"   => "Security Code *"
                                                        );

                                                        echo form_input($specdata);
                                                        echo form_error("security_code");

                                                        $TMP_arr        = array(
                                                            "img_width"         => 400,
                                                            "img_height"        => 60
                                                        );
                                                        echo captchacode($TMP_arr);
                                                        ?>
                                                    </div> -->    
                                            <?php
                                            $specdata       = array(
                                                "name"          => "donate_amount",
                                                "type"          => "hidden",
                                                "id"            => "donate_amount",
                                                "value"         => set_value("donate_amount", "100"),
                                            );
        
                                            echo form_input($specdata);
                                            echo form_error("donate_amount");
                                            ?> 
                                           <!-- Select Donation Amount -->
                                           <div class="check_box_style">
                                               <label> Select Donation Amount</label>
                                                 <ul class="num_box_style">
                                                    <?php
                                                        $_array_pre_amount = array('100','200','500');
                                                        $_count = 0;
                                                        foreach($_array_pre_amount as $amt){
                                                            
                                                            $active_class       = $checked = FALSE;
                                                            $selected_val       = set_value("donate_amount") == $amt ? TRUE : FALSE;    
                                                            
                                                            if( $selected_val ){
                                                                $active_class = TRUE;
                                                                $checked = TRUE;
                                                            }elseif($_count == 0 && set_value("donate_amount") == NULL){
                                                                $active_class = TRUE;
                                                                $checked = TRUE;
                                                            }
                                                            
                                                            ?>
                                                            <li <?php echo ($active_class == TRUE) ? "class='active_checked_box'" :""; ?>>
                                                                <input <?php echo ($checked == TRUE) ? 'checked' : ''; ?> name="pre_amount" type="radio" class="pre_amount yi-form-element" value="<?php echo $amt; ?>">
                                                                <label class="label_text">$<?php echo $amt; ?></label>
                                                            </li>
                                                            <?php
                                                            $_count++;
                                                        }
                                                    ?> 
                                                </ul>
                                            </div>
                                            
                                            <!-- Select Donation Amount  End-->
                                        <div class="label_warp">
                                            <label>Custom Donation</label>
                                         </div>
                                            <div class="input-group flex_checkout">

                                                <?php
                                                $specdata       = array(
                                                    "name"          => "custom_amount",
                                                    "id"            => "custom_amount",
                                                    "value"         => set_value("custom_amount"),
                                                    "class"         => "donationPclass form-control",
                                                    "placeholder"   => "$1",
                                                );
            
                                                echo form_input($specdata);
                                                echo form_error("custom_amount");
                                                ?> 
                                                <a href="javascript:;" id="nexttab" class="input-group-addon">Checkout</a>
                                                <!-- <span class="input-group-addon active-paypal-code fff" id="basic-addon2"><?php echo $active_payPal['code'] ?></span> -->
                                                <input type="hidden" name="active_paypal" class="active-paypal-email" value="<?php echo $active_payPal['paypal_email'] ?>" >
                                                <input type="hidden" name="currency_code" class="active-input-paypal-code" value="<?php echo $active_payPal['code'] ?>" >
                                                <input type="hidden" name="belongs_country" class="active-belongs-country" value="<?php echo $active_payPal['id'] ?>" >
                                            </div>
                                            <div id="sehm_o_marjaa" class="flALlLeft customclass less-class" style="display: none;">
                                                <div class="field_row w_100 p_right10 custom_style1 customclass" align="center" >
                                                    <div class="donationPclass">
                                                        <?php 
                                                        
                                                        foreach ($DONATEFORM['sehm_childs'] as $kh_key => $kh_value) { ?>
                                                            <label class="fl_lft m_rite10 m_bottom5">
                                                                <?php
                                                                echo form_radio(array('name' => 'sehm', 'value' => $kh_key, 'checked' => ($kh_key == 0)?TRUE: FALSE, 'id' => 'khums_'.$kh_key));
                                                                echo $kh_value;
                                                                ?>
                                                            </label>
                                                        <?php
                                                    }
            
                                                    echo form_error("sehm");
                                                    ?>
                                                    </div>
                                                </div>
                                                
                                                <div class="field_row w_100 " style="display: none;">
                                                    <span class="projectDspan "><?php echo lang_line('label_marjaa_taqleed'); ?></span>
                                                    <?php
                                                    echo form_dropdown('marjaa_taqleed', DropdownHelper::marjaa_taqleed_dropdown(), set_value("marjaa_taqleed"), "class='form-control donationPclass" . set_class("marjaa_taqleed") . "'");
                                                    echo form_error("marjaa_taqleed");
                                                    ?>
                                                </div>
                                            </div>
                                            <div id="is_syed" class="flALlLeft customclass less-class" style="display: none;">
                                                <div class="field_row w_100 p_right10 custom_style1 customclass" align="center" >
                                                    <div class="donationPclass">
                                                        <?php 
                                                        foreach ($DONATEFORM['syed_childs'] as $s_key => $s_value) { ?>
                                                            <label class="fl_lft m_rite10 m_bottom5">
                                                                <?php
                                                                echo form_radio(array('name' => 'is_syed', 'value' => $s_key, 'checked' => ($s_key == 0)?TRUE: FALSE, 'id' => 'syed_'.$s_key));
                                                                echo $s_value;
                                                                ?>
                                                            </label>
                                                        <?php
                                                    }
            
                                                    echo form_error("is_syed");
                                                    ?>
                                                    </div>
                                                </div>
                                                
                                            </div>   
                                        </div>                                        
                                    </div>
                                    <div class="form-section step-checkout">
                                        <h3 class="step-title ntab_3">
                                            <span>03</span> Single Checkout
                                        </h3>
                                        <div class="fields-contianer nfieldset_3">
                                        
                                            <?php if (isset($card_error)) { ?>
                                                <p class="form_error col-sm-12 no-padding">
                                                    <?php echo $card_error; ?>
                                                </p>
                                            <?php } ?>
                                         

                                            <!--     
                                                <div class="field_row w_50 p_right10">
                                                    <?php
                                                    $specdata       = array(
                                                        "name"          => "first_name",
                                                        "id"            => "first_name",
                                                        "value"         => set_value("first_name", $DONATEFORM['first_name']),
                                                        "class"         => set_class("first_name"),
                                                        "placeholder"   => "First Name *"
                                                    );

                                                    echo form_input($specdata);
                                                    echo form_error("first_name");
                                                    ?>
                                                </div>



                                                <div class="field_row w_50 p_left10">
                                                    <?php
                                                    $specdata       = array(
                                                        "name"          => "last_name",
                                                        "id"            => "last_name",
                                                        "value"         => set_value("last_name", $DONATEFORM['last_name']),
                                                        "class"         => set_class("last_name"),
                                                        "placeholder"   => "Last Name *"
                                                    );

                                                    echo form_input($specdata);
                                                    echo form_error("last_name");
                                                    ?>
                                                </div>



                                                <div class="field_row w_50 p_right10">
                                                    <?php
                                                    $specdata       = array(
                                                        "name"          => "email",
                                                        "id"            => "email",
                                                        "value"         => set_value("email", $DONATEFORM['email']),
                                                        "class"         => set_class("email"),
                                                        "placeholder"   => "Email *"
                                                    );

                                                    echo form_input($specdata);
                                                    echo form_error("email");
                                                    ?>
                                                </div>


                                                <div class="field_row w_50 p_left10">
                                                    <?php
                                                    $specdata       = array(
                                                        "name"          => "address",
                                                        "id"            => "address",
                                                        "value"         => set_value("address", $DONATEFORM['address']),
                                                        "class"         => set_class("address"),
                                                        "placeholder"   => "Address"
                                                    );

                                                    echo form_textarea($specdata);
                                                    echo form_error("address");
                                                ?>
                                            </div>
                                            -->
                                            <!--  <h3 class="h3Style1"></h3>
                                                <h3 class="h3Style3">Donation Information</h3>
                                            -->   

                                            <div class="flALlLeft customclass less-class">
                                                <div class="personal-information-heading"><h4>Personal Information</h4></div>
                                                <div class="personal-information-section-1">
                                                    <div class="col-sm-6">
                                                        <label>Name</lable>
                                                        <input id="card-number" name="donate_name" placeholder="<?php echo lang_line('text_name'); ?> *" class="form-control" value="<?php echo set_value('donate_name', $from_name) ?>" class="form-control input-md wiDthDef" type="text">
                                                        <?php echo form_error('donate_name'); ?>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Email <small>(Your tax receipt will be emailed to this email ID)</small></lable>
                                                        <input id="email" name="donate_email" placeholder="<?php echo lang_line('text_email'); ?> *" class="form-control" value="<?php echo set_value('donate_email', $email_address) ?>" class="form-control input-md" type="text">
                                                        <?php echo form_error('donate_email'); ?>
                                                    </div>
                                                </div>
                                                <div class="personal-information-section-2">
                                                    <div class="col-sm-6">
                                                        <label>Address</lable>
                                                        <?php  $requied_add = '';
                                                            if( site_url() == "https://imicanada.org/"){
                                                                $requied_add = '*';
                                                            }
                                                        ?>
                                                        <input id="address" name="donate_address" placeholder="Address <?php echo $requied_add; ?>" class="form-control" value="<?php echo set_value('donate_address', $donate_address) ?>" class="form-control input-md" type="text">
                                                        <?php echo form_error('donate_address'); ?>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Country</lable>
                                                        <?php echo form_dropdown('home_country', DropdownHelper::country_dropdown(), set_value("home_country", $home_country), 'class="form-control"') ?>
                                                        <?php echo form_error('home_country'); ?>
                                                    </div>
                                                </div>
                                                <div class="personal-information-section-3">
                                                    <div class="col-sm-4">
                                                        <label data-selected="<?php echo isset( $_POST['home_state'] ) ? $_POST['home_state'] : ""; ?>">State</lable>
                                                        <?php echo form_dropdown('home_state',[""=>"Select State"], set_value("home_state", $home_state), 'class="form-control"') ?>
                                                        <?php echo form_error('home_state'); ?>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label data-selected="<?php echo isset( $_POST['home_city'] ) ? $_POST['home_city'] : ""; ?>">City</lable>
                                                        <input id="city" name="home_city" placeholder="City" class="form-control" value="<?php echo set_value('home_city', $home_city) ?>" class="form-control input-md" type="text">
                                                        <?php echo form_error('home_city'); ?>
                                                    </div>
                                                    <!-- <div class="col-sm-4">
                                                        <label data-selected="<?php // echo isset( $_POST['home_city'] ) ? $_POST['home_city'] : ""; ?>">City</lable>
                                                        <?php // echo form_dropdown('home_city',[""=>"Select City"], set_value("home_city", $home_city), 'class="form-control"') ?>
                                                        <?php // echo form_error('home_city'); ?>
                                                    </div> -->
                                                    <div class="col-sm-4">
                                                        <label data-selected="<?php echo isset( $_POST['home_zipcode'] ) ? $_POST['home_zipcode'] : ""; ?>">Zip</lable>
                                                        <input id="zip" name="home_zipcode" placeholder="Zip" class="form-control" value="<?php echo set_value('home_zipcode', $home_zipcode) ?>" class="form-control input-md" type="text">
                                                        <?php echo form_error('home_zipcode'); ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="field_row w_100 p_right10 custom-div" style="display: inline-block;">
                                                <span class="projectDspan"><input type="checkbox" name="isEmpMatch" id="isEmpMatch" value="1" /><?php echo lang_line('label_employer_match'); ?></span>
                                                <div class="col-sm-12 no-padding m_top20 m_bottom10 custom_style1 container-radio_waper">
                                                    <!-- <label class="fl_lft m_bottom5 m_rite10 container-radio nlabel-cc" <?php echo $_hide_if_can;?>
                                                        <?php /*if(!isset($_GET['testing'])){ echo 'style="display:none;"';}*/ ?>>
                                                        <?php
                                                      
                                                        // $checked = isset($_POST['paymenttype']) && $_POST['paymenttype'] == "card" ? true : false;
                                                        $attr = array('name' => 'paymenttype', 'value' => 'card', 'checked' => TRUE, 'id' => 'card');
                                                        if($active_payPal['id'] == 3)
                                                        {
                                                            $attr['disabled'] = "disabled";
                                                        }
                                                        echo form_radio($attr);
                                                        echo lang_line('label_pay_card');
                                                        ?>
                                                        <span class="checkmark"></span>
                                                    </label> -->
                                                    <label class="fl_lft m_bottom5  container-radio">
                                                        <?php
                                                          $checked = true;
                                                        //   $checked = isset($_POST['paymenttype']) && $_POST['paymenttype'] == "paypal" ? true : false;
                                                        echo form_radio(array('name' => 'paymenttype', 'value' => 'paypal', 'checked' => $checked, 'id' => 'paypal'));
                                                        echo lang_line('label_pay_paypal');
                                                        ?>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                    <?php $_hide_if_can = ($active_payPal['id'] == 3) ? "style='visibility:hidden;'" :""; ?>
                                                    
                                                </div>
                                                <!-- <div class="card-details col-sm-12 no-padding m_bottom10" style="<?php echo isset($_POST['paymenttype']) && $_POST['paymenttype'] == "paypal" ? 'display:none;' : 'display:block;'; ?>">
                                                    <div class="col-sm-12 no-padding scal-bttom">
                                                        <div class="col-sm-12 no-padding m_bottom10">
                                                            <div class="col-sm-6 paddzERo">
                                                                <?php
                                                                $card_name       = array(
                                                                    "name"          => "card_name",
                                                                    "id"            => "card_name",
                                                                    "value"         => set_value("card_name"),
                                                                    "class"         => "donationPclass",
                                                                    "placeholder"   => lang_line('label_card_holder') . " *"
                                                                );

                                                                echo form_input($card_name);

                                                                echo form_error('card_name');
                                                                ?>
                                                            </div>
                                                            <div class="col-sm-6 paddRzERo lang-dir-<?php echo $lang['direction']; ?>">
                                                                <?php
                                                                $card_number       = array(
                                                                    "name"          => "card_number",
                                                                    "id"            => "card_number",
                                                                    "value"         => set_value("card_number"),
                                                                    "class"         => "donationPclass",
                                                                    "placeholder"   => lang_line('label_card_no') . " *"
                                                                );

                                                                echo form_input($card_number);

                                                                echo form_error('card_number');
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 no-padding m_bottom10">
                                                            <div class="col-sm-6 paddzERo">
                                                                <?php
                                                                $card_expiry       = array(
                                                                    "name"          => "card_expiry",
                                                                    "id"            => "card_expiry",
                                                                    "value"         => set_value("card_expiry"),
                                                                    "class"         => "donationPclass",
                                                                    "placeholder"   => lang_line('label_card_expiry') . " *"
                                                                );

                                                                echo form_input($card_expiry);

                                                                echo form_error('card_expiry');
                                                                ?>
                                                            </div>
                                                            <div class="col-sm-6 paddRzERo">
                                                                <?php
                                                                $card_cvv       = array(
                                                                    "name"          => "card_cvv",
                                                                    "id"            => "card_cvv",
                                                                    "value"         => set_value("card_cvv"),
                                                                    "class"         => "donationPclass",
                                                                    "placeholder"   => lang_line('label_card_cvv') . " *",
                                                                    "pattern"       => "\d*",
                                                                    "maxlength"     => "4"
                                                                );

                                                                echo form_input($card_cvv);

                                                                echo form_error('card_cvv');
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <div class="isEmpMatch <?php if (form_error("donation_empnames") || form_error('donate_empemail') || isset($_POST['isEmpMatch']) && $_POST['isEmpMatch'] == '1') {
                                                                            echo 'has_error';
                                                                        } ?>"  style="display: none">
                                                    <div class="EmpName">
                                                    <a href="javascript:;" class="notinlist" data-showlist="<?php echo lang_line('label_show_list'); ?>" data-notinlist="<?php echo lang_line('label_not_in_list'); ?>"><?php echo lang_line('label_not_in_list'); ?></a>
                                                        <?php
                                                        echo form_dropdown('donation_empnames', DropdownHelper::donation_empnames_dropdown(FALSE), set_value("donation_empnames"), "class='form-control donationPclass" . set_class("donation_empnames") . "'");

                                                        $empname       = array(
                                                            "name"          => "donation_empnames",
                                                            "id"            => "donation_empnames",
                                                            "value"         => set_value("donation_empnames"),
                                                            "class"         => "donationPclass",
                                                            "style"          => 'display:none;'
                                                        );

                                                        echo form_input($empname);
                                                        ?>

                                                    </div>
                                                    <?php
                                                    echo form_error("donation_empnames");

                                                    $empemail       = array(
                                                        "name"          => "donate_empemail",
                                                        "id"            => "donate_empemail",
                                                        "value"         => set_value("donate_empemail"),
                                                        "class"         => "donationPclass",
                                                        "placeholder"   => "employee@mail.com"
                                                    );

                                                    echo form_input($empemail);

                                                    echo form_error('donate_empemail');
                                                    ?>

                                                </div>
                                            </div>

                                            <div class="field_row w_100 p_right10 camp-related" style="display: none;">
                                                <span class="projectDspan"><input type="checkbox" name="hideIdentity" id="hideIdentity" value="1" <?php echo isset($_POST['hideIdentity']) ? "checked" : ""; ?> /><?php echo lang_line('label_hide_identity'); ?></span>
                                            </div>

                                            <div class="col-md-12 no-padding m_bottom10 camp-related" style="display: none;">
                                                <textarea id="givenowcomm" class="inputDesc fullLeng" name="comment" placeholder="<?php echo lang_line('label_add_comments'); ?>"><?php echo isset($_POST['comment']) ? $_POST['comment'] : ""; ?></textarea>
                                                <?php echo form_error('comment'); ?>
                                            </div>
                                            <input id="hiderecap" type="hidden" value="" name="custom_grecap">
                                            <div class="fl_lft w_100 text-center"><?php if(isset($_POST['donate_name']) && trim($_POST['donate_name'])){
                                                echo form_error("custom_grecap");
                                            } ?>
                                            </div>
                                            <div align="center" class="hundred sbmt-btn">
                                                <div class="donate_text_details">
                                                    
                                                    <?php
                                                    
                                                        $_valCause      = (is_array($valueCause) && isset($valueCause[0])) ? $valueCause[0] : "";
                                                        $_valAmount     = "100";

                                                        if(set_value("custom_amount") != NULL && set_value("custom_amount") != ""){
                                                            $_valAmount = set_value("custom_amount");
                                                        }
                                                        elseif(set_value("donate_amount") != NULL && set_value("donate_amount") != ""){
                                                            $_valAmount = set_value("donate_amount");
                                                        }
                                                       
                                                        $_valDonationType   = "Single Donation";
                                                        if(set_value("donation_mode") != NULL && set_value("donation_mode") != ""){
                                                            $_valDonationType = DropdownHelper::donationmode_dropdown_2(TRUE,set_value('donation_mode'));
                                                        }
                                                        ?>
                                                    <span>Cause:         <strong class="donte_name" id="review-cause"> <?php echo $_valCause; ?> </strong></span>
                                                    <span>Donation:      <b id="curr_symbol">$</b><strong class="donte_name" id="review-amount"><?php echo $_valAmount; ?> </strong></span>
                                                    <span>Donation Type: <strong class="donte_name" id="review-type"> <?php echo $_valDonationType; ?></strong></span>
                                                </div>
                                                <button id="givenow" class="submit_btn field_row" name="btn_donate_form_new" type="submit" onclick="addItem('givenow'); return false;" value="Donate"><?php echo lang_line('button_donate'); ?></button>
                                                <!-- <input id="givenow" class="submit_btn field_row" name="btn_donate_form_new" type="submit" onclick="addItem('givenow'); return false;" value="Donate" /> -->
                                            </div>
                                            <div class="question">
                                                <?php 

                                                    if (site_url() == 'https://imicanada.org/') {
                                                        ?>
                                                            <p>If you have any questions, please feel free to write to:  <a href="mailto:imamiacanada@gmail.com">imamiacanada@gmail.com</a></p>
                                                        <?php
                                                    }else{
                                                        ?>
                                                            <p>If you have any questions, please feel free to write to:  <a href="mailto:imifinance786@gmail.com">imifinance786@gmail.com</a></p>
                                                        <?php
                                                    }

                                                 ?>
                                        
                                            </div>                                        
                                        </div>
                                    </div>
                                    <div class="form-section step-completed">
                                        <h3 class="step-title ntab_4">
                                            <span>04</span> Completed
                                        </h3>
                                        <div class="fields-contianer nfieldset_4">
                                            <p>Donation complete!</p>
                                        </div>
                                    </div>
                                </div>    
                            <?php echo form_close(); ?>
                            <?php
                        }
                    } 
                    else {
                        $data["_messageBundle"]             = $DONATEFORM['_messageBundle_not_a_member'];
                        $this->load->view('frontend/template/_show_messages.php', $data);
                    }
                } 
                else {
                    $data["_messageBundle"]                 = $DONATEFORM['_messageBundle_please_login'];
                    $this->load->view('frontend/template/_show_messages.php', $data);
                } ?>

                <?php if (form_error('honorto') || form_error('recipientEmail') || form_error('fromname')) {
                    ?>
                    <script>
                        $("#emailForm").modal('toggle');
                    </script>
                <?php } ?>
            </div>
        </div>
    </div>
    <div id="onWillPopup" class="toggle-view-div requestwill donate-content-section" >
        <div class="donation-allow-other-country">
            <ul class="country-listing-donation">
                <?php foreach($chapter_countries as $chapter_country):
                        if(site_url() == "https://imamiamedics.com/" && $chapter_country['id'] == '3'):
                            continue;
                        elseif(site_url() == "https://imicanada.org/" && $chapter_country['id'] == '2'):
                            continue;
                        endif;
                    ?> 
                    <li class="giving-to-imi <?php echo $locationID == $chapter_country['country_id'] ? 'active-tab-donation' : '' ?>" data-currency-code="<?php echo $chapter_country['code']?>" data-country-id="<?php echo $chapter_country['country_id']?>" data-paypal-email="<?php echo $chapter_country['paypal_email']?>" data-belongs-country="<?php echo $chapter_country['id'] ?>" ><div class='cust-flag-div'><img class="flag-image" src="<?php echo site_url('/assets/frontend/images/flags')."/".strtolower($chapter_country['iso_code_2']).".png" ?>"></div><small>Giving to </small> IMI <?php echo $chapter_country['country_title'] == "International" ? "Global" :  $chapter_country['country_title'] ?></li>
                <?php endforeach;?>
            </ul>
        </div>
        <div class="hundred form_sec">
            <form method="post" action="" novalidate>
                <div class="inputs">
                    <div class="errorHonor err error-exist"></div>
                    <div class="donateHonorslide1 sameheight2">
                        <div class="iho-header">
                            <h2 class="h40 text-center"><?php echo lang_line('label_dedication_gift'); ?></h2>
                        </div>
                        <div class="payment-information">
                            <div class="payment-information-heading"><h4>Payment Information</h4></div>
                            <div class="col-sm-12 no-padding m_bottom10">
                                <label><?php echo lang_line('label_amount_to_donate'); ?></label>
                                <div class="input-group flex_checkout">
                                    <input id="donating_amount" name="donating_amount" placeholder="<?php echo lang_line('label_donate_amount'); ?> * " class="form-control" value="<?php echo set_value('donating_amount', '100'); ?>" class="form-control input-md" type="text">
                                    <span class="input-group-addon active-paypal-code sss" id="basic-addon2"><?php echo $active_payPal['code'] ?></span>
                                    <input type="hidden" name="active_paypal" class="active-paypal-email" value="<?php echo $active_payPal['paypal_email'] ?>" >
                                    <input type="hidden" name="currency_code" class="active-input-paypal-code" value="<?php echo $active_payPal['code'] ?>" >
                                    <input type="hidden" name="belongs_country" class="active-belongs-country" value="<?php echo $active_payPal['id'] ?>" >
                                </div>
                                <?php echo form_error('donating_amount'); ?>
                            </div>
                            <div class="col-sm-12 no-padding m_bottom10 custom_style1">
                                <label class="fl_lft m_bottom5 m_rite10">
                                    <?php
                                    echo form_radio(array('name' => 'honor_paymenttype', 'value' => 'paypal', 'checked' => TRUE, 'id' => 'honor-paypal'));
                                    echo lang_line('label_pay_paypal');
                                    ?>
                                </label>
                                <!-- <label class="fl_lft m_bottom5 m_rite10" <?php /*if(!isset($_GET['testing'])){ echo 'style="display:none;"';}*/?>>
                                    <?php
                                    $checked = isset($_POST['honor_paymenttype']) && $_POST['honor_paymenttype'] == "card" ? true : false;
                                    echo form_radio(array('name' => 'honor_paymenttype', 'value' => 'card', 'checked' => $checked, 'id' => 'honor-paymenttype'));
                                    echo lang_line('label_pay_card');
                                    ?>
                                </label> -->
                            </div>
                            <!-- <div class="honor-card-details col-sm-12 no-padding  " style="<?php echo isset($_POST['honor_paymenttype']) && $_POST['honor_paymenttype'] == "card" ? 'display:block;' : 'display:none;'; ?>">
                                <div class="col-sm-12 no-padding m_bottom10 scal-div">
                                    <div class="col-sm-6 paddzERo">
                                        <?php
                                        $honor_card_name       = array(
                                            "name"          => "honor_card_name",
                                            "id"            => "honor_card_name",
                                            "value"         => set_value("honor_card_name"),
                                            "class"         => "donationPclass",
                                            "placeholder"   => lang_line('label_card_holder')
                                        );
    
                                        echo form_input($honor_card_name);
    
                                        echo form_error('honor_card_name');
                                        ?>
                                    </div>
                                    <div class="col-sm-6 paddRzERo">
                                        <?php
                                        $honor_card_number       = array(
                                            "name"          => "honor_card_number",
                                            "id"            => "honor_card_number",
                                            "value"         => set_value("honor_card_number"),
                                            "class"         => "donationPclass",
                                            "placeholder"   => lang_line('label_card_no')
                                        );
    
                                        echo form_input($honor_card_number);
    
                                        echo form_error('honor_card_number');
                                        ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 no-padding m_bottom10 scal-div">
                                    <div class="col-sm-6 paddzERo">
                                        <?php
                                        $honor_card_expiry       = array(
                                            "name"          => "honor_card_expiry",
                                            "id"            => "honor_card_expiry",
                                            "value"         => set_value("honor_card_expiry"),
                                            "class"         => "donationPclass",
                                            "placeholder"   => lang_line('label_card_expiry')
                                        );
    
                                        echo form_input($honor_card_expiry);
    
                                        echo form_error('honor_card_expiry');
                                        ?>
                                    </div>
                                    <div class="col-sm-6 paddRzERo">
                                        <?php
                                        $honor_card_cvv       = array(
                                            "name"          => "honor_card_cvv",
                                            "id"            => "honor_card_cvv",
                                            "value"         => set_value("honor_card_cvv"),
                                            "class"         => "donationPclass",
                                            "placeholder"   => lang_line('label_card_cvv'),
                                            "pattern"       => "\d*",
                                            "maxlength"     => "4"
                                        );
    
                                        echo form_input($honor_card_cvv);
    
                                        echo form_error('honor_card_cvv');
                                        ?>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="personal-information">
                              <div class="personal-information-heading"><h4>Personal Information</h4></div>
                            <div class="col-md-12 no-padding m_bottom10 scal-div">
                                <div class="col-md-6 paddzERo">
                                 <label><?php echo lang_line('label_honoree_name'); ?></lable>   
                                    <input id="honorofname" name="honorto" type="text" placeholder="<?php echo lang_line('label_honoree_name'); ?> *" value="<?php echo set_value('honorto'); ?>" />
                                    <div class="honorerror err"><?php echo form_error('honorto'); ?></div>
                                </div>
                                <div class="col-md-6 paddRzERo">
                                <label><?php echo lang_line('label_honoree_email'); ?></lable>   
                                    <input type="email" id="honorEmail" name="honoreeEmail" placeholder="<?php echo lang_line('label_honoree_email'); ?> *" value="<?php echo set_value('honoreeEmail'); ?>">
                                    <div class="honoremailerror err"><?php echo form_error('honoreeEmail'); ?></div>
                                </div>
                            </div>
                            <div class="col-md-12 no-padding m_bottom10">
                                <input type="checkbox" id="sendTo" name="sendTo" value="recipient" <?php echo isset($_POST['sendTo']) && $_POST['sendTo'] == 'recipient' ? 'checked="checked"' : ''; ?> onclick="showhidReciepent(this)" />
                                <?php echo lang_line('label_send_to_else'); ?>
                            </div>
                            <div class="col-md-12 m_bottom10 no-padding showif_someone_else " style="<?php echo isset($_POST['sendTo']) && $_POST['sendTo'] == 'recipient' ? '' : 'display:none;'; ?>">
                                <div class="col-md-12 m_bottom10 no-padding scal-div">
                                    <div class="col-md-6 paddzERo">
                                        <label><?php echo lang_line('label_receipeint_name'); ?></lable>   
                                        <input type="text" id="recipientName" name="recipientName" placeholder="<?php echo lang_line('label_receipeint_name'); ?> *" value="<?php echo set_value('recipientName'); ?>">
                                        <div class="recipientnameerror err"><?php echo form_error('recipientName'); ?></div>
                                    </div>

                                    <div class="col-md-6 paddRzERo">
                                        <label><?php echo lang_line('label_receipeint_email'); ?></lable>   
                                        <input type="email" data-parsley-errors-container=".iho-email-errors" name="recipientEmail" placeholder="<?php echo lang_line('label_receipeint_email'); ?> *" value="<?php echo set_value('recipientEmail'); ?>">
                                        <div class="recipintemailerror err"><?php echo form_error('recipientEmail'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 no-padding m_bottom10 hwrap">
                                <label>From Name</lable>
                                <input type="text" name="fromname" id="fromname" placeholder="<?php echo lang_line('label_from_name'); ?> *" value="<?php echo set_value('fromname', $from_name); ?>" />
                                <div class="honorfromerror err"><?php echo form_error('fromname'); ?></div>
                            </div>
                            <div class="col-md-12 no-padding m_bottom10 ">
                                <label>Message</lable>
                                <textarea id="honormessage" class="inputDesc fullLeng" name="message" placeholder="<?php echo lang_line('label_write_message'); ?>"><?php echo set_value('message'); ?></textarea>
                                <?php echo form_error('message'); ?>
                            </div>
                            <div class="col-sm-12 no-padding m_bottom5 less-class padding_left_null">
                                <div class="col-sm-6 col-6-field">
                                    <label>Name</lable>
                                    <input id="name" name="name" placeholder="<?php echo lang_line('label_your_name'); ?> *" class="form-control" value="<?php echo set_value('name', $from_name); ?>" class="form-control input-md wiDthDef" type="text">
                                    <?php echo form_error('name'); ?>
                                </div>
                                <div class="col-sm-6 col-6-field">
                                <label>Email<small>(Your tax receipt will be emailed to this email ID)</small></lable>
                                    <input id="email" name="card_email" placeholder="<?php echo lang_line('label_your_email'); ?> *" class="form-control" value="<?php echo set_value('card_email', $email_address); ?>" class="form-control input-md" type="text">
                                    <?php echo form_error('card_email'); ?>
                                </div> 
                            </div>
                            <div class="personal-information-section-2">
                                <div class="col-sm-6">
                                    <label>Address</lable>
                                    <?php  $requied_add = '';
                                        if( site_url() == "https://imicanada.org/"){
                                            $requied_add = '*';
                                        }
                                    ?>
                                    <input id="address" name="donate_address" placeholder="Address <?php echo $requied_add; ?>" class="form-control" value="<?php echo set_value('donate_address', $donate_address) ?>" class="form-control input-md" type="text">
                                    <?php echo form_error('donate_address'); ?>
                                </div>
                                <div class="col-sm-6">
                                    <label>Country</lable>
                                    <?php echo form_dropdown('honor_home_country', DropdownHelper::country_dropdown(), set_value("honor_home_country", $honor_home_country), 'class="form-control"') ?>
                                    <?php echo form_error('honor_home_country'); ?>
                                </div>
                            </div>
                            <div class="personal-information-section-3">
                                <div class="col-sm-4">
                                    <label>State</lable>
                                    <?php echo form_dropdown('honor_home_state', [""=>"Select State"], set_value("honor_home_state", $honor_home_state), 'class="form-control"') ?>
                                    <?php echo form_error('honor_home_state'); ?>
                                </div>
                                <div class="col-sm-4">
                                    <label>Zip</lable>
                                    <input id="zip" name="donate_zip" placeholder="Zip" class="form-control" value="<?php echo set_value('donate_zip', $donate_zip) ?>" class="form-control input-md" type="text">
                                    <?php echo form_error('donate_zip'); ?>
                                </div>
                                <div class="col-sm-4">
                                    <label>City</lable>
                                    <?php echo form_dropdown('honor_home_city', [""=>"Select City"], set_value("honor_home_city", $honor_home_city), 'class="form-control"') ?>
                                    <?php echo form_error('honor_home_city'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="honor-preview" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="honor-modal-wrap">
                                        <div class="iho-header">
                                            <h2 class="h40 text-center">PREVIEW </h2> <br> Here’s what we’ll send to <span class="sendtoname2"><?php echo isset($_POST['sendTo']) && $_POST['sendTo'] == "recipient" ? (isset($_POST['recipientName']) ? $_POST['recipientName'] : '') : (isset($_POST['honorto']) ? $_POST['honorto'] : ''); ?></span></h2>
                                        </div>

                                        <table border="0" style="width:100%;">
                                            <tr>
                                                <td>
                                                    <img src="./assets/frontend/images/honor.jpg" alt="Honor" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <strong>To: </strong><span class="honorName"><?php echo isset($_POST['honorto']) ? $_POST['honorto'] : ''; ?></span><br />
                                                    <strong>Message: </strong><span class="honorMessage"><?php echo isset($_POST['message']) ? $_POST['message'] : ''; ?></span><br />
                                                    <strong>From: </strong> <span class="fromName"><?php echo isset($_POST['fromname']) ? $_POST['fromname'] : ''; ?></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>
                                                        The $<span class="amountHonor"><?php echo isset($_POST['donating_amount']) ? $_POST['donating_amount'] : ''; ?></span> donation that <span class="fromnameHonor"><?php echo isset($_POST['fromname']) ? $_POST['fromname'] : ''; ?></span> made to Imamia Medics International in your honor is going to help fund humanitarian relief, health care and education projects for communities around the world. It will save lives and empower communities so future generations can lift their families out of the cycles of poverty and need.
                                                    </p>
                                                    <p>
                                                        Visit us at <a href="http://imamiamedics.com">imamiamedics.com</a> to learn more about the impact we have together.
                                                    </p>
                                                    <p>
                                                        Imamia Medics International<br />Save a life, save humanity<br />PO Box 8209<br />Princeton, NJ 08543
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fl_lft w_100 text-center">
                        <?php if(isset($_POST['honorto']) && trim($_POST['honorto'])){
                                echo form_error("custom_grecap");
                            } ?>
                        </div>
                        <div class="col-md-12 no-padding m_bottom10 align_center">
                            <a href="javascript:;" class="preview-honor-email btn-honor"><?php echo lang_line('button_preview'); ?></a>
                            <button id="honor" class="btn-honor" name="btn_donate_form_new" type="submit" onclick="addItem('honor'); return false;" value="Send"><?php echo lang_line('button_send'); ?></button>
                            <!-- <input id="honor" class="btn-honor" name="btn_donate_form_new" type="submit" onclick="addItem('honor'); return false;" value="Send"> -->
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="toggle-view-div RequestHonour donate-content-section" id="other-ways-to-give" >
        <div class="hundred  no-float">

            <?php
            $className = "";
            if ($DONATEFORM['column_first_text'] != "" && $DONATEFORM['column_two_text'] == "" && $DONATEFORM['column_three_text'] == "") {
                $className = "fullWidth100";
            } else if ($DONATEFORM['column_first_text'] == "" && $DONATEFORM['column_two_text'] != "" && $DONATEFORM['column_three_text'] == "") {
                $className = "fullWidth100";
            } else if ($DONATEFORM['column_first_text'] == "" && $DONATEFORM['column_two_text'] == "" && $DONATEFORM['column_three_text'] != "") {
                $className = "fullWidth100";
            } else if ($DONATEFORM['column_first_text'] != "" && $DONATEFORM['column_two_text'] != "" && $DONATEFORM['column_three_text'] == "") {
                $className = "midWidth50 ";
            } else if ($DONATEFORM['column_first_text'] == "" && $DONATEFORM['column_two_text'] != "" && $DONATEFORM['column_three_text'] != "") {
                $className = "midWidth50 ";
            } else if ($DONATEFORM['column_first_text'] != "" && $DONATEFORM['column_two_text'] == "" && $DONATEFORM['column_three_text'] != "") {
                $className = "midWidth50 ";
            } else {
                $className = "row_donate";
            }

            ?>
            <div class="hundred no-float">
                <?php if (isset($DONATEFORM['column_first_text']) != "") { ?>

                    <div class="<?php echo $className; ?>">

                        <?php echo $DONATEFORM['column_first_text']; ?>

                    </div>

                <?php } ?>

                <?php if (isset($DONATEFORM['column_two_text']) != "") { ?>

                    <div class="<?php echo $className; ?>">

                        <?php echo $DONATEFORM['column_two_text']; ?>
                    </div>

                <?php } ?>

                <?php if (isset($DONATEFORM['column_three_text']) != "") { ?>

                    <div class="<?php echo $className; ?>">
                        <?php echo $DONATEFORM['column_three_text']; ?>

                    </div>
                <?php } ?>

                <?php if (isset($DONATEFORM['donation_way_to_give_address']) && $DONATEFORM['donation_way_to_give_address'] != "") { ?>

                    <div class="modal-footer bgmodFoot no-float">
                        <div class="address-line"> <?php echo $DONATEFORM['donation_way_to_give_address']; ?></div>
                        <!-- <div class="address-line">passages of Lorem Ipsum 330</div>
                                                                                                                                                                            <div class="address-line">passages of Lorem Ipsum 10013</div>
                                                                                                                                                                            <div class="address-line">Phon 954498995</div>
                                                                                                                                                                            <div class="address-line">passages of Lorem Ipsum</div>-->
                    </div>

                <?php } ?>
            </div>
        </div>
    </div>                           
</div>
<ul class="tabchangerDonate">
    <li class="switch-toggle donatenow" data-view-screen="#give-now" ><span><?php echo lang_line('heading_give_now'); ?></span></li> 
    <li class="switch-toggle giveHonor" data-view-screen="#onWillPopup" ><span><?php echo lang_line('heading_give_someone'); ?></span></li>
    <li class="switch-toggle requestwill" data-view-screen="#other-ways-to-give" ><span><?php echo lang_line('heading_ways_to_give'); ?></span></li>
</ul>
<div class="donatePage">
</div>
</div>
<script type="text/javascript">
    console.log(`<?php  echo "myemail site".site_url(); ?>`)
    function donateBtn2() {

        $('#donation').modal('toggle');
    }

    function showhidReciepent(e) {
        if ($(e).is(':checked')) {
            $('.showif_someone_else').slideDown();
        } else {
            $('.showif_someone_else').slideUp();
        }
    }

    $(document).on('click', '.preview-honor-email', function() {

        if ($('#honorofname').val() != "" && $('#honorEmail').val() != "" && $('#donating_amount').val() != "") {

            if ($('#sendTo').is(':checked')) {
                if ($('#recipientName').val() != "" && $('#recipientEmail').val() != "") {
                    $('.amountHonor').html($('#donating_amount').val());
                    $('#honor-preview').modal('toggle');
                } else {
                    alert('Please fill required fields first');
                }
            } else {
                $('.amountHonor').html($('#donating_amount').val());
                $('#honor-preview').modal('toggle');
            }

        } else {
            alert('Please fill required fields first');
        }

    });

    $(document).on('change', 'select[name="donation_projects"]', function() {
        //console.log('asds', $('select[name="donation_projects"] :selected').attr('class'));
        if($('select[name="donation_projects"] :selected').attr('class') == "camp"){
            $('.camp-related').show();
        } else {
            $('.camp-related').hide();
        }
        if($('select[name="donation_projects"] :selected').attr('type') == "Khums"){
            $('#sehm_o_marjaa').show();
        }else{
            $('#sehm_o_marjaa').hide();
        }
        if($('select[name="donation_projects"] :selected').attr('type') =="Fitrana"){
            $('#is_syed').show();
        }else{
            $('#is_syed').hide();
        }
    });

    $(document).on('change', 'input[name="paymenttype"]', function() {
        if ($(this).val() == "paypal") {
            $('.card-details').hide();
            //$('input#onetime').prop("checked", true);
            //hideElement('input[name=\'donation_mode\']:checked', '.hideElement', 'onetime', true);
            //$('.fl_lft.m_rite10.m_bottom5.recurring').hide();
        } else {
            $('.card-details').show();
            //$('.fl_lft.m_rite10.m_bottom5.recurring').show();
        }
    });
    new Cleave('#card_number', {
        creditCard: true,
        onCreditCardTypeChanged: function(type) {
            // update UI ...
        }
    });
    new Cleave('#card_expiry', {
        date: true,
        datePattern: ['m', 'y']
    });

    $(document).on('change', 'input[name="honor_paymenttype"]', function() {
        if ($(this).val() == "card") {
            $('.honor-card-details').show();
        } else {
            $('.honor-card-details').hide();
        }
    });
    new Cleave('#honor_card_number', {
        creditCard: true,
        onCreditCardTypeChanged: function(type) {
            // update UI ...
        }
    });
    new Cleave('#honor_card_expiry', {
        date: true,
        datePattern: ['m', 'y']
    });
    $(document).on('change', 'input[name="donation_mode"]', function() {
            if($(this).val() == "onetime"){
                $('select[name="donation_freq"]').parent(".donation_freq").hide();
                $('select[name="donation_freq"] option:eq(0)').prop('selected', true);
                $('#review-type').html("Single Donation");
            }else{
                $('select[name="donation_freq"]').parent(".donation_freq").show();
                $('#review-type').html("Recurring Donation");

            }
    });
    $(document).ready(function() {
        current_tab = $('.giving-to-imi.active-tab-donation');
        if(current_tab.length > 0){
            if(current_tab.data('belongs-country') == 3){
                $('input[type="radio"][value="card"]').attr('disabled', true);
                $('.nlabel-cc').css({"visibility":"hidden", "order": "1"});
                $('.card-details').hide();
                $('input[type="radio"][value="paypal"]').prop("checked", true);
            }
        }
    });
</script>


<?php if (isset($_POST['errorHonor'])) { ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.errorHonor').html('Some errors occured in your form. Please check and resolve.');
            $('.tabchangerDonate > li.giveHonor > .tabmeta').click();
        });
    </script>
<?php } ?>
<?php //if (!empty(trim($donProjVal))){ ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name=donation_projects]').trigger('change');
        });
    </script>
<?php //} ?>


<!-- ////start here//// -->


<!-- <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
     
     
</div>
</div> -->