<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
			if(isset($meta['job_name']) && !empty($meta['job_name'])){
				echo '<meta name="description" content="Portal Rekrutmen '.$meta['company_name'].' '.$meta['job_name'].'">';
				echo '<meta name="keywords" content="rekrutmen,karir,lowongan kerja,loker,pekerjaan,'.$meta['company_name'].','.$meta['job_name'].'">';
			} elseif(isset($meta['company_name']) && !empty($meta['company_name'])){
				echo '<meta name="description" content="Portal Rekrutmen '.$meta['company_name'].'">';
				echo '<meta name="keywords" content="rekrutmen,karir,lowongan kerja,loker,pekerjaan,'.$meta['company_name'].'">';
			} elseif(isset($meta['name']) && !empty($meta['name'])){
				echo '<meta name="description" content="Portal Rekrutmen '.$meta['name'].'">';
				echo '<meta name="keywords" content="rekrutmen,karir,lowongan kerja,loker,pekerjaan,'.$meta['name'].'">';
			} else {
				echo '<meta name="description" content="Portal Rekrutmen PT Brantas Abipraya">';
				echo '<meta name="keywords" content="rekrutmen,karir,lowongan kerja,loker,pekerjaan">';
			}
	?> 
    <meta name="author" content="PT Brantas Abipraya">
    <meta content="7" name="revisit-after"/>
    <meta content="id, en" name="language"/>
    <meta content="id" name="geo.country"/>
    <meta content="Indonesia" name="geo.placename"/>
    <meta content="all-language" http-equiv="Content-Language"/>
    <meta content="global" name="Distribution"/>
    <meta content="global" name="target"/>
    <meta content="Indonesia" name="geo.country"/>
    <meta content="all" name="robots"/>
    <meta content="all" name="googlebot"/>
    <meta content="all" name="msnbot"/>
    <meta content="all" name="Googlebot-Image"/>
    <meta content="all" name="Slurp"/>
    <meta content="all" name="ZyBorg"/>
    <meta content="all" name="Scooter"/>
    <meta content="all" name="spiders"/>
    <meta name="webcrawlers" content="all" />
    <meta content="true" name="MSSmartTagsPreventParsing"/>
    <meta content="general" name="rating"/>
    <link rel="icon" href="<?php echo base_url(); ?>images/brantas.png" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo base_url(); ?>images/brantas.png" type="image/x-icon" />

    <title>
		<?php 
			if(isset($meta['job_name']) && !empty($meta['job_name'])){
				echo $this->config->item("web_title").' - '.$meta['job_name'].' - '.$meta['company_name'];
			} elseif(isset($meta['company_name']) && !empty($meta['company_name'])){
				echo $this->config->item("web_title").' - '.$meta['company_name'];
			} elseif(isset($meta['name']) && !empty($meta['name'])){
				echo $this->config->item("web_title").' - '.$meta['name'];
			} else {
				echo $this->config->item("web_title");
			}
		?> 
    </title>

    <link href="<?php echo base_url(); ?>assets/frontend/css/animate.css" rel="stylesheet">
    
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>assets/frontend/twbs/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/frontend/twbs/css/base.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/frontend/twbs/plugins/datepicker/css/datepicker3.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/twbs/plugins/wysihtml5/dist/bootstrap-wysihtml5.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/twbs/plugins/bootstrapselect/bootstrap-select.min.css" />
    
	<!-- JavaScript -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/twbs/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/twbs/js/bootstrap.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/twbs/plugins/datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/twbs/plugins/wysihtml5/lib/js/wysihtml5-0.3.0.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/twbs/plugins/wysihtml5/dist/bootstrap3-wysihtml5.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/twbs/plugins/bootstrapselect/bootstrap-select.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/frontend/twbs/plugins/printelement/jquery.print.element.min.js"></script>
    <script>
	$(document).ready(function(){
		var root = '<?php echo base_url(); ?>';
		$('#myModal').on('hidden.bs.modal', function() {
			$(this).removeData('bs.modal');
		});
		$('#toprint').click(function(){
			printElem({});	
		});
		
		$('.popovers').popover();
		
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			todayHighlight: true
		});
		$('#company-forgot-password').click(function(e){
			$('#CompanyLogin').modal('hide');
			$('#CompanyForgot').modal('show');
		});
		$('#person-forgot-password').click(function(e){
			$('#PersonLogin').modal('hide');
			$('#PersonForgot').modal('show');
		});
	});
	function printElem(options){
		$('.toprint').printElement(options);
	}
	</script>
	
  </head>
  <body>

    <div class="navbar navbar-fixed-top navbar-default" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo base_url(); ?>"><span class="glyphicon glyphicon-asterisk"></span> <?php echo $this->config->item("web_title");?></a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="<?php echo base_url(); ?>"><?php echo lang('home'); ?></a></li>
            <li><a href="<?php echo base_url().'home/news'; ?>"><?php echo lang('news'); ?></a></li>
            <li><a href="<?php echo base_url().'home/userguide'; ?>" class="animated flash"><b>User Guide</b></a></li>
            <li><a href="<?php echo base_url().'home/contact'; ?>">Contact</a></li>
            
          </ul>
          
          <?php
            $user_id = $this->session->userdata("user_id");
            $company_id = $this->session->userdata("company_account_id");
			if(isset($user_id) && !empty($user_id)){
          ?>
          
          <ul class="nav navbar-nav navbar-right">
		  <li class="dropdown">
			<a href="javascript:void()" class="dropdown-toggle" data-toggle="dropdown">
				<?php echo $this->session->userdata('global_language') == 'indonesia' ? 'Bahasa Indonesia' : 'English Language' ; ?> <span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
			  <li><a href="<?php echo base_url().'home/setlang/indonesia'; ?>"> Bahasa Indonesia</a></li>
			  <li><a href="<?php echo base_url().'home/setlang/english'; ?>"> English Language</a></li>
			</ul>
		  </li>
		  <li class="dropdown">
			<a href="javascript:void()" class="dropdown-toggle" data-toggle="dropdown">
				<span class="glyphicon glyphicon-user"></span> <?php echo $this->session->userdata('name'); ?> <span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
			  <li><a href="<?php echo base_url().'person/account/'; ?>"><span class="glyphicon glyphicon-user"></span> <?php echo lang('my_account'); ?></a></li>
			  <li class="divider"></li>	
			  <li><a href="<?php echo base_url().'person/jobalert/'; ?>"><span class="glyphicon glyphicon-bell"></span> <?php echo lang('job_alert'); ?></a></li>
			  <li><a href="<?php echo base_url().'person/cv/'; ?>"><span class="glyphicon glyphicon-list-alt"></span> <?php echo lang('preview_resume'); ?></a></li>
			  <li><a href="<?php echo base_url().'person/application/'; ?>"><span class="glyphicon glyphicon-check"></span> <?php echo lang('application_status'); ?></a></li>
			  <li><a href="<?php echo base_url().'person/aot/'; ?>"><span class="glyphicon glyphicon-list"></span> Online Test </a></li>		  
			  <li><a href="<?php echo base_url().'person/aoi/'; ?>"><span class="glyphicon glyphicon-facetime-video"></span> Online Interview </a></li>		  
			  <li class="divider"></li>			  
			  <li><a href="<?php echo base_url().'person/logout/'; ?>"><span class="glyphicon glyphicon-remove"></span> <?php echo lang('logout'); ?></a></li>
			</ul>
		  </li>
		  </ul>
		  
          <?php 
			} elseif (isset($company_id) && !empty($company_id)){
		  ?>		
          
          <ul class="nav navbar-nav navbar-right">
		  <li class="dropdown">
			<a href="javascript:void()" class="dropdown-toggle" data-toggle="dropdown">
				<?php echo $this->session->userdata('global_language') == 'indonesia' ? 'Bahasa Indonesia' : 'English Language' ; ?> <span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
			  <li><a href="<?php echo base_url().'home/setlang/indonesia'; ?>"> Bahasa Indonesia</a></li>
			  <li><a href="<?php echo base_url().'home/setlang/english'; ?>"> English Language</a></li>
			</ul>
		  </li>
		  <li class="dropdown">
			<a href="javascript:void()" class="dropdown-toggle" data-toggle="dropdown">
				<span class="glyphicon glyphicon-th-large"></span> <?php echo $this->session->userdata('company_account_name'); ?> <span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
			  <li><a href="<?php echo base_url().'company/profile/'; ?>"><span class="glyphicon glyphicon-th-large"></span> <?php echo lang('account_&_profile'); ?></a></li>
			  <li class="divider"></li>	
			  <li><a href="<?php echo base_url().'company/post/'; ?>"><span class="glyphicon glyphicon-folder-open"></span> <?php echo lang('post_job'); ?></a></li>
			  <li><a href="<?php echo base_url().'company/jobs/'; ?>"><span class="glyphicon glyphicon-briefcase"></span> <?php echo lang('manage_jobs'); ?></a></li>
			  <li><a href="<?php echo base_url().'company/applicants/'; ?>"><span class="glyphicon glyphicon-user"></span> <?php echo lang('manage_applicants'); ?></a></li>
			  <li><a href="<?php echo base_url().'company/search/'; ?>"><span class="glyphicon glyphicon-search"></span> <?php echo lang('search').' '.lang('applicants'); ?></a></li>
			  <li><a href="<?php echo base_url().'company/export/'; ?>"><span class="glyphicon glyphicon-hdd"></span> Export</a></li>
			  <li><a href="<?php echo base_url().'company/news/'; ?>"><span class="glyphicon glyphicon-book"></span> <?php echo lang('news'); ?></a></li>
			  <li><a href="<?php echo base_url().'company/email/'; ?>"><span class="glyphicon glyphicon-envelope"></span> <?php echo lang('send_email'); ?></a></li>
			  <li><a href="<?php echo base_url().'company/aot/'; ?>" target="_blank"><span class="glyphicon glyphicon-list"></span> Admin AOT</a></li>
			  <li><a href="<?php echo base_url().'company/aoi/'; ?>"><span class="glyphicon glyphicon-facetime-video"></span> Online Interview</a></li>
			  <li class="divider"></li>			  
			  <li><a href="<?php echo base_url().'company/logout/'; ?>"><span class="glyphicon glyphicon-remove"></span> <?php echo lang('logout'); ?></a></li>
			</ul>
		  </li>
		  </ul>
          
          <?php 
			} else {
		  ?>
          
          <ul class="nav navbar-nav navbar-right">
		  <li class="dropdown">
			<a href="javascript:void()" class="dropdown-toggle" data-toggle="dropdown">
				<?php echo $this->session->userdata('global_language') == 'indonesia' ? 'Bahasa Indonesia' : 'English Language' ; ?> <span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
			  <li><a href="<?php echo base_url().'home/setlang/indonesia'; ?>"> Bahasa Indonesia</a></li>
			  <li><a href="<?php echo base_url().'home/setlang/english'; ?>"> English Language</a></li>
			</ul>
		  </li>
		  <li class="dropdown">
			<a href="javascript:void()" class="dropdown-toggle" data-toggle="dropdown" data-toggle="dropdown">
				<span class="glyphicon glyphicon-user"></span> <?php echo lang('job_seeker'); ?><span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
			  <li><a href="javascript:void(0)" data-toggle="modal" data-target="#PersonLogin"><?php echo lang('login'); ?></a></li>
			  <li><a data-toggle="modal" href="<?php echo base_url().'person/register'; ?>" data-target="#myModal"><?php echo lang('register'); ?></a></li>
			</ul>
		  </li>
		  <!--<li class="dropdown">
			<a href="javascript:void()" class="dropdown-toggle" data-toggle="dropdown" data-toggle="dropdown">
				<span class="glyphicon glyphicon-th-large"></span> <?php echo lang('company'); ?><span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
			  <li><a href="javascript:void(0)" data-toggle="modal" data-target="#CompanyLogin"><?php echo lang('login'); ?></a></li>
			</ul>
		  </li>-->
		  </ul>
		  
		  <?php 
			}
		  ?>
		  
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </div><!-- /.navbar -->

