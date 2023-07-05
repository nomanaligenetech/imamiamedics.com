<?php
if ( $SHOW_conferenceregistration_breadcrumbs) 
{
?>
    <div class="step-pagination">
        <ul>
            <?php
			$if_price_package_contains_applyvisa					= $this->functions->validate_if_require_visa( $conferenceregistration );
            
			
            if ( $current_page )
            {
                $breadcrumbs[$current_page]	= "active";
            }

            $tmp_bc[1]					= array("href"			=> site_url("shortconference/". $conference->row("slug") ."/registration/screen/1"));
            $tmp_bc[2]					= array("href"			=> site_url("shortconference/". $conference->row("slug") ."/registration/screen/2"));
			$tmp_bc[3]					= array("href"			=> site_url("shortconference/". $conference->row("slug") ."/registration/screen/3"));
            $tmp_bc[4]					= array("href"			=> site_url("shortconference/". $conference->row("slug") ."/registration/screen/4"));
			
			if ( !$if_price_package_contains_applyvisa )
			{
            	$tmp_bc[3]['is_show']	= FALSE;
				$tmp_bc[4]['is_show']	= FALSE;
			}
			
            $tmp_bc[5]					= array("href"			=> site_url("shortconference/". $conference->row("slug") ."/registration/screen/5"));
           
			
            
			$__new_steps_counter		= 0;
            for ($i=1; $i <= count($tmp_bc); $i++)
            {
                $class1					= '';
                if ( array_key_exists( $i, $breadcrumbs) )
                {
                    $class1				= $breadcrumbs[ $i ];
                }
				
				
				
				if ( isset( $tmp_bc[$i]['is_show'] ) )
				{
					if (  $tmp_bc[$i]['is_show'] == FALSE )
					{
						
						continue;	
					}
				}
				
				$__new_steps_counter++;
                
            ?>
                <li class="step<?php echo $i;?> <?php echo $class1;?>">
                    <a href="<?php echo $tmp_bc[ $i ]['href'];?>">Step 0<?php echo $__new_steps_counter;?></a>
                </li>
            <?php
            }
            ?>
        </ul>
    </div>



    <p>&nbsp;</p>
    <?php
    $data["_messageBundle"]				= $_messageBundle_youcanalwaysresumelater;
    if($this->functions->_user_logged_in_details( "id" ) > 0 ){
        ?>
        <div class="inline_error_style"><?php $this->load->view('frontend/template/_show_messages.php', $data); ?> </div>
        
    <?php
        }
}
?>