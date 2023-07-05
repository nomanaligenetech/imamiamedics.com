<?php 

$attributes             = array("name"          => "myForm",
  "method"        => "post",
  "enctype"       => "multipart/form-data");
$unique_form            = array("unique_formid" => set_value("unique_formid", random_string("unique")) );
?>   

<div class="mainChatWrap">
  <?php

  $count=1; $i=1;

  $tcoments = $this->queries->fetch_records("getComments","","(SELECT COUNT(*) FROM tb_comments WHERE post_id = {$_post_id}) as totalComment")->result()[0];

  ?>
  <div class="innerChatWrap">
    <div class="mainHoldWrap">
      <div class="titleChatwr">
        <?php echo $_postname;?>
      </div>

      <div class="breadcrumChatwr">
        <a href="<?php echo site_url().'page/discussion-board.html'; ?>"><?php echo "FORUMS";?></a> >
        <a href="<?php echo site_url().'page/discussion-board/topic_detail/'.$_topic_id.'/date/desc/0.html'; ?>"><?php echo $_topicname;?></a> >
        <a href="<?php echo site_url().'page/comments/comments/'.$_post_id.'.html'; ?>"><?php echo $_postname;?></a>
      </div>
    </div>

    <div class="profilesWrap">
      <div class="profile_descr">
        <?php 
          $createdby="";
          $profile_picture_one="";
          $tposts="";
          $profile_picture="";
           $userid=$this->functions->_user_logged_in_details('id'); 

           $profile                                  = $this->imiconf_queries->fetch_records_imiconf("conference_registration_screen_one", " AND conferenceregistrationid IN (SELECT id FROM tb_conference_registration_master WHERE userid = '".  $userid ."' )  " )->result()[0];  
            if($profile->photo_image!="") $profile_picture=$profile->photo_image; else $profile_picture=site_url()."assets/files/profileimages/noimage.png";

          if($postdetail[0]->created_by_admin!=null ){

            $getadmin = $this->queries->fetch_records("getAdmin", " AND id='".$postdetail[0]->created_by_admin."' ORDER BY id desc ")->result()[0]; 
            $createdby= $getadmin->username;
            $profile_picture_one=$getadmin->profile_image;
            $id=$postdetail->created_by_admin;
            $tposts                     =$this->queries->fetch_records("getPosts","","(SELECT COUNT(*) FROM tb_posts WHERE created_by_admin={$id}) as total_posts")->result()[0]; 

          }else if($postdetail[0]->created_by_user!=null){

            $user = $this->imiconf_queries->fetch_records_imiconf("users", " AND id='".$postdetail[0]->created_by_user."' ORDER BY id desc ")->result()[0]; 

            $createdby= $user->name." ".$user->last_name;

            $id=$postdetail[0]->created_by_user;
            $tposts                     =$this->queries->fetch_records("getPosts","","(SELECT COUNT(*) FROM tb_posts WHERE created_by_user={$id}) as total_posts")->result()[0]; 


            $profile_details                                   = $this->imiconf_queries->fetch_records_imiconf("conference_registration_screen_one", " AND conferenceregistrationid IN (SELECT id FROM tb_conference_registration_master WHERE userid = '".  $id ."' )  " )->result()[0];  

            if($profile_details->photo_image!="") $profile_picture_one=$profile_details->photo_image; else $profile_picture_one=site_url()."assets/files/profileimages/noimage.png";
          }
          //  $profile_picture_one = $profile_picture_one=="" ? site_url()."assets/files/profileimages/noimage.png" : '';
        ?>

        <div class="Imgpro_pic">
          <img src="<?php echo $profile_picture_one;?>"/>
        </div>

        <div class="ProfileName">
          <h3><?php echo $createdby;?></h3>
          <span><?php echo $tposts->total_posts;?> </span>
          <span>Posts</span>
        </div>
        <div class="shedulePro">
          <span class="timeUpdat_left">Time </span>
          <span class="colonDiv">:</span>
          <span class="timeUpdat_right">
            <?php echo date('H:i:s',strtotime($postdetail[0]->date)); ?>
          </span>
        </div>
        <div class="datesPro">
          <span class="dateupd_left">Date</span>
          <span class="colonDiv">:</span>
          <span class="dateupd_right">
            <?php echo date('Y-m-d',strtotime($postdetail[0]->date)); ?>
          </span>
        </div>
      </div>

      <div class="despcrPro">
        <span class="postedDate">
          <span class="postedTags"><b>Posted </b></span>
          <?php echo convert_in_hours($postdetail[0]->date,FALSE); ?>
        </span> 
        <div class="description_detailF"><?php echo $postdetail[0]->description; ?></div>
        <?php if($tcoments->totalComment==0) echo '<span class="commentCounter">No Comments.</span>'; else echo '<span class="commentCounter" id="commentcounter">'.$tcoments->totalComment.'</span>';?>
      </div>
    </div>
  </div>

  <div class="chatBottomWrap">

    <div class="comments-list">
      <?php if ( $commentdetail -> num_rows() > 0 ) { ?>

      <ul class="parentcomment">

        <?php foreach ( $commentdetail -> result() as $comment ) {

          $user = $this->imiconf_queries->fetch_records_imiconf("users", " AND id='".$comment->user_id."' ORDER BY id desc ")->result()[0];
          $isChildComments=$this->queries->fetch_records("getComments","","(SELECT COUNT(*) from tb_comments where parentid={$comment->id}) as childcomment")->result()[0];
        //  print($isChildComments->childcomment); die;
        ?>
        <li data-id="<?php echo $comment->id; ?>">

          <?php 

          $profile_detailss                                   = $this->imiconf_queries->fetch_records_imiconf("conference_registration_screen_one", " AND conferenceregistrationid IN (SELECT id FROM tb_conference_registration_master WHERE userid = '".  $comment->user_id ."' )  " )->result()[0];  

          $commentpic = $profile_detailss->photo_image !="" ? $profile_detailss->photo_image : site_url()."assets/files/profileimages/noimage.png";
          ?>
          <div class="commentInnerSec">
            <div class="commentInnerSec_left">
              <div class="commentbyImg">
                <img src="<?php echo $commentpic;?>">
              </div>
            </div>

            <div class="commentInnerSec_right">
              <div class="commentby"><?php echo $user->name.' '.$user->last_name;?></div>
              <div class="comment"><?php echo $comment->comment; ?></div>
              <div class="comment-meta">
                <?php $user = $this->imiconf_queries->fetch_records_imiconf("users", " AND id='".$comment->user_id."' ORDER BY id desc ")->result()[0]; ?>
                <div class="replyLinks" data-id="<?php echo $comment->id; ?>">
                  <input type="hidden" name="display_replyuser" id="display_replyuser<?php echo $comment->id; ?>" value="<?php echo $user->name.' '.$user->last_name;?>" />
                  <a href="javascript:;" id="button"  onclick="setIds(this)" name="reply">Reply</a>
                 <?php if($isChildComments->childcomment>0){?>
                  <span class="seperator"> | </span>
                  <a href="javascript:;" class="viewReplies">View Replies</a>
                <?php } ?>
                </div>
              </div>

              <?php $number=5;$html = ''; echo getChildComments($comment->id,$html,$number);?>
            </div>
          </li>

          <?php $count=$count+1; } ?>

        </ul>

        <?php } ?>
    </div>

    <form name="commentsform" onsubmit="return commentFormvalidation();" action="<?php echo site_url('cms/page/post_comment');?>" method="post">

    <div class="SendComWrap">
      <div class="pro_pic">
        <img src="<?php echo $profile_picture;?>">
      </div>

      <div class="inputComment">
        <textarea class="inputComment Widthcomnt_box" name="comment" id="comment"   rows="1" placeholder="Type comment here " cols="80" ></textarea>
      
      <input type="hidden" name="id" value="<?php echo set_value('id', $id); ?>" />
      <input type="hidden" name="post_id" value="<?php echo $_post_id; ?>" />
      <input type="hidden" name="pid"  id="parentid" value="">
      <input type="hidden" name="replyto"  id="replytoid" value="">
      <input id="sendComment"  type="submit" class="btn btn-info btn-lg"  name="submit" value="Submit">
      <label class="replyto" id="comt"> </label>
      </div>
      
    
    </form>

    </div>

    </div>
</div>


</div>

</div>

</div>

</div>