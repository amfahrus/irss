<!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>assets/frontend/twbs/css/bootstrap.css" rel="stylesheet">
<!-- Modal -->
<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-th-large"></span> <?php echo lang('company'); ?> <?php echo lang('registration'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" accept-charset="utf-8" method="post" action="<?php echo $act; ?>">
		  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		  <div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
			<div class="col-sm-10">
			  <input type="email" name="company_account_email" class="form-control" id="inputEmail3" placeholder="Email">
			  <?php echo form_error('company_account_email','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputPassword3" class="col-sm-2 control-label">Password</label>
			<div class="col-sm-10">
			  <input type="password" name="company_account_password" class="form-control" id="inputPassword3" placeholder="Password">
			  <?php echo form_error('company_account_password','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputNama" class="col-sm-2 control-label"><?php echo lang('account_username'); ?></label>
			<div class="col-sm-10">
			  <input type="text" name="company_account_username" class="form-control" id="inputNama" placeholder="<?php echo lang('account_username'); ?>">
			  <?php echo form_error('company_account_username','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputNama" class="col-sm-2 control-label"><?php echo lang('account_name'); ?></label>
			<div class="col-sm-10">
			  <input type="text" name="company_account_name" class="form-control" id="inputNama" placeholder="<?php echo lang('account_name'); ?>">
			  <?php echo form_error('company_account_name','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputNama" class="col-sm-2 control-label">Security Code</label>
			<img src="<?= base_url(); ?>captcha/normal/<?php echo uniqid(time()); ?>" /><br />
			<div class="col-sm-10">
			  <input type="text" name="security_code" class="form-control" id="security_code">
			  <?php echo form_error('security_code','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <button type="submit" class="btn btn-success"><?php echo lang('register'); ?></button>
			  <a href="<?php echo base_url(); ?>" class="btn btn-info"><?php echo lang('home'); ?></a>
			</div>
		  </div>
		</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
