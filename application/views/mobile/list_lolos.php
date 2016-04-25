<div data-role="collapsible-set" data-theme="c" data-content-theme="d">
			<div data-role="collapsible">
				<h3>Sarjana</h3>
				<p><?php
					if($sql2->num_rows() > 0){
					?>
					<div class="ui-grid-c ui-shadow ui-responsive">
                    <div align="center" class="ui-block-a">
						<div class="ui-bar ui-bar-b">
						Posisi
						</div>
                    </div>
                    <div class="ui-block-b">
						<div class="ui-bar ui-bar-b">
						Jumlah Peserta
						</div>
                    </div>
                    <div class="ui-block-c">
						<div class="ui-bar ui-bar-b">
						Tahap Tes
						</div>
                    </div>
                    <div class="ui-block-d">
						<div class="ui-bar ui-bar-b">
						Lihat Detail
						</div>
                    </div>
                </div>
				
                            <?
                                foreach ($sql2->result() as $row) {
                                    ?>
                                    <div class="ui-grid-c ui-shadow ui-body-d ui-responsive">
										<div align="center" class="ui-block-a">
											<a href="<?php echo base_url().'home/detail_lolos/'.$row->thp_id.'/'.$row->flags.'/'.$row->jobs_id; ?>" data-inline="true" data-rel="dialog" data-transition="pop"><?php echo $row->jobs_name; ?></a> 
										</div>
										<div class="ui-block-b">
											<div class="ui-bar">
											<? echo $row->jml; ?>
											</div>
                                        </div>
										<div class="ui-block-c">
											<div class="ui-bar">
											<?php echo $row->tahapan; ?>
											</div>
										</div>
										<div class="ui-block-d">
											<div class="ui-bar">
											<a href="<?php echo base_url().'home/detail_lolos/'.$row->thp_id.'/'.$row->flags.'/'.$row->jobs_id; ?>" data-inline="true" data-rel="dialog" data-transition="pop">Lihat Detail</a> 
											</div>
										</div>
									</div>
									<?php }
									}
									?>
				</p>
			</div>
			<div data-role="collapsible">
				<h3>Diploma</h3>
				<p><?php
					if($sql1->num_rows() > 0){
					?>
					<div class="ui-grid-c ui-shadow ui-responsive">
                    <div align="center" class="ui-block-a">
						<div class="ui-bar ui-bar-b">
						Posisi
						</div>
                    </div>
                    <div class="ui-block-b">
						<div class="ui-bar ui-bar-b">
						Jumlah Peserta
						</div>
                    </div>
                    <div class="ui-block-c">
						<div class="ui-bar ui-bar-b">
						Tahap Tes
						</div>
                    </div>
                    <div class="ui-block-d">
						<div class="ui-bar ui-bar-b">
						Lihat Detail
						</div>
                    </div>
                </div>
				
                            <?
                                foreach ($sql1->result() as $row) {
                                    ?>
                                    <div class="ui-grid-c ui-shadow ui-body-d ui-responsive">
										<div align="center" class="ui-block-a">
											<a href="<?php echo base_url().'home/detail_lolos/'.$row->thp_id.'/'.$row->flags.'/'.$row->jobs_id; ?>" data-inline="true" data-rel="dialog" data-transition="pop"><?php echo $row->jobs_name; ?></a> 
										</div>
										<div class="ui-block-b">
											<div class="ui-bar">
											<? echo $row->jml; ?>
											</div>
                                        </div>
										<div class="ui-block-c">
											<div class="ui-bar">
											<?php echo $row->tahapan; ?>
											</div>
										</div>
										<div class="ui-block-d">
											<div class="ui-bar">
											<a href="<?php echo base_url().'home/detail_lolos/'.$row->thp_id.'/'.$row->flags.'/'.$row->jobs_id; ?>" data-inline="true" data-rel="dialog" data-transition="pop">Lihat Detail</a> 
											</div>
										</div>
									</div>
									<?php }
									}
									?>
				</p>
			</div>
			<div data-role="collapsible">
				<h3>Berpengalaman</h3>
				<p><?php
					if($sql3->num_rows() > 0){
					?>
					<div class="ui-grid-c ui-shadow ui-responsive">
                    <div align="center" class="ui-block-a">
						<div class="ui-bar ui-bar-b">
						Posisi
						</div>
                    </div>
                    <div class="ui-block-b">
						<div class="ui-bar ui-bar-b">
						Jumlah Peserta
						</div>
                    </div>
                    <div class="ui-block-c">
						<div class="ui-bar ui-bar-b">
						Tahap Tes
						</div>
                    </div>
                    <div class="ui-block-d">
						<div class="ui-bar ui-bar-b">
						Lihat Detail
						</div>
                    </div>
                </div>
				
                            <?
                                foreach ($sql3->result() as $row) {
                                    ?>
                                    <div class="ui-grid-c ui-shadow ui-body-d ui-responsive">
										<div align="center" class="ui-block-a">
											<a href="<?php echo base_url().'home/detail_lolos/'.$row->thp_id.'/'.$row->flags.'/'.$row->jobs_id; ?>" data-inline="true" data-rel="dialog" data-transition="pop"><?php echo $row->jobs_name; ?></a> 
										</div>
										<div class="ui-block-b">
											<div class="ui-bar">
											<? echo $row->jml; ?>
											</div>
                                        </div>
										<div class="ui-block-c">
											<div class="ui-bar">
											<?php echo $row->tahapan; ?>
											</div>
										</div>
										<div class="ui-block-d">
											<div class="ui-bar">
											<a href="<?php echo base_url().'home/detail_lolos/'.$row->thp_id.'/'.$row->flags.'/'.$row->jobs_id; ?>" data-inline="true" data-rel="dialog" data-transition="pop">Lihat Detail</a> 
											</div>
										</div>
									</div>
									<?php }
									}
									?>
				</p>
			</div>
</div>
