<!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>assets/frontend/twbs/css/bootstrap.css" rel="stylesheet">
    <script>
	$(document).ready(function(){
		
		$('#forgot-password').click(function(e){
			$('#myModal').modal('hide');
			$('#myModal').removeData('bs.modal');
			$('#myModal').modal({
				remote: '<?php echo base_url(); ?>person/forgot'
			});
		});
	
	});
	</script>
<!-- Modal -->
            <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user"></span> <?php echo lang('job_seeker'); ?> <?php echo lang('login'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" id="jobseeker-login-form" accept-charset="utf-8" method="post" action="<?php echo $act; ?>">
		  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		  <div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
			<div class="col-sm-10">
			  <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email">
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputPassword3" class="col-sm-2 control-label">Password</label>
			<div class="col-sm-10">
			  <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password">
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
			  <a id="forgot-password" class="btn btn-warning"><?php echo lang('forgot_password'); ?></a>
			</div>
		  </div>
		</form>
      </div>
