<div style="font-size:13px;">
    <?php $name = $email_post["first_name"] . ' ' . $email_post["middle_name"] . ' ' . $email_post["last_name"]; ?>
    <p style=" <?php echo $emailTemplateHelper->styles("p"); ?> ">
        <b><?php echo $name; ?></b> has submit stage 3 form for Arbaeen Medical Mission. Below are the details.
    </p>

    <br />

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

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Email: </td>
                                <td><?php echo $email_post['email']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Phone: </td>
                                <td><?php echo $email_post['phone_number']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Biography: </td>
                                <td><?php echo $email_post['biography']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Citizenship: </td>
                                <td><?php echo $email_post['citizenship']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Passport Number: </td>
                                <td><?php echo $email_post['passport_number']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Passport Issue Date: </td>
                                <td><?php echo $email_post['passport_issue_date']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Passport Expiry Date: </td>
                                <td><?php echo $email_post['passport_expiry_date']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Passport Issue Place: </td>
                                <td><?php echo $email_post['passport_issue_place']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Date of Birth: </td>
                                <td><?php echo $email_post['birth_date']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Place of Birth: </td>
                                <td><?php echo $email_post['birth_place']; ?></td>
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
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Primary Emergency First Name: </td>
                                <td><?php echo $email_post['emergency_primary_first_name']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Primary Emergency Last Name: </td>
                                <td><?php echo $email_post['emergency_primary_last_name']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Primary Emergency Email: </td>
                                <td><?php echo $email_post['emergency_primary_email']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Primary Emergency Phone: </td>
                                <td><?php echo $email_post['emergency_primary_phone']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Primary Emergency Street Address: </td>
                                <td><?php echo $email_post['emergency_primary_address']; ?></td>
                            </tr>

                            <?php if ($email_post['emergency_primary_address_2'] != "") { ?>

                                <tr>
                                    <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Primary Emergency Street Address 2: </td>
                                    <td><?php echo $email_post['emergency_primary_address_2']; ?></td>
                                </tr>

                            <?php
                            } ?>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Primary Emergency City: </td>
                                <td><?php echo $email_post['emergency_primary_city']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Primary Emergency State: </td>
                                <td><?php echo $email_post['emergency_primary_state']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Primary Emergency Postal/Zip Code: </td>
                                <td><?php echo $email_post['emergency_primary_postal_code']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Primary Emergency Country: </td>
                                <td><?php echo $email_post['emergency_primary_country']; ?></td>
                            </tr>
                            
                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Secondary Emergency First Name: </td>
                                <td><?php echo $email_post['emergency_secondary_first_name']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Secondary Emergency Last Name: </td>
                                <td><?php echo $email_post['emergency_secondary_last_name']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Secondary Emergency Email: </td>
                                <td><?php echo $email_post['emergency_secondary_email']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Secondary Emergency Phone: </td>
                                <td><?php echo $email_post['emergency_secondary_phone']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Secondary Emergency Street Address: </td>
                                <td><?php echo $email_post['emergency_secondary_address']; ?></td>
                            </tr>

                            <?php if ($email_post['emergency_secondary_address_2'] != "") { ?>

                                <tr>
                                    <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Secondary Emergency Street Address 2: </td>
                                    <td><?php echo $email_post['emergency_secondary_address_2']; ?></td>
                                </tr>

                            <?php
                            } ?>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Secondary Emergency City: </td>
                                <td><?php echo $email_post['emergency_secondary_city']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Secondary Emergency State: </td>
                                <td><?php echo $email_post['emergency_secondary_state']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Secondary Emergency Postal/Zip Code: </td>
                                <td><?php echo $email_post['emergency_secondary_postal_code']; ?></td>
                            </tr>

                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Secondary Emergency Country: </td>
                                <td><?php echo $email_post['emergency_secondary_country']; ?></td>
                            </tr>
                            
                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Program Cost: </td>
                                <td><?php echo $email_post['program_cost']; ?></td>
                            </tr>
                            
                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Additional Donation: </td>
                                <td><?php echo $email_post['additional_donation']; ?></td>
                            </tr>
                            
                            <tr>
                                <td height="20" colspan="2" align="left" valign="middle" bgcolor="#465056" class="heading" style="color: #FFF">Accomodation Option: </td>
                                <td><?php echo $email_post['accomodation_option']; ?></td>
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


</div>