<div class="hwrap slider">
    <div class="cont2 pos_rel bg_white">
        <div class="hwrap main_slider inner-banners">
            <div class="owl-carousel">
                <div class="item">
                    
                    <img src="<?php echo base_url("assets/frontend/images/inner_banner.jpg");?>" alt="mainslider_img1"/>
                        
                        <!-- <div class="slide_inner">
                        
                            <div class="cont1">
                            
                                <div class="fl_lft banner-title">
                                    <h3>Save a life, save humanity</h3>
                                    <span class="tagline">keeping individuals and opportunity alive</span> 
                                </div>
                                
                                <a href="<?php echo site_url();?>page/donate.html" class="donate_btn">
                                    <img src="<?php echo base_url("assets/frontend/images/donate_btn_blue.png");?>" alt="donate_btn"/> 
                                    <span class="sp1"></span> 
                                    <span class="sp2"></span>
                                </a>
                                
                            </div>
                            
                        </div> -->

                        <div class="slider-bottom-strip static">
                        <div class="cont1">
                            <div class="strip-wrap">
                        
                                <div class="captions">
                                    <h3><?php echo lang_line('heading_banner_savealife'); ?></h3>
                                    <span class="tagline"><?php echo lang_line('heading_banner_keepingalive'); ?></span>
                                </div>

                                <?php $page_link = is_countryCheck(FALSE,FALSE,TRUE) == 'medics' ? "Donate-Medics-International" : "donate.html"; ?>

                                <a href="<?php echo site_url();?>page/<?php echo $page_link ?>" class="donation-button">
                                    <?php $imageExist = file_exists("./assets/frontend/images/donate_btn_blue-".is_countryCheck(true)."_".strtolower(SessionHelper::_get_session('LANG_CODE')).".png"); ?>
                                    <img src="<?php echo base_url("assets/frontend/images/donate_btn_blue-".is_countryCheck(true)."_".strtolower($imageExist?SessionHelper::_get_session('LANG_CODE'):DEFAULT_LANG_CODE).".png");?>" alt="donate_btn" /> 
                                    <span class="sp1"></span> <span class="sp2"></span> 
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>