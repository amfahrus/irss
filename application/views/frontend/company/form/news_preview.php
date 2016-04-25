<div class="container">
    <div class="row row-offcanvas row-offcanvas-right">
	<?php
		if($news->num_rows() > 0){
			$preview = $news->row_array();
	?>		  
	<div class="panel panel-default">
	  <div class="panel-heading">
        <h4><span class="glyphicon glyphicon-th-large"></span> <?php echo lang('news'); ?>
        <div class="pull-right">
				<a href="<?php echo base_url().'company/edit_news/'.$preview['news_id']; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-edit"></span> Edit</a>
				<a href="<?php echo base_url().'company/news'; ?>" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> <?php echo lang('done'); ?></a>
		</div>
		</h4>
      </div>
      <div class="panel-body">	
		<table class="table table-responsive table-hover">
			<tr>
				<td colspan="2">
					 <p><h4><?php echo $preview['news_name']; ?></h4></p>
					 <p><?php echo $preview['news_desc']; ?></p>
				</td>
			</tr>
			<?php if(!empty($preview['news_file'])){ ?>
			<tr>
				<td colspan="2"><h2><center><a href="<?php echo $preview['news_file']; ?>" target="_blank">Download File</a></center></h2></td>
			</tr>
			<?php } ?>
		</table>
      </div>
      <div class="panel-footer">
			<h4><span class="glyphicon glyphicon-th-large"></span> <?php echo lang('news'); ?>
			<div class="pull-right">
				<a href="<?php echo base_url().'company/edit_news/'.$preview['news_id']; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-edit"></span> Edit</a>
				<a href="<?php echo base_url().'company/news'; ?>" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> <?php echo lang('done'); ?></a>
			</div>
			</h4>
	 </div>
    </div>
    
	<?php 
		}
	?>   
    </div>
</div><!-- /.container -->
