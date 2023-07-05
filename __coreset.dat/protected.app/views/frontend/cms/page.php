<?php
if ( isset( $is_events ) )
{
	$uid='';
	$userid=$this->functions->_user_logged_in_details('id');
	$isAlreadyJoined=$this->queries->fetch_records("whojoinevents", " AND eventid=".$sitesectionswidgets->row('id')."");
	
	   if($isAlreadyJoined->num_rows > 0){
    
    	$uid=$isAlreadyJoined->row()->userid;
   
    	}
    	//$uid=6464;
	?>
    	<div class="event_top_head">
            <div class="head_left">
                <h3 class="h3_bluestyle1"><?php echo $sitesectionswidgets -> row("title");?></h3>
                
                
				<?php
				if ( strtotime( $sitesectionswidgets->row('start_date') ) > 0 )
				{
				?>
					<span class="time"><?php echo date("h:i:A", strtotime( $sitesectionswidgets->row('start_date') ));?></span>
				<?php
				}
				if ( $sitesectionswidgets->row('address') )
				{
				?>
					<span class="location"><?php echo $sitesectionswidgets->row('address');?></span>
				<?php
				}
				?>
            </div>
            <?php 
           //echo "<pre>"; echo($sitesectionswidgets->row('start_date')); echo "  / date=".date('Y-m-d',strtotime($sitesectionswidgets->row('start_date'))); echo "   / now  =".date("Y-m-d");  die; 
           if(date('Y-m-d H:m')>$sitesectionswidgets->row('end_date') /*|| $userid==$uid*/){

            }else{
            ?>
            <div class="head_right">
                <a href="javascript:;" onclick="eventInterest('<?php echo $sitesectionswidgets->row('id');?>');" class="join_btn btn_orange1">Join Event</a>
            </div>
            <?php }?>
        </div>
    <?php	
}
else
{
	if ( $_show_icon_with_title )
	{
		?><img style="float:left; margin-right:10px; margin-top:8px;" height="40" src="<?php echo $_show_icon_with_title ;?>"  /><?php
	}
	
	if ( $_show_title )
	{
		?><h1 class="h1Style2"><?php echo $_show_title;?></h1><?php
	}
}




if ( $content_detail->num_rows() > 0 )
{
	//echo $content_detail->row("content"); die();
	if ( isset( $is_pressrelease)  )
	{
		if ( $_show_icon_with_title )
		{
			?><img style="float:left; margin-right:10px; margin-top:8px;" height="40" src="<?php echo $_show_icon_with_title ;?>"  /><?php
		}

		$data['pressreleasedetail'] = $content_detail->result();
		$this->load->view('frontend/cms/page_plugins/pp_press_releases_child.php', $data);
	
	}else if($is_imi_news){
    	
		if ( $_show_icon_with_title )
		{ ?>
		
			<img style="float:left; margin-right:10px; margin-top:8px;" height="40" src="<?php echo $_show_icon_with_title ;?>"  /><?php
		}

		$data['iminewsdetail'] = $content_detail->result();
		$this->load->view('frontend/cms/page_plugins/pp_imi_news_detail.php', $data);
	

    }else if($is_topic_detail){
		
		if ( $_show_icon_with_title )
		{ ?>
		
			<img style="float:left; margin-right:10px; margin-top:8px;" height="40" src="<?php echo $_show_icon_with_title ;?>"  /><?php
		}
		$data['menu_slug']  ="comments";
		$this->load->view('frontend/cms/page_plugins/imi_topic_detail.php', $data);

	}else if($is_comment){


		if ( $_show_icon_with_title )

		{ ?>
		
			<img style="float:left; margin-right:10px; margin-top:8px;" height="40" src="<?php echo $_show_icon_with_title ;?>"  /><?php
		}

		$data['postdetail'] = $content_detail->result();
		$this->load->view('frontend/cms/page_plugins/imi_comments.php', $data);


	}else if($is_joining_event){
	//	die("345435");

	//	$data['event'] = $content_detail->result();
	  //  $data['message'] = $_messageBundle;
       // echo $_messageBundle;
	//	$this->load->view('frontend/cms/page_plugins/imi_event_joining.php', $data);
    }else{

    	$con = str_replace('&nbsp;',' ',$content_detail->row("content"));
    	if(stripos($con, "Board Of Region") !== false){
      	}else{
   		echo $this->functions->content_shortcodes($con, $PLUGINS_CODE);
		}
		
	}
	#$content_detail->row('content');    
}
else
{
    $data["_messageBundle"]				= $_messageBundle2;
    $this->load->view('frontend/template/_show_messages.php', $data);	
}
?>




<div class="modal fade" id="eventjoining" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<div class="row headingMid">
					<h2 class="h2Style2 m_bot25"><b>Are you going -</b>  to join event ?</h2>
				</div>
			</div>

			<div class="flALlLeft">
				<form action="<?php echo site_url();?>cms/page/event_form/" method="post">
					<input type="hidden" name="eventid" id="eventid" value="">
					<div class="form-group">
						<label class="control-label" for="test strucrt"></label>  
						<div class="col-md-10 bg_greyText">
							<input type="radio" name="event" id="event" value="Interested" checked/>
							<label class="control-label">Interested</label> 

						</div>
					</div>

					<div class="form-group">
						<label class="control-label" for="test strucrt"></label>  
						<div class="col-md-8 bg_greyText">
							<input type="radio" name="event" id="event" value="Going"/>
							<label class="control-label">Going</label> 

						</div>
					</div>

					<!-- <div class="form-group">
						<label class="control-label" for="test strucrt"></label>  
						<div class="col-md-10 bg_greyText">
							<input type="radio" name="event" id="event" value=""/>
							<label class="control-label">Not going </label> 

						</div>
					</div> -->

					<div class="form-group">
						<label class="control-label" for="test strucrt"></label>  
						<div class="col-md-10 bg_greyText">
							<input type="radio" name="event" id="event" value="Not going"/>
							<label class="control-label">Not going</label> 

						</div>
						<span class="event"></span>
					</div>

				</div>
				<div class="flALlLeft">
					<div class="col-md-2">
						<button id="submit" name="submit"  class="btn btn-primary">SUBMIT</button>
					</div>
				</div>
			</form>		

		</div>
	</div>
</div>
  
