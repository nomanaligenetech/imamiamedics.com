<?php $this->load->view('popup/template/_head.php');?>



<body>

		<?php
		if ( $h2 )
		{
			//margin: 4px 0 25px 0;
		?>
			<h2 class="mainh2"><?php echo $h2;?></h2>
		<?php
		}
		
		
		$this->load->view($_pageview);
        

		
        /*if ($showThings['_show_FOOTER'])
        {
            $this->load->view('popup/template/_footer.php');
        }*/
        ?>


</body>
</html>
