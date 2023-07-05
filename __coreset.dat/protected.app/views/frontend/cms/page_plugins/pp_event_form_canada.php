<?php
if ($DONATEFORM['_process_to_paypal']) {
$data["_messageBundle"]             = $DONATEFORM['_messageBundle_redirect_paypal'];
$this->load->view('frontend/template/_show_messages.php', $data);
?>
<form name="form_event_registerform" action="<?php echo $this->payment->paypal_form_details()->url; ?>" method="post" novalidate>
    <input type="hidden" value="<?php echo $this->payment->paypal_form_details()->business_email; ?>" name="business">
    <input type="hidden" name="active_paypal" class="active-paypal-email" value="imamiacanada@gmail.com">
    <input type="hidden" value="CAD" name="currency_code">
    <input type="hidden" value="<?php echo $this->functions->_user_logged_in_details("id"); ?>" name="item_number">

    <input type="hidden" value="_xclick" name="cmd">
    <input type="hidden" value="<?php echo set_value("donate_amount", $donate_amount); ?>" name="amount">

    <input type="hidden" value="2" name="rm">
    <input type="hidden" value="1" name="no_shipping">
    <input type="hidden" value="1" name="no_note">
    <input type="hidden" value="US" name="lc">


    <input type="hidden" value="tb_donation_form|id|<?php echo $donation_id; ?>" name="custom">



    <input type="hidden" value="<?php echo site_url(uri_string()).'/paymentsuccess'; ?>" name="return">
    <input type="hidden" value="<?php echo site_url(uri_string()).'/paymentnotify'; ?>" name="notify_url">


    <input type="hidden" value="<?php echo site_url(uri_string()).'/paymentcancel'; ?>" name="cancel_return">

    <input type="hidden" value="<?php echo DropdownHelper::donation_projects_dropdown(FALSE, set_value("donation_projects")); ?>" name="item_name">

    <input type="hidden" value="<?php echo set_value("first_name", $from_first_name); ?>" name="first_name">
    <input type="hidden" value="<?php echo set_value("last_name", $from_last_name); ?>" name="last_name">

    <input type="hidden" value="<?php echo set_value("address"); ?>" name="address1">
    <input type="hidden" value="" name="address2">
    <input type="hidden" value="" name="city">
    <input type="hidden" value="" name="country">
    <input type="hidden" value="" name="state">
    <input type="hidden" value="" name="zip">

</form>

<script>
    $("form[name='form_event_registerform']").submit();
</script>
<?php
}?>

