		<?php
			if($person){
		?>
		
		<div class="panel panel-info">
			  <div class="panel-heading">
                   <p><h4 class="head-text"><b><?php echo $person['name']; ?></h4></p>
              </div>
			  <div class="panel-body">
			  <div class="col-md-4">
					<img class="img-responsive thumbnail" src="<?php echo !empty($person['photo']) ? $person['photo'] : base_url().'assets/photo/no_person.jpg'; ?>" alt="<?php echo $person['name'] ?>">
			  </div>
			  <div class="col-md-8">
					<div class="list-group">
						  <a href="<?php echo base_url().'person/account/'; ?>" class="list-group-item"><span class="glyphicon glyphicon-user"></span> <?php echo lang('my_account'); ?></a>
						  <a href="<?php echo base_url().'person/jobalert/'; ?>" class="list-group-item"><span class="glyphicon glyphicon-bell"></span> <?php echo lang('job_alert'); ?></a>
						  <a href="<?php echo base_url().'person/cv/'; ?>" class="list-group-item"><span class="glyphicon glyphicon-list-alt"></span> <?php echo lang('preview_resume'); ?></a>
						  <a href="<?php echo base_url().'person/application/'; ?>" class="list-group-item"><span class="glyphicon glyphicon-check"></span> <?php echo lang('application_status'); ?></a>
						  <a href="<?php echo base_url().'person/aot/'; ?>" class="list-group-item"><span class="glyphicon glyphicon-list"></span> Online Test <span class="badge pull-right"><?php echo $this->session->userdata('useraot'); ?></span></a>
						  <a href="<?php echo base_url().'person/aoi/'; ?>" class="list-group-item"><span class="glyphicon glyphicon-facetime-video"></span> Online Interview <span class="badge pull-right"><?php echo $this->session->userdata('useraoi'); ?></span></a>
					</div>
			  </div>
				  
			  </div>
	      </div>
		 <?php 
			}
		 ?>
		 
		<?php
			if($companies){
		?>
		
		<div class="panel panel-info">
			  <div class="panel-heading">
                   <p><h4 class="head-text"><b><?php echo $companies['company_account_name']; ?></h4></p>
              </div>
			  <div class="panel-body">
				  <table class="table table-responsive">
				  <tbody>
				  <tr>
					<td>
						<div class="list-group">
						  <a href="<?php echo base_url().'company/profile/'; ?>" class="list-group-item"><span class="glyphicon glyphicon-th-large"></span> <?php echo lang('account_&_profile'); ?></a>
						  <a href="<?php echo base_url().'company/post/'; ?>" class="list-group-item"><span class="glyphicon glyphicon-folder-open"></span> <?php echo lang('post_job'); ?></a>
						  <a href="<?php echo base_url().'company/jobs/'; ?>" class="list-group-item"><span class="glyphicon glyphicon-briefcase"></span> <?php echo lang('manage_jobs'); ?></a>
						  <a href="<?php echo base_url().'company/applicants/'; ?>" class="list-group-item"><span class="glyphicon glyphicon-user"></span> <?php echo lang('manage_applicants'); ?></a>
						  <a href="<?php echo base_url().'company/search/'; ?>" class="list-group-item"><span class="glyphicon glyphicon-search"></span> <?php echo lang('search').' '.lang('applicants'); ?></a>
						  <a href="<?php echo base_url().'company/export/'; ?>" class="list-group-item"><span class="glyphicon glyphicon-hdd"></span> Export</a>
						  <a href="<?php echo base_url().'company/news/'; ?>" class="list-group-item"><span class="glyphicon glyphicon-book"></span> <?php echo lang('news'); ?></a>
						  <a href="<?php echo base_url().'company/email/'; ?>" class="list-group-item"><span class="glyphicon glyphicon-envelope"></span> <?php echo lang('send_email'); ?></a>
						  <a href="<?php echo base_url().'company/aot/'; ?>" target="_blank" class="list-group-item"><span class="glyphicon glyphicon-list"></span> Admin AOT</a>
						  <a href="<?php echo base_url().'company/aoi/'; ?>" class="list-group-item"><span class="glyphicon glyphicon-facetime-video"></span> Online Interview <span class="badge pull-right"><?php echo $this->session->userdata('company_account_aoi'); ?></span></a>
					    </div>
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
			  <div class="panel-body searchbar">
				<form class="form-inline" role="form" action="<?php echo $search; ?>" method="post">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
				<div class="form-group">
				<label class="sr-only" for="inputKeyword"><?php echo lang('keyword'); ?></label>
				<input type="text" class="form-control" id="inputKeyword" name="keyword" placeholder="<?php echo lang('keyword'); ?>" value="<?php echo set_value('keyword', isset($keyword) ? $keyword : ''); ?>">
				</div>
				<div class="form-group">
				<label class="sr-only" for="inputCompany"><?php echo lang('company'); ?></label>
				<input type="text" class="form-control" id="inputCompany" name="company" placeholder="<?php echo lang('company'); ?>" value="<?php echo set_value('company', isset($company) && !is_array($company) ? $company : ''); ?>">
				</div>
				<button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-search"></span> <?php echo lang('search'); ?></button>
				</form>
			  </div>
			  <div class="panel-footer">
				<div class="btn-group">
				  <a href="<?php echo base_url().'home/search/Fresh-Graduate'; ?>" id="graduate-btn" class="btn btn-info popovers" data-container="body" data-original-title="Fresh Graduate" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-html="true" data-content="<?php echo lang('fresh_graduate'); ?>">Fresh Graduate</a>
				  <a href="<?php echo base_url().'home/search/Junior'; ?>" id="junior-btn" class="btn btn-primary popovers" data-container="body" data-original-title="Junior" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-html="true" data-content="<?php echo lang('junior'); ?>">Junior</a>
				  <a href="<?php echo base_url().'home/search/Middle'; ?>" id="middle-btn" class="btn btn-warning popovers" data-container="body" data-original-title="Middle" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-html="true" data-content="<?php echo lang('middle'); ?>">Middle</a>
				  <a href="<?php echo base_url().'home/search/Senior'; ?>" id="senior-btn" class="btn btn-danger popovers" data-container="body" data-original-title="Senior" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-html="true" data-content="<?php echo lang('senior'); ?>">Senior</a>
				  <a href="<?php echo base_url().'home/search/Evergreen'; ?>" id="evergreen-btn" class="btn btn-success popovers" data-container="body" data-original-title="Evergreen" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-html="true" data-content="<?php echo lang('evergreen'); ?>">Evergreen</a>
				</div>
				<div class="clearfix">
				<?php 
					if(isset($catdesc)){
						echo "<p class=\"text-muted\">".lang($catdesc)."</p>";
					}
				?>
				</div>
			  </div>
	      </div>
