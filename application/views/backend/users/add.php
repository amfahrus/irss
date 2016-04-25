<script>
function passwd()
{
	$.post("<?php echo base_url() . "users/reset_passwd/" .$data['user_id']; ?>",function(response){
		alert('Reset Password Berhasil');
		window.location.reload();
	});
	return false;
}
</script>

<div>
	<ul class="breadcrumb">
		<li>
			<a href="<?php echo base_url() . 'users'; ?>"><? echo $modul; ?></a> <span class="divider">/</span>
		</li>
		<li>
			<a href="#"><? echo $title; ?></a>
		</li>
	</ul>
</div>

<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i><? echo $title; ?></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" action="<?php echo base_url() . $act; ?>" method='post'>
							<fieldset>
								
								<div class="control-group">
									<label class="control-label" for="focusedInput">Username</label>
									<div class="controls">
									  <input class="input-xlarge focused" name='username' id="focusedInput" type="text" value="<?php echo set_value('username', isset($data['username']) ? $data['username'] : ''); ?>">
									</div>
								</div>
								
								<div class="control-group">
									<label class="control-label" for="focusedInput">Password</label>
									<div class="controls">
										<?php echo isset($data['username']) ?'<button class="btn btn-primary" type="submit" onclick="return passwd();">Reset Password</button>' : '<input class="input-xlarge focused" name="password" id="focusedInput" type="text" value="">'; ?>
									</div>
								</div>
								
								<div class="control-group">
									<label class="control-label" for="focusedInput">Nama</label>
									<div class="controls">
									  <input class="input-xlarge focused" name="nama" id="focusedInput" type="text" value="<?php echo set_value('nama', isset($data['nama']) ? $data['nama'] : ''); ?>">
									</div>
								</div>
								
								<div class="control-group">
									<label class="control-label" for="focusedInput">Keterangan</label>
									<div class="controls">
									  <input class="input-xlarge focused" name="keterangan" id="focusedInput" type="text" value="<?php echo set_value('keterangan', isset($data['keterangan']) ? $data['keterangan'] : ''); ?>">
									</div>
								</div>
								
								<div class="control-group">
								<label class="control-label" for="selectError3">Group</label>
								<div class="controls">
								  <select id="selectError3" name="group">
									<?
									if ($group->num_rows() > 0) {
										foreach ($group->result() as $row) {
											if (isset($data['group_id']) && $data['group_id'] == $row->group_id) {
												?>
												<option value="<? echo $row->group_id; ?>" selected><? echo $row->group_name; ?></option>	
											<? } else { ?>
												<option value="<? echo $row->group_id; ?>"><? echo $row->group_name; ?></option>
											<?
											}
										}
									}
									?>
								  </select>
								</div>
							  </div>
								
							  <div class="form-actions">
								<button type="submit" class="btn btn-primary">Submit</button>
								<button class="btn">Cancel</button>
							  </div>
								
							</fieldset>
						</form>
					</div>
				</div><!--/span-->
</div><!--/row-->
