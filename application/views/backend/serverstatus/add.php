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
						<form class="form-horizontal" id="filter">
							<fieldset>
								
							<div class="form-actions">
								<a href="javascript:void(null);" id="serverstatus" class="btn btn-primary">Start</a>
							</div>	
								
							</fieldset>
						</form>
					</div>
				</div>
</div>

<div class="row-fluid sortable">
					
				<div class="box span12">
					<div class="box-header well">
						<h2><i class="icon-list-alt"></i> <? echo $subtitle; ?></h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<div id="live" class="center" style="min-width: 400px; height: 400px; margin: 0 auto" ></div>
					</div>
				</div>
				
</div><!--/row-->
