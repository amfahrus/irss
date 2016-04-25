<div>
	<ul class="breadcrumb">
		<li>
			<a href="<?php echo $home; ?>"><? echo $modul; ?></a> <span class="divider">/</span>
		</li>
		<li>
			<a href="#"><? echo $subtitle; ?></a>
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
									<label class="control-label" for="focusedInput">Label</label>
									<div class="controls">
									  <input class="input-xlarge focused" name='label' id="focusedInput" type="text" value="<?php echo set_value('label', isset($data['label']) ? $data['label'] : ''); ?>">
									</div>
								</div>
								
								<div class="control-group">
									<label class="control-label" for="focusedInput">Link</label>
									<div class="controls">
									  <input class="input-xlarge focused" name="link" id="focusedInput" type="text" value="<?php echo set_value('link', isset($data['link']) ? $data['link'] : ''); ?>">
									</div>
								</div>
								
								<div class="control-group">
									<label class="control-label" for="focusedInput">Gambar / Icon</label>
									<div class="controls">
									  <input class="input-xlarge focused" name="image" id="focusedInput" type="text" value="<?php echo set_value('image', isset($data['image']) ? $data['image'] : ''); ?>">
									</div>
								</div>
								
								<div class="control-group">
									<label class="control-label" for="focusedInput">Urutan</label>
									<div class="controls">
									  <input class="input-xlarge focused" name="urutan" id="focusedInput" type="text" value="<?php echo set_value('urutan', isset($data['urutan']) ? $data['urutan'] : ''); ?>">
									</div>
								</div>
								
								<div class="control-group">
								<label class="control-label" for="selectError3">Parent</label>
								<div class="controls">
								  <select id="selectError3" name="parent">
									<option value="0">Root</option>  
									<?
									if ($menus->num_rows() > 0) {
										foreach ($menus->result() as $row) {
											if (isset($data['parent']) && $data['parent'] == $row->menu_id) {
												?>
													<option value="<? echo $row->menu_id; ?>" selected><? echo $row->label; ?></option>
												<? } else { ?>
													<option value="<? echo $row->menu_id; ?>"><? echo $row->label; ?></option>
												<?
												}
											}
										}
									?>
								  </select>
								</div>
							  </div>
								
								<div class="control-group">
								<label class="control-label" for="selectError3">Visible</label>
								<div class="controls">
								  <select id="selectError3" name="visible">
									<option value="1" <?php echo set_value('visible', isset($data['visible']) && $data['visible'] == 1 ? 'selected' : ''); ?> >Tampilkan</option>
                                    <option value="0" <?php echo set_value('visible', isset($data['visible']) && $data['visible'] == 0 ? 'selected' : ''); ?> >Sembunyikan</option>
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
