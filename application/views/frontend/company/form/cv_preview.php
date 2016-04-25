<?php
			if($person){
		?>
		<div class="scroll-area">
			<center>
				<img class="img-responsive thumbnail" src="<?php echo base_url().'images/logo.png'; ?>" alt="IRSS">
			</center>
			<center><h2>BIODATA PELAMAR</h2></center>
		<div class="panel panel-default">
			  <div class="panel-heading">
                   <p><h4 class="head-text"><?php echo lang('I'); ?> <span class="pull-right"><a href="<?php echo base_url().'company/pdfcv/'.$person['user_id']; ?>" class="btn btn-danger">Download</a></span></h4></p>
              </div>
			  <div class="panel-body">
				  <table class="table table-responsive table-hover">
				  <tbody>	  
				  <tr>
					<td width="25%">
						1. <?php echo lang('full_name'); ?>
					</td>
					<td>
						<?php echo !empty($person['name']) ? $person['name'] : '-' ; ?>
					</td>
					<td rowspan="5">
						<center>
						<img class="img-responsive thumbnail" width="140px" height="140px" src="<?php echo !empty($person['photo']) ? $person['photo'] : base_url().'assets/photo/no_person.jpg'; ?>" alt="<?php echo $person['name'] ?>">
						</center>
					</td>
				  </tr>
				  <tr>
					<td>
						2. <?php echo lang('birth_place'); ?>
					</td>
					<td>
						<?php echo !empty($person['birth_place']) ? $person['birth_place'] : '-' ; ?>
					</td>
				  </tr>
				  <tr>
					<td>
						3. <?php echo lang('birth_date'); ?>
					</td>
					<td>
					    <?php echo !empty($person['birth_date']) ? $this->dokumen_lib->simple($person['birth_date']) : '-' ; ?> 
					</td>
				  </tr>
				  <tr>
					<td>
						4. <?php echo lang('religion'); ?>
					</td>
					<td>
						<?php echo !empty($person['religion']) ? $person['religion'] : '-' ; ?>
					</td>
				  </tr>
				  <tr>
					<td>
						5. <?php echo lang('gender'); ?>
					</td>
					<td>
						<?php echo !empty($person['gender']) ? ($person['gender'] == 'Male' ? lang('male') : lang('female')) : '-' ; ?>
					</td>
				  </tr>
				  <tr>
					<td>
						6. <?php echo lang('marital_status'); ?>
					</td>
					<td>
						<?php echo !empty($person['marital_status']) ? lang(strtolower($person['marital_status'])): '-' ; ?>
					</td>
				  </tr>
				  <tr>
					<td>
						7. <?php echo lang('address'); ?>
					</td>
					<td colspan="2">
						<?php echo !empty($person['address']) ? $person['address'] : '-' ; ?>
					</td>
				  </tr>
				  <tr>
					<td>
						8. <?php echo lang('city'); ?>
					</td>
					<td colspan="2">
						<?php echo !empty($person['city']) ? $person['city'] : '-' ; ?>
					</td>
				  </tr>
				  <tr>
					<td>
						9. <?php echo lang('phone'); ?>
					</td>
					<td colspan="2">
						<?php echo !empty($person['phone']) ? $person['phone'] : '-' ; ?>
					</td>
				  </tr>
				  <tr>
					<td>
						10. Email
					</td>
					<td colspan="2">
						<?php echo !empty($person['email']) ? $person['email'] : '-' ; ?>
					</td>
				  </tr>
				  <tr>
					<td>
						11. <?php echo lang('id_card'); ?>
					</td>
					<td colspan="2">
						<?php
							if($card->num_rows() > 0){
						?>
								  <table class="table table-bordered">
								  <thead>
									<tr>
									<th><?php echo lang('card_name'); ?></th>
									<th><?php echo lang('card_number'); ?></th>
									<th><?php echo lang('card_place'); ?></th>
									<th><?php echo lang('card_expire'); ?></th>
									</tr>
								  </thead>
								  <tbody>
						<?php
								foreach($card->result_array() as $cards){
						?>
								  <tr>
									<td>
										<?php echo !empty($cards['card_name']) ? $cards['card_name'] : '-' ; ?>
									</td>

									<td>
										<?php echo !empty($cards['card_number']) ? $cards['card_number'] : '-' ; ?>
									</td>
								 
									<td>
										<?php echo !empty($cards['card_place']) ? $cards['card_place'] : '-' ; ?>
									</td>

									<td>
										<?php echo !empty($cards['card_expire']) ? $this->dokumen_lib->simple($cards['card_expire']) : '-' ; ?>
									</td>
								  </tr>
							 <?php 
								}
							 ?>
								  </tbody>
								  </table>
						 <?php 
							}
						 ?>
					</td>
				  </tr>
				  
				  </tbody>
				  </table>
			  </div>
	      </div>
	      
		<div class="panel panel-default">
			  <div class="panel-heading">
                   <p><h4 class="head-text"><?php echo lang('II'); ?></h4></p>
              </div>
			  <div class="panel-body">
				  <table class="table table-responsive table-hover">
				  <tbody>	  
				  <tr>
					<td>
						<?php echo lang('height'); ?>
					</td>
					<td colspan="2">
						<?php echo !empty($person['height']) ? $person['height'].' cm' : '-' ; ?>
					</td>
				  </tr>
				  <tr>
					<td>
						<?php echo lang('weight'); ?>
					</td>
					<td colspan="2">
						<?php echo !empty($person['weight']) ? $person['weight'].' kg' : '-' ; ?>
					</td>
				  </tr>
				  </tbody>
				  </table>
			  </div>
	      </div>
	      
		 <?php 
			}
		 ?>
		
		<div class="panel panel-default">
			  <div class="panel-heading">
                   <p><h4 class="head-text"><?php echo lang('III'); ?></h4></p>
              </div>
			  <div class="panel-body">
		<p><b>1. <?php echo lang('education'); ?></b></p>
		<?php
			if($education->num_rows() > 0){
		?>
				  <table class="table table-responsive table-hover table-bordered">
				  <thead>
					<tr>
					<th><?php echo lang('university'); ?></th>
					<th><?php echo lang('city'); ?></th>
					<th><?php echo lang('grade_name'); ?></th>
					<th><?php echo lang('field_of_study'); ?></th>
					<th><?php echo lang('graduate'); ?></th>
					<th><?php echo lang('grade'); ?></th>
					<th><?php echo lang('graduation_year'); ?></th>
					</tr>
				  </thead>	  
				  <tbody>
		<?php
				foreach($education->result_array() as $educations){
		?>
				  <tr>
					<td>
						<?php echo !empty($educations['edu_name']) ? $educations['edu_name'] : '-' ; ?>
					</td>
				    <td>
						<?php echo !empty($educations['edu_place']) ? $educations['edu_place'] : '-' ; ?>
					</td>
				    <td>
						<?php echo !empty($educations['grade_name']) ? $educations['grade_name'] : '-' ; ?>
					</td>
				    <td>
						<?php echo !empty($educations['edu_status']) && $educations['edu_status'] == 1 ? lang('yes') : lang('no') ; ?>
					</td>
				    <td>
						<?php echo !empty($educations['major_name']) ? $educations['major_name'] : '-' ; ?>
					</td>
				    <td>
						<?php echo !empty($educations['edu_gpa']) && !empty($educations['edu_gpa_scale']) ? $educations['edu_gpa'].'/'.$educations['edu_gpa_scale'] : '-' ; ?>
					</td>
				    <td>
						<?php echo !empty($educations['edu_years']) ? $educations['edu_years'] : '-' ; ?>
					</td>
					
				  </tr>
			 <?php 
				}
			 ?>
				  </tbody>
				  </table>
		 <?php 
			}
		 ?>
		<hr>	  
        <p><b>2. <?php echo lang('training'); ?></b></p>
		<?php
			if($training->num_rows() > 0){
		?>
				  <table class="table table-responsive table-hover table-bordered">
				  <thead>
					<tr>
					<th><?php echo lang('training_name'); ?></th>
					<th><?php echo lang('training_institution'); ?></th>
					<th><?php echo lang('training_location'); ?></th>
					<th><?php echo lang('training_year'); ?></th>
					</tr>
				  </thead>	  
				  <tbody>
		<?php
				foreach($training->result_array() as $trainings){
		?>
				  <tr>
					<td>
						<?php echo !empty($trainings['training_name']) ? $trainings['training_name'] : '-' ; ?>
					</td>
				    <td>
						<?php echo !empty($trainings['training_trainer']) ? $trainings['training_trainer'] : '-' ; ?>
					</td>
				    <td>
						<?php echo !empty($trainings['training_city']) ? $trainings['training_city'] : '-' ; ?>
					</td>
				    <td>
						<?php echo !empty($trainings['training_years']) ? $trainings['training_years'] : '-' ; ?>
					</td>
					
				  </tr>
			 <?php 
				}
			 ?>
				  </tbody>
				  </table>
		 <?php 
			}
		 ?>
		 <hr>
		 <p><b>3. <?php echo lang('language'); ?></b></p>
		<?php
			if($language->num_rows() > 0){
		?>
				  <table class="table table-responsive table-hover table-bordered">
				  <thead>
					<tr>
					<th><?php echo lang('language'); ?></th>
					<th><?php echo lang('spoken'); ?></th>
					<th><?php echo lang('writen'); ?></th>
					<th><?php echo lang('score'); ?></th>
					<th><?php echo lang('description'); ?></th>
					</tr>
				  </thead>	  
				  <tbody>
		<?php
				foreach($language->result_array() as $languages){
		?>
				  <tr>
					<td>
						<?php echo !empty($languages['lang_name']) ? $languages['lang_name'] : '-' ; ?>
					</td>
					<td>
						<?php echo !empty($languages['lang_talking']) ? $languages['lang_talking'] : '-' ; ?>
					</td>
					<td>
						<?php echo !empty($languages['lang_writing']) ? $languages['lang_writing'] : '-' ; ?>
					</td>
					<td>
						<?php echo !empty($languages['lang_score']) && $languages['lang_score'] == 0 ? $languages['lang_score'] : '-' ; ?>
					</td>
					<td>
						<?php echo !empty($languages['lang_description']) ? $languages['lang_description'] : '-' ; ?>
					</td>
					
				  </tr>
			 <?php 
				}
			 ?>
				  </tbody>
				  </table>
		 <?php 
			}
		 ?>
		<hr> 
        <p><b>4. <?php echo lang('experience'); ?></b></p>
		<?php
			if($experience->num_rows() > 0){
		?>
				  <table class="table table-responsive table-hover table-bordered">
				  <thead>
					<tr>
					<th><?php echo lang('company_name'); ?></th>
					<th><?php echo lang('company_major'); ?></th>
					<th><?php echo lang('company_address'); ?></th>
					<th><?php echo lang('last_position'); ?></th>
					<th><?php echo lang('last_sallary'); ?></th>
					<th><?php echo lang('join_date'); ?></th>
					<th><?php echo lang('out_date'); ?></th>
					</tr>
				  </thead>	  
				  <tbody>
		<?php
				foreach($experience->result_array() as $experiences){
		?>
				  <tr>
					<td rowspan="2">
						<?php echo !empty($experiences['exp_company']) ? $experiences['exp_company'] : '-' ; ?>
					</td>
					<td>
						<?php echo !empty($experiences['exp_major']) ? $experiences['exp_major'] : '-' ; ?>
					</td>
					<td>
						<?php echo !empty($experiences['exp_address']) ? $experiences['exp_address'] : '-' ; ?>
					</td>
					<td>
						<?php echo !empty($experiences['exp_position']) ? $experiences['exp_position'] : '-' ; ?>
					</td>
					<td>
						<?php echo !empty($experiences['exp_sallary']) ? $experiences['exp_sallary'] : '-' ; ?>
					</td>
					<td>
						<?php echo !empty($experiences['exp_joindate']) ? $this->dokumen_lib->simple($experiences['exp_joindate']) : '-' ; ?>
					</td>
					<td>
						<?php echo $experiences['exp_untilnow'] > 0 ? lang('still_work') : (!empty($experiences['exp_outdate']) ? $this->dokumen_lib->simple($experiences['exp_outdate']) : '-') ; ?>
					</td>
					
				  </tr>
				  <tr>
				  	<td colspan="7">
						<b><?php echo lang('job_description'); ?></b> : <?php echo !empty($experiences['exp_jobdesc']) ? $experiences['exp_jobdesc'] : '-' ; ?>
					</td>
				  </tr>
			 <?php 
				}
			 ?>
				  </tbody>
				  </table>
		 <?php 
			}
		 ?>
		
			  </div>
	      </div>
	      	 
		<div class="panel panel-default">
			  <div class="panel-heading">
                   <p><h4 class="head-text"><?php echo lang('IV'); ?></h4></p>
              </div>
			  <div class="panel-body">
		<?php
			if($expectation->num_rows() > 0){
		?>
				  <table class="table table-responsive table-hover">	  
				  <tbody>
		<?php
				foreach($expectation->result_array() as $expectations){
		?>
				  <tr>
					<td>
						<?php echo lang('expected_sallary'); ?>
					</td>  
					<td>
						<?php echo !empty($expectations['expected_sallary']) ? $expectations['expected_sallary'] : '-' ; ?>
					</td>
				  </tr>
				  <tr>
					<td>
						<?php echo lang('expected_work_location'); ?>
					</td> 
					<td>
						<?php echo !empty($expectations['city_name']) ? $expectations['city_name'] : '-' ; ?>
					</td>
				  </tr>
				  <tr>
					<td>
						<?php echo lang('additional_info'); ?>
					</td> 
					<td>
						<?php echo !empty($expectations['expected_description']) ? $expectations['expected_description'] : '-' ; ?>
					</td>
					
				  </tr>
				  
				  <tr>
					<td>
						<?php echo lang('uploaded_resume'); ?>
					</td> 
					<td>
						<?php echo !empty($expectations['expected_url_cv']) ? '<a href="'.$expectations['expected_url_cv'].'" class="btn btn-primary" target="_blank">Download</a>' : '-' ; ?>
					</td>
					
				  </tr>
			 <?php 
				}
			 ?>
				  </tbody>
				  </table>
		 <?php 
			}
		 ?>
			  </div>
	      </div>
	      <!--
	      <div class="panel panel-default">
			  <div class="panel-heading">
                   <p><h4 class="head-text"><?php echo lang('V'); ?></h4></p>
              </div>
			  <div class="panel-body">
				  
			  </div>
	      </div>
	      -->
	      </div>
		
