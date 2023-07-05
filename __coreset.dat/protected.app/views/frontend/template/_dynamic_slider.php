<?php
if (  $site_gallery -> num_rows() > 0  )
{
?>
    <div class="hwrap main_slider <?php echo is_countryCheck(true);?>">
        <div class="owl-carousel">
            
            <?php
            foreach ( $site_gallery -> result_array() as $sg )
            {
                $site_gallery_languages = $this->queries->fetch_records("site_gallery_languages", " AND site_gallery_id = {$sg['id']}")->result_array();
                replace_data_for_lang($sg, $content_languages, $site_gallery_languages, ['caption_h1','caption_h2'], SessionHelper::_get_session('LANG_CODE') );	
    
				$TMP_href					= "javascript:;";
				$TMP_target					= "_parent";
				if (  $sg['content'] != "" )
				{
					$TMP_href					= $sg['content'];
					$TMP_target					= $sg['target'];
				}
				
				$window_open					= 'window.open("'. "afa" .'", "'. $TMP_target .'")';
            ?>
                <div class="item">
                	<a class="item link" target="<?php echo $TMP_target;?>" href="<?php echo $TMP_href;?>">
                    	<img src="<?php echo base_url( $sg['photo_image'] );?>" />
                    </a>
                    <?php /*
                    <div class="slide_inner">
                        <div class="cont1">
                        
                            <div class="fl_lft">

                                <h3><?php echo $sg['caption_h1'];?></h3>
                                <p><span class="tagline"><?php echo $sg['caption_h2'];?></span></p>
                            </div>

                            <a href="<?php echo site_url();?>page/donate.html" class="donate_btn">
                                <img src="<?php echo base_url("assets/frontend/images/donate_btn_blue.png");?>" alt="donate_btn" /> 
                                <span class="sp1"></span> <span class="sp2"></span> 
                            </a>
                            <a href="https://www.guidestar.org/profile/22-3309208" target="_blank" class="external-logo"><img src="https://widgets.guidestar.org/gximage2?o=7082160&amp;l=v4"></a>
                            
                        </div>
                    </div>
                    */?>

                    <div class="slider-bottom-strip" onclick="window.location.href='<?php echo $TMP_href;?>'">
                        <div class="cont1">
                            <div class="strip-wrap">
                        
                                <div class="captions">
                                    <h3><?php echo $sg['caption_h1'];?></h3>
                                    <span class="tagline"><?php echo trim($sg['caption_h2']) ? $sg['caption_h2'] : "&nbsp;";?></span>
                                </div>

                                <?php
                                if(is_countryCheck(FALSE,FALSE,TRUE) == 'canada'){?>
                                    <a href="https://www.guidestar.org/profile/22-3309208" target="_blank" class="transparency-seal"><img src="<?php echo base_url("assets/frontend/images/canadawhitelogo.png");?>"></a>
                                <?php } else { 
                                    // if($sg['id'] != "50" && $sg['id'] != "51"){
                                    ?>
                                    <a href="https://www.guidestar.org/profile/22-3309208" target="_blank" class="transparency-seal"><img src="https://widgets.guidestar.org/gximage2?o=7082160&amp;l=v4"></a>
                                    <?php $page_link = ( $sg['content'] != "" && $sg['content'] != "javascript:;" ? $sg['content'] : 'page/donate.html'); ?>
                                    <a href="<?php echo site_url();?><?php echo $page_link ?>" class="donation-button">
                                        <?php $imageExist = file_exists("./assets/frontend/images/donate_btn_blue-".is_countryCheck(true)."_".strtolower(SessionHelper::_get_session('LANG_CODE')).".png"); ?>
                                        <img src="<?php echo base_url("assets/frontend/images/donate_btn_blue-".is_countryCheck(true)."_".strtolower($imageExist?SessionHelper::_get_session('LANG_CODE'):DEFAULT_LANG_CODE).".png");?>" alt="donate_btn" />  
                                        <span class="sp1"></span> <span class="sp2"></span> 
                                    </a>
                                <?php // } 
                                } ?>
                            </div>
                        </div>
                    </div>
                    
                </div>
            <?php
            }
            ?>
            
    
            
        </div>
    </div>
<?php
}
?>