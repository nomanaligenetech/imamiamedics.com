<div style="font-size:13px;">
    <table width="600" border="0" align="center">
        <tr>
            <td>
                <p style=" <?php echo $emailTemplateHelper->styles("p");?> "><img width="600" alt="Thank you purchasing tickets. Sham-e-Adab" src="https://imamiamedics.com/assets/editor_images/file/sham-e-adab-event-page-image-3.png" /></p>
                <p style=" <?php echo $emailTemplateHelper->styles("p");?> ">Dear <?php echo !empty($email_post['event_email_name']) ? $email_post['event_email_name'] : '';?>,</p>
                <p style=" <?php echo $emailTemplateHelper->styles("p");?> "><strong>Thank you for purchasing tickets for IMI's January 1, 2022 Sham-e-Adab Meet & Greet New Jersey, featuring Dr. Azra Raza, Dr. Fozia Qamar and Dr. Zafar N. Naqvi.</strong> Please show this email to check-in at the event. Please also bring your ID and proof of COVID-19 vaccination to the event with you (or you can submit proof of vaccination in advance via email to <a href="mailto:imihq@imamiamedics.com">IMIHQ@imamiamedics.com</a> for a faster check-in process).</p>
                <div style="padding: 5px 10px;background-color: #edd5d5;">
                    <h2>Order Details</h2>
                    <p style=" <?php echo $emailTemplateHelper->styles("p");?> "><strong><?php echo !empty($email_post['event_email_date']) ? $email_post['event_email_date'] : '';?></strong></p>
                    <p style=" <?php echo $emailTemplateHelper->styles("p");?> ">
                        <strong>Name:</strong> <?php echo !empty($email_post['event_email_name']) ? $email_post['event_email_name'] : '';?> <br>
                        <strong>Phone:</strong> <?php echo !empty($email_post['event_email_phone']) ? $email_post['event_email_phone'] : '';?> <br>
                        <strong><?php echo !empty($email_post['event_email_seats']) ? $email_post['event_email_seats'] : '';?>:</strong> <?php echo !empty($email_post['event_email_package']) ? $email_post['event_email_package'] : '';?> <br>
                        <strong>Amount:</strong> $<?php echo !empty($email_post['event_email_amount']) ? $email_post['event_email_amount'] : '';?> <br>
                    </p>
                    <p style="text-align: center;">
                        (Please note: Children under 3 are free and don't require tickets, but please email us at <a href="mailto:imihq@imamiamedics.com">imihq@imamiamedics.com</a> in advance so we can ensure space is appropriated reserved.)
                    </p>
                </div>
                <p style="text-align: center;"><a href="http://tinyurl.com/sham-e-adab">Click here for event details including COVID-19 protocols</a></p>
                
                <h2>Follow us on Social Media</h2>
                <p style=" <?php echo $emailTemplateHelper->styles("p");?> ">
                    Don't forget to follow/connect with IMI via social media to see details and coverage of the event: <a href="https://www.facebook.com/ImamiaMedics" >Facebook</a> | <a href="https://twitter.com/IMI_HQ" >Twitter</a> | <a href="https://www.instagram.com/imamiamedicsinternational/" >Instagram</a> | <a href="https://www.youtube.com/c/ImamiaMedicsInternational" >YouTube</a></p>
                <h2>Questions?</h2>
                <p style=" <?php echo $emailTemplateHelper->styles("p");?> ">Feel free to contact our event organizers via email at <a href="mailto:imihq@imamiamedics.com">imihq@imamiamedics.com</a>, host committee members listed below or IMI HQ: Reza Jawad - (609) 481-9267 or Mehvesh Bilgrami (202) 705-3700.
                
                <table width="100%" border="0">
                    <tr>
                        <td>
                            <ul>
                                <li>Dr. Farheen Fahim - (973) 747-2879</li>
                                <li>Dr. Hadiqa Batool - (334) 625-9587</li>
                                <li>Dr. Huma Naqvi - (917) 891-2360</li>
                                <li>Mrs. Malika Jafri - (908) 425-7004</li>
                                <li>Mrs. Qurat Rizvi - (845) 598-7180</li>
                                <li>Mrs. Rashida Jafri - (201) 638-6458</li>
                                <li>Mrs. Shahla Rupani - (609) 635-9345</li>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                <li>Mrs. Uzma Rizvi - (609) 468-2505</li>
                                <li>Ms. Erum Ladak - (848) 391-7573</li>
                                <li>Ms. Erum Akhtar - (845) 729-8812</li>
                                <li>Mona Moosavi - (856) 220-5976</li>
                                <li>Nasreen Rizvi - (917) 887-7772</li>
                                <li>Ms. Amber Mohsin - (973) 464-8341</li>
                                <li>Shamila Jafri - (203) 554-9467</li>
                            </ul>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>      
    <br />
</div>