<?php $this->load->view('frontend/template/_head.php'); 

$lang = getCurrentLang($content_languages);
?>

<body lang="<?php echo $lang['code']; ?>" dir="<?php echo $lang['direction']; ?>" class="skin-black <?php echo is_countryCheck(true); ?> <?php echo $lang['direction']; ?> lang-<?php echo $lang['code']; ?>">

    <div class="menu_active" style="display:none;">
        <h1><?php echo $menu_active; ?></h1>
    </div>





    <div class="hwrap header">
        <div class="cont2 pos_rel bg_white">

            <?php
			if ($showThings['_show_HEADER']) {
					$this->load->view('frontend/template/_header.php');
				}

			if ($showThings['_show_SLIDER']) { }
			$this->load->view('frontend/template/_static_slider.php');
			?>

        </div>
    </div>

    <?php
	if (1 == 1) {
			?>
    <div class="hwrap mainBody">

        <?php $this->load->view('frontend/template/_breadcrumbs.php'); ?>

        <div class="cont2">
            <div class="inner_content bg_Offwhite p_TopBottom30">
                <div class="cont1 Two_Col_Tem1">

                    <div class="right_area fl_rit w_68">



                        <?php if (isset($_heading)) { ?><h4 class="h1Style2"><?php echo $_heading; ?> </h4><?php 
																										} ?>

                        <?php $this->load->view('frontend/template/_show_messages.php'); ?>



                        <?php
						if (isset($_messageBundle_work_in_progress)) {
								$data["_messageBundle"]				= $_messageBundle_work_in_progress;
								$this->load->view('frontend/template/_show_messages.php', $data);
							}


						if (isset($_messageBundle_not_a_paid_member) and !$this->functions->_user_logged_in_details("is_member")) {
								$data["_messageBundle"]				= $_messageBundle_not_a_paid_member;
								$this->load->view('frontend/template/_show_messages.php', $data);
							} elseif (isset($_messageBundle_paid_membersip_details)) {
							$data["_messageBundle"] = $_messageBundle_paid_membersip_details;
							$this->load->view('frontend/template/_show_messages.php', $data);
						}
						?>

                        <?php echo $this->load->view($_pageview); ?>

                    </div>

                    <?php $this->load->view('frontend/template_account/_left.php'); ?>

                </div>
            </div>
        </div>

    </div>
    <?php

}

if ($showThings['_show_FOOTER']) {
		$this->load->view('frontend/template/_footer.php');
	}
?>
    <script type="text/javascript">
        //<![CDATA[

        // This call can be placed at any point after the
        // <textarea>, or inside a <head><script> in a
        // window.onload event handler.

        // Replace the <textarea id="editor"> with an CKEditor
        // instance, using default configurations.

        $("textarea.ckeditor1").each(function() {

            CKEDITOR.replace($(this).attr("name"), {
                toolbar: [
                    ['Source', 'Preview', 'Save'],
                    ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript'],
                    ['NumberedList', 'BulletedList', 'Link', 'Unlink'],
                    ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', 'RemoveFormat'],
                    ['Styles', 'Format', 'Font', 'FontSize'],
                    ['Image', 'Table', 'Smiley'],
                    ['TextColor', 'BGColor'],
                ],
                filebrowserBrowseUrl: '<?php echo base_url("assets/admincms/js/ckeditor/filemanager/browser/default/browser.html?Connector=" . base_url("assets/admincms/js/ckeditor/filemanager/connectors/php/connector.php")); ?>',
                filebrowserImageBrowseUrl: '<?php echo base_url("assets/admincms/js/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=" . base_url("assets/admincms/js/ckeditor/filemanager/connectors/php/connector.php")); ?>',
                filebrowserFlashBrowseUrl: '<?php echo base_url("assets/admincms/js/ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector=" . base_url("assets/admincms/js/ckeditor/filemanager/connectors/php/connector.php")); ?>',
                filebrowserUploadUrl: '<?php echo base_url("assets/admincms/js/ckeditor/filemanager/connectors/php/upload.php?Type=File"); ?>',
                filebrowserImageUploadUrl: '<?php echo base_url("assets/admincms/js/ckeditor/filemanager/connectors/php/upload.php?Type=Image"); ?>',
                filebrowserFlashUploadUrl: '<?php echo base_url("assets/admincms/js/ckeditor/filemanager/connectors/php/upload.php?Type=Flash"); ?>'
            });

        });

        //]]>
    </script>
    <?php  /*<script src="<?php echo base_url("assets/frontend/js/jquery.js");?>"></script>*/ ?>

</body>

</html> 