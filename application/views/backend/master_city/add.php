
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
						<h2><i class="icon-edit"></i><? echo $subtitle; ?></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" action="<?php echo base_url() . $act; ?>" accept-charset="utf-8" enctype="multipart/form-data" method='post'>
							<fieldset>
								<div class="control-group">
									<label class="control-label" for="focusedInput">City Name</label>
									<div class="controls">
									  <input class="input-xlarge focused" name='city_name' id="focusedInput" type="text" value="<?php echo set_value('city_name', isset($data['city_name']) ? $data['city_name'] : ''); ?>">
									</div>
								</div>
								
								<div class="control-group">
								<label class="control-label" for="selectError3">Parent</label>
								<div class="controls">
								  <select id="selectError3" name="parent">
									<option value="0">Root</option>  
									<?
									if ($sql->num_rows() > 0) {
										foreach ($sql->result() as $row) {
											if (isset($data['parent']) && $data['parent'] == $row->city_id) {
												?>
													<option value="<? echo $row->city_id; ?>" selected><? echo $row->city_name; ?></option>
												<? } else { ?>
													<option value="<? echo $row->city_id; ?>"><? echo $row->city_name; ?></option>
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
							  </div>
								
							</fieldset>
						</form>
					</div>
				</div><!--/span-->
</div><!--/row-->
