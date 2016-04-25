<?php $this->load->view('default_header');?>
<script>
$(document).ready(function(){
  $("#regform").validationEngine();
}); 

</script>
<div class="mainholder">

	<!--<div class="hintsidebar ui-corner-all">
	<span class="icon-left ui-icon ui-icon-info"></span> 
	Hint: Create a member account. Its free and easy !</tt>
	</div>-->
	<!--Start register holder -->
	<div class="loginholder">

	<div class="logincontent ui-corner-all">
		<h1 class="w3-page-label">Register a member account</h1>
		<?php 
		if(isset($success))
			echo '<p id="success" class="msg done">'.$success.'</p>'
		?>
		
		<form action="" method="post" id="regform">
		<table>
	    <tbody><tr>
	    <td><div class="label">First Name</div></td>
	    <td><div class="input">
	    	<input type="text" name="firstname" size="39" class="ui-corner-all input-text validate[required]"><?=form_error('firstname'); ?></div></td>
	    </tr>
	    <tr>
	    <td><div class="label">Last Name</div></td>
	    <td><div class="input">
	    	<input type="text" name="lastname" size="39" class="ui-corner-all input-text validate[required]"><?=form_error('lastname'); ?></div></td>
	    </tr>
	    <tr>
	    <td><div class="label">Email</div></td>
	    <td><div class="input">
	    <input type="text" name="email" size="39" class="ui-corner-all input-text validate[required, custom[email]]"><?=form_error('email'); ?>
		</div></td>
	    </tr>
	    <tr>
	    <td><div class="label">Username</div></td>
	    <td><div class="input"><input type="text" name="username" size="39" class="ui-corner-all input-text validate[required] minSize[3] maxSize[20]"><?=form_error('username'); ?></div></td>
	    </tr>
	    <tr>
	    <td><div class="label">Password</div></td>
	    <td><div class="input"><input type="password" name="password" id="password" size="39" class="ui-corner-all input-text validate[required] minSize[6] maxSize[20]"><?=form_error('password'); ?></div></td>
	    </tr>
	    <tr>
	    <td><div class="label">Repeat Password</div></td>
	    <td><div class="input"><input type="password" name="confirmpassword" size="39" class="ui-corner-all input-text validate[required] equals[password]"><?=form_error('confirmpassword'); ?></div></td>
	    </tr>
	 	<tr>
	 	<td>&nbsp;</td>
	 	<td><input type="submit" value="Register member account" name="registerbttn" class="input-button ui-corner-all ui-state-default"></td>
	    </tr>
	    </tbody></table>
	    </form>
	</div>
	</div>
	<!--end register holder -->
	<div class="clear">&nbsp;</div>
</div>
<?php $this->load->view('footer');?>
</body>
<html>