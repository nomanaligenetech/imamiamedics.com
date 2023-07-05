<div style="font-size:13px;">
    
    <p style=" <?php echo $emailTemplateHelper->styles("p");?> ">
      <?php echo $email_post['TEXT_p'];?>
    </p>
      
    <br />
      
    <p style=" <?php echo $emailTemplateHelper->styles("p");?> ">
		
        <table border="0" style="width:100%;">
            <tr>
                <td>There are total <?php echo $email_post['details']['success'];?> Success and <?php if($email_post['details']['failure'] > 0){ echo "<strong style='color: #f00'>";} echo $email_post['details']['failure'];?> Failures<?php if($email_post['details']['failure'] > 0){ echo "</strong>";}?>.</td>
            </tr>
            <?php 
            if($email_post['details']['success'] > 0){?>
            <tr>
            <td>
                
                <div class="main" style="font-family:arial;text-align:left;">
                
                    <table  class="rooms_details" cellpadding="5" style="border:1px solid #c4c4c4; width:100%; font-size:12px;">
                      <tr>
                        <td align="center" bgcolor="#465056" class="heading" style="color: #FFF" rowspan="<?php echo ($email_post['details']['success']+1); ?>">Success</td>
                        <td align="center" bgcolor="#465056" class="heading" style="color: #FFF">Name</td>
                        <td align="center" bgcolor="#465056" class="heading" style="color: #FFF">Amount</td>
                        <td align="center" bgcolor="#465056" class="heading" style="color: #FFF">Reference No</td>
                        <td align="center" bgcolor="#465056" class="heading" style="color: #FFF">Payment No</td>
                      </tr>
                      <?php foreach($email_post['details']["successdata"] as $singleData){ ?>
                      <tr>
                        <td><?php echo $singleData['name'];?></td>
                        <td><?php echo $singleData['amount'];?></td>
                        <td><?php echo $singleData['auth'];?></td>
                        <td>Schedule Payment # <?php echo $singleData['payment_no'];?></td>
                      </tr>
                      <?php } ?>
                                                  
                    </table>
    
              </div>
            
            </td>
            </tr>
            <?php }
            if($email_post['details']['failure'] > 0){?>
            <tr>
            <td>
                
                <div class="main" style="font-family:arial;text-align:left;">
                
                    <table  class="rooms_details" cellpadding="5" style="border:1px solid #c4c4c4; width:100%; font-size:12px;">
                      <tr>
                        <td align="center" bgcolor="#465056" class="heading" style="color: #FFF" rowspan="<?php echo ($email_post['details']['failure']+1); ?>">Failure</td>
                        <td align="center" bgcolor="#465056" class="heading" style="color: #FFF">Name</td>
                        <td align="center" bgcolor="#465056" class="heading" style="color: #FFF">Amount</td>
                        <td align="center" bgcolor="#465056" class="heading" style="color: #FFF">Error</td>
                        <td align="center" bgcolor="#465056" class="heading" style="color: #FFF">Cancel Recurring</td>
                        <td align="center" bgcolor="#465056" class="heading" style="color: #FFF">Payment No</td>
                      </tr>
                      <?php foreach($email_post['details']["faildata"] as $singleData){ ?>
                      <tr>
                        <td><?php echo $singleData['name'];?></td>
                        <td><?php echo $singleData['amount'];?></td>
                        <td><?php echo $singleData['error'];?></td>
                        <td><a href="<?php echo $singleData['cancel_url'];?>">Cancel Recurring</a></td>
                        <td>Schedule Payment # <?php echo $singleData['payment_no'];?></td>
                      </tr>
                      <?php } ?>
                                                  
                    </table>
    
              </div>
            
            </td>
            </tr>
            <?php } ?>
		</table>
             
    </p>
    
    
</div>