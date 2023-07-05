<div style="font-size:13px;">
    
    <p style=" <?php echo $emailTemplateHelper->styles("p");?> ">
        Thank you for submitting Mentorship Form.
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
                            	<td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Last Name:</td>
                                <td><?php echo $email_post['last_name']; ?></td>
                          	</tr>
                            
                            <tr>
                            	<td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Address:</td>
                                <td><?php echo nl2br( $email_post['address'] ); ?></td>
                          	</tr>
                            
                            <tr>
                            	<td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Address 2:</td>
                                <td><?php echo nl2br ( $email_post['address_2'] ); ?></td>
                          	</tr>
                            
                            <tr>
                            	<td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">State:</td>
                                <td><?php echo $email_post['state']; ?></td>
                          	</tr>
                            
                            <tr>
                              <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">City:</td>
                              <td><?php echo $email_post['city']; ?></td>
                            </tr>
                            <tr>
                            	<td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Email:</td>
                                <td><?php echo ( $email_post['email'] ); ?></td>
                          	</tr>
                            <tr>
                              <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Zip:</td>
                              <td><?php echo ( $email_post['zip'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Employer:</td>
                              <td><?php echo ( $email_post['employer'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Profession:</td>
                              <td><?php echo ( $email_post['profession'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">University:</td>
                              <td><?php echo ( $email_post['university'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">University State:</td>
                              <td><?php echo ( $email_post['university_state'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">University City:</td>
                              <td><?php echo ( $email_post['university_city'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Degree Type:</td>
                              <td><?php echo ( $email_post['degree_type'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Major:</td>
                              <td><?php echo ( $email_post['major'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Graduate Year:</td>
                              <td><?php echo ( $email_post['graduate_year'] ); ?></td>
                            </tr>
                            
                      	</table>
        
                  </div>
                
                </td>
            </tr>

		</table>
             
    </p>
    
    
</div>