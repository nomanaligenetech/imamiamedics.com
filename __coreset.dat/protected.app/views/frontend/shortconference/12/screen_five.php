<style>
.error_style{ display:none;}
.inline_error_style .error_style{ display:block;}
.conf-reg-tabletab select{ padding:5px;}
</style>
<div class="conf-reg-page-top">
    <h1><?php

use LDAP\Result;

 echo lang_line('text_conferenceregistration');?></h1>
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

<?php $this->load->view("frontend/shortconference/12/include_screen_two.php");?>

<p>&nbsp;</p>

<p>&nbsp;</p>



<?php // $this->load->view("frontend/shortconference/12/include_participant_UID.php");?>





<?php //$this->load->view("frontend/shortconference/12/include_screen_five.php");?>
<?php 
if($conferenceregistration_screentwo -> num_rows() > 0){  
	
		$screentwo_data = $conferenceregistration_screentwo->result_array();

		$prefix			= $this->functions->getCurrencySymbol($conferenceregistration->row("show_rates_in_currency")) ;
        ?>
        <div class="reg-ticket-rightsection pak_step-form-cart s-five-cart-details">
            <h1>Summary : Cart Items</h1>
        
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="cart-table">
                <!-- <tr>
                    <td height="35" width="50%">Package Fees :</td>
                    <td height="35" width="50%" align="right">
                    
                    <strong class="js_package_fee">
                    <?php // echo format_price("<span>".$screentwo_data[0]["price_package_fee"]."</span>", array("prefix" => $prefix), TRUE, TRUE );?>
                   
                    </strong>
                    </td>
                </tr> -->
				<?php if ($screentwo_data[0]["be_a_member_fee"] > 0){?> 
                <tr class="tr_nam">
                  <td height="35">
                  <small>(Not a member FEE)</small>
                  </td>
                  <td height="35" align="right">
                    <strong class="js_not_a_member_fee">
                    <?php echo format_price("<span>".$screentwo_data[0]["be_a_member_fee"]."</span>", array("prefix" => $prefix), TRUE, TRUE );?>
                    <input type="hidden" name="txt_not_a_member_fee" value="0"  />
                    </strong>
                  </td>
                </tr>
                <?php }
                foreach ($conferenceregistration_screentwo_details->result_array() as $std)
                {
                    $conference_prices_details 		= $this->queries->fetch_records("short_conference_prices_details", " AND id = '". $std["price_details_id"] ."' ");
                    $parent_addon  		            = $this->db->query("SELECT * from `tb_short_conference_prices_master` where id = '".$conference_prices_details->row()->prices_parent_id."'");

                    if ( $conference_prices_details->num_rows() > 0 )
                    {
                        $explode_price_details_value		= explode("::", $std["price_details_value"]);
                    ?>
                        <tr>
                            <td width="200px;">
                                <?php if($std['addon'] != 1){ ?>
                                    <strong><?php echo $conference_prices_details->row()->whoattend_nam;?></strong>
                                <?php } ?>
                                <p><strong><?php echo $parent_addon->row()->title;?></strong></p>
                                <?php echo $conference_prices_details->row()->prices_title;?>
                                <br  />
                            </td>
                            <td width="100px;" align="right">
                            <?php echo $std["multply_by_no_of_people"] ;?> 
                            x 
                            <?php echo format_price( $explode_price_details_value[1], array("prefix" => $this->functions->getCurrencySymbol($conferenceregistration->row("show_rates_in_currency"))) );?>
                            </td>
                        </tr>
                    <?php
                    }
                }
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
                
                
                <tr>
                    <td height="35">Payable Now : 
                    <span style="display:none;" class="parent_js_payable_now_perc">
                        (<span class="js_payable_now_perc">0</span>%)
                    </span>
                    </td>
                    <td height="35" align="right">
                   
                    <strong class="js_payable_now">
                    <?php echo format_price("<span>".$screentwo_data[0]["price_payable_now"]."</span>", array("prefix" => $prefix), TRUE, TRUE );?>
                    </strong>
                    </td>
                </tr>
<!--             
                <tr>
                    <td height="35">Cash OnSite :</td>
                    <td height="35" align="right">
                    <strong class="js_cash_onsite">
                    <?php // echo format_price("<span>".$screentwo_data[0]["price_cash_onsite"]."</span>", array("prefix" => $prefix), TRUE, TRUE );?>
                    <input type="hidden" name="txt_cash_onsite" value="0"  />
                    </strong>
                    </td>
                </tr> -->
                
                
                
                <tr>
                    <td><strong>Total Payable:</strong></td>
                    <td align="right" class="totalpayable">
                   
                    <strong class="js_total_payable">
                    <?php echo format_price("<span>".$screentwo_data[0]["price_total_payable"]."</span>", array("prefix" => $prefix), TRUE, TRUE );?>
                    </strong>
                    
                    </td>
                </tr>
            </table>
        </div>         	
<?php } ?>
<div class="flt-rgt mq-imi-pay-sec">
    <input type="hidden" name="id" value="<?php echo set_value("id", $id);?>"  />
    
   
    
    
    
    <?php
	if ( $SHOW_submit_button_screen_5 )
	{
		$_make_payment_button				= FALSE;
		if ( $conference_regions -> row("allow_payment") )
		{
			$_make_payment_button				= TRUE;			
		}
		
		
		// if ( $country_notes->num_rows() > 0 )
		// {
		// 	if ( !$country_notes->row()->allow_payment_for_this_country )
		// 	{
		// 		$_make_payment_button		= FALSE;
		// 	}
		// }
		
		
		// if ( $conferenceregistration_screenone -> row("travelling_with") == "independently" )
		// {
		// 	$_make_payment_button			= FALSE;
		// }
		
		
		

		if ( !$_make_payment_button )
		{
			?>
				<input type="submit"	name="proceedfurther"		value="Finish"			class="bluebuttons flt-">
			<?php
		}
		else 
		{
		?>
			
			<div class="payment-div no-padding m_bottom10 custom_style1">
				<label class=" m_bottom5 paypal ">
					<?php
                    $checked = isset($_POST['paymenttype']) && $_POST['paymenttype'] == "paypal" ? true : false;
                    echo form_radio(array('name' => 'payment_type', 'value' => 'paypal', 'checked' => $checked,  'id' => 'paypal'));
					echo "Pay via PayPal";
					?>
				</label>
				<label class=" m_bottom5 m_rite10 credit-card active">
                    <?php

					echo form_radio(array('name' => 'payment_type', 'value' => 'card', 'checked' => TRUE, 'id' => 'card'));
					echo "Pay via Credit Card";
					?>
				</label>
			</div>

			<!-- <div class="paypal-details no-padding m_bottom10" style="display:none;">
				<small class="flt-rgt" style="font-style:italic; margin-top:5px;">
					You dont need a PayPal account to pay. You can also pay <br />by using your Debit or Credit Card. 
					<a href="<?php //echo base_url( "assets/frontend/images/credit-card-not-paypal.gif" );?>" class="modelImage">Click here</a> to see how.
				</small>
			</div>
			 -->
			
			<input type="submit" name="makepayment" value="Pay Now"	class="blackbuttons flt-rgt makepayment" style="display:none;"/>


		<?php	
		}
        // var_dump($_POST['payment_type']);die;
        // if($_POST['payment_type'] == 'paypal'){
        //     ?>
          
            <?php
        // }
		?>
   <?php     
       $attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data",
								"name"			=> "form1",
								"id"			=> "form1");

