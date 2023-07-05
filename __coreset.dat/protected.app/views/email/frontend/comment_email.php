<p>A user "<?php echo $email_post['user']->name;?>" has <?php echo $email_post['updated'] ? 'updated' : 'added new'; ?> comment in post  "<?php echo $email_post['post']->name;?>". Below are the details:</p>

<table>
    <tr>
        <td>
            <b>User Name</b>
        </td>
        <td>
            <?php echo $email_post['user']->name . ' ' . $email_post['user']->last_name; ?>
        </td>
    </tr>
    <tr>
        <td>
            <b>Forum Name</b>
        </td>
        <td>
            <?php echo $email_post['forum']->name;?>
        </td>
    </tr>
    <tr>
        <td>
            <b>Topic Name</b>
        </td>
        <td>
            <?php echo $email_post['topic']->name;?>
        </td>
    </tr>
    <tr>
        <td>
            <b>Post Name</b>
        </td>
        <td>
            <?php echo $email_post['post']->name;?>
        </td>
    </tr>
    <tr>
        <td>
            <b>Comment</b>
        </td>
        <td>
            <?php echo $email_post['comment'];?>
        </td>
    </tr>
</table>