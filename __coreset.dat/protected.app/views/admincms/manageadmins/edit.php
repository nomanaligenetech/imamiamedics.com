<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    

	<table class="table table_form">
		<tr>
		  <td class="td_bg fieldKey">Username <?php echo required_field(); ?></td>
		  <td class="td_bg fieldValue">
          <div class="input-group">
		    <?php
			$specdata		= array("name"			=> "username",
									"id"			=> "username",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("username", $username ) );	

			echo form_input($specdata);
			?>
		    </div></td>
	  </tr>
      
      
      <tr>
		  <td class="td_bg fieldKey">Password <?php echo required_field(); ?></td>
		  <td class="td_bg fieldValue">
          <div class="input-group">
		    <?php
			$specdata		= array("name"			=> "password",
									"id"			=> "password",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("password", $password ) );	

			echo form_input($specdata);
			?>
		    </div></td>
	  </tr>
      
      
          <tr>
            <td class="td_bg">Email</td>
            <td class="td_bg"><span class="input-group">
            <?php
			$specdata		= array("name"			=> "email",
									"id"			=> "email",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("email", $email) );	

			echo form_input($specdata);
			?>
            </span></td>
          </tr>
          <tr>
            <td class="td_bg">Profile Image <?php echo required_field();?></td>
            <td class="td_bg">
                <div class="input-group">
                <input type="file" class="btn btn-default" name="file_profile_image"/>
                <input type="hidden" value="<?php echo set_value("profile_image", $profile_image);?>" name="profile_image" />  
                <small><?php echo image_link("profile_image", $profile_image);?></small>
                </div>
            </td>
        </tr>
      
      
      
      <tr>
		  <td class="td_bg fieldKey">Role <?php echo required_field(); ?></td>
		  <td class="td_bg fieldValue">
          <div class="input-group">
				<?php

					echo form_dropdown("roleid", DropdownHelper::adminroles_dropdown(), set_value("roleid", $roleid), "class='form-control' onchange='toggleCountry(this)' " );
                ?>
            </div></td>
	  </tr>

	  <?php
	 	$get_role_id =  $this->functions->_admincms_logged_in_details( "roleid" ); 
	  if($get_role_id == 1 || $get_role_id == 4): ?>
	  <tr>
		  <td class="td_bg fieldKey">Belongs to Country <?php echo required_field(); ?></td>
		  <td class="td_bg fieldValue">
          <div class="input-group">
				<?php
					$belongscountry = explode(',',$belongs_country);
					echo form_multiselect("belongs_country[]", DropdownHelper::cmsmenubelongsto_dropdown(true), set_value("belongs_country", $belongscountry), "class='form-control' " );
                ?>
            </div></td>
	  </tr>
      <?php endif;?>
	  <tr <?php echo $roleid == 4 ? 'style="display:none;"' : '';?> id='allowed_country'>
		  <td class="td_bg fieldKey">Allowed Country </td>
		  <td class="td_bg fieldValue">
          <div class="input-group form-control countries-list">
				<?php $countries = explode(',',$countryid);echo form_multiselect('countryid[]', DropdownHelper::country_dropdown(), isset($_POST['countryid'])?$_POST['countryid']:$countries, "id='countries-list'" )?>
            </div></td>
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
        <button type="submit" data-operationid="manageadminssave" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>
        <a class="btn btn-danger btn-flat" data-operationid="manageadminsview" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php echo lang_line("text_cancel");?>
        </a>
    </div>

</form>

<script>
function toggleCountry(e){
	var roleid = $(e).val();
	if ( roleid == 4 ){ 
		$(e).parents('tr').siblings('#allowed_country').hide();
	}else{
		$(e).parents('tr').siblings('#allowed_country').show();
	}

}
</script>