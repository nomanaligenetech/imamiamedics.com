<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    

<table class="table table_form formarea">
    <tr>
        <td class="td_bg fieldKey">Name <?php echo required_field();?> </td>
        <td class="td_bg fieldValue">
        <div class="input-group col-xs-5">
        <?php
        $specdata		= array("name"				=> "name",
                                "id"				=> "name",
                                
                                "class"				=> "form-control",
                                "value"				=> set_value("name", $name) );
        
        echo form_input($specdata);
        ?>
        </div>
        </td>
    </tr>
    <tr>
      <td class="td_bg fieldKey">Last Name <?php echo required_field();?></td>
      <td class="td_bg fieldValue"><div class="input-group col-xs-5">
        <?php
        $specdata		= array("name"				=> "last_name",
                                "id"				=> "last_name",
                                
                                "class"				=> "form-control",
                                "value"				=> set_value("last_name", $last_name) );
        
        echo form_input($specdata);
        ?>
      </div></td>
    </tr>
    <tr>
      <td class="td_bg fieldKey">Email <?php echo required_field();?></td>
      <td class="td_bg fieldValue"><div class="input-group col-xs-5">
        <?php
		echo set_value("email", $email);
        $specdata		= array("name"				=> "email",
                                "id"				=> "email",
                                "readonly"			=> "readonly",
                                "class"				=> "form-control",
								"type"				=> "hidden",
                                "value"				=> set_value("email", $email) );
        
        echo form_input($specdata);
        ?>
      </div></td>
    </tr>
    <tr>
        <td class="td_bg fieldKey">Enter Old Password <?php echo required_field();?></td>
        <td class="td_bg fieldValue">
        <div class="input-group col-xs-5">
        <?php
        $specdata		= array("name"				=> "txt_password",
                                "id"				=> "txt_password",
                                
                                "class"				=> "form-control",
								"type"				=> "password",
                                "value"				=> set_value("txt_password", "") );
        
        echo form_input($specdata);
        ?>
        </div>
        </td>
    </tr>
    
    
    <tr>
        <td class="td_bg fieldKey">Enter New Password <?php echo required_field();?></td>
        <td class="td_bg fieldValue">
        <div class="input-group col-xs-5">
        <?php
        $specdata		= array("name"				=> "txt_newpassword",
                                "id"				=> "txt_newpassword",
                                
                                "class"				=> "form-control",
								"type"				=> "password",
                                "value"				=> set_value("txt_newpassword") );
        
        echo form_input($specdata);
        ?>
        </div>
        </td>
    </tr>
    
    
    <tr>
        <td class="td_bg fieldKey">Confirm New Password <?php echo required_field();?></td>
        <td class="td_bg fieldValue">
        <div class="input-group col-xs-5">
        <?php
        $specdata		= array("name"				=> "txt_cnewpassword",
                                "id"				=> "txt_cnewpassword",
                                
                                "class"				=> "form-control",
								"type"				=> "password",
                                "value"				=> set_value("txt_cnewpassword") );
        
        echo form_input($specdata);
        ?>
        </div>
        </td>
    </tr>


        

    
    <tr>
        <td class="td_bg">&nbsp;</td>
        <td class="td_bg">
            <input type="hidden" value="<?php echo set_value("id", $id);?>" name="hdn_id" />
        </td>
    </tr>
    
    
</table>
<input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
  <input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />
    
    <div class="crud_controls">
        <button type="submit" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>
        <!--<a class="btn btn-danger btn-flat" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php lang_line("text_cancel");?>
        </a>-->
    </div>

</form>