<?php
if ( isset($slug) )
{
	if ( $slug )
	{
		$slug							= " AND slug = '$slug' ";	
	}
}
else
{
	$slug							= FALSE;	
}


$TMP_chapterlocation				= $this->queries->fetch_records("chapterslocation_master", " AND status = '1' $slug ORDER BY sort ASC ");
if ( $TMP_chapterlocation -> num_rows() > 0 )
{
	
    foreach ( $TMP_chapterlocation -> result_array() as $t )
    {
        $chapterslocation_master_languages = $this->queries->fetch_records("chapterslocation_master_languages", " AND chapterslocation_master_id = {$t['id']}")->result_array();
        replace_data_for_lang($t, $content_languages, $chapterslocation_master_languages, ['title', 'short_desc','full_desc'], SessionHelper::_get_session('LANG_CODE') );	

		$TMP_chapterlocation_details				= $this->queries->fetch_records("chapterslocation_details", " AND parentid = '". $t['id'] ."' ");
    ?>
        <div class="cities_col m_bottom30 pos_rel ">
        	<h3 class="h3Style3">
            	<?php
				$TMP_geonames			= 'http://www.geonames.org/flags/x/'. strtolower( $t['countries_iso_code_2'] ) .'.gif';  #&w=39';
                ?>
             
               <?php if(strip_tags($t['title']) =="IMI Europe"){ ?>
                 <img class="flag" alt="<?php echo $t['country_name'];?>" align="right" src="<?php echo base_url("assets/frontend/images/european-union-flag.jpg")?>" width="39" />
               <?php }else{?>
                <img class="flag" alt="<?php echo $t['country_name'];?>" align="right" src="<?php echo ( $TMP_geonames );?>" width="39" />
                <?php }?>

             <!--   <img class="flag" alt="<?php echo $t['country_name'];?>" align="right" src="<?php echo ( $TMP_geonames );?>" width="39" />-->
                
				
				<?php echo $t['title'];?>
            </h3>
            
        	<p><?php echo $t['short_desc'];?></p>
            
            
            
            <?php
			if ( $TMP_chapterlocation_details -> num_rows() > 0 )
			{
				?>
                    <ul class="displayul">
                        <?php
                        foreach( $TMP_chapterlocation_details->result_array() as $cld)
                        {
                        ?>
                            <li>
                                <div class="city_contact_info">
                                <?php
                                if ( $cld['chapter_address'] != "" )
                                {
                                ?>
                                    <h3 class="h3_bluestyle2"><?php echo lang_line('label_address'); ?></h3>
                                    <ul>
                                        <li><img src="<?php echo base_url("assets/frontend/images/location_icon_grey.png");?>" alt="Location" /> <?php echo $cld['chapter_address'];?></li>
                                    </ul>
                                    
                                    <br />
                                <?php
                                }
                                
                                
                                if ( ($cld['chapter_tel'] != "") || ($cld['chapter_mobile']) || ($cld['chapter_website']) )
                                {
                                ?>                    
                                    <h3 class="h3_bluestyle2"><?php echo lang_line('label_contact_info'); ?></h3>
                                    
                                    <ul>
                                        <?php
                                        if ( $cld['chapter_tel'] != "" )
                                        {
                                        ?>
                                            <li><img src="<?php echo base_url("assets/frontend/images/phone_icon_grey.png");?>" alt="Phone" /> <?php echo $cld['chapter_tel'];?></li>
                                        <?php
                                        }
                                        
                                        if ( $cld['chapter_mobile'] != "" )
                                        {
                                        ?>
                                            <li><img src="<?php echo base_url("assets/frontend/images/mobile_icon_grey.png");?>" alt="Mobile" /> <?php echo $cld['chapter_mobile'];?></li>
                                        <?php	
                                        }
                                        
                                        if ( $cld['chapter_website'] != "" )
                                        {
                                        ?>
                                            <li>
                                                <img src="<?php echo base_url("assets/frontend/images/link_icon_grey.png");?>" alt="Link" /> 
                                                <a href="<?php echo $cld['chapter_website'];?>"><?php echo $cld['chapter_website'];?></a>
                                            </li>
                                        <?php	
                                        }
                                        ?>
                                        
                                        
                                    </ul>
                                <?php
                                }
                                ?>
                                
                                
                            </div>
                            </li>
                            
            
                            
                        <?php	
                        }
                        ?>
                    </ul>
                <?php
			}
			
			if (  $readmore )
			{
			?>
                <a  class="rmlinkchapters" href="<?php echo site_url( SLUG_CHAPTERS . "/" . $t['slug'] );?>">
                    <img  src="<?php echo base_url( "assets/frontend/images/link_icon.jpg" );?>"  />
                </a>
            <?php
			}
			?>
        </div>
    <?php
    }
}
?>