<!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>assets/frontend/twbs/css/bootstrap.css" rel="stylesheet">

<!-- Modal -->
<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-th-large"></span> Info</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form">
		  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		  <?php
			   $info = $this->session->flashdata('success');
               if (!empty($info)) {
					echo "<div class=\"alert alert-success\">" . $info . "</div>";
               } 
          ?>
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <a href="<?php echo base_url(); ?>" class="btn btn-info"><?php echo lang('home'); ?></a>
			</div>
		  </div>
		</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
