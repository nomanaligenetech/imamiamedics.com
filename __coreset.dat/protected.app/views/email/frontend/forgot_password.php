<div style="font-size:13px;">
    <p style=" <?php echo $emailTemplateHelper->styles("p");?> ">
        Your password has been reset. Please note your new credentials. Click below to login.
    </p>
    
    
    <p style=" <?php echo $emailTemplateHelper->styles("p");?> ">
    <br />
        <strong><a href="<?php echo $email_post['login_link'];?>"><?php echo $email_post['login_link'];?></a></strong>
    </p>
</div>

<br>


<div class="top" style="font-family:arial;text-align:left;">
    <h2 style="font-size:20px;color:#464646;margin:0;"></h2>
    <span style="font-size:13px;color:#019bce;"></span>
</div>

<table border="0" style="width:100%;">
    <tr>
        <td>
        
        
            <div class="main" style="font-family:arial;text-align:left;">
            
                <table  class="rooms_details" cellpadding="5" style="border:1px solid #c4c4c4; width:100%; font-size:12px;">
                    <tr>
                        <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">
                        <strong>
                        	<span>Forgot Password</span>
                        </strong>
                        </td>
                  </tr>
                    
                    <tr class="empty_tr" height="1" >
                        <td height="1"  colspan="2" align="left" valign="middle" bgcolor="#FFFFFF" class="left" style="font-size:1px;">&nbsp;</td>
                    </tr>
                   
                    <tr>
                        <td width="35%" height="20" align="left" valign="middle" bgcolor="#019BCE" class="left" style="color: #FFF">
						Email
                        </td>
                        <td width="65%" align="left" valign="middle" bgcolor="#EEEEEE">
                        <span class="right">
							<?php echo $email_post["email"];?>
						</span>
                        </td>
                    </tr>
                    
                    <tr>
                        <td height="20" align="left" valign="middle" bgcolor="#019BCE" class="left" style="color: #FFF">
                        <span class="left">Password</span></td>
                        <td align="left" valign="middle" bgcolor="#EEEEEE">
                        <span class="right">
							<?php echo $email_post["password"];?>
                        </span>
                        </td>
                    </tr>

                    
              </table>

          </div>
        
        </td>
    </tr>



</table>