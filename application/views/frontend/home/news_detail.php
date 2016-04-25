<div class="container">
      <div class="row row-offcanvas row-offcanvas-right">
		  
		<div class="col-md-12">
			
        <div class="col-md-8">
		  
		  <?php
			echo $panel;
		  ?>
		  
		  <?php
				if($news_detail->num_rows() > 0){
					$preview = $news_detail->row_array();
			?>		  
			<div class="panel panel-default toprint">
			  <div class="panel-heading">
				<h4><span class="glyphicon glyphicon-th-large"></span> <?php echo $preview['news_name']; ?>
				<div class="pull-right">
				<?php echo $this->dokumen_lib->simple2($preview['news_post_date']); ?>
				</div>	
				</h4>
			  </div>
			  <div class="panel-body">	
				<table class="table table-responsive table-hover">
					<tr>
						<td colspan="2">
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
		    </div>
			<?php
			}
			?>
		</div>
		
		<div class="col-md-4">
        
		  <div class="panel panel-default">
			<div class="panel-heading">
				Career Center
			</div>
			<div class="panel-body">
				<p>Bila anda ingin mengetahui lebih banyak tentang IRSS, memiliki perhatian yang tinggi terhadap kualitas sumber daya manusia.
				Di samping itu, penghargaan yang tinggi juga diberikan oleh perusahaan kepada setiap individu yang mampu menghadapi tantangan dan berprestasi
				dalam bidang masing-masing. Oleh karena itu, kami mengundang Anda yang memiliki kemampuan lebih untuk bergabung bersama kami.</p>
			</div>
		  </div>
		  <?php 
			if($count->num_rows() > 0){	
		  ?> 
		  <div class="panel panel-default">
			<div class="panel-heading">
				<?php echo lang('companies'); ?>
			</div>
			<div class="panel-body">
			<?php 
				foreach($count->result_array() as $rows){	
			?>
				<a title="<?php echo $rows['total']; ?> opening jobs." class="well top-block" href="<?php echo base_url().'home/company/'.$rows['company_id'].'/'.url_title($rows['company_name']); ?>">
					<img src="<?php echo $rows['company_logo']; ?>" width="50px" height="50px">
					<div><?php echo $rows['company_name']; ?></div>
					<span class="notification red"><?php echo $rows['total']; ?></span>
				</a>
			<?php 
				}
			?>
			</div>
			<?php
			}
			?>
		  </div>
		
        </div>
       
    </div>
        

</div><!-- /.container -->
