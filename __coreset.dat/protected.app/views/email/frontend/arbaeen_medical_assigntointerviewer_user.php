<div style="font-size:13px;">
    <?php $name = $email_post["first_name"] . ' ' . $email_post["middle_name"] . ' ' . $email_post["last_name"]; ?>
    <p style=" <?php echo $emailTemplateHelper->styles("p"); ?> ">
        <b>Dear <?php echo $email_post['interviewer_username']; ?></b>,
    </p>

    <br />

    <p style=" <?php echo $emailTemplateHelper->styles("p"); ?> ">
        We have assigned an applicant interview for Arbaeen Medical Mission, please have a look.
    </p>

    <p style=" <?php echo $emailTemplateHelper->styles("p"); ?> ">
        <b>Name</b> : <?php echo $name; ?> <br />
        <b>Email</b> : <?php echo $email_post['email']; ?> <br />
        <b>Phone</b> : <?php echo $email_post['phone_number']; ?> <br />
    </p>

    <p style=" <?php echo $emailTemplateHelper->styles("p"); ?> ">
        <a href="<?php echo site_url() . 'admincms/managearbaeenmedicalmission/controls/view'; ?>">Click here</a> to login and see details.
    </p>

</div>