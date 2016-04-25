<?php $this->load->view('admin/header');?>
<script>
$(document).ready(function(){
  $("#loginform").validationEngine();
}); 

</script>
<div class="mainholder">
	<!--Start login holder -->
	<div class="loginholder">
	<h1 style="text-align:center">Administrator - Login</h1>
	<div id="login">
	<?php
	if(isset($error)) echo '<p class="msg error">'.$error.'</p>';
	?>
	<form id="loginform" name="loginform" method="post" action="<?=base_url();?>admin/login">
	<p>
	<label><strong>Username</strong>
	<input type="text" name="username" class="validate[required] inputText">
	</label>
	</p>
	<p>
	<label><strong>Password</strong>
	<input type="password" name="password" class="validate[required] inputText">
	</label>
	</p>
	<div style="float:right;margin-right:30px">
		<input type="submit" value="Log in" name="loginbttn" class="input-button ui-corner-all ui-state-default">
	</div>
	<label>
	<!--<div id="forgot">
	<a href="#" class="forgotlink"><span>Forgot your username or password?</span></a></div>-->
	</label>            
	</form>
	<br clear="all">
	</div>
	</div>
	<!--end login holder -->
	<div class="clear">&nbsp;</div>
</div>


<?php $this->load->view('footer');?>
</body>
<html>
