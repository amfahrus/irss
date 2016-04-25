<script>
$(function () {
	var cstate = <?php echo $card->num_rows() > 0 ? $card->num_rows() : 1 ; ?>;
    $('#btnAdd').click(function () {
        var num     = $('.clonedInput').length, // Checks to see how many "duplicatable" input fields we currently have
            newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
            newElem = $('#entry' + num).clone().attr('id', 'entry' + newNum).fadeIn('slow'); // create the new element via clone(), and manipulate it's ID using newNum value
        
        // H2 - section
        newElem.find('.heading-reference').attr('id', 'ID' + newNum + '_reference').attr('name', 'ID' + newNum + '_reference').html('Entry #' + newNum);

        // Card Name
        newElem.find('.card-name').val('');
        
        // Card Number
        newElem.find('.card-number').val('');
        
        // Card Place
        newElem.find('.card-place').val('');
        
        // Card Expire
        newElem.find('.card-expire').val('');

    // Insert the new element after the last "duplicatable" input field
        $('#entry' + num).after(newElem);
        $('#ID' + newNum + '_reference').focus();

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
			if( 
			!newElem.find('.card-name').val()
			|| !newElem.find('.card-number').val()
			|| !newElem.find('.card-place').val()
			|| !newElem.find('.card-expire').val()
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
				if (num -1 === 1){
					$('#btnDel').attr('disabled', true);
				}
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
        <h4><span class="glyphicon glyphicon-user"></span> Edit <?php echo lang('id_card'); ?></h4>
      </div>
      <div class="panel-body"> 
        <form id="formvalid" class="form-horizontal" role="form" accept-charset="utf-8" method="post" action="<?php echo $act; ?>">
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		  
		<?php
			if($card->num_rows() > 0){
				$i=1;
				foreach($card->result_array() as $cards){
		?>
		 <div id="entry<?php echo $i; ?>" class="clonedInput">
		  <h2 id="reference" name="reference" class="heading-reference">Entry #<?php echo $i; ?> <span class="pull-right"><a href="<?php echo base_url().'person/deleteCard/'.$cards['card_id']; ?>"><span class="glyphicon glyphicon-trash"></span> <?php echo lang('delete'); ?></a></span></h2> 
		  <div class="form-group">
			<label for="inputCardName3" class="col-sm-2 control-label"><?php echo lang('card_name'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" id="card-name" name="card_name[]" class="form-control card-name" placeholder="<?php echo lang('card_name'); ?>" value="<?php echo $cards['card_name']; ?>">
			  <?php echo form_error('card_name[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="inputCardNumber3" class="col-sm-2 control-label"><?php echo lang('card_number'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" id="card-number" name="card_number[]" class="form-control card-number" placeholder="<?php echo lang('card_number'); ?>" value="<?php echo $cards['card_number']; ?>">
			  <?php echo form_error('card_number[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="inputCardPlace3" class="col-sm-2 control-label"><?php echo lang('card_place'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" id="card-place" name="card_place[]" class="form-control card-place" placeholder="<?php echo lang('card_place'); ?>" value="<?php echo $cards['card_place']; ?>">
			  <?php echo form_error('card_place[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="inputCardExpire3" class="col-sm-2 control-label"><?php echo lang('card_expire'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" id="card-expire" name="card_expire[]" class="form-control datepicker card-expire" placeholder="<?php echo lang('card_expire'); ?>" value="<?php echo $cards['card_expire']; ?>">
			  <?php echo form_error('card_expire[]','<div class="alert alert-danger">', '</div>'); ?>
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
			<label for="inputCardName3" class="col-sm-2 control-label"><?php echo lang('card_name'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" id="card-name" name="card_name[]" class="form-control card-name" placeholder="<?php echo lang('card_name'); ?>" value="">
			  <?php echo form_error('card_name[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="inputCardNumber3" class="col-sm-2 control-label"><?php echo lang('card_number'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" id="card-number" name="card_number[]" class="form-control card-number" placeholder="<?php echo lang('card_number'); ?>" value="">
			  <?php echo form_error('card_number[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="inputCardPlace3" class="col-sm-2 control-label"><?php echo lang('card_place'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" id="card-place" name="card_place[]" class="form-control card-place" placeholder="<?php echo lang('card_place'); ?>" value="">
			  <?php echo form_error('card_place[]','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="inputCardExpire3" class="col-sm-2 control-label"><?php echo lang('card_expire'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" id="card-expire" name="card_expire[]" class="form-control datepicker card-expire" placeholder="<?php echo lang('card_expire'); ?>" value="">
			  <?php echo form_error('card_expire[]','<div class="alert alert-danger">', '</div>'); ?>
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
