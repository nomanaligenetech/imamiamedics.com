<div style="font-size:13px;">
    <?php $name = $email_post["first_name"].' '.$email_post["middle_name"].' '.$email_post["last_name"];?>
    <p style=" <?php echo $emailTemplateHelper->styles("p");?> ">
        Applicant <b><?php echo $name;?></b> interview has been scheduled. Below are the details.
    </p>
      
    <br />
      
    <p style=" <?php echo $emailTemplateHelper->styles("p");?> ">
		
        <table border="0" style="width:100%;">
            <tr>
                <td>
                
                    <div class="main" style="font-family:arial;text-align:left;">
                    
                        <table  class="rooms_details" cellpadding="5" style="border:1px solid #c4c4c4; width:100%; font-size:12px;">
                        	<tr>
                            	<td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">First Name: </td>
                                <td><?php echo $email_post['first_name']; ?></td>
                            </tr>
                              
                            <tr>
                            	<td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Middle Name: </td>
                                <td><?php echo $email_post['middle_name']; ?></td>
                            </tr>
                              
                            <tr>
                            	<td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Last Name: </td>
                                <td><?php echo $email_post['last_name']; ?></td>
                          	</tr>
                            
                            <tr>
                            	<td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Email: </td>
                                <td><?php echo $email_post['email']; ?></td>
                          	</tr>
                            
                            <tr>
                            	<td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Phone: </td>
                                <td><?php echo $email_post['phone_number']; ?></td>
                          	</tr>
                            
                            <tr>
                            	<td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Interviewer: </td>
                                <td><?php echo $email_post['interviewer_username']; ?></td>
                            </tr>
                              
                            <tr>
                            	<td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Interview Details: </td>
                                <td><?php echo $email_post['interview_details']; ?></td>
                          	</tr>
                            
                      	</table>
        
                  </div>
                
                </td>
            </tr>

		</table>
             
    </p>
    
    
</div>