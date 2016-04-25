    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/twbs/plugins/slider/css/slider.css" />
    <script src="<?php echo base_url(); ?>assets/frontend/twbs/plugins/slider/js/bootstrap-slider.js"></script>
    <script src="<?php echo base_url(); ?>assets/frontend/twbs/plugins/validator/jquery.numeric.js"></script>
<script>
	$(document).ready(function(){
		addCompany();
		
		$('.job-score').numeric();
		$('.job-scale').numeric();
    
		$('#ex1').slider({
			formater: function(value) {
				return value + ' <?php echo lang("years"); ?>';
			}
		});
		
		$("#select-company").change(function(){
			if($(this).val() == "add") {
			   $('#myModal').modal({
				  remote: '<?php echo base_url()."company/modal_add_company"; ?>'
				});
			}
		});
		$('.editor').wysihtml5();	
		$('.selectpicker').selectpicker();
		checkEksIn();
		$('#is_external').change(function(){
			if($('#is_external').val() == 1){
				$('#website_external').show();
				$('#is_internal').hide();
			} else {
				$('#website_external').hide();
				$('#is_internal').show();
			}
		});
		
		$('#myModal').on('hidden.bs.modal', function() {
			$(this).removeData('bs.modal');
			$("#select-company").val('');
		});
		
		$('#btnAdd').click(function () {
			var num     = $('.clonedInput').length, // Checks to see how many "duplicatable" input fields we currently have
				newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
				newElem = $('#entry' + num).clone().attr('id', 'entry' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value

			// H2 - section
			newElem.find('.heading-reference').attr('id', 'ID' + newNum + '_reference').attr('name', 'ID' + newNum + '_reference').html('<?php echo lang('step'); ?> #' + newNum);

			newElem.find('.step-name').val([1]);
			newElem.find('.step-desc').html();
			
			// Insert the new element after the last "duplicatable" input field
			$('#entry' + num).after(newElem);

			
			// Enable the "remove" button. This only shows once you have a duplicated section.
			$('#btnDel').attr('disabled', false);
			
			// Right now you can only add 9 sections, for a total of 10. Change '10' below to the max number of sections you want to allow.
			if (newNum == 10)
			$('#btnAdd').attr('disabled', true).prop('value', "<?php echo lang('reached_the_limit'); ?>"); // value here updates the text in the 'add' button when the limit is reached 
		});

		$('#btnDel').click(function () {
			// Confirmation dialog box. Works on all desktop browsers and iPhone.
			if (confirm("<?php echo lang('are_you_sure_you_wish_to_remove_this_section?_this_cannot_be_undone.'); ?>"))
				{
					var num = $('.clonedInput').length;
					// how many "duplicatable" input fields we currently have
					$('#entry' + num).slideUp('slow', function () {$(this).remove();
					// if only one element remains, disable the "remove" button
						if (num -1 === 1)
					$('#btnDel').attr('disabled', true);
					// enable the "add" button
					$('#btnAdd').attr('disabled', false).prop('value', "<span class=\"glyphicon glyphicon-plus-sign\"></span> <?php echo lang('add_more'); ?>");});
				}
			return false; // Removes the last section you added
		});
		// Enable the "add" button
		$('#btnAdd').attr('disabled', false);
		// Disable the "remove" button
		$('#btnDel').attr('disabled', true);
		
		
	});

function addCompany(){
	if($("#select-company").val() == "add") {
		$('#myModal').modal({
		  remote: '<?php echo base_url()."company/modal_add_company"; ?>'
		});
	}
};

function checkEksIn(){
	if($('#is_external').val() == 1){
		$('#website_external').show();
		$('#is_internal').hide();
	} else {
		$('#website_external').hide();
		$('#is_internal').show();
	}
}

</script>
<style>

#ex1Slider .slider-selection {
	background: #BABABA;
}

</style>
<div class="container">
      <div class="row row-offcanvas row-offcanvas-right">
	
