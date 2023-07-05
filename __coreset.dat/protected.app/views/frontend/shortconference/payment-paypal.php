<?php 

?>
<h3>You are now redirecting to paypal</h3>
<form name="payment_form" action="<?php echo $this->payment->paypal_form_details()->url; ?>" method="post" target="_top" style="display:none;">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="<?php echo $this->payment->paypal_form_details()->business_email; ?>">
    <input type="hidden" name="lc" value="US">
    <input type="hidden" name="item_name" value="<?php echo $conference->row("name"); ?>">
    <input type="hidden" name="item_number" value="<?php echo $user_id; ?>">
    <input type="hidden" name="amount" value="<?php echo $total_amount; ?>" class="paypal-amount">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" value="2" name="rm">
    <input type="hidden" value="1" name="no_shipping">
    <input type="hidden" value="<?php echo $register_id; ?>" name="custom">
    <input type="hidden" name="no_note" value="1">
    <?php #site_url("home/payment_notify/". $conference->row("slug") ."/" . $register_id);
    ?>
    <input type="hidden" name="notify_url" value="<?php echo site_url("home/payment_notify/" . $conference->row("slug") . "/" . $register_id); ?>">

    <?php #echo site_url('conference/'. $conference->row("slug") .'/register/success');
    ?>
    <input type="hidden" name="return" value="<?php echo site_url('shortconference/' . $conference->row("slug") . '/registration/form/success'); ?>">
    <input type="hidden" value="<?php echo site_url('shortconference/' . $conference->row("slug") . '/registration/form'); ?>" name="cancel_return">
</form>

<script>
    $(function(){
        $("form[name='payment_form']").submit(); 
    });
</script>