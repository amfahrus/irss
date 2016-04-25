<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script>
        function initializeMap() {

			var centerMap = new google.maps.LatLng(-6.240524,106.877515);
			var markersArray = [];

			var myOptions = {
				zoom: 9,
				center: centerMap,
				mapTypeId: google.maps.MapTypeId.MAP
			}

			var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
			
			google.maps.event.addListener(map, 'click', function (e) {
				$("#lat").val(e.latLng.lat().toFixed(6));
				$("#long").val(e.latLng.lng().toFixed(6));
				placeMarker(e.latLng);
			 });
			 
			 function placeMarker(location) {
				// first remove all markers if there are any
				deleteOverlays();

				var marker = new google.maps.Marker({
					position: location, 
					map: map
				});

				// add marker in markers array
				markersArray.push(marker);

				//map.setCenter(location);
			}

			// Deletes all markers in the array by removing references to them
			function deleteOverlays() {
				if (markersArray) {
					for (i in markersArray) {
						markersArray[i].setMap(null);
					}
				markersArray.length = 0;
				}
			}

		};
        $(document).ready(function() {
			initializeMap();
			$('textarea').wysihtml5();
		});
</script>
<div class="container">
      <div class="row row-offcanvas row-offcanvas-right">
		  
<div class="panel panel-default">
	  <div class="panel-heading">
        <h4><span class="glyphicon glyphicon-th-large"></span> <?php echo lang('company_profile'); ?></h4>
      </div>
      <div class="panel-body">
        <form class="form-horizontal" role="form" accept-charset="utf-8" enctype="multipart/form-data" method="post" action="<?php echo $act; ?>">
		  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('company_name'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" name="company_name" class="form-control" placeholder="<?php echo lang('company_name'); ?>" value="<?php echo $company['company_name']; ?>">
			  <?php echo form_error('company_name','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		   <div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label"><?php echo lang('company_email'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="email" name="company_email" class="form-control" id="inputEmail3" placeholder="Email" value="<?php echo $company['company_email']; ?>">
			  <?php echo form_error('company_email','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('company_logo'); ?></label>
			<div class="col-sm-10">
			  <input type="file" name="company_logo">
			  <div class="help-block"><?php echo lang('max_3mb_with_only_jpg,_gif,_png_extension'); ?></div>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('company_banner'); ?></label>
			<div class="col-sm-10">
			  <input type="file" name="company_banner">
			  <div class="help-block"><?php echo lang('max_10mb_with_only_jpg,_gif,_png_extension'); ?></div>
			</div>
		  </div>
		  
		 <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('company_location'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" name="company_location" class="form-control" placeholder="<?php echo lang('company_location'); ?>" value="<?php echo $company['company_location']; ?>">
			  <?php echo form_error('company_location','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('map'); ?></label>
			<div class="col-sm-10">
			  <div id="map_canvas" style="width: 100%; height: 250px;"></div>
			  <div class="input-group">
			  <input type="text" id="long" name="company_longitude" class="form-control" placeholder="Longitude" value="<?php echo $company['company_longitude']; ?>">
			  <span class="input-group-addon"></span>
			  <input type="text" id="lat" name="company_latitude" class="form-control" placeholder="Latitude" value="<?php echo $company['company_latitude']; ?>">
			  </div>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('company_address'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <textarea class="form-control" rows="3" name="company_address" placeholder="<?php echo lang('company_address'); ?>"><?php echo $company['company_address']; ?></textarea>
			  <?php echo form_error('company_address','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('company_short_description'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <textarea class="form-control" rows="3" name="company_shortdesc" placeholder="<?php echo lang('company_short_description'); ?>"><?php echo $company['company_shortdesc']; ?></textarea>
			  <?php echo form_error('company_shortdesc','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('company_long_description'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <textarea class="form-control" rows="5" name="company_desc" placeholder="<?php echo lang('company_long_description'); ?>"><?php echo $company['company_desc']; ?></textarea>
			  <?php echo form_error('company_desc','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('company_industry'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <select name="company_industry" class="form-control edu-major">
				<?php 
					if($industry->num_rows() > 0){
						foreach($industry->result_array() as $industries){
				?>
					 <option value="<?php echo $industries['industry_id']; ?>" <?php echo $industries['industry_id'] == $company['industry_id'] ? 'selected' : ''; ?>><?php echo $industries['industry_name']; ?></option>
				<?php 
						}
					}
				?>
			  </select>
			  <?php echo form_error('company_industry','<div class="alert alert-danger">', '</div>'); ?>	
			  </div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('company_phone'); ?> <span class="important">*</span></label>
			<div class="col-sm-10">
			  <input type="text" name="company_phone" class="form-control" placeholder="<?php echo lang('company_phone'); ?>" value="<?php echo $company['company_phone']; ?>">
			  <?php echo form_error('company_phone','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="col-sm-2 control-label"><?php echo lang('company_website'); ?></label>
			<div class="col-sm-10">
			  <input type="text" name="company_website" class="form-control" placeholder="<?php echo lang('company_website'); ?>" value="<?php echo $company['company_website']; ?>">
			  <?php echo form_error('company_website','<div class="alert alert-danger">', '</div>'); ?>
			</div>
		  </div>
		  
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <button type="submit" class="btn btn-danger"><?php echo lang('update'); ?></button>
			  <a href="<?php echo base_url().'company/profile/'; ?>" class="btn btn-warning"><?php echo lang('cancel'); ?></a>
			</div>
		  </div>
		</form>
      </div>
  </div>
  
</div>
        

</div><!-- /.container -->
