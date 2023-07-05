<?php
if ( isset($slider_images)  )
{
	if ( count($slider_images) >  0 )
	{
	?>
    	<section id="slider_wrapper">
			<div id="slider" class="divas-slider three_images_slider">
				<ul class="divas-slide-container">
                
     
                    
					<?php
					foreach( $slider_images as $si )
					{
						
					?>
                    	 <li class="divas-slide">
                         	<img src="<?php echo base_url("assets/widgets/divaslider/images/placeholder.gif");?>" alt="" 
                            data-src="<?php echo  $this->functions->timthumb($si, $IMAGES_details['size']['width'], $IMAGES_details['size']['height'], FALSE, FALSE);?>" />
                         </li>
                    <?php
					}
					?>
			    </ul>
			    <div class="divas-navigation">
			        <span class="divas-prev">&nbsp;</span>
			        <span class="divas-next">&nbsp;</span>
			    </div>
                <div class="divas-controls">
                	<span class="divas-start"><i class="fa fa-play"></i></span>
			        <span class="divas-stop"><i class="fa fa-pause"></i></span>
                </div>
			</div>
		</section>
        
        
        <link rel="stylesheet" type="text/css" href="<?php echo FOLDER_WIDGETS . "divaslider/css/divas_free_skin.css" ;?>" />
		<script type="text/javascript" src="<?php echo FOLDER_WIDGETS . "divaslider/js/jquery.divas-1.1.js"  ;?>"></script>
        
        
	<?php
	}
}
?>