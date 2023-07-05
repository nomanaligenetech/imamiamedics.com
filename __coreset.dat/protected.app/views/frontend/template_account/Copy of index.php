<?php $this->load->view('frontend/template_account/_head.php');?>

<body class="skin-black">
	
    <div class="menu_active" style="display:none;">
    	<h1><?php echo $menu_active;?></h1>	
    </div>

	
    
    
    <div class="hwrap header">
        <div class="cont2 pos_rel bg_white">
            
        	<?php
			if ($showThings['_show_HEADER'])
			{
				$this->load->view('frontend/template/_header.php');
			}
			
			if ($showThings['_show_SLIDER'])
            {
               
            }
			 $this->load->view('frontend/template/_static_slider.php');
			?>
            
        </div>
    </div>

	<?php
	if ( 1==1 )
	{
	?>
		<div class="hwrap mainBody pos_rel  bb">
        	
              
                    		
            <div class="innerpage">
                <div class="container">
                    <div class="innerpage-1col-template">
                        <div class="innerpage-content">
								
								<?php $this->load->view("frontend/template_account/_header.php");?>
                                 
                                 
                                <div class="wrapper row-offcanvas row-offcanvas-left">
									<?php $this->load->view("frontend/template_account/_left.php");?>
    
                                    
                                    <aside class="right-side">
                                    
                                        <section class="content-header">
                                            <h1> <?php echo $_heading;?> </h1>
                                        </section>
    
                                        <section class="content">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                
                                                    <div class="box">
                                                        <div class="box-header">
                                                        </div>
                                                    
                                                        <div class="box-body table-responsive">
                                                            <?php 
                                                            $this->load->view('frontend/template_account/_show_messages.php');
                                                            
                                                            $this->load->view($_pageview) ;
                                                            ?>        
                                                        </div>      
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </section>
                                    
                                    </aside>
                                
                                </div>
                                
                                
						</div>
            		</div>
				</div>
			</div>
            				        
            		
				
				
			
         </div>
	<?php
	}
	
	
	
	
	if ($showThings['_show_FOOTER'])
	{
		$this->load->view('frontend/template/_footer.php');
	}	
	?>

</body>
</html>	