<div style="font-size:13px;">
    
    <p style=" <?php echo $emailTemplateHelper->styles("p");?> ">
        Thank you for submitting Volunteer Form.
    </p>
      
    <br />
      
    <p style=" <?php echo $emailTemplateHelper->styles("p");?> ">
		
        <table border="0" style="width:100%;">
            <tr>
                <td>
                
                    <div class="main" style="font-family:arial;text-align:left;">
                    
                        <table  class="rooms_details" cellpadding="5" style="border:1px solid #c4c4c4; width:100%; font-size:12px;">
                        	<tr>
                            	<td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Name: </td>
                                <td><?php echo $email_post['name']; ?></td>
                          	</tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Date of Birth:</td>
                              <td><?php echo date("d-m-Y", strtotime( $email_post['date_of_birth'] ) ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Email:</td>
                              <td><?php echo ( $email_post['email'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Phone:</td>
                              <td><?php echo ( $email_post['phone'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">City:</td>
                              <td><?php echo ( $email_post['city'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">State:</td>
                              <td><?php echo ( $email_post['state'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Country:</td>
                              <td><?php echo ( $email_post['country'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Qualification:</td>
                              <td><?php echo ( $email_post['qualification'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Area of Interest:</td>
                              <td><?php echo ( $email_post['area_of_interest'] ); ?></td>
                            </tr>
                            
                      	</table>
        
                  </div>
                
                </td>
            </tr>

		</table>
             
    </p>
    
    
</div>