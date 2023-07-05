<?php
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data",
								"name"			=> "form1",
								"id"			=> "form1");

form_open(site_url( uri_string() ), $attributes);
?>
<a name="hash_form" id="hash_form"></a>
<div class="formarea mq-main-head-2">
  <div class="abstract-form-content">
   
    <div class="subheading mq-main-subhead">
    	<?php echo conference_fullname( $conference ); ?>
    </div>
    
    <div class="subheading-2">
    	<?php echo conference_durationdates( $conference ); ?>
    </div>
    
    </div>
    
    
    
    
    
    
    
    
    <table cellpadding="2" cellspacing="5" width="100%" class="semiform mq-semiform" >
        <tbody>
            <tr>
                <td class="mq-layout-fixed">
                    <?php
                    $data["_messageBundle"]				= $_messageBundle2;
                    
                    $this->load->view('frontend/template/_show_messages.php', $data);
					
					
					if ( !$is_paid )
					{
                        if($payment_type == "card"){
                            ?>
                            <form class="mq-form-payment-5" name="payment_form" action="<?php echo site_url( uri_string() ); ?>" method="post" target="_top">
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
                                            <button class="btn-payezzy-submit" name="card_payment" type="submit" onclick="submitForm(); return false;" value="Pay">Pay</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                                
                            <?php
                                } else { ?>
                    
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
                        <input type="hidden" name="return" value="<?php echo site_url('conference/'. $conference->row("slug") .'/registration/success');?>">
                        <input type="hidden" value="<?php echo site_url('conference/'. $conference->row("slug") .'/registration/screen/5');?>" name="cancel_return">
                        </form>
                        
                        
                        <script>
						$(document).ready(function(){
						
							$("form[name='payment_form']").submit();
						
						});
						</script>
                        
                    <?php
                        }
					}
					?>
                    
                    
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="formbtns"></div>
<?php
form_close();
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
</script>