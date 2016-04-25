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
			
			<a class="btn btn-primary" href="<?php echo base_url() . $link_add; ?>">
							<i class="icon-user icon-white"></i>  
								Add User                                          
						</a>
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i><? echo $title; ?></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
							<thead>
							  <tr>
								  <th>Username</th>
								  <th>Nama</th>
								  <th>Keterangan</th>
								  <th>Group</th>
								  <th>Actions</th>
							  </tr>
							</thead>   
							<tbody>
                            <?
                            if ($sql->num_rows() > 0) {
                                foreach ($sql->result() as $row) {
                                    ?>
									<tr>
										<td class='center'>
                                            <? echo $row->username; ?>
                                        </td>
                                        <td class='center'>
                                            <? echo $row->nama; ?>
                                        </td>
                                        <td class='center'>
                                            <? echo $row->keterangan; ?>
                                        </td>
                                        <td class='center'>
                                            <? echo $row->group_name; ?>
                                        </td>
                                        <td class="center">
											<a class="btn btn-success" href="<?php echo base_url() . $link_detail . $row->user_id; ?>">
												<i class="icon-zoom-in icon-white"></i>  
												View                                            
											</a>
											<a class="btn btn-info" href="<?php echo base_url() . $link_edit . $row->user_id; ?>">
												<i class="icon-edit icon-white"></i>  
												Edit                                            
											</a>
											<a class="btn btn-danger" href="<?php echo base_url() . $link_delete . $row->user_id; ?>">
												<i class="icon-trash icon-white"></i> 
												Delete
											</a>
										</td>
									</tr>
									<?
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
             </div><!--/span-->
		</div><!--/row-->
