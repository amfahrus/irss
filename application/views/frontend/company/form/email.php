<script>
	$(document).ready(function(){
		$('.editor').wysihtml5();
	});
</script>
<div class="container">
      <div class="row row-offcanvas row-offcanvas-right">

<div class="modal-dialog">
	<div class="modal-content">
            <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-th-large"></span> <?php echo lang('send_email'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="send_email" role="form" enctype="multipart/form-data" accept-charset="utf-8" method="post" action="<?php echo $act; ?>">
		  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		  <div id="jvalid"></div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label">To</label>
			<div class="col-sm-10">
			  <input type="text" name="to" class="form-control" id="to" placeholder="Email Address">
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label">CC Email</label>
			<div class="col-sm-10">
			  <input type="text" name="cc" class="form-control" id="cc" placeholder="CC Email">
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('subject'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" name="subject" class="form-control" id="subject" placeholder="<?php echo lang('subject'); ?> Email">
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('messages'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <textarea class="form-control editor" rows="3" name="message" id="message" placeholder="<?php echo lang('messages'); ?> Email"></textarea>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('attach'); ?></label>
			<div class="col-sm-10">
			  <input type="file" name="attach" id="attach">
			  <div class="help-block"><?php echo lang('max_3mb_with_only_zip_extension'); ?></div>
			</div>
		  </div>
		  
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <button type="submit" class="btn btn-primary"><?php echo lang('send'); ?></button>
			  <button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true"><?php echo lang('cancel'); ?></button>
			</div>
		  </div>
		</form>
      </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
