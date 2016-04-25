<div>
				<ul class="breadcrumb">
					<li>
						<a href="<?php echo base_url(); ?>">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="<?php echo base_url(); ?>beranda">Dashboard</a>
					</li>
				</ul>
			</div>
<?php if($isPending){ ?>
<div class="sortable row-fluid">
				<a data-rel="tooltip" title="<?php echo $isPending; ?> pending account." class="well span3 top-block" href="<?php echo base_url().'account_pending'; ?>">
					<span class="icon32 icon-red icon-star-on"></span>
					<div>Pending Account</div>
					<div><?php echo $isPending; ?></div>
					<span class="notification">6</span>
				</a>
</div>
<?php } ?>			
<div class="row-fluid">
				<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-info-sign"></i> Welcome</h2>
					</div>
					<div class="box-content">
						<table border="0">
                                <tr><td>Username </td><td> : </td><td> <? echo $this->session->userdata("username"); ?></td></tr>
                                <tr><td>Nama </td><td> : </td><td> <? echo $this->session->userdata("nama"); ?></td></tr>
                                <tr><td>Keterangan </td><td> : </td><td> <? echo $this->session->userdata("keterangan"); ?></td></tr>
                                <tr><td>Hak Akses </td><td> : </td><td> <? echo $this->session->userdata("group_name"); ?></td></tr>
                                <tr><td>OS </td><td> : </td><td> <? echo $_SERVER["HTTP_USER_AGENT"]; ?></td></tr>
                            </table>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
