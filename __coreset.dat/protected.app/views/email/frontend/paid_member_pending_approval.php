<div style="font-size:13px;">
    <p style=" <?php echo $emailTemplateHelper->styles("p");?> ">
        <?php echo $email_post["user name"];?> (<?php echo $email_post["email address"];?>), a member registered on the IMI Portal, has just made a membership payment. Their membership is now pending your approval. Please approve/reject their membership though the IMI Portal backend.
    </p>
    
    
    <p style=" <?php echo $emailTemplateHelper->styles("p");?> ">
    <br />
        <strong><a href="<?php echo $email_post['activation_link'];?>"><?php echo $email_post['activation_link'];?></a></strong>
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
                        	<span>Details</span>
                        </strong>
                        </td>
                  </tr>
                    
                    <tr class="empty_tr" height="1" >
                        <td height="1"  colspan="2" align="left" valign="middle" bgcolor="#FFFFFF" class="left" style="font-size:1px;">&nbsp;</td>
                    </tr>
                   
                    <tr>
                        <td width="35%" height="20" align="left" valign="middle" bgcolor="#019BCE" class="left" style="color: #FFF">
						User's name
                        </td>
                        <td width="65%" align="left" valign="middle" bgcolor="#EEEEEE">
                        <span class="right">
							<?php echo $email_post["user name"];?>
						</span>
                        </td>
                    </tr>

                    <tr>
                        <td width="35%" height="20" align="left" valign="middle" bgcolor="#019BCE" class="left" style="color: #FFF">
						User's email address
                        </td>
                        <td width="65%" align="left" valign="middle" bgcolor="#EEEEEE">
                        <span class="right">
							<?php echo $email_post["email address"];?>
						</span>
                        </td>
                    </tr>

                    <tr>
                        <td width="35%" height="20" align="left" valign="middle" bgcolor="#019BCE" class="left" style="color: #FFF">
						Membership package purchased
                        </td>
                        <td width="65%" align="left" valign="middle" bgcolor="#EEEEEE">
                        <span class="right">
							<?php echo $email_post["package"];?>
						</span>
                        </td>
                    </tr>

                    <tr>
                        <td width="35%" height="20" align="left" valign="middle" bgcolor="#019BCE" class="left" style="color: #FFF">
						Amount paid
                        </td>
                        <td width="65%" align="left" valign="middle" bgcolor="#EEEEEE">
                        <span class="right">
							$<?php echo $email_post["amount"];?>
						</span>
                        </td>
                    </tr>
              </table>

          </div>
        
        </td>
    </tr>



</table>

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
                        	<span>Address (from PayPal)</span>
                        </strong>
                        </td>
                  </tr>

                    <tr class="empty_tr" height="1" >
                        <td height="1"  colspan="2" align="left" valign="middle" bgcolor="#FFFFFF" class="left" style="font-size:1px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td width="35%" height="20" align="left" valign="middle" bgcolor="#019BCE" class="left" style="color: #FFF">
						Name
                        </td>
                        <td width="65%" align="left" valign="middle" bgcolor="#EEEEEE">
                        <span class="right">
							<?php echo $email_post["address_name"];?>
						</span>
                        </td>
                    </tr>

                    <tr>
                        <td width="35%" height="20" align="left" valign="middle" bgcolor="#019BCE" class="left" style="color: #FFF">
						Street
                        </td>
                        <td width="65%" align="left" valign="middle" bgcolor="#EEEEEE">
                        <span class="right">
							<?php echo $email_post["address_street"];?>
						</span>
                        </td>
                    </tr>

                    <tr>
                        <td width="35%" height="20" align="left" valign="middle" bgcolor="#019BCE" class="left" style="color: #FFF">
						City
                        </td>
                        <td width="65%" align="left" valign="middle" bgcolor="#EEEEEE">
                        <span class="right">
							<?php echo $email_post["address_city"];?>
						</span>
                        </td>
                    </tr>

                    <tr>
                        <td width="35%" height="20" align="left" valign="middle" bgcolor="#019BCE" class="left" style="color: #FFF">
						State
                        </td>
                        <td width="65%" align="left" valign="middle" bgcolor="#EEEEEE">
                        <span class="right">
							<?php echo $email_post["address_state"];?>
						</span>
                        </td>
                    </tr>

                    <tr>
                        <td width="35%" height="20" align="left" valign="middle" bgcolor="#019BCE" class="left" style="color: #FFF">
						Country
                        </td>
                        <td width="65%" align="left" valign="middle" bgcolor="#EEEEEE">
                        <span class="right">
							<?php echo $email_post["address_country_code"];?>
						</span>
                        </td>
                    </tr>

                    <tr>
                        <td width="35%" height="20" align="left" valign="middle" bgcolor="#019BCE" class="left" style="color: #FFF">
						Zip
                        </td>
                        <td width="65%" align="left" valign="middle" bgcolor="#EEEEEE">
                        <span class="right">
							<?php echo $email_post["address_zip"];?>
						</span>
                        </td>
                    </tr>
              </table>

          </div>

        </td>
    </tr>



</table>