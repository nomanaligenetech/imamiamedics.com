<?php 

$attributes             = array("name"          => "myForm",
  "method"        => "post",
  "enctype"       => "multipart/form-data");
$unique_form            = array("unique_formid" => set_value("unique_formid", random_string("unique")) );

?>    




<?php 
  $sortby="";
          $sortby=($this->uri->segment(5)) ? $this->uri->segment(5) : "";
        
?>


<div class="FeederWrap">
  <div class="federHoldWrap">
    <div class="main_title_dec"><h4><?php echo $_topicname;  ?></h4></div>
    <div class="breadcurmbsWrap">
      <span><h3><a href="<?php echo site_url().'page/discussion-board.html'; ?>"><?php echo "FORUMS";?></a></h3></span> <span> > </span>
      <span><h3><a href="<?php echo site_url(); ?>page/discussion-board/topic_detail/<?php echo $_topicid."/".$sortby."/desc"."/0";?>"><?php echo $_topicname;?></a></h3></span>
    </div>

    <div class="sortAldWrap">
      <div class="topic_<?php echo $_slug;?> SortSection">
        <div class="dropSort">
          <span class="sortBySpan">Sort </span><select name="sort" class="sort" id="sort" onchange="sortby();">
          <?php 
          if($sortby=="name"){
            ?>
             <option value="<?php echo site_url(); ?>page/discussion-board/topic_detail/<?php echo $_topicid."/".$sortby."/desc"."/0";?>">By Name</option>
             <option value="<?php echo site_url(); ?>page/discussion-board/topic_detail/<?php echo $_topicid."/"."date/desc"."/0";?>">By Date</option>
           
          <?php
          }else if($sortby=="date"){
          ?>
          <option value="<?php echo site_url(); ?>page/discussion-board/topic_detail/<?php echo $_topicid."/"."date/desc"."/0";?>">By Date</option>
          <option value="<?php echo site_url(); ?>page/discussion-board/topic_detail/<?php echo $_topicid."/"."name/asc"."/0";?>">By  Name</option>
        <?php }else{?> 
          <option value="<?php echo site_url(); ?>page/discussion-board/topic_detail/<?php echo $_topicid."/"."date/desc"."/0";?>">By Date</option>
          <option value="<?php echo site_url(); ?>page/discussion-board/topic_detail/<?php echo $_topicid."/"."name/asc"."/0";?>">By  Name</option>
        <?php } ?>
        </select>
      </div>

      <div class="AddpostBtn">
        <a href="javascript:;" class="btn btn-addPost" onclick="setTopicid('<?php echo $_topicid;?>');" data-toggle="modal" data-target="#myModal">+Add Post</a>
      </div>      
    </div>
  </div>
  <div class="AllpostWrap">


    <?php
  //  echo "<pre>";
   //print_r($postdetail); die;

    if ($postdetail->num_rows() > 0)
    {
    //  die("435");

     $count=0;
     $post_date='';
     $last_post='';
     $last_commented_by='';
     foreach ($postdetail ->result_array() as $md )
     {
      //print_r( $md ); die("345");
      
      echo "<div class='postNameWrap'>";
      
      $postedby=$md['created_by_user'];
      $userid=$this->functions->_user_logged_in_details('id');

      $total_posts=0;
      $totalComments=0;
      $last_commented_by='';
      $count=0;
      $totalViews = $md['views'];

      $getComments              = $this->queries->fetch_records("getComments", "AND post_id = '". $md['id'] ." ORDER BY id DESC'");

      if(!empty($getComments)){

        foreach($getComments ->result_array() as $comment){

         $count=$count+1;
         $totalComments=$totalComments+1;

         if($count==1){

          $user = $this->imiconf_queries->fetch_records_imiconf("users", " AND id='".$comment['user_id']."' ORDER BY id desc ")->result()[0]; 

          $last_commented_by= $user->name." ".$user->last_name;

          }//end if count

        }//end foreach

}//end not empty getcomments if 


                      $createdby="";
                      if($md['created_by_admin']!=null ){ 

                       $getadmin = $this->queries->fetch_records("getAdmin", " AND id='".$md['created_by_admin']."' ORDER BY id desc ")->result()[0]; 
                       $createdby= $getadmin->username;
                    
                     }else{ 
                    
                      $user = $this->imiconf_queries->fetch_records_imiconf("users", " AND id='".$md['created_by_user']."' ORDER BY id desc ")->result()[0]; 
                      $createdby= $user->name." ".$user->last_name;
                      
                      }//end else
                    
                    ?>

                            <div class="titleleftWrap">
                              <div class="postTitleSec">

                                <h2 class="post_name"><a href="<?php echo site_url();?>page/<?php echo $menu_slug;?>/<?php echo SLUG_comments;?>/<?php echo $md['id'];?>.html"><?php echo $md['name']; ?></a></h2>

                              </div>
                              <div class="postDesc_Dates">

                                <span class="startedBy">Started By:</span>

                                <span class="byData"><?php echo $createdby;?></span>

                                <span class="date"><?php echo convert_in_hours($md['date'],FALSE);//echo date('Y-m-d',strtotime($md['date'])); //echo $md['date'];?></span>
                              </div>
                            </div>

                            <div class="tileActwrap">

                             <div class="titlerightWrap">
                              <div class="btn_posted"></div>


                              <div class="repl-viewWrap">
                             
                                <ul class="postViews_updates">
                                  <li>
                                    <strong><?php echo $totalComments; ?></strong>
                                    <span class="noreplies"> Replies</span>
                                  </li>
                                  <li>
                                    <strong><?php echo $totalViews; ?></strong>
                                    <span class="postViews"> Views</span>

                                  </li>
                                </ul>

                              </div>
                            </div>

                            <?php if($postedby==$userid){ ?>
                              <div class="actions_wrap">
                                <a href="javascript:;" class="dropdown"><img src="<?php echo site_url().'assets/frontend/images/dropdown.png'?>"></a>
                                 <ul class="actions">
                                 <li>
                                  <input type="hidden" name="postid" id="postid<?php  echo $md['id'];?>" value="">
                                  
                                  <a href="javascript:;"  onclick="setEditTopicid('<?php echo $md['id'];?>');" data-toggle="modal" data-target="#myModal">Edit</a>
                                </li>

                                <li>
                                 <a href="<?php echo site_url();?>cms/page/delete_post/<?php echo $_topicid.'/'.$md['id'];?>"> Delete</a>
                                                           
                                </li>
                                </ul>  
        
                              </div>
                               <?php } ?>
                            </div>   
                           
                          </div>

                          <?php 

                        }

                        ?>     
                      </div>
                      <?php }else{ ?>

                      <div class="AllpostWrap">

                       <div class="postNameWrap">

                         <?php echo "There is no posts for this topic.";?>

                       </div>

                     </div>      

                     <?php } ?>
                   </div>


                   <div class="pagniation_index">
                    <?php
                    echo $links;
                    ?>
                  </div>
                </div>
              </div>




              <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">

                  <div class="modal-content">

                    <div class="modal-header">

                      <button type="button" class="close" data-dismiss="modal">&times;</button>

                      <h4 class="modal-title ">Add Post</h4>

                    </div>
                    <form  onsubmit="return postFormvalidation();" action="<?php echo site_url();?>cms/page/add_post/" id="post_form" name="post_form" method="post">

                      <div class="modal-body">

                       <div class="field_row myLabel w_100 p_right10">
                        <label class="topicName">Name</label>
                        <input type="text" class="inputName" name="name" id="post_name"><br><br>
                      </div>

                      <div class="field_row myLabel w_100">
                        <label class="topicDescription">Description</label>
                        <textarea class="inputDesc" name="description" id="post_description" rows="8" cols="40"></textarea>
                      </div>

                    </div>

                    <div class="modal-footer">
                    <span id="error"></span>
                     <input type="hidden" name="id" id="id" value="">
                     <input type="hidden" name="edit" id="edit" value="">
                     <input type="hidden" name="topic_id" value="" id="topicid">
                     <input  type="submit" class="btn btn-info btn-lg"  name="submit" value="Submit">
         <!--   <button type="button" class="btn btn-info btn-lg" data-dismiss="modal">Close</button>
       -->
     </div>
   </div>
 </form>
</div>
</div>





















