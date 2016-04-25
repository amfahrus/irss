<html>
<head>
<title>Online Examination System</title>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/main.css">
<link rel="stylesheet" href="<?=base_url();?>assets/js/validationEngine/css/validationEngine.jquery.css" type="text/css"/>
<script type="text/javascript" src="<?=base_url();?>assets/js/validationEngine/js/jquery-1.8.2.min.js"></script>
<script src="<?=base_url();?>assets/js/validationEngine/js/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8">
</script>
<script src="<?=base_url();?>assets/js/validationEngine/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8">
</script>

</head>
<body>
<div class="header">
	<div id="logo">
	<img src="<?=base_url();?>assets/images/logo.png" width="100px" style="margin:10px" alt="OES System"/>
	</div>
	<div class="main-menu-box ui-widget ui-widget-header" style="padding:5px">
	<div class="container">
	<div class="grid_16">
	<div class="main-menu">
  	<ul style="float:left">
    <li class="ui-corner-all ui-state-default"><a href="<?=base_url();?>users">Dashboard</a></li>
  	</ul>
	</div><!-- w3-main-menu -->	
	</div>

	<div class="grid_16" style="float:right">
	<div class="main-menu" style="width:300px;padding-top:5px; text-align: right;">
	<?php
	$session = get_session_details();
	if(isset($session->userdetails) && !empty($session->userdetails))
	{
		$loggeduser = (object)$session->userdetails;
		echo 'Howdy, '.$loggeduser->user_username.' <a style="padding:5px;text-decoration:none" class="ui-corner-all ui-state-active" href="'.base_url().'main/logout"> Logout </a>';
	}
	?>
	</div><!-- w3-main-menu -->	
	</div>
	<div class="clear">&nbsp;</div>
	</div>
	</div>
</div>
