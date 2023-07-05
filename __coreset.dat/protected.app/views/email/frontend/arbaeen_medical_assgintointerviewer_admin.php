<div style="font-size:13px;">
    <?php $name = $email_post["first_name"] . ' ' . $email_post["middle_name"] . ' ' . $email_post["last_name"]; ?>
    <p style=" <?php echo $emailTemplateHelper->styles("p"); ?> ">
        An applicant <b><?php echo $name; ?></b> is now assigned to interviewer <b><?php echo $email_post['interviewer_email'].' ( '.$email_post['interviewer_username'].' ) ';?></b> for Arbaeen Medical Mission.
    </p>

    <br />
</div>