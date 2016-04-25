<div class="container">
    <div class="row row-offcanvas row-offcanvas-right">
	<?php
		if($job_detail->num_rows() > 0){
			$preview = $job_detail->row_array();
	?>		  
	<div class="panel panel-default">
	  <div class="panel-heading">
        <h4><span class="glyphicon glyphicon-th-large"></span> <?php echo lang('job_detail'); ?>
        <div class="pull-right">
				<a href="<?php echo base_url().'company/edit_post/'.$preview['job_id']; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-edit"></span> Edit</a>
				<a href="<?php echo base_url().'company/jobs'; ?>" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> <?php echo lang('done'); ?></a>
		</div>
		</h4>
      </div>
      <div class="panel-body">	
		<center>
			<img src="<?php echo $preview['company_banner']; ?>" class="img-responsive">
		</center>	
		<table class="table table-responsive table-hover">
			<tr>
				<td colspan="2">
					 <p><h4><?php echo $preview['company_name']; ?></h4></p>
					 <p><?php echo $preview['company_desc']; ?></p>
				</td>
			</tr>
			<tr>
				<td colspan="2">
						<p><h3><center><span class="label label-info"><?php echo $preview['job_name']; ?></span></center></h3></p>
				</td>
			</tr>
			<tr>
				<td colspan="2"><p><?php echo $preview['job_desc']; ?></p></td>
			</tr>
			<?php if($preview['job_is_external'] == 1){ ?>
			<tr>
				<td colspan="2"><h2><center><a href="<?php echo $preview['job_external_url']; ?>" target="_blank"><?php echo $preview['job_external_url']; ?></a></center></h2></td>
			</tr>
			<?php } else { ?>
			<tr>
				<td><b><?php echo lang('step'); ?></b></td>
				<td>
					<?php 
					if($job_step->num_rows() > 0){ 
						echo "<div class=\"tabs-left\"><ul class=\"nav nav-tabs\">";
						foreach($job_step->result_array() as $steps){
							echo "<li><a href=\"#tab".$steps['js_order']."\" data-toggle=\"tab\">".$steps['js_order'].". ".$steps['step_name']."</a></li>";
							}
						echo "</ul>";
						echo "<div class=\"tab-content\">";
						foreach($job_step->result_array() as $steps){
							echo "<div class=\"tab-pane\" id=\"tab".$steps['js_order']."\">".$steps['js_desc']."</div>";
						}
						echo "</div></div>";
					}
					?>
				</td>
			</tr>
			<?php } ?>	
			<tr>
				<td><b><?php echo lang('career_level'); ?></b></td>
				<td><?php echo $preview['category_name']; ?></td>
			</tr>
			<?php if(!empty($preview['job_age'])){ ?>
			<tr>
				<td><b><?php echo lang('ages'); ?></b></td>
				<td><?php echo $preview['job_age'].' '.lang('years'); ?></td>
			</tr>
			<?php } ?>
			<?php if(!empty($preview['job_score']) && !empty($preview['job_scale'])){ ?>
			<tr>
				<td><b><?php echo lang('gpas'); ?></b></td>
				<td><?php echo $preview['job_score'].' / '.$preview['job_scale']; ?></td>
			</tr>
			<?php } ?>
			<?php if(!empty($preview['job_gender'])){ ?>
			<tr>
				<td><b><?php echo lang('gender_priority'); ?></b></td>
				<td><?php echo lang(strtolower($preview['job_gender'])); ?></td>
			</tr>
			<?php } ?>
			<tr>
				<td><b><?php echo lang('years_of_experience'); ?></b></td>
				<td><?php echo $preview['job_years_exp'].' '.lang('years'); ?></td>
			</tr>

			<tr>
				<td><b><?php echo lang('education'); ?></b></td>
				<td><?php echo $preview['grade_name']; ?></td>
			</tr>
			<tr>
				<td><b><?php echo lang('qualification'); ?></b></td>
				<td><?php echo $preview['major']; ?></td>
			</tr>
			<tr>
				<td><b><?php echo lang('industry'); ?></b></td>
				<td><?php echo $preview['industry_name']; ?></td>
			</tr>
			<tr>
				<td><b><?php echo lang('job_function'); ?></b></td>
				<td><?php echo $preview['job_function']; ?></td>
			</tr>
			<tr>
				<td><b><?php echo lang('location'); ?></b></td>
				<td><?php echo $preview['city_name']; ?></td>
			</tr>
			<tr>
				<td><b><?php echo lang('employment_term'); ?></b></td>
				<td><?php echo $preview['term_name']; ?></td>
			</tr>	
			<tr>
				<td><b><?php echo lang('posting_date'); ?></b></td>
				<td><?php echo $this->dokumen_lib->simple($preview['job_post_date']); ?></td>
			</tr>
			<tr>
				<td><b><?php echo lang('expire_date'); ?></b></td>
				<td><?php echo $this->dokumen_lib->simple($preview['job_due_date']); ?></td>
			</tr>
		</table>
      </div>
      <div class="panel-footer">
			<a class="btn btn-default"><span class="glyphicon glyphicon-user"></span><?php echo $preview['sumappl']; ?> <?php echo lang('applicants'); ?></a>
					<div class="pull-right">
				<a href="<?php echo base_url().'company/edit_post/'.$preview['job_id']; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-edit"></span> Edit</a>
				<a href="<?php echo base_url().'company/jobs'; ?>" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> <?php echo lang('done'); ?></a>
			</div>
	 </div>
    </div>
    
	<?php 
		}
	?>   
    </div>
</div><!-- /.container -->
