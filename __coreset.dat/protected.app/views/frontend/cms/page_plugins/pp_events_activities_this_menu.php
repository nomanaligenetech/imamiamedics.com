<?php
if ( isset( $is_list ) )
{
	if ( $eventslist_menus_all->num_rows() > 0 )
	{
		?>
        <ul class="listing">
		<?php
		
		foreach ( $eventslist_menus_all -> result_array() as $elma )
		{
			?>
            <li>
            	<a href="<?php echo site_url( SLUG_PAGE . "/" . $elma['slug'] );?>">
					<?php echo $elma['name'];?>
                </a>
            </li>
            <?php	
		}
		
		?>
        </ul>
        <?php
	}
}
else if ( $sitesectionwidgets -> num_rows() > 0 )
{
?>
    <div class="events_sec fl_lft w_100">
    
    	<?php
		foreach ( $sitesectionwidgets->result_array() as &$ssw )
		{
			$sitesectionswidgets_languages = $this->queries->fetch_records("sitesectionswidgets_languages", " AND sitesectionswidgets_id = {$ssw['id']}")->result_array();
			replace_data_for_lang($ssw, $content_languages, $sitesectionswidgets_languages, ['title','short_desc','full_desc'], SessionHelper::_get_session('LANG_CODE') );	
			if($ssw['status_name'] == 'Yes'){
		?>
            <div class="event m_bottom30">
                <div class="event_img_wrap">
                    <?php echo $this->functions->timthumb( $ssw['photo_image'], 839, 278 );?>
                    
                    
                    <?php
					$EVENT_Tag				= FALSE;
					if ( strtotime( $ssw['end_date'] ) > 0 )
					{
						$mode											= DropdownHelper::eventactivities_dropdown( $ssw['mode'] );
						
						switch ( TRUE  )
						{
							case strtotime($ssw['start_date']) > strtotime("now"):
								$EVENT_Tag				= "Upcoming $mode";
								break;
								
							case strtotime("now") >= strtotime($ssw['start_date']) and strtotime("now") <= strtotime($ssw['end_date'])  :
								$EVENT_Tag				= "Current $mode";
								break;
								
							case  strtotime($ssw['end_date']) < strtotime("now") :
								$EVENT_Tag				= "Past $mode";
								break;
								
							default:
								break;
						}
					}
					
					if ( $EVENT_Tag )
					{
					?>
                    	<div class="tag"><?php echo $EVENT_Tag;?></div>
                    <?php
					}

					if ( strtotime($ssw['start_date']) > 0 and $ssw['mode'] == 'events' )
					{
					?>
                    	<div class="date"><span><?php echo date("d", strtotime( $ssw["start_date"] ));?></span><?php echo date("M", strtotime( $ssw["start_date"] ));?><?php echo "<br>".date("Y", strtotime( $ssw["start_date"] ));?></div>
					<?php
					}else if( strtotime($ssw['start_date']) == 0 and $ssw['mode'] == 'events' ){
					?>
						<div class="date"><span><?php echo date("M", strtotime($ssw["year"]."-".$ssw["month"]."-01"));?></span><?php echo "<br>".$ssw["year"];?></div>
				
					<?php }?>
                </div>
                
                
                <div class="event_bottom">
                    <div class="event_bottom_head">
                        <div class="head_left">
                            <h3 class="h3_bluestyle1"><?php echo $ssw['title'];?></h3>
                            
                            <?php
							if ( $ssw['mode'] == 'events' )
							{
								if ( strtotime($ssw['start_date']) > 0  )
								{
								?>
									<span class="time"><?php echo date(" h:i:A", strtotime($ssw['start_date']));?></span>
								<?php
								}
								
								
								
								if ( $ssw['address'] )
								{
								?>
									<span class="location"><?php echo $ssw['address'];?></span>
								<?php
								}
							}
							?>
                        </div>
                        <div class="head_right">
                            <a class="ViewDetail_btn grey_btn" 
                            href="<?php echo site_url( "page/" . $menu_detail->row("slug") . "/" . $ssw['mode'] . "/" . $ssw['slug'] ) ;?>">
								<?php echo lang_line("button_view_details"); ?>  
                            </a>
                        </div>
                    </div>
                    <p><?php echo $ssw['short_desc'];?></p>
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




