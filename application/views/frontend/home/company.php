<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<div class="container">
      <div class="row row-offcanvas row-offcanvas-right">
		  
		<div class="col-md-12">
            
        <div class="col-md-8">
		  <?php
			echo $panel;
		  ?>
		  
		  <?php if(count($company)){
		  ?>
		  <div class="panel panel-default">
			  <div class="panel-heading">
                   <p><h4 class="head-text"><b><?php echo $company['company_name']; ?></b><div class="pull-right"><span class="label label-info"><?php echo $company['company_website']; ?></div></h4></p>
              </div>
			  <div class="panel-body">
		  <table class="table table-hover">
		  <tbody>
		  <tr>
			<td><b><?php echo lang('location'); ?></b></td>
			<td><?php echo $company['company_location']; ?></td>
		  </tr>
		  <tr>
			<td><b><?php echo lang('company_address'); ?></b></td>
			<td><?php echo $company['company_address']; ?></td>
		  </tr>
		  <tr>
			<td><b><?php echo lang('description'); ?></b></td>
			<td><?php echo $company['company_desc']; ?></td>
		  </tr>
		  <?php 
		  if(!empty($company['company_longitude']) && !empty($company['company_latitude'])) {
		  ?>
		  <script type="text/javascript">
			var infowindow = null;
				$(document).ready(function () { initialize(); });

				function initialize() {

					var centerMap = new google.maps.LatLng(<?php echo $company['company_latitude']; ?>,<?php echo $company['company_longitude']; ?>);

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
				['<?php echo $company['company_name']; ?>', <?php echo $company['company_latitude']; ?>,<?php echo $company['company_longitude']; ?>, <?php echo $company['company_id']; ?>, '<?php echo $company['company_name']; ?>']
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
		  <tr>
			<td><b><?php echo lang('maps'); ?></b></td>
			<td><div id="map_canvas" style="width:100%; height: 300px;"></div></td>
		  </tr>
		  <?php } ?>	
		  </tbody>
		  </table>
		  </div>
		  </div>
		  
		  <?php if($sql->num_rows() > 0){
		  ?>
		  <div class="panel panel-default">
			  <div class="panel-heading">
                   <p><h4 class="head-text"><b><?php echo $total; ?></b> <?php echo lang('openings_by'); ?> <?php echo $company['company_name']; ?></h4></p>
              </div>
			  <div class="panel-body">
		  <table class="table table-hover">
		  <tbody>
		  <?php
					foreach($sql->result_array() as $row){
		  ?>
		  <tr>
			<td><a href="<?php echo base_url().'home/detail/'.$row['job_id'].'/'.url_title($row['job_name']); ?>"><img src="<?php echo $row['company_logo']; ?>" width="50px" height="50px"></a></td>
			<td><a href="<?php echo base_url().'home/detail/'.$row['job_id'].'/'.url_title($row['job_name']); ?>"><b><?php echo $row['job_name']; ?></b></a><br><p class="smooth"><?php echo $row['company_name']; ?></p></td>
			<td><span class="label <?php echo url_title($row['category_name']); ?>"><?php echo $row['category_name']; ?></span></td>
			<td class="smooth"><span class="glyphicon glyphicon-map-marker"></span> <?php echo $row['city_name']; ?></td>
		  </tr>	
			<?php } ?>
		  </tbody>
		  </table>
		  </div>
		  </div>
		  <?php
				}
			?>
			
		<?php echo $this->pagination->create_links(); ?>

        </div>

		<div class="col-md-4">
        
		  <div class="panel panel-default">
			<div class="panel-heading">
				<h5 class="head-text"><b><?php echo $company['company_name']; ?></b></h5>
			</div>
			<div class="panel-body">
				<a title="<?php echo $company['total']; ?> opening jobs." class="well top-block" href="<?php echo base_url().'home/company/'.$company['company_id'].'/'.url_title($company['company_name']); ?>">
					<img src="<?php echo $company['company_logo']; ?>" width="50px" height="50px">
					<span class="notification red"><?php echo $company['total']; ?></span>
				</a>
				<p class="smooth"><span class="glyphicon glyphicon-map-marker"></span> <?php echo $company['company_location']; ?></p>
				<p class="smooth"><span class="glyphicon glyphicon-home"></span> <?php echo $company['company_address']; ?></p>
				<a href="<?php echo prep_url($company['company_website']); ?>" target="_blank"><p class="smooth"><span class="glyphicon glyphicon-link"></span> <?php echo $company['company_website']; ?></p></a>
				<p><?php echo $company['company_shortdesc']; ?></p>
			</div>
			<div class="panel-footer">
				<p class="smooth"><span class="glyphicon glyphicon-phone-alt"></span> <?php echo $company['company_phone']; ?></p>
				<p class="smooth"><span class="glyphicon glyphicon-envelope"></span> <?php echo $company['company_email']; ?></p>
			</div>
		  </div>
		  
		  <?php } ?>
		  
		  <?php 
			if($count->num_rows() > 0){
		  ?> 
		  <div class="panel panel-default">
			<div class="panel-heading">
				<?php echo lang('other_companies'); ?>
			</div>
			<div class="panel-body">
			<?php 
				foreach($count->result_array() as $rows){	
			?>
				<a title="<?php echo $rows['total']; ?> opening jobs." class="well top-block" href="<?php echo base_url().'home/company/'.$rows['company_id'].'/'.url_title($rows['company_name']); ?>">
					<img src="<?php echo $rows['company_logo']; ?>" width="50px" height="50px">
					<div><?php echo $rows['company_name']; ?></div>
					<span class="notification red"><?php echo $rows['total']; ?></span>
				</a>
			<?php 
				}
			?>
			</div>
			<?php
			}
			?>
		  </div>

        </div>
       
    </div>
        

</div><!-- /.container -->
