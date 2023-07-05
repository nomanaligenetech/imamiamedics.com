<p>A user "<?php echo $email_post['user']->name;?>" has <?php echo $email_post['delete'] ? 'delete' : ($email_post['updated'] ? 'updated from' : 'added new');?> topic "<?php echo $email_post['updated'] ? $email_post['old_topic']->name.'" to "'. $email_post['topic']->name : $email_post['topic']->name;?>" in forum "<?php echo $email_post['forum']->name;?>". Below are the details:</p>

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
    <?php if ( isset($email_post['old_topic']) ){ ?>
    <tr>
        <td>
            <b>Old Topic Name</b>
        </td>
        <td>
            <?php echo $email_post['old_topic']->name;?>
        </td>
    </tr>
    <tr>
        <td>
            <b>Old Topic Description</b>
        </td>
        <td>
            <?php echo $email_post['old_topic']->description;?>
        </td>
    </tr>
    <?php } ?>
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
            <b>Topic Description</b>
        </td>
        <td>
            <?php echo $email_post['topic']->description;?>
        </td>
    </tr>
</table>