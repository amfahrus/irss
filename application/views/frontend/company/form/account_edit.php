<div class="container">
      <div class="row row-offcanvas row-offcanvas-right">
		  
<div class="panel panel-default">
	  <div class="panel-heading">
        <h4><span class="glyphicon glyphicon-th-large"></span> Edit <?php echo lang('account'); ?></h4>
      </div>
      <div class="panel-body">
        <form class="form-horizontal" role="form" accept-charset="utf-8" enctype="multipart/form-data" method="post" action="<?php echo $act; ?>">
		  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('account_username'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" name="company_account_username" class="form-control" placeholder="<?php echo lang('account_username'); ?>" value="<?php echo $company_account['company_account_username']; ?>">
			  <?php echo form_error('company_account_username','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('company_name'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" name="company_account_name" class="form-control" placeholder="<?php echo lang('company_name'); ?>" value="<?php echo $company_account['company_account_name']; ?>">
			  <?php echo form_error('company_account_name','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		   <div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label"><?php echo lang('company_email'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="email" name="company_account_email" class="form-control" id="inputEmail3" placeholder="<?php echo lang('company_email'); ?>" value="<?php echo $company_account['company_account_email']; ?>">
			  <?php echo form_error('company_account_email','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <button type="submit" class="btn btn-danger"><?php echo lang('update'); ?></button>
			  <a href="<?php echo base_url().'company/profile/'; ?>" class="btn btn-warning"><?php echo lang('cancel'); ?></a>
			</div>
		  </div>
		</form>
      </div>
  </div>
  
</div>
        

</div><!-- /.container -->
