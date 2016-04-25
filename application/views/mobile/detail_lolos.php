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
			<h1><?php echo $tahapan; ?></h1>
		</div>
		<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b"> 
			<li>Peserta Lulus Untuk Posisi <?php echo $jobs; ?></li> 
			<li><?php echo $keterangan; ?></li> 
			<li><div class="ui-grid-c ui-shadow ui-responsive">
                    <div align="center" class="ui-block-a">
						<div class="ui-bar ui-bar-b">
						Nama
						</div>
                    </div>
                    <div class="ui-block-b">
						<div class="ui-bar ui-bar-b">
						Jurusan
						</div>
                    </div>
                    <div class="ui-block-c">
						<div class="ui-bar ui-bar-b">
						Universitas
						</div>
                    </div>
                    <div class="ui-block-d">
						<div class="ui-bar ui-bar-b">
						Kota
						</div>
                    </div>
                </div>
		<?php
			if($sql->num_rows() > 0){
				foreach ($sql->result() as $row) {
					 ?>
                                    <div class="ui-grid-c ui-shadow ui-body-d ui-responsive">
										<div align="center" class="ui-block-a">
											<div class="ui-bar" >
											<? echo $row->nama; ?> 
											</div>
										</div>
										<div class="ui-block-b">
											<div class="ui-bar">
											<? echo $row->jurusan; ?>
											</div>
                                        </div>
										<div class="ui-block-c">
											<div class="ui-bar">
											<? echo $row->universitas; ?>
											</div>
										</div>
										<div class="ui-block-d">
											<div class="ui-bar">
											<? echo $row->kota; ?>
											</div>
										</div>
									</div>
			  <?php }
			} else {
				echo "<h1>Maaf untuk sementara belum ada lowongan pekerjaan yang tersedia</h1>";
			}
		
		?>
		<li data-role="list-divider"></li>
	</ul>      
	</div>
</body>
</html>
