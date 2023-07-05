<div style="font-size:13px;">
    <?php $name = $email_post["first_name"].' '.$email_post["middle_name"].' '.$email_post["last_name"];?>
    <p style=" <?php echo $emailTemplateHelper->styles("p");?> ">
       <b>Dear <?php echo $name;?></b>,
    </p>
      
    <br />
      
    <p style=" <?php echo $emailTemplateHelper->styles("p");?> ">
       Your application is now moved to waitlist for Arbaeen Medical Mission, we will contact you soon.
    </p>
    
</div>