<?php
/** @var CI_Loader $this */
$attributes             = array("name"          => "myForm",
  "method"        => "post",
  "enctype"       => "multipart/form-data");
$unique_form            = array("unique_formid" => set_value("unique_formid", random_string("unique")) );
?>    

<div class="forums">
<?php
      
     if ($forums_details -> num_rows() > 0 )
     {
      $btnViewMore=FALSE;
      $viewmore="";
         foreach ($forums_details->result_array() as $md )
                {
        
                    $total_posts=0;
                    $topic              = $this->queries->fetch_records("getforumtopics", " 
                        AND frmid = '". $md['id'] ."' ORDER BY date DESC  limit 0,3 ");
                    $viewmore      = $this->queries->fetch_records("getforumtopics", " 
                        AND frmid = '". $md['id'] ."' ORDER BY date DESC limit 3,4 ");
                   
                    if($viewmore->num_rows() > 0){

                        $btnViewMore=TRUE;
                    
                    }else{
                    
                        $btnViewMore=FALSE;
                    }

                    /* $admin=$this->queries->fetch_records("getAdmin","AND id='".$md['created_by_admin']."'")->result()[0];*/
  ?>


    <div class="forum forum_<?php echo $md['slug'];?>">
         <div class="topbar">
         <?php 
         $userid=$this->functions->_user_logged_in_details('id');
         ?>
           <div class="forum_name"> <h2><?php echo $md['name']; ?></h2></div>
         <?php if($this->functions->validate_if_user_is_a_paid_member($userid)){?>
           <div class="add_moretopic"> <a href="javascript:;" class="btn btn-info btn-lg" onclick="setForumid('<?php echo $md['id'];?>')" data-toggle="modal" data-target="#myModal">+ Add Topic</a></div>
         <?php } ?>
         </div>
         
        <div class="topics" id="topics<?php  echo $md['id']; ?>"> 
            <ul class="formUL" id="ul_topic<?php  echo $md['id']; ?>">
            <?php 
           foreach($topic ->result_array() as $rec){
           

              $postedby=$rec['created_by_user'];
             
           
             $count=0;
               $total_posts=0;
                 $totalComments=0;
                 $post_date="";
     
                        $getPosts              = $this->queries->fetch_records("getPosts", "AND topic_id = '". $rec['id'] ." ORDER BY id DESC'");
                          
                    foreach($getPosts->result_array() as $postss){
                           
                           $count=$count+1;
                           
                            $total_posts=$total_posts+1;
                           
                           if($count==1){
                             
                             if($postss['date']<$post_date){

                            }else{
                              
                                $post_date=$postss['date'];
                 
                          }//end post date
                         
                         }//end count
                
                            $getComments              = $this->queries->fetch_records("getComments", "AND post_id = '". $postss['id'] ." ORDER BY id DESC'");
                            $numberofcomments=$getComments->num_rows();
                            $totalComments=$totalComments+$numberofcomments;
                    
                        }//end inner foreach
                          
                       
                          $createdby="";
                          $profile_picture="";
                          
                          if($rec["created_by_admin"]!=null ){ 

                                         $getadmin = $this->queries->fetch_records("getAdmin", " AND id='".$rec['created_by_admin']."' ORDER BY id desc ")->result()[0]; 
                                         $createdby= $getadmin->username;
                                         $profile_picture=$getadmin->profile_image;
                            }else if($rec['created_by_user']!=null){ 
                                    
                                      $user = $this->imiconf_queries->fetch_records_imiconf("users", " AND id='".$rec['created_by_user']."' ORDER BY id desc ")->result()[0]; 
                                    
                                      $createdby= $user->name." ".$user->last_name;
                                    
                                      $profile_details                                   = $this->imiconf_queries->fetch_records_imiconf("conference_registration_screen_one", 
                                                                                                                    "   AND conferenceregistrationid IN (SELECT id FROM tb_conference_registration_master WHERE userid = '". $rec['created_by_user'] ."' )  " )->result()[0];  
        
                                   if($profile_details->photo_image!="") $profile_picture=$profile_details->photo_image; else $profile_picture=site_url()."assets/files/profileimages/noimage.png";
                                   

                            }//end else

                if($profile_picture=="")  $profile_picture=site_url()."assets/files/profileimages/noimage.png";
                

               // echo "User id".$userid; die;
                $tmp_data['rec'] = $rec;
                $tmp_data['total_posts']=$total_posts;
                $tmp_data['totalComments']=$totalComments;
                $tmp_data['post_date']=$post_date;
                $tmp_data['createdby']=$createdby;
                $tmp_data['profile_picture']=$profile_picture;
                $tmp_data['postedby']=$postedby;
                $tmp_data['userid']=$userid;
                $tmp_data['menu_slug']=$menu_slug;
               // echo "Menu Slug".$menu_slug; die;
                

                $this->load->view('frontend/cms/page_plugins/_topic_list',$tmp_data);

                }

                ?>
   
            </ul>
          </div>
         <input type="hidden" id="last_limit<?php echo $md['id'];?>" value="3">
         <?php if($btnViewMore==TRUE){ ?>
        <div class="viewmore"> <a href="javascript:;" id="btnViewMore<?php echo $md['id'];?>" onclick="getMoreTopics('<?php echo $md['id']; ?>');">view more</a></div>
         <?php } ?>
       </div>
       
       <?php 
      } 
     }
    ?>
</div>




  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title ">Add Topic</h4>
        </div>
      
       <form onsubmit="return postTopicValidation();" action="<?php echo site_url(); ?>cms/page/add_topic/" name="topic_form" method="post">

        <div class="modal-body">

           <div class="field_row myLabel w_100 p_right10">
              <label class="topicName">Topic Name</label>
              <input type="text" class="inputName" name="name" id="topic_name"><br><br>
           </div>

          <div class="field_row myLabel w_100">
              <label class="topicDescription">Description</label>
              <textarea class="inputDesc" name="description" id="topic_description" rows="8" cols="40"></textarea>
          </div>

         </div>
        <div class="modal-footer">
          <span id="error"></span>
          
          <input type="hidden" name="id" value="" id="id">
          <input type="hidden" name="edit" value="" id="edit">
          <input type="hidden" name="forumid" value="" id="forumid">
          <input  type="submit" class="btn btn-info btn-lg"  name="submit" value="Submit">
        </div>
      </div>

      </form>
      
    </div>
  </div>
  




