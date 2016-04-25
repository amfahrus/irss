<script>
	$(document).ready(function(){
		
		$('.selectpicker').selectpicker();
		$('textarea').wysihtml5();
		
	});
</script>
<div class="container">
      <div class="row row-offcanvas row-offcanvas-right">
		  
<div class="panel panel-default">
	  <div class="panel-heading">
        <h4><span class="glyphicon glyphicon-user"></span> Edit <?php echo lang('additional'); ?></h4>
      </div>
      <div class="panel-body">
        <form class="form-horizontal" role="form" accept-charset="utf-8" enctype="multipart/form-data" method="post" action="<?php echo $act; ?>">
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		  
		<?php
			if($expectation->num_rows() > 0){
				foreach($expectation->result_array() as $expectations){
		?>
		 <div id="entry" class="clonedInput">
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('uploaded_resume'); ?></label>
			<div class="col-sm-10">  
				<input type="file" name="expected_url_cv" id="InputFile"><br>
				<?php if(!empty($expectations['expected_url_cv'])){ ?>
				<a href="<?php echo $expectations['expected_url_cv']; ?>" class="btn btn-primary" target="_blank">Download</a>
				<?php } ?>
				<div class="help-block">
					<?php echo lang('max_300kb_with_only_pdf,_doc,_docx_extension'); ?>
				</div>
		    </div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('expected_sallary'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" name="expected_sallary" class="form-control" placeholder="<?php echo lang('expected_sallary'); ?>" value="<?php echo $expectations['expected_sallary']; ?>">
			  <?php echo form_error('expected_sallary','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('expected_work_location'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
				<select name="city_id" class="form-control selectpicker" data-live-search="true">
					 <?php 
						if(count($location) > 0){
							foreach($location as $locations){
								if($expectations['city_id'] == $locations['city_id']){
									echo "<option value=\"".$locations['city_id']."\" selected>".$locations['city_name']."</option>";
								} else {
									echo "<option value=\"".$locations['city_id']."\">".$locations['city_name']."</option>";
								}
								if(count($locations['child']) > 0){
									foreach($locations['child'] as $childs_key => $childs_val){
										if($expectations['city_id'] == $childs_key){
											echo "<option value=\"".$childs_key."\" selected>- ".$childs_val."</option>";
										} else {
											echo "<option value=\"".$childs_key."\">- ".$childs_val."</option>";
										}
									}
								}
							}
						}
					 ?>
			  </select>
			</div>
		  </div>
		 
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('additional_info'); ?></label>
			<div class="col-sm-10">
			  <textarea class="form-control" rows="3" name="expected_description"><?php echo $expectations['expected_description']; ?></textarea>
			  <?php echo form_error('expected_description','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  </div>
		  
		  <?php 
				}
			} else {
		  ?>
		  
		  <div id="entry" class="clonedInput">
			  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('uploaded_resume'); ?></label>
			<div class="col-sm-10">  
				<input type="file" name="expected_url_cv" id="InputFile">
				<div class="help-block">
					<?php echo lang('max_300kb_with_only_pdf,_doc,_docx_extension'); ?>
				</div>
		    </div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('expected_sallary'); ?></label>
			<div class="col-sm-10">
			  <input type="text" name="expected_sallary" class="form-control" placeholder="<?php echo lang('expected_sallary'); ?>" value="">
			  <?php echo form_error('expected_sallary','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('expected_work_location'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
				<select name="city_id" class="form-control selectpicker" data-live-search="true">
					 <?php 
						if(count($location) > 0){
							foreach($location as $locations){
								echo "<option value=\"".$locations['city_id']."\">".$locations['city_name']."</option>";
								if(count($locations['child']) > 0){
									foreach($locations['child'] as $childs_key => $childs_val){
										echo "<option value=\"".$childs_key."\">- ".$childs_val."</option>";
									}
								}
							}
						}
					 ?>
			  </select>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('additional_info'); ?></label>
			<div class="col-sm-10">
			  <textarea class="form-control" rows="3" name="expected_description"></textarea>
			  <?php echo form_error('expected_description','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  </div>
		  
		  <?php
			}
		  ?>
		  
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <button type="submit" class="btn btn-danger"><?php echo lang('update'); ?></button>
			  <a href="<?php echo base_url().'person/cv/'; ?>" class="btn btn-warning"><?php echo lang('cancel'); ?></a>
			</div>
		  </div>
		</form>
      </div>
  </div>
  
</div>
        

</div><!-- /.container -->
