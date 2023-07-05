<div style="font-size:13px;">
    
    <p style=" <?php echo $emailTemplateHelper->styles("p");?> ">
        <?php echo $email_post["name"];?> 
        sent contact inquiry.
    </p>
      
    <br />
      
    <p style=" <?php echo $emailTemplateHelper->styles("p");?> ">
		
        <table border="0" style="width:100%;">
            <tr>
                <td>
                
                    <div class="main" style="font-family:arial;text-align:left;">
                    
                        <table  class="rooms_details" cellpadding="5" style="border:1px solid #c4c4c4; width:100%; font-size:12px;">
                        	<tr>
                            	<td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Name: </td>
                                <td><?php echo $email_post['name']; ?></td>
                          	</tr>
                            
                            <tr>
                            	<td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Email: </td>
                                <td><?php echo $email_post['email']; ?></td>
                          	</tr>
                            
                            <tr>
                            	<td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Phone: </td>
                                <td><?php echo $email_post['phone']; ?></td>
                          	</tr>
                            
                            <tr>
                            	<td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Country: </td>
                                <td><?php echo $email_post['country']; ?></td>
                          	</tr>
                            
                            <tr>
                            	<td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">City: </td>
                                <td><?php echo $email_post['city']; ?></td>
                          	</tr>
                            
                            <tr>
                              <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Profession:</td>
                              <td><?php echo $email_post['profession']; ?></td>
                            </tr>
                            <tr>
                            	<td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Precious Words: </td>
                                <td><?php echo nl2br( $email_post['preciouswords'] ); ?></td>
                          	</tr>
                            
                      	</table>
        
                  </div>
                
                </td>
            </tr>

		</table>
             
    </p>
    
    
</div>