<?php /********** Hadi 12-3-2015 ****************** (Add class on all text spans to hide incase of update page) */?>
<table class="table table_form">
		
		
        <tr>
			<td class="td_bg fieldKey"><strong>Submitted By <?php echo required_field(); ?></strong></td>
			<td class="td_bg fieldValue" colspan="2">
			<div class="input-group">
				<?php
					$tmp_dd				= DropdownHelper::user_dropdown(TRUE, set_value('userid', $userid));
					echo '<span class="input-edit-details">'.$tmp_dd[ set_value('userid', $userid) ].'</span>';
					echo form_dropdown("userid", DropdownHelper::user_dropdown(TRUE, set_value('userid', $userid)), set_value("userid", $userid), "class='form-control' " );
                ?>
            </div>
			</td>
		</tr>
        

		<tr>
			<td class="td_bg fieldKey"><strong>Conference <?php echo required_field(); ?></strong></td>
			<td class="td_bg fieldValue" colspan="2">
			<div class="input-group">
				<?php
					$tmp_dd				= DropdownHelper::short_conference_dropdown(TRUE, set_value('conferenceid', $conferenceid));
					echo '<span class="input-edit-details">'.$tmp_dd[ set_value('conferenceid', $conferenceid) ].'</span>';
                    echo form_dropdown("conferenceid", DropdownHelper::short_conference_dropdown(TRUE, set_value('conferenceid', $conferenceid)), set_value("conferenceid", $conferenceid), "class='form-control'" );
				?>
            </div>
			</td>
		</tr>
        
		
      
      
        
        
        <tr>
          <td class="td_bg"><strong>Full Name <?php echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2">
          	<div class="input-group">
		    <?php
			echo '<span class="input-edit-details">'.set_value("full_name", $full_name ).'</span>';
			$specdata		= array("name"			=> "full_name",
									"id"			=> "full_name",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("full_name", $full_name ) );	

			echo form_input($specdata);
			?>
		    </div>
          
          </td>
        </tr>
        
        <tr>
          <td class="td_bg"><strong>Email <?php echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2">
          	<div class="input-group">
		    <?php
			echo '<span class="input-edit-details">'.set_value("email", $email ).'</span>';
			$specdata		= array("name"			=> "email",
									"id"			=> "email",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("email", $email ) );	

			echo form_input($specdata);
			?>
		    </div>
          
          </td>
        </tr>
        
        <tr>
          <td class="td_bg"><strong>Phone <?php echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2">
          	<div class="input-group">
		    <?php
			echo '<span class="input-edit-details">'.set_value("phone", $phone ).'</span>';
			$specdata		= array("name"			=> "phone",
									"id"			=> "phone",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("phone", $phone ) );	

			echo form_input($specdata);
			?>
		    </div>
          
          </td>
        </tr>
        
      
        

        <?php
		if (count($fetch_records_for_view_ROW) > 0 ) 
		{
		?>
            <tr>
                <td class="td_bg fieldKey"><strong>Registration Details </strong></td>
                <td class="td_bg fieldValue" colspan="2">
                    <?php echo $this->load->view("admincms/manageallreports/12/view_registration_prices"); ?>
                </td>
            </tr>
    
        
        <tr>
          <td class="td_bg"><strong>Registration Date <?php echo required_field(); ?></strong></td>
          <td class="td_bg" colspan="2">
          	<div class="input-group">
		    <?php
			echo '<span class="input-edit-details">'.set_value("VIEW_conference_master_date_added", $fetch_records_for_view_ROW["VIEW_conference_master_date_added"] ).'</span>';
			?>
		    </div>
          
          </td>
        </tr>
		<?php
		}
		?>
        
		
		<tr>
			<td class="td_bg">&nbsp;</td>
			<td colspan="2" class="td_bg">
				<input type="hidden" value="<?php echo set_value("id", $id);?>" name="hdn_id" />
			</td>
		</tr>
		
		
  </table>
 
<?php  $this->load->view("admincms/template/_css_js_include_view.php", array("show_span" => true));?>