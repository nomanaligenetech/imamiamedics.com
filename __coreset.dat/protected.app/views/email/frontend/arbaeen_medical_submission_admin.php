<div style="font-size:13px;">
    <?php $name = $email_post["first_name"] . ' ' . $email_post["middle_name"] . ' ' . $email_post["last_name"]; ?>
    <p style=" <?php echo $emailTemplateHelper->styles("p"); ?> ">
        <b><?php echo $name; ?></b> has submit an application for Arbaeen Medical Mission. Below are the details.
    </p>

    <br />

    <?php $this->load->view("email/frontend/arbaeen_medical_submission_details.php");?>

</div> 