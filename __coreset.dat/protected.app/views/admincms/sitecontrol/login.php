<div class="form-box" id="login-box">
  <div class="header bg-red">Sign In</div>
  
  
  <form action="<?php echo site_url( $_directory . "login" );?>" method="post">
    <div class="body bg-gray">
      <div class="form-group">
      	<?php echo form_input(array("name"	=> "username", "type" => "text", "class" => "form-control", "placeholder" => "Username", "value" => set_value("username") ) )	?>
        
      </div>
      <div class="form-group">
        <?php echo form_input(array("name"	=> "password", "type" => "password", "class" => "form-control", "placeholder" => "Password", "value" => set_value("password") ) )	?>
      </div>
      
      <?php if ( $this->session->userdata('login_attempt') >= ADMIN_LOGIN_ATTEMPTS ) { ?>
          <div class="form-group">
          
            <?php echo $captcha['image']; ?> <br clear="all"><br clear="all">
			<?php echo form_input(array("name"	=> "captcha", "type" => "text", "class" => "form-control", "placeholder" => "Captcha" ) );	?>
          </div>
      <?php } ?>
      
      <div class="form-group" style="display:none;">
        <input type="checkbox" name="remember_me"/>
        Remember me </div>
    </div>
    <div class="footer">
      <button type="submit" class="btn bg-red  btn-block">Sign me in</button>
      <!--<p><a href="#">I forgot my password</a></p>
      <a href="register.html" class="text-center">Register a new membership</a> -->
   	</div>
  </form>
  
  
  
  
  <!--<div class="margin text-center"> <span>Sign in using social networks</span> <br/>
    <a href="<?php echo socialicons_link("fb");?>"><button class="btn bg-light-blue btn-circle"><i class="fa fa-facebook"></i></button></a>
    <a href="<?php echo socialicons_link("tw");?>"><button class="btn bg-aqua btn-circle"><i class="fa fa-twitter"></i></button></a>
    <a href="<?php echo socialicons_link("gp");?>"><button class="btn bg-red btn-circle"><i class="fa fa-google-plus"></i></button></a>
  </div>-->
  
  
</div>
