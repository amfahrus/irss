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

<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i><? echo $subtitle; ?></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form class="form-horizontal" action="" method="POST" id="filter">
							<fieldset>
							
							<div class="control-group">
							  <label class="control-label" for="grafik">Tipe Grafik</label>
							  <div class="controls">
								<select name="tipe" id="tipe_chart">
								<option value="line">Line</option>
								<option value="pie">Pie</option>
								</select>
							  </div>
							</div>
							
							<div class="control-group">
							  <label class="control-label" for="date00">Tahun</label>
							  <div class="controls">
								<select name="tahun" id="tahun_chart">
								<option value="0">Pilih Tahun</option>
								<?php
								if ($thn->num_rows() > 0) {
									foreach ($thn->result_array() as $row) {
										echo '<option value="'.$row['years'].'">'.$row['years'].'</option>';
									}
								}
								?>
								</select>
							  </div>
							</div>
								
							</fieldset>
						</form>
					</div>
				</div><!--/span-->
</div><!--/row-->

<div class="row-fluid sortable">
					
				<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-list-alt"></i> Charts</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<div id="laporan"  class="center" style="min-width: 400px; height: 400px; margin: 0 auto" ></div>
					</div>
				</div>
				
</div><!--/row-->