<form class="form-horizontal" role="form" accept-charset="utf-8" method="post" action="<?php echo $act; ?>">
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		  				  
<div class="panel panel-default">

	  <div class="panel-heading">
        <h4><span class="glyphicon glyphicon-th-large"></span> <?php echo lang('company_info'); ?></h4>
      </div>
      <div class="panel-body">

		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('company_name'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
				<select id="select-company" name="company_id" class="form-control">
					 <?php 
						if($company->num_rows() > 0){
							foreach($company->result_array() as $companies){
								if($job_detail['company_id'] == $companies['company_id']){
									echo "<option value=\"".$companies['company_id']."\" selected>".$companies['company_name']."</option>";
								} else {
									echo "<option value=\"".$companies['company_id']."\">".$companies['company_name']."</option>";
								}
							}
						} else {
							echo "<option value=\"0\">Select Company</option>";
						}
					 ?>
					 <option value="add" ><?php echo lang('add_company'); ?></option>
			  </select>
			  <?php echo form_error('company_id','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		
		
      </div>
</div>

<div class="panel panel-default">
      <div class="panel-heading">
        <h4><span class="glyphicon glyphicon-briefcase"></span> <?php echo lang('job_info'); ?></h4>
      </div>
      <div class="panel-body">
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('job_name'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" name="job_name" class="form-control" placeholder="<?php echo lang('job_name'); ?>" value="<?php echo $job_detail['job_name'] ? $job_detail['job_name'] : ''; ?>">
			  <?php echo form_error('job_name','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('job_description'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <textarea class="form-control editor" rows="3" name="job_desc" placeholder="<?php echo lang('job_description'); ?>"><?php echo $job_detail['job_desc'] ? $job_detail['job_desc'] : ''; ?></textarea>
			  <?php echo form_error('job_desc','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('career_level'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
				<select name="category_id" class="form-control">
					 <?php 
						if($category->num_rows() > 0){
							foreach($category->result_array() as $categories){
								if($job_detail['category_id'] == $categories['category_id']){
									echo "<option value=\"".$categories['category_id']."\" selected>".$categories['category_name']."</option>";
								} else {
									echo "<option value=\"".$categories['category_id']."\">".$categories['category_name']."</option>";
								}
							}
						}
					 ?>
			  </select>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('job_function'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
				<select multiple name="jf_id[]" data-live-search="true" class="form-control selectpicker">
					 <?php 
						if($jobfunction->num_rows() > 0){
							foreach($jobfunction->result_array() as $jobfunctions){
								if($job_function && in_array($jobfunctions['jf_id'],$job_function)){
									echo "<option value=\"".$jobfunctions['jf_id']."\" selected>".($jobfunctions['jf_parent'] > 0 ? "&nbsp;&nbsp;&nbsp;".$jobfunctions['jf_name'] : $jobfunctions['jf_name'])."</option>";
								} else {
									echo "<option value=\"".$jobfunctions['jf_id']."\">".($jobfunctions['jf_parent'] > 0 ? "&nbsp;&nbsp;&nbsp;".$jobfunctions['jf_name'] : $jobfunctions['jf_name'])."</option>";
								}
							}
						}
					 ?>
			  </select>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('job_location'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
				<select name="city_id" class="form-control selectpicker" data-live-search="true">
					 <?php 
						if(count($location) > 0){
							foreach($location as $locations){
								if($job_detail['city_id'] == $locations['city_id']){
									echo "<option value=\"".$locations['city_id']."\" selected>".$locations['city_name']."</option>";
								} else {	
									echo "<option value=\"".$locations['city_id']."\">".$locations['city_name']."</option>";
								}
								if(count($locations['child']) > 0){
									foreach($locations['child'] as $childs_key => $childs_val){
										if($job_detail['city_id'] == $childs_key){
											echo "<option value=\"".$childs_key."\" selected>- ".$childs_val."</option>";
										} else {	
											echo "<option value=\"".$childs_key."\">- ".$childs_val."</option>";
										}
									}
								}
							}
						}
					 ?>
			  </select>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('employment_term'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
				<select name="term_id" class="form-control">
					 <?php 
						if($term->num_rows() > 0){
							foreach($term->result_array() as $terms){
								if($job_detail['term_id'] == $terms['term_id']){
									echo "<option value=\"".$terms['term_id']."\" selected>".$terms['term_name']."</option>";
								} else {	
									echo "<option value=\"".$terms['term_id']."\">".$terms['term_name']."</option>";
								}
							}
						}
					 ?>
			  </select>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('post_date'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" name="job_post_date" class="form-control datepicker" placeholder="<?php echo lang('post_date'); ?>" value="<?php echo $job_detail['job_post_date'] ? $job_detail['job_post_date'] : ''; ?>">
			  <?php echo form_error('job_post_date','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('expire_date'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" name="job_due_date" class="form-control datepicker" placeholder="<?php echo lang('expire_date'); ?>" value="<?php echo $job_detail['job_due_date'] ? $job_detail['job_due_date'] : ''; ?>">
			  <?php echo form_error('job_due_date','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('redirect_to_external_website'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
				<select name="job_is_external" id="is_external" class="form-control">
					 	<option <?php echo $job_detail['job_is_external'] == 0 ? 'selected' : ''; ?> value="0"><?php echo lang('no'); ?></option>
					 	<option <?php echo $job_detail['job_is_external'] == 1 ? 'selected' : ''; ?> value="1"><?php echo lang('yes'); ?></option>		
			  </select>
			</div>
		  </div>
		  
		  <div class="form-group" id="website_external">
			<label class="col-sm-2 control-label"><?php echo lang('website_external'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" name="job_external_url" class="form-control" placeholder="http://www.yourwebsite.com" value="<?php echo $job_detail['job_external_url'] ? $job_detail['job_external_url'] : ''; ?>">
			</div>
		  </div>
		  
      </div>
</div>

<div id="is_internal" class="panel panel-default">
      <div class="panel-heading">
        <h4><span class="glyphicon glyphicon-signal"></span> <?php echo lang('job_step'); ?></h4>
      </div>
      <div class="panel-body">
		  <?php 
			if($job_step && $job_step->num_rows() > 0){
				$i=1;
				foreach($job_step->result_array() as $job_steps){					
		  ?>
		  
		  <div id="entry<?php echo $i; ?>" class="clonedInput">
		  <h2 id="reference" name="reference" class="heading-reference"><?php echo lang('step'); ?> #<?php echo $i; ?><span class="pull-right"><a href="<?php echo base_url().'company/delete_step/'.$job_detail['job_id'].'/'.$job_steps['js_id']; ?>"><span class="glyphicon glyphicon-trash"></span> <?php echo lang('delete'); ?></a></span></h2>  
		  <div class="form-group">
			<label class="col-sm-2 control-label label-step"><?php echo lang('step_name'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
				<select name="step_id[]" class="form-control step-name">
					<?php
					if($step->num_rows() > 0){
						foreach($step->result_array() as $steps){
							if($job_steps['step_id'] == $steps['step_id']){
								echo "<option value=\"".$steps['step_id']."\" selected>".$steps['step_name']."</option>";
							} else {	
								echo "<option value=\"".$steps['step_id']."\">".$steps['step_name']."</option>";
							}
						}
					}
					?>
			    </select>
			</div>
		  </div>
		  
		   <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('description'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <textarea class="form-control step-desc" rows="3" name="js_desc[]" placeholder="<?php echo lang('description'); ?>"><?php echo $job_steps['js_desc'] ? $job_steps['js_desc'] : ''; ?></textarea>
			</div>
		  </div>
		  
		  </div>
		  <?php 
				$i++;
				}
			} else {
		  ?>
		  <div id="entry1" class="clonedInput">
		  <h2 id="reference" name="reference" class="heading-reference"><?php echo lang('step'); ?> #1</h2>  
		  <div class="form-group">
			<label class="col-sm-2 control-label label-step"><?php echo lang('step_name'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
				<select name="step_id[]" class="form-control step-name">
					<?php
					if($step->num_rows() > 0){
						foreach($step->result_array() as $steps){
							echo "<option value=\"".$steps['step_id']."\">".$steps['step_name']."</option>";
						}
					}
					?>
			    </select>
			</div>
		  </div>
		  
		   <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('description'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <textarea class="form-control step-desc" rows="3" name="js_desc[]" placeholder="<?php echo lang('description'); ?>"></textarea>
			</div>
		  </div>
		  
		  </div>
      <?php
			}
		  ?>
      </div>
      
      <div class="panel-footer">
      <button type="button" id="btnAdd" name="btnAdd" class="btn btn-info"><span class="glyphicon glyphicon-plus-sign"></span> <?php echo lang('add_more'); ?></button>
	  <button type="button" id="btnDel" name="btnDel" class="btn btn-danger"><span class="glyphicon glyphicon-minus-sign"></span> <?php echo lang('remove_this'); ?></button>
      </div>
      
</div>

<div class="panel panel-default">
      <div class="panel-heading">
        <h4><span class="glyphicon glyphicon-filter"></span> <?php echo lang('candidate_requirements'); ?></h4>
      </div>
      <div class="panel-body">
      
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('education_level'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
				<select name="grade_id" class="form-control">
					 <?php 
						if($grade->num_rows() > 0){
							foreach($grade->result_array() as $grades){
								if($job_detail['grade_id'] == $grades['grade_id']){
									echo "<option value=\"".$grades['grade_id']."\" selected>".$grades['grade_name']."</option>";
								} else {	
									echo "<option value=\"".$grades['grade_id']."\">".$grades['grade_name']."</option>";
								}
							}
						}
					 ?>
			  </select>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('education_major'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
				<select multiple name="major_id[]" class="form-control selectpicker">
					 <?php 
						if($major->num_rows() > 0){
							foreach($major->result_array() as $majors){
								if($job_major && in_array($majors['major_id'],$job_major)){
									echo "<option value=\"".$majors['major_id']."\" selected>".$majors['major_name']."</option>";
								} else {
									echo "<option value=\"".$majors['major_id']."\">".$majors['major_name']."</option>";
								}
							}
						}
					 ?>
			  </select>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('years_of_experience'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
				<select name="job_years_exp" class="form-control">
					 <option value="0" <?php echo $job_detail['job_years_exp'] == 0 ? 'selected' : ''; ?>>0</option>
					 <option value="1" <?php echo $job_detail['job_years_exp'] == 1 ? 'selected' : ''; ?>>1</option>
					 <option value="2" <?php echo $job_detail['job_years_exp'] == 2 ? 'selected' : ''; ?>>2</option>
					 <option value="3" <?php echo $job_detail['job_years_exp'] == 3 ? 'selected' : ''; ?>>3</option>
					 <option value="4" <?php echo $job_detail['job_years_exp'] == 4 ? 'selected' : ''; ?>>4</option>
					 <option value="5" <?php echo $job_detail['job_years_exp'] == 5 ? 'selected' : ''; ?>>5</option>
					 <option value="6" <?php echo $job_detail['job_years_exp'] == 6 ? 'selected' : ''; ?>>6</option>
					 <option value="7" <?php echo $job_detail['job_years_exp'] == 7 ? 'selected' : ''; ?>>7</option>
					 <option value="8" <?php echo $job_detail['job_years_exp'] == 8 ? 'selected' : ''; ?>>8</option>
					 <option value="9" <?php echo $job_detail['job_years_exp'] == 9 ? 'selected' : ''; ?>>9</option>
					 <option value="10" <?php echo $job_detail['job_years_exp'] == 10 ? 'selected' : ''; ?>>10</option>
					 <option value="11" <?php echo $job_detail['job_years_exp'] == 11 ? 'selected' : ''; ?>>11</option>
					 <option value="12" <?php echo $job_detail['job_years_exp'] == 12 ? 'selected' : ''; ?>>12</option>
					 <option value="13" <?php echo $job_detail['job_years_exp'] == 13 ? 'selected' : ''; ?>>13</option>
					 <option value="14" <?php echo $job_detail['job_years_exp'] == 14 ? 'selected' : ''; ?>>14</option>
					 <option value="15" <?php echo $job_detail['job_years_exp'] == 15 ? 'selected' : ''; ?>>15</option>
					 <option value="16" <?php echo $job_detail['job_years_exp'] == 16 ? 'selected' : ''; ?>>16</option>
					 <option value="17" <?php echo $job_detail['job_years_exp'] == 17 ? 'selected' : ''; ?>>17</option>
					 <option value="18" <?php echo $job_detail['job_years_exp'] == 18 ? 'selected' : ''; ?>>18</option>
					 <option value="19" <?php echo $job_detail['job_years_exp'] == 19 ? 'selected' : ''; ?>>19</option>
					 <option value="20" <?php echo $job_detail['job_years_exp'] == 20 ? 'selected' : ''; ?>>20</option>
			  </select>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('ages'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input name="job_age" id="ex1" data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="50" data-slider-step="1" data-slider-value="<?php echo !empty($job_detail['job_age']) ? $job_detail['job_age'] : 0; ?>" value="<?php echo !empty($job_detail['job_age']) ? $job_detail['job_age'] : 0; ?>"/>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('grade'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			<div class="input-group">
			  <input type="text" id="job-score" name="job_score" class="form-control job-score" placeholder="<?php echo lang('gpa'); ?>" value="<?php echo !empty($job_detail['job_score']) ? $job_detail['job_score'] : ''; ?>">
			  <span class="input-group-addon">/</span>
			  <input type="text" id="job-scale" name="job_scale" class="form-control job-scale" placeholder="<?php echo lang('scale'); ?>" value="<?php echo !empty($job_detail['job_scale']) ? $job_detail['job_scale'] : ''; ?>">
			</div>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('gender'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
				<select name="job_gender" class="form-control">
					 <option value="" <?php echo empty($job_detail['job_gender']) ? 'selected' : ''; ?>>N/A</option>
					 <option value="Male" <?php echo $job_detail['job_gender'] == 'Male' ? 'selected' : ''; ?>><?php echo lang('male'); ?></option>
					 <option value="Female" <?php echo $job_detail['job_gender'] == 'Female' ? 'selected' : ''; ?>><?php echo lang('female'); ?></option>
			  </select>
			</div>
		  </div>
		  
      </div>
</div>
      
<div class="panel panel-default">
      <div class="panel-body">
		  
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <button type="submit" class="btn btn-danger"><?php echo lang('next'); ?></button>
			  <a href="<?php echo base_url().'company/jobs'; ?>" class="btn btn-warning"><?php echo lang('cancel'); ?></a>
			</div>
		  </div>
		  
      </div>
</div>
	</form>
  

	</div>
</div><!-- /.container -->

<!-- Modal -->
<div class="modal fade" id="ModalStep" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Dialog</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