<div class="modal fade" id="PersonLogin" tabindex="-1" role="dialog" aria-labelledby="PersonLogin" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user"></span> <?php echo lang('job_seeker'); ?> <?php echo lang('login'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" id="jobseeker-login-form" accept-charset="utf-8" method="post" action="<?php echo base_url().'person/ceklogin'; ?>">
		  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		  <div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
			<div class="col-sm-10">
			  <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email">
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputPassword3" class="col-sm-2 control-label">Password</label>
			<div class="col-sm-10">
			  <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password">
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <div class="checkbox">
				<label>
				  <input name="remember_me" type="checkbox"> <?php echo lang('remember_me'); ?>
				</label>
			  </div>
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <input type="submit" class="btn btn-primary" value="<?php echo lang('login'); ?>" />
			  <a id="person-forgot-password" class="btn btn-warning"><?php echo lang('forgot_password'); ?></a>
			</div>
		  </div>
		</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="PersonForgot" tabindex="-1" role="dialog" aria-labelledby="PersonForgot" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user"></span> <?php echo lang('job_seeker'); ?> <?php echo lang('forgot_password'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" accept-charset="utf-8" method="post" action="<?php echo base_url().'person/cekforgot'; ?>">
		  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		  <div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
			<div class="col-sm-10">
			  <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email">
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <button type="submit" class="btn btn-danger">Reset Password</button>
			</div>
		  </div>
		</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    
