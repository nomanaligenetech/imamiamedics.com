<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    

	<table class="table table_form">
		<tr>
			<td class="td_bg fieldKey">Select Conference <?php echo required_field(); ?></td>
			<td class="td_bg fieldValue" colspan="2">
			<div class="input-group">
				<?php
                    echo form_dropdown("conferenceid", DropdownHelper::short_conference_dropdown(), set_value("conferenceid", $conferenceid), "class='form-control'" );
                ?>
            </div>
			</td>
		</tr>
        
        
        
		<tr>
		  <td class="td_bg">Name <?php echo required_field(); ?></td>
		  <td colspan="2" class="td_bg">
          <div class="input-group">
		    <?php
			$specdata		= array("name"			=> "name",
									"id"			=> "name",
									"size"			=> 50,
									"class"			=> "form-control",
									"value"			=> set_value("name", $name ) );	

			echo form_input($specdata);
			?>
		    </div></td>
	  </tr>
      
      
      <tr>
		  <td class="td_bg">Allow Payment</td>
		  <td colspan="2" class="td_bg">
          <div class="input-group">
		  <?php echo form_dropdown('allow_payment', DropdownHelper::yesno_dropdown(), set_value("allow_payment", $allow_payment), "class='form-control '" )?></div>
          </td>
	  </tr>
      
      
      <tr>
		  <td class="td_bg">Show Rates In</td>
		  <td colspan="2" class="td_bg">
          <div class="input-group">
		  <?php echo form_dropdown("show_rates_in_currency", DropdownHelper::currency_dropdown(TRUE), set_value("show_rates_in_currency", $show_rates_in_currency), "class='form-control'" ); ?>
		  </div>
          </td>
	  </tr>
		
        
        <tr>
		  <td class="td_bg">Step 5 Note 
          <br />
          <small class="badge  bg-green" style="">Will always display  on Step 5 screen</small>
          </td>
		  <td colspan="2" class="td_bg">
          <div class="input-group">
			<?php
            $descdata= array("name"			=> "step5_note1",
                            "id"			=> "step5_note1",
                            "cols"			=> 50,
                            "rows"			=> 10,
                            "class"			=> "ckeditor1",
                            "value"			=> set_value("step5_note1", $step5_note1)
                            );	

            echo form_textarea($descdata);
            ?>
            </div>
          
          </td>
	  </tr>
      
      
      
      <tr>
		  <td class="td_bg">Payment Description (Conference) 
          <br />
          <small class="badge  bg-green" style="">Will display on Step 5 if payment is not allowed by this Region</small>
          </td>
		  <td colspan="2" class="td_bg">
          <div class="input-group">
			<?php
            $descdata= array("name"			=> "paymentdescription_conference",
                            "id"			=> "paymentdescription_conference",
                            "cols"			=> 50,
                            "rows"			=> 10,
                            "class"			=> "ckeditor1",
                            "value"			=> set_value("paymentdescription_conference", $paymentdescription_conference)
                            );	

            echo form_textarea($descdata);
            ?>
            </div>
          
          </td>
	  </tr>
      
      <tr>
		  <td class="td_bg">Payment Description (abstract) </td>
		  <td colspan="2" class="td_bg">
          <div class="input-group">
			<?php
            $descdata= array("name"			=> "paymentdescription_abstract",
                            "id"			=> "paymentdescription_abstract",
                            "cols"			=> 50,
                            "rows"			=> 10,
                            "class"			=> "ckeditor1",
                            "value"			=> set_value("paymentdescription_abstract", $paymentdescription_abstract)
                            );	

            echo form_textarea($descdata);
            ?>
            </div>
          
          </td>
	  </tr>
      
      
		
	


		
		<tr>
		  <td class="td_bg">Description </td>
		  <td colspan="2" class="td_bg">
          <div class="input-group">
			<?php
            $descdata= array("name"			=> "description",
                            "id"			=> "description",
                            "cols"			=> 50,
                            "rows"			=> 10,
                            "class"			=> "ckeditor1",
                            "value"			=> set_value("description", $description)
                            );	

            echo form_textarea($descdata);
            ?>
            </div>
          
          </td>
	  </tr>
      
      
      
      <tr>
		  <td class="td_bg">Onsite Note </td>
		  <td colspan="2" class="td_bg">
          <div class="input-group">
			<?php
            $descdata= array("name"			=> "onsite_note",
                            "id"			=> "onsite_note",
                            "cols"			=> 50,
                            "rows"			=> 10,
                            "class"			=> "ckeditor1",
                            "value"			=> set_value("onsite_note", $onsite_note)
                            );	

            echo form_textarea($descdata);
            ?>
            </div>
          
          </td>
	  </tr>
      
      
		<tr>
			<td class="td_bg">&nbsp;</td>
			<td colspan="2" class="td_bg">
				<input type="hidden" value="<?php echo set_value("id", $id);?>" name="hdn_id" />
			</td>
		</tr>
		
		
  </table>
<input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
  <input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />
    
    <div class="crud_controls">
        <button type="submit" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>
        <a class="btn btn-danger btn-flat" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php echo lang_line("text_cancel");?>
        </a>
    </div>

</form>