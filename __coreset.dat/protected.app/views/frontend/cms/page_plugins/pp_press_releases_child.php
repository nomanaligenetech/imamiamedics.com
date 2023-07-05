
<div class="pressReleaseContainer">

<?php
      foreach ($pressreleasedetail as $row )
       { 
  ?>

  <div class="PressRelease " >
   
    <div class="leftdetaiTitle">
        <span><?php echo $row->name;  ?></span>
	</div>
   
    <div class="rightdetaiTitle">
        
        <span> <?php echo $row->pressreleas_date; ?></span>
    </div>
   
    <!--<div class="pressReleasePdf"> 
    
    <span>Press release pdf </span>
 
    <?php if($row->pressrelease_pdf!=""){ ?>
 
     <a href="<?php echo site_url().$row->pressrelease_pdf;?>"><?php echo $row->pressrelease_pdf;?> </a>
 
    <?php } else {?>
 
    <?php echo '<a href="javascript:;">No pdf document found</a>';

    } ?>
 
    </div>-->
    
     <div class="pressReleaseDescription">
      <div class="descriptionVideo">
      <span>
	  <?php echo $row->description;?> 
      </span>
      </div> 
    </div>

    </div>

    <?php }?>

  </div>

</div>