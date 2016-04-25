<div>
				<ul class="breadcrumb">
					<li>
						<a href="<?php echo base_url(); ?>">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Serial Number</a>
					</li>
				</ul>
			</div>
			
<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i>Input Serial Number</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" action="<?php echo base_url(); ?>beranda/input_serial" method='post'>
						
						<div class="control-group">
							<label class="control-label" for="disabledInput">Contact Person Name</label>
								<div class="controls">
								  <input class="input-xlarge disabled" id="disabledInput" type="text" placeholder="Asep Muhammad Fahrus" disabled="">
								</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="disabledInput">Contact Person Phone</label>
								<div class="controls">
								  <input class="input-xlarge disabled" id="disabledInput" type="text" placeholder="081323025598" disabled="">
								</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="disabledInput">Contact Person Email</label>
								<div class="controls">
								  <input class="input-xlarge disabled" id="disabledInput" type="text" placeholder="f4ztr1k@yahoo.co.id" disabled="">
								</div>
						</div>
						
						<div class="control-group">
							<label class="control-label" for="focusedInput">Serial Number</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="focusedInput" type="text" name="serial" value="">
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
