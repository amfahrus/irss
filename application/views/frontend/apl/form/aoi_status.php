<div class="container">
      <div class="row row-offcanvas row-offcanvas-right">

		<div class="panel panel-default">
			  <div class="panel-heading">
                   <p><h4 class="head-text">Online Interview </h4></p>
              </div>
			  <div class="panel-body">
				  <?php
					   $info = $this->session->flashdata('info');
					   if (!empty($info)) {
							echo "<div class=\"alert alert-info\">" . $info . "</div>";
					   } 
				  ?>
				  <table class="table table-responsive table-hover">
				  <thead>
				  <tr>
					<td>Job Name</td>
					<td>Schedule</td>
					<td>Description</td>
					<td>Status</td>
				  </tr></thead>
				  <tbody>
				  		
			   <?php
				  if(count($aoi) > 0){
					  foreach($aoi as $test){
			   ?>	  
				  <tr>
					<td>
						<?php echo $test['job_name']; ?>
					</td>
					<td>
						 <?php echo $this->dokumen_lib->convert($test['start_date']).' s/d '.$this->dokumen_lib->convert($test['end_date']); ?>
					</td>
					<td>
						 <?php echo $test['description']; ?>
					</td>
					<td>
						 <?php echo $test['status']; ?>
					</td>
				  </tr>
			 <?php 
					}
				}
			 ?>
				  </tbody>
				  </table>
			  </div>
	      </div>
    </div>
        

</div><!-- /.container -->