<div class="row donation_area donation_desktop m_bottom25 left_area fl_lft donation-campaigns-full form_event_register">
        <div class="DonateNow sameheight">
            <div class="hundred">
                <div class="form_sec fl_lft w_100 custom-border">
                    <form name="form_event_register" action="<?php echo site_url(uri_string()); ?>" id="form_event_register" method="post" enctype="multipart/form-data" novalidate>
                    	<?php if ($is_package): ?> 
                            <div class="packages-main">
                                <h3>Select Packages</h3>
                                <div class="packages">
                                    <?php
                                    
                                    foreach($event_packages as $e_k => $e_v): 
                                        $event_packages_languages = $this->queries->fetch_records("event_packages_languages", " AND event_packages_id = {$e_v->id}")->result_array();
                                        replace_data_for_lang($e_v, $content_languages, $event_packages_languages, ['package_title','available_seats'], SessionHelper::_get_session('LANG_CODE'));
                                        $pck_val = $e_v->id . '|' . $e_v->amount;
                                        $checked = $pck_val == $_POST['package_id'] ? true : false;
                                        ?>
                                        <label class="package-item">
                                            <!-- <input type="hidden" name="package_id" value="<?php // echo $e_v->id; ?>"> -->
                                            <?php echo form_radio(array('name' => 'package_id', 'value' => $pck_val, "checked" => $checked)); ?>
                                            <span class="check"></span>
                                            <span class="package-price"><sup>$</sup><?php echo $e_v->amount; ?></span>
                                            <div class="pakcage-detail">
                                                <!-- <span class="pakcage-seat"><?php // echo $e_v->available_seats; ?></span> -->
                                                <span class="pakcage-title"><?php echo $e_v->package_title; ?></span>
                                            </div>
                                        </label>
                                    <?php endforeach; ?>
                                    <?php echo form_error('package_id'); ?>
                                </div>
                            </div>
                        <?php endif;?>
                        <div class="personal-info">
                            <h3>Personal Information</h3>
                        <!-- <p style="text-align: center;"><?php //echo lang_line('donte_form_text'); ?></p> -->
                            <!-- <input type="hidden" value="<?php //echo $this->payment->paypal_form_details()->business_email; ?>" name="business">
                            <input type="hidden" value="USD" name="currency_code">
                            <input type="hidden" value="<?php //echo $this->functions->_user_logged_in_details("id"); ?>" name="item_number"> -->
                            <input type="hidden" name="donation_mode" value="onetime">
                            <input type="hidden" name="donation_projects" value="<?php echo $sitesectionswidgets->row('don_proj_id'); ?>">
                            <input type="hidden" name="home_country" value="223<?php //echo $campaign['donation_project_id']; ?>">

                            <div class="flALlLeft customclass less-class cutsom-margin-style">
                                <div class="col-sm-4 ">
                                    <input id="name" name="donate_name" placeholder="<?php echo lang_line('text_name'); ?> * " class="form-control donationPclass" value="<?php echo set_value('donate_name', $from_name) ?>" class="form-control input-md wiDthDef" type="text">
                                    <?php echo form_error('donate_name'); ?>
                                </div>
                                <div class="col-sm-4 ">
                                    <input id="email" name="donate_email" placeholder="<?php echo lang_line('text_email'); ?> * " class="form-control donationPclass" value="<?php echo set_value('donate_email', $email_address) ?>" class="form-control input-md" type="text">
                                    <?php echo form_error('donate_email'); ?>
                                </div>
                                <div class="col-sm-4 ">
                                    <input id="donate_phone" name="donate_phone" placeholder="<?php echo lang_line('text_phonenumber'); ?> * " class="form-control donationPclass" value="<?php echo set_value('donate_phone', $donate_phone) ?>" class="form-control input-md wiDthDef" type="text">
                                    <?php echo form_error('donate_phone'); ?>
                                </div>
                            </div>

                            <div class="flALlLeft customclass less-class cutsom-margin-style">
                                
                                <div class="col-sm-12 ">
                                    <input id="mailing_addr" name="mailing_addr" placeholder="<?php echo lang_line('mailing_address'); ?> " class="form-control donationPclass" value="<?php echo set_value('mailing_addr', $mailling_addr) ?>" class="form-control input-md" type="text">
                                    <?php echo form_error('mailing_addr'); ?>
                                </div>
                            </div>
                        </div>
                        <?php if ($is_package): ?>                 
                        <h3>Want to Donate More?</h3>
                        <?php endif; ?>                 

                        <div class="flALlLeft customclass less-class cutsom-margin-style">
                            <div class="col-sm-6 paddRzERo ">
                            <?php if ($is_package): 
                                $placeholder = "$ 0.00";
                                ?>
                                <!-- <label class="fl_lft m_bottom5 m_rite10">Fees will be calculated before you place your order. <?php //echo lang_line('label_pay_paypal'); ?></label> -->
                                
                            <?php else:
                                 $placeholder = "Amount to donate *";
                            
                            endif; ?>                 
                                <input id="add_amount" name="add_amount" placeholder="<?php echo $placeholder;?>" class="form-control" value="<?php echo isset($_POST['add_amount']) ? $_POST['add_amount'] : ''; ?>" class="form-control input-sm" type="number" min="1">
                                <?php echo form_error('add_amount'); ?>
                            </div>
                            <p class="total-price"></p>
                        </div>

                        <div class="flALlLeft col-sm-12  m_bottom10 custom_style1">

                            <label class="fl_lft m_bottom5 m_rite10">
                                <?php
                                // echo form_radio(array('name' => 'paymenttype', 'value' => 'paypal', 'checked' => TRUE, 'id' => 'paypal'));
                                echo form_radio(array('name' => 'paymenttype', 'value' => 'paypal', 'checked' => true, 'id' => 'paypal'));
                                echo lang_line('label_pay_paypal');
                                ?>
                            </label>
                        </div>



                     
                    </div>

                    <input id="hiderecap" type="hidden" value="" name="custom_grecap">
                    <?php if ($is_package){
                        $donate_btn = 'Make Payments';
                        // $donate_btn = lang_line('text_register');
                    }else{
                        $donate_btn = "Donate";

                    }
                        
                        ?> 
                    <div align="center" class="hundred">
                        <button id="givenow" class="submit_btn field_row" name="btn_event_form" type="submit" onclick="addItem('givenow'); return false;" value="EventRegister"><?php echo $donate_btn; ?></button>
                    </div>


                    </form>
                </div>
            </div>
        </div>
    </div>


<script type="text/javascript">

    // $('.package-item').on('click', function (e) {
    //     const pkg_amt = parseInt($(this).children('.package-price').text().replace('$',''));
    //     const add_amt = parseInt($('#donate_amount').val()) || 0;
        
    //     $('.total-price').textContent = (pkg_amt + add_amt);
    // });
    

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

<?php $sitekey = '6Le_N_QUAAAAAKzKoKE3aopntNguOy7ppf7kzafV'; ?>
<div class="g-recaptcha" data-sitekey="<?php echo $sitekey; ?>" data-size="invisible" data-callback="onSubm"></div>