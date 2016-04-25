<!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>assets/frontend/twbs/css/bootstrap.css" rel="stylesheet">
<!-- Modal -->
        <div class="modal-content">
            <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user"></span> <?php echo lang('job_seeker'); ?> <?php echo lang('forgot_password'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" accept-charset="utf-8" method="post" action="<?php echo $act; ?>">
		  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		  <div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
			<div class="col-sm-10">
			  <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email">
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <button type="submit" class="btn btn-danger">Reset Password</button>
			</div>
		  </div>
		</form>
      </div>
    </div><!-- /.modal-content -->
