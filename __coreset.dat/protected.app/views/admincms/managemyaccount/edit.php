<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    

<table class="table table_form">
    <tr>
        <td class="td_bg fieldKey">Username</td>
        <td class="td_bg fieldValue">
        <div class="input-group col-xs-5">
        <?php
        $specdata		= array("name"				=> "username",
                                "id"				=> "username",
                                "size"				=> 50,
                                "class"				=> "form-control",
                                "value"				=> set_value("username", $username) );
        
        echo form_input($specdata);
        ?>
        </div>
        </td>
    </tr>
    
    
    <tr>
        <td class="td_bg fieldKey">Email</td>
        <td class="td_bg fieldValue">
        <div class="input-group col-xs-5">
        <?php
        $specdata		= array("name"				=> "email",
                                "id"				=> "email",
                                "size"				=> 50,
                                "class"				=> "form-control",
                                "value"				=> set_value("email", $email) );
        
        echo form_input($specdata);
        ?>
        </div>
        </td>
    </tr>
    
    
    <tr>
        <td class="td_bg fieldKey">Enter Old Password</td>
        <td class="td_bg fieldValue">
        <div class="input-group col-xs-5">
        <?php
        $specdata		= array("name"				=> "txt_password",
                                "id"				=> "txt_password",
                                "size"				=> 50,
                                "class"				=> "form-control",
								"type"				=> "password",
                                "value"				=> set_value("txt_password", "") );
        
        echo form_input($specdata);
        ?>
        </div>
        </td>
    </tr>
    
    
    <tr>
        <td class="td_bg fieldKey">Enter New Password</td>
        <td class="td_bg fieldValue">
        <div class="input-group col-xs-5">
        <?php
        $specdata		= array("name"				=> "txt_newpassword",
                                "id"				=> "txt_newpassword",
                                "size"				=> 50,
                                "class"				=> "form-control",
								"type"				=> "password",
                                "value"				=> set_value("txt_newpassword") );
        
        echo form_input($specdata);
        ?>
        </div>
        </td>
    </tr>
    
    
    <tr>
        <td class="td_bg fieldKey">Confirm New Password</td>
        <td class="td_bg fieldValue">
        <div class="input-group col-xs-5">
        <?php
        $specdata		= array("name"				=> "txt_cnewpassword",
                                "id"				=> "txt_cnewpassword",
                                "size"				=> 50,
                                "class"				=> "form-control",
								"type"				=> "password",
                                "value"				=> set_value("txt_cnewpassword") );
        
        echo form_input($specdata);
        ?>
        </div>
        </td>
    </tr>


        

    
    <tr>
        <td class="td_bg">Profile Image</td>
        <td class="td_bg">
            <div class="input-group">
            <input type="file" class="btn btn-default" name="file_profile_image"/>
            <input type="hidden" value="<?php echo set_value("profile_image", $profile_image);?>" name="profile_image" />  
            <small><?php echo image_link("profile_image", $profile_image);?></small>
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
        <button type="submit" class="btn btn-warning btn-flat" data-operationid="managemyaccountsave"><?php echo lang_line("text_save");?></button>
        <!--<a class="btn btn-danger btn-flat" data-operationid="managemyaccountview" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php lang_line("text_cancel");?>
        </a>-->
    </div>

</form>