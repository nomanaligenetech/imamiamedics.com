<table id="tbl_records"  class="table table-bordered table-striped bSortable">
        <thead>
            <tr>
            
                <!--<th style="width:10px" ><?php #echo form_checkbox( array("name" => "select_all", "class" => "flat-red") );?></th>-->
                <?php
                foreach ($table_properties["tr_heading"] as $trheading)
                {
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
			
			$TMP_imi_or_nonimi = DropdownHelper::short_conferenceregistration_paymenttype();
			
            foreach ( $table_record as $key => $row )
            {	
                $total_amount = $row['donate_amount'] + $row['package_amount'];
                $country      = !empty($row['belongsto']) ? ' ('. $row['belongsto'].')' : '';
                	
                ?>
                    <tr>
                        <td>
                        <div style="display:none;">
							<?php echo form_checkbox( array("name" => "checkbox_options[]", "value" => $row["id"], "checked" => "checked") ); ?>
                        </div>
						<?php 
						echo $row["name"];
						?>
                        
                        </td>
                        <td><?php echo $row['email'];?></td>

                        <td><?php echo $row['address'].$country;?></td>

                        <td><?php echo $row['purpose'];?><br><?php echo $row['dpdesc'];?></td>
                        
                        <td><?php echo $row['payment_mode'] == 'card' ? 'payeezy' : $row['payment_mode'];?></td>
                        
                        <td><?php echo $total_amount;?></td>

                        <td><?php echo $row['Date']; ?></td>

                        <td>
                        <?php 
                            $TMP_receipt_table = (object)[];

                            if( $row['purpose'] == 'Membership Registration' ){
                                $TMP_receipt_table	= $this->db->query("SELECT receipt_number, receipt_prefix FROM tb_payment_receipts WHERE table_name = 'tb_user_memberships' AND table_id_value = '". $row['id'] ."' ");
                            }

                            // $row
                            if(  ( !empty($row["tax_receipt_num"] && $row["tax_receipt_num"] != NULL) ) || (property_exists($TMP_receipt_table, 'num_rows') && $TMP_receipt_table->num_rows() > 0) ) {  ?>
                                <a class="btn btn-success btn-sm" href="<?php echo site_url( $_directory . "controls/receipt/" . $row["id"]) ."/".strtolower(str_replace(' ', '', $row['purpose']));   ?>" data-operationid="allreportsreceipt">Download</a>
                            <?php } else {
                                echo ('N/A');
                            } ?>
                        </td>
                        
                        <td align="center">
                        <?php
                        $purpose = $row['purpose'] == 'Donation' ? '?p=donation' : '?p=shortconference'; 
                        if($row['purpose'] == 'Membership Registration'){
                            $site_url = '/admincms/managemembers/controls/edit/'  . $row["dpid"];
                        }
                        else{
                            $site_url = $_directory . "controls/edit/" . $row["dpid"] . $purpose;
                        }
                       
                        ?>
                        <a href="<?php echo site_url( $site_url ) ;?>">
                            <input type="button" class="btn btn-success btn-sm" value="<?php echo lang_line("text_view");?>"  />
                        </a>
                        
                        </td>
                    </tr>
                <?php
            }
            ?>
        </tbody>
        <tfoot>
        </tfoot>
    </table>