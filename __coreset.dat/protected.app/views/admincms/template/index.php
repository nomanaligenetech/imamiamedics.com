<?php $this->load->view('admincms/template/_head.php');?>    
    
    
    <body class="skin-black">
        
        
        <!-- header logo: style can be found in header.less -->
        <?php $this->load->view("admincms/template/_header.php");?>
        
        
        
        <div class="wrapper row-offcanvas row-offcanvas-left">
        		<?php $this->load->view("admincms/template/_left.php");?>
                
                
                
                
                
                
                
                
                
            <aside class="right-side">
                
                <section class="content-header">
                
                    <h1> <?php echo $_heading;?>
                    
                    </h1>
                    
                </section>
                
                
                
    
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                      
                            <div class="box">
                                <div class="box-header">
                               
                                </div>
                           
                                <div class="box-body table-responsive">
                                <?php 
                                $this->load->view('admincms/template/_show_messages.php');
                                
                                $this->load->view($_pageview) ;
                                ?>        
                                
                                
                                </div>      
                              
                            </div>
                       
                        </div>
                    </div>
                 </section>
             
            </aside>
                
        </div>
        
    
    <script type="text/javascript">
	//<![CDATA[

		// This call can be placed at any point after the
		// <textarea>, or inside a <head><script> in a
		// window.onload event handler.

		// Replace the <textarea id="editor"> with an CKEditor
		// instance, using default configurations.
		
		$("textarea.ckeditor1").each(function(){
													  
			CKEDITOR.replace( $(this).attr("name"),
			{
                toolbar: [
                                ['Source','Preview','Save'],
                                ['Bold','Italic','Underline','Strike','Subscript','Superscript'],
                                [ 'NumberedList','BulletedList','Link','Unlink'],
                                ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','RemoveFormat'],
                                ['Styles','Format','Font','FontSize'],
                                ['Image','Table','Smiley'],
                                ['TextColor','BGColor'],
                            ],
				filebrowserBrowseUrl :'<?php echo base_url("assets/admincms/js/ckeditor/filemanager/browser/default/browser.html?Connector=" . base_url("assets/admincms/js/ckeditor/filemanager/connectors/php/connector.php") );?>',
				filebrowserImageBrowseUrl : '<?php echo base_url("assets/admincms/js/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=" . base_url("assets/admincms/js/ckeditor/filemanager/connectors/php/connector.php") );?>',
				filebrowserFlashBrowseUrl :'<?php echo base_url("assets/admincms/js/ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector=" . base_url("assets/admincms/js/ckeditor/filemanager/connectors/php/connector.php") );?>',
				filebrowserUploadUrl  :'<?php echo base_url("assets/admincms/js/ckeditor/filemanager/connectors/php/upload.php?Type=File");?>',
				filebrowserImageUploadUrl : '<?php echo base_url("assets/admincms/js/ckeditor/filemanager/connectors/php/upload.php?Type=Image");?>',
				filebrowserFlashUploadUrl : '<?php echo base_url("assets/admincms/js/ckeditor/filemanager/connectors/php/upload.php?Type=Flash");?>'
			});
		
		});

	//]]>
	</script>
    
    
        
    </body>
    
    
    
</html>