<?php
/*if ( isset($slider_images) )
{
	if ( count($slider_images) >  0 )
	{
	?>
        <div id="wowslider-container1">
            <div class="ws_images">
                <ul>
                    <li>
                        <a href="javascript:;">
                            <img src="<?php echo $this->functions->timthumb($slider_images[0], 830, 480, FALSE, FALSE);?>" alt="javascript slider" title="event_img_1" id="wows1_0"/>
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="ws_thumbs">
                <div>
                <?php
                $img 			= array();
                $a				= 0;
                foreach( $slider_images as $si )
                {
                    $img[$a]['src']				= $this->functions->timthumb($si, $IMAGES_details['size']['width'], $IMAGES_details['size']['height'], FALSE, FALSE); 
                    ?>
                        <a href="<?php echo  $img[$a]['src'];?>" >
                            <img src="<?php echo $this->functions->timthumb($si, $IMAGES_details['thumb_size']['width'], $IMAGES_details['thumb_size']['height'], FALSE, FALSE);?>" alt="" />
                        </a>
                    <?php	
                    $a++;
                }
                
                ?>
                </div>
            </div>
            
            
            <div class="ws_shadow"></div>
        </div>
        
        
        
        <script>
        var JSON_Images = <?php echo json_encode($img);?>;
        </script>
        <link rel="stylesheet" type="text/css" href="<?php echo FOLDER_WIDGETS . "wowslider_1/engine1/style.css";?>" />
        <script type="text/javascript" src="<?php echo	FOLDER_WIDGETS . "wowslider_1/engine1/wowslider.js" ;?>"></script>
        <script type="text/javascript" src="<?php echo	FOLDER_WIDGETS . "wowslider_1/engine1/script.js";?>"></script>
	<?php
	}
}*/
?>

<style type="text/css">
.slick-prev {left: 10px!important;z-index: 99999;}
.slick-next {right: 10px!important;z-index: 99999;}
.slick-frame {visibility: hidden;}
.slick-frame.slick-initialized {visibility: visible;}
#events_slider_nav .slick-current{border-bottom: 2px solid #f00;outline: none!important;}
#events_slider_nav .slick-slide:focus{border-bottom: 2px solid #0070b0;outline: none!important;}
/*#events_slider_nav .slick-track{transform:initial !important}*/
</style>

<?php
if ( isset($slider_images) )
{
    if ( count($slider_images) >  0 )
    {
        ?>
        <div id="events_slider" style="width:100%;float:left;">
            <?php
            foreach ($slider_images as $key => $image) { ?>

            <li>
                <a href="javascript:;">

                    <img src="<?php echo $this->functions->timthumb($image['photo_other_image'], 830, 480, FALSE, FALSE);?>" alt="javascript slider" title="event_img_".<?php echo $key;?>/>

                </a>
            </li>

            <?php }
            ?>
        </div>
        <div id="events_slider_nav" style="width:100%;float:left;">
            <?php
            $img            = array();
            $a              = 0;
            
            foreach( $slider_images as $si )
            {
                $img[$a]['src']             = $this->functions->timthumb($si['photo_other_image'], $IMAGES_details['size']['width'], $IMAGES_details['size']['height'], FALSE, FALSE); 
                ?>
                <a href="javascript:;" >
                    <img src="<?php echo $this->functions->timthumb($si['photo_other_image'], $IMAGES_details['thumb_size']['width'], $IMAGES_details['thumb_size']['height'], FALSE, FALSE);?>" alt="" />
                </a>
                <?php   
                $a++;
            }

            ?>
        </div>

        <?php
    }
}

?>

<link rel="stylesheet" type="text/css" href="<?php echo FOLDER_WIDGETS.'slick-1.8.0/slick/slick.css'?>"/>
<!-- Add the slick-theme.css if you want default styling -->
<link rel="stylesheet" type="text/css" href="<?php echo FOLDER_WIDGETS.'slick-1.8.0/slick/slick-theme.css'?>"/>

<script type="text/javascript" src="<?php echo FOLDER_WIDGETS.'slick-1.8.0/slick/slick.js'?>"></script>

<script type="text/javascript">

    $('#events_slider').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: true,
      fade: true,
      infinite: false,
      asNavFor: '#events_slider_nav'
  });
    $('#events_slider_nav').slick({
      slidesToShow: 8,
      slidesToScroll: 1,
      asNavFor: '#events_slider',
      dots: false,
      centerMode: false,
      focusOnSelect: true
  });

</script>