<div>
	<ul class="breadcrumb">
		<li>
			<a href="<?php echo base_url() . 'menus'; ?>"><? echo $modul; ?></a> <span class="divider">/</span>
		</li>
		<li>
			<a href="#"><? echo $title; ?></a>
		</li>
	</ul>
</div>

<a class="btn btn-primary" href="<?php echo base_url() . $link_add; ?>">
							<i class="icon-list icon-white"></i>  
								Add Menu                                          
						</a>
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-list"></i><? echo $title; ?></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
							<thead>
							  <tr>
								  <th>Label</th>
								  <th>Link</th>
								  <th>Urutan</th>
								  <th>Visible</th>
								  <th>Parent</th>
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
                                            <? echo $row->label; ?>
                                        </td>
                                        <td class='center'>
                                            <? echo $row->link; ?>
                                        </td>
										<td class='center'>
                                            <? echo $row->urutan; ?>
                                        </td>
										<td class='center'>
                                            <center><? echo $row->visible == 1 ? '<img src="'.base_url().'images/checkbox_checked.png" >' : '<img src="'.base_url().'images/checkbox_unchecked.png" >'; ?></center>
                                        </td>
										<td class='center'>
                                            <? echo $row->nama_parent; ?>
                                        </td>
                                        <td class="center">
											<a class="btn btn-info" href="<?php echo base_url() . $link_edit . $row->menu_id; ?>">
												<i class="icon-edit icon-white"></i>  
												Edit                                            
											</a>
											<a class="btn btn-danger" href="<?php echo base_url() . $link_delete . $row->menu_id; ?>">
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
