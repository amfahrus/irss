<script>
	$(document).ready(function(){
		$('.selectpicker').selectpicker();
		checkAlert();
		$('#is_alert').change(function(){
			if($('#is_alert').val() == 1){
				$('#job_alert').show();
				$('#alert_time').show();
			} else {
				$('#job_alert').hide();
				$('#alert_time').hide();
			}
		});
	});
	function checkAlert(){
		if($('#is_alert').val() == 1){
			$('#job_alert').show();
			$('#alert_time').show();
		} else {
			$('#job_alert').hide();
			$('#alert_time').hide();
		}
	}
</script>
<div class="container">
      <div class="row row-offcanvas row-offcanvas-right">
		  
<div class="panel panel-default">
	  <div class="panel-heading">
        <h4><span class="glyphicon glyphicon-user"></span> <?php echo lang('job_alert'); ?></h4>
      </div>
      <div class="panel-body">
		  
        <form class="form-horizontal" role="form" accept-charset="utf-8" method="post" action="<?php echo $act; ?>">
		  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('subscribe'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
				<select name="is_job_alert" id="is_alert" class="form-control selectpicker">
					 	<option <?php echo $person['is_job_alert'] == 0 ? 'selected' : ''; ?> value="0"><?php echo lang('no'); ?></option>
					 	<option <?php echo $person['is_job_alert'] == 1 ? 'selected' : ''; ?> value="1"><?php echo lang('yes'); ?></option>		
			  </select>
			</div>
		  </div>
		  
		  <div id="job_alert" class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('criteria'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
				<select multiple name="jf_id[]" data-live-search="true" class="form-control selectpicker">
					 <?php 
						if($job_function->num_rows() > 0){
							foreach($job_function->result_array() as $job_functions){
								if(count($job_alert) > 0 && in_array($job_functions['jf_id'],$job_alert)){
									echo "<option value=\"".$job_functions['jf_id']."\" selected>".($job_functions['jf_parent'] > 1 ? "&nbsp;&nbsp;&nbsp;".$job_functions['jf_name'] : $job_functions['jf_name'])."</option>";
								} else {
									echo "<option value=\"".$job_functions['jf_id']."\">".($job_functions['jf_parent'] > 1 ? "&nbsp;&nbsp;&nbsp;".$job_functions['jf_name'] : $job_functions['jf_name'])."</option>";
								}
							}
						}
					 ?>
			  </select>
			</div>
		  </div>
		  
		  <div id="alert_time"  class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('frequency'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
				<select name="job_alert_time" class="form-control selectpicker">
					 	<option <?php echo $person['job_alert_time'] == 'Daily' ? 'selected' : ''; ?> value="Daily"><?php echo lang('daily'); ?></option>
					 	<option <?php echo $person['job_alert_time'] == 'Weekly' ? 'selected' : ''; ?> value="Weekly"><?php echo lang('weekly'); ?></option>		
					 	<option <?php echo $person['job_alert_time'] == 'Monthly' ? 'selected' : ''; ?> value="Monthly"><?php echo lang('monthly'); ?></option>		
			  </select>
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
  
</div>
        

</div><!-- /.container -->
