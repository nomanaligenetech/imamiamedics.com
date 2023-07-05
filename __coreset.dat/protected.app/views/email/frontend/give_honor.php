<?php if ($email_post['sendTo'] == 'recipient') { ?>
  <p>A Gift has been sent to <?php echo $email_post['recipientName']; ?> in behalf of you. Below is the preview of an email which is sent to <?php echo $email_post['recipientName']; ?></p>
<?php } ?>

<table border="0" style="width:100%;">
  <tr>
    <td>

      <img src="./assets/frontend/images/honor.jpg" alt="Honor" />

    </td>
  </tr>
  <tr>
    <td>
      <span style="font-family: arial;font-size:14px"><?php echo $email_post['honorto'] != "" ? "<b>To:</b> " . $email_post['honorto'] : ''; ?></span>
      <p style="font-family: arial;font-size:14px;margin:0;"><?php echo $email_post['message'] != "" ? "<b>Message:</b> " . $email_post['message'] : ''; ?></p>
      <span style="font-family: arial;font-size:14px"><?php echo $email_post['fromname'] != "" ? "<b>From:</b> " . $email_post['fromname'] : ''; ?></span>
    </td>
  </tr>
  <tr>
    <td>
      <p style="font-family: arial;font-size:14px;margin-top:20px;">
        The $<?php echo $email_post['donating_amount']; ?> donation that <?php echo $email_post['fromname']; ?> made to Imamia Medics International in your honor is going to help fund humanitarian relief, health care and education projects for communities around the world. It will save lives and empower communities so future generations can lift their families out of the cycles of poverty and need.
      </p>
      <p style="font-family: arial;font-size:14px">
        Visit us at <a href="<?php echo site_url(); ?>"><?php echo site_url(); ?></a> to learn more about the impact we have together.
      </p>
      <p style="font-family: arial;font-size:14px;margin-top:20px;">
        <b>Imamia Medics International</b><br />Save a life, save humanity<br />PO Box 8209<br />Princeton, NJ 08543
      </p>
    </td>
  </tr>


</table>