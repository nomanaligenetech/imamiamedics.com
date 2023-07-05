<?php
$attributes             = array(
    "method"        => "post",
    "name"            => "arbaeen_medical_mission_content",
    "enctype"        => "multipart/form-data"
);
$unique_form            = array("unique_formid"    => set_value("unique_formid", random_string("unique")));

echo form_open(site_url($_directory . "controls/content"), $attributes, $unique_form);
?>

<table class="table table_form">
    <tr>
        <td class="td_bg fieldKey">Application Form All Pages</td>
        <td class="td_bg fieldValue" colspan="2">
            <div class="input-group">

                    <ul class="nav nav-tabs">
						<?php foreach ($content_languages as $lang_key => $lang): ?>
							<li class="<?php echo $lang_key < 1?'active':''; ?>"><a href="#content_<?php echo $lang['id']; ?>" data-toggle="tab"><?php echo $lang['name']; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<div class="tab-content">
						<?php foreach ($content_languages as $lang_key => $lang): ?>

							<div class="tab-pane <?php echo $lang_key < 1?'active':''; ?>" id="content_<?php echo $lang['id']; ?>">
								<div class="input-group">
								<?php
								$specdata		= array("name"			=> "content[{$lang['id']}]",
														"id"			=> "content[{$lang['id']}]",
														"rows"			=> 25,
														"class"			=> "ckeditor1 form-control",
														"value"			=> $lang_content[$lang['id']]['content'] );	

								echo form_textarea($specdata);
								?>
								</div>
							</div>

						<?php endforeach; ?>
						
					</div>
					<!-- /.tab-content -->
            </div>
        </td>
    </tr>

	<tr>
        <td class="td_bg fieldKey">Application Form First Page</td>
        <td class="td_bg fieldValue" colspan="2">
            <div class="input-group">

                    <ul class="nav nav-tabs">
						<?php foreach ($content_languages as $lang_key => $lang): ?>
							<li class="<?php echo $lang_key < 1?'active':''; ?>"><a href="#content_fp_<?php echo $lang['id']; ?>" data-toggle="tab"><?php echo $lang['name']; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<div class="tab-content">
						<?php foreach ($content_languages as $lang_key => $lang): ?>

							<div class="tab-pane <?php echo $lang_key < 1?'active':''; ?>" id="content_fp_<?php echo $lang['id']; ?>">
								<div class="input-group">
								<?php
								$specdata		= array("name"			=> "content_fp[{$lang['id']}]",
														"id"			=> "content_fp[{$lang['id']}]",
														"rows"			=> 25,
														"class"			=> "ckeditor1 form-control",
														"value"			=> $lang_content[$lang['id']]['content_fp'] );	

								echo form_textarea($specdata);
								?>
								</div>
							</div>

						<?php endforeach; ?>
						
					</div>
					<!-- /.tab-content -->
            </div>
        </td>
    </tr>

    <tr>
        <td class="td_bg fieldKey">Stage 3 Form</td>
        <td class="td_bg fieldValue" colspan="2">
            <div class="input-group">

                    <ul class="nav nav-tabs">
						<?php foreach ($content_languages as $lang_key => $lang): ?>
							<li class="<?php echo $lang_key < 1?'active':''; ?>"><a href="#stage3_form_<?php echo $lang['id']; ?>" data-toggle="tab"><?php echo $lang['name']; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<div class="tab-content">
						<?php foreach ($content_languages as $lang_key => $lang): ?>

							<div class="tab-pane <?php echo $lang_key < 1?'active':''; ?>" id="stage3_form_<?php echo $lang['id']; ?>">
								<div class="input-group">
								<?php
								$specdata		= array("name"			=> "stage3_form[{$lang['id']}]",
														"id"			=> "stage3_form[{$lang['id']}]",
														"rows"			=> 25,
														"class"			=> "ckeditor1 form-control",
														"value"			=> $lang_content[$lang['id']]['stage3_form'] );	

								echo form_textarea($specdata);
								?>
								</div>
							</div>

						<?php endforeach; ?>
						
					</div>
					<!-- /.tab-content -->
            </div>
        </td>
    </tr>
    <tr>
        <td class="td_bg fieldKey">Stage 3b Form</td>
        <td class="td_bg fieldValue" colspan="2">
            <div class="input-group">

                    <ul class="nav nav-tabs">
						<?php foreach ($content_languages as $lang_key => $lang): ?>
							<li class="<?php echo $lang_key < 1?'active':''; ?>"><a href="#stage3b_form_<?php echo $lang['id']; ?>" data-toggle="tab"><?php echo $lang['name']; ?></a></li>
						<?php endforeach; ?>
					</ul>
					<div class="tab-content">
						<?php foreach ($content_languages as $lang_key => $lang): ?>

							<div class="tab-pane <?php echo $lang_key < 1?'active':''; ?>" id="stage3b_form_<?php echo $lang['id']; ?>">
								<div class="input-group">
								<?php
								$specdata		= array("name"			=> "stage3b_form[{$lang['id']}]",
														"id"			=> "stage3b_form[{$lang['id']}]",
														"rows"			=> 25,
														"class"			=> "ckeditor1 form-control",
														"value"			=> $lang_content[$lang['id']]['stage3b_form'] );	

								echo form_textarea($specdata);
								?>
								</div>
							</div>

						<?php endforeach; ?>
						
					</div>
					<!-- /.tab-content -->
            </div>
        </td>
    </tr>
</table>

<div class="crud_controls">
    <button type="submit" data-operationid="managearbaeenmedicalmissioncontent" class="btn btn-warning btn-flat"><?php echo lang_line("text_save"); ?></button>
    <a class="btn btn-danger btn-flat" data-operationid="managearbaeenmedicalmissionview" href="<?php echo site_url($_directory . "controls/view"); ?>">
        Submissions
    </a>
</div>
<?php
echo form_close();
