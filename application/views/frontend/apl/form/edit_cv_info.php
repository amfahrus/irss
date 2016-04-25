<script src="<?php echo base_url(); ?>assets/frontend/twbs/plugins/validator/jquery.numeric.js"></script>
<script>
	$(document).ready(function(){
		$('textarea').wysihtml5();
		$('.numeric').numeric();
	});
</script>
<div class="container">
      <div class="row row-offcanvas row-offcanvas-right">
		  
<div class="panel panel-default">
	  <div class="panel-heading">
        <h4><span class="glyphicon glyphicon-user"></span> Edit <?php echo lang('information'); ?></h4>
      </div>
      <div class="panel-body">
        <form class="form-horizontal" role="form" accept-charset="utf-8" enctype="multipart/form-data" method="post" action="<?php echo $act; ?>">
		  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		  
		  <div class="form-group">
			<label for="inputPhoto3" class="col-sm-2 control-label">Photo</label>
			<div class="col-sm-10">  
				<input type="file" name="photo" id="InputFile">
				<div class="help-block"><?php echo lang('max_3mb_with_only_jpg,_gif,_png_extension'); ?></div>
		    </div>
		  </div>
		  
		  <div class="form-group">
			<label for="inputName3" class="col-sm-2 control-label"><?php echo lang('full_name'); ?></label>
			<div class="col-sm-10">
			  <input type="text" name="name" class="form-control" id="inputName3" placeholder="<?php echo lang('full_name'); ?>" value="<?php echo $person['name']; ?>">
			  <?php echo form_error('name','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="inputGender3" class="col-sm-2 control-label"><?php echo lang('gender'); ?></label>
			<div class="col-sm-10">
			   <select name="gender" class="form-control">
				  <option value="Male" <?php echo $person['gender'] == 'Male' ? 'selected' : ''; ?>><?php echo lang('male'); ?></option>
				  <option value="Female" <?php echo $person['gender'] == 'Female' ? 'selected' : ''; ?>><?php echo lang('female'); ?></option>
				</select>
			  <?php echo form_error('gender','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="inputGender3" class="col-sm-2 control-label"><?php echo lang('marital_status'); ?></label>
			<div class="col-sm-10">
			   <select name="marital_status" class="form-control">
				  <option value="Married" <?php echo $person['marital_status'] == 'Married' ? 'selected' : ''; ?>><?php echo lang('married'); ?></option>
				  <option value="Not Married" <?php echo $person['marital_status'] == 'Not Married' ? 'selected' : ''; ?>><?php echo lang('not_married'); ?></option>
				  <option value="Widower" <?php echo $person['marital_status'] == 'Widower' ? 'selected' : ''; ?>><?php echo lang('widower'); ?></option>
				  <option value="Widow" <?php echo $person['marital_status'] == 'Widow' ? 'selected' : ''; ?>><?php echo lang('widow'); ?></option>
				</select>
			  <?php echo form_error('marital_status','<div class="alert alert-danger">', '</div>'); ?>
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
			  <textarea class="form-control" rows="3" name="address"><?php echo $person['address']; ?></textarea>
			  <?php echo form_error('address','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="inputCity3" class="col-sm-2 control-label"><?php echo lang('city'); ?></label>
			<div class="col-sm-10">
			  <input type="text" name="city" class="form-control" id="inputCity3" placeholder="<?php echo lang('city'); ?>" value="<?php echo $person['city']; ?>">
			  <?php echo form_error('city','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="inputBirthPlace3" class="col-sm-2 control-label"><?php echo lang('birth_place'); ?></label>
			<div class="col-sm-10">
			  <input type="text" name="birth_place" class="form-control" id="inputBirthPlace3" placeholder="<?php echo lang('birth_place'); ?>" value="<?php echo $person['birth_place']; ?>">
			  <?php echo form_error('phone','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="inputBirthDate3" class="col-sm-2 control-label"><?php echo lang('birth_date'); ?></label>
			<div class="col-sm-10">
			  <input type="text" name="birth_date" class="form-control datepicker" id="inputBirthDate3" placeholder="<?php echo lang('birth_date'); ?>" value="<?php echo $person['birth_date']; ?>">
			  <?php echo form_error('birth_date','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="inputReligion3" class="col-sm-2 control-label"><?php echo lang('religion'); ?></label>
			<div class="col-sm-10">
			  <input type="text" name="religion" class="form-control" id="inputReligion3" placeholder="<?php echo lang('religion'); ?>" value="<?php echo $person['religion']; ?>">
			  <?php echo form_error('religion','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="inputHeight3" class="col-sm-2 control-label"><?php echo lang('height'); ?> (cm)</label>
			<div class="col-sm-10">
			  <input type="text" name="height" class="numeric form-control" id="inputHeight3" placeholder="<?php echo lang('height'); ?>" value="<?php echo $person['height']; ?>">
			  <?php echo form_error('height','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label for="inputWeight3" class="col-sm-2 control-label"><?php echo lang('weight'); ?> (kg)</label>
			<div class="col-sm-10">
			  <input type="text" name="weight" class="numeric form-control" id="inputWeight3" placeholder="<?php echo lang('weight'); ?>" value="<?php echo $person['weight']; ?>">
			  <?php echo form_error('weight','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
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
