<div class="members_sec fl_lft w_100">
    <div class="myTableContainer">
		<?php
        
		

		if ( $files_details_1 -> num_rows() > 0 )
		{
		?>
            <table cellspacing="0" cellpadding="0" class="fl_lft w_100 myTable b_white">
                <tr class="b_grey t_white">
                    <td class="txt_lft w_45">Conference</td>
                    <td class="txt_lft">Name</td>
                    <td class="txt_lft">Registration</td>
                    <td class="">Status</td>
                </tr>
                <?php
				foreach ( $files_details_1->result_array() as $fd1)
				{
				?>
                    <tr class="in_padding border">
                        <td class="txt_lft"><?php echo $fd1['conference_name'];?></td>
                        <td class="txt_lft"><?php echo $fd1['submitted_by'];?></td>
                        <td class="txt_lft"><?php echo $fd1['registration'];?></td>
                        <td><?php echo $fd1['status'];?></td>    
                    </tr>
                <?php
				}
				?>
            </table>
		<?php
		}
		?>
        <?php
		if ( $files_details_2 -> num_rows() > 0 )
		{
		?>
            <table cellspacing="0" cellpadding="0" class="fl_lft w_100 myTable b_white">
                <tr class="b_grey t_white">
                    <td class="txt_lft">Short Conference</td>
                    <td class="txt_lft">Name</td>
                    <td class="txt_lft">Email</td>
                    <td class="txt_lft">Amount</td>
                    <td class="txt_lft">Mode</td>
                    <td class="">Paid</td>
                </tr>
                <?php
				foreach ( $files_details_2->result_array() as $fd1)
				{

				?>
                    <tr class="in_padding border">
                        <td class="txt_lft"><?php echo $fd1['conference_name'];?></td>
                        <td class="txt_lft"><?php echo $fd1['user_name'];?></td>
                        <td class="txt_lft"><?php echo $fd1['email'];?></td>
                        <td class="txt_lft"><?php echo format_price( $fd1["price_total_payable"], array("prefix" => $this->functions->getCurrencySymbol($fd1['region_show_rates_in_currency'] )) ); ?></td>
                        <td class="txt_lft"><?php echo $fd1['payment_type'];?></td>
                        <td><?php echo $fd1['is_paid'] == 1 ? 'yes' : 'no';?></td>    
                    </tr>
                <?php
				}
				?>
            </table>
		<?php
		}
		?>
    </div>
</div>