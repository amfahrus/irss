<div class="container">
      <div class="row row-offcanvas row-offcanvas-right">
		  
		<div class="col-md-12">
			
        <div class="col-md-8">
		  
		  <?php
			echo $panel;
		  ?>
		  
		  <?php
				if($job_detail->num_rows() > 0){
					$preview = $job_detail->row_array();
			?>		  
			<div class="panel panel-default toprint">
			  <div class="panel-heading">
				<h4><span class="glyphicon glyphicon-th-large"></span> <?php echo lang('job_detail'); ?>
				</h4>
			  </div>
			  <div class="panel-body">	
				<div class="center-block">
					<img src="<?php echo $preview['company_banner']; ?>" class="img-responsive">
				</div>			
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
						<td><b><?php echo lang('years_experience'); ?></b></td>
						<td><?php echo $preview['job_years_exp']; ?> <?php echo lang('years'); ?></td>
					</tr>
					<tr>
						<td><b><?php echo lang('education'); ?></b></td>
						<td><?php echo $preview['grade_name']; ?></td>
					</tr>
					<?php if(!empty($preview['qualified_edu'])){ ?>
					<tr>
						<td><b><?php echo lang('qualified_edu'); ?></b></td>
						<td><?php echo $preview['major']; ?></td>
					</tr>
					<?php } ?>
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
						<a href="<?php echo base_url().'person/submitjob/'.$preview['job_id']; ?>" class="btn btn-warning" target="_blank"><span class="glyphicon glyphicon-plus"></span> <?php echo lang('submit'); ?></a>
					</div>
			 </div>
			</div>
		  

        </div>

		<div class="col-md-4">
        
		  <div class="panel panel-default">
			<div class="panel-heading">
				<h5 class="head-text"><b><?php echo $preview['company_name']; ?></b></h5>
			</div>
			<div class="panel-body">
				<a title="<?php echo $preview['sumjobs']; ?> opening jobs." class="well top-block" href="<?php echo base_url().'home/company/'.$preview['company_id'].'/'.url_title($preview['company_name']); ?>">
					<img src="<?php echo$preview['company_logo']; ?>" width="50px" height="50px">
					<span class="notification red"><?php echo $preview['sumjobs']; ?></span>
				</a>
				<p class="smooth"><span class="glyphicon glyphicon-map-marker"></span> <?php echo $preview['company_location']; ?></p>
				<p class="smooth"><span class="glyphicon glyphicon-home"></span> <?php echo $preview['company_address']; ?></p>
				<a href="<?php echo prep_url($preview['company_website']); ?>" target="_blank"><p class="smooth"><span class="glyphicon glyphicon-link"></span> <?php echo $preview['company_website']; ?></p></a>
				<p><?php echo $preview['company_shortdesc']; ?></p>
				<?php 
				  if(!empty($preview['company_longitude']) && !empty($preview['company_latitude'])) {
				  ?>
				  <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
				  <script type="text/javascript">
					var infowindow = null;
						$(document).ready(function () { initialize(); });

						function initialize() {

							var centerMap = new google.maps.LatLng(<?php echo $preview['company_latitude']; ?>,<?php echo $preview['company_longitude']; ?>);

							var myOptions = {
								zoom: 9,
								center: centerMap,
								mapTypeId: google.maps.MapTypeId.MAPS
							}

							var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

							setMarkers(map, sites);
						infowindow = new google.maps.InfoWindow({
									content: "loading..."
								});
						}

						var sites = [
						['<?php echo $preview['company_name']; ?>', <?php echo $preview['company_latitude']; ?>,<?php echo $preview['company_longitude']; ?>, <?php echo $preview['company_id']; ?>, '<?php echo $preview['company_name']; ?>']
						];



						function setMarkers(map, markers) {

							for (var i = 0; i < markers.length; i++) {
								var sites = markers[i];
								var siteLatLng = new google.maps.LatLng(sites[1], sites[2]);
								var marker = new google.maps.Marker({
									position: siteLatLng,
									map: map,
									title: sites[0],
									zIndex: sites[3],
									html: sites[4]
								});

								var contentString = "Some content";

								

								google.maps.event.addListener(marker, "click", function () {
									infowindow.setContent(this.html);
									infowindow.open(map, this);
								});
							}
						}
				  </script>
				  <p><div id="map_canvas" style="width:100%; height: 200px;"></div></p>
				  <?php 
				  }
				  ?>
			</div>
			<div class="panel-footer">
				<p class="smooth"><span class="glyphicon glyphicon-phone-alt"></span> <?php echo $preview['company_phone']; ?></p>
				<p class="smooth"><span class="glyphicon glyphicon-envelope"></span> <?php echo $preview['company_email']; ?></p>
			</div>
		  </div>
		  
		  <?php	
				}
			?>
		  <?php 
			if($related->num_rows() > 0){
			?> 
		  <div class="panel panel-default">
			<div class="panel-heading">
				<?php echo lang('company_openings'); ?>
			</div>
			<div class="panel-body">
			<table class="table table-hover">
			  <tbody>
			  <?php
						foreach($related->result_array() as $rows){
			  ?>
			  <tr>
				<td><a href="<?php echo base_url().'home/detail/'.$rows['job_id'].'/'.url_title($rows['job_name']); ?>"><img src="<?php echo $rows['company_logo']; ?>" width="50px" height="50px"></a></td>
				<td><a href="<?php echo base_url().'home/detail/'.$rows['job_id'].'/'.url_title($rows['job_name']); ?>"><b><?php echo $rows['job_name']; ?></b></a><br><p class="smooth"><?php echo $rows['company_name']; ?></p></td>
			  </tr>	
				<?php } ?>
			  </tbody>
			</table>
			</div>
			<div class="panel-footer">
				<a href="<?php echo base_url().'home/company/'.$preview['company_id'].'/'.url_title($preview['company_name']); ?>"><p class="smooth"><?php echo lang('see_all_openings_of_this_company'); ?></p></a>
			</div>
		  </div>
			<?php
			}
			?>

        </div>
       
    </div>
        

</div><!-- /.container -->
