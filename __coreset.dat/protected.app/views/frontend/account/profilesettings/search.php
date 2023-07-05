    <div class="mem_single fl_lft w_100" style="display:;">
    <div class=" w_60 disp_tc">
        <div class="memImg ronded">
            <?php 
            if ( $fu['profile_imagae'] != "" )
            {
                echo $this->functions->timthumb( $fu['profile_imagae'], 200, 200 );	
            }
            else
            {
                echo $this->functions->timthumb( "assets/frontend/images/no-image.jpg", 200, 200 );	
            }									
            ?>
        </div>
        <div class="memName"><?php echo $fu['prefix'];?> <?php echo $fu['name'];?>
        <span class="blue"><?php echo $fu['education'];?></span>
        <span class="blue"><?php echo $fu['occupation'];?></span>
        
        </div>
    </div>
    
    <div class="memDetails w_40 disp_tc">
        <p><span>Phone No</span><strong>&nbsp; : &nbsp;</strong><?php echo $fu['phone'];?></p>
        <p><span>Email</span><strong>&nbsp; : &nbsp;</strong><?php echo $fu['email'];?></p>
        <p><span>IMI Chapter</span><strong>&nbsp; : &nbsp;</strong>
        <?php 
        echo $fu['region_name'];
        if ( $fu['country_name_of_birth'] ) 
        {
            echo ' - ' . $fu['country_name_of_birth'];	
        }
        
        if ( $fu['place_of_birth'] )
        {
            echo ', ' . $fu['place_of_birth'];	
        }
        ?>
        </p>
    </div>

    <div class="fl_lft w_100 memProLink">
        <a class="blue_btn1 fontFam_aleoReg fl_rit m_top20" href="javascript:;">View Complete Details</a>
    </div>
</div>
<!--Member-->