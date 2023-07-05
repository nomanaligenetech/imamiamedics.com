<!-- <h3>Thank you for your Submission</h3> -->
<h3> <?php echo lang_line('text_thankyou_submission'); ?> </h3>
<p><?php echo lang_line('text_thankyou_submission_line'); ?><a href="mailto:imiarbaeen@gmail.com">imiarbaeen@gmail.com</a></p>
<?php if( isset($text_expired_passport_submission_line) && !empty($text_expired_passport_submission_line) ): ?>
    <p><strong>NOTE: <?php echo $text_expired_passport_submission_line; ?></strong> <?php echo $text_expired_passport_submission_line_contd; ?></p>
<?php endif; ?>
<!-- <p>We have successfully recieved your application for Arbaeen Medical Mission, we will contact you soon.</p> -->