    <li>
         <div class="left">
         
         <div class="image_section_left">
              <div class="image">
                       <img src="<?php echo $profile_picture; ?>"></img>
                </div>
         </div>
        <div class="image_section_right">       
         <ul>
            <li>
               <h2 class="topic"><a href="<?php echo site_url("page/".$menu_slug."/".SLUG_TOPIC_DETAIL."/".$rec['id']."/date/desc/0/");?>"> <?php echo $rec['name'];?></a></h2>
            </li>
         <li>
            <span class="by"> By:</span>
            <span class="by_data"><?php echo $createdby;?></span>
         </li>
         <li>
            <span class="date"><?php echo convert_in_hours($rec['date'],FALSE)." ".date('H:i A',strtotime($rec['date']));?></span>
           
         </li>
        </ul>
      </div>

        </div>
         
        
       <div class="right">
             
             <div class="right_section">
        
        <div class="postrepInn">  
        <ul>
          <li>
          <span class="noposts_data"><?php echo $total_posts;?></span>
            <span class="noposts">Posts</span>
          </li>
          <li>
            <span class="noreplies_data"><?php echo $totalComments;?></span>  <span class="noreplies"> Replies</span>
          </li>
          <li>
           <span class="lastpost">Last Post On </span><span class="lastpost_data"><?php if($post_date!="") echo convert_in_hours($post_date,FALSE);?></span>
          </li>
         
        </ul>
        </div>


         <?php

          if($userid!=0)
          if($postedby==$userid){

          ?>
         <div class="actions_wrap">
          <a href="javascript:;" class="dropdown"><img src="<?php echo site_url().'assets/frontend/images/dropdown.png'?>"></a>
           <ul class="actions">
           <li>
             <input type="hidden" name="forumid" id="forumid<?php  echo $rec['id'];?>" value="">
                                  
             <a href="javascript:;"  onclick="setEditForumid('<?php echo $rec['id'];?>');" data-toggle="modal" data-target="#myModal">Edit</a>
          </li>

          <li>
          <a href="<?php echo site_url();?>cms/page/delete_topic/<?php echo $rec['frmid'].'/'.$rec['id'];?>">Delete</a>
                                  
          </li>
          </ul> 
         </div>
        <?php  } ?>
        </div>

      </div>
  </li>