<div class="conf-reg-page-top pak_pricing-top-content">
<h1><?php echo lang_line('text_conferenceregistration'); ?></h1>
<p><?php echo conference_fullname($conference); ?></p>
<span><?php echo conference_durationdates($conference); ?> </span> </div>

<?php
#if conf. registration is EXPIRED...
if ($this->validations->is_conference_registration_expired(FALSE)) 
{
    $expired_content        = $this->mixed_queries->fetch_records('conference_content_with_menu', " AND m.slug = 'conference-registration-closed' AND m.conferenceid = '" . $conference->row("id") . "' ");

    if ($expired_content->num_rows() > 0) {
        echo $expired_content->row("content");
    }
}
?>
<style>
    h4 {
        margin: 0;
        padding: 0;
        margin-bottom: 5px;
        margin-top: 5px;
    }
</style>
<?php
if ($conference_regions->num_rows() > 0) 
{
    $content = $conference_regions->row("description");
    if(is_medicsinternational()){
        $rpl_value = array("medicsinternationalpakistan@gmail.com","internationalconf@att.net");
        $CI = &get_instance();
        $content = $CI->functions->find_and_replace(2,$rpl_value,$content);
    }
?>
	<div class="conf-reg-page-content pak_pricing-desciption-content"> <?php echo $this->functions->content_shortcodes($content); ?> </div>
<?php
}


