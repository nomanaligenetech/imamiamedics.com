<?php 
$attributes 			= array("method"		=> "post",
								"enctype"		=> "multipart/form-data");
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")) );

echo form_open(site_url( $_directory . "controls/save" ), $attributes, $unique_form);
?>    



	<table class="table table_form">        
        
        <tr>
			<td class="td_bg fieldKey"> Conference <?php echo required_field(); ?></td>
			<td class="td_bg fieldValue" colspan="2">
			<div class="input-group">
				<?php
                    echo form_dropdown("conferenceid", DropdownHelper::short_conference_dropdown(), set_value("conferenceid", $conferenceid), "class='form-control'" );
                ?>
            </div>
			</td>
		</tr>
		
		
		<tr>
			<td class="td_bg fieldKey">Conference Region <?php echo required_field(); ?></td>
			<td class="td_bg fieldValue" colspan="2">
            <div class="input-group targetBox_regionid">
            	<?php
				if ( empty( $ajax_output2 ) )
				{
				?>
					<small class="badge pull-right bg-green" style="">please select conference first</small>
                <?php
				}
				else
				{
					echo $ajax_output2;	
				}
				?>
            </div>
            
			</td>
		</tr>
        
        
        <tr>
			<td class="td_bg fieldKey">(Who Attend) <?php echo required_field(); ?></td>
			<td class="td_bg fieldValue" colspan="2">
			<div class="input-group targetBox_other">
            	<?php
				if ( empty( $ajax_output1 ) )
				{
				?>
					<small class="badge pull-right bg-green" style="">please select conference first</small>
                <?php
				}
				else
				{
					echo $ajax_output1;	
				}
				?>
            </div>
			</td>
		</tr>
        
        
        <tr>
			<td class="td_bg fieldKey">Other Prices  <?php  required_field(); ?><br />
            <small>( Select only if you want to add any special options)</small>
            </td>
			<td class="td_bg fieldValue" colspan="2">
            <div class="input-group targetBox_parentid">
            	<?php
				if ( empty( $ajax_output3 ) )
				{
				?>
					<small class="badge pull-right bg-green" style="">please select conference price parent first</small>
                <?php
				}
				else
				{
					echo $ajax_output3;	
				}
				?>
            </div>
            
			</td>
		</tr>
        
        
        <tr>
            <td class="td_bg fieldKey">Title <?php  required_field(); ?></td>
            <td class="td_bg fieldValue" colspan="2">
            <div class="input-group">
            <?php
            $specdata		= array("name"		=> "title",
                                    "id"		=> "title",
                                    "size"		=> 50,
                                    "class"		=> "form-control",
                                    "value"		=> set_value("title", $title) );	
            
            echo form_input($specdata);
            ?>
            </div>
            </td>
        </tr>
        
        
        <tr>
            <td class="td_bg fieldKey">Description <?php  required_field(); ?></td>
            <td class="td_bg fieldValue" colspan="2">
            <div class="input-group" style="width:100%;">
            <?php
			$specdata		= array("name"			=> "description",
									"id"			=> "description",
									
									"rows"			=> 5,
									"style"			=> "width:100%",
									"class"			=> "form-control",
									"value"			=> set_value("description", $description ) );	

			echo form_textarea($specdata);
            ?>
            </div>
            </td>
        </tr>
		
        
        <tr>
			<td class="td_bg fieldKey">Image <?php  required_field(); ?></td>
			<td class="td_bg fieldValue" colspan="2">
				<div class="input-group">
				<input type="file" class="btn btn-default" name="file_image_icon"/>
				<input type="hidden" value="<?php echo set_value("image_icon", $image_icon);?>" name="image_icon" />  
				<small><?php echo image_link("image_icon", $image_icon);?></small>
				</div>
			</td>
		</tr>
       
		
        
        
        <tr class="clear_border_bottom">
            <td class="td_bg" colspan="3">
            	<br /><br />
            </td>
        </tr>

		<tr class="clear_border_bottom">
		  <td class="td_bg">Is Addon</td>
		  <td class="td_bg" colspan="2">
          <?php 
		  echo form_checkbox( "is_addon", "1", set_checkbox("is_addon", $is_addon, format_bool("1", $is_addon)));?>
          </td>
	  </tr>

	  <tr class="clear_border_bottom">
		  <td class="td_bg">Is Validated</td>
		  <td class="td_bg" colspan="2">
          <?php 
		  echo form_checkbox( "is_validated", "1", set_checkbox("is_validated", "1", format_bool("1", $is_validated)));?>
          </td>
	  </tr>
      
		<tr class="clear_border_bottom">
		  <td class="td_bg">Is Optional</td>
		  <td class="td_bg" colspan="2">
          <?php 
		  echo form_checkbox( "is_optional", "1", set_checkbox("is_optional", "1", format_bool("1", $is_optional)));?>
          </td>
	  </tr>
      
      <tr class="clear_border_bottom">
		  <td class="td_bg">Is Free</td>
		  <td class="td_bg" colspan="2">
          	
          
            <div class="input-group">
            <?php echo form_checkbox( "is_free", "1", set_checkbox("is_free", "1", format_bool("1", $is_free)));?>
            <?php
            $specdata		= array("name"		=> "discount_coupon_code",
                                    "id"		=> "discount_coupon_code",
                                    "size"		=> 50,
                                    "class"		=> "form-control",
									"style"		=> "width: 80%; margin-left: 5%;",
									"placeholder"	=> "Discount Coupon Code",
                                    "value"		=> set_value("discount_coupon_code", $discount_coupon_code) );	
            
            echo form_input($specdata);
            ?>
            </div>
            
          </td>
	  </tr>
      
      
      <tr class="clear_border_bottom">
		  <td class="td_bg">Apply for Visa</td>
		  <td class="td_bg" colspan="2">
          <?php 
		  
		  echo form_checkbox( "apply_for_visa", "1", set_checkbox("apply_for_visa", "1", format_bool("1", $apply_for_visa)));?>
          </td>
	  </tr>

	<!--<tr>
		<td class="td_bg fieldKey"> Currency <?php echo required_field(); ?></td>
		<td class="td_bg fieldValue" colspan="2">
		<div class="input-group">
			<?php
				echo form_dropdown("currency", DropdownHelper::currency_dropdown(), set_value("currency", $currency), "class='form-control'" );
			?>
		</div>
		</td>
	</tr>-->
      
      
      
		<tr class="clear_border_bottom">
		  <td class="td_bg">&nbsp;</td>
		  <td class="td_bg" colspan="2">&nbsp;</td>
	  </tr>
		<tr class="clear_border_bottom">
		  <td colspan="3" class="td_bg">
          
          <table width="100%" class="table table_form">
          	<tr>
            	<td>&nbsp;</td>
            	<td><strong>EarlyBird Price</strong></td>
                <td><strong>Regular Price</strong></td>
                <td><strong>Type</strong></td>
            </tr>
            <?php
			$tmp_arr							= array();
			foreach ($tmp_dd as $key => $value)
			{
				foreach ($value as $k => $v)
				{
				?>
                        <tr class="<?php echo $key;?>">
                           
                                <td>
                                <?php 
								if ( !in_array($key, $tmp_arr) )
								{
									$tmp_arr[]			= $key;
									?>
                                    <input type="radio" name="paymenttype_key"   	
									<?php echo set_checkbox("paymenttype_key", $key, format_bool($key, $paymenttype_key) );?>
                                    value="<?php echo $key;?>"  />
                                    <?php
								}
								?>
                                </td>
                                
                                <td>
                                <div class="input-group">
                                <?php
                                $specdata		= array("name"		=> "earlybird_price[". $k ."]",
                                                        "id"		=> "earlybird_price[". $k ."]",
                                                        "size"		=> 50,
                                                        "class"		=> "form-control numericonly",
                                                        "value"		=> set_value("earlybird_price[". $k ."]", $_detail_array['earlybird_price'][ $k ]) );	
                                
                                echo form_input($specdata);
                                ?>
                                </div>
                                </td>
                                
                                
                                
                                <td>
                                <div class="input-group">
                                <?php
                                $specdata		= array("name"		=> "regular_price[". $k ."]",
                                                        "id"		=> "regular_price[". $k ."]",
                                                        "size"		=> 50,
                                                        "class"		=> "form-control numericonly",
                                                        "value"		=> set_value("regular_price[". $k ."]", $_detail_array['regular_price'][ $k ]) );	
                                
                                echo form_input($specdata);
                                ?>
                                </div>
                                </td>
                                
                                
                                
                                
                                <td><strong><?php echo $v;?></strong></td>
                        </tr>
				<?php	
				}
			}
			?>
          	
          </table>
          
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