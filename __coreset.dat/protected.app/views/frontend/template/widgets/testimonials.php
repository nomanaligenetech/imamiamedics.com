<?php
if ( $sitesectionswidgets ){

	$event_id = $sitesectionswidgets->result()[0]->id;

}

$testimonials_query = " AND status = '1' ";

if ( NULL != $widget_parent_id ){

	$cms_content = $this->queries->fetch_records("cmscontent"," and id = $widget_parent_id","menuid");
	$menu_id = $cms_content->row()->menuid;

    if (null != $menu_id) {
        $testimonials_query = " AND menu in ($menu_id) ";
    }
}
$testimonials_query .= " ORDER BY sort ASC ";
$TMP_testimonials				= $this->queries->fetch_records("testimonials", $testimonials_query);

if ( $TMP_testimonials -> num_rows() > 0 )
{
	?>
	<div class="left_area fl_lft m_bottom25">

		<div class="left_top_title">Testimonials</div>

		<div class="left_area_bottom testi_bottom_area fl_lft">

			<ul class="testi_wrap">

				<?php


				
				$TMP_total = 0;

				$TMP_evv_total = 0;
				
				if (isset($menu_detail)) 
				{

					if ($menu_detail->num_rows() > 0) 
					{
						$menuid = $menu_detail->row()->id;
						
						foreach ( $TMP_testimonials -> result_array() as $t )
						{

							$evv = explode(',', $t['events']);
							$menu = explode(",", $t['menu']);

							if( in_array($menuid, $menu) ) 
							{
								$TMP_total+=1;
							}

							if ( in_array($event_id, $evv)){
								$TMP_evv_total+=1;
							}
						}
					}

					if( $TMP_evv_total ){
						foreach ( $TMP_testimonials -> result_array() as $t )
						{
							
							if ( in_array($event_id, explode(",", $t['events'])) )
							{
								?>					
								<li>
									<div class="testimonial_aut">
										<?php echo $t['testimonial'];?>
										<span class="author"><?php echo $t['username'];?></span>
									</div>
									<!--<a class="grey_btn" href="#">Read More</a>-->
								</li>
								<?php
							}
							
						}
					}else{
						if ($TMP_total)
						{

							foreach ( $TMP_testimonials -> result_array() as $t )
							{

								if ( in_array($menuid, explode(",", $t['menu'])) )
								{
									?>					
									<li>
										<div class="testimonial_aut">
											<?php echo $t['testimonial'];?>
											<span class="author"><?php echo $t['username'];?></span>
										</div>
										<!--<a class="grey_btn" href="#">Read More</a>-->
									</li>
									<?php
								}

							}

						}else{
							?>
							<li>
								<div class="testimonial_aut">
									<p> No testimonials to display.</p>
								</div>
							</li>
							<?php
						}
					}
					
					
					
				}//elseif () 
				else 
				{
					
					foreach ( $TMP_testimonials -> result_array() as $t )
					{

						?>					
						<li>
							<div class="testimonial_aut">
								<?php echo $t['testimonial'];?>
								<span class="author"><?php echo $t['username'];?></span>
							</div>
							<!--<a class="grey_btn" href="#">Read More</a>-->
						</li>
						<?php
					}
					
				} 
				
				?>

			</ul>

		</div>

	</div>
	<?php
}
?>