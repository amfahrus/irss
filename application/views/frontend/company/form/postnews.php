<script>
	$(document).ready(function(){
		$('.editor').wysihtml5();	
		addCompany();
		$("#select-company").change(function(){
			if($(this).val() == "add") {
			   $('#myModal').modal({
				  remote: '<?php echo base_url()."company/modal_add_company"; ?>'
				});
			}
		});
		$('#myModal').on('hidden.bs.modal', function() {
			$(this).removeData('bs.modal');
			$("#select-company").val('');
		});
	});
	
	function addCompany(){
		if($("#select-company").val() == "add") {
			$('#myModal').modal({
			  remote: '<?php echo base_url()."company/modal_add_company"; ?>'
			});
		}
	};
</script>
<div class="container">
      <div class="row row-offcanvas row-offcanvas-right">
	
<form class="form-horizontal" role="form" accept-charset="utf-8" enctype="multipart/form-data" method="post" action="<?php echo $act; ?>">
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		  				  
<div class="panel panel-default">

	  <div class="panel-heading">
        <h4><span class="glyphicon glyphicon-th-large"></span> <?php echo lang('company_info'); ?></h4>
      </div>
      <div class="panel-body">

		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('company_name'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
				<select id="select-company" name="company_id" class="form-control">
					 <?php 
						if($company->num_rows() > 0){
							foreach($company->result_array() as $companies){
								if($job_detail['company_id'] == $companies['company_id']){
									echo "<option value=\"".$companies['company_id']."\" selected>".$companies['company_name']."</option>";
								} else {
									echo "<option value=\"".$companies['company_id']."\">".$companies['company_name']."</option>";
								}
							}
						} else {
							echo "<option value=\"0\">Select Company</option>";
						}
					 ?>
					 <option value="add" ><?php echo lang('add_company'); ?></option>
			  </select>
			  <?php echo form_error('company_id','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		
		
      </div>
</div>

<div class="panel panel-default">
      <div class="panel-heading">
        <h4><span class="glyphicon glyphicon-briefcase"></span> <?php echo lang('news'); ?></h4>
      </div>
      <div class="panel-body">
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('news_name'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" name="news_name" class="form-control" placeholder="<?php echo lang('news_name'); ?>" value="<?php echo $news['news_name'] ? $news['news_name'] : ''; ?>">
			  <?php echo form_error('news_name','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('news_desc'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <textarea class="form-control editor" rows="3" name="news_desc" placeholder="<?php echo lang('news_desc'); ?>"><?php echo $news['news_desc'] ? $news['news_desc'] : ''; ?></textarea>
			  <?php echo form_error('news_desc','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label">File</label>
			<div class="col-sm-10">
			  <input type="file" name="news_file">
			  <div class="help-block"><?php echo lang('max_3mb_with_only_zip_extension'); ?></div>
			</div>
		  </div>
		  
      </div>
</div>
      
<div class="panel panel-default">
      <div class="panel-body">
		  
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <button type="submit" class="btn btn-danger"><?php echo lang('next'); ?></button>
			  <a href="<?php echo base_url().'company/news'; ?>" class="btn btn-warning"><?php echo lang('cancel'); ?></a>
			</div>
		  </div>
		  
      </div>
</div>
	</form>
  

	</div>
</div><!-- /.container -->

<!-- Modal -->
<div class="modal fade" id="ModalStep" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Dialog</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
