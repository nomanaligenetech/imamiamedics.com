<?php
$attributes 			= array(
	"method"		=> "post",
	"enctype"		=> "multipart/form-data"
);
$unique_form			= array("unique_formid"	=> set_value("unique_formid", random_string("unique")));

echo form_open(site_url($_directory . "controls/save"), $attributes, $unique_form);
?>

<table class="table table_form">




	<tr>
		<td class="td_bg fieldKey">Title <?php echo required_field(); ?></td>
		<td class="td_bg fieldValue" colspan="2">
			<div class="input-group">
				<?php
				$specdata		= array(
					"name"		=> "title",
					"id"		=> "title",
					"size"		=> 50,
					"class"		=> "form-control",
					"value"		=> set_value("title", $title)
				);

				echo form_input($specdata);
				?>
			</div>
		</td>
	</tr>








	<tr>
		<td class="td_bg">Description <?php echo required_field(); ?></td>
		<td class="td_bg" colspan="2">
			<div class="input-group">
				<?php
				$specdata		= array(
					"name"		=> "description",
					"id"		=> "description",
					"size"		=> 50,
					"cols"      => 50,
					"class"		=> "form-control",
					"value"		=> set_value("description", $short_desc)
				);

				echo form_textarea($specdata);
				?>

			</div>
		</td>
	</tr>



	<tr>
		<td class="td_bg">URL - Youtube / Vimeo <?php echo required_field(); ?></td>
		<td class="td_bg" colspan="2">
			<div class="input-group">
				<?php
				$specdata		= array(
					"name"		=> "url",
					"id"		=> "url",
					"size"		=> 50,
					"class"		=> "form-control",
					"value"		=> set_value("url", $url)
				);
				echo form_input($specdata);
				?>
			</div>
		</td>
	</tr>


	<tr>
		<td class="td_bg">Button Type</td>
		<td colspan="2" class="td_bg">
			<div class="input-group" id="buttontype">
				<p class="fl_lft">
					<input type="radio" id="nobutton" name="buttontype" value="0" <?php echo set_radio('buttontype', '0', format_bool(set_value("buttontype", $button_type), "0")); ?> />
					<label for="nobutton">No Button</label>
				</p>
				<p class="fl_lft">
					<input type="radio" id="learnmore" name="buttontype" value="1" <?php echo set_radio('buttontype', '1', format_bool(set_value("buttontype", $button_type), "1")); ?> />
					<label for="learnmore">Learn More</label>
				</p>
				<p class="fl_lft">
					<input type="radio" id="donate" name="buttontype" value="2" <?php echo set_radio('buttontype', '2', format_bool(set_value("buttontype", $button_type), "2")); ?> />
					<label for="donate">Donate</label>
				</p>

			</div>
		</td>
	</tr>


	<tr class="button_link_wrapper">
		<td class="td_bg">Button Link</td>
		<td class="td_bg" colspan="2">
			<div class="input-group">
				<?php
				$specdata		= array(
					"name"		=> "button_link",
					"id"		=> "button_link",
					"size"		=> 50,
					"class"		=> "form-control",
					"value"		=> set_value("button_link", $button_link)
				);
				echo form_input($specdata);
				?>
			</div>
		</td>
	</tr>








	<tr>
		<td class="td_bg">&nbsp;</td>
		<td colspan="2" class="td_bg">
			<input type="hidden" value="<?php echo set_value("id", $id); ?>" name="hdn_id" />
		</td>
	</tr>


</table>
<input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
<input type="hidden" name="options" value="<?php echo set_value('options', $options); ?>" />

<div class="crud_controls">
	<button type="submit" class="btn btn-warning btn-flat"><?php echo lang_line("text_save"); ?></button>
	<a class="btn btn-danger btn-flat" href="<?php echo site_url($_directory . "controls/view"); ?>">
		<?php echo lang_line("text_cancel"); ?>
	</a>
</div>

</form>

<script>
	$(function() {

		if($('#buttontype input[name="buttontype"]:checked').val() == 0 ){
			$('.button_link_wrapper').hide();
		}
		$('#buttontype input[name="buttontype"]').on("ifChanged",function(){
			var $radio = $(this);
			if($radio.val() == 0){

				$('.button_link_wrapper').hide();

			}else{
				$('.button_link_wrapper').show();
			}
			

		});
		// $("input[name='article[format]']:radio").on("change", function() { 
		/* $("#buttontype input[type=radio]").each(function() {
			$(this).on("change", function() {
				debugger
				if (this.value == '2') {

				} else if (this.value == '1') {
					// ...
				}
			});
		}); */
	})
</script>