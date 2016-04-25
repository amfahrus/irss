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
			<h1>Petunjuk</h1>
		</div>

		<div data-role="content" data-theme="c">
			<h1>Petunjuk Pengisian Form Lamaran</h1>
			<p>
			1. Silahkan Download dan isi Terlebih dahulu Format CV yang telah disediakan <a href="<?php echo base_url(); ?>form_daftar_pegawai_new.xlsx">disini</a><br/>
			2. Isi data lengkap Form Lamaran pada menu Kirim Lamaran. <br/>
			3. Upload CV (max. 500kb) yang telah diisi lengkap beserta foto dengan diberi nama file sesuai nama anda, contoh (Nama_Lengkap_Anda.xlsx).<br/>
			4. Upload Ijazah (max. 500kb) dengan format pdf yang diberi nama file sesuai nama anda, contoh (Nama_Lengkap_Anda_Ijazah.pdf).<br/>
			5. Upload Transkrip nilai (max. 500kb) akademik dengan format pdf yang diberi nama file sesuai dengan nama anda, contoh(Nama_Lengkap_Anda_Transkrip.pdf).<br/>
			</p>
			<a href="<?php echo base_url(); ?>form_daftar_pegawai_new.xlsx" data-role="button" data-rel="back" data-theme="b">Download CV</a>  
		</div>
	</div>
</body>
</html>
