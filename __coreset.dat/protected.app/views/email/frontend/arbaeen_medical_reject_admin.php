<div style="font-size:13px;">
    <?php $name = $email_post["first_name"].' '.$email_post["middle_name"].' '.$email_post["last_name"];?>
    <p style=" <?php echo $emailTemplateHelper->styles("p");?> ">
        An applicant <b><?php echo $name;?></b> is now rejected for Arbaeen Medical Mission.
    </p>
<br /><br />
    <p style=" <?php echo $emailTemplateHelper->styles("p");?> ">

        <?php if ( $email_post['rejected_notes'] != "" ){

            echo '<b>Rejected Notes Without Interview: </b> '.$email_post['rejected_notes'].'<br/><br/>';

        } ?>

        <?php if ( $email_post['interview_1_rejected_notes'] != "" ){

            echo '<b>Rejected Notes After Interview 1: </b> '.$email_post['interview_1_rejected_notes'].'<br/><br/>';

        } ?>
        
        <?php if ( $email_post['interview_2_rejected_notes'] != "" ){

            echo '<b>Rejected Notes After Interview 2: </b> '.$email_post['interview_2_rejected_notes'].'<br/><br/>';

        } ?>
    </p>
      
    <br />
</div>