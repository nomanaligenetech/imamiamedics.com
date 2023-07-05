<table width="100%" border="1" bordercolor="#ccc" cellpading="0" cellspacing="0">
    <tr height="50">
        <td width="300" align="center">
            <b>Total Number of Users Join Event</b>
        </td>
        <td align="center">
            <?php echo $email_post['total']; ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table cellpadding="5" cellspacing="5" width="100%">
                <tr>
                    <td colspan="2" align="center">
                        <h3>Events Joined By Users</h3>
                    </td>
                </tr>
                <?php foreach ($email_post['events'] as $event){?>
                    <tr height="5">
                        <td colspan="2"><hr/></td>
                    </tr>
                    <tr>
                        <td>
                            <b>Event Name</b>
                        </td>
                        <td>
                            <?php echo $event['details']->title; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <b>No. of Users</b>
                        </td>
                        <td>
                            <?php echo $event['count']; ?>
                            <a href="<?php echo $email_post['admin_url'].'?search='.$event['details']->title.' '.date('Y-m-d'); ?>">View List</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </td>
    </tr>
</table>