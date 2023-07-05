<table class="gridtable" width="100%" style="color:#333333;border-width: 1px;border-color: #666666;border-collapse: collapse;">
<?php
if ( false )
{
?>
    <tr>
        <th style="border-width: 1px;padding: 8px;border-style: solid;border-color: #666666;background-color: #dedede;" colspan="3">Participants UID (to show at Conference gate)</th>
    </tr>
<?php
}
?>

<tr>
	<th style="border-width: 1px;padding: 8px;border-style: solid;border-color: #666666;background-color: #dedede;" align="left">Participant Name</th>
    <th style="border-width: 1px;padding: 8px;border-style: solid;border-color: #666666;background-color: #dedede;" align="left">Participant UID</th>
</tr>

<?php
if ( isset( $conferenceregistration_screenthree_screenfour_ALL_PARTICIPANTS ) )
{
	foreach ($conferenceregistration_screenthree_screenfour_ALL_PARTICIPANTS->result_array() as $cstsfap)
	{
		?>
        <tr>
            <td style="border-width: 1px;padding: 8px;border-style: solid;border-color: #666666;background-color: #ffffff;"><?php echo $cstsfap["full_name"];?></td>
            <td style="border-width: 1px;padding: 8px;border-style: solid;border-color: #666666;background-color: #ffffff;"><?php echo  generate_participant_UID( $cstsfap["id"] );?></td>
        </tr>
        <?php
	}
}
?>
</table>