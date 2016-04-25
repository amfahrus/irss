<div>
				<ul class="breadcrumb">
					<li>
						<a href="<?php echo base_url() . 'users'; ?>"><? echo $modul; ?></a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#"><? echo $title; ?></a>
					</li>
				</ul>
			</div>
			
<div class="row-fluid">
				<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-info-sign"></i><? echo $title; ?></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						 <?
                            if ($sql->num_rows() > 0) {
                                foreach ($sql->result() as $row) {
                                    ?>
                        <table border="0">
                            <tr><td>Username </td><td> : </td><td> <? echo $row->username; ?></td></tr>
                            <tr><td>Nama </td><td> : </td><td> <? echo $row->nama; ?></td></tr>
                            <tr><td>Keterangan </td><td> : </td><td> <? echo $row->keterangan; ?></td></tr>
                            <tr><td>Group </td><td> : </td><td> <? echo $row->group_name; ?></td></tr>
                        </table>
                        <?
                                }
                            }
                        ?>
                        <div class="clearfix"></div>
					</div>
				</div>
			</div>
