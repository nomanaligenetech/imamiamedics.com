<p>A user "<?php echo $email_post['user']->name;?>" has <?php echo $email_post['delete'] ? 'delete' : ($email_post['updated'] ? 'updated from' : 'added new'); ?> post "<?php echo $email_post['updated'] ? $email_post['old_post'] .'" to "'.$email_post['post']->name : $email_post['post']->name ;?>" in topic "<?php echo $email_post['topic']->name;?>". Below are the details:</p>

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
    <?php if ( isset($email_post['old_post']) ){?>
        <tr>
        <td>
            <b>Old Post Name</b>
        </td>
        <td>
            <?php echo $email_post['old_post']->name ?>
        </td>
    </tr>
    <tr>
        <td>
            <b>Old Post Description</b>
        </td>
        <td>
            <?php echo $email_post['old_post']->description ?>
        </td>
    </tr>
    <?php }?>
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
            <b>Post Description</b>
        </td>
        <td>
            <?php echo $email_post['post']->description;?>
        </td>
    </tr>
</table>