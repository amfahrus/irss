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
	<div id="logo">	<img src="<?=base_url();?>assets/images/logo.png" width="100px" style="margin:10px" alt="OES System"/></div>
	<div class="main-menu-box ui-widget ui-widget-header" style="padding:5px">
	<div class="container">
	<div class="grid_16">
	<div class="main-menu">
  	<ul>
    <li class="ui-corner-all ui-state-default <?=($active == 'login') ? 'ui-state-active' : '' ;?>"><a href="<?=base_url();?>" title="Authenticate using your member account">Login</a></li>
	</ul>
	</div><!-- w3-main-menu -->	
	</div>
	<div class="clear">&nbsp;</div>
	</div>
	</div>
</div>
