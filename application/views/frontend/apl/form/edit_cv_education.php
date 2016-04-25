<script src="<?php echo base_url(); ?>assets/frontend/twbs/plugins/validator/jquery.numeric.js"></script>
<script src="<?php echo base_url(); ?>assets/frontend/twbs/plugins/validator/masked.js"></script>
<script>
$(function () {
	var cstate = <?php echo $education->num_rows() > 0 ? $education->num_rows() : 1 ; ?>;
    $('.edu-gpa').numeric();
    $('.edu-gpa-scale').numeric();
    $('.edu-years').mask('9999');
	for (var i=1;i<$('.clonedInput').length;i++)
	{
		checkNow(i);
	}
    $('#btnAdd').click(function () {
        var num     = $('.clonedInput').length, // Checks to see how many "duplicatable" input fields we currently have
            newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
            newElem = $('#entry' + num).clone().attr('id', 'entry' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value

        // H2 - section
        newElem.find('.heading-reference').attr('id', 'ID' + newNum + '_reference').attr('name', 'ID' + newNum + '_reference').html('Entry #' + newNum);
		newElem.find('.edustatus').attr('id', 'graduate' + newNum).attr('onchange', 'checkNow('+newNum+');');
        newElem.find('.gradecheck').attr('id', 'gradecheck' + newNum);
        newElem.find('.yearcheck').attr('id', 'yearcheck' + newNum);
        
        newElem.find('.edu-name').val('');
        newElem.find('.edu-years').val('');
        newElem.find('.edu-place').val('');
        newElem.find('.edu-grade').val([1]);
        newElem.find('.edu-major').val([1]);
        newElem.find('.edu-status').val([1]);
        newElem.find('.edu-gpa').val('');
        newElem.find('.edu-gpa-scale').val('');
        
        newElem.find('.edu-gpa').numeric();
		newElem.find('.edu-gpa-scale').numeric();
		newElem.find('.edu-years').mask('9999');

    // Insert the new element after the last "duplicatable" input field
        $('#entry' + num).after(newElem);
        $('#ID' + newNum + '_reference').focus();

    // Enable the "remove" button. This only shows once you have a duplicated section.
        $('#btnDel').attr('disabled', false);
	
	// Form validation	
		$('form').on('submit', function() {
		// do validation here
		if($('.clonedInput').length > cstate){
			if(
			!newElem.find('.edu-name').val()
			|| !newElem.find('.edu-place').val()
			){
				$('#jvalid').attr('class','alert alert-danger').html('<?php echo lang('jvalid'); ?>');
				return false;
			} 
		}
		});
		
    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
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
function checkNow(id){
	if($('#graduate'+id).val() == 1){
		$('#gradecheck'+id).show();
		$('#yearcheck'+id).show();
	} else {
		$('#gradecheck'+id).hide();
		$('#yearcheck'+id).hide();
	}
}
</script>
<div class="container">
      <div class="row row-offcanvas row-offcanvas-right">
		  
<div class="panel panel-default">
	  <div class="panel-heading">
        <h4><span class="glyphicon glyphicon-user"></span> Edit <?php echo lang('education'); ?></h4>
      </div>
      <div class="panel-body">
        <form class="form-horizontal" role="form" accept-charset="utf-8" method="post" action="<?php echo $act; ?>">
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		  
		<?php
			if($education->num_rows() > 0){
				$i=1;
				foreach($education->result_array() as $educations){
		?>
		 <div id="entry<?php echo $i; ?>" class="clonedInput">
		  <h2 id="reference" name="reference" class="heading-reference">Entry #<?php echo $i; ?> <span class="pull-right"><a href="<?php echo base_url().'person/deleteEducation/'.$educations['edu_id']; ?>"><span class="glyphicon glyphicon-trash"></span> <?php echo lang('delete'); ?></a></span></h2> 
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('university'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" id="edu-name" name="edu_name[]" class="form-control edu-name" placeholder="<?php echo lang('university'); ?>" value="<?php echo $educations['edu_name']; ?>">
			  <?php echo form_error('edu_name[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('city'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" id="edu-place" name="edu_place[]" class="form-control edu-place" placeholder="<?php echo lang('city'); ?>" value="<?php echo $educations['edu_place']; ?>">
			  <?php echo form_error('edu_place[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('grade_name'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <select name="grade_id[]" class="form-control edu-grade">
				<?php 
					if($grade->num_rows() > 0){
						foreach($grade->result_array() as $grades){
				?>
					 <option value="<?php echo $grades['grade_id']; ?>" <?php echo $grades['grade_id'] == $educations['grade_id'] ? 'selected' : ''; ?>><?php echo $grades['grade_name']; ?></option>
				<?php 
						}
					}
				?>
			  </select>
			  <?php echo form_error('grade_id[]','<div class="alert alert-danger">', '</div>'); ?>	
			  </div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('field_of_study'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <select name="major_id[]" class="form-control edu-major">
				<?php 
					if($major->num_rows() > 0){
						foreach($major->result_array() as $majors){
				?>
					 <option value="<?php echo $majors['major_id']; ?>" <?php echo $majors['major_id'] == $educations['major_id'] ? 'selected' : ''; ?>><?php echo $majors['major_name']; ?></option>
				<?php 
						}
					}
				?>
			  </select>
			  <?php echo form_error('major_id[]','<div class="alert alert-danger">', '</div>'); ?>	
			  </div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('graduate'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
				<select name="edu_status[]" id="graduate<?php echo $i; ?>" onchange="checkNow(<?php echo $i; ?>);" class="form-control exp-untilnow edustatus">
					 	<option <?php echo $educations['edu_status'] == 1 ? 'selected' : ''; ?> value="1"><?php echo lang('yes'); ?></option>	
					 	<option <?php echo $educations['edu_status'] == 0 ? 'selected' : ''; ?> value="0"><?php echo lang('no'); ?></option>	
			  </select>
			</div>
		  </div>
		  
		  <div id="gradecheck<?php echo $i; ?>" class="form-group gradecheck">
			<label class="col-sm-2 control-label"><?php echo lang('grade'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			<div class="input-group">
			  <input type="text" id="edu-gpa" name="edu_gpa[]" class="form-control edu-gpa" placeholder="Grade" value="<?php echo $educations['edu_gpa']; ?>">
			  <?php echo form_error('edu_gpa[]','<div class="alert alert-danger">', '</div>'); ?>
			  <span class="input-group-addon">/</span>
			  <input type="text" id="edu-gpa-scale" name="edu_gpa_scale[]" class="form-control edu-gpa-scale" placeholder="Scale" value="<?php echo $educations['edu_gpa_scale']; ?>">
			  <?php echo form_error('edu_scale[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
			</div>
		  </div>
		  
		  <div id="yearcheck<?php echo $i; ?>" class="form-group yearcheck">
			<label class="col-sm-2 control-label"><?php echo lang('graduation_year'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" id="edu-years" name="edu_years[]" class="form-control edu-years" placeholder="<?php echo lang('graduation_year'); ?>" value="<?php echo $educations['edu_years']; ?>">
			  <?php echo form_error('edu_years[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  </div>
		  
		  <?php 
				$i++;
				}
			} else {
		  ?>
		  <div id="entry1" class="clonedInput">
		  <h2 id="reference" name="reference" class="heading-reference">Entry #1</h2>
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('university'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" id="edu-name" name="edu_name[]" class="form-control edu-name" placeholder="<?php echo lang('university'); ?>" value="">
			  <?php echo form_error('edu_name[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('city'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" id="edu-place" name="edu_place[]" class="form-control edu-place" placeholder="<?php echo lang('city'); ?>" value="">
			  <?php echo form_error('edu_place[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('grade_name'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <select name="grade_id[]" class="form-control edu-grade">
				<?php 
					if($grade->num_rows() > 0){
						foreach($grade->result_array() as $grades){
				?>
					 <option value="<?php echo $grades['grade_id']; ?>"><?php echo $grades['grade_name']; ?></option>
				<?php 
						}
					}
				?>
			  </select>	
			  <?php echo form_error('grade_id[]','<div class="alert alert-danger">', '</div>'); ?>
			  </div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('field_of_study'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <select name="major_id[]" class="form-control edu-major">
				<?php 
					if($major->num_rows() > 0){
						foreach($major->result_array() as $majors){
				?>
					 <option value="<?php echo $majors['major_id']; ?>"><?php echo $majors['major_name']; ?></option>
				<?php 
						}
					}
				?>
			  </select>	
			  <?php echo form_error('major_id[]','<div class="alert alert-danger">', '</div>'); ?>
			  </div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('graduate'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
				<select name="edu_status[]" id="graduate1" onchange="checkNow(1);" class="form-control exp-untilnow edustatus">
					 	<option value="1"><?php echo lang('yes'); ?></option>
					 	<option value="0"><?php echo lang('no'); ?></option>		
			  </select>
			</div>
		  </div>
		  
		  <div id="gradecheck1" class="form-group gradecheck">
			<label class="col-sm-2 control-label"><?php echo lang('grade'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			<div class="input-group">
			  <input type="text" id="edu-gpa" name="edu_gpa[]" class="form-control edu-gpa" placeholder="Grade" value="">
			  
			<?php echo form_error('edu_gpa[]','<div class="alert alert-danger">', '</div>'); ?>
			  <span class="input-group-addon">/</span>
			  <input type="text" id="edu-gpa-scale" name="edu_gpa_scale[]" class="form-control edu-gpa-scale" placeholder="Scale" value="">
				
			<?php echo form_error('edu_gpa_scale[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
			</div>
		  </div>
		  
		  <div id="yearcheck1" class="form-group yearcheck">
			<label class="col-sm-2 control-label"><?php echo lang('graduation_year'); ?></label>
			<div class="col-sm-10">
			  <input type="text" id="edu-years" name="edu_years[]" class="form-control edu-years" placeholder="<?php echo lang('graduation_year'); ?>" value="">
			  <?php echo form_error('edu_years[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  </div>
		  
		  <?php
			}
		  ?>
		<div id="jvalid"></div> 
		<p>
			<button type="button" id="btnAdd" name="btnAdd" class="btn btn-info"><span class="glyphicon glyphicon-plus-sign"></span> <?php echo lang('add_more'); ?></button>
			<button type="button" id="btnDel" name="btnDel" class="btn btn-danger"><span class="glyphicon glyphicon-minus-sign"></span> <?php echo lang('remove_this'); ?></button>
        </p>
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <button type="submit" class="btn btn-danger"><?php echo lang('update'); ?></button>
			  <a href="<?php echo base_url().'person/cv/'; ?>" class="btn btn-warning"><?php echo lang('cancel'); ?></a>
			</div>
		  </div>
		</form>
      </div>
  </div>
  
</div>
        

</div><!-- /.container -->
