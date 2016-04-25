
<?php $this->load->view('default_header');?>
<script>
$(document).ready(function(){
  $("#loginform").validationEngine();
}); 

</script>
<div class="mainholder">

	<!--<div class="hintsidebar ui-corner-all">
	<span class="icon-left ui-icon ui-icon-info"></span> 
	Hint: You may login with <tt>demo/demo</tt>
	</div>-->
	<!--Start login holder -->
	<div class="loginholder">
	<div class="logincontent ui-corner-all" style="margin-top: 60px;">
		<h1 class="w3-page-label">User Login</h1>
		<?php
		if(isset($error)) echo '<p class="msg error">'.$error.'</p>';
		?>
		<form action="<?=base_url();?>main/login" method="post" id="loginform">
		<table>
	    <tbody><tr>
	    <td><div class="label">Username / Email</div></td>
	    <td><div class="input"><input type="text" name="username" size="39" class="ui-corner-all input-text validate[required]"></div></td>
	    </tr>
	    <tr>
	    <td><div class="label">Password</div></td>
	    <td><div class="input"><input type="password" name="password" size="39" class="ui-corner-all input-text validate[required]"></div></td>
	    </tr>
	 	<tr>
	 	<td>&nbsp;</td>
	 	<td><input type="submit" value="Log in" name="loginbttn" class="input-button ui-corner-all ui-state-default"></td>
	    </tr>
	    </tbody></table>
	    </form>
	</div>
	</div>
	<!--end login holder -->
	<div class="clear">&nbsp;</div>
</div>
<?php $this->load->view('footer');?>
</body>
<html>
