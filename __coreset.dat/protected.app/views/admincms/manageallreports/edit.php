<?php 
/********** Hadi 12-3-2015 ****************** (Add class on all text spans to hide incase of update page) */?>
<table class="table table_form">
		
		<?php if($_GET['p'] == 'donation'){?>
        <tr>
			<td class="td_bg fieldKey"><strong>Submitted By </strong></td>
			<td class="td_bg fieldValue" colspan="2">
			<div class="input-group">
				<?php
					echo '<span class="input-edit-details">'.$edit_details[0]['name'].'</span>';
                ?>
            </div>
			</td>
		</tr>
        <tr>
			<td class="td_bg fieldKey"><strong>Email </strong></td>
			<td class="td_bg fieldValue" colspan="2">
			<div class="input-group">
				<?php
					echo '<span class="input-edit-details">'.$edit_details[0]['email'].'</span>';
                ?>
            </div>
			</td>
		</tr>
		</tr>
        <tr>
			<td class="td_bg fieldKey"><strong>Donation Amount </strong></td>
			<td class="td_bg fieldValue" colspan="2">
			<div class="input-group">
				<?php
					echo '<span class="input-edit-details">$'.$edit_details[0]['donate_amount'].'</span>';
                ?>
            </div>
			</td>
		</tr>
		</tr>
        <tr>
			<td class="td_bg fieldKey"><strong>Tax Receipt </strong></td>
			<td class="td_bg fieldValue" colspan="2">
			<div class="input-group">
				<?php
					echo '<span class="input-edit-details">'.$edit_details[0]['receipt_prefix'].$edit_details[0]['tax_receipt_num'].'</span>';
                ?>
            </div>
			</td>
		</tr>
		</tr>
        <tr>
			<td class="td_bg fieldKey"><strong>Status </strong></td>
			<td class="td_bg fieldValue" colspan="2">
			<div class="input-group">
				<?php
					echo '<span class="input-edit-details">'.$edit_details[0]['status'].'</span>';
                ?>
            </div>
			</td>
		</tr>
		</tr>
        <tr>
			<td class="td_bg fieldKey"><strong>Date </strong></td>
			<td class="td_bg fieldValue" colspan="2">
			<div class="input-group">
				<?php
					echo '<span class="input-edit-details">'.$edit_details[0]['Date'].'</span>';
                ?>
            </div>
			</td>
		</tr>
		</tr>
        <tr>
			<td class="td_bg fieldKey"><strong>Payment Mode </strong></td>
			<td class="td_bg fieldValue" colspan="2">
			<div class="input-group">
				<?php
					echo '<span class="input-edit-details">'.$edit_details[0]['payment_mode'].'</span>';
                ?>
            </div>
			</td>
		</tr>
		</tr>
        <tr>
			<td class="td_bg fieldKey"><strong>Reference Id </strong></td>
			<td class="td_bg fieldValue" colspan="2">
			<div class="input-group">
				<?php
					echo '<span class="input-edit-details">'.$edit_details[0]['ref_id'].'</span>';
                ?>
            </div>
			</td>
		</tr>
		<?php }else if($_GET['p'] == 'shortconference'){ ?>
          <tr>
          <td class="td_bg fieldKey"><strong>Submitted By </strong></td>
          <td class="td_bg fieldValue" colspan="2">
          <div class="input-group">
            <?php
              echo '<span class="input-edit-details">'.$edit_details[0]['name'].'</span>';
                    ?>
                </div>
          </td>
        </tr>
            <tr>
          <td class="td_bg fieldKey"><strong>Conference </strong></td>
          <td class="td_bg fieldValue" colspan="2">
          <div class="input-group">
            <?php
              echo '<span class="input-edit-details">'.$edit_details[0]['conference_name'].'</span>';
                    ?>
                </div>
          </td>
        </tr>
        </tr>
            <tr>
          <td class="td_bg fieldKey"><strong>Email </strong></td>
          <td class="td_bg fieldValue" colspan="2">
          <div class="input-group">
            <?php
              echo '<span class="input-edit-details">'.$edit_details[0]['email'].'</span>';
                    ?>
                </div>
          </td>
        </tr>
        </tr>
            <tr>
          <td class="td_bg fieldKey"><strong>Phone </strong></td>
          <td class="td_bg fieldValue" colspan="2">
          <div class="input-group">
            <?php
              echo '<span class="input-edit-details">'.$edit_details[0]['phone'].'</span>';
                    ?>
                </div>
          </td>
        </tr>
        </tr>
            <tr>
          <td class="td_bg fieldKey"><strong>Registration Details</strong></td>
          <td class="td_bg fieldValue" colspan="2">
          <div class="input-group">
          <?php echo $this->load->view("admincms/manageallreports/12/view_registration_prices"); ?>
          </td>
        </tr>
        </tr>
            <tr>
          <td class="td_bg fieldKey"><strong>Registration Date </strong></td>
          <td class="td_bg fieldValue" colspan="2">
          <div class="input-group">
            <?php
              echo '<span class="input-edit-details">'.$edit_details[0]['conference_master_date_added'].'</span>';
                    ?>
                </div>
          </td>
        </tr>
    <?php }?>
          </table>
 
          <input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
  <input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />
    
    <div class="crud_controls"> <?php
       if(isset($show_update_page) && $show_update_page){?>
        <button type="submit" class="btn btn-warning btn-flat"><?php echo lang_line("text_save");?></button>	<?php	}?>
        
        <a class="btn btn-danger btn-flat" href="<?php echo site_url( $_directory . "controls/view");?>">
            <?php echo lang_line("text_cancel");?>
        </a>
    </div>

</form>

