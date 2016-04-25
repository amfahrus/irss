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
						Tanggal Posting
						</div>
                    </div>
                    <div class="ui-block-c">
						<div class="ui-bar ui-bar-b">
						Batas Waktu
						</div>
                    </div>
                    <div class="ui-block-d">
						<div class="ui-bar ui-bar-b">
						Jumlah Pelamar
						</div>
                    </div>
                </div>
				
                            <?
                                foreach ($sql2->result() as $row) {
                                    ?>
                                    <div class="ui-grid-c ui-shadow ui-body-d ui-responsive">
										<div align="center" class="ui-block-a">
											<a href="<?php echo base_url().'home/detail/'.$row->jobs_id; ?>" data-inline="true" data-rel="dialog" data-transition="pop"><?php echo $row->jobs_name; ?></a> 
										</div>
										<div class="ui-block-b">
											<div class="ui-bar">
											<? echo $this->dokumen_lib->simple($row->create_time); ?>
											</div>
                                        </div>
										<div class="ui-block-c">
											<div class="ui-bar">
											<?php echo $this->dokumen_lib->simple($row->due_time); ?>
											</div>
										</div>
										<div class="ui-block-d">
											<div class="ui-bar">
											<? echo $row->sumappl; ?>
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
						Tanggal Posting
						</div>
                    </div>
                    <div class="ui-block-c">
						<div class="ui-bar ui-bar-b">
						Batas Waktu
						</div>
                    </div>
                    <div class="ui-block-d">
						<div class="ui-bar ui-bar-b">
						Jumlah Pelamar
						</div>
                    </div>
                </div>
				
                            <?
                                foreach ($sql1->result() as $row) {
                                    ?>
                                    <div class="ui-grid-c ui-shadow ui-body-d ui-responsive">
										<div align="center" class="ui-block-a">
											<a href="<?php echo base_url().'home/detail/'.$row->jobs_id; ?>" data-inline="true" data-rel="dialog" data-transition="pop"><?php echo $row->jobs_name; ?></a>
										</div>
										<div class="ui-block-b">
											<div class="ui-bar">
											<? echo $this->dokumen_lib->simple($row->create_time); ?>
											</div>
                                        </div>
										<div class="ui-block-c">
											<div class="ui-bar">
											<?php echo $this->dokumen_lib->simple($row->due_time); ?>
											</div>
										</div>
										<div class="ui-block-d">
											<div class="ui-bar">
											<? echo $row->sumappl; ?>
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
						Tanggal Posting
						</div>
                    </div>
                    <div class="ui-block-c">
						<div class="ui-bar ui-bar-b">
						Batas Waktu
						</div>
                    </div>
                    <div class="ui-block-d">
						<div class="ui-bar ui-bar-b">
						Jumlah Pelamar
						</div>
                    </div>
                </div>
				
                            <?
                                foreach ($sql3->result() as $row) {
                                    ?>
                                    <div class="ui-grid-c ui-shadow ui-body-d ui-responsive">
										<div align="center" class="ui-block-a">
											<a href="<?php echo base_url().'home/detail/'.$row->jobs_id; ?>" data-inline="true" data-rel="dialog" data-transition="pop"><?php echo $row->jobs_name; ?></a>
										</div>
										<div class="ui-block-b">
											<div class="ui-bar">
											<? echo $this->dokumen_lib->simple($row->create_time); ?>
											</div>
                                        </div>
										<div class="ui-block-c">
											<div class="ui-bar">
											<?php echo $this->dokumen_lib->simple($row->due_time); ?>
											</div>
										</div>
										<div class="ui-block-d">
											<div class="ui-bar">
											<? echo $row->sumappl; ?>
											</div>
										</div>
									</div>
									<?php }
									}
									?>
				</p>
			</div>
</div>
