<!-- Adcance search start  -->
<div class="col-sm-12">
        <a class="btn btn-primary" href="http://localhost/imamiamedics.com/admincms/manageallreports/controls/advancesearchallreports" style="float: right;" target="_blank">Advance Search</a>
</div>
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
            </tr>
        </thead>
        
        <tbody>
            <?php
			
            foreach ( $table_record as $key => $row )
            {	
                // echo'<pre>';
                // print_r($row);
                // echo'</pre>';
                ?>
                    <tr>
                        <td>
                        <div style="display:none;">
							<?php echo form_checkbox( array("name" => "checkbox_options[]", "value" => $row["id"], "checked" => "checked") ); ?>
                        </div>
						<?php 
						echo $row["card_holder_name"];
						?>
                        
                        </td>
                        <td><?php echo $row['full_name'];?></td>

                        <td><?php echo $row['transaction_amount']?></td>
                        
                        <td><?php echo $row['date'];?></td>
                        
                        <td><?php echo $row['purpose'] ?></td>
                        
                        <td><?php echo $row['payment_method'];?></td>

                        <td><?php echo $row['donation_mode'];?></td>

                        <td><?php echo $row['country_name'];?></td>
                        
                        <td><?php echo $row['email_address'];?></td>

                        <td><?php echo $row['transaction_status'];?></td>

                        <?php if(!empty($row["receipt_id"]) && !empty($row["tax_receipt"])){ 
                            if(isset($row['pkg_title']) && !empty($row['pkg_title'])){
                                $row['receipt_purpose'] = 'eventregistration';
                            }    
                        ?>
                            <td><a class="btn btn-success btn-sm" href="<?php echo site_url( $_directory . "controls/receipt/" . $row["receipt_id"]) . "/".strtolower(str_replace(' ', '', $row['receipt_purpose'])). "/" . $row["tax_receipt"]. "/" . $row['date']   ?>" data-operationid="allreportsreceipt" ><?php echo $row['receipt_prefix'] . $row['tax_receipt'];?></a></td>
                        <?php }else{ ?>
                            <td>N/A</td>
                        <?php } ?>

                        <td><?php echo $row['reconciliation_status'];?></td>
                        
                    </tr>
                <?php
            }
            ?>
        </tbody>
        <tfoot>
        </tfoot>
    </table>