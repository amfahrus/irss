<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<div class="container">
      <div class="row row-offcanvas row-offcanvas-right">
		
		<?php
			if($company_account){
		?>
		
		<div class="panel panel-default">
			  <div class="panel-heading">
                   <p><h4 class="head-text"><b>Password <span class="pull-right"><a href="<?php echo base_url().'company/edit_password/'; ?>"><span class="glyphicon glyphicon-edit"></span> Edit</a></span></h4></p>
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
                   <p><h4 class="head-text"><b><?php echo lang('account'); ?> <span class="pull-right"><a href="<?php echo base_url().'company/edit_account/'; ?>"><span class="glyphicon glyphicon-edit"></span> Edit</a></span></h4></p>
              </div>
			  <div class="panel-body">
				  <table class="table table-responsive">
				  <tbody>
				  <tr>
					<td>
						<?php echo lang('account_username'); ?>
					</td>
					<td>
						<?php echo !empty($company_account['company_account_username']) ? $company_account['company_account_username'] : '-' ; ?>
					</td>
				  </tr>
				  <tr>
					<td>
						<?php echo lang('account_name'); ?>
					</td>
					<td>
						<?php echo !empty($company_account['company_account_name']) ? $company_account['company_account_name'] : '-' ; ?>
					</td>
				  </tr>
				  <tr>
					<td>
						Email
					</td>
					<td>
						<?php echo !empty($company_account['company_account_email']) ? $company_account['company_account_email'] : '-' ; ?>
					</td>
				  </tr>
				   </tbody>
				  </table>
			  </div>
	      </div>
	      
		 <?php 
			}
		 ?>

	      <?php 
	      if($sql->num_rows() > 0){
		  ?>
		  <div class="panel panel-default">
			  <div class="panel-heading">
                   <p><h4 class="head-text"><?php echo lang('companies'); ?> <span class="pull-right"><a href="<?php echo base_url().'company/add_profile/'; ?>"><span class="glyphicon glyphicon-edit"></span> <?php echo lang('add'); ?></a></span></h4></p>
              </div>
			  <div class="panel-body">
		  <table class="table table-hover">
		  <tbody>
		  <?php
					foreach($sql->result_array() as $row){
		  ?>
		  <tr>
			<td><a href="<?php echo base_url().'company/edit_profile/'.$row['company_id'].'/'.url_title($row['company_name']); ?>"><img src="<?php echo $row['company_logo']; ?>" width="50px" height="50px"></a></td>
			<td><a href="<?php echo base_url().'company/edit_profile/'.$row['company_id'].'/'.url_title($row['company_name']); ?>"><b><?php echo $row['company_name']; ?></b></a><br><p class="smooth"><?php echo $row['company_phone']; ?></p></td>
			<td><span class="smooth"><?php echo $row['industry_name']; ?></span></td>
			<td class="smooth"><span class="glyphicon glyphicon-map-marker"></span> <?php echo $row['company_location']; ?></td>
			<td>
				<a href="<?php echo base_url().'company/edit_profile/'.$row['company_id'].'/'.url_title($row['company_name']); ?>"><span class="glyphicon glyphicon-edit"></span> Edit</a> |
				<a href="<?php echo base_url().'company/delete_profile/'.$row['company_id'].'/'.url_title($row['company_name']); ?>" onclick="return confirm('Are you sure you wish to delete this data? This cannot be undone.');"><span class="glyphicon glyphicon-trash"></span> <?php echo lang('delete'); ?></a>
			</td>
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
        

</div><!-- /.container -->
