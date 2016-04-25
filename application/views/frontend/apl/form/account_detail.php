<div class="container">
      <div class="row row-offcanvas row-offcanvas-right">
		
		<?php
			if($person){
		?>
		
		<div class="panel panel-default">
			  <div class="panel-heading">
                   <p><h4 class="head-text"><b>Password <span class="pull-right"><a href="<?php echo base_url().'person/edit_password/'; ?>"><span class="glyphicon glyphicon-edit"></span> Edit</a></span></h4></p>
              </div>
			  <div class="panel-body">
				  <table class="table table-responsive">
				  <tbody>
				  <tr>
					<td>
						Password
					</td>
					<td>******
					</td>
				  </tr>
				  </tbody>
				  </table>
			  </div>
	      </div>
	      
	      <div class="panel panel-default">
			  <div class="panel-heading">
                   <p><h4 class="head-text"><b><?php echo lang('information'); ?> <span class="pull-right"><a href="<?php echo base_url().'person/edit_account/'; ?>"><span class="glyphicon glyphicon-edit"></span> Edit</a></span></h4></p>
              </div>
			  <div class="panel-body">
				  <table class="table table-responsive">
				  <tbody>
				  <tr>
					<td>
						<?php echo lang('full_name'); ?>
					</td>
					<td>
						<?php echo !empty($person['name']) ? $person['name'] : '-' ; ?>
					</td>
				  </tr>
				  <tr>
					<td>
						Email
					</td>
					<td>
						<?php echo !empty($person['email']) ? $person['email'] : '-' ; ?>
					</td>
				  </tr>
				  <tr>
					<td>
						<?php echo lang('phone'); ?>
					</td>
					<td>
						<?php echo !empty($person['phone']) ? $person['phone'] : '-' ; ?>
					</td>
				  </tr>
				  <tr>
					<td>
						<?php echo lang('address'); ?>
					</td>
					<td>
						<?php echo !empty($person['address']) ? $person['address'] : '-' ; ?>
					</td>
				  </tr>
				  </tbody>
				  </table>
			  </div>
	      </div>
	      
	      <div class="panel panel-default">
			  <div class="panel-heading">
                   <p><h4 class="head-text"><b><?php echo lang('job_alert'); ?> <span class="pull-right"><a href="<?php echo base_url().'person/jobalert/'; ?>"><span class="glyphicon glyphicon-edit"></span> Edit</a></span></h4></p>
              </div>
			  <div class="panel-body">
				  <table class="table table-responsive">
				  <tbody>
				  <tr>
					<td>
						<?php echo lang('subscribe'); ?>
					</td>
					<td>
						<?php echo $person['is_job_alert'] > 0 ? lang('yes') : lang('no') ; ?>
					</td>
				  </tr>
				  </tbody>
				  </table>
			  </div>
	      </div>
		 <?php 
			}
		 ?>

       
    </div>
        

</div><!-- /.container -->
