<!DOCTYPE html> 
<html> 
   <head> 
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="icon" type="image/png" href="<?php echo base_url() ?>assets/images/brantas.png"/>
   <title><?php
            echo $this->config->item("web_title");
            ?> (Mobile Version)</title> 

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/jqueryMobile/css/themes/default/jquery.mobile-1.1.1.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/jqueryMobile/css/themes/default/jquery.mobile.structure-1.1.1.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/jqueryMobile/css/themes/default/jquery.mobile.theme-1.1.1.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/jqueryMobile/docs/_assets/css/jqm-docs.css" />
	<script src="<?php echo base_url(); ?>assets/jqueryMobile/js/jquery.js"></script>
	<script src="<?php echo base_url(); ?>assets/jqueryMobile/js/jquery.mobile-1.1.1.js"></script>
	<script src="<?php echo base_url(); ?>assets/jqueryMobile/docs/_assets/js/jqm-docs.js"></script>

</head> 
<body>
<div data-role="page">
	<header data-role="header" data-theme="b">
     <h1>
       <?php
            echo $this->config->item("web_title");
            ?> (Mobile Version)
     </h1>
	<div data-role="navbar" data-theme="b">
		<ul>
			<li><a href="<?php echo base_url(); ?>" data-role="button" data-theme="b" data-icon="home">Home</a></li>
		</ul>
	</div>
   </header>
<?php
if(isset($contents)){
    echo $this->load->view($contents);
}
?>
 <!-- /page -->
 
   <footer data-role="footer" data-theme="b">
      <h1>Brantas Abipraya</h1>
   </footer>	
 </div>  
</body>
</html>