form_open(site_url( uri_string() ), $attributes); ?>
<div class="formarea mq-main-head-2">
    <table cellpadding="2" cellspacing="5" width="100%" class="semiform mq-semiform" >
        <tbody>
            <tr>
                <td class="mq-layout-fixed">
                    <?php
                    $data["_messageBundle"]				= $_messageBundle2;
                    
                    $this->load->view('frontend/template/_show_messages.php', $data);
					
					if ( !$is_paid )
					{
                            ?>
                            <form class="mq-form-payment-5 " name="payment_form" action="<?php echo site_url( uri_string() ); ?>" method="post" target="_top">
                            <?php if (isset($card_error)) { ?>
                                <div class="mq-error-main">
                                    <p class="form_error col-sm-12 no-padding mq-error">
                                        <?php echo $card_error; ?>
                                    </p>
                                </div>
                            <?php } ?> 
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
                                            <button class="btn-payezzy-submit" name="card_payment" type="submit" onclick="submitForm(); return false;" value="Pay Now">Pay Now</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                                
                    
                        <form name="payment_form" action="<?php echo $this->payment->paypal_form_details() -> url;?>" method="post" target="_top" style="display:none;">
                        <input type="hidden" name="cmd" value="_xclick">
                        <input type="hidden" name="business" value="<?php echo $this->payment->paypal_form_details() -> business_email;?>">
                        <input type="hidden" name="lc" value="US">
                        <input type="hidden" name="item_name" value="<?php echo $conference->row("name");?>">
                        <input type="hidden" name="item_number" value="<?php echo $this->functions->_user_logged_in_details( "id" );?>">
                        <input type="hidden" name="amount" value="<?php echo $total_amount;?>">
                        <input type="hidden" name="currency_code" value="USD">
                        <input type="hidden" value="2" name="rm">
                        <input type="hidden" value="1" name="no_shipping">
                        <input type="hidden" value="<?php echo $register_id; ?>" name="custom">
                        <input type="hidden" name="no_note" value="1">
                        <?php #site_url("home/payment_notify/". $conference->row("slug") ."/" . $register_id);?>
                        <input type="hidden" name="notify_url" value="<?php echo site_url("home/payment_notify/". $conference->row("slug") ."/" . $register_id);?>">
                        
                        <?php #echo site_url('conference/'. $conference->row("slug") .'/register/success');?>
                        <input type="hidden" name="return" value="<?php echo site_url('shortconference/'. $conference->row("slug") .'/registration/success');?>">
                        <input type="hidden" value="<?php echo site_url('shortconference/'. $conference->row("slug") .'/registration/screen/5');?>" name="cancel_return">
                        </form>
                        <?php
                        }
					?>
                    
                    
                </td>
            </tr>
        </tbody>
    </table>
</div>
        <?php
	}
	?>

<?php  //$this->load->view("frontend/shortconference/payment.php");?>
</div>



<?php
echo form_close();
?>
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
$(document).on('click', '.makepayment' , function(e){
    e.preventDefault();
    $("form[name='payment_form']").submit(); 
})
</script>