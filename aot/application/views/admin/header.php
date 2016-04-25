<html>
<head>
<title>Online Examination System</title>
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/admin/css/admin.css">
<link rel="stylesheet" href="<?=base_url();?>assets/js/validationEngine/css/validationEngine.jquery.css" type="text/css"/>
<script type="text/javascript" src="<?=base_url();?>assets/js/validationEngine/js/jquery-1.8.2.min.js"></script>
<script src="<?=base_url();?>assets/js/validationEngine/js/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8">
</script>
<script src="<?=base_url();?>assets/js/validationEngine/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8">
</script>
<script src="<?=base_url();?>assets/admin/js/datatable/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?=base_url();?>assets/admin/js/jquery-ui.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?=base_url();?>assets/admin/css/jquery-ui.css" type="text/css"/>
<script type="text/javascript">
    $(document).ready(function () { 
       $('#contenttable').selectableDataTable({
          iDisplayLength: 6,
          bAutoWidth: true,
          
        }) 
    });
</script>

</head>
<body>
<div class="header">
	<div id="logo"><img src="<?=base_url();?>assets/images/logo.png" width="100px" style="margin:10px" alt="OES System"/></div>
	<div class="main-menu-box ui-widget ui-widget-header" style="padding:5px">
	<div class="main-menu" style="width:300px;padding-top:5px;float:right; text-align: left;">
<?php
	$session = get_session_details();
	if(isset($session->admindetails) && !empty($session->admindetails))
	{
		$loggedadmin = (object)$session->admindetails;
		echo 'Howdy, '.$loggedadmin->adminusername.' <a style="padding:5px;text-decoration:none" class="ui-corner-all ui-state-active" href="'.base_url().'admin/logout"> Logout </a>';
	}
?>
	</div>
	</div>
</div>

