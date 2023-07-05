<div class="members_sec fl_lft w_100">
    <div class="myTableContainer">
    	<?php
		if ( $membership_details -> num_rows() > 0 )
		{
		?>
            <table cellspacing="0" cellpadding="0" class="fl_lft w_100 myTable b_white">
                <tr class="b_grey t_white">
                    <td class="txt_lft txt_lft1">Conference</td>
                    <td class="txt_lft txt_lft1">Membership Type</td>
                    <td class="txt_lft width1301">Amount Paid</td>
                    <td class="txt_lft width1301">Year</td>
                </tr>
                
                <?php
				foreach ( $membership_details -> result_array() as $md )
				{
					$TMP_member_fee				= $this->imiconf_queries->fetch_records_imiconf("conference_prices_not_a_member", " AND id = '". $md['be_a_member_fee'] ."' ");
				?>
                    <tr class="in_padding border">
                        <td class="txt_lft "><?php echo $TMP_member_fee->row("conference_name");?></td>
                        <td class="txt_lft "><?php echo $TMP_member_fee->row("name");?></td>
                        <td class="txt_lft "><?php echo format_price($TMP_member_fee->row("price"), array("prefix" => "$"));?></td>
                        <td class="txt_lft "><?php echo format_date( "Y", $md["date_added"] ) ;?></td>
                    </tr>
				<?php
				}
				?>
            </table>
        <?php
		}
		else
		{
		
		}
		?>
    </div>
</div>