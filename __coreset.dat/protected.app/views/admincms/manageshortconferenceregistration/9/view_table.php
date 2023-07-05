<table id="tbl_records"  class="table table-bordered table-striped bSortable">
        <thead>
            <tr>
            
                <!--<th style="width:10px" ><?php #echo form_checkbox( array("name" => "select_all", "class" => "flat-red") );?></th>-->
                <?php
                foreach ($table_properties["tr_heading"] as $trheading)
                {
					
					$_width					= "";
					if ( $trheading == "Name" )
					{
						$_width				= "width:340px";
					}
					else if ( $trheading  == "Registered By")
					{
						$_width				= "width:150px";
					}
					else if ( $trheading  == "Registered As")
					{
						$_width				= "width:150px";
					}
					else if ( $trheading  == "Registered For")
					{
						$_width				= "width:150px";
					}
					else if ( $trheading  == "Member Package")
					{
						$_width				= "width:100px";
					}
                    ?>
                        
                        <th style=" <?php echo $_width;?>"><?php echo $trheading;?></th>
                        
                    <?php	
                }
                ?>
                <th style=" width:170px;" ><?php echo lang_line("text_option");?></th>
            </tr>
        </thead>
        
        <tbody>
            <?php
			
			$TMP_imi_or_nonimi = DropdownHelper::conferenceregistration_paymenttype();
			
            foreach ( $table_record as $key => $row )
            {						
						
                ?>
                    <tr>
                        <!--<td><?php #echo form_checkbox( array("name" => "checkbox_options[]", "value" => $row["id"]) );?></td>-->
                        <!--<td><?php #echo $row["conference_name"];?></td>-->
                        <td>
						<?php 
						echo $row["full_name"];
						if ( $row["parentid"] == 0)
						{
							echo ' <strong>('. $this->queries->fetch_records("short_conference_registration_screen_three", 
																			 " AND parentid = '". $row["id"] ."' AND screen_one_detail_id IN (SELECT id FROM `tb_short_conference_registration_screen_one_family_details` WHERE parentid IN (SELECT id FROM `tb_short_conference_registration_screen_one` WHERE conferenceregistrationid = tb_short_conference_registration_screen_three.conferenceregistrationid)) ")->num_rows() . ')</strong>';
						}
						?>
                        
                        </td>
                        
                        <td><?php echo DropdownHelper::short_conferenceregistration_guestfamilyguest( $row['parentid'] );?></td>
                        <td>
						<div style="display:none;">
							<?php echo form_checkbox( array("name" => "checkbox_options[]", "value" => $row["id"], "checked" => "checked") ); ?>
                        </div>
                        
                        
						<?php
                        echo $row["user_name"];
						if($row["parentid"] == 0)
						{
							echo '<br><strong style="color:#008d4c">('. $row['VIEW_email'] .')</strong><br><strong style="color:#008d4c">'. $row['VIEW_phone'] .'</strong>';	
							
							$TMP_users			= $this->db->query("SELECT * FROM tb_users WHERE id = '". $row['userid'] ."' ");
                            if ( $TMP_users -> num_rows() > 0 )
                            {
                                echo '<br />'.$this->encrption->decrypt( $TMP_users->row('password') );
                            }
						}
						else
						{
							echo '<br><strong style="color:steelblue">('. $row['VIEW_email'] .')</strong>';	
						}
						
						?>
                        </td>
                        
                     	
                        <td><?php echo $row['family_relationship'];?></td>
                        <td><?php echo $row['VIEW_date_added'];?></td>
                        
                        <td><?php echo $row['VIEW_email_screen_3'];?></td>
                        <td><?php echo $row['VIEW_phone_screen_3'];?></td>
                        
                        
                        <td><?php echo $row['VIEW_total_price'];?></td>
                        <td><?php echo $row['VIEW_coupon_code'];?></td>
                        <td><?php echo $row['VIEW_be_a_member_fee_desc'];?></td>
                        
                        <td><?php echo $row['VIEW_payment_type'];?></td>
                        <td><?php echo $row['VIEW_is_paid_name'];?></td>
                        
                       
                        <td>
                        
                        	<?php echo $this->load->view("admincms/manageshortconferenceregistration/9/view_registration_prices", $data = array('row' => $row)); ?>
						
                        </td>
                        
                        
                        
                        <td align="center">
                        
                        <?php
						if ( $row['VIEW_need_to_change_status'] )
						{
						?>
                            <input data-operation="ajax_change_payment_status" type="button" class="btn btn-vk btn-sm submit_btn_form" 
                            value="Mark as paid" data-confregistrationmasterid='<?php echo $row['conferenceregistrationid'];?>'  />
                            <br /><br />
                        <?php
						}
						?>
                        
                        <a href="<?php echo site_url( $_directory . "controls/edit/" . $row["id"]);?>">
                            <input type="button" class="btn btn-success btn-sm" value="<?php echo lang_line("text_view");?>"  />
                        </a>
                        
                        <a href="<?php echo site_url( $_directory . "controls/update/" . $row["id"]);?>">
                            <input type="button" class="btn btn-success btn-sm" value="<?php echo lang_line("text_edit");?>"  />
                        </a>
                        
                        <?php
						if ( $row["travelling_with"] == 'independently'  and $row['VIEW_screen_5'] )
						{
							?>
                            <br /><br />
                            <a class="btn-sm btn-danger" 
                            onclick="_runtimePopup('modalUrl_80perc', '<?php echo site_url( "admincms/manageshortconferenceregistration/controls/display_screen_5/" . $row["id"] );?>')" 
                            href="javascript:;" >
                            	View<i class="fa fa-fw fa-plane"></i>
                            </a>
                            <?php
						}
						?>
                        

                        </td>
                    </tr>
                <?php
            }
            ?>
        </tbody>
        <tfoot>
        </tfoot>
    </table>