#if conf. registration is not expired
if (!$this->validations->is_conference_registration_expired(FALSE)) 
{
    #echo $confreg_paymenttype_dropdown[ $first_key ];
    ?>
    <div class="pak_pricing-package-wrapper">
	<?php
    if ($who_attend_list->num_rows() > 0) 
    {
    ?>
        <div class="pak_pricing-package-list">
            <ul>
            	<?php
            	foreach ($who_attend_list->result_array() as $wal) 
				{
				?>
                    <li>
                        <div class="pak_pricing-package-icon">
							<?php $package_id_name = url_title($wal['name'], 'dash', true); #strtolower(str_replace(' ', '', $wal['name'])); ?>
                            <a data-href="<?php echo $package_id_name; ?>"><img src="<?php echo base_url($wal['image_icon']); ?>" alt="<?php echo $wal['name']; ?>"></a> 
                        </div>
                        
                        <div class="pak_pricing-package-text">
                            <h4><?php echo $wal['name']; ?></h4>
                            <span><?php echo $wal['description']; ?></span> 
                        </div>
                    </li>
				<?php
				}
            ?>
            </ul>
        </div>
	<?php
	}
	?>
    
    
    
    <?php
	$TMP_whoattendlist_types			=  ( DropdownHelper::conferenceregistration_paymenttype(TRUE, TRUE) );
	krsort( $TMP_whoattendlist_types );
	#unset($TMP_whoattendlist_types ['others'] );
	
	if (count($prices_chart['whoattendlist']) > 0  ) 
	{
		foreach ($who_attend_list->result_array() as $wal) 
		{
			$packages_id_name = url_title($wal["name"], 'dash', true);
			?>
			<div class="pak_pricing-package-details" id="<?php echo $packages_id_name;?>" style="display: block;">
				<div class="pak_pricing-package-name">
					<h2><?php echo $wal["name"];?></h2>
				</div>
				
				<div class="pak_pricing-package-types">
				<?php
				foreach (DropdownHelper::short_conferenceprice_earlybird_regular_dropdown() as $pricetype_earlybird_regular => $leavethis)
				{
					$heading_title          	= "";
					$class_title                = "";
					switch ($pricetype_earlybird_regular) 
					{
						case "earlybird_price":
							#$heading_title    	= "Discounted Early Bird Registration";
							$heading_title    	= "Discounted Advance";
							$class_title        = "early-bird";
							
					
					
							$TMP_to_date		= $conference->row("registration_from");
							$TMP_to_date		= date("F d, Y ", strtotime( $TMP_to_date ) );
	
							$date_text			=  "Deadline: ". $TMP_to_date ."";
							break;
	
						default:
							#$heading_title      = "General Registration";
							$heading_title      = "Onsite Registration";
							$class_title        = "gernal-registration";
							
							
							$TMP_to_date		= $conference->row("registration_to");
							$TMP_to_date		= date("F d, Y",  strtotime("+1 day", strtotime( $TMP_to_date )));
	
							$date_text			=  $TMP_to_date . " onwards";										
							break;
					}
					?>
                    <div class="pak_pricing-package-type <?php echo $class_title ;?>">
                    	<div class="pak_pricing-package-type-name stick-title">
                            <p><?php echo $heading_title;?></p>
                            <p class="custom-date"><span class="tag"></span> <?php echo $date_text;?> </p>
                        </div>
						<?php
                        foreach ($TMP_whoattendlist_types as $members_others_key => $members_others_array)
                        {
							?>
                            <div class="pak_pricing-package-type-col">
                            
                                                        
                                <?php
                                if ( array_key_exists(IMI_OTHERS, $members_others_array) )
								{
									if ( count($prices_chart['whoattendlist'][$members_others_key][$wal['name']][$pricetype_earlybird_regular] ) > 0 )
									{
									?>
                                        <div class="gradiansection" style="border-bottom: 2px solid white;margin-bottom: 20px;">
                                                <div class="gradianshadow"> <?php echo $TMP_whoattendlist_types[$members_others_key][IMI_OTHERS];?> : </div>
                                                <?php
                                                foreach ( $prices_chart['whoattendlist'][$members_others_key][$wal['name']][$pricetype_earlybird_regular] as $k => $p )
                                                {
                                                    ?>
                                                        <p><?php echo $p[IMI_OTHERS]['title_for_price'];?>: <?php echo $p[IMI_OTHERS]['pricedisplay'];?></p>
                                                    <?php
                                                }
                                                ?>
                                        </div>
									<?php
									}
									
								}
								else
								{
									
									foreach ($prices_chart['whoattendlist'][$members_others_key][$wal['name']][$pricetype_earlybird_regular] as $price_master_key => $price_child_array) 
									{
										
									?>
										<div class="pak_pricing-package">
											<div class="pak_pricing-package-img"> 
												<img src="<?php echo base_url($price_child_array[IMI_MEMBER]["image_icon_for_price"]); ?>" alt="<?php echo $price_child_array[IMI_MEMBER]["title_for_price"]; ?>"> 
											</div>
											
											<div class="pak_pricing-package-content">
												<div class="pak_pricing-package-descripion">
													<div class="pak_pricing-package-about">
														<h3><?php echo $price_child_array[IMI_MEMBER]["title_for_price"]; ?></h3>
														<?php echo nl2br($price_child_array[IMI_MEMBER]["description_for_price"]); ?> 
													</div>
													
													<div class="pak_pricing-package-prices">
														<div class="pak_pricing-package-price">
															<p>
																<?php #echo is_medicsinternational() ? $this->functions->find_and_replace(0,'',$TMP_whoattendlist_types[$members_others_key][IMI_MEMBER]) : $TMP_whoattendlist_types[$members_others_key][IMI_MEMBER] ;?>
                                                                Rates
                                                            </p>
															<ul>
																<li><?php echo $price_child_array[IMI_MEMBER]["pricedisplay"]; ?></li>
															</ul>
														</div>
														
														<div class="pak_pricing-package-price" style="display:none;">
															<p>
                                                            	<?php #echo is_medicsinternational() ? $this->functions->find_and_replace(0,'',$TMP_whoattendlist_types[$members_others_key][IMI_NON_MEMBER]) : $TMP_whoattendlist_types[$members_others_key][IMI_NON_MEMBER] ;?>
                                                                Rates
                                                            </p>
															<ul>
																<li><?php echo $price_child_array[IMI_NON_MEMBER]["pricedisplay"]; ?></li>
															</ul>
														</div>
													</div>
												</div>
												<?php
												if (array_key_exists("addon", $price_child_array)) 
												{
													$_AddonsPerPerson_Text				= "Add-ons Per Person";
													if 	( 
															$price_child_array[IMI_MEMBER]['whoattend_weight'] == 4 
															&&
															( 
																$price_child_array[IMI_MEMBER]['title_for_price'] != "Pick & Choose Package for Graduates / Retired / NGO Persons Willing to Attend Both Conferences" 
																&&
																$price_child_array[IMI_MEMBER]['title_for_price'] != "Pick & Choose Package for Students Willing to Attend Both Conferences"

															) 
														)
													{
														$_AddonsPerPerson_Text				= "Add-ons Per Group";	
													}
													else if ( $price_child_array[IMI_MEMBER]['whoattend_weight'] == 2 )
													{
														$_AddonsPerPerson_Text				= "Add-ons Per Couple";	
													}
													
												?>
												<div class="pak_pricing-package-addons" style="display:;'">
													<div class="pak_pricing-package-about">
													<h3><?php echo $_AddonsPerPerson_Text;?></h3>
														<ul>
														<?php
														
														foreach ($price_child_array["addon"] as $addon_key => $addon_array) 
														{
															if ( $addon_array[IMI_MEMBER]["price"] > 0 )
															{
															?>
																<li><?php echo $addon_array[IMI_MEMBER]["title_for_price"]; ?></li>
															<?php
															}
														}
														?>
														</ul>
													</div>
													
													
													<div class="pak_pricing-package-prices">
														<div class="pak_pricing-package-price">
															<ul>
															<?php
															foreach ($price_child_array["addon"] as $addon_key => $addon_array) 
															{
																if ( $addon_array[IMI_MEMBER]["price"] > 0 )
																{
																	?>
                                                                    <li>+ <?php echo $addon_array[IMI_MEMBER]["pricedisplay"]; ?></li>
                                                                    <?php
                                                                    if ($price_master_key == 136 && $pricetype_earlybird_regular != "earlybird_price") 
                                                                    {
                                                                        #print_r($price_child_array["addon"]);
                                                                        #die;	
                                                                    }
																}
															}
															?>
															</ul>
														</div>
														
														<div class="pak_pricing-package-price" style="display:none;">
															<ul>
																<?php
																foreach ($price_child_array["addon"] as $addon_key => $addon_array) 
																{
																	if ( $addon_array[IMI_NON_MEMBER]["price"] > 0 )
																	{
																	?>
																		<li>+ <?php echo $addon_array[IMI_NON_MEMBER]["pricedisplay"]; ?></li>
																	<?php
																	}
																}
																?>
															</ul>
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
								}
                                ?>       
                            </div>
                            
                            <?php
                        }
                        ?>
                    </div>
                    <?php
				}
				?>
				</div>         
			</div>
		<?php
		}
	}
	?>
    
    
    
    
    
    
    <?php
	if (count($prices_chart['whoattendlist']) > 0 and false) 
	{

		foreach ($prices_chart['whoattendlist']['members'] as $whoattendname => $pricetable) 
		{
			$packages_id_name = url_title($whoattendname, 'dash', true); #strtolower(str_replace(' ', '', $whoattendname));
			// var_dump($packages_id_name);die('test');
			?>
            <div class="pak_pricing-package-details" id="<?php echo $packages_id_name; ?>">
                <div class="pak_pricing-package-name">
                	<h2><?php echo $whoattendname; ?></h2>
                </div>
                
                <div class="pak_pricing-package-types">
                <?php
                foreach ($pricetable as $pricetype_earlybird_regular => $master_detail_chart) 
                {
                    #print_r($imi_non_price_chart);die;
    
                    $heading_title          	= "";
                    $class_title                = "";
                    switch ($pricetype_earlybird_regular) 
                    {
                        case "earlybird_price":
                            #$heading_title    	= "Discounted Early Bird Registration";
							$heading_title    	= "Discounted Advance";
                            $class_title        = "early-bird";
                            
                    
                    
                            $TMP_to_date		= $conference->row("registration_to");
                            $TMP_to_date		= date("F d, Y ", strtotime( $TMP_to_date ) );
    
                            $date_text			= "Deadline: ". $TMP_to_date ."";
                            break;
    
                        default:
                            #$heading_title        = "General Registration";
							$heading_title      = "Onsite Registration";
                            $class_title        = "gernal-registration";
                            $date_text			= "(". conference_registrationdates( $conference, TRUE ) .")";												
                            break;
                    }
                    ?>
                    
                    <div class="pak_pricing-package-type <?php echo $class_title; ?>">
                        <div class="pak_pricing-package-type-name">
                            <p><?php echo $heading_title; ?></p>
                            <p class="custom-date"><span class="tag"></span> <?php echo $date_text;?></p>
                        </div>
                        
                        <div class="pak_pricing-package-type-col">
                        <?php
                        #print_r($master_detail_chart);die;
                        foreach ($master_detail_chart as $price_master_key => $price_child_array) 
                        {
                        ?>
                            <div class="pak_pricing-package">
                                <div class="pak_pricing-package-img"> 
                                    <img src="<?php echo base_url($price_child_array[IMI_MEMBER]["image_icon_for_price"]); ?>" alt="<?php echo $price_child_array[IMI_MEMBER]["title_for_price"]; ?>"> 
                                </div>
                                
                                <div class="pak_pricing-package-content">
                                    <div class="pak_pricing-package-descripion">
                                        <div class="pak_pricing-package-about">
                                            <h3><?php echo $price_child_array[IMI_MEMBER]["title_for_price"]; ?></h3>
                                            <?php echo nl2br($price_child_array[IMI_MEMBER]["description_for_price"]); ?> 
                                        </div>
                                        
                                        <div class="pak_pricing-package-prices">
                                            <div class="pak_pricing-package-price">
                                                <p>IMI Member</p>
                                                <ul>
                                                    <li><?php echo $price_child_array[IMI_MEMBER]["pricedisplay"]; ?></li>
                                                </ul>
                                            </div>
                                            
                                            <div class="pak_pricing-package-price">
                                                <p>Non Member</p>
                                                <ul>
                                                    <li><?php echo $price_child_array[IMI_NON_MEMBER]["pricedisplay"]; ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    if (array_key_exists("addon", $price_child_array)) 
                                    {
                                    ?>
                                    <div class="pak_pricing-package-addons" style="display:;'">
                                        <div class="pak_pricing-package-about">
                                        <h3>Add-ons Per Person</h3>
                                            <ul>
                                            <?php
                                            foreach ($price_child_array["addon"] as $addon_key => $addon_array) 
                                            {
                                            ?>
                                                <li><?php echo $addon_array[IMI_MEMBER]["title_for_price"]; ?></li>
                                            <?php
                                            }
                                            ?>
                                            </ul>
                                        </div>
                                        
                                        
                                        <div class="pak_pricing-package-prices">
                                            <div class="pak_pricing-package-price">
                                                <ul>
                                                <?php
                                                foreach ($price_child_array["addon"] as $addon_key => $addon_array) 
                                                {
                                                ?>
                                                    <li>+ <?php echo $addon_array[IMI_MEMBER]["pricedisplay"]; ?></li>
                                                    <?php
                                                    if ($price_master_key == 136 && $pricetype_earlybird_regular != "earlybird_price") 
                                                    {
                                                        #print_r($price_child_array["addon"]);
                                                        #die;	
                                                    }
                                                }
                                                ?>
                                                </ul>
                                            </div>
                                            
                                            <div class="pak_pricing-package-price">
                                                <ul>
                                                    <?php
                                                    foreach ($price_child_array["addon"] as $addon_key => $addon_array) 
                                                    {
                                                    ?>
                                                        <li>+ <?php echo $addon_array[IMI_NON_MEMBER]["pricedisplay"]; ?></li>
                                                    <?php
                                                    }
                                                    ?>
                                                </ul>
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
                        </div>
                    </div>
                <?php
                }
                ?>
                </div>
            </div>
		<?php
		}
	}   
	?>
    </div>
    <br />
    <br />
    
    
    <div class="registercontent pak_pricing-desciption-content">
        <?php 
        $content = $conference_regions->row("onsite_note");
        if(is_medicsinternational()){
            $content = $CI->functions->find_and_replace(2,$rpl_value,$content);
        }
        echo $content;
        ?>
    </div>
    
    <br />
    <br />
    
    
    <div class="alng-mid">
		<a href="<?php echo site_url("conference/" . $conference->row("slug") . "/registration/screen/1"); ?>" style="text-decoration:none">
      		<input class="bluebuttons" type="button" value="To register for the <?php echo conference_fullname($conference, FALSE); ?>, please click here" />
      	</a> 
	</div>
    
    
	<script>
        const packageList = $('.pak_pricing-package-list ul').offset();

        function stickPriceList() {
            var windowScroll = $(window).scrollTop() - 80;
            // console.log('Postion: '+ packageList.top +' Scroll: '+ windowScroll);
            if (packageList.top <= windowScroll) {
                $('.pak_pricing-package-list').addClass('stickyPackage');
                $('.pak_pricing-package-type-name').addClass('stick-title');
            } else {
                $('.pak_pricing-package-list').removeClass('stickyPackage');
                $('.pak_pricing-package-type-name').removeClass('stick-title');
            }

        }

        $(window).scroll(function() {
            stickPriceList();
        });
        stickPriceList();


        $('.pak_pricing-package-list a').click(function() {
            $('.pak_pricing-package-list a').parents('.pak_pricing-package-icon').removeClass('activePackage');
            $(this).parents('.pak_pricing-package-icon').addClass('activePackage');
        });

        $('.pak_pricing-package-list li:first-child .pak_pricing-package-icon').addClass('activePackage');

        /*
            $('.pak_pricing-package-list a').click(function (e) {
                e.preventDefault();
				var packageScroll = $(this).attr('href');
                var scrollSpace = $('.pak_pricing-package-list').height() + 50;
				console.log('Attr: '+packageScroll+' Height: '+scrollSpace);
                // console.log(packageScroll);
                $('html, body').animate({
                    scrollTop: $(packageScroll).offset().top - scrollSpace
                }, 1000);
            });*/
    </script>
<?php
}
?>
