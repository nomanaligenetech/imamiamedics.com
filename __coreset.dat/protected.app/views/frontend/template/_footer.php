<div class="cont2 footer ">
	<?php
	if ( $bigfootermenus -> num_rows() > 0 )
	{
		$siteIdQuery										= getSiteId();
	?>
    	<div class="hwrap footer_sec1 bg_Offwhite">
        <div class="cont1 p_Top30 TopGreyBdr">
            <div class="fl_lft sec1_1">
            	<?php
				foreach ( $bigfootermenus -> result_array() as $fm )
				{
					$sub_footermenus						= $this->queries->fetch_records('cmsmenu', " AND parentid = '". $fm['id'] ."' ".$siteIdQuery);

					$cmsmenu_languages = $this->queries->fetch_records("cmsmenu_languages", " AND cmsmenu_id = {$fm['id']}")->result_array();
					replace_data_for_lang($fm, $content_languages, $cmsmenu_languages, ['name', 'subheading'], SessionHelper::_get_session('LANG_CODE') );
				?>
                    <div>
                        <h3><?php echo $fm['name'];?></h3>
                        <?php
						if ( $sub_footermenus -> num_rows() > 0 )
						{
						?>
							<ul>
								<?php
								foreach ( $sub_footermenus -> result_array() as $s_fm ) 
								{
									$TMP_content					= $this->mixed_queries->fetch_records("cmscontent", " AND  menuid = '". $s_fm['id'] ."' ");	
									$TMP_attributes					= $this->functions->set_link_attributes( $s_fm, $TMP_content, SLUG_PAGE );

									$cmsmenu_child_languages = $this->queries->fetch_records("cmsmenu_languages", " AND cmsmenu_id = {$s_fm['id']}")->result_array();
									replace_data_for_lang($s_fm, $content_languages, $cmsmenu_child_languages, ['name', 'subheading'], SessionHelper::_get_session('LANG_CODE') );				
								?>
									<li>
										<a target="<?php echo $TMP_attributes['target'];?>" href="<?php echo $TMP_attributes['href'];?>">
											<?php echo $s_fm['name'];?>
										</a>
									</li>
								<?php 
								}
								?>
							</ul>
						<?php
						}
						?>
                    </div>
                <?php
				}
				?>
            </div>
            
        	<div class="fl_lft sec1_2"> 
                <a href="<?php echo site_url();?>page/donate.html" class="donate_btn"> 
					<?php $imageExist = file_exists("./assets/frontend/images/donate_btn_orange-".is_countryCheck(true)."_".strtolower(SessionHelper::_get_session('LANG_CODE')).".png"); ?>
					<img src="<?php echo base_url("assets/frontend/images/donate_btn_orange-".is_countryCheck(true)."_".strtolower($imageExist?SessionHelper::_get_session('LANG_CODE'):DEFAULT_LANG_CODE).".png");?>" alt="donate_btn" /> 
                	<span class="sp1"></span> 
                    <span class="sp2"></span> 
				</a>
				<?php
				if(is_countryCheck(FALSE,FALSE,TRUE) == 'canada'){?>
				<a href="https://www.guidestar.org/profile/22-3309208" target="_blank"><img src="<?php echo base_url("assets/frontend/images/canada-footerlogo.png");?>"></a>
				<?php } else { ?>
					<a href="https://www.guidestar.org/profile/22-3309208" target="_blank" class="external-logo"><img src="https://widgets.guidestar.org/gximage2?o=7082160&amp;l=v4"></a>
				<?php } ?>
            </div>
        </div>
    </div>
    <?php
	}
	?>

    <div class="hwrap footer_sec2 p_TopBottom30">
    
        <div class="cont1">
        	
            <?php
			if ( $footermenus_parent -> num_rows() > 0 )
			{
			?>
                <div class="fl_lft">
                    <ul class="ulli4">
						<li>
							<a target="_parent" href="<?php echo site_url();?>"><?php echo lang_line('text_home'); ?></a>
						</li>
						<li>|</li>
                    	<?php
						$i = 0;
						foreach ( $footermenus_child -> result_array() as $fm )
						{
							$i++;
							$TMP_content					= $this->mixed_queries->fetch_records("cmscontent", " AND  menuid = '". $fm['id'] ."' ");	
							$TMP_attributes					= $this->functions->set_link_attributes( $fm, $TMP_content, SLUG_PAGE );

							$cmsmenu_child_languages = $this->queries->fetch_records("cmsmenu_languages", " AND cmsmenu_id = {$fm['id']}")->result_array();
							replace_data_for_lang($fm, $content_languages, $cmsmenu_child_languages, ['name', 'subheading'], SessionHelper::_get_session('LANG_CODE') );
							?>
                            	<li>
                                <a target="<?php echo $TMP_attributes['target'];?>" href="<?php echo $TMP_attributes['href'];?>">
									<?php echo $fm['name'];?>
                                </a>
                                </li>
                                
                                
                                <?php 
								if ( $footermenus_child -> num_rows() != $i ) 
								{ 
								?>
                        			<li>|</li>
                                <?php 
								} 
						}
						?>
                    </ul>
                    
                    
                    <p class="m_top5 hwrap">
					<?php
					$TMP_content					= $this->mixed_queries->fetch_records("cmscontent", " AND  menuid = '". $footermenus_parent->row("id") ."' ");	
					$TMP_attributes					= $this->functions->set_link_attributes( $footermenus_parent->row_array(), $TMP_content, SLUG_PAGE );

					$cmscontent_languages = $this->queries->fetch_records("cmscontent_languages", " AND cmscontent_id = {$TMP_content->row('id')}")->result_array();
					replace_data_for_lang($TMP_attributes, $content_languages, $cmscontent_languages, ['content'], SessionHelper::_get_session('LANG_CODE') );

					
					if( is_countryCheck(FALSE,FALSE,TRUE) == 'canada' ){
						echo $this->functions->find_and_replace(0,"Imamia Medics Canada", $TMP_attributes['content']);
					}else if(is_countryCheck(FALSE,FALSE,TRUE) == 'medics'){
						echo $this->functions->find_and_replace(0,"Medics International", $TMP_attributes['content']);
					}else{
						echo $TMP_attributes['content'];
					}?>
                    </p>
                </div>
            
            
            
				<?php
                if ( $footer_socialbuttons -> num_rows() > 0 )
                {
                ?>
                    <div class="fl_rit">
                    
                        <ul class="smedia_list1 fl_lft">
                        	<?php
							foreach ( $footer_socialbuttons -> result_array() as $fsb )
							{
								$TMP_content					= $this->mixed_queries->fetch_records("cmscontent", " AND  menuid = '". $fsb['id'] ."' ");	
								$TMP_attributes					= $this->functions->set_link_attributes( $fsb, $TMP_content, SLUG_PAGE );
							?>
                            	<li>
                                	<a target="<?php echo $TMP_attributes['target'];?>" href="<?php echo $TMP_attributes['href'];?>">
                                    	<img src="<?php echo $this->functions->timthumb( $fsb['photo_image'], "", 30, FALSE, FALSE );?>"  alt="<?php echo $fsb['name'];?>" />
                                    </a>
                                </li>
							<?php
							}
							?>
                        </ul>
                    </div>
                <?php
                }
			}
			?>
        </div>
        
    </div>
</div>
