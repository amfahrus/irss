<body class='special-page'>
    <section style="margin:0 auto;width:400px">
        <div id='container'>
            <div class='block-border'>
                <div class='block-header'>
                    <h1>Registrasi User</h1>
                    <span></span>
                </div>



                <form id='validate-form' class="block-content form" action="<?php echo base_url(); ?>beranda/register_user" method='post'>

                    <?php
                    
                    $pesan_sukses = $this->session->flashdata('pesan_sukses');

                    if (!empty($pesan_sukses)) {

                        echo "<div class=\"alert success\"><strong>Success</strong>  " . $pesan_sukses . "</div>";
                    } 
                    ?>



                    <div class='_100'>
                        <p><label for='textfield'>Username</label><input id='username' name='username' class='required' type='text' value="<?= set_value('username'); ?>"/></p>
                        <?= form_error('username','<div class="error">', '</div>'); ?>
                    </div>


                    <div class='_100'>
                        <p>
							<label for='textfield'>Nama Lengkap</label>
							<input id='nama' name='nama' class='required' type='text' value="<?= set_value('nama'); ?>"/>
							<?= form_error('nama','<div class="error">', '</div>'); ?>
							</p>
                    </div>
                    
                    <div class='_100'>
                        <p>
							<label for='textfield'>Email</label>
							<input id='email' name='email' class='required' type='text' value="<?= set_value('email'); ?>"/>
							<?= form_error('email','<div class="error">', '</div>'); ?>
							</p>
                    </div>




<div class='_100'>
<p><label for='select'>Keterangan</label>

<select  name="bag_id">
<?php
foreach ($bagian->result() as $row) {

echo "<option value = '" . $row->bag_id . "'>" . $row->bag_code . "</option>";
}
?>
</select>
</p>
</div>


                    <div class='_100'>
                        <p>
                            <label for='select'>Unit Kerja</label>

                            <select  name="biro_id">
<?php
foreach ($biro->result() as $row) {

    echo "<option value = '" . $row->biro_id . "'>" . $row->biro_nama . "</option>";
}
?>
                            </select>


                        </p>
                    </div>

                    <div class='_100'>
                        <p>
                            <label for='select'>Jabatan</label>
                            <select name="role1">
<?php
foreach ($jabatan->result() as $row) {

    echo "<option value = '" . $row->role_id . "'>" . $row->role . "</option>";
}
?>
                            </select>
                        </p>
                    </div>


                    <div class='_100'>
                        <p>
							<label for='textfield'>Security Code</label>
							<img src="<?= base_url(); ?>captcha/normal/<?php echo uniqid(time()); ?>" /><br />
							
                        </p>
						<p><input id='security_code' name='security_code' class='required' type='text' value=""/>
						<?= form_error('security_code','<div class="error">', '</div>'); ?>
						</p>
                    </div>




                    <div class='clear'>
                    </div>
                    <div class='block-actions'>
                        <ul class='actions-left'>
                            <li><a class="button red" id='reset-validate-form' href="<?php echo base_url(); ?>beranda/">Kembali</a></li>
                        </ul>
                        <ul class='actions-right'>
                            <li><input type='submit' class='button' value="Daftar"></li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>
