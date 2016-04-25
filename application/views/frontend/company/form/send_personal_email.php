<div class="modal-content">
            <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-th-large"></span> Send Email <?php echo isset($person) ? $person['name'] : ''; ?></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="send_personal_email" role="form" enctype="multipart/form-data" accept-charset="utf-8" method="post" action="<?php echo $act; ?>">
		  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		  <div id="jvalid"></div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label">Subject <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" name="subject" class="form-control" id="subject" placeholder="Subject Email">
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label">Messages <span class="important">*</span></label>
			<div class="col-sm-10">
			  <textarea class="form-control" rows="3" name="message" id="message" placeholder="Messages Email"></textarea>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label">Attach</label>
			<div class="col-sm-10">
			  <input type="file" name="attach">
			  <div class="help-block">Max 3Mb with only zip extension</div>
			</div>
		  </div>
		  
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <button type="submit" class="btn btn-primary">Send</button>
			  <button type="button" class="btn btn-warning" data-dismiss="modal" aria-hidden="true">Cancel</button>
			</div>
		  </div>
		</form>
      </div>
</div><!-- /.modal-content -->
<script src="<?php echo base_url(); ?>assets/frontend/twbs/plugins/ajaxfileupload/jquery.form.js"></script>

<script>
$(document).ready(function() {
		 $("#send_personal_email").ajaxForm({
					complete: function(response) { // on complete
						alert('Success Send Email');
					$('#myModal').modal('hide');
					}
			});
		
		});
</script>
  
