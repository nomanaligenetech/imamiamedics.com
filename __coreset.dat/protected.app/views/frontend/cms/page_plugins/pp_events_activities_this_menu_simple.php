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
		foreach ( $sitesectionwidgets->result_array() as $ssw )
		{
			$sitesectionswidgets_languages = $this->queries->fetch_records("sitesectionswidgets_languages", " AND sitesectionswidgets_id = {$ssw['id']}")->result_array();
			replace_data_for_lang($ssw, $content_languages, $sitesectionswidgets_languages, ['title','short_desc','full_desc'], SessionHelper::_get_session('LANG_CODE') );
		?>              
            <div class="event m_bottom30">
                <a style="display:inline-block;" href="<?php echo site_url("page/" . $menu_detail->row("slug") . "/" . $ssw['mode'] . "/" . $ssw['slug']); ?>">
                <div class="event_img_wrap">
                    <?php echo $this->functions->timthumb( $ssw['photo_image'], 839, 278 );?>
                </div>
                
                
                <div class="event_bottom">
                    <div class="event_bottom_head" style="margin-bottom:0;">
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
                            <span style="background:#575757;color: #fff;padding:7px 15px;border-radius: 15px;">
								<?php echo lang_line("button_view_details"); ?> 
                            </span>
                        </div>
                    </div>
                    <p><?php echo $ssw['short_desc'];?></p>
                </div>
                </a>
            </div>
        <?php
		}
		?>
    </div>
<?php
}
?>




