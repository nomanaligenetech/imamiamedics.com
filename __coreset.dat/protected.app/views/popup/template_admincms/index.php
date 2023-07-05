<?php $this->load->view('popup/template_admincms/_head.php');?>



<body>

		<?php
		if ( $h2 )
		{
		?>
			<h2 class="mainh2"><?php echo $h2;?></h2>
		<?php
		}
		
		
		$this->load->view($_pageview);
        ?>


</body>
</html>
