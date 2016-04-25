<script>
	function view_jobstep(js_id){
		$('#myModal').modal({
				remote: '<?php echo base_url(); ?>person/view_jobstep/'+js_id
			});
	}
	</script>
<div class="container">
      <div class="row row-offcanvas row-offcanvas-right">

		<div class="panel panel-default">
			  <div class="panel-heading">
                   <p><h4 class="head-text"><b><?php echo lang('application_status'); ?> </h4></p>
              </div>
			  <div class="panel-body">
				  <?php
					   $info = $this->session->flashdata('info');
					   if (!empty($info)) {
							echo "<div class=\"alert alert-info\">" . $info . "</div>";
					   } 
				  ?>
				  <table class="table table-responsive table-hover">
				  <tbody>
				  		
			   <?php
				  if(count($job_status) > 0){
					  foreach($job_status as $job){
			   ?>	  
				  <tr>
					<td>
						<a href="<?php echo base_url().'home/detail/'.$job['job_id'].'/'.url_title($job['job_name']); ?>"><?php echo $job['job_name']; ?></a>
					</td>
					<td>
						 <div class="list-group">
						<?php
							$total = count($job['job_status']);
							$i = 1;
							foreach($job['job_status'] as $steps => $status){
								switch ($status['status']) {
									case 'pass':
										//echo '<button type="button" class="btn btn-success"><span class="glyphicon glyphicon-ok-sign"></span> '.$i.' '.$steps.'</button>';
										echo '<a href="#" onclick="view_jobstep('.$status['js_id'].');" class="list-group-item list-group-item-success">'.$i.'. '.$steps.'<span class="pull-right"><span class="glyphicon glyphicon-ok-sign"></span> '.lang('passed').'</span></a>';
										break;
									case 'fail':
										 //echo $job['job_active'] > 0 ? '<a href="#" onclick="view_jobstep('.$status['js_id'].');" class="list-group-item list-group-item-info">'.$i.'. '.$steps.'<span class="pull-right"><span class="glyphicon glyphicon-exclamation-sign"></span> '.lang('proses').'</span></a>' : '<a href="#" onclick="view_jobstep('.$status['js_id'].');" class="list-group-item list-group-item-danger">'.$i.'. '.$steps.'<span class="pull-right"><span class="glyphicon glyphicon-minus-sign"></span> '.lang('failed').'</span></a>';
										 echo '<a href="#" onclick="view_jobstep('.$status['js_id'].');" class="list-group-item list-group-item-info">'.$i.'. '.$steps.'<span class="pull-right"><span class="glyphicon glyphicon-exclamation-sign"></span> '.lang('proses').'</span></a>';
										
										//echo '<button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-minus-sign"></span> '.$i.' '.$steps.'</button>';
										break;
									case 'unknown':
										//echo '<button type="button" class="btn btn-warning"><span class="glyphicon glyphicon-question-sign"></span> '.$i.' '.$steps.'</button>';
										echo '<a href="#" onclick="view_jobstep('.$status['js_id'].');" class="list-group-item list-group-item-warning">'.$i.'. '.$steps.'<span class="pull-right"><span class="glyphicon glyphicon-question-sign"></span> '.lang('unknown').'</span></a>';
										break;
								}
								$i++;
							}
						 ?>
						</div>

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
