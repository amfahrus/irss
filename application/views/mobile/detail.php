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
<div data-role="dialog">
	
		<div data-role="header" data-theme="b">
			<h1>Jobs Detail</h1>
		</div>
		<?php
			if($sql->num_rows() > 0){
				foreach ($sql->result() as $row) {
					echo "<div data-role=\"content\" data-theme=\"c\">
							<h1>".$row->jobs_name."</h1>
							<p>
								".$row->jobs_desc."
							</p>
							<ul data-role=\"listview\" data-inset=\"true\" data-theme=\"c\" data-dividertheme=\"b\"> 
									<li data-role=\"list-divider\">Kualifikasi Jurusan</li> 
									<li>".$row->jurusannya."</li> 
									<li data-role=\"list-divider\"></li>
							</ul>
							<ul data-role=\"listview\" data-inset=\"true\" data-theme=\"c\" data-dividertheme=\"b\"> 
									<li data-role=\"list-divider\">Waktu</li> 
									<li>Tanggal Posting : ".$this->dokumen_lib->simple($row->create_time)."</li>
									<li>Batas Waktu     : ".$this->dokumen_lib->simple($row->due_time)."</li>
									<li data-role=\"list-divider\"></li>
							</ul>
						   </div>";
				}
			} else {
				echo "<h1>Maaf untuk sementara belum ada lowongan pekerjaan yang tersedia</h1>";
			}
		
		?>
	</div>
</body>
</html>
