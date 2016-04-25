<!-- topbar starts -->
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="<?php echo base_url() ?>">e-Recruitment</a>
				
				<!-- user dropdown starts -->
				<div class="btn-group pull-right" >
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-user"></i><span class="hidden-phone"> admin</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url().'beranda/detailuser/'.$this->session->userdata("user_id"); ?>">Profile</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo base_url().'beranda/passwd/'.$this->session->userdata("user_id"); ?>">Change Password</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo base_url().'login/logout/'; ?>">Logout</a></li>
					</ul>
				</div>
				<!-- user dropdown ends -->
				
				<div class="btn-group pull-right" id="license"></div>
			</div>
		</div>
	</div>
	<!-- topbar ends -->
