<script src="<?php echo base_url(); ?>assets/frontend/twbs/plugins/validator/jquery.numeric.js"></script>
<script>
$(function () {
	$('.numeric').numeric();
	var cstate = <?php echo $experience->num_rows() > 0 ? $experience->num_rows() : 1 ; ?>;
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
        newElem.find('.untilnow').attr('id', 'untilnow' + newNum).attr('onchange', 'checkNow('+newNum+');');
        newElem.find('.outdate').attr('id', 'outdate' + newNum);

        newElem.find('.exp-company').val('');
        newElem.find('.exp-major').val('');
        newElem.find('.exp-address').html('');
        newElem.find('.exp-position').val('');
        newElem.find('.exp-sallary').val('');
        newElem.find('.exp-jobdesc').html('');
        newElem.find('.exp-joindate').val('');
        newElem.find('.exp-outdate').val('');
        newElem.find('.exp-untilnow').val(0);
    // Insert the new element after the last "duplicatable" input field
        $('#entry' + num).after(newElem);
        $('#ID' + newNum + '_reference').focus();
		
		$('#outdate'+newNum).show();
    // Enable the "remove" button. This only shows once you have a duplicated section.
        $('#btnDel').attr('disabled', false);
        
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			todayHighlight: true
		})
		
	// Form validation	
		$('form').on('submit', function() {
		// do validation here
			if($('.clonedInput').length > cstate){
				if(!newElem.find('.exp-company').val()
					|| !newElem.find('.exp-major').val()
					|| !newElem.find('.exp-address').val()
					|| !newElem.find('.exp-position').val()
					|| !newElem.find('.exp-sallary').val()
					|| !newElem.find('.exp-jobdesc').val()
					|| !newElem.find('.exp-joindate').val()
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
	if($('#untilnow'+id).val() == 1){
		$('#outdate'+id).hide();
	} else {
		$('#outdate'+id).show();
	}
}
</script>
<div class="container">
      <div class="row row-offcanvas row-offcanvas-right">
		  
<div class="panel panel-default">
	  <div class="panel-heading">
        <h4><span class="glyphicon glyphicon-user"></span> Edit <?php echo lang('experience'); ?></h4>
      </div>
      <div class="panel-body">
        <form class="form-horizontal" role="form" accept-charset="utf-8" method="post" action="<?php echo $act; ?>">
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		  
		<?php
			if($experience->num_rows() > 0){
				$i=1;
				foreach($experience->result_array() as $experiences){
		?>
		 <div id="entry<?php echo $i; ?>" class="clonedInput">
		  <h2 id="reference" name="reference" class="heading-reference">Entry #<?php echo $i; ?> <span class="pull-right"><a href="<?php echo base_url().'person/deleteExperience/'.$experiences['exp_id']; ?>"><span class="glyphicon glyphicon-trash"></span> <?php echo lang('delete'); ?></a></span></h2> 
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('company_name'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" id="exp-company" name="exp_company[]" class="form-control exp-company" placeholder="<?php echo lang('company_name'); ?>" value="<?php echo $experiences['exp_company']; ?>">
			  <?php echo form_error('exp_company[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('company_major'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" id="exp-major" name="exp_major[]" class="form-control exp-major" placeholder="<?php echo lang('company_major'); ?>" value="<?php echo $experiences['exp_major']; ?>">
			  <?php echo form_error('exp_major[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('company_address'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <textarea class="form-control exp-address" rows="3" name="exp_address[]" placeholder="<?php echo lang('company_address'); ?>"><?php echo $experiences['exp_address']; ?></textarea>
			  <?php echo form_error('exp_address[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('last_position'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" id="exp-position" name="exp_position[]" class="form-control exp-position" placeholder="<?php echo lang('last_position'); ?>" value="<?php echo $experiences['exp_position']; ?>">
			  <?php echo form_error('exp_position[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('job_description'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <textarea class="form-control exp-jobdesc" rows="3" name="exp_jobdesc[]" placeholder="<?php echo lang('job_description'); ?>"><?php echo $experiences['exp_jobdesc']; ?></textarea>
			  <?php echo form_error('exp_jobdesc[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('last_sallary'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" id="exp-sallary" name="exp_sallary[]" class="numeric form-control exp-sallary" placeholder="<?php echo lang('last_sallary'); ?>" value="<?php echo $experiences['exp_sallary']; ?>">
			  <?php echo form_error('exp_sallary[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('join_date'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" id="exp-joindate" name="exp_joindate[]" class="datepicker form-control exp-joindate" placeholder="<?php echo lang('join_date'); ?>" value="<?php echo $experiences['exp_joindate']; ?>">
			  <?php echo form_error('exp_joindate[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('still_work'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
				<select name="exp_untilnow[]" id="untilnow<?php echo $i; ?>" onchange="checkNow(<?php echo $i; ?>);" class="form-control exp-untilnow untilnow">
					 	<option <?php echo $experiences['exp_untilnow'] == 0 ? 'selected' : ''; ?> value="0"><?php echo lang('no'); ?></option>
					 	<option <?php echo $experiences['exp_untilnow'] == 1 ? 'selected' : ''; ?> value="1"><?php echo lang('yes'); ?></option>		
			  </select>
			</div>
		  </div>
		  <div id="outdate<?php echo $i; ?>" class="form-group outdate">
			<label class="col-sm-2 control-label"><?php echo lang('out_date'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" id="exp-out-date" name="exp_outdate[]" class="datepicker form-control exp-outdate" placeholder="<?php echo lang('out_date'); ?>" value="<?php echo $experiences['exp_outdate']; ?>">
			  <?php echo form_error('exp_outdate[]','<div class="alert alert-danger">', '</div>'); ?>
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
			<label class="col-sm-2 control-label"><?php echo lang('company_name'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" id="exp-company" name="exp_company[]" class="form-control exp-company" placeholder="<?php echo lang('company_name'); ?>" value="">
			  <?php echo form_error('exp_company[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('company_major'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" id="exp-major" name="exp_major[]" class="form-control exp-major" placeholder="<?php echo lang('company_major'); ?>" value="">
			  <?php echo form_error('exp_major[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('company_address'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <textarea class="form-control exp-address" rows="3" name="exp_address[]" placeholder="<?php echo lang('company_address'); ?>"></textarea>
			  <?php echo form_error('exp_address[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('last_position'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" id="exp-position" name="exp_position[]" class="form-control exp-position" placeholder="<?php echo lang('last_position'); ?>" value="">
			  <?php echo form_error('exp_position[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('job_description'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <textarea class="form-control exp-jobdesc" rows="3" name="exp_jobdesc[]" placeholder="<?php echo lang('job_description'); ?>"></textarea>
			  <?php echo form_error('exp_jobdesc[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('last_sallary'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" id="exp-sallary" name="exp_sallary[]" class="numeric form-control exp-sallary" placeholder="<?php echo lang('last_sallary'); ?>" value="">
			  <?php echo form_error('exp_sallary[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('join_date'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" id="exp-joindate" name="exp_joindate[]" class="datepicker form-control exp-joindate" placeholder="<?php echo lang('join_date'); ?>" value="">
			  <?php echo form_error('exp_joindate[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('still_work'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
				<select name="exp_untilnow[]" id="untilnow1" onchange="checkNow(1);" class="form-control exp-untilnow untilnow">
					 	<option value="0"><?php echo lang('no'); ?></option>
					 	<option value="1"><?php echo lang('yes'); ?></option>		
			  </select>
			</div>
		  </div>
		  
		  <div id="outdate1" class="form-group outdate">
			<label class="col-sm-2 control-label"><?php echo lang('out_date'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" id="exp-out-date" name="exp_outdate[]" class="datepicker form-control exp-outdate" placeholder="<?php echo lang('out_date'); ?>" value="">
			  <?php echo form_error('exp_outdate[]','<div class="alert alert-danger">', '</div>'); ?>
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
