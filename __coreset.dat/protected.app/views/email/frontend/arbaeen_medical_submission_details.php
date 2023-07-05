<p style=" <?php echo $emailTemplateHelper->styles("p"); ?> ">

        <table border="0" style="width:100%;">
            <tr>
                <td>

                    <div class="main" style="font-family:arial;text-align:left;">

                        <table class="rooms_details" cellpadding="5" style="border:1px solid #c4c4c4; width:100%; font-size:12px;">
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

                            <?php if(isset($email_post['other_name']) && $email_post['other_name'] != ""){?>
                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Name you prefer to be called by others (if not your legal name): </td>
                                <td><?php echo $email_post['other_name']; ?></td>
                            </tr>
                            <?php } ?>

                            <?php if(isset($email_post['street_address']) && $email_post['street_address'] != ""){?>
                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Street Address: </td>
                                <td><?php echo $email_post['street_address']; ?></td>
                            </tr>
                            <?php } ?>

                            <?php if ($email_post['street_address_2'] != "") { ?>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Street Address 2: </td>
                                <td><?php echo $email_post['street_address_2']; ?></td>
                            </tr>

                            <?php } ?>

                            <?php if(isset($email_post['city']) && $email_post['city'] != ""){?>
                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">City: </td>
                                <td><?php echo $email_post['city']; ?></td>
                            </tr>
                            <?php } ?>

                            <?php if(isset($email_post['region']) && $email_post['region'] != ""){?>
                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Region: </td>
                                <td><?php echo $email_post['region']; ?></td>
                            </tr>
                            <?php } ?>

                            <?php if(isset($email_post['postal_code']) && $email_post['postal_code'] != ""){?>
                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Postal/Zip Code: </td>
                                <td><?php echo $email_post['postal_code']; ?></td>
                            </tr>
                            <?php } ?>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Country: </td>
                                <td><?php echo $email_post['country']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Email: </td>
                                <td><?php echo $email_post['email']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Phone: </td>
                                <td><?php echo $email_decrypted['phone_number']; ?></td>
                            </tr>

                            
                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Occupation: </td>
                                <td><?php echo $email_post['occupation']; ?></td>
                            </tr>
                            
                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">CV/Resume : </td>
                                <td><?php echo '<a href="' . site_url() . 'assets/files/arbaeen-mission/' . $email_post['cv_resume'] . '" style="font-weight:bold" download="download">click here</a> to download'; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Brief information regarding any health history/current conditions/allergies AND personal physical & mental fitness self-assessment: </td>
                                <td><?php echo $email_post['health_his']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Citizenship: </td>
                                <td><?php echo $email_post['citizenship']; ?></td>
                            </tr>
                                                        
                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Date of Birth: </td>
                                <td><?php echo $email_decrypted['birth_date']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Passport Number: </td>
                                <td><?php echo $email_decrypted['passportno']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Date of Expiration: </td>
                                <td><?php echo $email_decrypted['passport_expiry']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Passport Copy : </td>
                                <td><?php echo '<a href="' . site_url() . 'assets/files/arbaeen-mission/' . $email_post['passport_copy'] . '" style="font-weight:bold" download="download">click here</a> to download'; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Passport Sized Photograph : </td>
                                <td><?php echo '<a href="' . site_url() . 'assets/files/arbaeen-mission/' . $email_post['passport_pic'] . '" style="font-weight:bold" download="download">click here</a> to download'; ?></td>
                            </tr>
                            
                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">I agree to the personal covenant and liability form and agree to abide by all rules and processes of IMI. : </td>
                                <td><?php echo $email_post['agree_terms'] == 1 ? 'yes' : $email_post['agree_terms']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Digital Signature : </td>
                                <td><?php echo '<a href="' . site_url() . 'assets/files/arbaeen-mission/' . $email_post['signature'] . '" style="font-weight:bold" download="download">click here</a> to download'; ?></td>
                            </tr>

                        </table>

                    </div>

                </td>
            </tr>

        </table>

    </p>