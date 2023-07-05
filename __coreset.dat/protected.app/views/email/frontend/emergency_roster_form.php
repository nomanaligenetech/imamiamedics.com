<div style="font-size:13px;">
    
    <p style=" <?php echo $emailTemplateHelper->styles("p");?> ">
        Thank you for submitting Emergency Roster Form.
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
                            	<td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Address:</td>
                                <td><?php echo nl2br( $email_post['address'] ); ?></td>
                          	</tr>
                            
                            <tr>
                            	<td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Contact Number: </td>
                                <td><?php echo $email_post['contact_number']; ?></td>
                          	</tr>
                            
                            <tr>
                            	<td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Email:</td>
                                <td><?php echo $email_post['email']; ?></td>
                          	</tr>
                            
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Occupation:</td>
                              <td><?php echo $email_post['occupation']; ?></td>
                            </tr>
                            <tr>
                            	<td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Specialty:</td>
                                <td><?php echo ( $email_post['specialities'] ); ?></td>
                          	</tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Citizenship:</td>
                              <td><?php echo ( $email_post['citizenship'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Date of Birth:</td>
                              <td><?php echo date("d-m-Y", strtotime( $email_post['date_of_birth'] ) ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Passport Number:</td>
                              <td><?php echo ( $email_post['passport_number'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Date of Issue:</td>
                              <td><?php echo date("d-m-Y", strtotime( $email_post['date_of_issue'] ) ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Place of Issue:</td>
                              <td><?php echo ( $email_post['place_of_issue'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Date of Expiration:</td>
                              <td><?php echo date("d-m-Y", strtotime( $email_post['date_of_expiration'] ) ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Marital Status</td>
                              <td><?php echo ( $email_post['marital_status'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">T-shirt Size:</td>
                              <td><?php echo ( $email_post['tshirt_size'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Why to go on Emergency Relief Mission:</td>
                              <td><?php echo nl2br( $email_post['question_why_to_go_on_emer_relief_mission'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Time to take off short notice:</td>
                              <td><?php echo nl2br( $email_post['question_time_to_take_off_short_notice'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Foreign Language Skills:</td>
                              <td><?php echo nl2br( $email_post['question_foreign_language_skills'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Any other skills:</td>
                              <td><?php echo nl2br( $email_post['question_any_other_skills'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Attended Emergency Relief Before:</td>
                              <td><?php echo nl2br( $email_post['question_attended_emer_relief_before'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Any difficulty in foreign country:</td>
                              <td><?php echo nl2br( $email_post['question_any_difficulty_in_foreign_country'] ); ?></td>
                            </tr>
                            <?php if ( $email_post['medical_physical_status'] == 1 ){
                                ?>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Medical Physical Reason:</td>
                              <td><?php echo nl2br($email_post['medical_physical_reason']); ?></td>
                            </tr>
                            <?php
                            }?>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">List any Medications:</td>
                              <td><?php echo nl2br( $email_post['list_any_medications'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">List any Allergies:</td>
                              <td><?php echo nl2br( $email_post['list_any_allergies'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">
                              <span class="heading" style="color: #FFF"><strong>Primary Emergency Contact </strong></span></td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Name:</td>
                              <td><?php echo ( $email_post['primary_emer_contact_name'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Relationship:</td>
                              <td><?php echo ( $email_post['primary_emer_contact_relationship'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Address:</td>
                              <td><?php echo nl2br( $email_post['primary_emer_contact_address'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Telephone:</td>
                              <td><?php echo ( $email_post['primary_emer_contact_telephone'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Email:</td>
                              <td><?php echo ( $email_post['primary_emer_contact_email'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">
                              <span class="heading" style="color: #FFF"><span class="heading" style="color: #FFF"><strong>Secondary Emergency Contact </strong></span></span>
                              </td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Name:</td>
                              <td><?php echo ( $email_post['secondary_emer_contact_name'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Relationship:</td>
                              <td><?php echo ( $email_post['secondary_emer_contact_relationship'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Address:</td>
                              <td><?php echo nl2br( $email_post['secondary_emer_contact_address'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Telephone:</td>
                              <td><?php echo ( $email_post['secondary_emer_contact_telephone'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Email:</td>
                              <td><?php echo ( $email_post['secondary_emer_contact_email'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Short Biography:</td>
                              <td><?php echo nl2br( $email_post['short_biography'] ); ?></td>
                            </tr>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Resume:</td>
                              <td><a href="<?php echo base_url( $email_post['resume'] ); ?>">click here</a> to download</td>
                            </tr>
                            
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Passport:</td>
                              <td><a href="<?php echo base_url( $email_post['passport'] ); ?>">click here</a> to download</td>
                            </tr>
                            
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Photo Image:</td>
                              <td><a href="<?php echo base_url( $email_post['photo_image'] ); ?>">click here</a> to download</td>
                            </tr>
                            <?php if ( $email_post['signature'] != "" ) {?>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Signature:</td>
                              <td><a href="<?php echo site_url()."assets/files/emergency_roster/".$email_post['signature']; ?>" target="_blank" download="download">click here</a> to download</td>
                            </tr>
                            <?php }?>
                            <?php if ( $email_post['parent_signature'] != "" ) {?>
                            <tr>
                              <td height="20" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Parent Signature:</td>
                              <td><a href="<?php echo site_url()."assets/files/emergency_roster/".$email_post['parent_signature']; ?>" target="_blank"  download="download">click here</a> to download</td>
                            </tr>
                            <?php }?>
                            
                      	</table>
        
                  </div>
                
                </td>
            </tr>

		</table>
             
    </p>
    
    
</div>