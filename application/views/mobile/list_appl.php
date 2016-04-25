<style type="text/css">
div.pagination {
	font-family:Verdana,Tahoma,Arial,Helvetica,Sans-Serif;
	font-size: 12px;
	text-align:center;
	padding:8px 10px 8px 0;
	background-color:#fff;
	color:#313031;
}

div.pagination a {
	color:#0030ce;
	text-decoration:none;
	padding:7px 8px 6px 7px;
	margin:0 7px 0 7px;
	border:1px solid #b7d8ee;
}

div.pagination a:hover, div.pagination a:active {
	color:#0066a7;
	border:3px solid #b7d8ee;
	background-color:#d2eaf6;
}
div.pagination span.current {
	padding:7px 8px 6px 7px;
	margin:0 9px 0 9px;
	border:1px solid #b7d8ee;
	font-weight:bold;
	color:#444444;
	background-color:#d2eaf6;
}
div.pagination span.disabled {
	//display:none;
	color:#fff;
}

</style>
<div data-role="content">
<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b"> 
			<li data-role="list-divider">Daftar Pelamar</li> 
			<li><div class="ui-grid-d ui-shadow ui-responsive">
                    <div align="center" class="ui-block-a">
						<div class="ui-bar ui-bar-b">
						Nama
						</div>
                    </div>
                    <div class="ui-block-b">
						<div class="ui-bar ui-bar-b">
						Jurusan
						</div>
                    </div>
                    <div class="ui-block-c">
						<div class="ui-bar ui-bar-b">
						Universitas
						</div>
                    </div>
                    <div class="ui-block-d">
						<div class="ui-bar ui-bar-b">
						Kota
						</div>
                    </div>
                    <div align="center" class="ui-block-e">
						<div class="ui-bar ui-bar-b">
						Posisi
						</div>
                    </div>
                </div>
				
                            <?
                            if ($pelamar->num_rows() > 0) {
                                foreach ($pelamar->result() as $row) {
                                    ?>
                                    <div class="ui-grid-d ui-shadow ui-body-d ui-responsive">
										<div align="center" class="ui-block-a">
											<div class="ui-bar" >
											<? echo $row->nama; ?> 
											</div>
										</div>
										<div class="ui-block-b">
											<div class="ui-bar">
											<? echo $row->jurusan; ?>
											</div>
                                        </div>
										<div class="ui-block-c">
											<div class="ui-bar">
											<? echo $row->universitas; ?>
											</div>
										</div>
										<div class="ui-block-d">
											<div class="ui-bar">
											<? echo $row->kota; ?>
											</div>
										</div>
										<div align="center" class="ui-block-e">
											<div class="ui-bar">
											<? echo $row->jobs_name; ?>
											</div>
                                       </div>
									</div>
									<?php }
									}
									?>
                                    <br>
					<div> <?php echo $this->pagination->create_links(); ?> </div></li>
			<li data-role="list-divider"></li>
	</ul>              
					
</div>
