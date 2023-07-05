<div class="members_sec fl_lft w_100">
    <div class="myTableContainer">
    	<?php
		if ( $conference_registration_excel_documents -> num_rows() > 0 )
		{
		?>
            <table cellspacing="0" cellpadding="0" class="fl_lft w_100 myTable b_white">
            <tr class="b_grey t_white">
                <td class="txt_lft w_45">Document</td>
                <td class="txt_lft w_45">Uploaded On</td>
                <td>Document Type</td>
            </tr>
            
			<?php
			foreach ( $conference_registration_excel_documents->result_array() as $fd1)
			{
			?>
				<tr class="in_padding border">
					<td class="txt_lft"><a target="_blank" href="<?php echo $fd1['document'];?>"><?php echo $fd1['document'];?></a></td>
					<td class="txt_lft"><?php echo $fd1['uploaded_on'] ?></td>                            
					<td><?php echo $fd1['uploaded_on'];?></td>
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