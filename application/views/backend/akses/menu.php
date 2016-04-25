<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/backend/css/jquery.checkboxtree.css"/>
<script type="text/javascript" src="<?php echo base_url();?>assets/backend/js/jquery.checkboxtree.js"></script>
<script>
	$('#tree1').checkboxTree();
</script>
                            
<ul id="tree1">
	<?php echo $this->dokumen_lib->build_cekmenu($group); ?>
</ul>
                       
