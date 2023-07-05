<div style="font-size:13px;">
   <?php $name = '';$prefix_title = str_replace('.', '', $email_post['user']->prefix_title); ?>
   <?php $name .= $prefix_title != "" ? $prefix_title . '. ' : ''; ?>
   <?php $name .= $email_post['user']->name != "" ? $email_post['user']->name . ' ' : ''; ?>
   <?php $name .= $email_post['user']->middle_name != "" ? $email_post['user']->middle_name . ' ' : ''; ?>
   <?php $name .= $email_post['user']->last_name != "" ? $email_post['user']->last_name . ' ' : ''; ?>
   <p style=" <?php echo $emailTemplateHelper->styles("p"); ?> ">
      <b>Dear <?php echo $name; ?></b>,
   </p>

   <br />

   <p style=" <?php echo $emailTemplateHelper->styles("p"); ?> ">
      Your membership on imamiamedics.com is going to be expire at <b><?php echo date('F j, Y',strtotime($email_post['membership']->member_expiry)); ?></b>. If you want to renew your plan please follow the link below. <br><br /> <a href="<?php echo site_url() . 'joinus/payment/' . $email_post['user']->id; ?>">Click here to renew</a>
   </p>
</div>