<?php $this->load->view('admincms/template_login/_head.php');?>    
    
    
    <body class="bg-black">
        
        <div class="show_errors">
        	<?php $this->load->view('admincms/template_login/_show_messages.php');?>    
        </div>
        
        <!-- #PAGE CONTENT -->
    
        	<?php  $this->load->view($_pageview) ;?>
        
    	<!-- #PAGE CONTENT -->

    </body>
</html>