<script src="<?php echo base_url() ?>assets/backend/js/jquery-1.7.2.min.js"></script>
<script>
	$(document).ready(function() {
	   list_menu();
	});
		function list_menu()
				{
					$.ajax({

					  url: '<?php echo base_url();?>akses/menu/'+$("#selectError3").val(),
					  success: function(data) {
							$('#group_list').html(data);
					  },
					beforeSend: function(){ $('.wait').show();},
					complete: function(){ $('.wait').hide();}
					});
				}
</script>
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
						<form class="form-horizontal" action="<?php echo base_url() . $act; ?>" method='post'>
						
						<div class="control-group">
								<label class="control-label" for="selectError3">Group</label>
								<div class="controls">
								  <select id="selectError3" onchange="list_menu();" name="group">
									<?
									if ($groups->num_rows() > 0) {
										foreach ($groups->result() as $row) {
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
							
						<div class="control-group">
									<label class="control-label" for="focusedInput">Menu</label>
									<div class="controls" id="group_list">
									  <img class="wait" src="<?php echo base_url(); ?>assets/backend/img/ajax-loaders/ajax-loader-7.gif" alt="Loading...">
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
