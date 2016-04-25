<div data-role="navbar" data-theme="b">
		<ul>
			<li><a href="<?php echo base_url(); ?>" data-role="button" data-theme="b" data-icon="home">Beranda</a></li>
			<li><a href="<?php echo base_url() . 'beranda/email/' . $this->session->userdata("user_id");; ?>" data-role="button" data-theme="b" data-icon="info">Email</a></li>
			<li><a href="<?php echo base_url() . 'beranda/passwd/' . $this->session->userdata("user_id");; ?>" data-role="button" data-theme="b" data-icon="gear">Password</a></li>
			<li><a href="<?php echo base_url(); ?>login/logout" data-role="button" data-ajax="false" data-theme="b" data-icon="delete">Log Out</a></li>
		</ul>
</div>
