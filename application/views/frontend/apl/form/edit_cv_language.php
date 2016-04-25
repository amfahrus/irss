<script src="<?php echo base_url(); ?>assets/frontend/twbs/plugins/validator/jquery.numeric.js"></script>
<script>
$(function () {
	$('.numeric').numeric();
	var cstate = <?php echo $language->num_rows() > 0 ? $language->num_rows() : 1 ; ?>;
    $('#btnAdd').click(function () {
        var num     = $('.clonedInput').length, // Checks to see how many "duplicatable" input fields we currently have
            newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
            newElem = $('#entry' + num).clone().attr('id', 'entry' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value

        // H2 - section
        newElem.find('.heading-reference').attr('id', 'ID' + newNum + '_reference').attr('name', 'ID' + newNum + '_reference').html('Entry #' + newNum);

        newElem.find('.lang-name').val('');
        newElem.find('.lang-score').val('');
        newElem.find('.lang-talking').val([1]);
        newElem.find('.lang-writing').val([1]);

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
			!newElem.find('.lang-name').val()
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
</script>
<div class="container">
      <div class="row row-offcanvas row-offcanvas-right">
		  
<div class="panel panel-default">
	  <div class="panel-heading">
        <h4><span class="glyphicon glyphicon-user"></span> Edit <?php echo lang('language'); ?></h4>
      </div>
      <div class="panel-body">
        <form class="form-horizontal" role="form" accept-charset="utf-8" method="post" action="<?php echo $act; ?>">
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		  
		<?php
			if($language->num_rows() > 0){
				$i=1;
				foreach($language->result_array() as $languages){
		?>
		 <div id="entry<?php echo $i; ?>" class="clonedInput">
		  <h2 id="reference" name="reference" class="heading-reference">Entry #<?php echo $i; ?> <span class="pull-right"><a href="<?php echo base_url().'person/deleteLanguage/'.$languages['lang_id']; ?>"><span class="glyphicon glyphicon-trash"></span> <?php echo lang('delete'); ?></a></span></h2> 
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('language'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" id="lang-name" name="lang_name[]" class="form-control lang-name" placeholder="<?php echo lang('language'); ?>" value="<?php echo $languages['lang_name']; ?>">
			  <?php echo form_error('lang_name[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('spoken'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <select name="lang_talking[]" class="form-control lang-talking">
					 <option value="10" <?php echo $languages['lang_talking'] == 10 ? 'selected' : ''; ?>>10</option>
					 <option value="9" <?php echo $languages['lang_talking'] == 9 ? 'selected' : ''; ?>>9</option>
					 <option value="8" <?php echo $languages['lang_talking'] == 8 ? 'selected' : ''; ?>>8</option>
					 <option value="7" <?php echo $languages['lang_talking'] == 7 ? 'selected' : ''; ?>>7</option>
					 <option value="6" <?php echo $languages['lang_talking'] == 6 ? 'selected' : ''; ?>>6</option>
					 <option value="5" <?php echo $languages['lang_talking'] == 5 ? 'selected' : ''; ?>>5</option>
					 <option value="4" <?php echo $languages['lang_talking'] == 4 ? 'selected' : ''; ?>>4</option>
					 <option value="3" <?php echo $languages['lang_talking'] == 3 ? 'selected' : ''; ?>>3</option>
					 <option value="2" <?php echo $languages['lang_talking'] == 2 ? 'selected' : ''; ?>>2</option>
					 <option value="1" <?php echo $languages['lang_talking'] == 1 ? 'selected' : ''; ?>>1</option>
			  </select>
			  <?php echo form_error('lang_talking[]','<div class="alert alert-danger">', '</div>'); ?>	
			  </div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('writen'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <select name="lang_writing[]" class="form-control lang-writing">
					 <option value="10" <?php echo $languages['lang_writing'] == 10 ? 'selected' : ''; ?>>10</option>
					 <option value="9" <?php echo $languages['lang_writing'] == 9 ? 'selected' : ''; ?>>9</option>
					 <option value="8" <?php echo $languages['lang_writing'] == 8 ? 'selected' : ''; ?>>8</option>
					 <option value="7" <?php echo $languages['lang_writing'] == 7 ? 'selected' : ''; ?>>7</option>
					 <option value="6" <?php echo $languages['lang_writing'] == 6 ? 'selected' : ''; ?>>6</option>
					 <option value="5" <?php echo $languages['lang_writing'] == 5 ? 'selected' : ''; ?>>5</option>
					 <option value="4" <?php echo $languages['lang_writing'] == 4 ? 'selected' : ''; ?>>4</option>
					 <option value="3" <?php echo $languages['lang_writing'] == 3 ? 'selected' : ''; ?>>3</option>
					 <option value="2" <?php echo $languages['lang_writing'] == 2 ? 'selected' : ''; ?>>2</option>
					 <option value="1" <?php echo $languages['lang_writing'] == 1 ? 'selected' : ''; ?>>1</option>
			  </select>
			  <?php echo form_error('lang_writing[]','<div class="alert alert-danger">', '</div>'); ?>	
			  </div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('score'); ?></label>
			<div class="col-sm-10">
			  <input type="text" id="lang-score" name="lang_score[]" class="numeric form-control lang-score" placeholder="<?php echo lang('score'); ?>" value="<?php echo $languages['lang_score']; ?>">
			  <?php echo form_error('lang_score[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('description'); ?></label>
			<div class="col-sm-10">
			  <textarea class="form-control lang-desc" rows="3" name="lang_description[]"><?php echo $languages['lang_description']; ?></textarea>
			  <?php echo form_error('lang_description[]','<div class="alert alert-danger">', '</div>'); ?>
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
			<label class="col-sm-2 control-label"><?php echo lang('language'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" id="lang-name" name="lang_name[]" class="form-control lang-name" placeholder="<?php echo lang('language'); ?>" value="">
			  <?php echo form_error('lang_name[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('spoken'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <select name="lang_talking[]" class="form-control lang-talking">
					 <option value="10">10</option>
					 <option value="9">9</option>
					 <option value="8">8</option>
					 <option value="7">7</option>
					 <option value="6">6</option>
					 <option value="5">5</option>
					 <option value="4">4</option>
					 <option value="3">3</option>
					 <option value="2">2</option>
					 <option value="1">1</option>
			  </select>
			  <?php echo form_error('lang_talking[]','<div class="alert alert-danger">', '</div>'); ?>	
			  </div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('writen'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <select name="lang_writing[]" class="form-control lang-writing">
					 <option value="10">10</option>
					 <option value="9">9</option>
					 <option value="8">8</option>
					 <option value="7">7</option>
					 <option value="6">6</option>
					 <option value="5">5</option>
					 <option value="4">4</option>
					 <option value="3">3</option>
					 <option value="2">2</option>
					 <option value="1">1</option>
			  </select>
			  <?php echo form_error('lang_writing[]','<div class="alert alert-danger">', '</div>'); ?>	
			  </div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('score'); ?></label>
			<div class="col-sm-10">
			  <input type="text" id="lang-score" name="lang_score[]" class="numeric form-control lang-score" placeholder="<?php echo lang('score'); ?>" value="">
			  <?php echo form_error('lang_score[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('description'); ?></label>
			<div class="col-sm-10">
			  <textarea class="form-control lang-desc" rows="3" name="lang_description[]"></textarea>
			  <?php echo form_error('lang_description[]','<div class="alert alert-danger">', '</div>'); ?>
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
