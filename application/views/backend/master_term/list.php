			<div>
				<ul class="breadcrumb">
					<li>
						<a href="<?php echo $home; ?>"><? echo $modul; ?></a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#"><? echo $subtitle; ?></a>
					</li>
				</ul>
			</div>
			
			<a class="btn btn-primary" href="<?php echo base_url() . $link_add; ?>">
							<i class="icon-file icon-white"></i>  
								Add                                   
						</a>
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-file"></i><? echo $subtitle; ?></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
							<thead>
							  <tr>
								  <th>Name</th>
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
                                            <? echo $row->term_name; ?>
                                        </td>
                                        <td class="center">
											<a class="btn btn-info" href="<?php echo base_url() . $link_edit . $row->term_id; ?>">
												<i class="icon-edit icon-white"></i>  
												Edit                                            
											</a>
											<a class="btn btn-danger" href="<?php echo base_url() . $link_delete . $row->term_id; ?>" onclick="return confirm(\'Yakin dihapus?\')">
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
