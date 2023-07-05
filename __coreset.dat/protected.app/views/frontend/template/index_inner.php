<?php $this->load->view('frontend/template/_head.php');

$lang = getCurrentLang($content_languages);
?>

<body lang="<?php echo $lang['code']; ?>" dir="<?php echo $lang['direction']; ?>" class="<?php echo is_countryCheck(true); ?> <?php echo $lang['direction']; ?> lang-<?php echo $lang['code']; ?>">
	
    <div class="menu_active" style="display:none;">
    	<h1><?php echo $menu_active;?></h1>	
    </div>

	

	<?php
	if ( 1==1 )
	{
	?>
		<div class="websitewrapper">
    
			<?php
            if ($showThings['_show_HEADER'])
            {
                $this->load->view('frontend/template/_header.php');
            }
            
            
            if ($showThings['_show_SLIDER'])
            {
                $this->load->view('frontend/template/_dynamic_slider.php');
            }
            else
            {
                $this->load->view('frontend/template/_static_slider.php');
            }
            
			
			
            if ($showThings['_show_CONF_NAVIGATION'])
            {
                $this->load->view('frontend/template/_confnavigation.php');
            }
            
            if ($showThings['_show_CONF_PARTNERS'])
            {
                $this->load->view('frontend/template/_confpartners.php');
            }
            ?>
            
            
            
       
        
            
            <div class="innerpage">
                <div class="container">
                    <div class="innerpage-1col-template">
                        <div class="innerpage-content">
                        	<div class="contentarea">
								<?php
								if ( $h1 )
								{
								?>
									<h1><?php echo $h1;?></h1>
								<?php
								}                
								$this->load->view('frontend/template/_show_messages.php');
								
								$this->load->view($_pageview);
								?>
							</div>
						</div>
            		</div>
				</div>
			</div>
			
            <?php
            
            
            if ($showThings['_show_SUS_ASSOCIATE_PARTNERS'])
            {
                $this->load->view('frontend/template/_susassociatepartners.php');
            }
            
            if ($showThings['_show_PREV_CONF'])
            {
                $this->load->view('frontend/template/_prevconference.php');
            }
 
   
			if ($showThings['_show_FOOTER'])
			{
				echo '<div class="footer">';
				$this->load->view('frontend/template/_footer.php');
				echo '</div>';
			}	
		?>
        
        
         </div>
        <?php

	}
	?>
    

</body>
</html>	