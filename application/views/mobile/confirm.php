<div data-role="content">
   <p>Selamat datang di situs rekrutmen PT Brantas Abipraya<span>Kami mengundang putra putri terbaik bangsa Indonesia untuk bergabung</span></p>

<?php
			if($sql->num_rows() > 0){
				foreach ($sql->result() as $row) {
				?><p>Silahkan konfirmasi kehadiran anda dengan menekan tombol hadir</p>
					<form action="<?php echo base_url(); ?>home/confirm_act" id="register_form" method="post" accept-charset="utf-8" enctype="multipart/form-data" name="form" data-ajax="false">
					<input type="hidden" name="key" value="<?php echo $row->key; ?>" />
						
						<fieldset>
						<div data-role="fieldcontain">
						 <label for="nama"><b>Nama Lengkap : </b></label>
						 <label for="nama"><?php echo $row->nama; ?></label>
						</div>
						
						<div data-role="fieldcontain">
						 <label for="nama"><b>Gender : </b></label>
						 <label for="nama"><?php echo $row->gender; ?></label>
						</div>
						
						<div data-role="fieldcontain">
						 <label for="nama"><b>Email : </b></label>
						 <label for="nama"><?php echo $row->email; ?></label>
						</div>
						
						<div data-role="fieldcontain">
						 <label for="nama"><b>Universitas : </b></label>
						 <label for="nama"><?php echo $row->universitas; ?></label>
						</div>
						
						<div data-role="fieldcontain">
						 <label for="nama"><b>Kota : </b></label>
						 <label for="nama"><?php echo $row->kota; ?></label>
						</div>
						
						<div data-role="fieldcontain">
						 <label for="nama"><b>Posisi : </b></label>
						 <label for="nama"><?php echo $row->jobs_name; ?></label>
						</div>
						
						<div class="ui-body ui-body-b">
						<fieldset class="ui-grid-a">
								<div class="ui-block-a"><input type="reset" name="batal" value="Batal" onclick="window.location = '<?php echo base_url();?>'"/></div>
								<div class="ui-block-b"><input type="Submit" name="simpan" value="Hadir"/></div>
						</fieldset>
						</div>
					 </form>
			<? } 
			}
		?>
</div>
