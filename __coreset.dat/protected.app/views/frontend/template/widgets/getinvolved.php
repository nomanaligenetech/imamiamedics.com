<?php
if ( $getinvolved -> num_rows() > 0 )
{
?>
    <div class="left_area fl_lft m_bottom25">
        <div class="left_area_bottom fl_lft">
        
            <ul class="ulli2">
            	<?php echo $this->load->view('frontend/template/_getinvolved.php');?>
            </ul>
        
        </div>
    </div>
<?php
}
?>