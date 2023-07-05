<?php
  if ( $this->functions->_user_logged_in_details( "is_member" ) ==1)
  { ?>
<div class="pressReleaseContainer">

<?php
      foreach ($iminewsdetail as $row )
       { 
  ?>
  <div class="PressRelease " >

    <div class="leftdetaiTitle">
        <span><?php echo $row->name;  ?></span>
  </div>
    <div class="rightdetaiTitle">
        <span> <?php echo $row->date; ?></span>
    </div>
   <!-- <div class="pressReleasePdf"> 
    <span class="pressPdfimg"></span>
   <?php 
    $pdf=$this->queries->fetch_records("news_pdf","AND parentid={$row->id}")->result();
   
   foreach($pdf as $re){
   
      if(isset($re->news_pdf)!=""){
   
       ?>

 <div class="pdf"> 
     <a target="_blank" href="<?php echo site_url().$re->news_pdf;?>"><?php echo "Click here to download";?>
      </a>
 </div>
    <?php
         }
       }
    ?>
 
     </div>-->
     <div class="pressReleaseDescription">
      <div class="descriptionVideo">
      <span>
   
      <?php echo $row->description;?> 
    
      </span>
      </div> 
    </div>
   </div>
  <?php 
       
    $videos=$this->queries->fetch_records("news_videos","AND parentid={$row->id}")->result();
    foreach($videos as $rec){
    ?>
    <div class="videos">
     <video controls=""><source src="<?php echo site_url(). $rec->news_videos;?>"></video>
   </div>
 <?php } ?>
<?php }?>
</div>
<?php }else{ 

  echo "Thank you for visiting this page. This page is only  available for IMI Members"; 

 } ?>