<!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>assets/frontend/twbs/css/bootstrap.css" rel="stylesheet">

<!-- Modal -->
<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-th-large"></span> <?php echo lang('company'); ?> <?php echo lang('login'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" id="jobseeker-login-form" accept-charset="utf-8" method="post" action="<?php echo $act; ?>">
		  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		  <?php
			   $info = $this->session->flashdata('info');
               if (!empty($info)) {
					echo "<div class=\"alert alert-danger\">" . $info . "</div>";
               } 
          ?>
		  <div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label">Username / Email</label>
			<div class="col-sm-10">
			  <input type="text" name="company_account_email" class="form-control" id="inputEmail3" placeholder="Username/Email">
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
			<div class="col-sm-offset-2 col-sm-10">
			  <div class="checkbox">
				<label>
				  <input name="remember_me" type="checkbox"> <?php echo lang('remember_me'); ?>
				</label>
			  </div>
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <input type="submit" class="btn btn-primary" value="<?php echo lang('login'); ?>" />
			  <a href="<?php echo base_url().'company/forgot'; ?>" class="btn btn-warning"><?php echo lang('forgot_password'); ?></a>
			  <a href="<?php echo base_url(); ?>" class="btn btn-info"><?php echo lang('home'); ?></a>
			</div>
		  </div>
		</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
