<div style="font-size:13px;">
    <?php $name = $email_post["first_name"].' '.$email_post["middle_name"].' '.$email_post["last_name"];?>
    <p style=" <?php echo $emailTemplateHelper->styles("p");?> ">
       <b>Dear <?php echo $name;?></b>,
    </p>

    <br />

    <p style=" <?php echo $emailTemplateHelper->styles("p");?> ">
      Asalaam Aleikum.
    </p>
      
    <br />
      
    <p style=" <?php echo $emailTemplateHelper->styles("p");?> ">
      We have received your application for the upcoming IMI Annual Arbaeen Medical Mission taking place August 25-September 8 in Iraq. A team member will contact you within 2 weeks regarding the next stage of the application process. If you do not hear back within that time, you may contact us at <a href="mailto:">imiarbaeen@gmail.com</a>. 

      <br />

      A copy of your form submission is included below for your records. 

      <br />
      <br />
      <?php $this->load->view("email/frontend/arbaeen_medical_submission_details.php");?>
      <br />
      <br />

      Best, <br />
      Arbaeen Working Group <br />
      Imamia Medics International
    </p>
    
</div>