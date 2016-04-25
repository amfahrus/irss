<div class="container">
      <div class="row row-offcanvas row-offcanvas-right">

		<div class="panel panel-default">
			  <div class="panel-heading">
                   <p><h4 class="head-text">Online Test </h4></p>
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
					<td>Name</td>
					<td>Job Name</td>
					<td>Schedule</td>
					<td>Description</td>
					<td>Status AOT</td>
					<td>Result</td>
				  </tr></thead>
				  <tbody>
				  		
			   <?php
				  if(count($aot) > 0){
					  foreach($aot as $test){
			   ?>	  
				  <tr>
					<td>
						<?php echo $test['detail']; ?>
					</td>
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
					<td>
						 <?php echo $test['result']; ?>
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
