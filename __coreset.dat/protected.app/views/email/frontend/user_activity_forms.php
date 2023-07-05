<div style="font-size:13px;">
    <p style=" <?php echo $emailTemplateHelper->styles("p");?> ">
        <?php echo $email_post["email_message"];?>
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
                        	<span><?php echo lang_line("txt_details");?></span>
                        </strong>
                        </td>
                  </tr>
                    
                    <tr class="empty_tr" height="1" >
                        <td height="1"  colspan="2" align="left" valign="middle" bgcolor="#FFFFFF" class="left" style="font-size:1px;">&nbsp;</td>
                    </tr>
                   
                    <tr>
                        <td width="35%" height="20" align="left" valign="middle" bgcolor="#019BCE" class="left" style="color: #FFF">
						<?php echo lang_line("text_subactivity");?>
                        </td>
                        <td width="65%" align="left" valign="middle" bgcolor="#EEEEEE">
                        <span class="right">
							<?php echo $email_post["txt_name"];?>
						</span>
                        </td>
                    </tr>
                    
                    <tr>
                        <td height="20" align="left" valign="middle" bgcolor="#019BCE" class="left" style="color: #FFF">
                        <span class="left">
							<?php echo lang_line("text_noofpeople");?>
                        </span>
                        </td>
                        <td align="left" valign="middle" bgcolor="#EEEEEE">
                        <span class="right">
							<?php echo $email_post["dd_num_people"];?>
                        </span>
                        </td>
                    </tr>
                    
                    <tr>
                        <td  height="20" align="left" valign="middle" bgcolor="#019BCE" class="left" style="color: #FFF">
                        <span class="left">
							<?php echo lang_line("text_name");?>
                        </span>
                        </td>
                        <td align="left" valign="middle" bgcolor="#EEEEEE">
                        <?php echo $email_post["txt_name"];?>
                        </td>
                    </tr>
                    
                    <tr>
                        <td  height="20" align="left" valign="middle" bgcolor="#019BCE" class="left" style="color: #FFF">
                            <?php echo lang_line("text_emailaddress");?>
                        </td>
                        <td align="left" valign="middle" bgcolor="#EEEEEE">
                            <?php echo $email_post["txt_email"] ;?>        
                        </td>
                    </tr>
                    <tr>
                      <td  height="20" align="left" valign="middle" bgcolor="#019BCE" class="left" style="color: #FFF"><span class="left"> <?php echo lang_line("text_cellphone");?> </span></td>
                      <td align="left" valign="middle" bgcolor="#EEEEEE"><?php echo $email_post["txt_cell"];?></td>
                    </tr>
                    <tr>
                      <td  height="20" align="left" valign="middle" bgcolor="#019BCE" class="left" style="color: #FFF"><span class="left"> <?php echo lang_line("text_hotelsforpickup");?> </span></td>
                      <td align="left" valign="middle" bgcolor="#EEEEEE"><?php echo $email_post["txt_hotelm"];?></td>
                    </tr>
                    <tr>
                      <td  height="20" align="left" valign="middle" bgcolor="#019BCE" class="left" style="color: #FFF"><span class="left"> <?php echo lang_line("text_desireddate");?> </span></td>
                      <td align="left" valign="middle" bgcolor="#EEEEEE"><?php echo $email_post["txt_date"];?></td>
                    </tr>
                    <tr>
                      <td  height="20" align="left" valign="middle" bgcolor="#019BCE" class="left" style="color: #FFF"><span class="left"> <?php echo lang_line("text_desiredtime");?> </span></td>
                      <td align="left" valign="middle" bgcolor="#EEEEEE"><?php echo $email_post["dd_time"];?></td>
                    </tr>
                    <tr>
                      <td  height="20" align="left" valign="middle" bgcolor="#019BCE" class="left" style="color: #FFF"><span class="left"> <?php echo lang_line("text_additionalrequest");?> </span></td>
                      <td align="left" valign="middle" bgcolor="#EEEEEE"><?php echo nl2br( $email_post["txt_additional"] );?></td>
                    </tr>
              </table>

          </div>
        
        </td>
    </tr>



</table>