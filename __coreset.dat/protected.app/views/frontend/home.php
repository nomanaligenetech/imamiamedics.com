
<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyA8EuVGT4PCuU6uoih7Isu6PhR955Qu_uo&sensor=true"></script>
<div class="hwrap mainBody">
    <div class="cont2">
        <?php
        if(is_countryCheck(FALSE,FALSE,TRUE) == 'canada'){ ?>
            <div class="charitydiv">
                <div class='charityinnerdiv'>
                    <span class='label'>CRA Charity Reg #:</span>
                    <span class='chr-num'>834140048 RR 0001</span>
                </div>
                <a href="<?php echo site_url();?>page/donate.html" class="donation-button">
                    <?php $imageExist = file_exists("./assets/frontend/images/donate_btn_blue-".is_countryCheck(true)."_".strtolower(SessionHelper::_get_session('LANG_CODE')).".png"); ?>
                    <img src="<?php echo base_url("assets/frontend/images/donate_btn_blue-".is_countryCheck(true)."_".strtolower($imageExist?SessionHelper::_get_session('LANG_CODE'):DEFAULT_LANG_CODE).".png");?>" alt="donate_btn" /> 
                    <span class="sp1"></span> <span class="sp2"></span> 
                </a>
            </div>
            
        <?php
        }
        ?>
        <!-- # CENTER MENU -->
        <?php
        if ( $centermenu -> num_rows() > 0 )
        {
        ?>
            <div class="hwrap bg_offwhite site_links_sec">
                <div class="cont1">
                <h1 class="h1Style1 m_top0 m_bottom20"><?php echo lang_line('heading_whatwedo')?></h1>
                    <ul class="ulli1">
                        <?php
                        $x = 0;
                        foreach ( $centermenu -> result_array() as $cm )
                        {
                            if($x > 4){
                                break;
                            }
                            $x++;
                            $TMP_content                    = $this->mixed_queries->fetch_records("cmscontent", " AND  menuid = '". $cm['id'] ."' ");   
                            $TMP_attributes                 = $this->functions->set_link_attributes( $cm, $TMP_content, SLUG_PAGE );
                            $cm['photo_image']              = $this->functions->replace_img_by_lang($cm['photo_image']);
                        ?>
                            <li>
                                <a href="<?php echo $TMP_attributes['href'];?>">
                                    <img src="<?php echo $this->functions->timthumb( $cm['photo_image'], 285, 114, FALSE, FALSE );?>" alt="<?php echo $cm['name'];?>" />
                                </a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        <?php
        }
        ?>
        <!-- # CENTER MENU -->
        
        <!-- # WHERE WE WORK -->
        <?php
        if ( $wherewework -> num_rows() > 0 )
        {
        ?>
            <div class="hwrap bg_white global_sec3">
                <div class="cont1">
                    
                    <div class="hwrap m_top50">
                    
                    
                    <?php
                        $btnType = $spotlight->row("button_type");
                        if($btnType == 1){
                            $btnText = "Learn More";
                            $btnTypeClass = "learn-more";
                        }
                        if($btnType == 2){
                            $btnText = "Donate Now";
                            $btnTypeClass = "donate-now";
                        }

                        // $btnText = $spotlight->row("button_type") == 1 ? "Learn More" : (($spotlight->row("button_type") == 2) ? "Donate Now" : "");
                        $videoLink = $spotlight->row("url");


                        if (strpos($videoLink, "youtube")) {
                            parse_str(parse_url($videoLink, PHP_URL_QUERY), $my_array_of_vars);
                            $videoParams = "https://www.youtube.com/embed/" . $my_array_of_vars['v'];
                        }
                        if (strpos($videoLink, "vimeo")) {
                            $videoParams = "https://player.vimeo.com/video/" . (int) substr(parse_url($videoLink, PHP_URL_PATH), 1);
                        }
                        ?>
                        <div class="map_wrap">
                            <div class="fiftySec1">
                                <h2 class="h2Style1"><?php echo lang_line('heading_spotlight') ?></h2>
                                <div class="video-wrap">

                                        <?php if (is_countryCheck(FALSE, FALSE, TRUE) != 'medics') : ?>
                                                <iframe src="<?php echo $videoParams; ?>" frameborder="0"></iframe>
                                        <?php else: ?>
                                                <iframe src="https://www.youtube.com/embed/ORr9luDKR0Q" frameborder="0"></iframe>
                                        <?php endif; ?>

                                        <div class="text-wrap">

                                        <?php if (is_countryCheck(FALSE, FALSE, TRUE) != 'medics') : ?>
                                            <?php echo $spotlight->row("button_type") > 0 ? "<a href=".$spotlight->row("button_link")." class=".$btnTypeClass."> $btnText </a>" : ""; ?> 
                                        <?php else: ?>
                                            <a href="https://medicsinternational.org/page/upcoming-events/events/atlanta-umc-dinner-and-auction" class="learn-more"> Learn More </a>
                                        <?php endif; ?>

                                        <h3><?php
                                            if (is_countryCheck(FALSE, FALSE, TRUE) != 'medics') :
                                                echo $spotlight->row("title"); 
                                            else:
                                                echo "Support the University Medical Complex";
                                            endif;
                                        
                                        ?></h3>
                                    </div>
                                    <p><?php 
                                        if (is_countryCheck(FALSE, FALSE, TRUE) != 'medics') :
                                            echo $spotlight->row("short_desc"); 
                                        else:
                                            echo "Work is underway on our Landmark UMC Project: the 500-bedded health care facility had its groundbreaking and the laying of its foundation stone in December 2022. Join us at events happening across the world to help support the University Medical Complex.";
                                        endif;
                                    
                                    ?></p>
                                    
                                </div>
                            </div>
                        </div>
                    
                    
                    
                    
                        <div class="fiftySec2 fiftySec2_res">
                    <h1 class="h2Style1"><?php echo lang_line('heading_impacting_millions') ?></h1>
                        <br>
                            <h2 class="h2Style1"><?php echo $wherewework->row("title"); ?></h2>

                            <div class="arialGrey16px m_top20 trimText">
                                <?php 
                                if (is_countryCheck(FALSE, FALSE, TRUE) != 'medics') :
                                    echo $wherewework->row("short_desc"); 
                                else:
                                    echo "<p>With many international chapters, projects and partners, our presence spans across five continents. Medics International is comprised of active regional chapters in Europe and East Africa and national chapters in Australia, Canada, India, Iraq, Ireland, New Zealand, Pakistan, the United Kingdom and the United States. Local chapters at state and city levels exist in many of these locations as well. Medics International's Global Headquarters are located in Princeton, New Jersey, USA.</p>

                                    <p>A registered 501(c)(3) non-profit in the US, MI also holds Special Consultative Status with the United Nations Economic and Social Council since 2006 and accreditation by the United Nations Department of Global Communications (formerly the United Nations Department of Public Information) since 2001.</p>

                                    <p>We are funded by members and people like you. Our beneficiaries include individuals from all backgrounds without regard to religious affiliation (or lack thereof).</p>
                                    ";
                                endif;
                                
                                ?>
                                <a class="read-more" href="#">more</a>

                            </div>
                            
                            <a href="javascript:;" class="ellipseReadMore"><?php echo lang_line('text_readmore')?></a> 
                        </div>
                        
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
        <!-- # WHERE WE WORK -->
    
        <!-- # WHAT WE DO -->
        <?php 
        if ( $timelinehistory -> num_rows() > 0 ) 
        {
        ?>
            <a id="hash_timeline" name="hash_timeline">&nbsp;</a>
            <!-- # WHAT WE DO # -->
            <div class="hwrap evn_his bg_Offwhite">
                <div class="evn_his_head hwrap">
                    <h1><?php echo lang_line('heading_our_story')?></h1>
                    <!--<span>Timeline of our History</span> -->
                </div>
                
                <div class="hwrap pos_rel timeline_sec">
                    <div class="evn_his_rod"></div>
                    
                    <div class="cont1">
                        <div class="evn_his_slider">
                        
                        
                            <?php 
                            foreach ( $timelinehistory -> result_array() as $wwd)
                            {
                                $timelinehistory_languages = $this->queries->fetch_records("timelinehistory_languages", " AND timelinehistory_id = {$wwd['id']}")->result_array();
                                replace_data_for_lang($wwd, $content_languages, $timelinehistory_languages, ['title','short_desc','full_desc'], SessionHelper::_get_session('LANG_CODE') );	                    
                            ?>
                                <div class="item">
                                    <div class="hwrap align_center"> <span class="rod_pointer"></span> </div>
                                    <a href="<?php echo site_url( SLUG_TIMELINE . "/" . $wwd['slug'] );?>">
                                        <div class="hwrap align_center">
                                            <span class="yr">
                                                <?php echo $wwd['year'];?>
                                            </span> 
                                        </div>
                                        
                                        
                                        <div class="hwrap align_center"> 
                                            <?php echo $this->functions->timthumb($wwd['photo_image'], 259, 205);?>
                                        </div>
                                        
                                        <div class="hwrap align_center">
                                            <h3><?php echo $wwd['title'];?></h3>
                                            <span class="dscp"><?php echo $wwd['short_desc'];?></span> 
                                        </div>
                                    </a> 
                                </div>
                                
                            <?php
                            }
                            ?>
                            
                            
                        </div>
                    </div>
                    
                    
                    <div class="customNavigation"> <a class="prevBtn"></a> <a class="nextBtn"></a> </div>
                    
                </div>
            </div>
        <?php
        }
        ?>
        <!-- # WHAT WE DO -->
        
        
        
        
        <!-- # GET INVOLVED -->
        <?php
        if ( $getinvolved -> num_rows() > 0 )
        {
             $data['home']="HOME";
        ?>
            <div class="hwrap bg_white getInvolde_sec">
                <h1 class="h1Style1"><?php echo lang_line('heading_get_involved')?></h1>
            
                <ul class="ulli2 cont1">
                    <?php echo $this->load->view('frontend/template/_getinvolved.php',$data);?>
                </ul>
                
            </div>
        <?php
        }
        ?>
        
        
        
        
        <!-- # EVENTS LIST -->
        <?php
        if(is_countryCheck(FALSE,FALSE,TRUE) != 'medics'){
            if ( $eventslist -> num_rows() > 0 )
            {
                /*style="background-image:url(<?php echo $this->functions->timthumb( $eventslist->row('photo_image'), 1376, 817, FALSE, FALSE );?>)"*/
                
                $this->queries->fetch_records( "sitesectionswidgets_details", " AND parentid = '". $eventslist->row('id') ."' ", " sitesections_id " );
                $TMP_menu       = $this->queries->fetch_records( "cmsmenu", " AND id IN ( ". $this->db->last_query() ." ) LIMIT 1  " );
                $TMP_url        = site_url( SLUG_PAGE . "/" . $TMP_menu->row("slug") . "/" . SLUG_EVENTS . "/" . $eventslist->row('slug') );
            ?>
                
                <div class="hwrap imi_events" style="background:url(<?php echo $this->functions->timthumb( $eventslist->row('photo_image'), 1376, 817, FALSE, FALSE );?>)"  >
                    <div class="imi_event_overlay">
                    <h1 class="h1Style1 h1Style1b"><?php echo lang_line('text_imievents')?></h1>
                    <div class="cont1">
                    
                        <div class="hwrap m_top50">
                        
                            <div class="fiftySec1" onclick="window.location = '<?php echo $TMP_url;?>'" style="cursor:pointer;">
                                <div class="sec1"> 
                                    <?php echo $this->functions->timthumb( $eventslist->row('photo_image'), 587, 278 );?>
                                    
                                    <h3><?php echo lang_line('text_upcomingevents')?></h3>
                                    
                                    <?php
                                    if ( $this->validations->is_date( $eventslist->row('start_date') ) )
                                    {
                                    ?>
                                        <div class="date">
                                            <span class="day"><?php echo date("d", strtotime( $eventslist->row("start_date") ));?></span> 
                                            <span class="month"><?php echo date("M", strtotime( $eventslist->row("start_date") ));?></span>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                
                                <div class="sec2">
                                    <h2><?php echo $eventslist->row('title');?></h2>
                                    <ul class="ulli3">
                                        <li class="icon_time1"><?php echo date("h:i:A", strtotime($eventslist->row('start_date')));?></li>
                                        
                                        <li class="icon_address1"><?php echo $eventslist->row('address');?></li>
                                    </ul>
                                    <p class="fontStyle1"><?php echo word_limiter($eventslist->row('short_desc'),30);?></p>
                                </div>
                            </div>
                            
                            <?php
                            if ( $eventslist->num_rows() > 1 )
                            {
                                $is_not_first_index                 = 0;
                                foreach ($eventslist->result() as $el )
                                {
                                    $el = (array) $el;
                                    if ( $is_not_first_index )
                                    {
                                        $this->queries->fetch_records( "sitesectionswidgets_details", " AND parentid = '". $el['id'] ."' ", " sitesections_id " );
                                        $TMP_menu       = $this->queries->fetch_records( "cmsmenu", " AND id IN ( ". $this->db->last_query() ." ) LIMIT 1  " );
                                        
                                        $TMP_url        = site_url( SLUG_PAGE . "/" . $TMP_menu->row("slug") . "/" . SLUG_EVENTS . "/" . $el['slug'] );
                                    ?>
                                    
                                        <div class="fiftySec2">
                                            <div class="fiftySec2_1" onclick="window.location = '<?php echo $TMP_url;?>';" style="cursor:pointer;"> 
                                                
                                                    <?php echo $this->functions->timthumb( $el['photo_image'], 286, 255 );?>
                                                    <div class="title"><?php echo $el['title'];?></div>
                                                    <div class="detail_layer">
                                                        <ul>
                                                            <?php
                                                            if ( $this->validations->is_date( $el['start_date'] ) )
                                                            {
                                                            ?>
                                                                <li class="icon_date2"><?php echo date("F, d Y", strtotime( $el['start_date'] ));?></li>
                                                                <li class="icon_time2"><?php echo date("h:i:A", strtotime( $el['start_date'] ));?></li>
                                                            <?php
                                                            }
                                                            ?>
                                                            <li class="icon_address2"><?php echo $el['address'];?></li>
                                                        </ul>
                                                    </div>
                                            </div>                                                
                                        </div>
                                        
                                    <?php
                                    }
                                    
                                    $is_not_first_index++;
                                }
                            }
                            ?>
                        </div>
                    <div class="hwrap m_top50 align_center"> <a href="<?php echo site_url(  SLUG_PAGE . "/upcoming-events" );?>" class="btn_blue1"><?php echo lang_line('text_moreevents')?></a> </div>
                    </div>
                    </div>
                </div>
            <?php
            }
        }
        ?>
    </div>
</div>
