<p style=" <?php echo $emailTemplateHelper->styles("p");?> ">
	<?php echo sprintf(lang_line("text_contactus_message"), "<strong>".$email_post["txt_name"] . "</strong>" ) ;?>
</p>
<br>


<div class="top" style="font-family:arial;text-align:left;">
    <h2 style="font-size:20px;color:#464646;margin:0;"></h2>
    <span style="font-size:13px;color:#019bce;"></span>
    <!--<h3 style="font-size:15px;color:#838282;border-bottom:1px solid #dadada;padding:18px 0 12px 0;margin:0;">Reservation ID: RI4986782</h3>-->
</div>

<table border="0" style="width:100%;">
    <tr>
        <td>
        
        
            <div class="main" style="font-family:arial;text-align:left;">
            
                <!--<table width="100%" class="details_table" cellspacing="3" cellpadding="5">
                    
                    <tr>
                        <td width="25%" height="20" align="center" valign="middle" bgcolor="#464646" class="heading" style="color: #FFF;">
                        <strong><span>Booking Status</span>
                        </strong></td>
                        <td width="25%" align="center" valign="middle" bgcolor="#464646" class="heading" style="color: #FFF"><strong><span>Check In</span></strong></td>
                        <td width="25%" align="center" valign="middle" bgcolor="#464646"  class="heading" style="color: #FFF"><strong><span>Check Out</span></strong></td>
                        <td width="25%" align="center" valign="middle" bgcolor="#464646"  class="heading" style="color: #FFF"><strong><span>Board Type</span></strong></td>
                    </tr>
                    
                    <tr>
                        <td height="41" align="center" valign="middle" bgcolor="#EEEEEE">Confirmed, Unpaid</td>
                        <td align="center" valign="middle" bgcolor="#EEEEEE">October 16, 2014</td>
                        <td align="center" valign="middle" bgcolor="#EEEEEE">October 18, 2014</td>
                        <td align="center" valign="middle" bgcolor="#EEEEEE">Bed and Ext. Continental Breakfast</td>
                    </tr>
                    
                    <tr>
                        <td height="20" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                        <td valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                        <td colspan="2" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
                    </tr>
                </table>-->
            
            
                <table  class="rooms_details" cellpadding="5" style="border:1px solid #c4c4c4; width:100%; font-size:12px;">
                    <tr>
                        <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">
                        <strong>
                        	<span><?php echo lang_line("txt_details");?></span>
                        </strong>
                        </td>
                  </tr>
                    
                    <tr class="empty_tr" height="1" >
                        <td height="1"  colspan="2" align="left" valign="middle" bgcolor="#FFFFFF" class="left" style="font-size:1px;">&nbsp;</td>
                    </tr>
                   
                    <tr>
                        <td width="29%" height="20" align="left" valign="middle" bgcolor="#019BCE" class="left" style="color: #FFF">
						Name
                        </td>
                        <td width="71%" align="left" valign="middle" bgcolor="#EEEEEE">
                        <span class="right">
							<?php echo $email_post["txt_name"];?>
						</span>
                        </td>
                    </tr>
                    
                    <tr>
                        <td height="20" align="left" valign="middle" bgcolor="#019BCE" class="left" style="color: #FFF">
                        <span class="left">
							Email
                        </span>
                        </td>
                        <td align="left" valign="middle" bgcolor="#EEEEEE">
                        <span class="right">
							<?php echo $email_post["txt_email"];?>
                        </span>
                        </td>
                    </tr>
                    
                    <tr>
                        <td  height="20" align="left" valign="middle" bgcolor="#019BCE" class="left" style="color: #FFF">
                        <span class="left">
							Subject
                        </span>
                        </td>
                        <td align="left" valign="middle" bgcolor="#EEEEEE">
                        <?php echo $email_post["txt_subject"];?>
                        </td>
                    </tr>
                    
                    <tr>
                        <td  height="20" align="left" valign="middle" bgcolor="#019BCE" class="left" style="color: #FFF">
                            Inquiries
                        </td>
                        <td align="left" valign="middle" bgcolor="#EEEEEE">
                            <?php echo nl2br( $email_post["txt_text"] ) ;?>        
                        </td>
                    </tr>
              </table>

          </div>
        
        </td>
    </tr>



</table>