<h3>
    Payment in Process....
</h3>

<p>Please wait you are redirected to paypal...</p>

<?php
if (isset($__process_to_paypal)) {
    ?>
    <form name="stage3_paypal" action="<?php echo $this->payment->paypal_form_details()->url; ?>" method="post" novalidate>
        <input type="hidden" value="<?php echo $this->payment->paypal_form_details()->business_email; ?>" name="business">
        <input type="hidden" value="USD" name="currency_code">

        <input type="hidden" value="_xclick" name="cmd">
        <input type="hidden" value="<?php echo $formdata['total_amount']; ?>" name="amount">

        <input type="hidden" value="tb_arbaeen_medical_mission_stage3|id|<?php echo $stage3_id; ?>" name="custom">
        <input type="hidden" value="<?php echo site_url(uri_string() . "/payment_success"); ?>" name="return">
        <input type="hidden" value="<?php echo site_url(uri_string() . "/payment_cancel"); ?>" name="cancel_return">
        <input type="hidden" value="<?php echo site_url(uri_string() . "/payment_notify"); ?>" name="notify_url">

        <input type="hidden" value="Stage 3" name="item_name">
        <input type="hidden" value="<?php echo $formdata['first_name']; ?>" name="first_name">
        <input type="hidden" value="<?php echo $formdata['last_name']; ?>" name="last_name">

        <input type="hidden" value="2" name="rm">
        <input type="hidden" value="1" name="no_shipping">
        <input type="hidden" value="1" name="no_note">
        <input type="hidden" value="US" name="lc">

    </form>

    <script>
        $("form[name='stage3_paypal']").submit();
    </script>

<?php } ?>