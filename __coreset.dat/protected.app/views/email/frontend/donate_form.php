<div style="font-size:13px;">
    
    <p style=" <?php echo $emailTemplateHelper->styles("p");?> ">
      <?php echo isset($email_post['recurring']) ? 'Thankyou for your recurring donation payment' : 'Thank you for submitting Donate Form.';?>
    </p>
      
    <br />
      
    <p style=" <?php echo $emailTemplateHelper->styles("p");?> ">
		
        <table border="0" style="width:100%;">
            <tr>
                <td>
                
                    <div class="main" style="font-family:arial;text-align:left;">
                    
                        <table  class="rooms_details" cellpadding="5" style="border:1px solid #c4c4c4; width:100%; font-size:12px;">
                        	<tr>
                        	  <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Donation Projects</td>
                        	  <td><?php echo DropdownHelper::donation_projects_dropdown(FALSE, $email_post['donation_details']["donation_projects_id"], false, false, false, $content_languages);?></td>
                      	  </tr>
                        	<tr>
                            	<td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Name: </td>
                                <td><?php echo ucwords($email_post['donation_details']['first_name']); ?></td>
                          	</tr>
                            
                            <tr>
                            	<td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Email:</td>
                                <td><?php echo $email_post['donation_details']['email']; ?></td>
                          	</tr>
                            
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Donation Mode:</td>
                              <td><?php echo ucwords($email_post['donation_details']['donation_mode']); ?></td>
                            </tr>
                            <?php
							if ( $email_post['donation_details']['donation_mode'] == "recurring" )
							{
							?>
                                <tr>
                                  <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Donation Frequency:</td>
                                  <td><?php echo DropdownHelper::donationfrequency_dropdown(FALSE, $email_post['donation_details']['donation_freq']); ?></td>
                                </tr>
                                <tr>
                                  <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Donation Occurance:</td>
                                  <td><?php if($email_post['donation_details']['num_of_recurring'] < 1){
                                    echo "Initial Payment";
                                  } else {
                                    echo "Schedule Payment # ".$email_post['donation_details']['num_of_recurring'];  
                                  }?></td>
                                </tr>
							<?php
							}
							?>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Donate Type:</td>
                              <!--<td><?php //echo DropdownHelper::donatetype_dropdown(FALSE, $email_post['donation_details']["donate_type"]);?></td>-->
                              <td>Give Now<?php //echo $email_post['donation_details']["donate_type"];?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Donate Amount:</td>
                              <td><?php echo format_price($email_post['donation_details']['donate_amount'], array("prefix" => "$")); ?></td>
                            </tr>
                            <tr>
                            	<td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Comments:</td>
                                <td><?php echo nl2br( $email_post['donation_details']['comments'] ); ?></td>
                          	</tr>
                            
                      	</table>
        
                  </div>
                
                </td>
            </tr>

		</table>
             
    </p>
    
    
</div>