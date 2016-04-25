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
			<h1>Submit Lowongan</h1>
		</div>

		<div data-role="content" data-theme="c">
			<h1>Pilih Posisi Yang Dilamar</h1>
			<p>
			<?php
			if($sql->num_rows() > 0){
				?> <form action="<?php echo base_url(); ?>form" id="register_form" method="post" accept-charset="utf-8" data-ajax="false">
						<div data-role="fieldcontain">
						<label for="select-choice-a" class="select">Posisi :</label>
						<select name="jobs" id="select-choice-a" data-native-menu="false" data-mini="true">
								<?
									if ($sql->num_rows() > 0) {
										foreach ($sql->result() as $row) {
												?>
												<option value="<? echo $row->jobs_id; ?>"><? echo $row->jobsnya; ?></option>
												<?php
											}
										}
									?>
							</select>
						</div>
						<div class="ui-body ui-body-b">
						<fieldset class="ui-grid-solo">
								<div class="ui-block-a"><input type="submit" name="simpan" value="Daftar"></div>
						</fieldset>
						</div>
					 </form>
			<? } else {
				echo "<h1>Maaf untuk sementara belum ada lowongan pekerjaan yang tersedia</h1>";
			}
			?>
			</p>
		</div>
	</div>
</body>
</html>
