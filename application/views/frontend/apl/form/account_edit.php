<script>
	$(document).ready(function(){
		$('textarea').wysihtml5();
	});
</script>
<div class="container">
      <div class="row row-offcanvas row-offcanvas-right">
		  
<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user"></span> Edit <?php echo lang('information'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" accept-charset="utf-8" method="post" action="<?php echo $act; ?>">
		  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		  <div class="form-group">
			<label for="inputName3" class="col-sm-2 control-label"><?php echo lang('full_name'); ?></label>
			<div class="col-sm-10">
			  <input type="text" name="name" class="form-control" id="inputName3" placeholder="<?php echo lang('full_name'); ?>" value="<?php echo $person['name']; ?>">
			  <?php echo form_error('name','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
			<div class="col-sm-10">
			  <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email" value="<?php echo $person['email']; ?>">
			  <?php echo form_error('email','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="inputPhone3" class="col-sm-2 control-label"><?php echo lang('phone'); ?></label>
			<div class="col-sm-10">
			  <input type="text" name="phone" class="form-control" id="inputPhone3" placeholder="<?php echo lang('phone'); ?>" value="<?php echo $person['phone']; ?>">
			  <?php echo form_error('phone','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="inputAddress3" class="col-sm-2 control-label"><?php echo lang('address'); ?></label>
			<div class="col-sm-10">
			  <textarea class="form-control" rows="3" name="address" placeholder="<?php echo lang('address'); ?>"><?php echo $person['address']; ?></textarea>
			  <?php echo form_error('address','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <button type="submit" class="btn btn-danger"><?php echo lang('update'); ?></button>
			  <a href="<?php echo base_url().'person/account/'; ?>" class="btn btn-warning"><?php echo lang('cancel'); ?></a>
			</div>
		  </div>
		</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
  
</div>
        

</div><!-- /.container -->