<div class="modal fade" id="CompanyLogin" tabindex="-1" role="dialog" aria-labelledby="CompanyLogin" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	  <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><span class="glyphicon glyphicon-th-large"></span> <?php echo lang('company'); ?> <?php echo lang('login'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" id="company-login-form" accept-charset="utf-8" method="post" action="<?php echo base_url().'company/ceklogin'; ?>">
		  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		  <div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label">Username / Email</label>
			<div class="col-sm-10">
			  <input type="text" name="company_account_email" class="form-control" id="inputEmail3" placeholder="Username/Email">
			</div>
		  </div>
		  <div class="form-group">
			<label for="inputPassword3" class="col-sm-2 control-label">Password</label>
			<div class="col-sm-10">
			  <input type="password" name="company_account_password" class="form-control" id="inputPassword3" placeholder="Password">
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <div class="checkbox">
				<label>
				  <input name="remember_me" type="checkbox"> <?php echo lang('remember_me'); ?>
				</label>
			  </div>
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <input type="submit" class="btn btn-primary" value="<?php echo lang('login'); ?>" />
			  <a id="company-forgot-password" class="btn btn-warning"><?php echo lang('forgot_password'); ?></a>
			</div>
		  </div>
		</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="CompanyForgot" tabindex="-1" role="dialog" aria-labelledby="CompanyForgot" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-th-large"></span> <?php echo lang('company'); ?> <?php echo lang('forgot_password'); ?></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" accept-charset="utf-8" method="post" action="<?php echo base_url().'company/cekforgot'; ?>">
		  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		  <div class="form-group">
			<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
			<div class="col-sm-10">
			  <input type="email" name="company_account_email" class="form-control" id="inputEmail3" placeholder="Email">
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			  <button type="submit" class="btn btn-danger">Reset Password</button>
			</div>
		  </div>
		</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
